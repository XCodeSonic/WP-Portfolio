<?php
/**
 * Title: 404
 * Slug: freelancer-design-portfolio/404
 * Categories: freelancer-design-portfolio
 * Description: Not found message with a search form and a link back to the homepage.
 */
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/404","name":"404","categories":["freelancer-design-portfolio"]},"tagName":"main","className":"fdp-404","style":{"spacing":{"padding":{"top":"var(\u002d\u002dfdp-sec)","bottom":"var(\u002d\u002dfdp-sec)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"20px"}},"backgroundColor":"shell","layout":{"type":"constrained","contentSize":"680px"}} -->
<main class="wp-block-group fdp-404 has-shell-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--fdp-sec);padding-right:var(--fdp-pad);padding-bottom:var(--fdp-sec);padding-left:var(--fdp-pad)"><!-- wp:paragraph {"align":"center","className":"fdp-404-code"} -->
<p class="has-text-align-center fdp-404-code">404</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","fontSize":"d3"} -->
<h2 class="wp-block-heading has-text-align-center has-d-3-font-size"><?php esc_html_e( 'This page has moved on.', 'freelancer-design-portfolio' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"slate","fontSize":"lead"} -->
<p class="has-text-align-center has-slate-color has-text-color has-lead-font-size"><?php esc_html_e( 'The page you are looking for does not exist, or it has been moved. Try a search, or head back to the homepage.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php esc_attr_e( 'Search', 'freelancer-design-portfolio' ); ?>","showLabel":false,"placeholder":"<?php esc_attr_e( 'Search this site…', 'freelancer-design-portfolio' ); ?>","width":100,"widthUnit":"%","buttonText":"<?php esc_attr_e( 'Search', 'freelancer-design-portfolio' ); ?>","className":"fdp-searchform","style":{"spacing":{"margin":{"top":"10px"}}}} /-->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"12px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:12px"><!-- wp:button {"className":"fdp-btn-ink"} -->
<div class="wp-block-button fdp-btn-ink"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to homepage', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></main>
<!-- /wp:group -->
