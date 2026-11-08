<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'pixel_personal_portfolio_Welcome' ) ) {

	class pixel_personal_portfolio_Welcome {
		public $pixel_personal_portfolio_theme_fields;

		public function __construct( $pixel_personal_portfolio_fields = array() ) {
			$this->pixel_personal_portfolio_theme_fields = $pixel_personal_portfolio_fields;
			add_action ('admin_init' , array( $this, 'admin_scripts' ) );
			add_action('admin_menu', array( $this, 'pixel_personal_portfolio_themeinfo_page_menu' ));
		}

		public function admin_scripts() {
			global $pagenow;
			$pixel_personal_portfolio_file_dir = get_template_directory_uri() . '/themeinfo/assets/';

			if ( $pagenow === 'themes.php' && isset($_GET['page']) && $_GET['page'] === 'pixel-personal-portfolio-themeinfo-page' ) {

				wp_enqueue_style (
					'pixel-personal-portfolio-themeinfo-page-style',
					$pixel_personal_portfolio_file_dir . 'pixel_personal_portfolio_themeinfo_page.css',
					array(), '1.0.0'
				);

				wp_enqueue_script (
					'pixel-personal-portfolio-themeinfo-page-functions',
					$pixel_personal_portfolio_file_dir . 'pixel_personal_portfolio_themeinfo_page.js',
					array('jquery'),
					'1.0.0',
					true
				);
			}
		}

        public function pixel_personal_portfolio_theme_info($pixel_personal_portfolio_id, $pixel_personal_portfolio_screenshot = false) {
            $pixel_personal_portfolio_themedata = wp_get_theme();
            return ($pixel_personal_portfolio_screenshot === true) ? esc_url($pixel_personal_portfolio_themedata->get_screenshot()) : esc_html($pixel_personal_portfolio_themedata->get($pixel_personal_portfolio_id));
        }

        public function pixel_personal_portfolio_themeinfo_page_menu() {
            add_theme_page(
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('%1$s Info', 'pixel-personal-portfolio'), $this->pixel_personal_portfolio_theme_info('Name')),
                sprintf(esc_html__('%1$s Info', 'pixel-personal-portfolio'), $this->pixel_personal_portfolio_theme_info('Name')),
                'edit_theme_options',
                'pixel-personal-portfolio-themeinfo-page',
                array( $this, 'pixel_personal_portfolio_themeinfo_page' )
            );
		}

        public function pixel_personal_portfolio_themeinfo_page() {
            // Define tabs with proper escaping and prefixes
            $pixel_personal_portfolio_tabs = array(
                'pixel_personal_portfolio_home'      => esc_html__('Home', 'pixel-personal-portfolio'),
                'pixel_personal_portfolio_free_pro'  => esc_html__('Free VS Pro', 'pixel-personal-portfolio'),
                'pixel_personal_portfolio_faqs'      => esc_html__('FAQs', 'pixel-personal-portfolio'),
                'pixel_personal_portfolio_support'   => esc_html__('Free Theme Supports', 'pixel-personal-portfolio'),
                'pixel_personal_portfolio_review'    => esc_html__('Please Rate Us', 'pixel-personal-portfolio'),
                // 'pixel_personal_portfolio_free_demo_content'    => esc_html__('Click Here For Free Demo Content', 'pixel-personal-portfolio'),
            );
            ?>
            <div class="wrap about-wrap access-wrap">
                <div class="test">
                    <div class="nav-tab-wrapper clearfix">
                        <?php
                        $tabHTML = '';
        
                        foreach ($pixel_personal_portfolio_tabs as $pixel_personal_portfolio_id => $pixel_personal_portfolio_label) :
        
                            $pixel_personal_portfolio_target = '';
                            $pixel_personal_portfolio_nav_class = 'nav-tab';
                            $pixel_personal_portfolio_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'pixel_personal_portfolio_home';
        
                            if ($pixel_personal_portfolio_id === $pixel_personal_portfolio_section) {
                                $pixel_personal_portfolio_nav_class .= ' nav-tab-active';
                            }
        
                            if ($pixel_personal_portfolio_id === 'pixel_personal_portfolio_free_pro') {
                                $pixel_personal_portfolio_nav_class .= ' upgrade-button';
                            }

                            if ($pixel_personal_portfolio_id === 'pixel_personal_portfolio_review') {
                                $pixel_personal_portfolio_nav_class .= ' review-button';
                            }

                            if ($pixel_personal_portfolio_id === 'pixel_personal_portfolio_free_demo_content') {
                                $pixel_personal_portfolio_nav_class .= ' demo-content-button';
                            }
        
                            switch ($pixel_personal_portfolio_id) {
        
                                case 'pixel_personal_portfolio_support':
                                    $pixel_personal_portfolio_target = 'target="_blank"';
                                    $pixel_personal_portfolio_url = esc_url('https://wordpress.org/support/theme/' . esc_html($this->pixel_personal_portfolio_theme_info('TextDomain')));
                                break;
        
                                case 'pixel_personal_portfolio_review':
                                    $pixel_personal_portfolio_target = 'target="_blank"';
                                    $pixel_personal_portfolio_url = esc_url('https://wordpress.org/support/theme/' . esc_html($this->pixel_personal_portfolio_theme_info('TextDomain')) . '/reviews/#new-post');
                                break;

                                case 'pixel_personal_portfolio_free_demo_content':
                                $pixel_personal_portfolio_target = 'target="_blank"';
                                $pixel_personal_portfolio_url = esc_url(admin_url('themes.php?page=pixel-personal-portfolio-freedemocontent'));
                                break;
                                
                                
                                case 'pixel_personal_portfolio_home':
                                    $pixel_personal_portfolio_url = esc_url(admin_url('themes.php?page=pixel-personal-portfolio-themeinfo-page'));
                                break;
        
                                default:
                                    $pixel_personal_portfolio_url = esc_url(admin_url('themes.php?page=pixel-personal-portfolio-themeinfo-page&section=' . esc_attr($pixel_personal_portfolio_id)));
                                break;
        
                            }
        
                            $tabHTML .= '<a ';
                            $tabHTML .= $pixel_personal_portfolio_target;
                            $tabHTML .= ' href="' . esc_url($pixel_personal_portfolio_url) . '"';
                            $tabHTML .= ' class="' . esc_attr($pixel_personal_portfolio_nav_class) . '"';
                            $tabHTML .= '>';

                            if ($pixel_personal_portfolio_id === 'pixel_personal_portfolio_free_demo_content') {
                                $tabHTML .= '<span>' . esc_html($pixel_personal_portfolio_label) . '</span>';
                            } else {
                                $tabHTML .= esc_html($pixel_personal_portfolio_label);
                            }

                            $tabHTML .= '</a>';
        
                        endforeach;
        
                        echo $tabHTML;
                        ?>
                    </div>
                    <div class="second-div">
                        <div class="themeinfo-section-wrapper">
                            <div class="themeinfo-section pixel_personal_portfolio_home clearfix">
                                <?php
                                $pixel_personal_portfolio_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'pixel_personal_portfolio_home';
                                switch ($pixel_personal_portfolio_section) {
            
                                    case 'pixel_personal_portfolio_free_pro':
                                        $this->pixel_personal_portfolio_free_pro();
                                    break;
            
                                    case 'pixel_personal_portfolio_faqs':
                                        $this->pixel_personal_portfolio_faqs();
                                    break;
            
                                    case 'pixel_personal_portfolio_home':
                                    default:
                                        $this->pixel_personal_portfolio_home();
                                    break;
            
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="customizer-settings">
                        <h4><?php esc_html_e( 'Quick Customizer Settings', 'pixel-personal-portfolio' ); ?></h4>
                        <div class="setting-box">
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon1.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Site Identity', 'pixel-personal-portfolio' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=title_tagline' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'pixel-personal-portfolio' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon2.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Color Options', 'pixel-personal-portfolio' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?p=%2Fstyles&section=%2Fvariations' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'pixel-personal-portfolio' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon3.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Header Options', 'pixel-personal-portfolio' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?path=%2Fpatterns&postType=wp_template_part&categoryId=header' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'pixel-personal-portfolio' ); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="setting-box">
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon4.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Footer Options', 'pixel-personal-portfolio' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?path=%2Fpatterns&postType=wp_template_part&categoryId=footer' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'pixel-personal-portfolio' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon5.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Homepage Option', 'pixel-personal-portfolio' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?p=%2F&canvas=edit' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'pixel-personal-portfolio' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon6.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Templates', 'pixel-personal-portfolio' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?p=%2Ftemplate' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'pixel-personal-portfolio' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="theme-steps-list">
                    <div class="theme-steps">
                        <h3><?php echo esc_html__('Documentation', 'pixel-personal-portfolio'); ?></h3>
                        <p><?php echo esc_html__('Need help? Our detailed docs will guide you through everything.', 'pixel-personal-portfolio'); ?></p>
                        <a target="_blank" class="button button-primary" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_FREE_DOC); ?>"><?php echo esc_html__('Go to Docs', 'pixel-personal-portfolio'); ?></a>
                    </div>    
                    <div class="theme-steps">
                        <h3><?php echo esc_html__('Preview Pro Theme', 'pixel-personal-portfolio'); ?></h3>
                        <p><?php echo esc_html__('Explore our Pro theme demo and see the power of customization.', 'pixel-personal-portfolio'); ?></p>
                        <div class="pro-screenshot">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/pro-img.png' ); ?>" alt="<?php esc_attr_e( 'Premium Theme Screenshot', 'pixel-personal-portfolio' ); ?>">
                        </div>
                        <strong>Get 20% OFF </strong><span>WordPress Themes</span><br>
                        <strong>Code: EARLY20</strong>
                        <h6 class="price"><?php echo esc_html__('Just ','pixel-personal-portfolio'); ?><span class="reg-price"><?php echo esc_html__('$69.00','pixel-personal-portfolio'); ?></span><span class="sel-price"><?php echo esc_html__('$39.00','pixel-personal-portfolio'); ?></span></h6>
                        <div class="pro-info-buttons">
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_LIVE_DEMO); ?>"><?php echo esc_html__('View Live Demo', 'pixel-personal-portfolio'); ?></a>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_BUY_NOW); ?>"><?php echo esc_html__('Buy Pro Theme', 'pixel-personal-portfolio'); ?></a>
                        </div>
                    </div>              
                    <div class="theme-steps">
                        <h3><?php echo esc_html__('Get the Bundle At Just $69 ', 'pixel-personal-portfolio'); ?></h3>
                        <div class="bundle-img">
                            <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/bundle-img-2.png'; ?>" />
                        </div>
                        <br>
                        <a target="_blank" class="button button-primary" href="<?php echo esc_url(PIXEL_PERSONAL_PORTFOLIO_BUNDLE); ?>"><?php echo esc_html__('Get All Themes', 'pixel-personal-portfolio'); ?></a>
                    </div>          
                </div>
            </div>
            <?php
        }

        public function pixel_personal_portfolio_home() {
            ?>
            <div class="theme-info-top-wrap clearfix">
                <div class="theme-details">
                    <div class="theme-screenshot">
                        <img src="<?php echo esc_url( $this->pixel_personal_portfolio_theme_info( 'Screenshot', true ) ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'pixel-personal-portfolio' ); ?>" />
                    </div>
                    <div class="about-text"><?php echo esc_html( $this->pixel_personal_portfolio_theme_info( 'Description' ) ); ?></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php
        }        

		public function pixel_personal_portfolio_free_pro() {
            ?>
            <div class="freeandpro">
                <table class="card table free-pro" cellspacing="0" cellpadding="0">
                    <tbody class="table-body">
                        <tr class="table-head">
                            <th class="large"><?php echo esc_html__( 'Features', 'pixel-personal-portfolio' ); ?></th>
                            <th class="indicator"><?php echo esc_html__( 'Free theme', 'pixel-personal-portfolio' ); ?></th>
                            <th class="indicator"><?php echo esc_html__( 'Pro Theme', 'pixel-personal-portfolio' ); ?></th>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Responsive Design', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Site Logo upload', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Footer Copyright text', 'pixel-personal-portfolio' ); ?></h4>
                                    <div class="feature-inline-row">
                                        <span class="info-icon dashicon dashicons dashicons-info"></span>
                                        <span class="feature-description">
                                            <?php echo esc_html__( 'Remove the copyright text from the Footer.', 'pixel-personal-portfolio' ); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Easy Customization', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Lightweight & Fast Loading', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Global Color', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Regular Bug Fixes', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>
                        
                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Premium Support', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Theme Sections', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="abc"><?php echo esc_html__( '2 Sections', 'pixel-personal-portfolio' ); ?></span></td>
                            <td class="indicator"><span class="abc"><?php echo esc_html__( '15+ Sections', 'pixel-personal-portfolio' ); ?></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Custom colors', 'pixel-personal-portfolio' ); ?></h4>
                                    <div class="feature-inline-row">
                                        <span class="info-icon dashicon dashicons dashicons-info"></span>
                                        <span class="feature-description">
                                            <?php echo esc_html__( 'Choose a color for links, buttons, icons and so on.', 'pixel-personal-portfolio' ); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Google fonts', 'pixel-personal-portfolio' ); ?></h4>
                                    <div class="feature-inline-row">
                                        <span class="info-icon dashicon dashicons dashicons-info"></span>
                                        <span class="feature-description">
                                            <?php echo esc_html__( 'You can choose and use over 600 different fonts, for the logo, the menu and the titles.', 'pixel-personal-portfolio' ); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Compatible with Popular Plugins', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Translation & WPML Ready', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'SEO Optimized', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Premium Support', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Extensive Customization', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Custom Post Types', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'High-Level Compatibility with Modern Browsers', 'pixel-personal-portfolio' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
        }

        public function pixel_personal_portfolio_faqs() {
            ?>
            <div class="faq-container">
                <div class="accordion" id="ShoeOutletFaqAccordion">
                    <!-- FAQ 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseOne" aria-expanded="true" aria-controls="ShoeOutletCollapseOne">
                                <?php echo esc_html__('What is the difference between Free and Pro?', 'pixel-personal-portfolio'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseOne" class="accordion-collapse collapse show" aria-labelledby="ShoeOutletHeadingOne" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('The themes are well-made in both their free and premium versions. But there are a lot more features in the Pro edition.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('You may quickly alter the appearance and feel of your website with the Pro version. You can alter your websites color and typeface with a few clicks. With more customization choices, the premium version gives you greater control over the theme. In addition, the theme offers more layout options and sections than the free version.', 'pixel-personal-portfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseTwo" aria-expanded="false" aria-controls="ShoeOutletCollapseTwo">
                                <?php echo esc_html__('What are the advantages of upgrading to the Premium version?', 'pixel-personal-portfolio'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseTwo" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingTwo" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('In addition to the additional features and regular upgrades, the Premium version comes with premium support. Compared to the free assistance, you will receive a much faster response if you encounter any theme problems.', 'pixel-personal-portfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseThree" aria-expanded="false" aria-controls="ShoeOutletCollapseThree">
                                <?php echo esc_html__('Upgrading to the Pro version- will I lose my changes?', 'pixel-personal-portfolio'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseThree" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingThree" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('Your posts, pages, media, categories, and other data will all be preserved when you upgrade to the Pro theme.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('You will need to configure the extra features via the customizer, though, because the Pro edition has more features and options. It just takes a few minutes to complete this easy process.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('There is a lot of flexibility in the Pro version to accommodate future updates. As a result, it differs slightly from the free theme yet is incredibly versatile and user-friendly.', 'pixel-personal-portfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseFour" aria-expanded="false" aria-controls="ShoeOutletCollapseFour">
                                <?php echo esc_html__('How do I change the copyright text?', 'pixel-personal-portfolio'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseFour" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingFour" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('You can change the copyright text going to Appearance > Customize > Footer Option > And here you can find (Edit Footer Copyright Text)', 'pixel-personal-portfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseFour" aria-expanded="false" aria-controls="ShoeOutletCollapseFour">
                                <?php echo esc_html__('Why is my theme not working well?', 'pixel-personal-portfolio'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseFour" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingFour" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('It could be a plugin conflict if your customizer is not loading correctly or if you are experiencing problems with the theme.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Deactivate every plugin first, with the exception of those the theme suggests, to resolve the problem. After that, use "Ctrl+Shift+R" on Windows to force a new page load. Once the problems have been resolved, begin turning on each plugin individually, then refresh and verify your website each time. This will assist you in identifying the problematic plugin.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Please get in touch with us if this was not helpful.', 'pixel-personal-portfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseFour" aria-expanded="false" aria-controls="ShoeOutletCollapseFour">
                                <?php echo esc_html__('How can I solve my issues quickly and get faster support?', 'pixel-personal-portfolio'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseFour" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingFour" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('Please make sure you have updated the theme to the most recent version before sending us a support ticket for any problems. The theme update may have resolved the issue.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Please try to include as much information as you can in your support ticket submission so that we can address your issue more quickly. We advise you to email us one or more screenshots that clearly illustrate the problems and include the URL of your website.', 'pixel-personal-portfolio'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Please be patient with us as we may have a delayed response time during the weekend.', 'pixel-personal-portfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        
	}

}
new pixel_personal_portfolio_Welcome();
?>