<?php if ( ! defined( 'ABSPATH' ) ) exit;
$all  = pp_get_projects( 'work', -1 );
$cur  = (int) get_queried_object_id();
$next = null;
foreach ( $all as $i => $p ) {
	if ( (int) $p['id'] === $cur ) { $next = $all[ ( $i + 1 ) % count( $all ) ]; break; }
}
if ( $next && (int) $next['id'] === $cur ) $next = null;
$work_url = get_post_type_archive_link( 'pp_project' ) ?: home_url( '/work/' );
?>
<div class="container medium">
	<?php if ( $next ) : ?>
	<a href="<?php echo esc_url( $next['url'] ); ?>" class="row next-case-btn">
		<div class="flex-col"><p>Next case</p><h2><?php echo esc_html( $next['title'] ); ?></h2></div>
		<div class="tile-image-wrap"><div class="tile-image"><div class="overlay overlay-image" style="background-image:url('<?php echo esc_url( $next['img'] ); ?>');background-size:cover;background-position:center"></div></div></div>
	</a>
	<?php endif; ?>
	<div class="row"><div class="flex-col"><div class="stripe"></div></div></div>
	<div class="row"><div class="flex-col">
		<div class="btn btn-normal">
			<a href="<?php echo esc_url( $work_url ); ?>" class="btn-click magnetic" data-strength="25" data-strength-text="15">
				<div class="btn-fill"></div>
				<span class="btn-text"><span class="btn-text-inner change">All work<div class="count-nr"><?php echo (int) count( $all ); ?></div></span></span>
			</a>
		</div>
	</div></div>
</div>
