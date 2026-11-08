<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Graceful_Aspire_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

// Left Sidebar.
get_template_part( 'template-parts/sidebars/sidebar', 'left' );

// Content Columns Wrapper.
get_template_part( 'template-parts/columns/column', 'one' );

// Right Sidebar.
get_template_part( 'template-parts/sidebars/sidebar', 'right' );

get_footer();
