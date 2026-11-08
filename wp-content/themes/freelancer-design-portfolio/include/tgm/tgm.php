<?php
/**
 * Recommended plugins via TGM Plugin Activation.
 *
 * @package Freelancer_Design_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/include/tgm/class-tgm-plugin-activation.php';

/**
 * Register the plugins this theme recommends.
 */
function freelancer_design_portfolio_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'     => 'Scintilla Blocks',
			'slug'     => 'scintilla-blocks',
			'required' => false,
		),
		array(
			'name'     => 'GetBooqin',
			'slug'     => 'getbooqin',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'freelancer-design-portfolio',
		'default_path' => '',
		'menu'         => 'freelancer-design-portfolio-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'freelancer_design_portfolio_register_recommended_plugins' );
