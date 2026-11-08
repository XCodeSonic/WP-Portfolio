<?php
/**
 * Customizer About Pro Panel
 *
 * @package Graceful
 */

	// Pro Version
	class Graceful_Pro extends WP_Customize_Control {
		public $type = 'pro_options';

		public function render_content() {
			echo '<span class="dashicons dashicons-info"></span>';
			echo '<span> Want more <strong>'. esc_html( $this->label ) .'</strong>?</span>';
			echo '<a class="graceful-pro-link" href="'. esc_url( $this->description ) .'" target="_blank">';
				echo '<strong><i> '. esc_html__( 'Check Graceful PRO version.', 'graceful' ) .'</i><strong>';
			echo '</a>';
		}
	}

	// Pro Version Links
	class Graceful_Pro_Links extends WP_Customize_Control {
		public $type = 'pro_links';

		public function render_content() {
			?>
			<ul>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Pro Version', 'graceful' ); ?></h3>
					<p><strong><?php esc_html_e( 'Upgrade to pro version for more customization options and Premium Support.', 'graceful' ); ?></strong></p>
					<a href="<?php echo esc_url('http://optimathemes.com/themes/graceful-pro?ref=graceful-customizer-buypro'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Check Graceful Pro', 'graceful' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Documentation and Demo', 'graceful' ); ?></h3>
					<a href="<?php echo esc_url('http://optimathemes.com/themes/graceful/docs/?ref=graceful-customizer-docs/'); ?>" target="_blank"><?php esc_html_e( 'Check Documentation', 'graceful' ); ?></a>
				</li>
				<li class="customize-control">
					<a href="<?php echo esc_url('http://optimathemes.com/themes/graceful/demo-content/?ref=graceful-customizer-demo/'); ?>" target="_blank"><?php esc_html_e( 'Check Demo Content', 'graceful' ); ?></a>
				</li>
			</ul>
			<?php
		}
	}

	// Add Colors section
	$wp_customize->add_section( 'graceful_pro' , array(
		'title'		 => esc_html__( 'About Graceful Pro', 'graceful' ),
		'priority'	 => 1,
		'capability' => 'edit_theme_options'
	) );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_', array(
		'sanitize_callback' => 'graceful_sanitize_custom_controller'
	) );
	$wp_customize->add_control( new Graceful_Pro_Links ( $wp_customize,
			'pro_version_', array(
				'section'	=> 'graceful_pro',
				'type'		=> 'pro_links',
				'label' 	=> '',
				'priority'	=> 1
			)
		)
	);

	// Recommend Graceful Extra Companion Plugin if not active.
	if ( ! function_exists( 'graceful_extra_is_activated' ) || ! graceful_extra_is_activated() ) {

		if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Graceful_Extra_Recommend_Control' ) ) {
			/**
			 * Customizer control to recommend and install Graceful Extra.
			 */
			class Graceful_Extra_Recommend_Control extends WP_Customize_Control {
				public $type = 'graceful_extra_recommend';

				public function render_content() {
					?>
					<div class="graceful-extra-customizer-recommend" style="padding: 10px 0;">
						<p style="font-size: 13px; line-height: 1.5; color: #50575e;">
							<?php
							echo wp_kses_post(
								sprintf(
									/* translators: %s: Plugin name */
									__( 'To unlock reading time, post views counter, customizable floating back-to-top button, and per-post layout controls, install and activate %s plugin.', 'graceful' ),
									'<strong>' . esc_html__( 'Graceful Extra', 'graceful' ) . '</strong>'
								)
							);
							?>
						</p>
						<p style="margin-top: 15px;">
							<?php
							if ( class_exists( 'Graceful_Plugin_Install' ) ) {
								Graceful_Plugin_Install::install_plugin_button(
									'graceful-extra',
									'graceful-extra.php',
									'Graceful Extra',
									array( 'button-primary', 'widefat' )
								);
							}
							?>
						</p>
					</div>
					<?php
				}
			}
		}

		$wp_customize->add_section(
			'graceful_extra_recommend',
			array(
				'title'       => esc_html__( 'Recommended: Graceful Extra', 'graceful' ),
				'priority'    => 0,
				'capability'  => 'edit_theme_options',
			)
		);

		$wp_customize->add_setting(
			'graceful_extra_recommend_setting',
			array(
				'sanitize_callback' => 'graceful_sanitize_custom_controller',
			)
		);

		$wp_customize->add_control(
			new Graceful_Extra_Recommend_Control(
				$wp_customize,
				'graceful_extra_recommend_setting',
				array(
					'section'  => 'graceful_extra_recommend',
					'priority' => 1,
				)
			)
		);
	}