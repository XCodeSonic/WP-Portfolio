<?php
/**
 * Template part for displaying Archive / Search Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Graceful_Aspire_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$archive_type  = '';
$archive_title = '';
$archive_desc  = '';
$author_avatar = '';

if ( is_category() ) {
	$archive_type  = esc_html__( 'Category', 'graceful-aspire-blog' );
	$archive_title = single_cat_title( '', false );
	$archive_desc  = category_description();
} elseif ( is_tag() ) {
	$archive_type  = esc_html__( 'Tag', 'graceful-aspire-blog' );
	$archive_title = single_tag_title( '', false );
	$archive_desc  = tag_description();
} elseif ( is_author() ) {
	$archive_type = esc_html__( 'Author', 'graceful-aspire-blog' );
	$author_obj   = get_queried_object();
	if ( $author_obj instanceof WP_User ) {
		$archive_title = $author_obj->display_name;
		$archive_desc  = get_the_author_meta( 'description', $author_obj->ID );
		$author_avatar = get_avatar( $author_obj->ID, 80, '', $author_obj->display_name, array( 'class' => 'archive-author-avatar' ) );
	} else {
		$archive_title = get_the_author();
	}
} elseif ( is_search() ) {
	$archive_type  = esc_html__( 'Search Results', 'graceful-aspire-blog' );
	$archive_title = get_search_query();
	global $wp_query;
	$found = (int) $wp_query->found_posts;
	if ( $found > 0 ) {
		$archive_desc = sprintf(
			/* translators: %s: Number of articles found */
			esc_html( _n( '%s article found', '%s articles found', $found, 'graceful-aspire-blog' ) ),
			number_format_i18n( $found )
		);
	} else {
		$archive_desc = esc_html__( 'No articles found matching your criteria.', 'graceful-aspire-blog' );
	}
} elseif ( is_day() ) {
	$archive_type  = esc_html__( 'Daily Archive', 'graceful-aspire-blog' );
	$archive_title = get_the_date();
} elseif ( is_month() ) {
	$archive_type  = esc_html__( 'Monthly Archive', 'graceful-aspire-blog' );
	$archive_title = get_the_date( 'F Y' );
} elseif ( is_year() ) {
	$archive_type  = esc_html__( 'Yearly Archive', 'graceful-aspire-blog' );
	$archive_title = get_the_date( 'Y' );
} elseif ( is_tax() ) {
	$current_term = get_queried_object();
	if ( $current_term && ! empty( $current_term->taxonomy ) ) {
		$taxonomy_obj = get_taxonomy( $current_term->taxonomy );
		$archive_type = $taxonomy_obj ? $taxonomy_obj->labels->singular_name : esc_html__( 'Archive', 'graceful-aspire-blog' );
	} else {
		$archive_type = esc_html__( 'Archive', 'graceful-aspire-blog' );
	}
	$archive_title = single_term_title( '', false );
	$archive_desc  = term_description();
} elseif ( is_post_type_archive() ) {
	$archive_type  = esc_html__( 'Archive', 'graceful-aspire-blog' );
	$archive_title = post_type_archive_title( '', false );
	$archive_desc  = get_the_archive_description();
} elseif ( is_home() && ! is_front_page() ) {
	$archive_type  = esc_html__( 'Blog', 'graceful-aspire-blog' );
	$archive_title = single_post_title( '', false );
} else {
	$archive_type  = esc_html__( 'Archive', 'graceful-aspire-blog' );
	$archive_title = get_the_archive_title();
	$archive_desc  = get_the_archive_description();
}
?>

<header class="graceful-aspire-archive-header">
	<div class="archive-header-inner">
		<?php if ( ! empty( $author_avatar ) ) : ?>
			<div class="archive-header-avatar">
				<?php echo wp_kses_post( $author_avatar ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $archive_type ) ) : ?>
			<span class="archive-header-subtitle"><?php echo esc_html( $archive_type ); ?></span>
		<?php endif; ?>

		<?php if ( is_search() ) : ?>
			<h1 class="archive-header-title page-title">&ldquo;<?php echo esc_html( $archive_title ); ?>&rdquo;</h1>
		<?php else : ?>
			<h1 class="archive-header-title page-title"><?php echo esc_html( $archive_title ); ?></h1>
		<?php endif; ?>

		<?php if ( ! empty( $archive_desc ) ) : ?>
			<div class="archive-header-desc archive-description">
				<?php
				if ( strip_tags( $archive_desc ) === $archive_desc ) {
					echo wp_kses_post( wpautop( $archive_desc ) );
				} else {
					echo wp_kses_post( $archive_desc );
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</header>
