<?php
/**
 * Graceful Extra Back to Top Options
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Back to Top Section.
$wp_customize->add_section(
	'graceful_extra_back_to_top_section',
	array(
		'title'       => esc_html__( 'Back to Top Button', 'graceful-extra' ),
		'description' => esc_html__( 'Configure and style the floating Back to Top button.', 'graceful-extra' ),
		'panel'       => 'graceful_extra_panel',
		'priority'    => 20,
	)
);

// Enable / Disable.
$wp_customize->add_setting(
	'graceful_extra_btt_enable',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_btt_enable',
	array(
		'label'       => esc_html__( 'Enable Floating Back to Top Button', 'graceful-extra' ),
		'description' => esc_html__( 'Displays a floating scroll-to-top button on long pages.', 'graceful-extra' ),
		'section'     => 'graceful_extra_back_to_top_section',
		'type'        => 'checkbox',
		'priority'    => 10,
	)
);

// Position.
$wp_customize->add_setting(
	'graceful_extra_btt_position',
	array(
		'default'           => 'right',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_select',
	)
);

$wp_customize->add_control(
	'graceful_extra_btt_position',
	array(
		'label'    => esc_html__( 'Button Screen Position', 'graceful-extra' ),
		'section'  => 'graceful_extra_back_to_top_section',
		'type'     => 'select',
		'choices'  => array(
			'right' => esc_html__( 'Bottom Right', 'graceful-extra' ),
			'left'  => esc_html__( 'Bottom Left', 'graceful-extra' ),
		),
		'priority' => 20,
	)
);

// Button Shape.
$wp_customize->add_setting(
	'graceful_extra_btt_shape',
	array(
		'default'           => 'circle',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_select',
	)
);

$wp_customize->add_control(
	'graceful_extra_btt_shape',
	array(
		'label'    => esc_html__( 'Button Shape', 'graceful-extra' ),
		'section'  => 'graceful_extra_back_to_top_section',
		'type'     => 'select',
		'choices'  => array(
			'circle'  => esc_html__( 'Circle (Round)', 'graceful-extra' ),
			'rounded' => esc_html__( 'Rounded Corners', 'graceful-extra' ),
			'square'  => esc_html__( 'Square', 'graceful-extra' ),
		),
		'priority' => 30,
	)
);

// Background Color.
$wp_customize->add_setting(
	'graceful_extra_btt_bg_color',
	array(
		'default'           => '#111111',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'graceful_extra_btt_bg_color',
		array(
			'label'    => esc_html__( 'Background Color', 'graceful-extra' ),
			'section'  => 'graceful_extra_back_to_top_section',
			'priority' => 40,
		)
	)
);

// Icon Color.
$wp_customize->add_setting(
	'graceful_extra_btt_icon_color',
	array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'graceful_extra_btt_icon_color',
		array(
			'label'    => esc_html__( 'Icon / Arrow Color', 'graceful-extra' ),
			'section'  => 'graceful_extra_back_to_top_section',
			'priority' => 50,
		)
	)
);

// Mobile Display.
$wp_customize->add_setting(
	'graceful_extra_btt_mobile',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_btt_mobile',
	array(
		'label'    => esc_html__( 'Display on Mobile Screens', 'graceful-extra' ),
		'section'  => 'graceful_extra_back_to_top_section',
		'type'     => 'checkbox',
		'priority' => 60,
	)
);
