<?php
/**
 * Graceful Aspire Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Graceful_Aspire_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// ----------------------------------------------------------------------------------
// Register Front-End Styles And Scripts
// ----------------------------------------------------------------------------------

/**
 * Enqueue parent and child stylesheets.
 */
function graceful_aspire_blog_enqueue_child_styles() {
	wp_enqueue_style( 'graceful-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'graceful-aspire-blog-style', get_stylesheet_directory_uri() . '/style.css', array( 'graceful-style' ), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'graceful_aspire_blog_enqueue_child_styles' );

/**
 * Enqueue dynamic styles for Graceful Aspire Blog.
 */
function graceful_aspire_blog_dynamic_styles() {
	$bg_color  = sanitize_hex_color( graceful_aspire_blog_options( 'main_navigation_bg_color' ) );
	$nav_align = graceful_options( 'main_navigation_align' );
	$align     = in_array( $nav_align, array( 'left', 'center', 'right' ), true ) ? $nav_align : 'center';

	$custom_css = '';
	if ( $bg_color ) {
		$custom_css .= "#main-navigation { background-color: {$bg_color} !important; }\n";
	}
	$custom_css .= "#main-navigation, #main-navigation .site-menu-wrapper, #site-menu { text-align: {$align}; }\n";

	if ( ! graceful_aspire_blog_options( 'aspirepost_slider_nav' ) ) {
		$custom_css .= "#graceful-aspire-post-slider-wrap .owl-nav { display: none !important; }\n";
	}
	if ( ! graceful_aspire_blog_options( 'aspirepost_slider_dots' ) ) {
		$custom_css .= "#graceful-aspire-post-slider-wrap .owl-dots { display: none !important; }\n";
	}

	$links_bg_color   = sanitize_hex_color( graceful_aspire_blog_options( 'special_links_bg_color' ) );
	$links_text_color = sanitize_hex_color( graceful_aspire_blog_options( 'special_links_text_color' ) );

	if ( $links_bg_color ) {
		$custom_css .= ".graceful-aspire-special-links-wrap li a, .graceful-aspire-special-link-box { background-color: {$links_bg_color} !important; }\n";
	}
	if ( $links_text_color ) {
		$custom_css .= ".graceful-aspire-special-links-wrap li a, .graceful-aspire-special-link-box { color: {$links_text_color} !important; }\n";
	}

	if ( ! empty( $custom_css ) ) {
		wp_add_inline_style( 'graceful-aspire-blog-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'graceful_aspire_blog_dynamic_styles', 20 );

/**
 * Graceful Aspire Blog default options.
 *
 * @param string $controls Option name.
 * @return mixed Option value.
 */
function graceful_aspire_blog_options( $controls ) {
	$defaults = array(
		'blog_grid_excerpt_length' => '30',
		'aspirepost_slider_show'   => true,
		'aspirepost_slider_nav'    => true,
		'aspirepost_slider_dots'   => true,
		'main_navigation_bg_color' => '#ffffff',
		// Featured Boxes.
		'featured_boxes_show'      => false,
		'featured_boxes_window'    => true,
		'featured_boxes_width'     => 'wrapped',
		'featured_boxes_title_1'   => '',
		'featured_boxes_url_1'     => '',
		'featured_boxes_image_1'   => '',
		'featured_boxes_title_2'   => '',
		'featured_boxes_url_2'     => '',
		'featured_boxes_image_2'   => '',
		'featured_boxes_title_3'   => '',
		'featured_boxes_url_3'     => '',
		'featured_boxes_image_3'   => '',
		// Special Links.
		'special_links_show'       => false,
		'special_links_bg_color'   => '#f8f8f8',
		'special_links_text_color' => '#000000',
	);
	$options  = get_option( 'graceful_aspire_blog_options', array() );
	$merged   = wp_parse_args( $options, $defaults );
	return isset( $merged[ $controls ] ) ? $merged[ $controls ] : '';
}

/**
 * Sanitize absolute integer values.
 *
 * @param int                  $number  Input value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int Sanitized absolute integer.
 */
function graceful_aspire_blog_sanitize_number_absint( $number, $setting ) {
	$number = absint( $number );
	return ( $number ? $number : $setting->default );
}

/**
 * Fallback for Special Links Menu when unassigned.
 */
function graceful_aspire_blog_special_links_fallback() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		?>
		<nav class="graceful-aspire-special-links-nav">
			<ul id="special-links-menu" class="graceful-aspire-special-links-wrap">
				<li class="menu-item">
					<a class="graceful-aspire-special-link-box" href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">
						<?php esc_html_e( 'Set-up Special Links Menu', 'graceful-aspire-blog' ); ?>
					</a>
				</li>
			</ul>
		</nav>
		<?php
	}
}

/**
 * Filter graceful_options to make main_navigation_align default to 'center' in Aspire.
 *
 * @param array $options Theme options array.
 * @return array Modified theme options array.
 */
function graceful_aspire_blog_default_options( $options ) {
	if ( ! is_array( $options ) ) {
		$options = array();
	}
	if ( ! isset( $options['main_navigation_align'] ) ) {
		$options['main_navigation_align'] = 'center';
	}
	return $options;
}
add_filter( 'option_graceful_options', 'graceful_aspire_blog_default_options' );

/**
 * Theme setup for Graceful Aspire Blog.
 */
function graceful_aspire_blog_theme_setup() {
	// Make child theme available for translation.
	load_child_theme_textdomain( 'graceful-aspire-blog', get_stylesheet_directory() . '/languages' );

	// Register Special Links Menu.
	register_nav_menus(
		array(
			'special-links' => esc_html__( 'Special Links Menu', 'graceful-aspire-blog' ),
		)
	);
}
add_action( 'after_setup_theme', 'graceful_aspire_blog_theme_setup' );

/**
 * Register widget areas for Graceful Aspire Blog.
 */
function graceful_aspire_blog_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Right', 'graceful-aspire-blog' ),
			'id'            => 'sidebar-right',
			'description'   => esc_html__( 'Add widgets here, for right sidebar.', 'graceful-aspire-blog' ),
			'before_widget' => '<section id="%1$s" class="graceful-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Left', 'graceful-aspire-blog' ),
			'id'            => 'sidebar-left',
			'description'   => esc_html__( 'Add widgets here, for left sidebar.', 'graceful-aspire-blog' ),
			'before_widget' => '<section id="%1$s" class="graceful-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Slide Menu', 'graceful-aspire-blog' ),
			'id'            => 'sidebar-slide-menu',
			'description'   => esc_html__( 'Add widgets here, for slide menu sidebar.', 'graceful-aspire-blog' ),
			'before_widget' => '<section id="%1$s" class="graceful-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widgets', 'graceful-aspire-blog' ),
			'id'            => 'footer-widgets',
			'description'   => esc_html__( 'Add widgets here, for the footer.', 'graceful-aspire-blog' ),
			'before_widget' => '<section id="%1$s" class="graceful-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'graceful_aspire_blog_widgets_init', 11 );

