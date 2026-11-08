=== Graceful Extra ===
Contributors: aslamnaik
Tags: graceful, reading time, post views, back to top
Requires at least: 5.6
Tested up to: 7.1
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Companion addon for Graceful theme. Adds reading time, post views, post display options, and a floating back-to-top button.

== Description ==

**Graceful Extra** is a companion plugin built specifically for the **Graceful** WordPress theme. It introduces powerful yet lightweight features without any external dependencies or framework bloat.

### Features
* **Reading Time Estimator**: Calculates reading time automatically and seamlessly displays it inside post header metadata with customizable WPM and suffix.
* **Post Views Counter**: Tracks single post views with crawler filtering and repeat-visit throttling (hourly cookie), displaying the count in the post header meta and WP Admin posts list.
* **Post & Page Display Options**: Individual post/page metabox settings allowing you to hide post/page titles or disable sidebars (force full width layout) on a per-post or per-page basis.
* **Customizable Floating Back-to-Top Button**: Smooth floating button with customizable shape, position (left or right), colors (background and icon), and mobile visibility controls.

== Installation ==

1. Upload the `graceful-extra` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure the **Graceful** theme is active.
4. Navigate to **Appearance -> Customize -> Graceful Extra Options** to configure your settings.

== Frequently Asked Questions ==

= Does this plugin require the Graceful theme? =
Yes, Graceful Extra is a dedicated companion addon built specifically for the Graceful WordPress theme.

= Where do I configure the settings? =
Go to Appearance -> Customize -> Graceful Extra Options to access all settings.

= What data is collected and does this plugin set cookies? =
When enabled, the Post Views Counter records only an aggregate numerical count locally in your WordPress database. It does not log IP addresses, browser fingerprints, or visitor identities, and sends no data to external servers. It sets a temporary cookie per viewed post (`graceful_extra_viewed_[post_id]`), lasting one hour solely to prevent repeat view increments from the same browsing session. The plugin does not collect any other personal data or set any other cookies.

== Upgrade Notice ==

= 1.0.0 =
Initial release for the Graceful theme.

== Changelog ==

= 1.0.0 =
* Initial release with Reading Time Estimator, Post Views Counter, Post/Page Display Metaboxes, and Customizable Floating Back-to-Top button.

