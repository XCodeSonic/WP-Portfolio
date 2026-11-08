<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
 * People (team members) + their offers, certificates, links
 * Projects are linked to people from the project screen.
 * ========================================================= */

add_action( 'init', function () {
	register_post_type( 'pp_person', array(
		'labels' => array( 'name' => 'People', 'singular_name' => 'Person', 'add_new_item' => 'Add person', 'edit_item' => 'Edit person', 'menu_name' => 'People' ),
		'public' => false, 'show_ui' => true, 'show_in_menu' => true, 'show_in_rest' => true,
		'menu_icon' => 'dashicons-groups', 'menu_position' => 6,
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
	) );
	add_rewrite_rule( '^about/?$', 'index.php?pp_about=1', 'top' );
} );

add_filter( 'enter_title_here', function ( $t, $post ) { return $post->post_type === 'pp_person' ? 'Full name' : $t; }, 10, 2 );
add_filter( 'query_vars', function ( $v ) { $v[] = 'pp_about'; return $v; } );
add_filter( 'template_include', function ( $tpl ) {
	if ( get_query_var( 'pp_about' ) ) {
		global $wp_query;
		$wp_query->is_404  = false;
		$wp_query->is_home = false;
		status_header( 200 );
		return get_theme_file_path( 'template-about.php' );
	}
	return $tpl;
} );
add_filter( 'pre_get_document_title', function ( $t ) {
	return get_query_var( 'pp_about' ) ? 'About – ' . get_bloginfo( 'name' ) : $t;
} );

/* ---------- Repeater definitions (used for the admin UI and for sanitising) ---------- */
function pp_rep_defs() {
	return array(
		'_pp_offers' => array(
			'title' => 'What this person can offer', 'add' => '+ Add an offer',
			'fields' => array(
				array( 'k' => 'title', 'label' => 'Title', 'type' => 'text', 'ph' => 'Web development' ),
				array( 'k' => 'text', 'label' => 'Short description', 'type' => 'textarea' ),
			),
		),
		'_pp_certs' => array(
			'title' => 'Certifications', 'add' => '+ Add a certificate',
			'fields' => array(
				array( 'k' => 'title', 'label' => 'Certificate name', 'type' => 'text' ),
				array( 'k' => 'issuer', 'label' => 'Issued by', 'type' => 'text' ),
				array( 'k' => 'date', 'label' => 'Date / year', 'type' => 'text', 'ph' => '2025' ),
				array( 'k' => 'image', 'label' => 'Certificate image (opens full screen when clicked)', 'type' => 'media' ),
				array( 'k' => 'link', 'label' => 'Verification link (optional)', 'type' => 'url', 'ph' => 'https://' ),
			),
		),
		'_pp_links' => array(
			'title' => 'Links (portfolio, LinkedIn, GitHub…)', 'add' => '+ Add a link',
			'fields' => array(
				array( 'k' => 'label', 'label' => 'Label', 'type' => 'text', 'ph' => 'LinkedIn' ),
				array( 'k' => 'url', 'label' => 'URL', 'type' => 'url', 'ph' => 'https://' ),
			),
		),
	);
}

function pp_rep_sanitize( $key, $raw ) {
	$defs = pp_rep_defs();
	if ( ! isset( $defs[ $key ] ) || ! is_array( $raw ) ) return array();
	$out = array();
	foreach ( array_slice( $raw, 0, 60 ) as $row ) {
		if ( ! is_array( $row ) ) continue;
		$clean = array();
		$any   = false;
		foreach ( $defs[ $key ]['fields'] as $f ) {
			$v = $row[ $f['k'] ] ?? '';
			switch ( $f['type'] ) {
				case 'textarea': $v = sanitize_textarea_field( (string) $v ); break;
				case 'url':      $v = esc_url_raw( (string) $v ); break;
				case 'media':
					$mid = is_array( $v ) ? (int) ( $v['id'] ?? 0 ) : (int) $v;
					$v   = ( $mid > 0 && get_post( $mid ) ) ? $mid : 0;
					break;
				default:         $v = sanitize_text_field( (string) $v );
			}
			if ( $v ) $any = true;
			$clean[ $f['k'] ] = $v;
		}
		if ( $any ) $out[] = $clean;
	}
	return $out;
}

