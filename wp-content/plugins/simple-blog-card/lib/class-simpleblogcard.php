<?php
/**
 * Simple Blog Card
 *
 * @package    Simple Blog Card
 * @subpackage SimpleBlogCard Main Functions
/*
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

$simpleblogcard = new SimpleBlogCard();

/** ==================================================
 * Main Functions
 */
class SimpleBlogCard {

	/** ==================================================
	 * Parsed Page Object
	 *
	 * @var $_values  _values[].
	 */
	private $_values;

	/** ==================================================
	 * Construct
	 *
	 * @since   1.00
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'simpleblogcard_block_init' ) );
		add_shortcode( 'simpleblogcard', array( $this, 'simpleblogcard_func' ) );
		add_action( 'enqueue_block_assets', array( $this, 'load_style' ) );
	}

	/** ==================================================
	 * Attribute block
	 *
	 * @since 1.00
	 */
	public function simpleblogcard_block_init() {

		$simpleblogcard_settings = $this->load_settings();

		register_block_type(
			plugin_dir_path( __DIR__ ) . 'block/build',
			array(
				'attributes'      => array(
					'url'         => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['url'],
					),
					'dessize' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['dessize'],
					),
					'imgsize' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['imgsize'],
					),
					'img_pos' => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['img_pos'],
					),
					'color'   => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['color'],
					),
					'color_width' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['color_width'],
					),
					'title'   => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['title'],
					),
					't_line_height' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['t_line_height'],
					),
					'description'  => array(
						'type'      => 'string',
						'default'   => $simpleblogcard_settings['description'],
					),
					'd_line_height' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['d_line_height'],
					),
					'target_blank' => array(
						'type'      => 'boolean',
						'default'   => $simpleblogcard_settings['target_blank'],
					),
					'encoding'  => array(
						'type'      => 'string',
						'default'   => $simpleblogcard_settings['encoding'],
					),
				),
				'render_callback' => array( $this, 'simpleblogcard_func' ),
				'title' => _x( 'Simple Blog Card', 'block title', 'simple-blog-card' ),
				'description' => _x( 'Get OGP and display blog card.', 'block description', 'simple-blog-card' ),
				'keywords' => array(
					_x( 'blogcard', 'block keyword', 'simple-blog-card' ),
					_x( 'card', 'block keyword', 'simple-blog-card' ),
					_x( 'external link', 'block keyword', 'simple-blog-card' ),
					_x( 'internal link', 'block keyword', 'simple-blog-card' ),
					_x( 'linkcard', 'block keyword', 'simple-blog-card' ),
				),
			)
		);

		$script_handle = generate_block_asset_handle( 'simple-blog-card/simpleblogcard-block', 'editorScript' );
		wp_set_script_translations( $script_handle, 'simple-blog-card' );
	}

	/** ==================================================
	 * Short code
	 *
	 * @param array  $atts  attributes.
	 * @param string $content  contents.
	 * @return string $content  contents.
	 * @since 1.00
	 */
	public function simpleblogcard_func( $atts, $content = null ) {

		$a = shortcode_atts(
			array(
				'url'     => '',
				'dessize' => '',
				'imgsize' => '',
				'img_pos' => '',
				'color'   => '',
				'color_width' => '',
				'title' => '',
				't_line_height' => '',
				'description' => '',
				'd_line_height' => '',
				'target_blank' => '',
				'encoding' => '',
			),
			$atts
		);

		$settings_tbl = get_option(
			'simpleblogcard_settings',
			array(
				'url' => null,
				'dessize' => 90,
				'imgsize' => 100,
				'img_pos' => 'right',
				'color' => '#7db4e6',
				'color_width' => 5,
				'title' => null,
				't_line_height' => 120,
				'description' => null,
				'd_line_height' => 120,
				'target_blank' => false,
				'encoding' => 'UTF-8',
			)
		);
		/* 'img_pos' from ver 2.01 */
		if ( ! array_key_exists( 'img_pos', $settings_tbl ) ) {
			$settings_tbl['img_pos'] = 'right';
		}

		foreach ( $settings_tbl as $key => $value ) {
			$shortcodekey = strtolower( $key );
			if ( 'dessize' === $key ||
					'imgsize' === $key ||
					'color_width' === $key ||
					't_line_height' === $key ||
					'd_line_height' === $key ) {
				if ( empty( $a[ $shortcodekey ] ) ) {
					if ( is_numeric( $a[ $shortcodekey ] ) ) {
						$a[ $shortcodekey ] = 0;
					} else {
						$a[ $shortcodekey ] = $value;
					}
				} elseif ( ! is_numeric( $a[ $shortcodekey ] ) ) {
					$a[ $shortcodekey ] = $value;
				}
			} elseif ( 'encoding' === $key ) {
				if ( empty( $a[ $shortcodekey ] ) ) {
					$a[ $shortcodekey ] = $value;
				} else {
					$encodings = array( 'UTF-8', 'ASCII', 'EUC-JP', 'SJIS', 'eucJP-win', 'SJIS-win', 'JIS', 'ISO-2022-JP' );
					if ( ! in_array( $a[ $shortcodekey ], $encodings ) ) {
						$a[ $shortcodekey ] = $value;
					}
				}
			} elseif ( 'target_blank' === $key ) {
				if ( empty( $a[ $shortcodekey ] ) ) {
					$a[ $shortcodekey ] = $value;
				} elseif ( 'false' === strtolower( $a[ $shortcodekey ] ) ) {
					$a[ $shortcodekey ] = false;
				}
			} elseif ( empty( $a[ $shortcodekey ] ) ) {
				$a[ $shortcodekey ] = $value;
			}
		}
		if ( 'right' === $a['img_pos'] ) {
			$a['border_pos'] = 'left';
		} else {
			$a['border_pos'] = 'right';
		}

		$this->get_access_url();

		return do_shortcode( $this->simpleblogcard( $a ) );
	}

	/** ==================================================
	 * Get access url
	 *
	 * @since 2.27
	 */
	private function get_access_url() {

		$post_id = get_the_ID();
		$post_ids = get_option( 'simpleblogcard_access_ids', array() );
		if ( ! in_array( $post_id, $post_ids ) ) {
			$post_ids[] = $post_id;
			update_option( 'simpleblogcard_access_ids', $post_ids );
		}
	}

	/** ==================================================
	 * Simple Blog Card
	 *
	 * @param array $settings  settings.
	 * @return string $content  contents.
	 * @since 1.00
	 */
	private function simpleblogcard( $settings ) {

		$contents = null;

		if ( $settings['url'] ) {
			$url = $settings['url'];
			$post_id = url_to_postid( $settings['url'] );
			$html = $this->check_status( $post_id, $url );
			if ( 'inside_nocard_contents' === $html ) {
				$contents .= '<div style="text-align: center;">';
				$contents .= '<div><strong><span class="dashicons dashicons-share-alt2" style="position: relative; top: 5px;"></span>Simple Blog Card</strong></div>';
				$contents .= esc_html__( 'This content is protected or in draft and cannot create a card.', 'simple-blog-card' );
				$contents .= '</div>';
				return $contents;
			}
			$inside_archive_contents = false;
			if ( 'inside_archive_contents' === $html ) {
				$inside_archive_contents = true;
			}
			if ( get_transient( 'simple_blog_card_' . esc_url( $url ) ) ) {
				/* Get cache */
				$call_site = get_transient( 'simple_blog_card_' . esc_url( $url ) );

				$title = $call_site['title'];
				$custom_title = $call_site['custom_title'];
				$description = $call_site['description'];
				$custom_description = $call_site['custom_description'];
				$dessize = $call_site['dessize'];
				$imgsize = $call_site['imgsize'];
				$img_url = $call_site['img_url'];
				$img = $call_site['img'];
				$img_width = $call_site['img_width'];
				$img_height = $call_site['img_height'];
				$encoding = $call_site['encoding'];
				if ( $imgsize <> $settings['imgsize'] || $dessize <> $settings['dessize'] ||
					$custom_title <> $settings['title'] || $custom_description <> $settings['description'] ||
					$encoding <> $settings['encoding'] ) {
					if ( 'outside' === $html || 'inside_archive_contents' === $html ) {
						$html = $this->get_contents_remote_get( $settings['url'], false );
					}
					list( $title, $description, $img, $img_url, $img_width, $img_height ) = $this->re_generate( $settings, $html, $post_id );
				}
			} else {
				if ( 'outside' === $html || 'inside_archive_contents' === $html ) {
					$html = $this->get_contents_remote_get( $settings['url'], false );
				}
				list( $title, $description, $img, $img_url, $img_width, $img_height ) = $this->re_generate( $settings, $html, $post_id );
			}
			$host = null;
			if ( 0 == $post_id && ! $inside_archive_contents ) {
				$host = wp_parse_url( $url, PHP_URL_HOST );
			}
			$hash = md5( $url . wp_date( 'YmdHis' ) );
			$img_pos = apply_filters( 'simple_blog_card_img_pos', $settings['img_pos'] );
			$border_pos = apply_filters( 'simple_blog_card_border_pos', $settings['border_pos'] );
			$color_width = apply_filters( 'simple_blog_card_color_width', $settings['color_width'] );
			$color = apply_filters( 'simple_blog_card_color', $settings['color'] );
			$t_line_height = apply_filters( 'simple_blog_card_t_line_height', $settings['t_line_height'] );
			$d_line_height = apply_filters( 'simple_blog_card_d_line_height', $settings['d_line_height'] );
			$target_blank = apply_filters( 'simple_blog_card_target_blank', $settings['target_blank'] );
			$img_width = apply_filters( 'simple_blog_card_img_width', $img_width );
			$img_height = apply_filters( 'simple_blog_card_img_height', $img_height );
			$dessize = apply_filters( 'simple_blog_card_dessize', $settings['dessize'] );

			list( $template_file_name, $css_file_name ) = $this->select_template( get_option( 'simpleblogcard_template', 'default' ) );

			$template_file = apply_filters( 'simple_blog_card_generate_template_file', plugin_dir_path( __DIR__ ) . 'template/' . $template_file_name );

			ob_start();
			include $template_file;
			$contents = ob_get_contents();
			ob_end_clean();
		} else {
			$contents .= '<div style="text-align: center;">';
			$contents .= '<div><strong><span class="dashicons dashicons-share-alt2" style="position: relative; top: 5px;"></span>Simple Blog Card</strong></div>';
			/* translators: Input URL */
			$contents .= esc_html( sprintf( __( 'Please input "%1$s".', 'simple-blog-card' ), 'URL' ) );
			$contents .= '</div>';
		}

		return $contents;
	}

	/** ==================================================
	 * Check status
	 *
	 * @param int    $post_id  post_id.
	 * @param string $url  url.
	 * @return string
	 * @since 1.32
	 */
	private function check_status( $post_id, $url ) {

		if ( 0 < $post_id ) {
			$post = get_post( $post_id );
			if ( 'publish' === $post->post_status ) {
				if ( ! empty( $post->post_password ) ) {
					return 'inside_nocard_contents';
				}
				return 'inside';
			} else {
				return 'inside_nocard_contents';
			}
		}
		if ( false !== strpos( $url, home_url() ) ) {
			return 'inside_archive_contents';
		}

		return 'outside';
	}

	/** ==================================================
	 * Re Generate
	 *
	 * @param array  $settings  settings.
	 * @param string $html  html.
	 * @param int    $post_id  post_id.
	 * @return array $title $description $img $img_url $img_width $img_height
	 * @since 1.04
	 */
	private function re_generate( $settings, $html, $post_id ) {

		$title = null;
		$description = null;
		$img_url = null;
		$img = false;
		$img_width = 0;
		$img_height = 0;
		$url = $settings['url'];
		if ( $html ) {
			if ( 'inside' === $html ) {
				$title = get_the_title( $post_id );
				$description = strip_shortcodes( get_post( $post_id )->post_content );
				$img_url = get_the_post_thumbnail_url( $post_id );
				if ( ! $img_url ) {
					if ( get_option( 'site_icon' ) ) {
						$siteicon_id = get_option( 'site_icon' );
						$img_url = wp_get_attachment_url( $siteicon_id );
					} else {
						$img_url = includes_url() . 'images/w-logo-blue.png';
					}
				}
			} else {
				if ( function_exists( 'mb_encode_numericentity' ) ) {
					$html = mb_encode_numericentity( $html, array( 0x80, 0x10ffff, 0, 0x1fffff ), $settings['encoding'] );
				}
				$page = $this->parse( $html );
				if ( ! empty( $page->_values ) ) {
					if ( array_key_exists( 'title', $page->_values ) ) {
						$title = $page->_values['title'];
					}
					if ( array_key_exists( 'description', $page->_values ) ) {
						$description = $page->_values['description'];
					}
					if ( array_key_exists( 'image', $page->_values ) ) {
						$img_url = $page->_values['image'];
					}
				}
			}

			if ( ! empty( $settings['title'] ) ) {
				$title = $settings['title'];
			}
			if ( ! empty( $settings['description'] ) ) {
				$description = $settings['description'];
			}

			$plus_str = null;
			if ( function_exists( 'mb_substr' ) ) {
				if ( $settings['dessize'] < mb_strlen( $description ) ) {
					$plus_str = '...';
				}
				$description = mb_substr( wp_strip_all_tags( $description, true ), 0, $settings['dessize'] ) . $plus_str;
			} else {
				if ( $settings['dessize'] < strlen( $description ) ) {
					$plus_str = '...';
				}
				$description = substr( wp_strip_all_tags( $description, true ), 0, $settings['dessize'] ) . $plus_str;
			}

			/* thumbnail */
			if ( $img_url && $settings['imgsize'] > 0 ) {
				$imagesize = @getimagesize( $img_url );
				if ( $imagesize ) {
					$img = true;
					$ratio = $imagesize[1] / $imagesize[0];
					$img_width = $settings['imgsize'];
					$img_height = intval( $settings['imgsize'] * $ratio );
				}
			}

			/* Set cache */
			$call_site = array(
				'title' => $title,
				'custom_title' => $settings['title'],
				'description' => $description,
				'custom_description' => $settings['description'],
				'dessize' => $settings['dessize'],
				'imgsize' => $settings['imgsize'],
				'img_url' => $img_url,
				'img' => $img,
				'img_width' => $img_width,
				'img_height' => $img_height,
				'encoding' => $settings['encoding'],
			);
			set_transient( 'simple_blog_card_' . esc_url( $url ), $call_site, 86400 * 14 );

		} else {
			if ( $settings['title'] ) {
				$title = $settings['title'];
			} else {
				$title = $settings['url'];
			}
			$description = $settings['description'];
		}

		return array( $title, $description, $img, $img_url, $img_width, $img_height );
	}

	/** ==================================================
	 * Get contents
	 *
	 * @param string $url  url.
	 * @param bool   $cli  WP-CLI.
	 * @return string $html  html.
	 * @since 1.37
	 */
	public static function get_contents_remote_get( $url, $cli ) {

		if ( is_admin() ) {
			$timeout = get_option( 'simpleblogcard_timeout', 10 );
		} else if ( $cli ) {
			$timeout = 30;
		} else {
			$timeout = 3;
		}

		$response = wp_remote_get(
			$url,
			array(
				'timeout' => $timeout,
				'redirection' => 0,
				'user-agent' => 'Simple Blog Card; ' . $url,
			),
		);
		if ( ( ! is_wp_error( $response ) ) && ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
			if ( false !== strpos( $response['headers']['content-type'], 'text/html' ) ) {
				if ( $cli ) {
					$message = sprintf( 'Simple Blog Card : %s : refresh.', $url );
					WP_CLI::success( $message );
				} else {
					return $response['body'];
				}
			} elseif ( $cli ) {
				$message = sprintf( 'Simple Blog Card : %s : not refresh.', $url );
				WP_CLI::error( $message );
			} else {
				return null;
			}
		}
	}

	/** ==================================================
	 * Parse
	 *
	 * @param string $html  html.
	 * @return object $page  page.
	 * @since 1.02
	 */
	private function parse( $html ) {

		$dom_document = new DOMDocument();
		libxml_use_internal_errors( true );
		$dom_document->loadHTML( $html );
		libxml_clear_errors();

		$tags = $dom_document->getElementsByTagName( 'meta' );
		if ( ! $tags || 0 === $tags->length ) {
			return false;
		}

		$page = new self();

		$non_og_description = null;

		foreach ( $tags as $tag ) {
			if ( $tag->hasAttribute( 'property' ) &&
				strpos( $tag->getAttribute( 'property' ), 'og:' ) === 0 ) {
				$key = strtr( substr( $tag->getAttribute( 'property' ), 3 ), '-', '_' );
				$page->_values[ $key ] = $tag->getAttribute( 'content' );
			}
			if ( $tag->hasAttribute( 'value' ) && $tag->hasAttribute( 'property' ) &&
				strpos( $tag->getAttribute( 'property' ), 'og:' ) === 0 ) {
				$key = strtr( substr( $tag->getAttribute( 'property' ), 3 ), '-', '_' );
				$page->_values[ $key ] = $tag->getAttribute( 'value' );
			}
			if ( $tag->hasAttribute( 'name' ) && $tag->getAttribute( 'name' ) === 'description' ) {
				$non_og_description = $tag->getAttribute( 'content' );
			}
		}

		$titles = $dom_document->getElementsByTagName( 'title' );
		if ( isset( $page->_values['title'] ) ) {
			if ( $titles->length > 0 ) {
				if ( strlen( $page->_values['title'] ) < $titles->item( 0 )->textContent ) {
					$page->_values['title'] = esc_html( $titles->item( 0 )->textContent );
				}
			}
		} elseif ( $titles->length > 0 ) {
			$page->_values['title'] = esc_html( $titles->item( 0 )->textContent );
		}

		if ( isset( $page->_values['description'] ) ) {
			if ( $non_og_description ) {
				if ( strlen( $page->_values['description'] ) < strlen( $non_og_description ) ) {
					$page->_values['description'] = esc_html( $non_og_description );
				}
			}
		} elseif ( $non_og_description ) {
			$page->_values['description'] = esc_html( $non_og_description );
		}

		if ( ! isset( $page->values['image'] ) ) {
			$domxpath = new DOMXPath( $dom_document );
			$elements = $domxpath->query( "//link[@rel='image_src']" );

			if ( $elements->length > 0 ) {
				$domattr = $elements->item( 0 )->attributes->getNamedItem( 'href' );
				if ( $domattr ) {
					$page->_values['image'] = $domattr->value;
					$page->_values['image_src'] = $domattr->value;
				}
			}
		}

		if ( empty( $page->_values ) ) {
			return false;
		}

		return $page;
	}

	/** ==================================================
	 * Load Style
	 *
	 * @since 1.15
	 */
	public function load_style() {

		list( $template_file_name, $css_file_name ) = $this->select_template( get_option( 'simpleblogcard_template', 'default' ) );

		$css_url = apply_filters( 'simple_blog_card_css_url', plugin_dir_url( __DIR__ ) . 'template/' . $css_file_name );
		wp_enqueue_style( 'simple-blog-card', $css_url, array(), '1.00' );
	}

	/** ==================================================
	 * Select Template & CSS
	 *
	 * @param string $slug  slug.
	 * @return array $template_file_name, $css_file_name  filename.
	 * @since 2.04
	 */
	private function select_template( $slug ) {

		$templates = $this->load_templates();

		$template_file_name = $templates['templates'][0]['files']['template'];
		$css_file_name = $templates['templates'][0]['files']['css'];
		foreach ( $templates as $key => $value ) {
			foreach ( $value as $value2 ) {
				if ( $slug === $value2['slug'] ) {
					if ( ! empty( $value2['files']['template'] ) ) {
						$template_file_name = $value2['files']['template'];
					}
					if ( ! empty( $value2['files']['css'] ) ) {
						$css_file_name = $value2['files']['css'];
					}
				}
			}
		}

		return array( $template_file_name, $css_file_name );
	}

	/** ==================================================
	 * Load Templates
	 *
	 * @return array $templates  templates.
	 * @since 2.04
	 */
	public function load_templates() {

		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
		$wp_filesystem = new WP_Filesystem_Direct( false );

		$json = $wp_filesystem->get_contents( plugin_dir_path( __DIR__ ) . 'template/templates.json' );
		$templates = json_decode( $json, true );

		return $templates;
	}

	/** ==================================================
	 * Load settings
	 *
	 * @return array $simpleblogcard_settings  settings.
	 * @since 2.20
	 */
	public function load_settings() {

		$simpleblogcard_settings = get_option(
			'simpleblogcard_settings',
			array(
				'url' => null,
				'dessize' => 90,
				'imgsize' => 100,
				'img_pos' => 'right',
				'color' => '#7db4e6',
				'color_width' => 5,
				'title' => null,
				't_line_height' => 120,
				'description' => null,
				'd_line_height' => 120,
				'target_blank' => false,
				'encoding' => 'UTF-8',
			)
		);
		/* 'target_blank' from ver 1.08 */
		if ( ! array_key_exists( 'target_blank', $simpleblogcard_settings ) ) {
			$simpleblogcard_settings['target_blank'] = false;
		}
		/* 'encoding' from ver 1.40 */
		if ( ! array_key_exists( 'encoding', $simpleblogcard_settings ) ) {
			$simpleblogcard_settings['encoding'] = 'UTF-8';
		}
		/* 'img_pos' from ver 2.01 */
		if ( ! array_key_exists( 'img_pos', $simpleblogcard_settings ) ) {
			$simpleblogcard_settings['img_pos'] = 'right';
		}

		return $simpleblogcard_settings;
	}
}
