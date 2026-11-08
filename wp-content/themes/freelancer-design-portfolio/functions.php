<?php
/**
 * Freelancer Design Portfolio theme setup.
 *
 * @package Freelancer_Design_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end styles and scripts.
 */
function freelancer_design_portfolio_enqueue_assets() {
	$style_path  = get_theme_file_path( 'style.css' );
	$script_path = get_theme_file_path( 'assets/js/theme.js' );
	$version     = wp_get_theme()->get( 'Version' );

	// Version off the file mtime so edits are never served from a stale cache.
	wp_enqueue_style(
		'freelancer-design-portfolio-style',
		get_theme_file_uri( 'style.css' ),
		array(),
		file_exists( $style_path ) ? filemtime( $style_path ) : $version
	);

	wp_enqueue_script(
		'freelancer-design-portfolio-script',
		get_theme_file_uri( 'assets/js/theme.js' ),
		array(),
		file_exists( $script_path ) ? filemtime( $script_path ) : $version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'freelancer_design_portfolio_enqueue_assets' );

/**
 * Theme supports, text domain and menus.
 */
function freelancer_design_portfolio_setup() {
	load_theme_textdomain( 'freelancer-design-portfolio', get_template_directory() . '/languages' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'menus' );

	add_editor_style( array( 'editor-style.css', 'style.css' ) );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'freelancer-design-portfolio' ),
		)
	);
}
add_action( 'after_setup_theme', 'freelancer_design_portfolio_setup' );

/**
 * Pattern category used by every bundled pattern.
 */
function freelancer_design_portfolio_register_pattern_category() {
	register_block_pattern_category(
		'freelancer-design-portfolio',
		array( 'label' => esc_html__( 'Freelancer Design Portfolio', 'freelancer-design-portfolio' ) )
	);
}
add_action( 'init', 'freelancer_design_portfolio_register_pattern_category' );

/**
 * Extra button styles that map to the reference design.
 */
function freelancer_design_portfolio_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/button',
		array(
			'name'  => 'fdp-btn-ink',
			'label' => esc_html__( 'Ink Pill', 'freelancer-design-portfolio' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'fdp-btn-outline',
			'label' => esc_html__( 'Outline Pill', 'freelancer-design-portfolio' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'fdp-btn-ghost',
			'label' => esc_html__( 'Ghost Pill', 'freelancer-design-portfolio' ),
		)
	);
}
add_action( 'init', 'freelancer_design_portfolio_register_block_styles' );

/**
 * Admin promo banner for the pro theme.
 */
require_once get_theme_file_path( '/include/admin-promo-banner.php' );

/**
 * Front-end promo popup for super admins.
 */
require_once get_theme_file_path( '/include/admin-promo-frontend-popup.php' );

/**
 * Recommended plugins (TGM Plugin Activation).
 */
require_once get_theme_file_path( '/include/tgm/tgm.php' );
