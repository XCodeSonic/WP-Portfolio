<?php
/**
 * Graceful Theme Welcome Admin Notice
 *
 * @package Graceful
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Graceful_Welcome_Notice' ) ) :

	/**
	 * Welcome notice recommending Graceful Extra companion plugin.
	 */
	class Graceful_Welcome_Notice {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'render_notice' ), 20 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			add_action( 'wp_ajax_graceful_dismiss_notice', array( $this, 'ajax_dismiss_notice' ) );
		}

		/**
		 * Enqueue admin scripts and styles for notice and 1-click install.
		 *
		 * @param string $hook Current admin page hook.
		 */
		public function enqueue_admin_assets( $hook ) {
			// Enqueue on all admin pages if notice is active, and always on the About Theme page.
			$is_about_page = ( 'appearance_page_about-theme' === $hook );
			$show_notice   = $this->should_show_notice();

			if ( ! $show_notice && ! $is_about_page ) {
				return;
			}

			wp_enqueue_style(
				'graceful-admin-notice-css',
				get_template_directory_uri() . '/inc/admin/css/about-theme.css',
				array(),
				wp_get_theme()->get( 'Version' )
			);

			wp_enqueue_script(
				'graceful-admin-js',
				get_template_directory_uri() . '/inc/admin/js/graceful-admin.js',
				array( 'jquery', 'updates' ),
				wp_get_theme()->get( 'Version' ),
				true
			);

			wp_localize_script(
				'graceful-admin-js',
				'gracefulAdminL10n',
				array(
					'nonce' => wp_create_nonce( 'graceful_notice_dismiss' ),
				)
			);
		}

		/**
		 * Check whether the welcome notice should be displayed.
		 *
		 * @return bool
		 */
		public function should_show_notice() {
			global $pagenow;

			// Don't show if user cannot manage plugins.
			if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
				return false;
			}

			// Don't show if dismissed.
			if ( (bool) get_option( 'graceful_notice_dismissed', false ) ) {
				return false;
			}

			// Don't show if Graceful Extra is already active.
			if ( function_exists( 'graceful_extra_is_activated' ) && graceful_extra_is_activated() ) {
				return false;
			}

			// Only show on Dashboard (index.php) and Appearance/Themes (themes.php).
			if ( ! in_array( $pagenow, array( 'index.php', 'themes.php' ), true ) ) {
				return false;
			}

			// Don't show inside the About Theme page itself to avoid duplication.
			if ( 'themes.php' === $pagenow && isset( $_GET['page'] ) && 'about-theme' === $_GET['page'] ) {
				return false;
			}

			return true;
		}

		/**
		 * Render the welcome admin notice.
		 */
		public function render_notice() {
			if ( ! $this->should_show_notice() ) {
				return;
			}

			$theme      = wp_get_theme();
			$theme_name = $theme->get( 'Name' );

			// Check for child theme banner/screenshot first, then parent fallback.
			if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/assets/img/' . strtolower( str_replace( ' ', '-', $theme_name ) ) . '-banner.png' ) ) {
				$banner_url = get_stylesheet_directory_uri() . '/assets/img/' . strtolower( str_replace( ' ', '-', $theme_name ) ) . '-banner.png';
			} elseif ( is_child_theme() && file_exists( get_stylesheet_directory() . '/screenshot.png' ) ) {
				$banner_url = get_stylesheet_directory_uri() . '/screenshot.png';
			} elseif ( file_exists( get_template_directory() . '/assets/img/graceful-banner.png' ) ) {
				$banner_url = get_template_directory_uri() . '/assets/img/graceful-banner.png';
			} else {
				$banner_url = get_template_directory_uri() . '/screenshot.png';
			}
			?>
			<div class="notice notice-info graceful-notice graceful-notice-nux is-dismissible">
				<div class="graceful-notice-row">
					<div class="graceful-notice-col graceful-notice-col-left">
						<div class="graceful-notice-content">
							<h2>
								<?php
								/* translators: %s: Theme name */
								printf( esc_html__( 'Thank you for installing %s!', 'graceful' ), esc_html( $theme_name ) );
								?>
							</h2>
							<p class="graceful-notice-description">
								<?php
								echo wp_kses_post(
									sprintf(
										/* translators: %s: Plugin name */
										__( 'To take full advantage of all the features this theme has to offer, please install and activate the %s plugin.', 'graceful' ),
										'<strong>' . esc_html__( 'Graceful Extra', 'graceful' ) . '</strong>'
									)
								);
								?>
							</p>
							<div class="graceful-notice-actions">
								<?php
								Graceful_Plugin_Install::install_plugin_button(
									'graceful-extra',
									'graceful-extra.php',
									'Graceful Extra',
									array( 'sf-nux-button' )
								);
								?>
								<a href="<?php echo esc_url( admin_url( 'themes.php?page=about-theme' ) ); ?>" class="button button-primary button-hero graceful-hero-button">
									<?php
									/* translators: %s: Theme name */
									printf( esc_html__( 'Get started with %s', 'graceful' ), esc_html( $theme_name ) );
									?>
								</a>
							</div>
						</div>
					</div>
					<div class="graceful-notice-col graceful-notice-col-right">
						<div class="graceful-notice-image image-container">
							<img src="<?php echo esc_url( $banner_url ); ?>" alt="<?php echo esc_attr( $theme_name ); ?>" />
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Handle AJAX dismissal of notice.
		 */
		public function ajax_dismiss_notice() {
			check_ajax_referer( 'graceful_notice_dismiss', 'nonce' );

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_send_json_error( 'Permission denied.' );
			}

			update_option( 'graceful_notice_dismissed', 1 );
			wp_send_json_success();
		}
	}

endif;

return new Graceful_Welcome_Notice();
