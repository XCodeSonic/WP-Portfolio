<?php
/**
 * Plugin Name: Graceful Extra
 * Description: Companion addon plugin for Graceful WordPress Theme. Adds reading time, post views, per-post display options, and a customizable back-to-top button.
 * Version: 1.0.0
 * Requires at least: 5.6
 * Requires PHP: 7.2
 * Author: Optima Themes
 * Author URI: https://optimathemes.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: graceful-extra
 * Domain Path: /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Constants.
define( 'GRACEFUL_EXTRA_VERSION', '1.0.0' );
define( 'GRACEFUL_EXTRA_PATH', plugin_dir_path( __FILE__ ) );
define( 'GRACEFUL_EXTRA_URL', plugin_dir_url( __FILE__ ) );
define( 'GRACEFUL_EXTRA_FILE', __FILE__ );

/**
 * Check if the Graceful theme (or a child theme) is currently active.
 *
 * @return bool
 */
function graceful_extra_is_theme_active() {
	$theme = wp_get_theme();
	return ( 'Graceful' === $theme->name || 'graceful' === $theme->template || 'graceful' === get_template() );
}

/**
 * Admin notice if Graceful theme is not active.
 */
function graceful_extra_inactive_theme_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-warning is-dismissible">
		<p>
			<?php
			printf(
				/* translators: 1: Plugin name, 2: Theme name */
				esc_html__( '%1$s requires the %2$s theme to be active in order to use its features.', 'graceful-extra' ),
				'<strong>' . esc_html__( 'Graceful Extra', 'graceful-extra' ) . '</strong>',
				'<strong><a href="' . esc_url( admin_url( 'themes.php' ) ) . '">' . esc_html__( 'Graceful', 'graceful-extra' ) . '</a></strong>'
			);
			?>
		</p>
	</div>
	<?php
}

/**
 * Bootstrap plugin features.
 */
function graceful_extra_init() {
	if ( ! graceful_extra_is_theme_active() ) {
		add_action( 'admin_notices', 'graceful_extra_inactive_theme_notice' );
		return;
	}

	// Customizer additions.
	require_once GRACEFUL_EXTRA_PATH . 'inc/customizer/customizer.php';

	// Post Metrics (Reading Time & Views).
	require_once GRACEFUL_EXTRA_PATH . 'inc/post-metrics/reading-time.php';
	require_once GRACEFUL_EXTRA_PATH . 'inc/post-metrics/view-counter.php';

	// Post/Page metaboxes.
	if ( is_admin() ) {
		require_once GRACEFUL_EXTRA_PATH . 'inc/admin/metabox.php';
	}

	// Frontend output, scripts and hooks.
	require_once GRACEFUL_EXTRA_PATH . 'inc/frontend/frontend.php';
}
add_action( 'after_setup_theme', 'graceful_extra_init' );

/**
 * Add settings action link to plugins page.
 *
 * @param array $links Array of plugin action links.
 * @return array
 */
function graceful_extra_action_links( $links ) {
	if ( graceful_extra_is_theme_active() ) {
		$customize_url = add_query_arg(
			array(
				'autofocus[panel]' => 'graceful_extra_panel',
				'return'           => urlencode( admin_url( 'plugins.php' ) ),
			),
			admin_url( 'customize.php' )
		);
		$settings_link = '<a href="' . esc_url( $customize_url ) . '">' . esc_html__( 'Customize Options', 'graceful-extra' ) . '</a>';
		array_unshift( $links, $settings_link );
	}
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'graceful_extra_action_links' );
