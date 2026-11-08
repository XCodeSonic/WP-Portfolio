<?php if ( ! defined( 'ABSPATH' ) ) exit;
$email = get_theme_mod( 'pp_email', 'hello@example.com' );
$phone = get_theme_mod( 'pp_phone', '' );
?>
		<div class="footer-rounded-div" data-scroll-section><div class="rounded-div-wrap"><div class="rounded-div"></div></div></div>
		<div class="footer-wrap <?php echo is_singular( 'pp_project' ) ? 'footer-case-wrap' : 'footer-footer-wrap'; ?> theme-dark" data-scroll-section>
			<footer class="section footer" data-pp-speed="-4" data-scroll data-scroll-speed="-4" data-scroll-position="bottom">
				<?php if ( is_singular( 'pp_project' ) ) : get_template_part( 'template-parts/footer-case' ); else : ?>
				<div class="container medium">
					<div class="row">
						<div class="flex-col">
							<div class="arrow"><?php echo pp_arrow(); // phpcs:ignore ?></div>
							<h2><span><div class="profile-picture"></div> <?php echo esc_html( get_theme_mod( 'pp_cta_line1', 'Let’s work' ) ); ?> </span><span><?php echo esc_html( get_theme_mod( 'pp_cta_line2', 'together' ) ); ?></span></h2>
						</div>
					</div>
					<div class="row">
						<div class="flex-col">
							<div class="stripe"></div>
							<div class="btn-fixed">
								<div class="btn btn-round" data-scroll data-scroll-speed="-1" data-scroll-direction="horizontal" data-scroll-position="bottom" data-scroll-offset="-50%, 0">
									<a href="<?php echo esc_url( pp_url( get_theme_mod( 'pp_cta_url', '/contact/' ) ) ); ?>" class="btn-click magnetic" data-strength="100" data-strength-text="50">
										<div class="btn-fill"></div>
										<span class="btn-text"><span class="btn-text-inner"><?php echo esc_html( get_theme_mod( 'pp_cta_label', 'Get in touch' ) ); ?></span></span>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="flex-col">
							<?php if ( $email ) : ?>
							<div class="btn btn-normal"><a href="mailto:<?php echo esc_attr( $email ); ?>" class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( $email ); ?></span></span></a></div>
							<?php endif; ?>
							<?php if ( $phone ) : ?>
							<div class="btn btn-normal"><a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>" class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( $phone ); ?></span></span></a></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php get_template_part( 'template-parts/bottom-footer' ); ?>
			</footer>
			<div class="overlay overlay-gradient"></div>
		</div>
	</div><!-- .main-wrap -->
</main>
<?php wp_footer(); ?>
</body>
</html>
