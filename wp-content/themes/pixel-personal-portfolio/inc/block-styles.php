<?php
/**
 * Block Styles
 *
 * @package pixel_personal_portfolio
 * @since 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	function pixel_personal_portfolio_register_block_styles() {

		//Wp Block Padding Zero
		register_block_style(
			'core/group',
			array(
				'name'  => 'pixel-personal-portfolio-padding-0',
				'label' => esc_html__( 'No Padding', 'pixel-personal-portfolio' ),
			)
		);

		//Wp Block Post Author Style
		register_block_style(
			'core/post-author',
			array(
				'name'  => 'pixel-personal-portfolio-post-author-card',
				'label' => esc_html__( 'Theme Style', 'pixel-personal-portfolio' ),
			)
		);

		//Wp Block Button Style
		register_block_style(
			'core/button',
			array(
				'name'         => 'pixel-personal-portfolio-button',
				'label'        => esc_html__( 'Plain', 'pixel-personal-portfolio' ),
			)
		);

		//Post Comments Style
		register_block_style(
			'core/post-comments',
			array(
				'name'         => 'pixel-personal-portfolio-post-comments',
				'label'        => esc_html__( 'Theme Style', 'pixel-personal-portfolio' ),
			)
		);

		//Latest Comments Style
		register_block_style(
			'core/latest-comments',
			array(
				'name'         => 'pixel-personal-portfolio-latest-comments',
				'label'        => esc_html__( 'Theme Style', 'pixel-personal-portfolio' ),
			)
		);


		//Wp Block Table Style
		register_block_style(
			'core/table',
			array(
				'name'         => 'pixel-personal-portfolio-wp-table',
				'label'        => esc_html__( 'Theme Style', 'pixel-personal-portfolio' ),
			)
		);


		//Wp Block Pre Style
		register_block_style(
			'core/preformatted',
			array(
				'name'         => 'pixel-personal-portfolio-wp-preformatted',
				'label'        => esc_html__( 'Theme Style', 'pixel-personal-portfolio' ),
			)
		);

		//Wp Block Verse Style
		register_block_style(
			'core/verse',
			array(
				'name'         => 'pixel-personal-portfolio-wp-verse',
				'label'        => esc_html__( 'Theme Style', 'pixel-personal-portfolio' ),
			)
		);
	}
	add_action( 'init', 'pixel_personal_portfolio_register_block_styles' );
}
