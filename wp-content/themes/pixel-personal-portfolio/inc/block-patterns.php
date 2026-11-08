<?php
/**
 * Block Patterns
 *
 * @package pixel_personal_portfolio
 * @since 1.0
 */

function pixel_personal_portfolio_register_block_patterns() {
	$pixel_personal_portfolio_block_pattern_categories = array(
		'pixel-personal-portfolio' => array( 'label' => esc_html__( 'Pixel Personal Portfolio', 'pixel-personal-portfolio' ) ),
		'pages' => array( 'label' => esc_html__( 'Pages', 'pixel-personal-portfolio' ) ),
	);

	$pixel_personal_portfolio_block_pattern_categories = apply_filters( 'pixel_personal_portfolio_pixel_personal_portfolio_block_pattern_categories', $pixel_personal_portfolio_block_pattern_categories );

	foreach ( $pixel_personal_portfolio_block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}
}
add_action( 'init', 'pixel_personal_portfolio_register_block_patterns', 9 );