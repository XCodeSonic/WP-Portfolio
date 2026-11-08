<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
	$id       = get_the_ID();
	$types    = pp_project_types( $id );
	$credits  = pp_lines( get_post_meta( $id, '_pp_credits', true ) );
	$team     = pp_project_people( $id );
	$location = (string) get_post_meta( $id, '_pp_location', true );
	$year     = get_post_meta( $id, '_pp_year', true ) ?: get_the_date( 'Y' );
	$live     = (string) get_post_meta( $id, '_pp_url', true );
	$cover_id = (int) get_post_meta( $id, '_pp_cover_id', true );
	$cover    = $cover_id ? wp_get_attachment_image_url( $cover_id, 'full' ) : '';
	if ( ! $cover ) {
		$guess = pp_project_image( $id );
		if ( strpos( $guess, 'placeholder-work' ) === false ) $cover = $guess;
	}
	$intro  = trim( get_the_content() );
	$blocks = pp_get_blocks( $id );
?>
<section class="section case-top-wrap">
	<header class="section default-header case-header" data-scroll-section>
		<?php get_template_part( 'template-parts/nav-bar' ); ?>
		<div class="container medium once-in">
			<div class="row"><div class="flex-col"><h1><?php the_title(); ?></h1></div></div>
		</div>
	</header>

	<section class="section case-intro once-in" data-scroll-section>
		<div class="container medium">
			<div class="row">
				<?php if ( $types ) : ?>
				<div class="flex-col"><h5>Role / Services</h5><div class="stripe"></div><li><p><?php echo esc_html( $types ); ?></p></li></div>
				<?php endif; ?>
				<?php if ( $credits || $team ) : ?>
				<div class="flex-col"><h5>Credits</h5><div class="stripe"></div><?php foreach ( $team as $tm ) echo '<li><p><a href="' . esc_url( home_url( '/about/#' . $tm['slug'] ) ) . '">' . esc_html( $tm['name'] ) . '</a></p></li>'; foreach ( $credits as $c ) echo '<li><p>' . esc_html( $c ) . '</p></li>'; ?></div>
				<?php endif; ?>
				<div class="flex-col"><h5>Location &amp; year</h5><div class="stripe"></div>
					<?php if ( $location ) echo '<li><p>' . esc_html( $location ) . '</p></li>'; ?>
					<li><p><?php echo esc_html( $year ); ?></p></li>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $cover || $live ) : ?>
	<section class="section case-intro-image once-in block-padding-bottom" data-scroll-section>
		<div class="container"><div class="row"><div class="flex-col">
			<?php if ( $live ) : ?>
			<div class="btn-wrap theme-dark">
				<div class="btn btn-round" data-scroll data-scroll-speed="2" data-scroll-position="top">
					<a href="<?php echo esc_url( $live ); ?>" target="_blank" rel="noopener" class="btn-click magnetic" data-strength="100" data-strength-text="50">
						<div class="btn-fill"></div>
						<span class="btn-text"><span class="btn-text-inner">Live site <div class="arrow"><?php echo pp_arrow(); // phpcs:ignore ?></div></span></span>
					</a>
				</div>
			</div>
			<?php endif; ?>
			<?php if ( $cover ) : ?>
			<div class="single-image">
				<div class="overlay overlay-image" data-scroll data-scroll-speed="-1" style="background:url('<?php echo esc_url( $cover ); ?>') center center no-repeat;background-size:cover"></div>
			</div>
			<?php endif; ?>
		</div></div></div>
	</section>
	<?php endif; ?>
</section>

<?php if ( $intro !== '' ) : ?>
<section class="section single-block block-text pp-case-content" data-scroll-section>
	<div class="container medium"><div class="row"><div class="flex-col text-label"></div><div class="flex-col text-body"><?php the_content(); ?></div></div></div>
</section>
<?php endif; ?>

<?php foreach ( $blocks as $n => $b ) pp_render_block( $b, $n ); ?>

<?php endwhile;
get_footer();
