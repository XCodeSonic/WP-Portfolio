<?php if ( ! defined( 'ABSPATH' ) ) exit;
$b = pp_brand();
?>
<div class="nav-bar">
	<div class="credits-top">
		<div class="btn btn-link btn-left-top">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-click magnetic" data-strength="20" data-strength-text="10">
				<span class="btn-text">
					<div class="credit"><span>©</span></div><div class="cbd"><span class="code-by"><?php echo esc_html( $b['prefix'] ); ?> </span><span class="dennis"><span class="dennis-span"><?php echo esc_html( $b['first'] ); ?></span> <span class="snellenberg"><?php echo esc_html( $b['last'] ); ?></span></span></div>
				</span>
			</a>
		</div>
	</div>
	<ul class="links-wrap">
		<?php foreach ( pp_menu_items() as $m ) : ?>
		<li class="btn btn-link<?php echo $m[2] ? ' active' : ''; ?>"><a href="<?php echo esc_url( $m[1] ); ?>" class="btn-click magnetic" data-strength="20" data-strength-text="10"><span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( $m[0] ); ?></span></span></a></li>
		<?php endforeach; ?>
		<li class="btn btn-link btn-menu"><div class="btn-click magnetic" data-strength="20" data-strength-text="10"><div class="btn-text"><span class="btn-text-inner">Menu</span></div></div></li>
	</ul>
</div>
