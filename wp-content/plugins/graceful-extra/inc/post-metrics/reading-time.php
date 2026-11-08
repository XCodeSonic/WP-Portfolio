<?php
/**
 * Graceful Extra Reading Time Estimator
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Calculate estimated reading time in minutes for a post.
 *
 * @param int $post_id Optional post ID. Defaults to current post.
 * @return int Reading time in minutes.
 */
function graceful_extra_calculate_reading_time( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$content = get_post_field( 'post_content', $post_id );
	if ( empty( $content ) ) {
		return 1;
	}

	// Clean content.
	$clean_content = wp_strip_all_tags( strip_shortcodes( $content ) );
	$word_count    = str_word_count( $clean_content );

	$wpm = (int) get_theme_mod( 'graceful_extra_reading_time_wpm', 200 );
	if ( $wpm <= 0 ) {
		$wpm = 200;
	}

	$minutes = (int) ceil( $word_count / $wpm );
	return max( 1, $minutes );
}

/**
 * Get formatted HTML for the reading time metric.
 *
 * @param int    $post_id Optional post ID.
 * @param string $context Context: 'single' or 'archive'.
 * @return string HTML output.
 */
function graceful_extra_get_reading_time_html( $post_id = 0, $context = 'single' ) {
	if ( 'archive' === $context ) {
		if ( ! get_theme_mod( 'graceful_extra_reading_time_archives', true ) ) {
			return '';
		}
	} else {
		if ( ! get_theme_mod( 'graceful_extra_reading_time_enable', true ) ) {
			return '';
		}
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$minutes   = graceful_extra_calculate_reading_time( $post_id );
	$label     = get_theme_mod( 'graceful_extra_reading_time_label', __( 'min read', 'graceful-extra' ) );
	$show_icon = get_theme_mod( 'graceful_extra_reading_time_show_icon', true );

	$icon_html = $show_icon ? '<i class="fa fa-clock-o" aria-hidden="true"></i> ' : '';

	return sprintf(
		'<span class="graceful-extra-meta-item graceful-extra-reading-time">%s%d %s</span>',
		$icon_html,
		$minutes,
		esc_html( $label )
	);
}

/**
 * Register [graceful_reading_time] shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function graceful_extra_reading_time_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'post_id' => 0,
		),
		$atts,
		'graceful_reading_time'
	);

	return graceful_extra_get_reading_time_html( (int) $atts['post_id'] );
}
add_shortcode( 'graceful_reading_time', 'graceful_extra_reading_time_shortcode' );