/**
 * Register Customizer settings and controls for Graceful Aspire Blog.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function graceful_aspire_blog_customize_register( $wp_customize ) {
	// Main Navigation - Default alignment to center for Aspire.
	$main_nav_align_setting = $wp_customize->get_setting( 'graceful_options[main_navigation_align]' );
	if ( $main_nav_align_setting ) {
		$main_nav_align_setting->default = 'center';
	}

        // Main Navigation - Background Color option
        $wp_customize->add_setting( 'graceful_aspire_blog_options[main_navigation_bg_color]', array(
            'default'           => graceful_aspire_blog_options( 'main_navigation_bg_color' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graceful_aspire_blog_options[main_navigation_bg_color]', array(
            'label'    => esc_html__( 'Main Navigation Background Color', 'graceful-aspire-blog' ),
            'section'  => 'graceful_main_navigation',
            'priority' => 5,
        ) ) );

        // Aspire Post Slider Banner section
        $wp_customize->add_section( 'graceful_aspire_post_slider', array(
            'title'      => esc_html__( 'Aspire Post Slider', 'graceful-aspire-blog' ),
            'priority'   => 26,
            'capability' => 'edit_theme_options',
        ) );

        $wp_customize->add_setting( 'graceful_aspire_blog_options[aspirepost_slider_show]', array(
            'default'           => graceful_aspire_blog_options( 'aspirepost_slider_show' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes',
        ) );
        $wp_customize->add_control( 'graceful_aspire_blog_options[aspirepost_slider_show]', array(
            'label'    => esc_html__( 'Enable Aspire Post Slider', 'graceful-aspire-blog' ),
            'section'  => 'graceful_aspire_post_slider',
            'type'     => 'checkbox',
            'priority' => 1,
        ) );

        $wp_customize->add_setting( 'graceful_aspire_blog_options[aspirepost_slider_nav]', array(
            'default'           => graceful_aspire_blog_options( 'aspirepost_slider_nav' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes',
        ) );
        $wp_customize->add_control( 'graceful_aspire_blog_options[aspirepost_slider_nav]', array(
            'label'    => esc_html__( 'Show Navigation Buttons', 'graceful-aspire-blog' ),
            'section'  => 'graceful_aspire_post_slider',
            'type'     => 'checkbox',
            'priority' => 2,
        ) );

        $wp_customize->add_setting( 'graceful_aspire_blog_options[aspirepost_slider_dots]', array(
            'default'           => graceful_aspire_blog_options( 'aspirepost_slider_dots' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes',
        ) );
        $wp_customize->add_control( 'graceful_aspire_blog_options[aspirepost_slider_dots]', array(
            'label'    => esc_html__( 'Show Dots', 'graceful-aspire-blog' ),
            'section'  => 'graceful_aspire_post_slider',
            'type'     => 'checkbox',
            'priority' => 3,
        ) );

        // Aspire Featured Boxes section
        $wp_customize->add_section( 'graceful_aspire_blog_featured_boxes', array(
            'title'      => esc_html__( 'Featured Boxes', 'graceful-aspire-blog' ),
            'priority'   => 27,
            'capability' => 'edit_theme_options',
        ) );

        $wp_customize->add_setting( 'graceful_aspire_blog_options[featured_boxes_show]', array(
            'default'           => graceful_aspire_blog_options( 'featured_boxes_show' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes',
        ) );
        $wp_customize->add_control( 'graceful_aspire_blog_options[featured_boxes_show]', array(
            'label'    => esc_html__( 'Enable Featured Boxes', 'graceful-aspire-blog' ),
            'section'  => 'graceful_aspire_blog_featured_boxes',
            'type'     => 'checkbox',
            'priority' => 1,
        ) );

        for ( $i = 1; $i <= 3; $i++ ) {
            $wp_customize->add_setting( "graceful_aspire_blog_options[featured_boxes_title_{$i}]", array(
                'default'           => graceful_aspire_blog_options( "featured_boxes_title_{$i}" ),
                'type'              => 'option',
                'transport'         => 'refresh',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            
            $wp_customize->add_control( "graceful_aspire_blog_options[featured_boxes_title_{$i}]", array(
                // translators: %d: Featured box number.
                'label'    => sprintf( esc_html__( 'Title %d', 'graceful-aspire-blog' ), $i ),
                'section'  => 'graceful_aspire_blog_featured_boxes',
                'type'     => 'text',
                'priority' => 5 + ( $i * 2 ),
            ) );

            $wp_customize->add_setting( "graceful_aspire_blog_options[featured_boxes_url_{$i}]", array(
                'default'           => graceful_aspire_blog_options( "featured_boxes_url_{$i}" ),
                'type'              => 'option',
                'transport'         => 'refresh',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            ) );
            
            $wp_customize->add_control( "graceful_aspire_blog_options[featured_boxes_url_{$i}]", array(
                // translators: %d: Featured box number.
                'label'    => sprintf( esc_html__( 'URL %d', 'graceful-aspire-blog' ), $i ),
                'section'  => 'graceful_aspire_blog_featured_boxes',
                'type'     => 'text',
                'priority' => 6 + ( $i * 2 ),
            ) );

            $wp_customize->add_setting( "graceful_aspire_blog_options[featured_boxes_image_{$i}]", array(
                'default'           => '',
                'type'              => 'option',
                'transport'         => 'refresh',
                'sanitize_callback' => 'graceful_aspire_blog_sanitize_number_absint',
            ) );
            
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( 
                $wp_customize, 
                "graceful_aspire_blog_options[featured_boxes_image_{$i}]", 
                array(
                    // translators: %d: Featured box number.
                    'label'       => sprintf( esc_html__( 'Image %d', 'graceful-aspire-blog' ), $i ),
                    'section'     => 'graceful_aspire_blog_featured_boxes',
                    'flex_width'  => false,
                    'flex_height' => false,
                    'width'       => 600,
                    'height'      => 340,
                    'priority'    => 7 + ( $i * 2 ),
                )
            ) );
        }

        $wp_customize->add_setting( 'graceful_aspire_blog_options[featured_boxes_width]', array(
            'default'           => graceful_aspire_blog_options( 'featured_boxes_width' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_select',
        ) );
        $wp_customize->add_control( 'graceful_aspire_blog_options[featured_boxes_width]', array(
            'label'    => esc_html__( 'Featured Boxes Width', 'graceful-aspire-blog' ),
            'section'  => 'graceful_basic',
            'type'     => 'select',
            'choices'  => array(
                'full'    => esc_html__( 'Full', 'graceful-aspire-blog' ),
                'wrapped' => esc_html__( 'Boxed', 'graceful-aspire-blog' ),
            ),
            'priority' => 28,
        ) );


        // Aspire Special Links section.
        $wp_customize->add_section( 'graceful_aspire_special_links_section', array(
            'title'       => esc_html__( 'Special Links', 'graceful-aspire-blog' ),
            'description' => esc_html__( 'Special links bar appears below the site header.', 'graceful-aspire-blog' ),
            'priority'    => 23.5,
        ) );

        $wp_customize->add_setting( 'graceful_aspire_blog_options[special_links_show]', array(
            'default'           => graceful_aspire_blog_options( 'special_links_show' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'graceful_sanitize_checkboxes',
        ) );
        $wp_customize->add_control( 'graceful_aspire_blog_options[special_links_show]', array(
            'label'       => esc_html__( 'Enable Special Links', 'graceful-aspire-blog' ),
            'description' => esc_html__( 'To set up links, create a menu and assign it to "Special Links Menu" under Appearance > Menus or Customizer > Menus.', 'graceful-aspire-blog' ),
            'section'     => 'graceful_aspire_special_links_section',
            'type'        => 'checkbox',
            'priority'    => 1,
        ) );

        // Special Links Background Color option.
        $wp_customize->add_setting( 'graceful_aspire_blog_options[special_links_bg_color]', array(
            'default'           => graceful_aspire_blog_options( 'special_links_bg_color' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graceful_aspire_blog_options[special_links_bg_color]', array(
            'label'    => esc_html__( 'Links Background Color', 'graceful-aspire-blog' ),
            'section'  => 'graceful_aspire_special_links_section',
            'priority' => 2,
        ) ) );

        // Special Links Text Color option.
        $wp_customize->add_setting( 'graceful_aspire_blog_options[special_links_text_color]', array(
            'default'           => graceful_aspire_blog_options( 'special_links_text_color' ),
            'type'              => 'option',
            'transport'         => 'refresh',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graceful_aspire_blog_options[special_links_text_color]', array(
            'label'    => esc_html__( 'Links Text Color', 'graceful-aspire-blog' ),
            'section'  => 'graceful_aspire_special_links_section',
            'priority' => 3,
        ) ) );
    }
add_action( 'customize_register', 'graceful_aspire_blog_customize_register', 99 );

function graceful_aspire_blog_customizer_css() {
    wp_enqueue_style( 'graceful-customize-style', get_theme_file_uri( '/css/customize-ui.css' ), array(), '1.0' );
}
add_action( 'customize_controls_enqueue_scripts', 'graceful_aspire_blog_customizer_css' );

function graceful_aspire_blog_enqueue_assets() {
    require_once get_theme_file_path( 'webfont-loader/wptt-webfont-loader.php' );
    wp_enqueue_style(
        'graceful-aspire-blog-fonts',
        wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=auto' ),
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'graceful_aspire_blog_enqueue_assets' );

if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'graceful-post-column-thumbnail', 700, 680, true );
}

/**
 * Add body class when Special Links are enabled.
 *
 * @param array $classes Array of body classes.
 * @return array Modified array of body classes.
 */
function graceful_aspire_blog_body_classes( $classes ) {
	if ( graceful_aspire_blog_options( 'special_links_show' ) ) {
		$classes[] = 'has-special-links';
	}
	return $classes;
}
add_filter( 'body_class', 'graceful_aspire_blog_body_classes' );
