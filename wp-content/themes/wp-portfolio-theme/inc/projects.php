<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Post type + taxonomy ---------- */
add_action( 'init', function () {
	register_post_type( 'pp_project', array(
		'labels' => array( 'name' => 'Projects', 'singular_name' => 'Project', 'add_new_item' => 'Add new project', 'edit_item' => 'Edit project' ),
		'public' => true, 'has_archive' => 'work', 'rewrite' => array( 'slug' => 'work' ),
		'menu_icon' => 'dashicons-portfolio', 'menu_position' => 5, 'show_in_rest' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies' => array( 'pp_type' ),
	) );
	register_taxonomy( 'pp_type', 'pp_project', array(
		'labels' => array( 'name' => 'Project types', 'singular_name' => 'Project type', 'add_new_item' => 'Add project type', 'menu_name' => 'Project types' ),
		'hierarchical' => true, 'show_admin_column' => true, 'show_in_rest' => true, 'rewrite' => array( 'slug' => 'work-type' ),
	) );
	if ( ! get_option( 'pp_default_types' ) ) {
		foreach ( array( 'Design', 'Development', 'Interaction', 'Branding', 'Video' ) as $t ) {
			if ( ! term_exists( $t, 'pp_type' ) ) wp_insert_term( $t, 'pp_type' );
		}
		update_option( 'pp_default_types', 1 );
	}
} );

add_action( 'init', function () {
	$v = wp_get_theme()->get( 'Version' ) . '-5';
	if ( get_option( 'pp_rewrite_version' ) !== $v ) {
		flush_rewrite_rules( false );
		update_option( 'pp_rewrite_version', $v );
	}
}, 99 );

/* ---------- Meta box ---------- */
function pp_media_field( $name, $id, $type, $button ) {
	$thumb = '';
	if ( $id ) {
		$thumb = ( $type === 'image' )
			? wp_get_attachment_image( $id, 'thumbnail', false, array( 'style' => 'max-width:150px;height:auto;display:block;margin-bottom:6px' ) )
			: '<code>' . esc_html( basename( get_attached_file( $id ) ) ) . '</code>';
	}
	printf(
		'<div class="pp-media" data-type="%1$s"><input type="hidden" name="%2$s" value="%3$s"><div class="pp-media-thumb">%4$s</div><button type="button" class="button pp-media-pick">%5$s</button> <button type="button" class="button-link pp-media-clear" style="margin-left:8px">Remove</button></div>',
		esc_attr( $type ), esc_attr( $name ), esc_attr( $id ), $thumb, esc_html( $button )
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'pp_project_meta', 'Project details (homepage list, hover preview & tile)', function ( $post ) {
		wp_nonce_field( 'pp_project_meta', 'pp_project_nonce' );
		$feat = get_post_meta( $post->ID, '_pp_featured', true ) === '1';
		$arch = get_post_meta( $post->ID, '_pp_archived', true ) === '1';
		printf( '<p><label><input type="checkbox" name="pp_featured" value="1" %s> <strong>Featured</strong> — show this project on the homepage</label><br><label><input type="checkbox" name="pp_archived" value="1" %s> <strong>Archived</strong> — hide from the Work page and homepage, list it on the Archive page only</label></p><hr>', checked( $feat, true, false ), checked( $arch, true, false ) );
		echo '<p><strong>Preview image</strong> — shown in the hover preview and the homepage tile. Your project page can still have as many images or videos as you like in the editor above.<br>';
		pp_media_field( 'pp_preview_id', (int) get_post_meta( $post->ID, '_pp_preview_id', true ), 'image', 'Select preview image' );
		echo '</p><p><strong>Preview video</strong> (optional, mp4) — plays in the hover preview instead of the image.<br>';
		pp_media_field( 'pp_preview_video_id', (int) get_post_meta( $post->ID, '_pp_preview_video_id', true ), 'video', 'Select preview video' );
		echo '</p>';
		printf( '<p><label><strong>Year</strong> (leave empty to use the publish year)<br><input type="text" name="pp_year" class="regular-text" value="%s" placeholder="2025"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_year', true ) ) );
		printf( '<p><label><strong>Location</strong> (e.g. Manila, Philippines)<br><input type="text" name="pp_location" class="regular-text" value="%s"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_location', true ) ) );
		printf( '<p><label><strong>External link</strong> (optional — Archive page opens this instead of a project page)<br><input type="url" name="pp_url" class="regular-text" value="%s" placeholder="https://"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_url', true ) ) );
		printf( '<p><label><strong>Custom type label</strong> (optional — overrides the Project types checkboxes, e.g. "Brand identity &amp; web")<br><input type="text" name="pp_label" class="regular-text" value="%s"></label></p>', esc_attr( get_post_meta( $post->ID, '_pp_label', true ) ) );
	}, 'pp_project', 'normal', 'high' );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	$screen = get_current_screen();
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) && $screen && $screen->post_type === 'pp_project' ) wp_enqueue_media();
} );

