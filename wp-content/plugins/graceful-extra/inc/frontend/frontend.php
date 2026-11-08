<?php
/**
 * Graceful Extra Frontend Functionality
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue frontend scripts and styles.
 */
function graceful_extra_enqueue_scripts() {
	// Enqueue CSS.
	wp_enqueue_style(
		'graceful-extra-style',
		GRACEFUL_EXTRA_URL . 'assets/css/graceful-extra.css',
		array(),
		GRACEFUL_EXTRA_VERSION
	);

	// Enqueue JS if Back to Top, Reading Time, or Views are enabled.
	$needs_js = get_theme_mod( 'graceful_extra_btt_enable', true )
		|| get_theme_mod( 'graceful_extra_reading_time_enable', true )
		|| get_theme_mod( 'graceful_extra_reading_time_archives', true )
		|| get_theme_mod( 'graceful_extra_views_enable', false );

	if ( $needs_js ) {
		wp_enqueue_script(
			'graceful-extra-script',
			GRACEFUL_EXTRA_URL . 'assets/js/graceful-extra.js',
			array( 'jquery' ),
			GRACEFUL_EXTRA_VERSION,
			true
		);
	}

	// Dynamic CSS for Back to Top.
	$btt_enabled    = get_theme_mod( 'graceful_extra_btt_enable', true );
	$btt_bg_color   = sanitize_hex_color( get_theme_mod( 'graceful_extra_btt_bg_color', '#111111' ) );
	$btt_icon_color = sanitize_hex_color( get_theme_mod( 'graceful_extra_btt_icon_color', '#ffffff' ) );
	$btt_position   = sanitize_key( get_theme_mod( 'graceful_extra_btt_position', 'right' ) );
	$btt_shape      = sanitize_key( get_theme_mod( 'graceful_extra_btt_shape', 'circle' ) );
	$btt_mobile     = get_theme_mod( 'graceful_extra_btt_mobile', true );

	$radius = '50%';
	if ( 'rounded' === $btt_shape ) {
		$radius = '8px';
	} elseif ( 'square' === $btt_shape ) {
		$radius = '0';
	}

	$pos_css = ( 'left' === $btt_position ) ? 'left: 25px; right: auto;' : 'right: 25px; left: auto;';

	$custom_css = '';

	if ( $btt_enabled ) {
		// Suppress theme's default .scrolltop button so it doesn't collide with the plugin's button,
		// and ensure it does not unexpectedly reappear on mobile when the plugin button is hidden on mobile.
		$custom_css .= "
			.scrolltop {
				display: none !important;
			}
			#graceful-extra-btt {
				background-color: {$btt_bg_color};
				color: {$btt_icon_color};
				border-radius: {$radius};
				{$pos_css}
			}
			#graceful-extra-btt:hover,
			#graceful-extra-btt:focus {
				color: {$btt_icon_color};
				opacity: 0.9;
			}
		";

		if ( ! $btt_mobile ) {
			$custom_css .= '
				@media (max-width: 767px) {
					#graceful-extra-btt {
						display: none !important;
					}
				}
			';
		}
	}

	if ( ! empty( $custom_css ) ) {
		wp_add_inline_style( 'graceful-extra-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'graceful_extra_enqueue_scripts', 20 );

/**
 * Filter body classes to apply post/page display options.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function graceful_extra_body_classes( $classes ) {
	if ( is_singular() ) {
		$post_id = get_the_ID();

		// Hide Title.
		$hide_title = get_post_meta( $post_id, '_graceful_extra_hide_title', true );
		if ( 'yes' === $hide_title ) {
			$classes[] = 'graceful-extra-hide-title';
		}

		// Disable Sidebar / Full Width.
		$disable_sidebar = get_post_meta( $post_id, '_graceful_extra_disable_sidebar', true );
		if ( 'yes' === $disable_sidebar ) {
			$classes[] = 'graceful-extra-no-sidebar';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'graceful_extra_body_classes' );

/**
 * Render floating Back to Top button in footer.
 */
function graceful_extra_render_back_to_top() {
	if ( ! get_theme_mod( 'graceful_extra_btt_enable', true ) ) {
		return;
	}
	?>
	<a href="#top" id="graceful-extra-btt" class="graceful-extra-btt" aria-label="<?php esc_attr_e( 'Back to top', 'graceful-extra' ); ?>">
		<i class="fa fa-angle-up" aria-hidden="true"></i>
	</a>
	<?php
}
add_action( 'wp_footer', 'graceful_extra_render_back_to_top', 30 );

/**
 * Collect reading time for archive post cards during the main query loop.
 *
 * @param WP_Post $post Current post object.
 */
function graceful_extra_collect_archive_reading_time( $post ) {
	if ( is_singular() ) {
		return;
	}

	if ( ! function_exists( 'graceful_extra_get_reading_time_html' ) ) {
		return;
	}

	if ( ! get_theme_mod( 'graceful_extra_reading_time_archives', true ) ) {
		return;
	}

	$reading_time_html = graceful_extra_get_reading_time_html( $post->ID, 'archive' );
	if ( ! empty( $reading_time_html ) ) {
		if ( ! isset( $GLOBALS['graceful_extra_archive_reading_times'] ) || ! is_array( $GLOBALS['graceful_extra_archive_reading_times'] ) ) {
			$GLOBALS['graceful_extra_archive_reading_times'] = array();
		}
		$GLOBALS['graceful_extra_archive_reading_times'][ $post->ID ] = $reading_time_html;
	}
}
add_action( 'the_post', 'graceful_extra_collect_archive_reading_time' );

/**
 * Localize metrics data into graceful-extra-script before it prints in the footer.
 */
function graceful_extra_localize_metrics_data() {
	if ( ! wp_script_is( 'graceful-extra-script', 'enqueued' ) ) {
		return;
	}

	$metrics_data = array(
		'single'   => '',
		'archives' => array(),
	);

	if ( is_singular( 'post' ) ) {
		$post_id           = get_the_ID();
		$reading_time_html = function_exists( 'graceful_extra_get_reading_time_html' ) ? graceful_extra_get_reading_time_html( $post_id, 'single' ) : '';
		$views_html        = function_exists( 'graceful_extra_get_views_html' ) ? graceful_extra_get_views_html( $post_id ) : '';
		$metrics_data['single'] = $reading_time_html . $views_html;
	} elseif ( ! empty( $GLOBALS['graceful_extra_archive_reading_times'] ) ) {
		$metrics_data['archives'] = $GLOBALS['graceful_extra_archive_reading_times'];
	}

	wp_localize_script( 'graceful-extra-script', 'gracefulExtraMetrics', $metrics_data );
}
add_action( 'wp_footer', 'graceful_extra_localize_metrics_data', 15 );

/**
 * Add noscript fallback for reading time on single posts.
 *
 * @param string $content Post content.
 * @return string
 */
function graceful_extra_inject_noscript_metrics( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$post_id           = get_the_ID();
	$reading_time_html = function_exists( 'graceful_extra_get_reading_time_html' ) ? graceful_extra_get_reading_time_html( $post_id, 'single' ) : '';
	$views_html        = function_exists( 'graceful_extra_get_views_html' ) ? graceful_extra_get_views_html( $post_id ) : '';

	if ( empty( $reading_time_html ) && empty( $views_html ) ) {
		return $content;
	}

	$noscript = '<noscript class="graceful-extra-noscript-meta">' . $reading_time_html . $views_html . '</noscript>';
	return $noscript . $content;
}
add_filter( 'the_content', 'graceful_extra_inject_noscript_metrics', 5 );


