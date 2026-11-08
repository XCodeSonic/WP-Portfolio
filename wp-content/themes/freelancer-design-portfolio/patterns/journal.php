<?php
/**
 * Title: Journal
 * Slug: freelancer-design-portfolio/journal
 * Categories: posts, freelancer-design-portfolio
 * Description: Latest posts in a three column query loop with cover image, category pill, date, excerpt and a read link.
 */
$fdp_blog = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/journal","name":"Journal","categories":["posts","freelancer-design-portfolio"]},"tagName":"section","anchor":"journal","className":"fdp-journal","style":{"spacing":{"padding":{"top":"var(\u002d\u002dfdp-sec)","bottom":"var(\u002d\u002dfdp-sec)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"backgroundColor":"shell","layout":{"type":"constrained","contentSize":"1320px"}} -->
<section id="journal" class="wp-block-group fdp-journal has-shell-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--fdp-sec);padding-right:var(--fdp-pad);padding-bottom:var(--fdp-sec);padding-left:var(--fdp-pad)"><!-- wp:group {"className":"fdp-sh fdp-rev","style":{"spacing":{"blockGap":"28px","margin":{"bottom":"clamp(34px, 4vw, 58px)"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group fdp-sh fdp-rev" style="margin-bottom:clamp(34px, 4vw, 58px)"><!-- wp:group {"className":"fdp-sh-l","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained","contentSize":"640px","justifyContent":"left"}} -->
<div class="wp-block-group fdp-sh-l"><!-- wp:paragraph {"className":"fdp-eyebrow","fontSize":"eyebrow"} -->
<p class="fdp-eyebrow has-eyebrow-font-size"><?php esc_html_e( 'Notebook', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"d2"} -->
<h2 class="wp-block-heading has-d-2-font-size"><?php esc_html_e( 'Things I keep having to explain.', 'freelancer-design-portfolio' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"fdp-btn-outline"} -->
<div class="wp-block-button fdp-btn-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $fdp_blog ); ?>"><?php esc_html_e( 'Every article', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":false},"className":"fdp-posts fdp-rev","layout":{"type":"default"}} -->
<div class="wp-block-query fdp-posts fdp-rev"><!-- wp:post-template {"className":"fdp-post-template","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"fdp-post","style":{"spacing":{"blockGap":"18px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group fdp-post"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/11","className":"fdp-post-media"} /-->

<!-- wp:group {"className":"fdp-post-meta","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-post-meta"><!-- wp:post-terms {"term":"category","className":"fdp-post-cat","fontSize":"mini"} /-->

<!-- wp:post-date {"format":"d M Y","className":"fdp-post-date","fontSize":"mini"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"isLink":true,"className":"fdp-post-title","fontSize":"card-title"} /-->

<!-- wp:post-excerpt {"moreText":"","excerptLength":24,"className":"fdp-post-excerpt","fontSize":"small"} /-->

<!-- wp:read-more {"content":"<?php esc_attr_e( 'Read article', 'freelancer-design-portfolio' ); ?>","className":"fdp-post-more"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"textColor":"slate","fontSize":"lead"} -->
<p class="has-slate-color has-text-color has-lead-font-size"><?php esc_html_e( 'No posts have been published yet. New writing will appear here.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></section>
<!-- /wp:group -->
