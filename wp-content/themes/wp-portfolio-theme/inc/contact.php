<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
 * Contact page route, form handling, saved messages,
 * and the "Portfolio settings" screen (social links)
 * ========================================================= */

add_action( 'init', function () {
	add_rewrite_rule( '^contact/?$', 'index.php?pp_contact=1', 'top' );
	register_post_type( 'pp_message', array(
		'labels' => array( 'name' => 'Messages', 'singular_name' => 'Message', 'menu_name' => 'Messages', 'edit_item' => 'Message' ),
		'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-email', 'menu_position' => 7,
		'supports' => array( 'title' ), 'capability_type' => 'post', 'map_meta_cap' => true,
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
	) );
} );
add_filter( 'query_vars', function ( $v ) { $v[] = 'pp_contact'; return $v; } );
add_filter( 'template_include', function ( $tpl ) {
	if ( get_query_var( 'pp_contact' ) ) {
		global $wp_query;
		$wp_query->is_404  = false;
		$wp_query->is_home = false;
		status_header( 200 );
		return get_theme_file_path( 'template-contact.php' );
	}
	return $tpl;
} );
add_filter( 'pre_get_document_title', function ( $t ) {
	return get_query_var( 'pp_contact' ) ? 'Contact – ' . get_bloginfo( 'name' ) : $t;
} );

/* ---------- Form submit ---------- */
function pp_contact_redirect( $flag ) {
	wp_safe_redirect( add_query_arg( 'msg', $flag, home_url( '/contact/' ) ) );
	exit;
}

function pp_handle_contact() {
	if ( ! isset( $_POST['pp_contact_nonce'] ) || ! wp_verify_nonce( $_POST['pp_contact_nonce'], 'pp_contact' ) ) pp_contact_redirect( 'error' );
	if ( ! empty( $_POST['tel'] ) ) pp_contact_redirect( 'sent' ); // honeypot: pretend success

	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? preg_replace( '/[^0-9a-fA-F:.]/', '', wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'x';
	$key = 'pp_cf_' . md5( $ip );
	if ( get_transient( $key ) ) pp_contact_redirect( 'wait' );

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$company = sanitize_text_field( wp_unslash( $_POST['company'] ?? '' ) );
	$service = sanitize_text_field( wp_unslash( $_POST['service'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	if ( $name === '' || ! is_email( $email ) || $message === '' ) pp_contact_redirect( 'invalid' );

	set_transient( $key, 1, 30 );
	$id = wp_insert_post( array(
		'post_type' => 'pp_message', 'post_status' => 'publish',
		'post_title' => $name . ( $company ? ' — ' . $company : '' ), 'post_content' => $message,
		'meta_input' => array( '_pp_m_name' => $name, '_pp_m_email' => $email, '_pp_m_company' => $company, '_pp_m_service' => $service ),
	) );
	$to      = sanitize_email( (string) get_option( 'pp_contact_to', '' ) ) ?: get_option( 'admin_email' );
	$body    = "Name: $name\nEmail: $email\nOrganization: $company\nServices: $service\n\n$message\n";
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	wp_mail( $to, 'New message from ' . $name, $body, $headers );
	pp_contact_redirect( $id ? 'sent' : 'error' );
}
add_action( 'admin_post_nopriv_pp_contact', 'pp_handle_contact' );
add_action( 'admin_post_pp_contact', 'pp_handle_contact' );

/* ---------- Messages in the dashboard ---------- */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'pp_message_view', 'Message', function ( $post ) {
		$rows = array( 'Name' => '_pp_m_name', 'Email' => '_pp_m_email', 'Organization' => '_pp_m_company', 'Services' => '_pp_m_service' );
		echo '<table class="form-table"><tbody>';
		foreach ( $rows as $label => $k ) printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html( $label ), esc_html( get_post_meta( $post->ID, $k, true ) ) );
		printf( '<tr><th>Message</th><td>%s</td></tr>', nl2br( esc_html( $post->post_content ) ) );
		printf( '<tr><th>Received</th><td>%s</td></tr>', esc_html( get_the_date( 'F j, Y g:i a', $post ) ) );
		echo '</tbody></table>';
		$email = get_post_meta( $post->ID, '_pp_m_email', true );
		if ( $email ) printf( '<p><a class="button button-primary" href="mailto:%s">Reply by email</a></p>', esc_attr( $email ) );
	}, 'pp_message', 'normal', 'high' );
} );
add_filter( 'manage_pp_message_posts_columns', function ( $cols ) {
	return array( 'cb' => $cols['cb'], 'title' => 'From', 'pp_email' => 'Email', 'pp_service' => 'Services', 'date' => 'Date' );
} );
add_action( 'manage_pp_message_posts_custom_column', function ( $col, $id ) {
	if ( $col === 'pp_email' ) echo esc_html( get_post_meta( $id, '_pp_m_email', true ) );
	if ( $col === 'pp_service' ) echo esc_html( get_post_meta( $id, '_pp_m_service', true ) );
}, 10, 2 );