add_action( 'admin_print_footer_scripts', function () {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'pp_project' || $screen->base !== 'post' ) return; ?>
<script>
jQuery(function ($) {
	$('.pp-media').each(function () {
		var box = $(this), type = box.data('type');
		box.find('.pp-media-pick').on('click', function (e) {
			e.preventDefault();
			var frame = wp.media({ title: 'Select ' + type, library: { type: type }, multiple: false });
			frame.on('select', function () {
				var a = frame.state().get('selection').first().toJSON();
				box.find('input').val(a.id);
				box.find('.pp-media-thumb').html(type === 'image'
					? '<img src="' + (a.sizes && a.sizes.thumbnail ? a.sizes.thumbnail.url : a.url) + '" style="max-width:150px;height:auto;display:block;margin-bottom:6px">'
					: '<code>' + a.filename + '</code>');
			});
			frame.open();
		});
		box.find('.pp-media-clear').on('click', function (e) { e.preventDefault(); box.find('input').val(''); box.find('.pp-media-thumb').empty(); });
	});
});
</script>
<?php } );

add_action( 'save_post_pp_project', function ( $id ) {
	if ( ! isset( $_POST['pp_project_nonce'] ) || ! wp_verify_nonce( $_POST['pp_project_nonce'], 'pp_project_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $id ) ) return;
	update_post_meta( $id, '_pp_featured', isset( $_POST['pp_featured'] ) ? '1' : '0' );
	update_post_meta( $id, '_pp_archived', isset( $_POST['pp_archived'] ) ? '1' : '0' );
	update_post_meta( $id, '_pp_location', sanitize_text_field( wp_unslash( $_POST['pp_location'] ?? '' ) ) );
	update_post_meta( $id, '_pp_url', esc_url_raw( wp_unslash( $_POST['pp_url'] ?? '' ) ) );
	update_post_meta( $id, '_pp_year', sanitize_text_field( wp_unslash( $_POST['pp_year'] ?? '' ) ) );
	update_post_meta( $id, '_pp_label', sanitize_text_field( wp_unslash( $_POST['pp_label'] ?? '' ) ) );
	update_post_meta( $id, '_pp_preview_id', absint( $_POST['pp_preview_id'] ?? 0 ) );
	update_post_meta( $id, '_pp_preview_video_id', absint( $_POST['pp_preview_video_id'] ?? 0 ) );
} );

/* ---------- Helpers ---------- */
function pp_project_image( $post_id ) {
	$pid = (int) get_post_meta( $post_id, '_pp_preview_id', true );
	if ( $pid && ( $u = wp_get_attachment_image_url( $pid, 'large' ) ) ) return $u;
	if ( $u = get_the_post_thumbnail_url( $post_id, 'large' ) ) return $u;
	$content = get_post_field( 'post_content', $post_id );
	if ( preg_match( '/wp-image-(\d+)/', $content, $m ) && ( $u = wp_get_attachment_image_url( (int) $m[1], 'large' ) ) ) return $u;
	if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $m ) ) return $m[1];
	return get_template_directory_uri() . '/assets/images/placeholder-work-1.svg';
}

function pp_project_types( $post_id ) {
	$label = trim( (string) get_post_meta( $post_id, '_pp_label', true ) );
	if ( $label !== '' ) return $label;
	$names = wp_get_post_terms( $post_id, 'pp_type', array( 'fields' => 'names' ) );
	return ( ! is_wp_error( $names ) && $names ) ? implode( ' & ', $names ) : '';
}


/* ---------- Queries: featured (home) / work (not archived) / archive ---------- */
function pp_meta_query( $scope ) {
	$not_archived = array(
		'relation' => 'OR',
		array( 'key' => '_pp_archived', 'compare' => 'NOT EXISTS' ),
		array( 'key' => '_pp_archived', 'value' => '1', 'compare' => '!=' ),
	);
	if ( $scope === 'archive' ) return array( array( 'key' => '_pp_archived', 'value' => '1' ) );
	if ( $scope === 'featured' ) return array( 'relation' => 'AND', $not_archived, array( 'key' => '_pp_featured', 'value' => '1' ) );
	return array( $not_archived );
}

