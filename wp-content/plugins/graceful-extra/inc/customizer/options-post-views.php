<?php
/**
 * Graceful Extra Post Views Options
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Post Views Section.
$wp_customize->add_section(
	'graceful_extra_post_views_section',
	array(
		'title'       => esc_html__( 'Post Views Counter', 'graceful-extra' ),
		'description' => esc_html__( 'Track and display view counts on single blog posts. (Disabled by default)', 'graceful-extra' ),
		'panel'       => 'graceful_extra_panel',
		'priority'    => 18,
	)
);

// 1. Enable Views Counter (Disabled by default).
$wp_customize->add_setting(
	'graceful_extra_views_enable',
	array(
		'default'           => false,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_views_enable',
	array(
		'label'       => esc_html__( 'Enable Post Views Counter', 'graceful-extra' ),
		'description' => esc_html__( 'Tracks and displays views on single post views.', 'graceful-extra' ),
		'section'     => 'graceful_extra_post_views_section',
		'type'        => 'checkbox',
		'priority'    => 10,
	)
);

// 2. Views Label (Plural).
$wp_customize->add_setting(
	'graceful_extra_views_label',
	array(
		'default'           => __( 'views', 'graceful-extra' ),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'graceful_extra_views_label',
	array(
		'label'    => esc_html__( 'Views Label (Plural)', 'graceful-extra' ),
		'section'  => 'graceful_extra_post_views_section',
		'type'     => 'text',
		'priority' => 20,
	)
);

// 3. Views Label (Singular).
$wp_customize->add_setting(
	'graceful_extra_views_label_singular',
	array(
		'default'           => __( 'view', 'graceful-extra' ),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'graceful_extra_views_label_singular',
	array(
		'label'    => esc_html__( 'Views Label (Singular)', 'graceful-extra' ),
		'section'  => 'graceful_extra_post_views_section',
		'type'     => 'text',
		'priority' => 30,
	)
);

// 4. Show Eye Icon.
$wp_customize->add_setting(
	'graceful_extra_views_show_icon',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_views_show_icon',
	array(
		'label'    => esc_html__( 'Display Eye Icon', 'graceful-extra' ),
		'section'  => 'graceful_extra_post_views_section',
		'type'     => 'checkbox',
		'priority' => 40,
	)
);

// 5. Exclude Admins from counting.
$wp_customize->add_setting(
	'graceful_extra_views_exclude_admins',
	array(
		'default'           => true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'graceful_extra_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'graceful_extra_views_exclude_admins',
	array(
		'label'       => esc_html__( 'Exclude Administrators', 'graceful-extra' ),
		'description' => esc_html__( 'Do not increment view count when logged-in site administrators view the post.', 'graceful-extra' ),
		'section'     => 'graceful_extra_post_views_section',
		'type'        => 'checkbox',
		'priority' => 50,
	)
);