/* ---------- Portfolio settings (social links, mail address) ---------- */
add_action( 'admin_menu', function () {
	add_theme_page( 'Portfolio settings', 'Portfolio settings', 'manage_options', 'pp-settings', 'pp_settings_page' );
} );

function pp_sanitize_socials( $raw ) {
	if ( is_string( $raw ) ) $raw = json_decode( $raw, true );
	$out = array();
	if ( ! is_array( $raw ) ) return $out;
	foreach ( array_slice( $raw, 0, 30 ) as $r ) {
		if ( ! is_array( $r ) ) continue;
		$url   = esc_url_raw( (string) ( $r['url'] ?? '' ) );
		$label = sanitize_text_field( (string) ( $r['label'] ?? '' ) );
		if ( $url ) $out[] = array( 'label' => $label, 'url' => $url );
	}
	return $out;
}

add_action( 'admin_init', function () {
	register_setting( 'pp_settings', 'pp_socials', array( 'sanitize_callback' => 'pp_sanitize_socials', 'default' => array() ) );
	register_setting( 'pp_settings', 'pp_contact_to', array( 'sanitize_callback' => 'sanitize_email', 'default' => '' ) );
} );

function pp_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	$rows = get_option( 'pp_socials', array() );
	$rows = is_array( $rows ) ? $rows : array();
	?>
	<div class="wrap">
		<h1>Portfolio settings</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'pp_settings' ); ?>
			<h2>Social links</h2>
			<p>Add as many as you like. They appear in the footer, the full-screen menu and the Contact page, and open in a new tab.</p>
			<div id="pp-rep-socials" class="pp-rep"></div>
			<input type="hidden" name="pp_socials" id="pp-rep-socials-json" value="">
			<script>window.ppRep=window.ppRep||[];window.ppRep.push(<?php echo wp_json_encode( array( 'root' => '#pp-rep-socials', 'input' => '#pp-rep-socials-json', 'data' => $rows, 'add' => '+ Add a social link', 'fields' => array(
				array( 'k' => 'label', 'label' => 'Name (e.g. Instagram)', 'type' => 'text', 'ph' => 'Instagram' ),
				array( 'k' => 'url', 'label' => 'Link', 'type' => 'url', 'ph' => 'https://' ),
			) ) ); ?>);</script>
			<h2>Contact form</h2>
			<table class="form-table"><tr><th><label for="pp_contact_to">Send messages to</label></th>
				<td><input type="email" class="regular-text" id="pp_contact_to" name="pp_contact_to" value="<?php echo esc_attr( get_option( 'pp_contact_to', '' ) ); ?>" placeholder="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>">
				<p class="description">Leave empty to use the site admin email. Every message is also saved under <strong>Messages</strong> in the dashboard, so nothing is lost even if email is not set up (common on a local XAMPP site).</p></td></tr></table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
