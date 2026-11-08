<?php
/**
 * Title: Header
 * Slug: freelancer-design-portfolio/header
 * Categories: header, freelancer-design-portfolio
 * Description: Sticky header with the studio logo, primary navigation and a pill call-to-action button.
 */
$fdp_dir = get_template_directory_uri();
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/header","name":"Header","categories":["header","freelancer-design-portfolio"]},"tagName":"div","className":"fdp-hdr","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group fdp-hdr" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0"><!-- wp:group {"className":"fdp-hdr-in","style":{"spacing":{"blockGap":"24px","padding":{"left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-hdr-in" style="padding-right:var(--fdp-pad);padding-left:var(--fdp-pad)"><!-- wp:image {"width":"164px","sizeSlug":"full","linkDestination":"custom","className":"fdp-brand"} -->
<figure class="wp-block-image size-full is-resized fdp-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/header/header-logo.png" alt="<?php esc_attr_e( 'Freelancer Design Portfolio', 'freelancer-design-portfolio' ); ?>" style="width:164px;height:auto"/></a></figure>
<!-- /wp:image -->

<!-- wp:navigation {"className":"fdp-nav","overlayMenu":"mobile","overlayBackgroundColor":"shell","overlayTextColor":"ink","style":{"spacing":{"blockGap":"clamp(14px, 1.9vw, 30px)"}},"fontFamily":"inter-tight","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Home', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"<?php echo esc_url( home_url( '/' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'About', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#about","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-submenu {"label":"<?php esc_attr_e( 'Services', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#services","kind":"custom"} -->
<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Art Direction', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#services","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Interface Design', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#services","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Design Systems', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#services","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Identity', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#services","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Toolkit', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#toolkit","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Work', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#work","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Testimonial', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#testimonials","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'Journal', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#journal","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php esc_attr_e( 'FAQ', 'freelancer-design-portfolio' ); ?>","type":"custom","url":"#faq","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:buttons {"className":"fdp-hdr-cta","layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons fdp-hdr-cta"><!-- wp:button {"className":"fdp-btn-ink"} -->
<div class="wp-block-button fdp-btn-ink"><a class="wp-block-button__link wp-element-button" href="#work"><?php esc_html_e( 'See our works', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
