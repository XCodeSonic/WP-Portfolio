<?php
/**
 * Graceful Plugin Install Helper Class
 *
 * @package Graceful
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'graceful_extra_is_activated' ) ) {
	/**
	 * Check whether the Graceful Extra plugin is active.
	 *
	 * @return bool
	 */
	function graceful_extra_is_activated() {
		return defined( 'GRACEFUL_EXTRA_VERSION' );
	}
}

if ( ! class_exists( 'Graceful_Plugin_Install' ) ) :

	/**
	 * The Graceful plugin install helper class.
	 */
	class Graceful_Plugin_Install {

		/**
		 * Render an install / activate button for a plugin.
		 *
		 * @param string $plugin_slug Plugin directory slug.
		 * @param string $plugin_file Main plugin file name.
		 * @param string $plugin_name Human-readable plugin name.
		 * @param array  $classes     Additional CSS classes.
		 */
		public static function install_plugin_button( $plugin_slug, $plugin_file, $plugin_name, $classes = array(), $show_learn_more = false ) {
			if ( ! current_user_can( 'install_plugins' ) && ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugin_path  = $plugin_slug . '/' . $plugin_file;
			$activate_url = self::is_plugin_installed( $plugin_slug, $plugin_file );

			if ( is_plugin_active( $plugin_path ) || ( 'graceful-extra' === $plugin_slug && graceful_extra_is_activated() ) ) {
				// Plugin is active.
				$customize_url = admin_url( 'customize.php' );
				$btn_classes   = array_merge( array( 'button', 'button-secondary', 'disabled' ), $classes );
				?>
				<span class="sf-plugin-card plugin-card-<?php echo esc_attr( $plugin_slug ); ?>">
					<a href="<?php echo esc_url( $customize_url ); ?>" class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>" aria-disabled="true" style="pointer-events: none;">
						<?php esc_html_e( 'Activated', 'graceful' ); ?>
					</a>
				</span>
				<?php
			} elseif ( $activate_url ) {
				// Plugin is installed, but not active.
				$btn_classes = array_merge( array( 'button', 'button-primary', 'activate-now' ), $classes );
				?>
				<span class="sf-plugin-card plugin-card-<?php echo esc_attr( $plugin_slug ); ?>">
					<a href="<?php echo esc_url( $activate_url ); ?>" class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: Plugin name */ __( 'Activate %s', 'graceful' ), $plugin_name ) ); ?>">
						<?php esc_html_e( 'Activate', 'graceful' ); ?>
					</a>
				</span>
				<?php
			} else {
				// Plugin is not installed.
				$install_url = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							'plugin' => $plugin_slug,
						),
						self_admin_url( 'update.php' )
					),
					'install-plugin_' . $plugin_slug
				);

				$btn_classes = array_merge( array( 'button', 'button-primary', 'sf-install-now', 'install-now' ), $classes );
				?>
				<span class="sf-plugin-card plugin-card-<?php echo esc_attr( $plugin_slug ); ?>">
					<a href="<?php echo esc_url( $install_url ); ?>" class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>" data-slug="<?php echo esc_attr( $plugin_slug ); ?>" data-name="<?php echo esc_attr( $plugin_name ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: Plugin name */ __( 'Install %s now', 'graceful' ), $plugin_name ) ); ?>">
						<?php esc_html_e( 'Install', 'graceful' ); ?>
					</a>
				</span>
				<?php
			}

			if ( $show_learn_more ) {
				?>
				<a href="https://wordpress.org/plugins/<?php echo esc_attr( $plugin_slug ); ?>/" target="_blank" class="sf-learn-more"><?php esc_html_e( 'Learn more', 'graceful' ); ?></a>
				<?php
			}
		}

		/**
		 * Check if a plugin is installed and return its activation URL.
		 *
		 * @param string $plugin_slug Plugin directory slug.
		 * @param string $plugin_file Main plugin file name.
		 * @return string|false Activation URL or false.
		 */
		public static function is_plugin_installed( $plugin_slug, $plugin_file = '' ) {
			$plugin_path = $plugin_slug . '/' . ( $plugin_file ? $plugin_file : $plugin_slug . '.php' );

			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
				return wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'activate',
							'plugin' => $plugin_path,
						),
						admin_url( 'plugins.php' )
					),
					'activate-plugin_' . $plugin_path
				);
			}

			// Fallback: search directory for first php file.
			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
				if ( ! function_exists( 'get_plugins' ) ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}
				$plugins = get_plugins( '/' . $plugin_slug );
				if ( ! empty( $plugins ) ) {
					$keys        = array_keys( $plugins );
					$target_file = $plugin_slug . '/' . $keys[0];
					return wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'activate',
								'plugin' => $target_file,
							),
							admin_url( 'plugins.php' )
						),
						'activate-plugin_' . $target_file
					);
				}
			}

			return false;
		}
	}

endif;
