<?php
/**
 * Title: Posts Grid
 * Slug: freelancer-design-portfolio/posts-grid
 * Categories: posts, freelancer-design-portfolio
 * Inserter: no
 * Description: Inheriting query loop of post cards with a no-results message and pagination.
 */
?>
<!-- wp:query {"queryId":2,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":true},"className":"fdp-posts","layout":{"type":"default"}} -->
<div class="wp-block-query fdp-posts"><!-- wp:post-template {"className":"fdp-post-template","style":{"spacing":{"blockGap":"clamp(16px, 1.9vw, 26px)","margin":{"bottom":"clamp(44px, 5vw, 72px)"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"fdp-post","style":{"spacing":{"blockGap":"18px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group fdp-post"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/11","className":"fdp-post-media"} /-->

<!-- wp:group {"className":"fdp-post-meta","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-post-meta"><!-- wp:post-terms {"term":"category","className":"fdp-post-cat","fontSize":"mini"} /-->

<!-- wp:post-date {"format":"d M Y","className":"fdp-post-date","fontSize":"mini"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"isLink":true,"className":"fdp-post-title","fontSize":"card-title"} /-->

<!-- wp:post-excerpt {"moreText":"","excerptLength":22,"className":"fdp-post-excerpt","fontSize":"small"} /-->

<!-- wp:read-more {"content":"<?php esc_attr_e( 'Read article', 'freelancer-design-portfolio' ); ?>","className":"fdp-post-more"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"align":"center","textColor":"slate","fontSize":"lead"} -->
<p class="has-text-align-center has-slate-color has-text-color has-lead-font-size"><?php esc_html_e( 'Nothing found here. Try another search or head back to the homepage.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php esc_attr_e( 'Search', 'freelancer-design-portfolio' ); ?>","showLabel":false,"placeholder":"<?php esc_attr_e( 'Search the journal…', 'freelancer-design-portfolio' ); ?>","width":100,"widthUnit":"%","buttonText":"<?php esc_attr_e( 'Search', 'freelancer-design-portfolio' ); ?>","className":"fdp-searchform","style":{"spacing":{"margin":{"top":"24px"}}}} /-->
<!-- /wp:query-no-results -->

<!-- wp:query-pagination {"paginationArrow":"arrow","className":"fdp-pagination","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
