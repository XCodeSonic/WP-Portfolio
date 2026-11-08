<?php
/**
 * Pixel Personal Portfolio functions and definitions
 *
 * @package pixel_personal_portfolio
 * @since 1.0
 */

if ( ! defined( 'PIXEL_PERSONAL_PORTFOLIO_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'PIXEL_PERSONAL_PORTFOLIO_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'pixel_personal_portfolio_support' ) ) :
	function pixel_personal_portfolio_support() {

		load_theme_textdomain( 'pixel-personal-portfolio', get_template_directory() . '/languages' );

		add_theme_support( 'custom-background', apply_filters( 'pixel_personal_portfolio_custom_background', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support('woocommerce');

		// Enqueue editor styles.
		add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor-style.css');

		define('PIXEL_PERSONAL_PORTFOLIO_FREE_BUY_NOW',__('https://www.themepixels.net/products/pixel-personal-portfolio/','pixel-personal-portfolio'));
		define('PIXEL_PERSONAL_PORTFOLIO_BUY_NOW',__('https://www.themepixels.net/products/pixel-personal-portfolio-wordpress-theme','pixel-personal-portfolio'));
		define('PIXEL_PERSONAL_PORTFOLIO_LIVE_DEMO',__('https://themepixels.net/demo-site/pixel-personal-portfolio-pro/','pixel-personal-portfolio'));
		define('PIXEL_PERSONAL_PORTFOLIO_FREE_DOC',__('https://www.themepixels.net/docs/pixel-personal-portfolio-free-doc/','pixel-personal-portfolio'));
		define('PIXEL_PERSONAL_PORTFOLIO_BUNDLE',__('https://www.themepixels.net/products/wp-theme-bundle','pixel-personal-portfolio'));
		define('PIXEL_PERSONAL_PORTFOLIO_THEME_SUPPORT',__('https://wordpress.org/support/theme/pixel-personal-portfolio','pixel-personal-portfolio'));

    	require_once get_theme_file_path( '/inc/customizer.php' );
	}
endif;

add_action( 'after_setup_theme', 'pixel_personal_portfolio_support' );

if ( ! function_exists( 'pixel_personal_portfolio_styles' ) ) :
	function pixel_personal_portfolio_styles() {
		// Register theme stylesheet.
		$pixel_personal_portfolio_theme_version = wp_get_theme()->get( 'Version' );

		$PIXEL_PERSONAL_PORTFOLIO_VERSION_string = is_string( $pixel_personal_portfolio_theme_version ) ? $pixel_personal_portfolio_theme_version : false;
		wp_enqueue_style(
			'pixel-personal-portfolio-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$PIXEL_PERSONAL_PORTFOLIO_VERSION_string
		);

		wp_style_add_data('pixel-personal-portfolio', 'style-rtl', 'replace');

		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style( 'animate-css', esc_url(get_template_directory_uri()).'/assets/css/animate.css' );

		wp_enqueue_script( 'jquery-wow', esc_url(get_template_directory_uri()) . '/assets/js/wow.js', array('jquery') );
	    
		 //font-awesome
		 wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/inc/fontawesome/css/all.css'
		 	, array(), '6.7.0' );

		 wp_enqueue_script('pixel-personal-portfolio-custom-scripts', get_template_directory_uri() . '/assets/js/custom-script.js',  array('jquery'),'' ,true );
	}
endif;

add_action( 'wp_enqueue_scripts', 'pixel_personal_portfolio_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// Add block styles
require get_template_directory() . '/inc/block-styles.php';

// Block Filters
require get_template_directory() . '/inc/block-filters.php';

// Svg icons
require get_template_directory() . '/inc/icon-function.php';

// TGM
require get_template_directory() . '/inc/TGM/tgm.php';

/**
* GET START.
*/
require get_template_directory() . '/themeinfo/pixel_personal_portfolio_themeinfo_page.php';

// NOTICE FUNCTION
function pixel_personal_portfolio_activation_notice() {

    if ( get_option( 'pixel_personal_portfolio_notice_dismissed' ) ) {
        return;
    }

    if ( isset( $_GET['page'] ) && $_GET['page'] === 'pixel-personal-portfolio-themeinfo-page' ) {
        return;
    }
    pixel_personal_portfolio_theme_notice_content( true, false, true );
}

function pixel_personal_portfolio_theme_notice_content(
    $pixel_personal_portfolio_show_theme_info = true,
    $pixel_personal_portfolio_show_box_1 = false,
    $pixel_personal_portfolio_show_dismiss = true
) {
?>
	<div class="updated notice notice-theme-info-class <?php echo $pixel_personal_portfolio_show_dismiss ? 'is-dismissible' : ''; ?>" data-notice="theme_info">
        <div class="pixel-personal-portfolio-theme-info-notice clearfix">
            <div class="pixel-personal-portfolio-theme-notice-content">
				<div class="notice-content">
					<div class="inner-notice-contetn">
						<h4 class="best-value"><?php esc_html_e( 'Best Value', 'pixel-personal-portfolio' ); ?></h4>
						<h2 class="pixel-personal-portfolio-notice-h2">
							<?php
							printf(
								/* translators: 1: Theme name */
								esc_html__('Get 30+ Premium WordPress Themes in One Bundle', 'pixel-personal-portfolio'), '<strong>' . esc_html(wp_get_theme()->get('Name')) . '</strong>'
							);
							?>
						</h2>

						<p class="pixel-personal-portfolio-notice-p">
							<?php
							printf(
								/* translators: 1: Theme name */
								esc_html__('Premium WordPress Themes for Business, Ecommerce, Blogs, Portfolio and more. Our themes are light & easy to customize ', 'pixel-personal-portfolio'), '<strong>' . esc_html(wp_get_theme()->get('Name')) . '</strong>'
							);
							?>
						</p>
					</div>
					<div class="inner-notice-buttons">
						<?php if ( $pixel_personal_portfolio_show_theme_info ) : ?>
							<a class="pixel-personal-portfolio-btn-theme-info button button-primary bundlee"
								href="<?php echo esc_url( admin_url( 'themes.php?page=pixel-personal-portfolio-themeinfo-page' ) ); ?>">
								<?php esc_html_e( 'Theme Info', 'pixel-personal-portfolio' ); ?>
							</a>
						<?php endif; ?>
						<a class="pixel-personal-portfolio-btn-theme-info button button-primary live-demoo" target="_blank" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_BUY_NOW); ?>" id="pixel-personal-portfolio-bundle-button"> <?php esc_html_e('Buy Now', 'pixel-personal-portfolio') ?></a>
						<a class="pixel-personal-portfolio-btn-theme-info button button-primary bundlee" target="_blank" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_LIVE_DEMO); ?>" id="pixel-personal-portfolio-collection-button"> <?php esc_html_e('Live Demo', 'pixel-personal-portfolio') ?></a>
						<a class="pixel-personal-portfolio-btn-theme-info button button-primary bundlee" target="_blank" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_BUNDLE); ?>" 
						id="pixel-personal-portfolio-collection-button"> <?php esc_html_e('Get Bundle', 'pixel-personal-portfolio') ?></a>
					</div>
				</div>
				<div class="middle-box">
					<?php if ( $pixel_personal_portfolio_show_box_1 ) : ?>
						<div class="box-1">
							<div class="box-info">
								<span class="dashicons dashicons-yes-alt"></span>
								<div>
									<p><?php esc_html_e( '30+ Premium', 'pixel-personal-portfolio' ); ?></p>
									<p><?php esc_html_e( 'WordPress Themes', 'pixel-personal-portfolio' ); ?></p>
								</div>
							</div>
							<div class="box-info">
								<span class="dashicons dashicons-yes-alt"></span>
								<div>
									<p><?php esc_html_e( 'Single Theme', 'pixel-personal-portfolio' ); ?></p>
									<p><?php esc_html_e( 'Starting at $40', 'pixel-personal-portfolio' ); ?></p>
								</div>
							</div>
							<div class="box-info">
								<span class="dashicons dashicons-yes-alt"></span>
								<div>
									<p><?php esc_html_e( 'One Time Payment -', 'pixel-personal-portfolio' ); ?></p>
									<p><?php esc_html_e( 'no hidden charges', 'pixel-personal-portfolio' ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="box-2">
						<p class="box-2-para"><?php esc_html_e( 'Total Value', 'pixel-personal-portfolio' ); ?></p>
						<h4><?php esc_html_e( '$2499', 'pixel-personal-portfolio' ); ?></h4>
						<p><?php esc_html_e( 'Bundle Price', 'pixel-personal-portfolio' ); ?></p>
						<span><sup><?php esc_html_e( '$', 'pixel-personal-portfolio' ); ?></sup><h2><?php esc_html_e( '69', 'pixel-personal-portfolio' ); ?></h2></span>
						<p class="box-para"><?php esc_html_e( 'One Time Payement', 'pixel-personal-portfolio' ); ?></p>
						<p class="box-btn"><?php esc_html_e( 'You Save $2430', 'pixel-personal-portfolio' ); ?></p>
					</div>
				</div>
				<div class="notice-image">
					<a href="<?php echo esc_url( PIXEL_PERSONAL_PORTFOLIO_BUNDLE ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/bundle-img.png' ); ?>" alt="<?php esc_attr_e( 'Theme Screenshot', 'pixel-personal-portfolio' ); ?>">
					</a>
				</div>
            </div>
        </div>
    </div>
<?php
}

add_action('admin_notices', 'pixel_personal_portfolio_activation_notice');

add_action('wp_ajax_pixel_personal_portfolio_dismiss_notice', 'pixel_personal_portfolio_dismiss_notice');

function pixel_personal_portfolio_notice_status() {
    delete_option('pixel_personal_portfolio_notice_dismissed');
}
add_action('after_switch_theme', 'pixel_personal_portfolio_notice_status');

function pixel_personal_portfolio_dismiss_notice() {
    update_option('pixel_personal_portfolio_notice_dismissed', true);
    wp_send_json_success();
}

function pixel_personal_portfolio_admin_enqueue_scripts(){
	wp_enqueue_style('pixel-personal-portfolio-admin-style', esc_url( get_template_directory_uri() ) . '/assets/css/pixel-personal-portfolio-notice.css');
	wp_enqueue_script('pixel-personal-portfolio-dismiss-notice-script', get_stylesheet_directory_uri() . '/assets/js/pixel-personal-portfolio-notice.js', array('jquery'), null, true);
}
add_action( 'admin_enqueue_scripts', 'pixel_personal_portfolio_admin_enqueue_scripts' );