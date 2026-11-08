<?php
/**
 * Block Filters
 *
 * @package pixel_personal_portfolio
 * @since 1.0
 */

function pixel_personal_portfolio_block_wrapper( $pixel_personal_portfolio_block_content, $pixel_personal_portfolio_block ) {

	if ( 'core/button' === $pixel_personal_portfolio_block['blockName'] ) {
		
		if( isset( $pixel_personal_portfolio_block['attrs']['className'] ) && strpos( $pixel_personal_portfolio_block['attrs']['className'], 'has-arrow' ) ) {
			$pixel_personal_portfolio_block_content = str_replace( '</a>', pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'caret-circle-right' ) ) ) . '</a>', $pixel_personal_portfolio_block_content );
			return $pixel_personal_portfolio_block_content;
		}
	}

	if( ! is_single() ) {
	
		if ( 'core/post-terms'  === $pixel_personal_portfolio_block['blockName'] ) {
			if( 'post_tag' === $pixel_personal_portfolio_block['attrs']['term'] ) {
				$pixel_personal_portfolio_block_content = str_replace( '<div class="taxonomy-post_tag wp-block-post-terms">', '<div class="taxonomy-post_tag wp-block-post-terms flex">' . pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'tags' ) ) ), $pixel_personal_portfolio_block_content );
			}

			if( 'category' ===  $pixel_personal_portfolio_block['attrs']['term'] ) {
				$pixel_personal_portfolio_block_content = str_replace( '<div class="taxonomy-category wp-block-post-terms">', '<div class="taxonomy-category wp-block-post-terms flex">' . pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'category' ) ) ), $pixel_personal_portfolio_block_content );
			}
			return $pixel_personal_portfolio_block_content;
		}
		if ( 'core/post-date' === $pixel_personal_portfolio_block['blockName'] ) {
			$pixel_personal_portfolio_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'calendar' ) ) ), $pixel_personal_portfolio_block_content );
			return $pixel_personal_portfolio_block_content;
		}
		if ( 'core/post-author' === $pixel_personal_portfolio_block['blockName'] ) {
			$pixel_personal_portfolio_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'user' ) ) ), $pixel_personal_portfolio_block_content );
			return $pixel_personal_portfolio_block_content;
		}
	}
	if( is_single() ){

		// Add chevron icon to the navigations
		if ( 'core/post-navigation-link' === $pixel_personal_portfolio_block['blockName'] ) {
			if( isset( $pixel_personal_portfolio_block['attrs']['type'] ) && 'previous' === $pixel_personal_portfolio_block['attrs']['type'] ) {
				$pixel_personal_portfolio_block_content = str_replace( '<span class="post-navigation-link__label">', '<span class="post-navigation-link__label">' . pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'prev' ) ) ), $pixel_personal_portfolio_block_content );
			}
			else {
				$pixel_personal_portfolio_block_content = str_replace( '<span class="post-navigation-link__label">Next Post', '<span class="post-navigation-link__label">Next Post' . pixel_personal_portfolio_get_svg( array( 'icon' => esc_attr( 'next' ) ) ), $pixel_personal_portfolio_block_content );
			}
			return $pixel_personal_portfolio_block_content;
		}
		if ( 'core/post-date' === $pixel_personal_portfolio_block['blockName'] ) {
            $pixel_personal_portfolio_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . pixel_personal_portfolio_get_svg( array( 'icon' => 'calendar' ) ), $pixel_personal_portfolio_block_content );
            return $pixel_personal_portfolio_block_content;
        }
		if ( 'core/post-author' === $pixel_personal_portfolio_block['blockName'] ) {
            $pixel_personal_portfolio_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . pixel_personal_portfolio_get_svg( array( 'icon' => 'user' ) ), $pixel_personal_portfolio_block_content );
            return $pixel_personal_portfolio_block_content;
        }

	}
    return $pixel_personal_portfolio_block_content;
}
	
add_filter( 'render_block', 'pixel_personal_portfolio_block_wrapper', 10, 2 );