function pp_rep_for_admin( $post_id, $key ) {
	$defs = pp_rep_defs();
	$rows = get_post_meta( $post_id, $key, true );
	$rows = is_array( $rows ) ? $rows : array();
	foreach ( $rows as &$r ) {
		foreach ( $defs[ $key ]['fields'] as $f ) {
			if ( $f['type'] === 'media' ) $r[ $f['k'] ] = pp_media_info( $r[ $f['k'] ] ?? 0 );
		}
	}
	return $rows;
}

/* ---------- Person meta boxes ---------- */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'pp_person_profile', 'Profile', function ( $post ) {
		wp_nonce_field( 'pp_person', 'pp_person_nonce' );
		printf( '<p><label><strong>Role / position</strong><br><input type="text" class="widefat" name="pp_role" value="%s" placeholder="Lead Developer"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_role', true ) ) );
		printf( '<p><label><strong>One-line tagline</strong> (optional)<br><input type="text" class="widefat" name="pp_tagline" value="%s"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_tagline', true ) ) );
		printf( '<p><label><strong>Email</strong> (optional, shown as a button)<br><input type="email" class="widefat" name="pp_email" value="%s"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_email', true ) ) );
		echo '<p><strong>Photo</strong> (or use the Featured image box on the right)<br>';
		pp_media_field( 'pp_photo_id', (int) get_post_meta( $post->ID, '_pp_photo_id', true ), 'image', 'Select photo' );
		echo '</p><p class="description">The “About this person” text is the main editor above. Use the Order box on the right to arrange people on the About page.</p>';
	}, 'pp_person', 'normal', 'high' );

	foreach ( pp_rep_defs() as $key => $def ) {
		add_meta_box( 'pp_rep' . $key, $def['title'], function ( $post ) use ( $key, $def ) {
			$id = 'pp-rep-' . ltrim( $key, '_' );
			echo '<div id="' . esc_attr( $id ) . '" class="pp-rep"></div><input type="hidden" name="pp_rep[' . esc_attr( $key ) . ']" id="' . esc_attr( $id ) . '-json" value="">';
			echo '<script>window.ppRep=window.ppRep||[];window.ppRep.push(' . wp_json_encode( array( 'root' => '#' . $id, 'input' => '#' . $id . '-json', 'data' => pp_rep_for_admin( $post->ID, $key ), 'fields' => $def['fields'], 'add' => $def['add'] ) ) . ');</script>';
		}, 'pp_person', 'normal', 'default' );
	}

	add_meta_box( 'pp_project_people', 'Made by (people)', function ( $post ) {
		wp_nonce_field( 'pp_project_people', 'pp_project_people_nonce' );
		$people = get_posts( array( 'post_type' => 'pp_person', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) );
		$sel    = array_map( 'intval', (array) get_post_meta( $post->ID, '_pp_people', true ) );
		if ( ! $people ) { echo '<p>No people yet. <a href="' . esc_url( admin_url( 'post-new.php?post_type=pp_person' ) ) . '">Add a person</a> first.</p>'; return; }
		foreach ( $people as $p ) printf( '<label style="display:block;margin:4px 0"><input type="checkbox" name="pp_people[]" value="%d" %s> %s</label>', (int) $p->ID, checked( in_array( (int) $p->ID, $sel, true ), true, false ), esc_html( $p->post_title ) );
		echo '<p class="description">Tick everyone who worked on this project. It shows on the project page and can be filtered on the Work page.</p>';
	}, 'pp_project', 'side', 'default' );
} );

