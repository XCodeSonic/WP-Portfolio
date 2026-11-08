<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
 * Project page builder: header fields + flexible blocks
 * ========================================================= */

function pp_block_types() {
	return array(
		'laptop'    => 'Laptop screen (image or video)',
		'screen'    => 'Big screen (image or video, no frame)',
		'fullwidth' => 'Full-width picture',
		'mobiles'   => 'Phone screens (2–3 photos)',
		'photos'    => 'Photo row (2–3 photos)',
		'text'      => 'Text',
		'details'   => 'Details list (tech stack, equipment, credits…)',
	);
}

function pp_get_blocks( $post_id ) {
	$b = get_post_meta( $post_id, '_pp_blocks', true );
	return is_array( $b ) ? $b : array();
}

function pp_media_info( $id ) {
	$id = (int) $id;
	if ( ! $id ) return null;
	$url = wp_attachment_is_image( $id ) ? ( wp_get_attachment_image_url( $id, 'medium' ) ?: wp_get_attachment_url( $id ) ) : wp_get_attachment_url( $id );
	return array( 'id' => $id, 'url' => (string) $url, 'mime' => (string) get_post_mime_type( $id ), 'name' => basename( (string) get_attached_file( $id ) ) );
}

function pp_blocks_for_admin( $post_id ) {
	$out = array();
	foreach ( pp_get_blocks( $post_id ) as $b ) {
		$m = array();
		foreach ( (array) ( $b['media'] ?? array() ) as $mid ) { if ( $i = pp_media_info( $mid ) ) $m[] = $i; }
		$b['media'] = $m;
		$out[] = $b;
	}
	return $out;
}

function pp_sanitize_blocks( $raw ) {
	$types = array_keys( pp_block_types() );
	$out   = array();
	if ( ! is_array( $raw ) ) return $out;
	foreach ( array_slice( $raw, 0, 60 ) as $b ) {
		if ( ! is_array( $b ) || empty( $b['type'] ) || ! in_array( $b['type'], $types, true ) ) continue;
		$media = array();
		if ( ! empty( $b['media'] ) && is_array( $b['media'] ) ) {
			foreach ( $b['media'] as $m ) {
				$mid = is_array( $m ) ? (int) ( $m['id'] ?? 0 ) : (int) $m;
				if ( $mid > 0 && get_post( $mid ) ) $media[] = $mid;
			}
		}
		$cols = array();
		if ( ! empty( $b['cols'] ) && is_array( $b['cols'] ) ) {
			foreach ( array_slice( $b['cols'], 0, 3 ) as $c ) {
				$cols[] = array( 'label' => sanitize_text_field( $c['label'] ?? '' ), 'items' => sanitize_textarea_field( $c['items'] ?? '' ) );
			}
		}
		$bg = sanitize_hex_color( $b['bg'] ?? '' );
		$out[] = array(
			'type'    => $b['type'],
			'media'   => $media,
			'bg'      => $bg ? $bg : '',
			'overlay' => empty( $b['overlay'] ) ? 0 : 1,
			'text'    => sanitize_text_field( $b['text'] ?? '' ),
			'label'   => sanitize_text_field( $b['label'] ?? '' ),
			'heading' => sanitize_text_field( $b['heading'] ?? '' ),
			'body'    => sanitize_textarea_field( $b['body'] ?? '' ),
			'cols'    => $cols,
		);
	}
	return $out;
}

