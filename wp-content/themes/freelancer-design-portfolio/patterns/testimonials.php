<?php
/**
 * Title: Testimonials
 * Slug: freelancer-design-portfolio/testimonials
 * Categories: testimonials, freelancer-design-portfolio
 * Description: Three client testimonial cards with star ratings, quotes and author avatars on a soft mist band.
 */
$fdp_dir = get_template_directory_uri();

$fdp_quotes = array(
	array(
		'quote'  => __( 'We briefed three studios before this one. August spent his first week inside our support inbox rather than a design file, then showed us the two screens costing us signups. Setup completion moved forty-four points.', 'freelancer-design-portfolio' ),
		'name'   => __( 'Priya Raghunathan', 'freelancer-design-portfolio' ),
		'role'   => __( 'Co-founder, Brightsill', 'freelancer-design-portfolio' ),
		'avatar' => 'client-1.webp',
		'delay'  => '',
	),
	array(
		'quote'  => __( 'The handover is the part that surprised me. Our two engineers built the entire marketing site from his component library in eight days and never once had to message him.', 'freelancer-design-portfolio' ),
		'name'   => __( 'Tomas Berger', 'freelancer-design-portfolio' ),
		'role'   => __( 'CTO, Coalfield', 'freelancer-design-portfolio' ),
		'avatar' => 'client-2.webp',
		'delay'  => '',
	),
	array(
		'quote'  => __( 'Fixed price, weekly demos, and in week two he told us to cut a feature rather than design it. That single conversation saved us a full quarter of engineering.', 'freelancer-design-portfolio' ),
		'name'   => __( 'Elena Marchetti', 'freelancer-design-portfolio' ),
		'role'   => __( 'Head of Product, Petrichor', 'freelancer-design-portfolio' ),
		'avatar' => 'client-3.webp',
		'delay'  => '',
	),
);
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/testimonials","name":"Testimonials","categories":["testimonials","freelancer-design-portfolio"]},"tagName":"section","anchor":"testimonials","className":"fdp-tst","style":{"spacing":{"padding":{"top":"var(\u002d\u002dfdp-sec)","bottom":"var(\u002d\u002dfdp-sec)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"backgroundColor":"mist","layout":{"type":"constrained","contentSize":"1320px"}} -->
<section id="testimonials" class="wp-block-group fdp-tst has-mist-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--fdp-sec);padding-right:var(--fdp-pad);padding-bottom:var(--fdp-sec);padding-left:var(--fdp-pad)"><!-- wp:group {"className":"fdp-sh fdp-rev","style":{"spacing":{"blockGap":"28px","margin":{"bottom":"clamp(34px, 4vw, 58px)"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group fdp-sh fdp-rev" style="margin-bottom:clamp(34px, 4vw, 58px)"><!-- wp:group {"className":"fdp-sh-l","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained","contentSize":"640px","justifyContent":"left"}} -->
<div class="wp-block-group fdp-sh-l"><!-- wp:paragraph {"className":"fdp-eyebrow","fontSize":"eyebrow"} -->
<p class="fdp-eyebrow has-eyebrow-font-size"><?php esc_html_e( 'In their words', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"d2"} -->
<h2 class="wp-block-heading has-d-2-font-size"><?php esc_html_e( 'What clients say once the invoice is paid.', 'freelancer-design-portfolio' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"fdp-btn-outline"} -->
<div class="wp-block-button fdp-btn-outline"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'Read the full cases', 'freelancer-design-portfolio' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"fdp-tst-grid","style":{"spacing":{"blockGap":{"top":"clamp(14px, 1.7vw, 22px)","left":"clamp(14px, 1.7vw, 22px)"}}}} -->
<div class="wp-block-columns fdp-tst-grid">
<?php foreach ( $fdp_quotes as $fdp_quote ) : ?>
<!-- wp:column {"className":"fdp-tst-card fdp-rev","style":{"spacing":{"blockGap":"18px","padding":{"top":"clamp(24px, 2.4vw, 32px)","bottom":"clamp(24px, 2.4vw, 32px)","left":"clamp(24px, 2.4vw, 32px)","right":"clamp(24px, 2.4vw, 32px)"}},"border":{"radius":"18px"}}} -->
<div class="wp-block-column fdp-tst-card" style="border-radius:18px;padding-top:clamp(24px, 2.4vw, 32px);padding-right:clamp(24px, 2.4vw, 32px);padding-bottom:clamp(24px, 2.4vw, 32px);padding-left:clamp(24px, 2.4vw, 32px)"><!-- wp:group {"className":"fdp-tst-top","style":{"spacing":{"blockGap":"14px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-tst-top"><!-- wp:image {"width":"96px","sizeSlug":"full","linkDestination":"none","className":"fdp-tst-stars"} -->
<figure class="wp-block-image size-full is-resized fdp-tst-stars"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/icons/stars.svg" alt="<?php esc_attr_e( 'Rated 5 out of 5', 'freelancer-design-portfolio' ); ?>" style="width:96px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"fdp-tst-quote"} -->
<p class="fdp-tst-quote"><?php echo esc_html( $fdp_quote['quote'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"fdp-tst-who","style":{"spacing":{"blockGap":"13px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group fdp-tst-who"><!-- wp:image {"width":"44px","height":"44px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( $fdp_dir ); ?>/assets/images/testimonials/<?php echo esc_attr( $fdp_quote['avatar'] ); ?>" alt="" style="object-fit:cover;width:44px;height:44px"/></figure>
<!-- /wp:image -->

<!-- wp:group {"style":{"spacing":{"blockGap":"2px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"fdp-tst-name"} -->
<p class="fdp-tst-name"><?php echo esc_html( $fdp_quote['name'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"fdp-tst-role"} -->
<p class="fdp-tst-role"><?php echo esc_html( $fdp_quote['role'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
