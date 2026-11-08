<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>
<header class="section default-header" data-scroll-section>
	<?php get_template_part( 'template-parts/nav-bar' ); ?>
</header>
<div data-scroll-section><div class="pp-content">
	<a class="pp-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">← Back home</a>
	<?php if ( is_archive() ) : ?><h1><?php the_archive_title(); ?></h1><?php endif; ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<?php if ( is_singular() ) : ?>
				<h1><?php the_title(); ?></h1>
				<?php if ( is_singular( 'pp_project' ) ) :
					$bits = array_filter( array( pp_project_types( get_the_ID() ), get_post_meta( get_the_ID(), '_pp_location', true ), get_post_meta( get_the_ID(), '_pp_year', true ) ?: get_the_date( 'Y' ) ) ); ?>
					<p class="pp-meta" style="opacity:.6"><?php echo esc_html( implode( '  ·  ', $bits ) ); ?></p>
				<?php elseif ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); endif; ?>
				<?php the_content(); ?>
			<?php else : ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; the_posts_pagination(); else : ?>
		<h1>Nothing here yet</h1>
	<?php endif; ?>
</div></div>
<?php get_footer();
