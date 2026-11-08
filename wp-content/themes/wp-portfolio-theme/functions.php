<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/projects.php';
require get_template_directory() . '/inc/people.php';
require get_template_directory() . '/inc/blocks.php';
require get_template_directory() . '/inc/contact.php';

function pp_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'primary' => __( 'Primary menu', 'wp-portfolio-theme' ) ) );
}
add_action( 'after_setup_theme', 'pp_setup' );

function pp_assets() {
	$dir = get_template_directory();
	$v   = wp_get_theme()->get( 'Version' );
	$vc  = $v . '.' . filemtime( $dir . '/assets/css/main.css' );
	$vj  = $v . '.' . filemtime( $dir . '/assets/js/main.js' );
	$uri = get_template_directory_uri();
	wp_enqueue_style( 'pp-fonts', 'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300..800&display=swap', array(), null );
	wp_enqueue_style( 'pp-loco', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.3/dist/locomotive-scroll.min.css', array(), '4.1.3' );
	wp_enqueue_style( 'pp-main', $uri . '/assets/css/main.css', array( 'pp-fonts', 'pp-loco' ), $vc );
	wp_enqueue_style( 'pp-style', get_stylesheet_uri(), array( 'pp-main' ), $v );
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-st', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
	wp_enqueue_script( 'locomotive', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.3/dist/locomotive-scroll.min.js', array(), '4.1.3', true );
	wp_enqueue_script( 'pp-main', $uri . '/assets/js/main.js', array( 'gsap', 'gsap-st', 'locomotive' ), $vj, true );
}
add_action( 'wp_enqueue_scripts', 'pp_assets' );

/** Image helper: uploaded image (theme_mod) or bundled placeholder. */
function pp_img( $mod, $fallback = 'placeholder-hero.svg' ) {
	$id = get_theme_mod( $mod );
	if ( $id ) {
		$url = is_numeric( $id ) ? wp_get_attachment_image_url( $id, 'full' ) : $id;
		if ( $url ) return $url;
	}
	return get_template_directory_uri() . '/assets/images/' . $fallback;
}

/** Menu items: assigned WP menu, otherwise sensible defaults. Each item: title, url, active. */
function pp_menu_items() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( $locations['primary'] );
		if ( $items ) {
			$out = array();
			foreach ( $items as $i ) {
				if ( (int) $i->menu_item_parent === 0 ) $out[] = array( $i->title, $i->url, pp_is_active( $i->url ) );
			}
			return $out;
		}
	}
	$work = get_post_type_archive_link( 'pp_project' ) ?: home_url( '/work/' );
	$defaults = array( array( 'Work', $work ), array( 'About', home_url( '/about/' ) ), array( 'Contact', home_url( '/contact/' ) ) );
	foreach ( $defaults as &$d ) $d[] = pp_is_active( $d[1] );
	return $defaults;
}

function pp_socials() {
	$out  = array();
	$rows = get_option( 'pp_socials', array() );
	if ( is_array( $rows ) ) {
		foreach ( $rows as $r ) {
			if ( ! empty( $r['url'] ) ) $out[] = array( ! empty( $r['label'] ) ? $r['label'] : $r['url'], $r['url'] );
		}
	}
	if ( ! $out ) { // legacy Customizer values
		foreach ( array( 'instagram' => 'Instagram', 'twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'github' => 'GitHub' ) as $k => $label ) {
			$url = get_theme_mod( 'pp_social_' . $k, '' );
			if ( $url ) $out[] = array( $label, $url );
		}
	}
	return $out;
}

function pp_render_socials() {
	foreach ( pp_socials() as $s ) { ?>
		<li class="btn btn-link btn-link-external">
			<a href="<?php echo esc_url( $s[1] ); ?>" target="_blank" rel="noopener" class="btn-click magnetic" data-strength="20" data-strength-text="10">
				<span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( $s[0] ); ?></span></span>
			</a>
		</li>
	<?php }
}

function pp_arrow() {
	return '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><g transform="translate(7 7) rotate(90) translate(-6 -6)" fill="none" stroke="#FFFFFF" stroke-width="1.5"><polyline points="2.76923077 0 12 0 12 9.23076923"/><line x1="12" y1="0" x2="0" y2="12"/></g></svg>';
}

/** Link helper: "/about/" style values become full site URLs. */
function pp_url( $v ) {
	return ( strpos( $v, '/' ) === 0 ) ? home_url( $v ) : $v;
}


/* ---------- Brand / location / menu helpers ---------- */
function pp_brand() {
	return array(
		'prefix' => get_theme_mod( 'pp_brand_prefix', 'Code by' ),
		'first'  => get_theme_mod( 'pp_brand_first', 'Your' ),
		'last'   => get_theme_mod( 'pp_brand_last', 'Name' ),
	);
}

function pp_location_lines() {
	$t     = trim( str_replace( "\r", '', (string) get_theme_mod( 'pp_location', "Located\nin the\nPhilippines" ) ) );
	$lines = array_values( array_filter( array_map( 'trim', explode( "\n", $t ) ), 'strlen' ) );
	if ( count( $lines ) === 1 ) {
		$w = preg_split( '/\s+/', $lines[0] );
		if ( count( $w ) >= 3 ) {
			$first = array_shift( $w );
			$last  = array_pop( $w );
			$lines = array( $first, implode( ' ', $w ), $last );
		}
	}
	return $lines;
}

function pp_current_path() {
	$p = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/', PHP_URL_PATH );
	return untrailingslashit( (string) $p );
}

function pp_home_path() {
	return untrailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) );
}

function pp_is_active( $url ) {
	$u = untrailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) );
	$c = pp_current_path();
	if ( $u === '' || $u === pp_home_path() ) return false;
	return $c === $u || strpos( $c, $u . '/' ) === 0;
}

function pp_archive_url() {
	return home_url( '/archive/' );
}


/** Words shown one after another in the intro loader (editable in Customizer). */
function pp_loading_words() {
	$t     = (string) get_theme_mod( 'pp_loading_words', "Hello\nBonjour\nCiao\nHola\nOlá\nHallo" );
	$words = array_values( array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", '', $t ) ) ), 'strlen' ) );
	$name  = trim( (string) get_theme_mod( 'pp_name', '' ) );
	if ( $name !== '' ) $words[] = $name;
	return $words ? $words : array( get_bloginfo( 'name' ) );
}


/** CSS classes ("by-slug") that tie a project to its people, used by the Work page filter. */
function pp_people_classes( $p ) {
	$c = array();
	foreach ( (array) ( $p['people'] ?? array() ) as $pe ) $c[] = 'by-' . $pe['slug'];
	return implode( ' ', $c );
}