add_action( 'save_post_pp_person', function ( $id ) {
	if ( ! isset( $_POST['pp_person_nonce'] ) || ! wp_verify_nonce( $_POST['pp_person_nonce'], 'pp_person' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $id ) ) return;
	update_post_meta( $id, '_pp_role', sanitize_text_field( wp_unslash( $_POST['pp_role'] ?? '' ) ) );
	update_post_meta( $id, '_pp_tagline', sanitize_text_field( wp_unslash( $_POST['pp_tagline'] ?? '' ) ) );
	update_post_meta( $id, '_pp_email', sanitize_email( wp_unslash( $_POST['pp_email'] ?? '' ) ) );
	update_post_meta( $id, '_pp_photo_id', absint( $_POST['pp_photo_id'] ?? 0 ) );
	$rep = isset( $_POST['pp_rep'] ) && is_array( $_POST['pp_rep'] ) ? $_POST['pp_rep'] : array();
	foreach ( array_keys( pp_rep_defs() ) as $key ) {
		$raw = json_decode( wp_unslash( $rep[ $key ] ?? '[]' ), true );
		update_post_meta( $id, $key, pp_rep_sanitize( $key, $raw ) );
	}
} );

add_action( 'save_post_pp_project', function ( $id ) {
	if ( ! isset( $_POST['pp_project_people_nonce'] ) || ! wp_verify_nonce( $_POST['pp_project_people_nonce'], 'pp_project_people' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $id ) ) return;
	$ids = isset( $_POST['pp_people'] ) && is_array( $_POST['pp_people'] ) ? array_values( array_filter( array_map( 'absint', $_POST['pp_people'] ) ) ) : array();
	update_post_meta( $id, '_pp_people', $ids );
}, 12 );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	$screen = get_current_screen();
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) && $screen && $screen->post_type === 'pp_person' ) wp_enqueue_media();
} );

