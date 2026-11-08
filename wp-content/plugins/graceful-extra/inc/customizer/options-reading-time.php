<?php
/**
 * Graceful Extra Reading Time Options
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Reading Time Section.
$wp_customize->add_section(
	'graceful_extra_reading_time_section',
	array(
		'title'       => esc_html__( 'Reading Time Estimator', 'graceful-extra' ),
		'description' => esc_html__( 'Configure estimated reading time settings for single posts and blog archive cards.', 'graceful-extra' ),
		'panel'       => 'graceful_extra_panel',
		'priority'    => 15,
	)
);

// 1. Enable Reading Time on Single Posts.
$wp_customize->add_setting(
	'graceful_extra_reading_time_enable',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_reading_time_enable',
	array(
		'label'       => esc_html__( 'Enable on Single Posts', 'graceful-extra' ),
		'description' => esc_html__( 'Displays estimated reading time inside the single post header meta.', 'graceful-extra' ),
		'section'     => 'graceful_extra_reading_time_section',
		'type'        => 'checkbox',
		'priority'    => 10,
	)
);

// 2. Enable Reading Time on Blog / Archive Cards.
$wp_customize->add_setting(
	'graceful_extra_reading_time_archives',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_reading_time_archives',
	array(
		'label'       => esc_html__( 'Enable on Blog & Archive Cards', 'graceful-extra' ),
		'description' => esc_html__( 'Displays estimated reading time on home, category, tag, author, and search post cards.', 'graceful-extra' ),
		'section'     => 'graceful_extra_reading_time_section',
		'type'        => 'checkbox',
		'priority'    => 20,
	)
);

// 3. Words Per Minute (WPM).
$wp_customize->add_setting(
	'graceful_extra_reading_time_wpm',
	array(
		'default'           => 200,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'graceful_extra_reading_time_wpm',
	array(
		'label'       => esc_html__( 'Reading Speed (Words Per Minute)', 'graceful-extra' ),
		'description' => esc_html__( 'Average adult reading speed is between 200 and 250 words per minute.', 'graceful-extra' ),
		'section'     => 'graceful_extra_reading_time_section',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 50,
			'max'  => 600,
			'step' => 10,
		),
		'priority'    => 30,
	)
);

// 4. Reading Time Suffix Label.
$wp_customize->add_setting(
	'graceful_extra_reading_time_label',
	array(
		'default'           => __( 'min read', 'graceful-extra' ),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'graceful_extra_reading_time_label',
	array(
		'label'    => esc_html__( 'Reading Time Suffix', 'graceful-extra' ),
		'section'  => 'graceful_extra_reading_time_section',
		'type'     => 'text',
		'priority' => 40,
	)
);

// 5. Show Clock Icon.
$wp_customize->add_setting(
	'graceful_extra_reading_time_show_icon',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_reading_time_show_icon',
	array(
		'label'    => esc_html__( 'Display Clock Icon', 'graceful-extra' ),
		'section'  => 'graceful_extra_reading_time_section',
		'type'     => 'checkbox',
		'priority' => 50,
	)
);
