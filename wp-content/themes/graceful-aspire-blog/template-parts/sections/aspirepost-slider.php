<?php
/**
 * Template part for Post Slider with angled background style
 *
 * @package Graceful_Aspire_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$graceful_aspire_slider_nav  = graceful_aspire_blog_options( 'aspirepost_slider_nav' ) ? 'true' : 'false';
$graceful_aspire_slider_dots = graceful_aspire_blog_options( 'aspirepost_slider_dots' ) ? 'true' : 'false';
?>

<div id="graceful-aspire-post-slider-wrap" class="wrapped-content clear-fix">
  <div class="graceful-aspire-carousel-section owl-carousel" data-nav="<?php echo esc_attr( $graceful_aspire_slider_nav ); ?>" data-dots="<?php echo esc_attr( $graceful_aspire_slider_dots ); ?>">
    <?php
    $graceful_aspire_posts = new WP_Query(
		array(
			'posts_per_page' => 3,
			'post_status'    => 'publish',
		)
	);
    if ( $graceful_aspire_posts->have_posts() ) :
		while ( $graceful_aspire_posts->have_posts() ) :
			$graceful_aspire_posts->the_post();
			?>
        <div class="item angled-slide" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
          <div class="image-overlay"></div>
          <div class="angled-overlay">
            <div class="carousel-device">
              <div class="carousel-device-content">
                
                <h2 class="carousel-title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
              </div>
            </div>
          </div>
        </div>
			<?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div>
</div>