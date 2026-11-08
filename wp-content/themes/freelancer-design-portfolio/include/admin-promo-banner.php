<?php
/**
 * Admin promo banner for pro theme upgrade.
 *
 * Shown on all admin screens.
 * Dismissed permanently per user (persisted via user meta).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FREELANCER_DESIGN_PORTFOLIOMO_META_KEY', 'freelancer_design_portfoliomo_dismissed' );
define( 'FREELANCER_DESIGN_PORTFOLIOMO_NONCE', 'freelancer_design_portfoliomo_dismiss' );

/**
 * Whether the banner has been dismissed by the current user.
 */
function freelancer_design_portfoliomo_is_dismissed() {
	return (bool) get_user_meta( get_current_user_id(), FREELANCER_DESIGN_PORTFOLIOMO_META_KEY, true );
}

/**
 * Render banner on all admin screens.
 */
function freelancer_design_portfolio_admin_promo_banner() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( freelancer_design_portfoliomo_is_dismissed() ) {
		return;
	}

	$logo_url = get_theme_file_uri( '/assets/images/admin-banner/scintillawp-logo-white.webp' );
	$buy_url  = 'https://scintillawpthemes.com/product/freelancer-wordpress-theme/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_admin_banner';
	$demo_url = 'https://scintillawpthemes.com/demo/freelancer-design-portfolio-pro/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_admin_banner';
	$nonce    = wp_create_nonce( FREELANCER_DESIGN_PORTFOLIOMO_NONCE );
	?>
	<div class="freelancer-design-portfoliomo-banner" data-nonce="<?php echo esc_attr( $nonce ); ?>">
		<div class="freelancer-design-portfoliomo-banner__inner">
			<div class="freelancer-design-portfoliomo-banner__brand">
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'ScintillaWP', 'freelancer-design-portfolio' ); ?>" class="freelancer-design-portfoliomo-banner__logo" />
			</div>
			<div class="freelancer-design-portfoliomo-banner__content">
				<h2 class="freelancer-design-portfoliomo-banner__title"><?php esc_html_e( 'Upgrade to Freelancer Design Portfolio', 'freelancer-design-portfolio' ); ?></h2>
				<p class="freelancer-design-portfoliomo-banner__text"><?php esc_html_e( 'Unlock premium designs, powerful features, exclusive layouts, and priority support to build better websites with ease.', 'freelancer-design-portfolio' ); ?></p>
			</div>
			<div class="freelancer-design-portfoliomo-banner__actions">
				<a href="<?php echo esc_url( $buy_url ); ?>" class="freelancer-design-portfoliomo-banner__btn freelancer-design-portfoliomo-banner__btn--buy" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Buy Now', 'freelancer-design-portfolio' ); ?></a>
				<a href="<?php echo esc_url( $demo_url ); ?>" class="freelancer-design-portfoliomo-banner__btn freelancer-design-portfoliomo-banner__btn--demo" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View Demo', 'freelancer-design-portfolio' ); ?></a>
			</div>
		</div>
		<button type="button" class="freelancer-design-portfoliomo-banner__close" aria-label="<?php esc_attr_e( 'Dismiss this notice', 'freelancer-design-portfolio' ); ?>">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?php
}
add_action( 'admin_notices', 'freelancer_design_portfolio_admin_promo_banner' );

/**
 * Enqueue banner CSS + JS on all admin screens.
 */
function freelancer_design_portfolio_admin_promo_banner_assets( $hook ) {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( freelancer_design_portfoliomo_is_dismissed() ) {
		return;
	}

	wp_enqueue_style(
		'freelancer-design-portfoliomo-banner',
		get_theme_file_uri( '/assets/css/admin-promo-banner.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'freelancer-design-portfoliomo-banner',
		get_theme_file_uri( '/assets/js/admin-promo-banner.js' ),
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_localize_script(
		'freelancer-design-portfoliomo-banner',
		'FreelancerDesignPortfolioPromo',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'action'  => 'freelancer_design_portfolio_dismiss_promo',
		)
	);
}
add_action( 'admin_enqueue_scripts', 'freelancer_design_portfolio_admin_promo_banner_assets' );

/**
 * AJAX handler: persist per-user dismissal.
 */
function freelancer_design_portfolio_dismiss_promo_handler() {

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'forbidden' ), 403 );
	}

	check_ajax_referer( FREELANCER_DESIGN_PORTFOLIOMO_NONCE, 'nonce' );

	update_user_meta( get_current_user_id(), FREELANCER_DESIGN_PORTFOLIOMO_META_KEY, time() );

	wp_send_json_success();
}
add_action( 'wp_ajax_freelancer_design_portfolio_dismiss_promo', 'freelancer_design_portfolio_dismiss_promo_handler' );
