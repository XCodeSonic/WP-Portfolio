<?php
/**
 * Graceful Extra Customizer Handler
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panel, sections and settings.
 *
 * @param WP_Customize_Manager $wp_customize Instance of WP_Customize_Manager.
 */
function graceful_extra_customize_register( $wp_customize ) {

	// Add Graceful Extra Panel.
	$wp_customize->add_panel(
		'graceful_extra_panel',
		array(
			'title'       => esc_html__( 'Graceful Extra Options', 'graceful-extra' ),
			'description' => esc_html__( 'Additional features and controls provided by Graceful Extra addon.', 'graceful-extra' ),
			'priority'    => 35,
		)
	);

	// Load modular options.
	require_once GRACEFUL_EXTRA_PATH . 'inc/customizer/options-reading-time.php';
	require_once GRACEFUL_EXTRA_PATH . 'inc/customizer/options-post-views.php';
	require_once GRACEFUL_EXTRA_PATH . 'inc/customizer/options-back-to-top.php';
}
add_action( 'customize_register', 'graceful_extra_customize_register' );

/**
 * Sanitize boolean / checkbox values.
 *
 * @param mixed $checked Checked state.
 * @return bool
 */
function graceful_extra_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === (bool) $checked ) ? true : false );
}

/**
 * Sanitize select choices.
 *
 * @param string               $input   User input value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string
 */
function graceful_extra_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

