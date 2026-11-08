<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$people   = pp_get_people();
$p1       = trim( (string) get_theme_mod( 'pp_about_p1', '' ) );
$p2       = trim( (string) get_theme_mod( 'pp_about_p2', '' ) );
$img_id   = (int) get_theme_mod( 'pp_about_image' );
$img      = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : '';
$offers_t = (string) get_theme_mod( 'pp_offers_title', 'What %%s can help you with' );
if ( strpos( $offers_t, 'http' ) !== false ) $offers_t = 'What %s can help you with'; // safety: ignore a value polluted by the old bug
$certs_t  = (string) get_theme_mod( 'pp_certs_title', 'Certifications' );
$team_t   = (string) get_theme_mod( 'pp_team_title', 'Meet the team' );
?>
<header class="section default-header about-header" data-scroll-section>
	<?php get_template_part( 'template-parts/nav-bar' ); ?>
	<div class="container medium once-in">
		<div class="row"><div class="flex-col">
			<h1><span><?php echo esc_html( get_theme_mod( 'pp_about_h1_a', 'We are a team' ) ); ?> </span><span><?php echo esc_html( get_theme_mod( 'pp_about_h1_b', 'of creative people' ) ); ?></span></h1>
		</div></div>
	</div>
</header>

<section class="section no-padding line-globe once-in" data-scroll-section>
	<div class="container medium"><div class="row"><div class="flex-col">
		<div class="stripe"></div>
		<div class="digital-ball">
			<div class="overlay"></div>
			<div class="globe"><div class="globe-wrap">
				<div class="circle"></div><div class="circle"></div><div class="circle"></div>
				<div class="circle-hor"></div><div class="circle-hor-middle"></div>
			</div></div>
		</div>
	</div></div></div>
</section>

<?php if ( $p1 !== '' || $p2 !== '' || $img ) : ?>
<section class="section about-image once-in" data-scroll-section>
	<div class="container"><div class="row">
		<div class="flex-col">
			<div class="arrow"><?php echo pp_arrow(); // phpcs:ignore ?></div>
			<?php if ( $p1 !== '' ) : ?><p data-scroll data-scroll-speed="-1" data-scroll-position="top" data-scroll-offset="0%, -50%"><?php echo esc_html( $p1 ); ?></p><?php endif; ?>
			<?php if ( $p2 !== '' ) : ?><p data-scroll data-scroll-speed="-1" data-scroll-position="top" data-scroll-offset="0%, -50%"><span><?php echo esc_html( $p2 ); ?><span class="animate-dot">.</span><span class="animate-dot">.</span><span class="animate-dot">.</span></span></p><?php endif; ?>
		</div>
		<div class="flex-col">
			<div class="single-about-image">
				<div class="overlay overlay-image" data-scroll data-scroll-speed="-2" data-scroll-position="top" style="<?php echo $img ? 'background:url(\'' . esc_url( $img ) . '\') center center no-repeat;background-size:cover;' : ''; ?>top:-10%;height:110%"></div>
				<div class="overlay"></div>
			</div>
		</div>
	</div></div>
</section>
<?php endif; ?>

<?php if ( $people ) : ?>
<section class="section team-intro" data-scroll-section>
	<div class="container medium">
		<h2><?php echo esc_html( $team_t ); ?></h2>
		<div class="team-nav">
			<?php foreach ( $people as $p ) : ?>
			<div class="btn btn-normal">
				<a href="#<?php echo esc_attr( $p['slug'] ); ?>" class="btn-click magnetic pp-anchor" data-strength="25" data-strength-text="15">
					<div class="btn-fill"></div>
					<span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( $p['name'] ); ?></span></span>
				</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
<section class="section team-intro" data-scroll-section><div class="container medium"><p style="opacity:.6">No people yet. Go to People → Add New to add your first team member (only you see this note).</p></div></section>
<?php endif; ?>

<?php foreach ( $people as $i => $p ) :
	$alt = $i % 2 === 1;
