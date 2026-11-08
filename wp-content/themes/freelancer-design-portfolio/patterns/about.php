<?php
/**
 * Title: About
 * Slug: freelancer-design-portfolio/about
 * Categories: about, freelancer-design-portfolio
 * Description: Two column about section with a portrait, an experience badge, a promise list and a signature.
 */
$fdp_dir = get_template_directory_uri();
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/about","name":"About","categories":["about","freelancer-design-portfolio"]},"tagName":"section","anchor":"about","className":"fdp-about","style":{"spacing":{"padding":{"top":"var(\u002d\u002dfdp-sec)","bottom":"var(\u002d\u002dfdp-sec)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"backgroundColor":"shell","layout":{"type":"constrained","contentSize":"1320px"}} -->
<section id="about" class="wp-block-group fdp-about has-shell-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--fdp-sec);padding-right:var(--fdp-pad);padding-bottom:var(--fdp-sec);padding-left:var(--fdp-pad)"><!-- wp:columns {"verticalAlignment":"center","className":"fdp-about-grid","style":{"spacing":{"blockGap":{"top":"clamp(30px, 4.4vw, 72px)","left":"clamp(30px, 4.4vw, 72px)"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center fdp-about-grid"><!-- wp:column {"verticalAlignment":"center","width":"48%","className":"fdp-about-img fdp-rev","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column is-vertically-aligned-center fdp-about-img fdp-rev" style="flex-basis:48%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/about/about-main.webp" alt="<?php esc_attr_e( 'Art director reviewing printed layouts pinned to a studio wall', 'freelancer-design-portfolio' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"fdp-about-badge","style":{"spacing":{"blockGap":"14px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-about-badge"><!-- wp:paragraph {"className":"fdp-about-badge-num"} -->
<p class="fdp-about-badge-num"><?php esc_html_e( '15', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"fdp-about-badge-text"} -->
<p class="fdp-about-badge-text"><?php esc_html_e( 'Years working independently, almost always with teams of under twenty people.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","className":"fdp-rev","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column is-vertically-aligned-center fdp-rev"><!-- wp:paragraph {"className":"fdp-eyebrow","fontSize":"eyebrow"} -->
<p class="fdp-eyebrow has-eyebrow-font-size"><?php esc_html_e( 'Background', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"spacing":{"margin":{"top":"18px","bottom":"20px"}}},"fontSize":"d2"} -->
<h2 class="wp-block-heading has-d-2-font-size" style="margin-top:18px;margin-bottom:20px"><?php esc_html_e( 'Forty projects taught me the same lesson forty times.', 'freelancer-design-portfolio' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"slate","fontSize":"lead","style":{"typography":{"lineHeight":"1.72"}}} -->
<p class="has-slate-color has-text-color has-lead-font-size" style="line-height:1.72"><?php esc_html_e( 'I spent my twenties inside agencies making things look expensive. Somewhere around the fourth rebrand that never shipped, I started asking what the work was actually for. These days I take fewer clients, ask the awkward questions in week one, and stay until the thing is live.', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"fdp-about-list","style":{"spacing":{"margin":{"top":"30px"}}}} -->
<ul class="wp-block-list fdp-about-list" style="margin-top:30px"><!-- wp:list-item -->
<li><?php esc_html_e( 'I read your support inbox before I open a design file.', 'freelancer-design-portfolio' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'One senior person on the work from first call to launch — nothing gets passed down.', 'freelancer-design-portfolio' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'If I think the project is the wrong project, you hear it before you pay me.', 'freelancer-design-portfolio' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:group {"className":"fdp-about-sign","style":{"spacing":{"blockGap":"22px","margin":{"top":"34px"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-about-sign" style="margin-top:34px"><!-- wp:image {"width":"150px","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/about/signature.svg" alt="<?php esc_attr_e( 'Signature of August Reyes', 'freelancer-design-portfolio' ); ?>" style="width:150px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"fdp-btn-outline"} -->
<div class="wp-block-button fdp-btn-outline"><a class="wp-block-button__link wp-element-button" href="#work"><?php esc_html_e( 'See the work', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
