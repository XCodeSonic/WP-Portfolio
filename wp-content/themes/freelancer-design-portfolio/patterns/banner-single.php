<?php
/**
 * Title: Single Post Banner
 * Slug: freelancer-design-portfolio/banner-single
 * Categories: banner, freelancer-design-portfolio
 * Description: Mist banner for a single post showing the category, title, author and publish date.
 */
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/banner-single","name":"Single Post Banner","categories":["banner","freelancer-design-portfolio"]},"tagName":"div","className":"fdp-banner","style":{"spacing":{"padding":{"top":"clamp(44px, 5vw, 78px)","bottom":"clamp(44px, 5vw, 78px)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"18px"}},"backgroundColor":"mist","layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-group fdp-banner has-mist-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:clamp(44px, 5vw, 78px);padding-right:var(--fdp-pad);padding-bottom:clamp(44px, 5vw, 78px);padding-left:var(--fdp-pad)"><!-- wp:post-terms {"term":"category","className":"fdp-post-cat","fontSize":"mini"} /-->

<!-- wp:post-title {"level":1,"fontSize":"d2"} /-->

<!-- wp:group {"className":"fdp-entry-meta","style":{"spacing":{"blockGap":"18px"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-entry-meta"><!-- wp:post-author-name {"isLink":false,"fontSize":"mini"} /-->

<!-- wp:post-date {"format":"d M Y","fontSize":"mini"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
