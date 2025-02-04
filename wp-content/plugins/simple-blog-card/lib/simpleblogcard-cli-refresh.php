<?php
/**
 * Cli Name:    Simple Blog Card refresh
 * Description: Remove all cache and regenerate.
 * Version:     1.03
 * Author:      Katsushi Kawamori
 * Author URI:  https://riverforest-wp.info/
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package simpleblogcard_refresh
 */

/*
	Copyright (c) 2024- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

/** ==================================================
 * Simple Blog Card refresh command
 *
 * @since 1.00
 */
function simpleblogcard_refresh_command() {

	do_action( 'simpleblogcard_delete_all_cache' );

	$post_ids = get_option( 'simpleblogcard_access_ids', array() );
	$remove_ids = array();
	$urls = array();
	if ( ! empty( $post_ids ) ) {
		foreach ( $post_ids as $post_id ) {
			$post = get_post( $post_id );
			if ( ! is_null( $post ) ) {
				$contents = $post->post_content;
				if ( false !== strpos( $contents, '<!-- wp:simple-blog-card' ) ||
						false !== strpos( $contents, '[simpleblogcard ' ) ) {
					$urls[] = get_permalink( $post_id );
				} else {
					$remove_ids[] = $post_id;
				}
			} else {
				$remove_ids[] = $post_id;
			}
		}
	}

	if ( ! empty( $remove_ids ) ) {
		$result = array_diff( $post_ids, $remove_ids );
		$result = array_values( $result );
		update_option( 'simpleblogcard_access_ids', $result );
	}

	if ( ! empty( $urls ) ) {
		foreach ( $urls as $url ) {
			SimpleBlogCard::get_contents_remote_get( $url, true );
		}
	}
}
WP_CLI::add_command( 'simpleblogcard_refresh', 'simpleblogcard_refresh_command' );
