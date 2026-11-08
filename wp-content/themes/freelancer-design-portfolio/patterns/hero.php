<?php
/**
 * Title: Hero
 * Slug: freelancer-design-portfolio/hero
 * Categories: featured, freelancer-design-portfolio
 * Description: Three column introduction with a name headline, a framed portrait card with social links and an availability note.
 */
$fdp_dir = get_template_directory_uri();
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/hero","name":"Hero","categories":["featured","freelancer-design-portfolio"]},"tagName":"section","anchor":"top","className":"fdp-hero","style":{"spacing":{"padding":{"left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"backgroundColor":"shell","layout":{"type":"constrained","contentSize":"1320px"}} -->
<section id="top" class="wp-block-group fdp-hero has-shell-background-color has-background" style="margin-top:0;margin-bottom:0;padding-right:var(--fdp-pad);padding-left:var(--fdp-pad)"><!-- wp:columns {"verticalAlignment":"center","className":"fdp-hero-grid","style":{"spacing":{"blockGap":{"top":"clamp(20px, 2.4vw, 52px)","left":"clamp(20px, 2.4vw, 52px)"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center fdp-hero-grid"><!-- wp:column {"verticalAlignment":"center","width":"41%","className":"fdp-hero-l fdp-rev","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column is-vertically-aligned-center fdp-hero-l fdp-rev" style="flex-basis:41%"><!-- wp:paragraph {"className":"fdp-hero-hi","style":{"spacing":{"margin":{"bottom":"14px"}}}} -->
<p class="fdp-hero-hi" style="margin-bottom:14px"><?php esc_html_e( 'Hello. The name is', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"fdp-hero-name","style":{"spacing":{"margin":{"top":"0","bottom":"22px"}}},"fontSize":"d1"} -->
<h1 class="wp-block-heading fdp-hero-name has-d-1-font-size" style="margin-top:0;margin-bottom:22px"><?php esc_html_e( 'August', 'freelancer-design-portfolio' ); ?><br><?php esc_html_e( 'Reyes', 'freelancer-design-portfolio' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"fdp-hero-copy","style":{"spacing":{"margin":{"bottom":"32px"}}}} -->
<p class="fdp-hero-copy" style="margin-bottom:32px"><?php esc_html_e( 'I art-direct and design for teams who already know what they are building, and need it to feel like one thing instead of forty.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'Book a call', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"34%","className":"fdp-hero-card fdp-rev","style":{"spacing":{"blockGap":"0","padding":{"top":"16px","right":"16px","left":"16px","bottom":"0"}}}} -->
<div class="wp-block-column is-vertically-aligned-center fdp-hero-card fdp-rev" style="padding-top:16px;padding-right:16px;padding-bottom:0;padding-left:16px;flex-basis:34%"><!-- wp:group {"className":"fdp-hero-photo","style":{"spacing":{"blockGap":"0","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group fdp-hero-photo" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/hero/hero-main.webp" alt="<?php esc_attr_e( 'August Reyes, art director, photographed against a plain patterned wall', 'freelancer-design-portfolio' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:social-links {"iconColor":"graphite","iconColorValue":"#2B2C2A","size":"has-small-icon-size","className":"is-style-logos-only fdp-hero-social","style":{"spacing":{"blockGap":{"top":"9px","left":"9px"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
<ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only fdp-hero-social"><!-- wp:social-link {"url":"#work","service":"dribbble"} /-->

<!-- wp:social-link {"url":"#work","service":"behance"} /-->

<!-- wp:social-link {"url":"#work","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#work","service":"facebook"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"fdp-hero-avail"} -->
<p class="fdp-hero-avail"><?php esc_html_e( 'Two slots open from September 2026', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%","className":"fdp-hero-right fdp-rev","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column is-vertically-aligned-center fdp-hero-right fdp-rev" style="flex-basis:25%"><!-- wp:paragraph {"className":"fdp-hero-role","style":{"spacing":{"margin":{"bottom":"14px"}}}} -->
<p class="fdp-hero-role" style="margin-bottom:14px"><?php esc_html_e( 'Independent of the Year 2025', 'freelancer-design-portfolio' ); ?><br><?php esc_html_e( 'Art Direction &amp; Interface', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"fdp-hero-title2","style":{"spacing":{"margin":{"top":"0","bottom":"30px"}}}} -->
<h2 class="wp-block-heading fdp-hero-title2" style="margin-top:0;margin-bottom:30px"><?php esc_html_e( 'Art', 'freelancer-design-portfolio' ); ?><br><?php esc_html_e( 'Direction', 'freelancer-design-portfolio' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"fdp-stack","style":{"spacing":{"blockGap":"0","margin":{"bottom":"16px"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-stack" style="margin-bottom:16px"><!-- wp:image {"width":"38px","height":"38px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/testimonials/client-1.webp" alt="" style="object-fit:cover;width:38px;height:38px"/></figure>
<!-- /wp:image -->

<!-- wp:image {"width":"38px","height":"38px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/testimonials/client-2.webp" alt="" style="object-fit:cover;width:38px;height:38px"/></figure>
<!-- /wp:image -->

<!-- wp:image {"width":"38px","height":"38px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/testimonials/client-3.webp" alt="" style="object-fit:cover;width:38px;height:38px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"fdp-stack-more"} -->
<p class="fdp-stack-more"><?php esc_html_e( '98%', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"bottom":"16px"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"bottom"}} -->
<div class="wp-block-group" style="margin-bottom:16px"><!-- wp:paragraph {"className":"fdp-hero-kpi"} -->
<p class="fdp-hero-kpi"><?php esc_html_e( '210+', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"fdp-hero-kpi-label"} -->
<p class="fdp-hero-kpi-label"><?php esc_html_e( 'launches behind me', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"fdp-hero-note"} -->
<p class="fdp-hero-note"><?php esc_html_e( 'Working across nine time zones', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
