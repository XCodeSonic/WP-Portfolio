<?php
/**
 * Title: FAQ
 * Slug: freelancer-design-portfolio/faq
 * Categories: text, freelancer-design-portfolio
 * Description: Frequently asked questions in an accordion beside a short section heading.
 */
$fdp_faqs = array(
	array(
		'q'    => __( 'How long does a project usually take?', 'freelancer-design-portfolio' ),
		'a'    => __( 'A full product engagement runs six weeks end to end. An identity is three to four. A second opinion is one week. If your deadline is tighter than that, tell me early and I will say honestly whether it fits.', 'freelancer-design-portfolio' ),
		'open' => true,
	),
	array(
		'q'    => __( 'Is the price fixed?', 'freelancer-design-portfolio' ),
		'a'    => __( 'Yes, wherever the scope is defined. One number, one payment schedule and a written list of what sits inside it. Anything outside becomes a conversation before work starts, never a surprise line on an invoice.', 'freelancer-design-portfolio' ),
		'open' => false,
	),
	array(
		'q'    => __( 'Can you work alongside our engineers?', 'freelancer-design-portfolio' ),
		'a'    => __( 'That is the normal arrangement. I join your stand-ups, write specs in whatever format your team already uses, and stay reachable for a month after handover so questions get answered rather than guessed at.', 'freelancer-design-portfolio' ),
		'open' => false,
	),
	array(
		'q'    => __( 'What lands in my hands at the end?', 'freelancer-design-portfolio' ),
		'a'    => __( 'Source files, a component library with every state documented, a token sheet, exported assets and a written spec covering behaviour and edge cases. Build engagements also include block patterns and a configured theme.json.', 'freelancer-design-portfolio' ),
		'open' => false,
	),
	array(
		'q'    => __( 'Do you take small pieces of work?', 'freelancer-design-portfolio' ),
		'a'    => __( 'Sometimes. A single landing page, a pricing rewrite or a one-week review all fit comfortably. Anything larger tends to work better as a short sprint than as hours scattered across a quarter.', 'freelancer-design-portfolio' ),
		'open' => false,
	),
	array(
		'q'    => __( 'Who owns the work at the end?', 'freelancer-design-portfolio' ),
		'a'    => __( 'You do, completely, once the final payment clears. Files transfer into your accounts rather than living in mine. I only ask permission to show the work publicly, and I will keep it private if you would rather.', 'freelancer-design-portfolio' ),
		'open' => false,
	),
);
?>
<!-- wp:group {"metadata":{"patternName":"freelancer-design-portfolio/faq","name":"FAQ","categories":["text","freelancer-design-portfolio"]},"tagName":"section","anchor":"faq","className":"fdp-faq","style":{"spacing":{"padding":{"top":"var(\u002d\u002dfdp-sec)","bottom":"var(\u002d\u002dfdp-sec)","left":"var(\u002d\u002dfdp-pad)","right":"var(\u002d\u002dfdp-pad)"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"border":{"top":{"color":"#E3E5DE","width":"1px"}}},"backgroundColor":"shell","layout":{"type":"constrained","contentSize":"1320px"}} -->
<section id="faq" class="wp-block-group fdp-faq has-shell-background-color has-background" style="border-top-color:#E3E5DE;border-top-width:1px;margin-top:0;margin-bottom:0;padding-top:var(--fdp-sec);padding-right:var(--fdp-pad);padding-bottom:var(--fdp-sec);padding-left:var(--fdp-pad)"><!-- wp:columns {"className":"fdp-faq-grid","style":{"spacing":{"blockGap":{"top":"clamp(28px, 4vw, 64px)","left":"clamp(28px, 4vw, 64px)"}}}} -->
<div class="wp-block-columns fdp-faq-grid"><!-- wp:column {"width":"39%","className":"fdp-rev","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column fdp-rev" style="flex-basis:39%"><!-- wp:paragraph {"className":"fdp-eyebrow","fontSize":"eyebrow"} -->
<p class="fdp-eyebrow has-eyebrow-font-size"><?php esc_html_e( 'FAQ', 'freelancer-design-portfolio' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"spacing":{"margin":{"top":"18px","bottom":"20px"}}},"fontSize":"d2"} -->
<h2 class="wp-block-heading has-d-2-font-size" style="margin-top:18px;margin-bottom:20px"><?php esc_html_e( 'Asked before nearly every project.', 'freelancer-design-portfolio' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"fdp-faq-list fdp-rev","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column fdp-faq-list">
<?php foreach ( $fdp_faqs as $fdp_faq ) : ?>
<!-- wp:details {"showContent":<?php echo $fdp_faq['open'] ? 'true' : 'false'; ?>,"summary":"<?php echo esc_attr( $fdp_faq['q'] ); ?>","className":"fdp-faq-item"} -->
<details class="wp-block-details fdp-faq-item"<?php echo $fdp_faq['open'] ? ' open' : ''; ?>><summary><?php echo esc_html( $fdp_faq['q'] ); ?></summary><!-- wp:paragraph -->
<p><?php echo esc_html( $fdp_faq['a'] ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<?php endforeach; ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
