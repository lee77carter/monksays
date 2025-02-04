<?php
/**
 * Simple Blog Card
 *
 * @package    Simple Blog Card
 * @subpackage SimpleBlogCardAdmin Management screen
	Copyright (c) 2019- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$simpleblogcardadmin = new SimpleBlogCardAdmin();

/** ==================================================
 * Management screen
 */
class SimpleBlogCardAdmin {

	/** ==================================================
	 * Construct
	 *
	 * @since 1.00
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );

		add_action( 'rest_api_init', array( $this, 'register_rest' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 10, 1 );

		/* Original hook */
		add_action( 'simpleblogcard_delete_all_cache', array( $this, 'delete_all_cache' ) );
	}

	/** ==================================================
	 * Add a "Settings" link to the plugins page
	 *
	 * @param  array  $links  links array.
	 * @param  string $file   file.
	 * @return array  $links  links array.
	 * @since 1.00
	 */
	public function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty( $this_plugin ) ) {
			$this_plugin = 'simple-blog-card/simpleblogcard.php';
		}
		if ( $file === $this_plugin ) {
			$links[] = '<a href="' . admin_url( 'options-general.php?page=simpleblogcard' ) . '">' . __( 'Settings', 'simple-blog-card' ) . '</a>';
		}
			return $links;
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.00
	 */
	public function plugin_menu() {
		add_options_page(
			'Simple Blog Card Options',
			'Simple Blog Card',
			'manage_options',
			'simpleblogcard',
			array( $this, 'plugin_options' )
		);
	}

	/** ==================================================
	 * For only admin style
	 *
	 * @since 1.00
	 */
	private function is_my_plugin_screen() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'settings_page_simpleblogcard' === $screen->id ) {
			return true;
		} else {
			return false;
		}
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.00
	 */
	public function plugin_options() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'simple-blog-card' ) );
		}

		global $wp_version;
		$requires = '6.6';
		if ( version_compare( $wp_version, $requires, '>=' ) ) {
			$admin_screen = esc_html__( 'Loading…', 'simple-blog-card' );
		} else {
			/* translators: WordPress requires version */
			$admin_screen = sprintf( esc_html__( 'WordPress %s or higher is required to view this screen.', 'simple-blog-card' ), $requires );
		}
		printf( '<div class="wrap" id="simple-blog-card-settings">%s</div>', esc_html( $admin_screen ) );
	}

	/** ==================================================
	 * Load script
	 *
	 * @param string $hook_suffix  hook_suffix.
	 * @since 2.20
	 */
	public function admin_scripts( $hook_suffix ) {

		if ( 'settings_page_simpleblogcard' !== $hook_suffix ) {
			return;
		}

		$asset_file = plugin_dir_path( __DIR__ ) . 'guten/build/index.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_style(
			'simple_blog_card_settings_style',
			plugin_dir_url( __DIR__ ) . 'guten/build/index.css',
			array( 'wp-components' ),
			'1.0.0',
		);

		wp_enqueue_script(
			'simple_blog_card_settings_script',
			plugin_dir_url( __DIR__ ) . 'guten/build/index.js',
			$asset['dependencies'],
			$asset['version'],
			array(
				'in_footer' => true,
			)
		);

		$simpleblogcard = new SimpleBlogCard();

		$simpleblogcard_settings = $simpleblogcard->load_settings();

		$simpleblogcard_timeout = get_option( 'simpleblogcard_timeout', 10 );
		$simpleblogcard_template = get_option( 'simpleblogcard_template', 'default' );

		$templates = $simpleblogcard->load_templates();
		$template_label_value = array();
		$template_overviews = array();
		foreach ( $templates as $key => $value ) {
			foreach ( $value as $value2 ) {
				$template_label_value[] = array(
					'label' => __( $value2['name'], 'simple-blog-card' ),
					'value' => $value2['slug'],
				);
				$template_overviews[ $value2['slug'] ] = array(
					'description' => __( $value2['description'], 'simple-blog-card' ),
					'version' => $value2['version'],
					'author' => $value2['author'],
					'author_link' => $value2['author_link'],
				);
			}
		}

		/* To be added to Glotpress */
		$tmp = __( 'Default template', 'simple-blog-card' );
		$tmp = __( 'This is default card.', 'simple-blog-card' );
		$tmp = __( 'Grid Card template', 'simple-blog-card' );
		$tmp = __( 'This is a CSS grid layout style card.', 'simple-blog-card' );

		wp_localize_script(
			'simple_blog_card_settings_script',
			'simple_blog_card_settings_script_data',
			array(
				'options' => wp_json_encode( $simpleblogcard_settings, JSON_UNESCAPED_SLASHES ),
				'timeout' => $simpleblogcard_timeout,
				'template' => $simpleblogcard_template,
				'template_label_value' => wp_json_encode( $template_label_value, JSON_UNESCAPED_SLASHES ),
				'template_overviews' => wp_json_encode( $template_overviews, JSON_UNESCAPED_SLASHES ),
				'img_block_search' => plugin_dir_url( __DIR__ ) . 'assets/screenshot-4.png',
			)
		);

		wp_set_script_translations( 'simple_blog_card_settings_script', 'simple-blog-card' );

		$this->credit( 'simple_blog_card_settings_script' );
	}

	/** ==================================================
	 * Register Rest API
	 *
	 * @since 2.20
	 */
	public function register_rest() {

		register_rest_route(
			'rf/simpleblogcard_set_api',
			'/token',
			array(
				'methods' => 'POST',
				'callback' => array( $this, 'api_save' ),
				'permission_callback' => array( $this, 'rest_permission' ),
			),
		);
	}

	/** ==================================================
	 * Rest Permission
	 *
	 * @since 2.20
	 */
	public function rest_permission() {

		return current_user_can( 'manage_options' );
	}

	/** ==================================================
	 * Rest API save
	 *
	 * @param object $request  changed data.
	 * @since 2.20
	 */
	public function api_save( $request ) {

		$args = json_decode( $request->get_body(), true );

		$simpleblogcard_settings['url'] = null;
		$simpleblogcard_settings['title'] = null;
		$simpleblogcard_settings['description'] = null;

		$simpleblogcard_settings['dessize'] = intval( $args['dessize'] );
		$simpleblogcard_settings['imgsize'] = intval( $args['imgsize'] );
		$simpleblogcard_settings['img_pos'] = sanitize_text_field( wp_unslash( $args['img_pos'] ) );
		$simpleblogcard_settings['color'] = sanitize_text_field( wp_unslash( $args['color'] ) );
		$simpleblogcard_settings['color_width'] = intval( $args['color_width'] );
		$simpleblogcard_settings['t_line_height'] = intval( $args['t_line_height'] );
		$simpleblogcard_settings['d_line_height'] = intval( $args['d_line_height'] );
		$simpleblogcard_settings['target_blank'] = boolval( $args['target_blank'] );
		$simpleblogcard_settings['encoding'] = sanitize_text_field( wp_unslash( $args['encoding'] ) );
		$simpleblogcard_timeout = intval( $args['timeout'] );
		$simpleblogcard_template = sanitize_text_field( wp_unslash( $args['template'] ) );
		$cache_delete = boolval( $args['cache_delete'] );

		update_option( 'simpleblogcard_settings', $simpleblogcard_settings );
		update_option( 'simpleblogcard_timeout', $simpleblogcard_timeout );
		update_option( 'simpleblogcard_template', $simpleblogcard_template );

		if ( $cache_delete ) {
			 $this->delete_all_cache();
		}

		return new WP_REST_Response( $args, 200 );
	}

	/** ==================================================
	 * Delete all cache
	 *
	 * @since 1.06
	 */
	public function delete_all_cache() {

		global $wpdb;
		$search_transients = '%simple_blog_card_%';
		$del_transients = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT	option_name
				FROM	{$wpdb->prefix}options
				WHERE	option_name LIKE %s
				",
				$search_transients
			)
		);

		foreach ( $del_transients as $del_transient ) {
			$transient = str_replace( '_transient_', '', $del_transient->option_name );
			$value_del_cache = get_transient( $transient );
			if ( false <> $value_del_cache ) {
				delete_transient( $transient );
			}
		}
	}

	/** ==================================================
	 * Credit
	 *
	 * @param string $handle  handle.
	 * @since 2.20
	 */
	private function credit( $handle ) {

		$plugin_name    = null;
		$plugin_ver_num = null;
		$plugin_path    = plugin_dir_path( __DIR__ );
		$plugin_dir     = untrailingslashit( wp_normalize_path( $plugin_path ) );
		$slugs          = explode( '/', $plugin_dir );
		$slug           = end( $slugs );
		$files          = scandir( $plugin_dir );
		foreach ( $files as $file ) {
			if ( '.' === $file || '..' === $file || is_dir( $plugin_path . $file ) ) {
				continue;
			} else {
				$exts = explode( '.', $file );
				$ext  = strtolower( end( $exts ) );
				if ( 'php' === $ext ) {
					$plugin_datas = get_file_data(
						$plugin_path . $file,
						array(
							'name'    => 'Plugin Name',
							'version' => 'Version',
						)
					);
					if ( array_key_exists( 'name', $plugin_datas ) && ! empty( $plugin_datas['name'] ) && array_key_exists( 'version', $plugin_datas ) && ! empty( $plugin_datas['version'] ) ) {
						$plugin_name    = $plugin_datas['name'];
						$plugin_ver_num = $plugin_datas['version'];
						break;
					}
				}
			}
		}

		wp_localize_script(
			$handle,
			'credit',
			array(
				'links'          => __( 'Various links of this plugin', 'simple-blog-card' ),
				'plugin_version' => __( 'Version:', 'simple-blog-card' ) . ' ' . $plugin_ver_num,
				/* translators: FAQ Link & Slug */
				'faq'            => sprintf( __( 'https://wordpress.org/plugins/%s/faq', 'simple-blog-card' ), $slug ),
				'support'        => 'https://wordpress.org/support/plugin/' . $slug,
				'review'         => 'https://wordpress.org/support/view/plugin-reviews/' . $slug,
				'translate'      => 'https://translate.wordpress.org/projects/wp-plugins/' . $slug,
				/* translators: Plugin translation link */
				'translate_text' => sprintf( __( 'Translations for %s', 'simple-blog-card' ), $plugin_name ),
				'facebook'       => 'https://www.facebook.com/katsushikawamori/',
				'twitter'        => 'https://twitter.com/dodesyo312',
				'youtube'        => 'https://www.youtube.com/channel/UC5zTLeyROkvZm86OgNRcb_w',
				'donate'         => __( 'https://shop.riverforest-wp.info/donate/', 'simple-blog-card' ),
				'donate_text'    => __( 'Please make a donation if you like my work or would like to further the development of this plugin.', 'simple-blog-card' ),
				'donate_button'  => __( 'Donate to this plugin &#187;', 'simple-blog-card' ),
			)
		);
	}
}
