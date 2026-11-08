<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$projects = pp_get_projects( 'archive', -1 );
?>
<header class="section default-header work-header archive-header" data-scroll-section>
	<?php get_template_part( 'template-parts/nav-bar' ); ?>
	<div class="container medium">
		<div class="row"><div class="flex-col once-in">
			<h1><span><?php echo esc_html( get_theme_mod( 'pp_archive_label', 'Archive' ) ); ?> <div class="count-nr">(<?php echo (int) count( $projects ); ?>)</div></span></h1>
		</div></div>
	</div>
</header>
<section class="section-wrap section-wrap-work once-in archive-work-grid" data-scroll-section>
	<section class="section work-grid tiny-work-grid">
		<div class="container">
			<div class="grid-sub-title">
				<div class="flex-col"><h5>Client</h5></div>
				<div class="flex-col"><h5>Location</h5></div>
				<div class="flex-col"><h5>Services</h5></div>
				<div class="flex-col"><h5>Year</h5></div>
			</div>
			<?php if ( ! $projects ) : ?><p style="padding:2em 0;opacity:.6">Nothing archived yet. Edit a project and tick “Archived”.</p><?php endif; ?>
			<ul class="work-items mouse-pos-list-archive">
				<?php foreach ( $projects as $p ) :
					$href = $p['ext'] ?: $p['url'];
					$blank = $p['ext'] ? ' target="_blank" rel="noopener"' : '';
				?>
				<li>
					<div class="stripe animate"></div>
					<a href="<?php echo esc_url( $href ); ?>"<?php echo $blank; // phpcs:ignore ?> class="row">
						<div class="flex-col"><h4><span><?php echo esc_html( $p['title'] ); ?></span></h4></div>
						<div class="flex-col animate"><p><?php echo esc_html( $p['location'] ); ?></p></div>
						<div class="flex-col animate"><p><?php echo esc_html( $p['services'] ); ?></p></div>
						<div class="flex-col animate"><p><?php echo esc_html( $p['year'] ); ?></p></div>
						<div class="arrow"><?php echo pp_arrow(); // phpcs:ignore ?></div>
					</a>
				</li>
				<?php endforeach; ?>
				<div class="stripe last animate"></div>
			</ul>
		</div>
	</section>
</section>
<?php get_footer();
