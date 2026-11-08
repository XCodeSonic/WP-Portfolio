<?php
/**
 * Front-end promo popup for pro theme upgrade.
 *
 * Shown bottom-right on the front end to super admins only.
 * Closing it hides it for 3 days per user (persisted via user meta).
 *
 * @package Freelancer_Design_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FREELANCER_DESIGN_PORTFOLIO_POPUP_META_KEY', 'freelancer_design_portfolio_popup_dismissed' );
define( 'FREELANCER_DESIGN_PORTFOLIO_POPUP_NONCE', 'freelancer_design_portfolio_popup_dismiss' );
define( 'FREELANCER_DESIGN_PORTFOLIO_POPUP_SNOOZE', 3 * DAY_IN_SECONDS );

/**
 * Whether the popup should render for the current request.
 */
function freelancer_design_portfolio_popup_should_show() {
	if ( is_admin() || ! is_user_logged_in() || ! is_super_admin() ) {
		return false;
	}

	$dismissed = (int) get_user_meta( get_current_user_id(), FREELANCER_DESIGN_PORTFOLIO_POPUP_META_KEY, true );

	return ( time() - $dismissed ) >= FREELANCER_DESIGN_PORTFOLIO_POPUP_SNOOZE;
}

/**
 * Render popup in the front-end footer.
 */
function freelancer_design_portfolio_frontend_promo_popup() {

	if ( ! freelancer_design_portfolio_popup_should_show() ) {
		return;
	}

	$logo_url = get_theme_file_uri( '/assets/images/admin-banner/scintillawp-logo-white.webp' );
	$buy_url  = 'https://scintillawpthemes.com/product/freelancer-wordpress-theme/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_frontend_popup';
	$demo_url = 'https://scintillawpthemes.com/demo/freelancer-design-portfolio-pro/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_frontend_popup';
	$nonce    = wp_create_nonce( FREELANCER_DESIGN_PORTFOLIO_POPUP_NONCE );
	?>
	<div class="freelancer-design-portfolio-popup" role="dialog" aria-labelledby="freelancer-design-portfolio-popup-title" data-nonce="<?php echo esc_attr( $nonce ); ?>">
		<div class="freelancer-design-portfolio-popup__inner">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'ScintillaWP', 'freelancer-design-portfolio' ); ?>" class="freelancer-design-portfolio-popup__logo" />
			<h2 id="freelancer-design-portfolio-popup-title" class="freelancer-design-portfolio-popup__title"><?php esc_html_e( 'Upgrade to Freelancer Design Portfolio Pro', 'freelancer-design-portfolio' ); ?></h2>
			<p class="freelancer-design-portfolio-popup__text"><?php esc_html_e( 'Unlock premium designs, powerful features, exclusive layouts, and priority support to build better websites with ease.', 'freelancer-design-portfolio' ); ?></p>
			<div class="freelancer-design-portfolio-popup__actions">
				<a href="<?php echo esc_url( $buy_url ); ?>" class="freelancer-design-portfolio-popup__btn freelancer-design-portfolio-popup__btn--buy" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Buy Now', 'freelancer-design-portfolio' ); ?></a>
				<a href="<?php echo esc_url( $demo_url ); ?>" class="freelancer-design-portfolio-popup__btn freelancer-design-portfolio-popup__btn--demo" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View Demo', 'freelancer-design-portfolio' ); ?></a>
			</div>
		</div>
		<button type="button" class="freelancer-design-portfolio-popup__close" aria-label="<?php esc_attr_e( 'Close', 'freelancer-design-portfolio' ); ?>">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php
}
add_action( 'wp_footer', 'freelancer_design_portfolio_frontend_promo_popup' );

/**
 * Enqueue popup CSS + JS on the front end.
 */
function freelancer_design_portfolio_frontend_promo_popup_assets() {

	if ( ! freelancer_design_portfolio_popup_should_show() ) {
		return;
	}

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'freelancer-design-portfolio-popup',
		get_theme_file_uri( '/assets/css/admin-promo-frontend-popup.css' ),
		array(),
		$version
	);

	wp_enqueue_script(
		'freelancer-design-portfolio-popup',
		get_theme_file_uri( '/assets/js/admin-promo-frontend-popup.js' ),
		array(),
		$version,
		true
	);

	wp_localize_script(
		'freelancer-design-portfolio-popup',
		'FreelancerDesignPortfolioPopup',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'action'  => 'freelancer_design_portfolio_dismiss_popup',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'freelancer_design_portfolio_frontend_promo_popup_assets' );

/**
 * AJAX handler: snooze the popup for the current user.
 */
function freelancer_design_portfolio_dismiss_popup_handler() {

	if ( ! is_super_admin() ) {
		wp_send_json_error( array( 'message' => 'forbidden' ), 403 );
	}

	check_ajax_referer( FREELANCER_DESIGN_PORTFOLIO_POPUP_NONCE, 'nonce' );

	update_user_meta( get_current_user_id(), FREELANCER_DESIGN_PORTFOLIO_POPUP_META_KEY, time() );

	wp_send_json_success();
}
add_action( 'wp_ajax_freelancer_design_portfolio_dismiss_popup', 'freelancer_design_portfolio_dismiss_popup_handler' );
