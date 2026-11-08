<?php
/**
 * Title: Footer
 * Slug: freelancer-design-portfolio/footer
 * Categories: footer, freelancer-design-portfolio
 * Description: Dark footer with brand summary, social links, two link columns, contact details and a legal bar.
 */
$fdp_dir = get_template_directory_uri();
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/footer","name":"Footer","categories":["footer","freelancer-design-portfolio"]},"tagName":"div","className":"fdp-ftr","style":{"spacing":{"padding":{"top":"clamp(52px, 5.4vw, 84px)","bottom":"0","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"backgroundColor":"ink","textColor":"shell","layout":{"type":"constrained","contentSize":"1320px"}} -->
<div class="wp-block-group fdp-ftr has-shell-color has-ink-background-color has-text-color has-background" style="margin-top:0;margin-bottom:0;padding-top:clamp(52px, 5.4vw, 84px);padding-right:var(--fdp-pad);padding-bottom:0;padding-left:var(--fdp-pad)"><!-- wp:columns {"className":"fdp-ftr-top","style":{"spacing":{"blockGap":{"top":"clamp(26px, 3vw, 48px)","left":"clamp(26px, 3vw, 48px)"},"padding":{"bottom":"clamp(38px, 4vw, 60px)"}}}} -->
<div class="wp-block-columns fdp-ftr-top" style="padding-bottom:clamp(38px, 4vw, 60px)"><!-- wp:column {"width":"36%","style":{"spacing":{"blockGap":"20px"}}} -->
<div class="wp-block-column" style="flex-basis:36%"><!-- wp:image {"width":"164px","sizeSlug":"full","linkDestination":"custom","className":"fdp-ftr-logo","style":{"spacing":{"margin":{"bottom":"18px"}}}} -->
<figure class="wp-block-image size-full is-resized fdp-ftr-logo" style="margin-bottom:18px"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/footer/footer-logo.png" alt="<?php esc_attr_e( 'Freelancer Design Portfolio', 'freelancer-design-portfolio' ); ?>" style="width:164px;height:auto"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"fdp-ftr-about","style":{"spacing":{"margin":{"bottom":"24px"}}}} -->
<p class="fdp-ftr-about" style="margin-bottom:24px"><?php esc_html_e( 'An independent art direction and design practice for teams of under twenty. Fewer clients, harder questions early, and a handover that does not quietly depend on me.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"shell","iconColorValue":"#FFFFFF","size":"has-normal-icon-size","className":"is-style-logos-only fdp-ftr-soc","style":{"spacing":{"blockGap":{"left":"9px","top":"9px"}}}} -->
<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only fdp-ftr-soc"><!-- wp:social-link {"url":"#","service":"dribbble"} /-->

<!-- wp:social-link {"url":"#","service":"behance"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"blockGap":"20px"}}} -->
<div class="wp-block-column"><!-- wp:heading {"level":4,"className":"fdp-ftr-title","style":{"spacing":{"margin":{"bottom":"20px"}}}} -->
<h4 class="wp-block-heading fdp-ftr-title" style="margin-bottom:20px"><?php esc_html_e( 'Explore', 'freelancer-design-portfolio' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:list {"className":"fdp-ftr-links"} -->
<ul class="wp-block-list fdp-ftr-links"><!-- wp:list-item -->
<li><a href="#about"><?php esc_html_e( 'About', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#services"><?php esc_html_e( 'Services', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#work"><?php esc_html_e( 'Selected work', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#process"><?php esc_html_e( 'Process', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#journal"><?php esc_html_e( 'Journal', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"blockGap":"20px"}}} -->
<div class="wp-block-column"><!-- wp:heading {"level":4,"className":"fdp-ftr-title","style":{"spacing":{"margin":{"bottom":"20px"}}}} -->
<h4 class="wp-block-heading fdp-ftr-title" style="margin-bottom:20px"><?php esc_html_e( 'Services', 'freelancer-design-portfolio' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:list {"className":"fdp-ftr-links"} -->
<ul class="wp-block-list fdp-ftr-links"><!-- wp:list-item -->
<li><a href="#services"><?php esc_html_e( 'Art direction', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#services"><?php esc_html_e( 'Interface design', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#services"><?php esc_html_e( 'Design systems', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#services"><?php esc_html_e( 'Identity', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#services"><?php esc_html_e( 'Site build', 'freelancer-design-portfolio' ); ?></a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"blockGap":"16px"}}} -->
<div class="wp-block-column"><!-- wp:heading {"level":4,"className":"fdp-ftr-title","style":{"spacing":{"margin":{"bottom":"20px"}}}} -->
<h4 class="wp-block-heading fdp-ftr-title" style="margin-bottom:20px"><?php esc_html_e( 'Get in touch', 'freelancer-design-portfolio' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"fdp-ftr-cbox"} -->
<p class="fdp-ftr-cbox"><a href="mailto:contact@example.com">contact@example.com</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"fdp-ftr-cbox is-phone"} -->
<p class="fdp-ftr-cbox is-phone"><a href="tel:+10005555555">+1 (000) 555-555</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"fdp-ftr-cbox is-pin"} -->
<p class="fdp-ftr-cbox is-pin"><?php esc_html_e( '123 Maplewood Lane Apartment 4B, Springfield, IL 62704 USA', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"fdp-ftr-bot","style":{"spacing":{"blockGap":"16px","padding":{"top":"24px","bottom":"30px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-ftr-bot" style="padding-top:24px;padding-bottom:30px"><!-- wp:paragraph {"fontSize":"mini"} -->
<p class="has-mini-font-size"><?php
	/* translators: %s: current year. */
	printf( esc_html__( 'Copyright © %s Freelancer Design Portfolio WordPress theme by ScintillaWPThemes', 'freelancer-design-portfolio' ), esc_html( gmdate( 'Y' ) ) );
?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"fdp-ftr-legal","style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group fdp-ftr-legal"><!-- wp:paragraph {"fontSize":"mini"} -->
<p class="has-mini-font-size"><a href="#faq"><?php esc_html_e( 'Privacy', 'freelancer-design-portfolio' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"mini"} -->
<p class="has-mini-font-size"><a href="#faq"><?php esc_html_e( 'Terms', 'freelancer-design-portfolio' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"mini"} -->
<p class="has-mini-font-size"><a href="#faq"><?php esc_html_e( 'Licence', 'freelancer-design-portfolio' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"fdp-totop","layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons fdp-totop"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#top"><?php esc_html_e( 'Back to top', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
