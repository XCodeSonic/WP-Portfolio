<?php
/**
 * Title: Page Banner
 * Slug: freelancer-design-portfolio/banner-page
 * Categories: banner, freelancer-design-portfolio
 * Description: Mist banner for static pages showing the page title with a breadcrumb pill.
 */
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/banner-page","name":"Page Banner","categories":["banner","freelancer-design-portfolio"]},"tagName":"div","className":"fdp-banner","style":{"spacing":{"padding":{"top":"clamp(44px, 5vw, 78px)","bottom":"clamp(44px, 5vw, 78px)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"16px"}},"backgroundColor":"mist","layout":{"type":"constrained","contentSize":"1320px"}} -->
<div class="wp-block-group fdp-banner has-mist-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:clamp(44px, 5vw, 78px);padding-right:var(--fdp-pad);padding-bottom:clamp(44px, 5vw, 78px);padding-left:var(--fdp-pad)"><!-- wp:paragraph {"className":"fdp-eyebrow","fontSize":"eyebrow"} -->
<p class="fdp-eyebrow has-eyebrow-font-size"><?php esc_html_e( 'Page', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"level":1,"fontSize":"d2"} /-->

<!-- wp:group {"className":"fdp-crumbs","style":{"spacing":{"blockGap":"10px","padding":{"top":"9px","bottom":"9px","left":"20px","right":"20px"},"margin":{"top":"8px"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-crumbs" style="margin-top:8px;padding-top:9px;padding-right:20px;padding-bottom:9px;padding-left:20px"><!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"mini"} -->
<p class="has-mini-font-size" style="font-weight:600"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'freelancer-design-portfolio' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"slate","fontSize":"mini"} -->
<p class="has-slate-color has-text-color has-mini-font-size">/</p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"level":0,"isLink":false,"textColor":"slate","fontSize":"mini","style":{"typography":{"fontWeight":"500","letterSpacing":"0"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