/* ---------- Admin repeater UI ---------- */
add_action( 'admin_print_footer_scripts', function () {
	$screen = get_current_screen();
	if ( ! $screen ) return;
	$is_person = $screen->post_type === 'pp_person' && $screen->base === 'post';
	if ( ! $is_person && $screen->id !== 'appearance_page_pp-settings' ) return; ?>
<style>
.pp-rep .pp-row{border:1px solid #c3c4c7;background:#fff;margin:0 0 10px;border-radius:4px}
.pp-rep .pp-row-head{display:flex;justify-content:space-between;padding:6px 12px;background:#f6f7f7;border-bottom:1px solid #dcdcde}
.pp-rep .pp-row-head .button-link{margin-left:10px}
.pp-rep .pp-row-head .del{color:#b32d2e}
.pp-rep .pp-row-body{padding:8px 12px}
.pp-rep .pp-thumbs img{width:120px;height:80px;object-fit:cover;border:1px solid #dcdcde;display:block;margin:4px 0}
</style>
<script>
jQuery(function ($) {
	function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }
	function attr(s) { return esc(s).replace(/"/g, '&quot;'); }
	function Repeater(cfg) {
		var $root = $(cfg.root), $in = $(cfg.input), data = cfg.data || [], fields = cfg.fields;
		function sync() { $in.val(JSON.stringify(data)); }
		function blank() { var o = {}; fields.forEach(function (f) { o[f.k] = f.type === 'media' ? null : ''; }); return o; }
		function field(row, f) {
			var w = $('<p></p>');
			if (f.type === 'media') {
				w.append('<strong>' + esc(f.label) + '</strong><br>');
				var m = row[f.k];
				var th = $('<div class="pp-thumbs"></div>');
				if (m && m.url) th.append((m.mime || '').indexOf('image') === 0 ? '<img src="' + attr(m.url) + '" alt="">' : '<code>' + esc(m.name) + '</code>');
				var b = $('<button type="button" class="button">Select image</button>'), c = $('<button type="button" class="button-link" style="margin-left:8px">Remove</button>');
				b.on('click', function (e) {
					e.preventDefault();
					var fr = wp.media({ title: 'Select image', multiple: false, library: { type: 'image' } });
					fr.on('select', function () { var a = fr.state().get('selection').first().toJSON(); row[f.k] = { id: a.id, url: (a.sizes && a.sizes.medium ? a.sizes.medium.url : a.url), mime: a.mime, name: a.filename }; render(); });
					fr.open();
				});
				c.on('click', function () { row[f.k] = null; render(); });
				return w.append(th, b, c);
			}
			var tag = f.type === 'textarea' ? '<textarea class="widefat" rows="3"></textarea>' : '<input type="' + (f.type === 'url' ? 'url' : 'text') + '" class="widefat">';
			var lab = $('<label>' + esc(f.label) + '<br></label>'), inp = $(tag);
			if (f.ph) inp.attr('placeholder', f.ph);
			inp.val(row[f.k] || '').on('input', function () { row[f.k] = this.value; sync(); });
			return w.append(lab.append(inp));
		}
		function card(row, i) {
			var el = $('<div class="pp-row"></div>');
			el.append('<div class="pp-row-head"><strong>#' + (i + 1) + '</strong><span><button type="button" class="button-link up">↑</button><button type="button" class="button-link down">↓</button><button type="button" class="button-link del">Remove</button></span></div>');
			var body = $('<div class="pp-row-body"></div>').appendTo(el);
			fields.forEach(function (f) { body.append(field(row, f)); });
			el.find('.up').on('click', function () { if (i > 0) { data.splice(i - 1, 0, data.splice(i, 1)[0]); render(); } });
			el.find('.down').on('click', function () { if (i < data.length - 1) { data.splice(i + 1, 0, data.splice(i, 1)[0]); render(); } });
			el.find('.del').on('click', function () { data.splice(i, 1); render(); });
			return el;
		}
		function render() {
			$root.empty();
			data.forEach(function (r, i) { $root.append(card(r, i)); });
			var add = $('<button type="button" class="button button-primary">' + esc(cfg.add) + '</button>');
			add.on('click', function () { data.push(blank()); render(); });
			$root.append(add); sync();
		}
		$('#post').on('submit', sync);
		render();
	}
	(window.ppRep || []).forEach(function (c) { Repeater(c); });
});
</script>
<?php } );

/* =========================================================
 * Data getters
 * ========================================================= */
function pp_get_people() {
	static $cache = null;
	if ( $cache !== null ) return $cache;
	$posts = get_posts( array( 'post_type' => 'pp_person', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) );
	$out   = array();
	foreach ( $posts as $p ) {
		$id    = $p->ID;
		$pid   = (int) get_post_meta( $id, '_pp_photo_id', true );
		$photo = $pid ? wp_get_attachment_image_url( $pid, 'large' ) : get_the_post_thumbnail_url( $id, 'large' );
		$certs = array();
		foreach ( (array) get_post_meta( $id, '_pp_certs', true ) as $c ) {
			$iid = (int) ( $c['image'] ?? 0 );
			$certs[] = array(
				'title' => $c['title'] ?? '', 'issuer' => $c['issuer'] ?? '', 'date' => $c['date'] ?? '', 'link' => $c['link'] ?? '',
				'full'  => $iid ? (string) wp_get_attachment_image_url( $iid, 'full' ) : '',
				'thumb' => $iid ? (string) wp_get_attachment_image_url( $iid, 'large' ) : '',
			);
		}
		$out[] = array(
			'id' => $id, 'name' => get_the_title( $id ), 'slug' => $p->post_name, 'first' => strtok( get_the_title( $id ), ' ' ),
			'role' => (string) get_post_meta( $id, '_pp_role', true ), 'tagline' => (string) get_post_meta( $id, '_pp_tagline', true ),
			'email' => (string) get_post_meta( $id, '_pp_email', true ), 'photo' => (string) $photo,
			'about' => apply_filters( 'the_content', $p->post_content ),
			'offers' => array_values( array_filter( (array) get_post_meta( $id, '_pp_offers', true ) ) ),
			'links'  => array_values( array_filter( (array) get_post_meta( $id, '_pp_links', true ) ) ),
			'certs'  => $certs,
		);
	}
	return $cache = $out;
}

/** People tied to one project: array of id, name, slug. */
function pp_project_people( $project_id ) {
	$ids = array_map( 'intval', (array) get_post_meta( $project_id, '_pp_people', true ) );
	if ( ! $ids ) return array();
	$out = array();
	foreach ( pp_get_people() as $p ) {
		if ( in_array( (int) $p['id'], $ids, true ) ) $out[] = array( 'id' => $p['id'], 'name' => $p['name'], 'slug' => $p['slug'] );
	}
	return $out;
}
