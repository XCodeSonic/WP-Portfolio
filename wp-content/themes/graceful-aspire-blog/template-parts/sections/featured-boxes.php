<?php
/**
 * Template part for Featured Boxes below Header
 *
 * @package Graceful_Aspire_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Open the links in New Tab.
$graceful_links_window = graceful_aspire_blog_options( 'featured_boxes_window' ) ? '_blank' : '_self';
$graceful_links_rel    = ( '_blank' === $graceful_links_window ) ? ' rel="noopener"' : '';
$graceful_boxes_width  = ( 'wrapped' === graceful_aspire_blog_options( 'featured_boxes_width' ) ) ? ' wrapped-content' : '';
?>

<div id="featured-boxes" class="<?php echo esc_attr( $graceful_boxes_width ); ?> clear-fix">
	<!-- Link No 1 -->
	<?php if ( graceful_aspire_blog_options( 'featured_boxes_image_1' ) !== '' ) : ?>
	<div class="featured-box">
		<img src="<?php echo esc_url( wp_get_attachment_url( graceful_aspire_blog_options( 'featured_boxes_image_1' ) ) ); ?>" alt="<?php echo esc_attr( graceful_aspire_blog_options( 'featured_boxes_title_1' ) ); ?>">
		<a href="<?php echo esc_url( graceful_aspire_blog_options( 'featured_boxes_url_1' ) ); ?>" target="<?php echo esc_attr( $graceful_links_window ); ?>"<?php echo esc_attr( $graceful_links_rel ); ?>>
			<div class="graceful-wrap-outer">
				<div class="graceful-wrap-inner">
					<h4><?php echo esc_html( graceful_aspire_blog_options( 'featured_boxes_title_1' ) ); ?></h4>
				</div>
			</div>
		</a>
	</div>
	<?php endif; ?>

	<!-- Link No 2 -->
	<?php if ( graceful_aspire_blog_options( 'featured_boxes_image_2' ) !== '' ) : ?>
	<div class="featured-box">
		<img src="<?php echo esc_url( wp_get_attachment_url( graceful_aspire_blog_options( 'featured_boxes_image_2' ) ) ); ?>" alt="<?php echo esc_attr( graceful_aspire_blog_options( 'featured_boxes_title_2' ) ); ?>">
		<a href="<?php echo esc_url( graceful_aspire_blog_options( 'featured_boxes_url_2' ) ); ?>" target="<?php echo esc_attr( $graceful_links_window ); ?>"<?php echo esc_attr( $graceful_links_rel ); ?>>
			<div class="graceful-wrap-outer">
				<div class="graceful-wrap-inner">
					<h4><?php echo esc_html( graceful_aspire_blog_options( 'featured_boxes_title_2' ) ); ?></h4>
				</div>
			</div>
		</a>
	</div>
	<?php endif; ?>

	<!-- Link No 3 -->
	<?php if ( graceful_aspire_blog_options( 'featured_boxes_image_3' ) !== '' ) : ?>
	<div class="featured-box">
		<img src="<?php echo esc_url( wp_get_attachment_url( graceful_aspire_blog_options( 'featured_boxes_image_3' ) ) ); ?>" alt="<?php echo esc_attr( graceful_aspire_blog_options( 'featured_boxes_title_3' ) ); ?>">
		<a href="<?php echo esc_url( graceful_aspire_blog_options( 'featured_boxes_url_3' ) ); ?>" target="<?php echo esc_attr( $graceful_links_window ); ?>"<?php echo esc_attr( $graceful_links_rel ); ?>>
			<div class="graceful-wrap-outer">
				<div class="graceful-wrap-inner">
					<h4><?php echo esc_html( graceful_aspire_blog_options( 'featured_boxes_title_3' ) ); ?></h4>
				</div>
			</div>
		</a>
	</div>
	<?php endif; ?>

</div><!-- #featured-boxes end -->