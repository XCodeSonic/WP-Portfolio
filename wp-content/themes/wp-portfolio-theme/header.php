<?php if ( ! defined( 'ABSPATH' ) ) exit;
$words = pp_loading_words();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>try{if(sessionStorage.getItem('ppSeen'))document.documentElement.className+=' pp-skip-loader';}catch(e){}</script>
<style>.pp-skip-loader .loading-container{display:none}</style>
<noscript><style>.loading-container{display:none}</style></noscript>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="--pp-profile-image:url('<?php echo esc_url( pp_img( 'pp_profile_image', 'placeholder-profile.svg' ) ); ?>')">
<?php wp_body_open(); ?>

<div class="loading-container">
	<div class="loading-screen">
		<div class="rounded-div-wrap top"><div class="rounded-div"></div></div>
		<div class="loading-words">
			<?php foreach ( $words as $i => $w ) : ?>
				<h2><?php echo esc_html( $w ); ?><div class="dot"></div></h2>
			<?php endforeach; ?>
		</div>
		<div class="rounded-div-wrap bottom"><div class="rounded-div"></div></div>
	</div>
</div>

<main class="main touch" id="home">
	<div class="mouse-pos-list-image no-select">
		<div class="mouse-pos-list-image-bounce overlay">
			<div class="float-image-wrap">
				<?php foreach ( pp_hover_projects() as $p ) : ?>
					<li class="mouse-pos-list-image-inner visible">
						<?php if ( ! empty( $p['video'] ) ) : ?>
							<video class="overlay" src="<?php echo esc_url( $p['video'] ); ?>" poster="<?php echo esc_url( $p['img'] ); ?>" muted loop playsinline autoplay preload="metadata" style="object-fit:cover"></video>
						<?php else : ?>
							<div class="overlay overlay-image" style="background-image:url('<?php echo esc_url( $p['img'] ); ?>')"></div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="mouse-pos-list-btn no-select"></div>
	<div class="mouse-pos-list-span no-select"><p>View</p></div>

	<div class="btn btn-hamburger">
		<div class="btn-click magnetic" data-strength="50" data-strength-text="25">
			<div class="btn-fill"></div>
			<div class="btn-text"><div class="btn-bars"></div><span class="btn-text-inner">Menu</span></div>
		</div>
	</div>
	<div class="overlay fixed-nav-back"></div>
	<div class="fixed-nav theme-dark">
		<div class="fixed-nav-rounded-div"><div class="rounded-div-wrap"><div class="rounded-div"></div></div></div>
		<div class="fixed-nav-inner">
			<div class="row nav-row">
				<h5>Navigation</h5>
				<div class="stripe"></div>
				<ul class="links-wrap">
					<li class="btn btn-link<?php echo ( pp_current_path() === pp_home_path() ) ? ' active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-click magnetic" data-strength="24" data-strength-text="12"><span class="btn-text"><span class="btn-text-inner">Home</span></span></a>
					</li>
					<?php foreach ( pp_menu_items() as $m ) : ?>
					<li class="btn btn-link<?php echo $m[2] ? ' active' : ''; ?>">
						<a href="<?php echo esc_url( $m[1] ); ?>" class="btn-click magnetic" data-strength="24" data-strength-text="12"><span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( $m[0] ); ?></span></span></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php if ( pp_socials() ) : ?>
			<div class="row social-row">
				<div class="stripe"></div>
				<div class="socials"><h5>Socials</h5><ul><?php pp_render_socials(); ?></ul></div>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="main-wrap" data-scroll-container>
