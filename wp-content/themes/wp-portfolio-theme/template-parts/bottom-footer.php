<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="container no-padding">
					<div class="row bottom-footer">
						<div class="flex-col">
							<div class="credits"><h5>Version</h5><p><?php echo esc_html( get_theme_mod( 'pp_version', date( 'Y' ) . ' © Edition' ) ); ?></p></div>
							<div class="time"><h5>Local time</h5><p><span id="timeSpan" data-tz="<?php echo esc_attr( get_theme_mod( 'pp_timezone', 'Asia/Manila' ) ); ?>"></span></p></div>
						</div>
						<div class="flex-col">
							<?php if ( pp_socials() ) : ?>
							<div class="socials"><h5>Socials</h5><ul><?php pp_render_socials(); ?></ul><div class="stripe"></div></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