/* ---------- Meta boxes ---------- */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'pp_case_header', 'Project page — header', function ( $post ) {
		echo '<p><strong>Cover image</strong> — the big picture under the project title.<br>';
		pp_media_field( 'pp_cover_id', (int) get_post_meta( $post->ID, '_pp_cover_id', true ), 'image', 'Select cover image' );
		echo '</p>';
		printf( '<p><label><strong>Credits</strong> (one per line, e.g. "Design: Jane Doe")<br><textarea name="pp_credits" rows="4" class="widefat">%s</textarea></label></p>', esc_textarea( get_post_meta( $post->ID, '_pp_credits', true ) ) );
		echo '<p class="description">Role / Services come from the Project types, Location &amp; Year from “Project details”, and the “Live site” button from the External link.</p>';
	}, 'pp_project', 'normal', 'default' );

	add_meta_box( 'pp_blocks', 'Project page — content blocks (images, videos, text, tech stack…)', function ( $post ) {
		wp_nonce_field( 'pp_blocks', 'pp_blocks_nonce' );
		echo '<div id="pp-blocks-list"></div>';
		echo '<p class="pp-add"><select id="pp-add-type">';
		foreach ( pp_block_types() as $k => $label ) printf( '<option value="%s">%s</option>', esc_attr( $k ), esc_html( $label ) );
		echo '</select> <button type="button" class="button button-primary" id="pp-add">+ Add block</button></p>';
		echo '<input type="hidden" name="pp_blocks_json" id="pp-blocks-json" value="">';
		echo '<p class="description">Blocks appear on the project page in this order. Anything you write in the main editor above is shown as an intro text before the blocks.</p>';
		echo '<script>window.ppBlocksData=' . wp_json_encode( pp_blocks_for_admin( $post->ID ) ) . ';window.ppBlockTypes=' . wp_json_encode( pp_block_types() ) . ';</script>';
	}, 'pp_project', 'normal', 'default' );
} );

add_action( 'save_post_pp_project', function ( $id ) {
	if ( ! isset( $_POST['pp_blocks_nonce'] ) || ! wp_verify_nonce( $_POST['pp_blocks_nonce'], 'pp_blocks' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $id ) ) return;
	$raw = json_decode( wp_unslash( $_POST['pp_blocks_json'] ?? '[]' ), true );
	update_post_meta( $id, '_pp_blocks', pp_sanitize_blocks( $raw ) );
	update_post_meta( $id, '_pp_cover_id', absint( $_POST['pp_cover_id'] ?? 0 ) );
	update_post_meta( $id, '_pp_credits', sanitize_textarea_field( wp_unslash( $_POST['pp_credits'] ?? '' ) ) );
}, 11 );

