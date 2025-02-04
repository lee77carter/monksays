=== Simple Blog Card ===
Contributors: Katsushi Kawamori, ishitaka
Donate link: https://shop.riverforest-wp.info/donate/
Tags: block, blogcard, external link, internal link, linkcard
Requires at least: 6.6
Requires PHP: 8.0
Tested up to: 6.7
Stable tag: 2.33
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get OGP and display blog card.

== Description ==

= Blog card =
* Generated with shortcode
* Generated with block
* Can specify the number of characters displayed in the description.
* Displays an ogp image.
* Can specify the size of the displayed ogp image.
* Can change the title and description.

= Warning =
A redirect loop occurs when all three of the following factors are met:
* When two sites with different domains embed "Siｍple Blog Card" for each other on their top pages.
* When two sites with different domains are on the same server (same IP address).
* When the ”Simple Blog Card” caches of two sites on different domains are empty.

= How it works =
[youtube https://youtu.be/xTicX7DiGjU]

= Customize =
* Template files allow for flexible [customization](https://github.com/katsushi-kawamori/Simple-Blog-Card-Templates).
* The default template file is template/simpleblogcard-template.php. Using this as a reference, you can specify a separate template file using the filters below.
~~~
/** ==================================================
 * Filter for template file.
 *
 */
add_filter(
	'simple_blog_card_generate_template_file',
	function () {
		$wp_uploads = wp_upload_dir();
		$upload_dir = wp_normalize_path( $wp_uploads['basedir'] );
		$upload_dir = untrailingslashit( $upload_dir );
		return $upload_dir . '/tmp/simpleblogcard-template.php';
	},
	10,
	1
);
~~~

* CSS files can be set separately. Please see the filters below.
~~~
/** ==================================================
 * Filter for CSS file.
 *
 */
add_filter(
	'simple_blog_card_css_url',
	function () {
		$wp_uploads = wp_upload_dir();
		$upload_url = $wp_uploads['baseurl'];
		if ( is_ssl() ) {
			$upload_url = str_replace( 'http:', 'https:', $upload_url );
		}
		$upload_url = untrailingslashit( $upload_url );
		return $upload_url . '/tmp/simpleblogcard.css';
	},
	10,
	1
);
~~~

== Installation ==

1. Upload `simple-blog-card` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= WP-CLI =

Can delete and regenerate the cache with the following WP-CLI command. It would be beneficial to register it with the server's cron.
* `wp simpleblogcard_refresh`

== Frequently Asked Questions ==

none

== Screenshots ==

1. View
2. View2
3. Block
4. Block search
5. Settings

== Changelog ==

= [2.33] 2024/11/14 =
* Fix - Rebuilt javascript.

= [2.32] 2024/11/13 =
* Fix - Rebuilt javascript.
* Change - Changed the required version of WordPress.

= [2.31] 2024/06/15 =
* Fix - Issues with getting site information for WP-CLI.

= [2.30] 2024/06/10 =
* Fix - Issues with getting site information for WP-CLI.

= [2.29] 2024/06/07 =
* Added - Warning text to readme.txt.

= [2.28] 2024/06/01 =
* Fix - Issues with getting site information.
* Added - The user agent for retrieving site information was set to "Simple Blog Card; %url%".
* Fix - The number of redirects for site information getting was reduced from 5 to 0.

= [2.27] 2024/05/18 =
* Added - WP-CLI command to delete and regenerate caches.

= [2.26] 2024/04/29 =
* Fix - Processing when "Border color width" is 0.

= [2.25] 2024/04/27 =
* Fix - Initial value issue with shortcode attribute values.

= [2.24] 2024/04/21 =
* Fix - Translation.

= [2.23] 2024/04/21 =
* Fix - Translation.

= [2.22] 2024/04/21 =
* Tweak - About the template overview display.

= [2.21] 2024/04/10 =
* Fix - Block translation.

= [2.20] 2024/04/10 =
* Fix - Template.
* Fix - Block translation.
* Fix - Host name from output to blank in internal site archive.
* Change - The management screen was converted to React.

= [2.11] 2024/03/31 =
* Fix - Template.
* Added - Added filters to some of the configuration values used in the template.

= [2.10] 2024/03/31 =
* Fix - Individual hash values for each card are now passed as variables to the template.
* Fix - Template.
* Change - Place the CSS files in the same folder as the template files.
* Added - Added filters to some of the configuration values used in the template.

= [2.09] 2024/03/26 =
* Fix - Change in the way css are loaded.
* Fix - Template.

= [2.08] 2024/03/25 =
* Tweak - Added explanation of search terms for blocks to the admin screen.
* Fix - Template.

= [2.07] 2024/03/25 =
* Tweak - Added explanation of search terms for blocks to the admin screen.

= [2.06] 2024/03/25 =
* Tweak - Added explanation of search terms for blocks to the admin screen.

= [2.05] 2024/03/24 =
* Fix - Image size issue with default template.

= [2.04] 2024/03/24 =
* Added - Templates can be selected in the admin panel.
* Added - Add new template. Special thanks [ishitaka](https://profiles.wordpress.org/ishitaka/).

= [2.03] 2024/03/23 =
* Fix - Template internal linking issues.
* Added - Adding a description to the management screen.

= [2.02] 2024/03/23 =
* Fix - Display problem when 'Border color width' is 0.

= [2.01] 2024/03/23 =
* Removed - CSS saving in the admin panel has been removed.
* Added - Allowing the filter to load CSS from a separate file.
* Added - The image position can be changed to the left or right.
* Tweak - 'Border color width' can now be set to 0.
* Fix - Reviewed template files.

= [2.00] 2024/03/20 =
* Added - Customization by template files.

= [1.41] 2024/02/09 =
* Fix - Error that occurs when the title or description cannot be retrieved.

= [1.40] 2024/02/04 =
* Added - Added 'encoding' option. Can specify the character encoding of site.

= [1.39] 2024/01/19 =
* Fix - Deprecated error in php8.2. mb_convert_encoding => mb_encode_numericentity.
* Fix - Deprecated error in php8.2. Dynamic Property Issues.

= 1.38 =
Fixed an error that occurred when the URL was a file.

= 1.37 =
Site information retrieval was changed from cURL to wp_remote_get.

= 1.36 =
Rebuild blocks.

= 1.35 =
Rebuild blocks.

= 1.34 =
Rebuild blocks.

= 1.33 =
Supported WordPress 6.4.
PHP 8.0 is now required.

= 1.32 =
Fixed an issue where protected content could be retrieved with subscriber user. Thanks[Bob](https://wpscan.com/).

= 1.31 =
Fixed problem of XSS via shortcode. Thanks[Dmitrii Ignatyev](https://cleantalk.org/).

= 1.30 =
Fixed a ratio problem with portrait images.

= 1.29 =
Fixed problem with sites without description.

= 1.28 =
Fixed problem with sites without thumbnails.

= 1.27 =
Fixed the display of thumbnails in the same host.

= 1.26 =
Host names are now hidden within the same host.

= 1.25 =
Host name is now displayed.

= 1.24 =
Added escaping of html special characters.

= 1.23 =
Fixed a problem in which the site name was not displayed on some sites.
Fixed a problem with insufficient string retrieval at some sites.
The maximum length of the description in the settings has been changed to 300.

= 1.22 =
Fixed a translation issue.

= 1.21 =
WordPress 6.1 is now supported.

= 1.20 =
Fixed a problem with parameters.

= 1.19 =
Supported WordPress 6.0.

= 1.18 =
Fixed a problem with parameters.
Rebuilt the block.

= 1.17 =
Supported WordPress 5.7.

= 1.16 =
Added the ability to modify CSS in the admin panel.

= 1.15 =
Separated some style CSS for cards as files.

= 1.14 =
Added the ability to change the line height of the title, the line height of the description, and the width of the vertical line color.

= 1.13 =
Supported WordPress 5.6.

= 1.12 =
Added description of shortcode.

= 1.11 =
Fixed a translation issue.

= 1.10 =
The block now supports ESNext.

= 1.09 =
Fixed block loading error.

= 1.08 =
Supported open new tab.

= 1.07 =
Cache interval change.
Fixed problem of timeout.

= 1.06 =
Add cache removal option.
Add timeout change option.

= 1.05 =
Changing the timeout value.

= 1.04 =
Added cache function.

= 1.03 =
Added input place of URL.

= 1.02 =
Changed the parsing method.

= 1.01 =
Fixed OGP acquisition issue.

= 1.00 =
Initial release.

== Upgrade Notice ==

= 1.32 =
Security measures.

= 1.31 =
Security measures.

= 1.00 =

