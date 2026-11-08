<?php
/**
 * Graceful Extra Post View Counter
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieve the total views for a post.
 *
 * @param int $post_id Optional post ID. Defaults to current post.
 * @return int Total views.
 */
function graceful_extra_get_post_views( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return (int) get_post_meta( $post_id, '_graceful_extra_post_views', true );
}

/**
 * Check if the current request is from a known bot or web crawler.
 *
 * @return bool
 */
function graceful_extra_is_bot() {
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return false;
	}

	$user_agent = strtolower( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$bot_identifiers = array(
		'bot',
		'crawl',
		'slurp',
		'spider',
		'mediapartners',
		'googlebot',
		'bingbot',
		'yandex',
		'baiduspider',
		'duckduckbot',
	);

	foreach ( $bot_identifiers as $identifier ) {
		if ( false !== strpos( $user_agent, $identifier ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Track single post view.
 */
function graceful_extra_track_post_views() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	// Must be enabled in Customizer (default is disabled).
	if ( ! get_theme_mod( 'graceful_extra_views_enable', false ) ) {
		return;
	}

	// Avoid bot and preview increments.
	if ( is_preview() || graceful_extra_is_bot() ) {
		return;
	}

	// Exclude administrators if option is checked.
	if ( get_theme_mod( 'graceful_extra_views_exclude_admins', true ) && current_user_can( 'manage_options' ) ) {
		return;
	}

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}

	// Throttle via cookie (1 hour) to avoid multiple increments on immediate page reloads.
	$cookie_name = 'graceful_extra_viewed_' . $post_id;
	if ( isset( $_COOKIE[ $cookie_name ] ) ) {
		return;
	}

	$views = (int) get_post_meta( $post_id, '_graceful_extra_post_views', true );
	update_post_meta( $post_id, '_graceful_extra_post_views', $views + 1 );

	// Set cookie if headers have not been sent yet.
	if ( ! headers_sent() ) {
		setcookie( $cookie_name, '1', time() + 3600, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN );
	}
}
add_action( 'template_redirect', 'graceful_extra_track_post_views' );

/**
 * Format and return HTML for post views.
 *
 * @param int $post_id Optional post ID.
 * @return string HTML output.
 */
function graceful_extra_get_views_html( $post_id = 0 ) {
	if ( ! get_theme_mod( 'graceful_extra_views_enable', false ) ) {
		return '';
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$views     = graceful_extra_get_post_views( $post_id );
	$plural    = get_theme_mod( 'graceful_extra_views_label', _n( 'view', 'views', 2, 'graceful-extra' ) );
	$singular  = get_theme_mod( 'graceful_extra_views_label_singular', _n( 'view', 'views', 1, 'graceful-extra' ) );
	$show_icon = get_theme_mod( 'graceful_extra_views_show_icon', true );

	$label     = ( 1 === $views ) ? $singular : $plural;
	$icon_html = $show_icon ? '<i class="fa fa-eye" aria-hidden="true"></i> ' : '';

	return sprintf(
		'<span class="graceful-extra-meta-item graceful-extra-post-views">%s%s %s</span>',
		$icon_html,
		number_format_i18n( $views ),
		esc_html( $label )
	);
}

/**
 * Register [graceful_post_views] shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function graceful_extra_views_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'post_id' => 0,
		),
		$atts,
		'graceful_post_views'
	);

	return graceful_extra_get_views_html( (int) $atts['post_id'] );
}
add_shortcode( 'graceful_post_views', 'graceful_extra_views_shortcode' );

/* ==========================================================================
   Admin Columns Support (Posts Table)
   ========================================================================== */

/**
 * Add Views column to Posts table in WP Admin.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function graceful_extra_add_views_column( $columns ) {
	if ( get_theme_mod( 'graceful_extra_views_enable', false ) ) {
		$columns['graceful_extra_views'] = esc_html__( 'Views', 'graceful-extra' );
	}
	return $columns;
}
add_filter( 'manage_posts_columns', 'graceful_extra_add_views_column' );

/**
 * Render Views column content in Posts table.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function graceful_extra_render_views_column( $column, $post_id ) {
	if ( 'graceful_extra_views' === $column ) {
		$views = graceful_extra_get_post_views( $post_id );
		echo esc_html( number_format_i18n( $views ) );
	}
}
add_action( 'manage_posts_custom_column', 'graceful_extra_render_views_column', 10, 2 );

/**
 * Make Views column sortable.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function graceful_extra_sortable_views_column( $columns ) {
	$columns['graceful_extra_views'] = 'graceful_extra_views';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'graceful_extra_sortable_views_column' );

/**
 * Filter the posts clauses to sort by views count.
 *
 * Scoped strictly to the main admin Posts query when sorting by graceful_extra_views.
 * Joins one aggregated views row per post to preserve unviewed posts and avoid
 * introducing duplicates. Missing counts sort as 0 (first in ASC, last in DESC).
 * Existing WHERE conditions, metadata filters, and query grouping are preserved.
 *
 * @param array    $clauses Query clauses.
 * @param WP_Query $query   Query instance.
 * @return array
 */
function graceful_extra_sort_views_clauses( $clauses, $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return $clauses;
	}

	// Restrict to 'post' post_type.
	$post_type = $query->get( 'post_type' );
	if ( ! empty( $post_type ) && 'post' !== $post_type ) {
		return $clauses;
	}

	if ( 'graceful_extra_views' !== $query->get( 'orderby' ) ) {
		return $clauses;
	}

	global $wpdb;

	// Validate order direction strictly.
	$raw_order = (string) $query->get( 'order' );
	$order     = 'ASC' === strtoupper( $raw_order ) ? 'ASC' : 'DESC';

	// Use the highest recorded count if duplicate views metadata exists.
	$clauses['join'] .= " LEFT JOIN (
		SELECT post_id, MAX(CAST(meta_value AS UNSIGNED)) AS view_count
		FROM {$wpdb->postmeta}
		WHERE meta_key = '_graceful_extra_post_views'
		GROUP BY post_id
	) AS graceful_extra_views_sort ON ({$wpdb->posts}.ID = graceful_extra_views_sort.post_id)";

	// Treat missing counts as zero: first in ascending, last in descending.
	$clauses['orderby'] = " COALESCE(graceful_extra_views_sort.view_count, 0) {$order}, {$wpdb->posts}.post_date DESC";

	return $clauses;
}
add_filter( 'posts_clauses', 'graceful_extra_sort_views_clauses', 10, 2 );
