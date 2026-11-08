<?php
/**
 * The header for our theme
 *
 * This is the template that displays the <head> section, Header and Navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Graceful Aspire Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

	<?php
	if ( graceful_options( 'basic_header_width' ) === 'wrapped' ) {
	    $graceful_header_width = 'class=wrapped-content';
	} else {
	    $graceful_header_width = '';
	}
	if ( graceful_options( 'basic_content_width' ) === 'wrapped' ) {
	    $graceful_content_width = 'wrapped-content';
	} else {
	    $graceful_content_width = '';
	}
	?>

	<?php // Site Loading Animation
	get_template_part('template-parts/sections/site', 'loadinganim'); 
	?>

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'graceful-aspire-blog' ); ?></a>	

	<div id="site-container">
		<div id="site-header" <?php echo esc_attr( $graceful_header_width ); ?>>
		<?php
		
		get_template_part( 'template-parts/header/main', 'navigation' );
		get_template_part( 'template-parts/header/site', 'header' );
		
		?>
		</div><!-- site-header close -->

		<!-- Page Content -->
		<main id="primary" class="site-main">
		<?php
			// Show Special Links if enabled.
			$graceful_special_links_enabled = graceful_aspire_blog_options( 'special_links_show' );
			if ( $graceful_special_links_enabled ) {
				get_template_part( 'template-parts/sections/special', 'links' );
			}
			if ( is_home() && !is_paged() ) {
			    // Show Aspire Post Slider if enabled
			    $graceful_aspire_post_slider_enabled = graceful_aspire_blog_options('aspirepost_slider_show');
			    if ( $graceful_aspire_post_slider_enabled ) {
			        get_template_part('template-parts/sections/aspirepost', 'slider');
			    }
			    
				// Show Post Slider if enabled
				$graceful_post_slider_enabled = graceful_options('post_slider_label');
			    if ( $graceful_post_slider_enabled ) {
			        get_template_part('template-parts/sections/post', 'slider');
			    }

			    // Show Featured Boxes if enabled
			    $graceful_featured_boxes_enabled = graceful_aspire_blog_options('featured_boxes_show');
			    if ( $graceful_featured_boxes_enabled ) {
			        get_template_part('template-parts/sections/featured', 'boxes');
			    }
			}
		?>
		<div class="main-content clear-fix <?php echo esc_attr( $graceful_content_width ); ?>" data-layout="<?php echo esc_attr( graceful_page_layout() ); ?>" data-sidebar-sticky="<?php echo esc_attr( graceful_options( 'basic_sidebar_sticky' ) ); ?>">