?>
<section class="section person<?php echo $alt ? ' alt rev' : ''; ?>" id="<?php echo esc_attr( $p['slug'] ); ?>" data-scroll-section>
	<div class="container">
		<div class="row person-row">
			<div class="flex-col person-photo">
				<div class="person-photo-wrap">
					<div class="overlay" style="<?php echo $p['photo'] ? 'background-image:url(\'' . esc_url( $p['photo'] ) . '\')' : ''; ?>"></div>
				</div>
			</div>
			<div class="flex-col person-info">
				<?php if ( $p['role'] ) : ?><h5><?php echo esc_html( $p['role'] ); ?></h5><div class="stripe"></div><?php endif; ?>
				<h2><?php echo esc_html( $p['name'] ); ?></h2>
				<?php if ( $p['tagline'] ) : ?><p class="tagline"><?php echo esc_html( $p['tagline'] ); ?></p><?php endif; ?>
				<div class="person-about"><?php echo $p['about']; // phpcs:ignore ?></div>
				<?php if ( $p['email'] || $p['links'] ) : ?>
				<div class="person-links">
					<?php if ( $p['email'] ) : ?>
					<div class="btn btn-normal"><a href="mailto:<?php echo esc_attr( $p['email'] ); ?>" class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( $p['email'] ); ?></span></span></a></div>
					<?php endif; ?>
					<?php foreach ( $p['links'] as $l ) : if ( empty( $l['url'] ) ) continue; ?>
					<div class="btn btn-normal"><a href="<?php echo esc_url( $l['url'] ); ?>" target="_blank" rel="noopener" class="btn-click magnetic" data-strength="25" data-strength-text="15"><div class="btn-fill"></div><span class="btn-text"><span class="btn-text-inner change"><?php echo esc_html( $l['label'] ?: $l['url'] ); ?></span></span></a></div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $p['offers'] ) : ?>
		<div class="person-sub person-offers">
			<h5><?php echo esc_html( str_replace( '%s', $p['first'], $offers_t ) ); ?></h5>
			<div class="stripe"></div>
			<div class="person-offers-grid">
				<?php foreach ( $p['offers'] as $n => $o ) : ?>
				<div class="person-offer">
					<h5><?php echo esc_html( str_pad( (string) ( $n + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></h5>
					<div class="stripe"></div>
					<h4><?php echo esc_html( $o['title'] ?? '' ); ?></h4>
					<?php if ( ! empty( $o['text'] ) ) : ?><p><?php echo esc_html( $o['text'] ); ?></p><?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $p['certs'] ) : ?>
		<div class="person-sub person-certs">
			<h5><?php echo esc_html( $certs_t ); ?></h5>
			<div class="stripe"></div>
			<div class="person-certs-grid" data-cert-group="<?php echo esc_attr( $p['slug'] ); ?>">
				<?php foreach ( $p['certs'] as $c ) :
					$href  = $c['full'] ?: ( $c['link'] ?: '#' );
					$blank = ( ! $c['full'] && $c['link'] ) ? ' target="_blank" rel="noopener"' : '';
					$meta  = trim( ( $c['issuer'] ?: '' ) . ( $c['issuer'] && $c['date'] ? ' · ' : '' ) . ( $c['date'] ?: '' ) );
				?>
				<a class="pp-cert" href="<?php echo esc_url( $href ); ?>"<?php echo $blank; // phpcs:ignore ?>
					<?php if ( $c['full'] ) : ?> data-full="<?php echo esc_url( $c['full'] ); ?>" data-title="<?php echo esc_attr( $c['title'] ); ?>" data-meta="<?php echo esc_attr( $meta ); ?>" data-link="<?php echo esc_url( $c['link'] ); ?>"<?php endif; ?>>
					<div class="thumb"><?php if ( $c['thumb'] ) : ?><img src="<?php echo esc_url( $c['thumb'] ); ?>" alt="<?php echo esc_attr( $c['title'] ); ?>" loading="lazy"><?php else : ?><span class="ph">↗</span><?php endif; ?></div>
					<h4><?php echo esc_html( $c['title'] ); ?></h4>
					<?php if ( $meta ) : ?><p><?php echo esc_html( $meta ); ?></p><?php endif; ?>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>
<?php endforeach; ?>
<?php get_footer();
