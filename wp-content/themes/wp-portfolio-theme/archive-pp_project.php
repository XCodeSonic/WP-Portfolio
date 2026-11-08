<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$projects = pp_get_projects( 'work', -1 );
$types    = array();
foreach ( $projects as $p ) foreach ( $p['types'] as $slug => $name ) {
	if ( ! isset( $types[ $slug ] ) ) $types[ $slug ] = array( 'name' => $name, 'n' => 0 );
	$types[ $slug ]['n']++;
}
$by = array();
foreach ( $projects as $p ) foreach ( $p['people'] as $pe ) {
	if ( ! isset( $by[ $pe['slug'] ] ) ) $by[ $pe['slug'] ] = array( 'name' => $pe['name'], 'n' => 0 );
	$by[ $pe['slug'] ]['n']++;
}
$archived = pp_count( 'archive' );
?>
<header class="section default-header work-header" data-scroll-section>
	<?php get_template_part( 'template-parts/nav-bar' ); ?>
	<div class="container medium">
		<div class="row"><div class="flex-col once-in">
			<h1><span><?php echo esc_html( get_theme_mod( 'pp_work_h1_a', 'Creating next level' ) ); ?> </span><span><?php echo esc_html( get_theme_mod( 'pp_work_h1_b', 'digital products' ) ); ?></span></h1>
		</div></div>
	</div>
</header>

<section class="section work-filters" data-scroll-section>
	<div class="container once-in">
		<div class="filter-row">
			<div class="toggle-row">
				<div class="btn btn-normal all-btn active" data-filter="all">
					<div class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change">All</span></span></div>
				</div>
				<?php foreach ( $types as $slug => $t ) : ?>
				<div class="btn btn-normal <?php echo esc_attr( $slug ); ?>-btn" data-filter="<?php echo esc_attr( $slug ); ?>">
					<div class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( $t['name'] ); ?><div class="count-nr"><?php echo (int) $t['n']; ?></div></span></span></div>
				</div>
				<?php endforeach; ?>
				<?php if ( count( $by ) > 1 ) foreach ( $by as $slug => $t ) : ?>
				<div class="btn btn-normal by-<?php echo esc_attr( $slug ); ?>-btn" data-filter="by-<?php echo esc_attr( $slug ); ?>">
					<div class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change">By <?php echo esc_html( strtok( $t['name'], ' ' ) ); ?><div class="count-nr"><?php echo (int) $t['n']; ?></div></span></span></div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="grid-row">
				<div class="btn btn-normal btn-icon rows-btn active"><div class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><svg style="width:20px" width="20" height="19" viewBox="0 0 20 19"><g fill="currentColor" fill-rule="evenodd"><path d="M0 6h20v1H0zM0 0h20v1H0zM0 12h20v1H0zM0 18h20v1H0z"></path></g></svg></span></span></div></div>
				<div class="btn btn-normal btn-icon columns-btn"><div class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><svg style="width:20px" width="20" height="20" viewBox="0 0 20 20"><g fill="currentColor" fill-rule="nonzero"><path d="M8 0H0v8h8V0zM7 1v6H1V1h6zM8 12H0v8h8v-8zm-1 1v6H1v-6h6zM20 0h-8v8h8V0zm-1 1v6h-6V1h6zM20 12h-8v8h8v-8zm-1 1v6h-6v-6h6z"></path></g></svg></span></span></div></div>
			</div>
		</div>
	</div>
</section>

<section class="section-wrap section-wrap-work once-in" data-scroll-section>
	<section class="section work-grid small-work-grid grid-fade grid-rows-part visible">
		<div class="container">
			<div class="grid-sub-title">
				<div class="flex-col"><h5>Client</h5></div>
				<div class="flex-col"><h5>Location</h5></div>
				<div class="flex-col"><h5>Services</h5></div>
				<div class="flex-col"><h5>Year</h5></div>
			</div>
			<?php if ( ! $projects ) : ?><p style="padding:2em 0;opacity:.6">No projects yet. Add one under Projects → Add New.</p><?php endif; ?>
			<ul class="work-items mouse-pos-list-image-wrap all-active">
				<?php foreach ( $projects as $p ) : ?>
				<li class="visible <?php echo esc_attr( $p['slugs'] . ' ' . pp_people_classes( $p ) ); ?>">
					<div class="stripe animate"></div>
					<a href="<?php echo esc_url( $p['url'] ); ?>" class="row">
						<div class="flex-col"><h4><span><?php echo esc_html( $p['title'] ); ?></span></h4></div>
						<div class="flex-col animate"><p><?php echo esc_html( $p['location'] ); ?></p></div>
						<div class="flex-col animate"><p><?php echo esc_html( $p['services'] ); ?></p></div>
						<div class="flex-col animate"><p><?php echo esc_html( $p['year'] ); ?></p></div>
					</a>
				</li>
				<?php endforeach; ?>
				<div class="stripe last animate"></div>
			</ul>
		</div>
	</section>
	<section class="section work-tiles grid-fade grid-columns-part">
		<div class="container">
			<ul>
				<?php foreach ( $projects as $p ) : ?>
				<li class="visible <?php echo esc_attr( $p['slugs'] . ' ' . pp_people_classes( $p ) ); ?>">
					<div class="single-tile-wrap">
						<a href="<?php echo esc_url( $p['url'] ); ?>" class="row">
							<div class="flex-col"><div class="tile-image"><div class="overlay overlay-color"></div><div class="overlay overlay-image" style="background-image:url('<?php echo esc_url( $p['img'] ); ?>')"></div></div></div>
							<div class="flex-col"><h4><span><?php echo esc_html( $p['title'] ); ?></span></h4><div class="stripe"></div></div>
							<div class="flex-col"><p><?php echo esc_html( $p['services'] ); ?></p></div>
							<div class="flex-col"><p><?php echo esc_html( $p['year'] ); ?></p></div>
						</a>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
</section>

<?php if ( $archived ) : ?>
<section class="section center-grid-btn center-grid-btn-archive" data-scroll-section>
	<div class="container"><div class="grid-after-btn">
		<div class="btn btn-normal btn-dark">
			<a href="<?php echo esc_url( pp_archive_url() ); ?>" class="btn-click magnetic" data-strength="25" data-strength-text="15">
				<div class="btn-fill"></div>
				<span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( get_theme_mod( 'pp_archive_label', 'Archive' ) ); ?><div class="count-nr"><?php echo (int) $archived; ?></div></span></span>
			</a>
		</div>
	</div></div>
</section>
<?php endif; ?>
<?php get_footer();
