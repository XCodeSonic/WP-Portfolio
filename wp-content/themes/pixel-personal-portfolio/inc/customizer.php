<?php
/**
 * Customizer
 * 
 * @package WordPress
 * @subpackage Pixel Personal Portfolio
 * @since Pixel Personal Portfolio 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pixel_personal_portfolio_customize_register( $wp_customize ) {
    // Check for existence of WP_Customize_Manager before proceeding
	if ( ! class_exists( 'WP_Customize_Manager' ) ) {
        return;
    }
    
	$wp_customize->add_section( new pixel_personal_portfolio_Customizer_Pro_Button( $wp_customize, 'pixel_personal_portfolio_upsell_premium_section', array(
		'title'       => __( 'Buy Pixel Personal Portfolio Pro', 'pixel-personal-portfolio' ),
		'button_text' => __( 'Buy Pro Theme', 'pixel-personal-portfolio' ),
		'url'         => esc_url( PIXEL_PERSONAL_PORTFOLIO_BUY_NOW ),
		'priority'    => 0,
	)));

	$wp_customize->add_section( new pixel_personal_portfolio_Customizer_Pro_Button( $wp_customize, 'pixel_personal_portfolio_upsell_live_preview_section', array(
		'title'       => __( 'Preview Pro Theme', 'pixel-personal-portfolio' ),
		'button_text' => __( 'View Live Demo', 'pixel-personal-portfolio' ),
		'url'         => esc_url( PIXEL_PERSONAL_PORTFOLIO_LIVE_DEMO ),
		'priority'    => 0,
	)));

}
add_action( 'customize_register', 'pixel_personal_portfolio_customize_register' );

if ( class_exists( 'WP_Customize_Section' ) ) {
	class pixel_personal_portfolio_Customizer_Pro_Button extends WP_Customize_Section {
		public $type = 'pixel-personal-portfolio-buynow';
		public $button_text = '';
		public $url = '';

		protected function render() {
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="pixel_personal_portfolio_customizer_pro_button accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="accordion-section-title premium-details">
					<?php echo esc_html( $this->title ); ?>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-secondary alignright" target="_blank" style="margin-top: -4px;"><?php echo esc_html( $this->button_text ); ?></a>
				</h3>
			</li>
			<?php
		}
	}
}

/**
 * Enqueue script for custom customize control.
 */
function pixel_personal_portfolio_custom_control_scripts() {
	wp_enqueue_script( 'pixel-personal-portfolio-custom-controls-js', get_template_directory_uri() . '/assets/js/custom-controls.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '1.0', true );

    wp_enqueue_style( 'pixel-personal-portfolio-customizer-css', get_template_directory_uri() . '/assets/css/customizer.css', array(), '1.0' );
}
add_action( 'customize_controls_enqueue_scripts', 'pixel_personal_portfolio_custom_control_scripts' );