function pp_project_item( $id ) {
	$vid   = (int) get_post_meta( $id, '_pp_preview_video_id', true );
	$terms = wp_get_post_terms( $id, 'pp_type' );
	$types = array();
	if ( ! is_wp_error( $terms ) ) foreach ( $terms as $t ) $types[ $t->slug ] = $t->name;
	$ext = (string) get_post_meta( $id, '_pp_url', true );
	return array(
		'id'       => $id,
		'title'    => get_the_title( $id ),
		'url'      => get_permalink( $id ),
		'ext'      => $ext,
		'services' => pp_project_types( $id ),
		'year'     => get_post_meta( $id, '_pp_year', true ) ?: get_the_date( 'Y', $id ),
		'location' => (string) get_post_meta( $id, '_pp_location', true ),
		'img'      => pp_project_image( $id ),
		'video'    => $vid ? wp_get_attachment_url( $vid ) : '',
		'types'    => $types,
		'slugs'    => implode( ' ', array_keys( $types ) ),
		'people'   => function_exists( 'pp_project_people' ) ? pp_project_people( $id ) : array(),
	);
}

/** scope: featured | work | archive. Placeholders only when NO project exists yet (featured scope). */
function pp_get_projects( $scope = 'work', $limit = -1 ) {
	static $cache = array();
	$key = $scope . ':' . $limit;
	if ( isset( $cache[ $key ] ) ) return $cache[ $key ];
	$ids = get_posts( array(
		'post_type' => 'pp_project', 'post_status' => 'publish', 'posts_per_page' => $limit, 'fields' => 'ids', 'no_found_rows' => true,
		'meta_query' => pp_meta_query( $scope ), 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	) );
	$out = array();
	foreach ( $ids as $id ) $out[] = pp_project_item( $id );
	if ( ! $out && $scope === 'featured' && (int) wp_count_posts( 'pp_project' )->publish === 0 ) {
		$base = get_template_directory_uri() . '/assets/images/';
		foreach ( array( 'Project One', 'Project Two', 'Project Three', 'Project Four' ) as $i => $t ) {
			$out[] = array( 'id' => 0, 'title' => $t, 'url' => '#', 'ext' => '', 'services' => 'Add a project in the dashboard', 'year' => date( 'Y' ), 'location' => '', 'img' => $base . 'placeholder-work-' . ( $i + 1 ) . '.svg', 'video' => '', 'types' => array(), 'slugs' => '', 'people' => array() );
		}
	}
	return $cache[ $key ] = $out;
}

function pp_count( $scope ) {
	return count( pp_get_projects( $scope, -1 ) );
}

/** Which projects feed the floating hover preview on this page. */
function pp_hover_projects() {
	if ( is_front_page() ) return pp_get_projects( 'featured', 4 );
	if ( is_post_type_archive( 'pp_project' ) ) return pp_get_projects( 'work', -1 );
	return array();
}

/* ---------- /archive/ route ---------- */
add_action( 'init', function () {
	add_rewrite_rule( '^archive/?$', 'index.php?pp_archive=1', 'top' );
} );
add_filter( 'query_vars', function ( $v ) { $v[] = 'pp_archive'; return $v; } );
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) return;
	if ( $q->get( 'pp_archive' ) ) {
		$q->set( 'post_type', 'pp_project' );
		$q->set( 'posts_per_page', 1 );
	}
	if ( $q->is_post_type_archive( 'pp_project' ) || $q->is_tax( 'pp_type' ) ) {
		$q->set( 'posts_per_page', -1 );
		$q->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
	}
} );
add_filter( 'template_include', function ( $tpl ) {
	if ( get_query_var( 'pp_archive' ) ) {
		global $wp_query;
		$wp_query->is_404 = false;
		$wp_query->is_home = false;
		status_header( 200 );
		return get_theme_file_path( 'template-archive.php' );
	}
	return $tpl;
} );
add_filter( 'pre_get_document_title', function ( $t ) {
	return get_query_var( 'pp_archive' ) ? 'Archive – ' . get_bloginfo( 'name' ) : $t;
} );

/* ---------- Admin list columns ---------- */
add_filter( 'manage_pp_project_posts_columns', function ( $cols ) {
	$cols['pp_flags'] = 'Homepage / Archive';
	return $cols;
} );
add_action( 'manage_pp_project_posts_custom_column', function ( $col, $id ) {
	if ( $col !== 'pp_flags' ) return;
	$out = array();
	if ( get_post_meta( $id, '_pp_featured', true ) === '1' ) $out[] = '★ Featured';
	if ( get_post_meta( $id, '_pp_archived', true ) === '1' ) $out[] = 'Archived';
	echo esc_html( $out ? implode( ' · ', $out ) : '—' );
}, 10, 2 );
