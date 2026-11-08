<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$name     = get_theme_mod( 'pp_name', 'Your Name' );
$projects = pp_get_projects( 'featured', 4 );
$heading  = get_theme_mod( 'pp_intro_heading', 'Helping brands stand out online. Clean design, solid code, no nonsense.' );
$more     = pp_count( 'work' );
$work_url = get_post_type_archive_link( 'pp_project' ) ?: home_url( '/work/' );
?>
<header class="section home-header theme-dark" data-scroll-section>
	<div class="overlay personal-image no-select" data-pp-speed="-3" data-scroll data-scroll-speed="-3" data-scroll-position="top">
		<?php $zoom = max( 40, min( 120, (int) get_theme_mod( 'pp_hero_zoom', 100 ) ) ); ?>
		<img src="<?php echo esc_url( pp_img( 'pp_hero_image' ) ); ?>" alt="" style="<?php echo $zoom < 100 ? 'top:auto;bottom:0;' : ''; ?>height:<?php echo (int) $zoom; ?>%">
	</div>
	<div class="overlay get-height">
		<div class="hanger">
			<p><?php foreach ( pp_location_lines() as $line ) echo '<span>' . esc_html( $line ) . ' </span>'; ?></p>
			<svg width="300px" height="121px" viewBox="0 0 300 121" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Artboard" transform="translate(0.000000, -366.000000)" fill="#1C1D20">
            <g id="Group" transform="translate(149.816828, 426.633657) rotate(90.000000) translate(-149.816828, -426.633657) translate(89.816828, 276.816828)">
                <g id="Hanger" transform="translate(60.000000, 149.816828) rotate(-90.000000) translate(-60.000000, -149.816828) translate(-89.816828, 89.816828)">
                    <path d="M239.633657,0 C272.770742,1.0182436e-15 299.633657,26.862915 299.633657,60 C299.633657,93.137085 272.770742,120 239.633657,120 L0,120 L0,0 L239.633657,0 Z M239.633657,18.7755102 C216.866,18.7755102 198.409167,37.232343 198.409167,60 C198.409167,82.767657 216.866,101.22449 239.633657,101.22449 C262.401314,101.22449 280.858147,82.767657 280.858147,60 C280.858147,37.232343 262.401314,18.7755102 239.633657,18.7755102 Z" id="Combined-Shape"></path>
                </g>
            </g>
        </g>
    </g>
</svg>
			<div class="digital-ball">
				<div class="overlay"></div>
				<div class="globe"><div class="globe-wrap">
					<div class="circle"></div><div class="circle"></div><div class="circle"></div>
					<div class="circle-hor"></div><div class="circle-hor-middle"></div>
				</div></div>
			</div>
		</div>
	</div>
	<?php get_template_part( 'template-parts/nav-bar' ); ?>
	<div class="container">
		<div class="row"><div class="flex-col">
			<div class="header-above-h4" data-pp-speed="1" data-scroll data-scroll-speed="1"><div class="arrow big"><?php echo pp_arrow(); // phpcs:ignore ?></div></div>
			<h4><span><?php echo esc_html( get_theme_mod( 'pp_role_first', 'Freelance' ) ); ?></span> <?php echo esc_html( get_theme_mod( 'pp_role_rest', 'Designer & Developer' ) ); ?></h4>
		</div></div>
	</div>
	<div class="big-name">
		<div class="name-h1" data-pp-speed-x="4" data-scroll data-scroll-direction="horizontal" data-scroll-speed="4" data-scroll-position="top">
			<div class="name-wrap"><h1 class="no-select"><?php echo esc_html( $name ); ?><span class="spacer">—</span></h1></div>
			<div class="name-wrap"><h1 class="no-select" aria-hidden="true"><?php echo esc_html( $name ); ?><span class="spacer">—</span></h1></div>
		</div>
	</div>
	<div class="white-block"></div>
</header>

<section class="section home-intro" data-scroll-section>
	<div class="container medium">
		<div class="row">
			<div class="flex-col">
				<h4 class="span-lines animate" data-pp-lines><?php
					foreach ( preg_split( '/\s+/', trim( $heading ) ) as $w ) {
						echo '<span class="span-line"><span class="span-line-inner">' . esc_html( $w ) . '</span></span> ';
					}
				?></h4>
			</div>
			<div class="flex-col">
				<div class="text-wrap fade-in animate"><p><?php echo esc_html( get_theme_mod( 'pp_intro_text', '' ) ); ?></p></div>
				<div class="btn btn-round" data-pp-speed="2" data-scroll data-scroll-speed="2">
					<a href="<?php echo esc_url( pp_url( get_theme_mod( 'pp_about_url', '/about/' ) ) ); ?>" class="btn-click magnetic" data-strength="100" data-strength-text="50">
						<div class="btn-fill"></div>
						<span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( get_theme_mod( 'pp_about_label', 'About me' ) ); ?></span></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section work-grid large-work-grid" id="work" data-scroll-section>
	<div class="container">
		<div class="grid-sub-title"><div class="flex-col"><h5><?php echo esc_html( get_theme_mod( 'pp_work_title', 'Recent work' ) ); ?></h5></div></div>
		<?php if ( ! $projects && current_user_can( 'edit_theme_options' ) ) : ?>
			<p style="padding:2em 0;opacity:.6">No featured projects yet. Edit a project and tick “Featured” to show it here (only you see this note).</p>
		<?php endif; ?>
		<ul class="work-items mouse-pos-list-image-wrap">
			<?php foreach ( $projects as $p ) : ?>
			<li class="visible <?php echo esc_attr( $p['slugs'] ); ?>">
				<div class="stripe animate"></div>
				<a href="<?php echo esc_url( $p['url'] ); ?>" class="row">
					<div class="flex-col"><h4><span><?php echo esc_html( $p['title'] ); ?></span></h4></div>
					<div class="flex-col animate"><p><?php echo esc_html( $p['services'] ); ?></p></div>
				</a>
			</li>
			<?php endforeach; ?>
			<div class="stripe last animate"></div>
		</ul>
	</div>
</section>

<section class="section work-tiles work-tiles-home" data-scroll-section>
	<div class="container">
		<ul>
			<?php foreach ( $projects as $p ) : ?>
			<li class="visible">
				<div class="single-tile-wrap">
					<a href="<?php echo esc_url( $p['url'] ); ?>" class="row">
						<div class="flex-col"><div class="tile-image"><div class="overlay overlay-image" style="background-image:url('<?php echo esc_url( $p['img'] ); ?>')"></div></div></div>
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

<section class="section center-grid-btn center-grid-btn-home" data-scroll-section>
	<div class="container">
		<div class="grid-after-btn">
			<div class="btn btn-normal">
				<a href="<?php echo esc_url( $work_url ); ?>" class="btn-click magnetic" data-strength="25" data-strength-text="15">
					<div class="btn-fill"></div>
					<span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( get_theme_mod( 'pp_more_label', 'More work' ) ); ?><?php if ( $more ) : ?><div class="count-nr"><?php echo (int) $more; ?></div><?php endif; ?></span></span>
				</a>
			</div>
		</div>
	</div>
</section>
<?php get_footer();