/* ---------- Admin builder UI ---------- */
add_action( 'admin_print_footer_scripts', function () {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'pp_project' || $screen->base !== 'post' ) return; ?>
<style>
#pp-blocks-list .pp-block{border:1px solid #c3c4c7;background:#fff;margin:0 0 12px;border-radius:4px}
#pp-blocks-list .pp-block-head{display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#f6f7f7;border-bottom:1px solid #dcdcde}
#pp-blocks-list .pp-block-head .button-link{margin-left:10px}
#pp-blocks-list .pp-block-head .del{color:#b32d2e}
#pp-blocks-list .pp-block-body{padding:10px 12px}
#pp-blocks-list .pp-thumbs{display:flex;flex-wrap:wrap;gap:8px;margin:6px 0}
#pp-blocks-list .pp-thumbs img{width:110px;height:70px;object-fit:cover;border:1px solid #dcdcde}
#pp-blocks-list .pp-vid{display:inline-block;padding:6px 10px;background:#f0f0f1;border:1px solid #dcdcde}
#pp-blocks-list .pp-cols{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
</style>
<script>
jQuery(function ($) {
	var TYPES = window.ppBlockTypes || {}, data = window.ppBlocksData || [];
	var $list = $('#pp-blocks-list'), $json = $('#pp-blocks-json');
	function blank(t) { return { type: t, media: [], bg: '', overlay: 0, text: '', label: '', heading: '', body: '', cols: [{label:'',items:''},{label:'',items:''},{label:'',items:''}] }; }
	function norm(b) { var n = $.extend(blank(b.type), b); while (n.cols.length < 3) n.cols.push({label:'',items:''}); return n; }
	function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }
	function attr(s) { return esc(s).replace(/"/g, '&quot;'); }
	function sync() { $json.val(JSON.stringify(data)); }

	function textField(b, k, label) {
		var p = $('<p><label>' + esc(label) + '<br><input type="text" class="widefat" value="' + attr(b[k]) + '"></label></p>');
		p.find('input').on('input', function () { b[k] = this.value; sync(); }); return p;
	}
	function areaField(b, k, label, rows) {
		var p = $('<p><label>' + esc(label) + '<br><textarea class="widefat" rows="' + (rows || 4) + '">' + esc(b[k]) + '</textarea></label></p>');
		p.find('textarea').on('input', function () { b[k] = this.value; sync(); }); return p;
	}
	function checkField(b, k, label) {
		var p = $('<p><label><input type="checkbox"' + (b[k] ? ' checked' : '') + '> ' + esc(label) + '</label></p>');
		p.find('input').on('change', function () { b[k] = this.checked ? 1 : 0; sync(); }); return p;
	}
	function colorField(b) {
		var p = $('<p><label>Background color (optional) <input type="color" value="' + attr(b.bg || '#e0d9d1') + '"></label> <span class="state">' + (b.bg ? '' : '(none)') + '</span> <button type="button" class="button-link clr">clear</button></p>');
		p.find('input').on('input', function () { b.bg = this.value; p.find('.state').text(''); sync(); });
		p.find('.clr').on('click', function () { b.bg = ''; p.find('.state').text('(none)'); sync(); });
		return p;
	}
	function mediaField(b, multi) {
		var p = $('<div class="pp-media-field"></div>');
		var th = $('<div class="pp-thumbs"></div>');
		(b.media || []).forEach(function (m) {
			th.append((m.mime || '').indexOf('video') === 0 ? '<span class="pp-vid">▶ ' + esc(m.name) + '</span>' : '<img src="' + attr(m.url) + '" alt="">');
		});
		var btn = $('<button type="button" class="button">' + (multi ? 'Select photos (2–3)' : 'Select image or video') + '</button>');
		var clr = $('<button type="button" class="button-link" style="margin-left:8px">Remove</button>');
		btn.on('click', function (e) {
			e.preventDefault();
			var frame = wp.media({ title: 'Select media', multiple: multi ? 'add' : false, library: { type: multi ? 'image' : ['image', 'video'] } });
			frame.on('select', function () {
				var sel = frame.state().get('selection').toJSON();
				b.media = sel.slice(0, multi ? 3 : 1).map(function (a) {
					return { id: a.id, url: (a.sizes && a.sizes.medium ? a.sizes.medium.url : a.url), mime: a.mime, name: a.filename };
				});
				render();
			});
			frame.open();
		});
		clr.on('click', function () { b.media = []; render(); });
		return p.append(th, btn, clr);
	}
	function colField(b, c) {
		var col = b.cols[c];
		var w = $('<div><p><strong>Column ' + (c + 1) + '</strong></p><p><label>Title<br><input type="text" class="widefat" value="' + attr(col.label) + '" placeholder="Tech stack"></label></p><p><label>Items (one per line)<br><textarea class="widefat" rows="5" placeholder="WordPress&#10;GSAP&#10;Figma">' + esc(col.items) + '</textarea></label></p></div>');
		w.find('input').on('input', function () { col.label = this.value; sync(); });
		w.find('textarea').on('input', function () { col.items = this.value; sync(); });
		return w;
	}

	function card(b, i) {
		var el = $('<div class="pp-block"></div>');
		el.append('<div class="pp-block-head"><strong>' + (i + 1) + '. ' + esc(TYPES[b.type] || b.type) + '</strong><span><button type="button" class="button-link up">↑ Up</button><button type="button" class="button-link down">↓ Down</button><button type="button" class="button-link del">Remove</button></span></div>');
		var body = $('<div class="pp-block-body"></div>').appendTo(el), t = b.type;
		if (t === 'laptop' || t === 'screen' || t === 'fullwidth') body.append(mediaField(b, false));
		if (t === 'mobiles' || t === 'photos') body.append(mediaField(b, true));
		if (t === 'fullwidth') { body.append(checkField(b, 'overlay', 'Dark overlay on the picture')); body.append(textField(b, 'text', 'Big text on the picture (optional)')); }
		if (t === 'laptop' || t === 'screen' || t === 'mobiles' || t === 'photos') body.append(colorField(b));
		if (t === 'text') { body.append(textField(b, 'label', 'Small label on the left (optional)')); body.append(textField(b, 'heading', 'Heading (optional)')); body.append(areaField(b, 'body', 'Text (blank line = new paragraph)', 6)); }
		if (t === 'details') { var g = $('<div class="pp-cols"></div>'); for (var c = 0; c < 3; c++) g.append(colField(b, c)); body.append(g); }
		el.find('.up').on('click', function () { if (i > 0) { data.splice(i - 1, 0, data.splice(i, 1)[0]); render(); } });
		el.find('.down').on('click', function () { if (i < data.length - 1) { data.splice(i + 1, 0, data.splice(i, 1)[0]); render(); } });
		el.find('.del').on('click', function () { if (confirm('Remove this block?')) { data.splice(i, 1); render(); } });
		return el;
	}
	function render() { $list.empty(); data.forEach(function (b, i) { $list.append(card(b, i)); }); sync(); }

	data = data.map(norm);
	$('#pp-add').on('click', function () { data.push(blank($('#pp-add-type').val())); render(); });
	$('#post').on('submit', sync);
	render();
});
</script>
<?php } );

