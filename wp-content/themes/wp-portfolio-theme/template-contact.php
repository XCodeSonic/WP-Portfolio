<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$msg   = isset( $_GET['msg'] ) ? sanitize_key( wp_unslash( $_GET['msg'] ) ) : '';
$email = get_theme_mod( 'pp_email', '' );
$phone = get_theme_mod( 'pp_phone', '' );

$default_q = "What’s your name? | John Doe *\nWhat’s your email? | john@doe.com *\nWhat’s the name of your organization? | Your company\nWhat services are you looking for? | Web design, development …\nYour message | Hello, can you help me with … *";
$qs = array();
foreach ( array_values( array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", '', (string) get_theme_mod( 'pp_form_q', $default_q ) ) ) ), 'strlen' ) ) as $line ) {
	$parts = array_map( 'trim', explode( '|', $line, 2 ) );
	$qs[]  = array( $parts[0], $parts[1] ?? '' );
}
$defaults = array_map( function ( $l ) { return array_map( 'trim', explode( '|', $l, 2 ) ); }, explode( "\n", $default_q ) );
for ( $i = 0; $i < 5; $i++ ) if ( empty( $qs[ $i ] ) ) $qs[ $i ] = $defaults[ $i ];

$business = array_values( array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", '', (string) get_theme_mod( 'pp_business', "Your Organization\nLocation: Philippines" ) ) ) ), 'strlen' ) );
$notices = array(
	'sent'    => array( get_theme_mod( 'pp_form_thanks', 'Thank you! Your message has been sent. We will get back to you soon.' ), '' ),
	'invalid' => array( 'Please fill in your name, a valid email and a message.', ' error' ),
	'wait'    => array( 'Please wait a few seconds before sending another message.', ' error' ),
	'error'   => array( 'Something went wrong. Please try again.', ' error' ),
);
?>
<header class="section default-header contact-header theme-dark" data-scroll-section>
	<?php get_template_part( 'template-parts/nav-bar' ); ?>
	<div class="container medium">
		<div class="row once-in">
			<div class="flex-col">
				<h1><span><div class="profile-picture"></div> <?php echo esc_html( get_theme_mod( 'pp_contact_h1_a', 'Let’s start a' ) ); ?> </span><span><?php echo esc_html( get_theme_mod( 'pp_contact_h1_b', 'project together' ) ); ?></span></h1>
			</div>
			<div class="flex-col">
				<div class="profile-picture"></div>
				<div class="arrow"><?php echo pp_arrow(); // phpcs:ignore ?></div>
			</div>
		</div>
		<div class="row once-in">
			<div class="flex-col">
				<?php if ( isset( $notices[ $msg ] ) ) : ?>
					<p class="form-notice<?php echo esc_attr( $notices[ $msg ][1] ); ?>"><?php echo esc_html( $notices[ $msg ][0] ); ?></p>
				<?php endif; ?>
				<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="pp_contact">
					<?php wp_nonce_field( 'pp_contact', 'pp_contact_nonce' ); ?>
					<div class="website-field">
						<label class="label" for="form-tel">Phone Number</label>
						<input class="field" type="text" id="form-tel" name="tel" tabindex="-1" autocomplete="off">
					</div>
					<?php
					$fields = array( 'name' => 'text', 'email' => 'email', 'company' => 'text', 'service' => 'text', 'message' => 'textarea' );
					$n = 0;
					foreach ( $fields as $fname => $type ) :
						$n++;
						$q = $qs[ $n - 1 ];
						$req = in_array( $fname, array( 'name', 'email', 'message' ), true ) ? ' required' : '';
					?>
					<div class="form-col">
						<h5><?php echo esc_html( str_pad( (string) $n, 2, '0', STR_PAD_LEFT ) ); ?></h5>
						<label class="label" for="form-<?php echo esc_attr( $fname ); ?>"><?php echo esc_html( $q[0] ); ?></label>
						<?php if ( $type === 'textarea' ) : ?>
							<textarea class="field" id="form-<?php echo esc_attr( $fname ); ?>" name="<?php echo esc_attr( $fname ); ?>" rows="8"<?php echo $req; // phpcs:ignore ?> placeholder="<?php echo esc_attr( $q[1] ); ?>"></textarea>
						<?php else : ?>
							<input class="field" type="<?php echo esc_attr( $type ); ?>" id="form-<?php echo esc_attr( $fname ); ?>" name="<?php echo esc_attr( $fname ); ?>"<?php echo $req; // phpcs:ignore ?> placeholder="<?php echo esc_attr( $q[1] ); ?>">
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
					<div class="btn-contact-send">
						<div class="btn btn-round" data-scroll data-scroll-speed="2" data-scroll-offset="-50%, 0%">
							<div class="btn-click magnetic" data-strength="100" data-strength-text="50">
								<div class="btn-fill"></div>
								<span class="btn-text"><input type="submit" value="<?php echo esc_attr( get_theme_mod( 'pp_form_send', 'Send it!' ) ); ?>" class="form-btn"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="flex-col">
				<?php if ( $email || $phone ) : ?>
				<h5>Contact Details</h5>
				<ul class="links-wrap">
					<?php if ( $email ) : ?>
					<li class="btn btn-link btn-link-external"><a href="mailto:<?php echo esc_attr( $email ); ?>" class="btn-click magnetic" data-strength="20" data-strength-text="10"><span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( $email ); ?></span></span></a></li>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
					<li class="btn btn-link btn-link-external"><a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>" class="btn-click magnetic" data-strength="20" data-strength-text="10"><span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( $phone ); ?></span></span></a></li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>
				<?php if ( $business ) : ?>
				<h5>Organization Details</h5>
				<ul class="links-wrap plain">
					<?php foreach ( $business as $line ) echo '<li><p>' . esc_html( $line ) . '</p></li>'; ?>
				</ul>
				<?php endif; ?>
				<?php if ( pp_socials() ) : ?>
				<h5>Socials</h5>
				<ul class="links-wrap"><?php pp_render_socials(); ?></ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
<?php get_footer( 'contact' );
