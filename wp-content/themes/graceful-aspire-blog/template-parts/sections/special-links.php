<?php
/**
 * Template part for Special Links below Header
 *
 * @package Graceful_Aspire_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! graceful_aspire_blog_options( 'special_links_show' ) ) {
	return;
}

if ( ! has_nav_menu( 'special-links' ) && ! current_user_can( 'edit_theme_options' ) ) {
	return;
}

$graceful_aspire_wrapper_class = ( 'wrapped' === graceful_aspire_blog_options( 'featured_boxes_width' ) ) ? 'wrapped-content' : '';
?>

<div id="graceful-aspire-special-links" class="<?php echo esc_attr( $graceful_aspire_wrapper_class ); ?> clear-fix">
	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'special-links',
			'menu_id'         => 'special-links-menu',
			'menu_class'      => 'graceful-aspire-special-links-wrap',
			'container'       => 'nav',
			'container_class' => 'graceful-aspire-special-links-nav',
			'fallback_cb'     => 'graceful_aspire_blog_special_links_fallback',
			'depth'           => 1,
		)
	);
	?>
</div><!-- #graceful-aspire-special-links end -->