/* =========================================================
 * Front-end rendering
 * ========================================================= */
function pp_media_html( $id, $speed = '' ) {
	$id = (int) $id;
	if ( ! $id ) return '';
	$mime = (string) get_post_mime_type( $id );
	if ( strpos( $mime, 'video' ) === 0 ) {
		return '<div class="overlay overlay-image playpauze"><video class="overlay" src="' . esc_url( wp_get_attachment_url( $id ) ) . '" loop muted playsinline preload="metadata" style="object-fit:cover"></video></div>';
	}
	$img = wp_get_attachment_image( $id, 'full', false, array( 'class' => 'overlay', 'loading' => 'lazy', 'style' => 'object-fit:cover;width:100%;height:100%' ) );
	$data = $speed !== '' ? ' data-scroll data-scroll-speed="' . esc_attr( $speed ) . '"' : '';
	return '<div class="overlay overlay-image"' . $data . '>' . $img . '</div>';
}

function pp_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ), 'strlen' ) );
}

function pp_render_block( $b, $n ) {
	$bg    = ! empty( $b['bg'] ) ? ' style="background-color:' . esc_attr( $b['bg'] ) . '"' : '';
	$media = (array) ( $b['media'] ?? array() );
	$first = $media ? $media[0] : 0;
	switch ( $b['type'] ) {
		case 'laptop':
		case 'screen':
			if ( ! $first ) return;
			$laptop = $b['type'] === 'laptop';
			echo '<section class="section single-block block-device block_' . (int) $n . ( $laptop ? '' : ' block-padding-bottom' ) . '" data-scroll-section' . $bg . '>'; // phpcs:ignore
			echo '<div class="container"><div class="row ' . ( $laptop ? 'device-mbp15' : 'device-nodevice' ) . '"><div class="flex-col"><div class="device">';
			echo '<div class="single-image">' . pp_media_html( $first ) . '</div>'; // phpcs:ignore
			if ( $laptop ) echo '<div class="overlay-device-image"><div class="overlay overlay-device" style="background:url(\'' . esc_url( get_template_directory_uri() . '/assets/images/device-laptop.svg' ) . '\') center center no-repeat;background-size:100% 100%"></div></div>';
			echo '</div></div></div></div></section>';
			break;

		case 'fullwidth':
			if ( ! $first ) return;
			echo '<section class="section single-block block-fullwidth block_' . (int) $n . '" data-scroll-section' . $bg . '><div class="row"><div class="flex-col"><div class="single-image">'; // phpcs:ignore
			echo pp_media_html( $first, '-2' ); // phpcs:ignore
			if ( ! empty( $b['overlay'] ) ) echo '<div class="overlay dark-overlay"></div>';
			if ( ! empty( $b['text'] ) ) echo '<div class="overlay text-overlay"><h2>' . esc_html( $b['text'] ) . '</h2></div>';
			echo '</div></div></div></section>';
			break;

		case 'mobiles':
			if ( ! $media ) return;
			$media  = array_slice( $media, 0, 3 );
			$amount = count( $media ) >= 3 ? 3 : 2;
			echo '<section class="section single-block block-mobile-devices block_' . (int) $n . '" data-scroll-section' . $bg . '><div class="container no-padding block-padding-sides amount-' . (int) $amount . '"><div class="row device-nodevice">'; // phpcs:ignore
			foreach ( $media as $i => $mid ) {
				$sp = $i === 0 ? ' data-scroll data-scroll-target=".block_' . (int) $n . '" data-scroll-speed="1"' : ( $i === 2 ? ' data-scroll data-scroll-target=".block_' . (int) $n . '" data-scroll-speed="-1"' : '' );
				echo '<div class="flex-col block-padding-bottom"><div class="device"' . $sp . '><div class="single-image">' . pp_media_html( $mid ) . '</div></div></div>'; // phpcs:ignore
			}
			echo '</div></div></section>';
			break;

		case 'photos':
			if ( ! $media ) return;
			$media = array_slice( $media, 0, 3 );
			echo '<section class="section single-block block-photos block_' . (int) $n . '" data-scroll-section' . $bg . '><div class="container"><div class="photos-row amount-' . count( $media ) . '">'; // phpcs:ignore
			foreach ( $media as $mid ) echo '<div class="photo"><div class="single-image">' . pp_media_html( $mid ) . '</div></div>'; // phpcs:ignore
			echo '</div></div></section>';
			break;

		case 'text':
			if ( empty( $b['heading'] ) && empty( $b['body'] ) ) return;
			echo '<section class="section single-block block-text block_' . (int) $n . '" data-scroll-section><div class="container medium"><div class="row"><div class="flex-col text-label">'; // phpcs:ignore
			if ( ! empty( $b['label'] ) ) echo '<h5>' . esc_html( $b['label'] ) . '</h5><div class="stripe"></div>';
			echo '</div><div class="flex-col text-body">';
			if ( ! empty( $b['heading'] ) ) echo '<h2>' . esc_html( $b['heading'] ) . '</h2>';
			if ( ! empty( $b['body'] ) ) echo wpautop( esc_html( $b['body'] ) ); // phpcs:ignore
			echo '</div></div></div></section>';
			break;

		case 'details':
			$cols = array();
			foreach ( (array) ( $b['cols'] ?? array() ) as $c ) { if ( ! empty( $c['label'] ) || ! empty( $c['items'] ) ) $cols[] = $c; }
			if ( ! $cols ) return;
			echo '<section class="section case-intro single-block block-details block_' . (int) $n . '" data-scroll-section><div class="container medium"><div class="row">'; // phpcs:ignore
			foreach ( $cols as $c ) {
				echo '<div class="flex-col"><h5>' . esc_html( $c['label'] ) . '</h5><div class="stripe"></div>';
				foreach ( pp_lines( $c['items'] ) as $line ) echo '<li><p>' . esc_html( $line ) . '</p></li>';
				echo '</div>';
			}
			echo '</div></div></section>';
			break;
	}
}
