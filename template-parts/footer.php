<?php
/**
 * ILBS Alumni — Premium Footer
 */
$home_url     = home_url( '/' );
$about_page   = get_page_by_path( 'about' );
$contact_page = get_page_by_path( 'contact' );
?>
<footer class="ilbs-footer footer" role="contentinfo">
	<svg class="ilbs-svg-decor" style="top:10%;right:-5%;width:400px;height:400px;" viewBox="0 0 400 400" fill="none" aria-hidden="true">
		<circle cx="200" cy="200" r="180" stroke="rgba(94,234,212,0.12)" stroke-width="1"/>
		<circle cx="200" cy="200" r="120" stroke="rgba(94,234,212,0.08)" stroke-width="1"/>
	</svg>

	<div class="container position-relative">
		<div class="row g-5">

			<div class="col-lg-4" data-reveal>
				<h2 class="h3 mb-3">ILBS Alumni</h2>
				<p>
					<?php esc_html_e( 'Connecting graduates, researchers, clinicians and professionals from the Institute of Liver & Biliary Sciences through lifelong networking, collaboration and academic excellence.', 'ilbs-alumni' ); ?>
				</p>
				<p class="mt-4 mb-0">
					<strong><?php esc_html_e( 'Address', 'ilbs-alumni' ); ?></strong><br>
					<?php esc_html_e( 'Institute of Liver & Biliary Sciences (ILBS)', 'ilbs-alumni' ); ?><br>
					<?php esc_html_e( 'D-1, Vasant Kunj, New Delhi – 110070, India', 'ilbs-alumni' ); ?>
				</p>
			</div>

			<div class="col-6 col-lg-2" data-reveal>
				<h3 class="h5 mb-3"><?php esc_html_e( 'Quick Links', 'ilbs-alumni' ); ?></h3>
				<?php if ( $about_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $about_page ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'About Us', 'ilbs-alumni' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'Alumni Directory', 'ilbs-alumni' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'Reunions', 'ilbs-alumni' ); ?></a>
				<?php if ( $contact_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $contact_page ) ); ?>" class="d-block"><?php esc_html_e( 'Contact Us', 'ilbs-alumni' ); ?></a>
				<?php endif; ?>
			</div>

			<div class="col-6 col-lg-2" data-reveal>
				<h3 class="h5 mb-3"><?php esc_html_e( 'Resources', 'ilbs-alumni' ); ?></h3>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_publication' ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'Publications', 'ilbs-alumni' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'Awards', 'ilbs-alumni' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_news' ) ); ?>" class="d-block"><?php esc_html_e( 'News & Updates', 'ilbs-alumni' ); ?></a>
			</div>

			<div class="col-6 col-lg-2" data-reveal>
				<h3 class="h5 mb-3"><?php esc_html_e( 'Community', 'ilbs-alumni' ); ?></h3>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'Alumni Network', 'ilbs-alumni' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>" class="d-block mb-2"><?php esc_html_e( 'Events', 'ilbs-alumni' ); ?></a>
				<?php $video_page = get_page_by_path( 'video' ); if ( $video_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $video_page ) ); ?>" class="d-block"><?php esc_html_e( 'Alumni Stories', 'ilbs-alumni' ); ?></a>
				<?php endif; ?>
			</div>

			<div class="col-lg-2" data-reveal>
				<h3 class="h5 mb-3"><?php esc_html_e( 'Connect', 'ilbs-alumni' ); ?></h3>
				<p class="mb-2"><a href="mailto:alumni@ilbs.in">alumni@ilbs.in</a></p>
				<p class="mb-4">+91 11 4630 0000</p>
				<div class="socials d-flex gap-2">
					<a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin" aria-hidden="true"></i></a>
					<a href="#" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
					<a href="#" aria-label="X"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>
					<a href="#" aria-label="YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a>
				</div>
			</div>

		</div>

		<div class="row mt-5 pt-5 border-top border-light border-opacity-10 align-items-center g-4" data-reveal>
			<div class="col-lg-6">
				<h4 class="h5 text-white mb-2"><?php esc_html_e( 'Stay Connected', 'ilbs-alumni' ); ?></h4>
				<p class="mb-0"><?php esc_html_e( 'Subscribe for alumni news, events, publications and networking opportunities.', 'ilbs-alumni' ); ?></p>
			</div>
			<div class="col-lg-6">
				<form class="d-flex flex-column flex-sm-row gap-2" action="#" method="post">
					<label class="visually-hidden" for="footer-email"><?php esc_html_e( 'Email address', 'ilbs-alumni' ); ?></label>
					<input type="email" id="footer-email" class="form-control" placeholder="<?php esc_attr_e( 'Enter your email', 'ilbs-alumni' ); ?>" required>
					<button type="submit" class="ilbs-btn ilbs-btn--primary" data-magnetic><?php esc_html_e( 'Subscribe', 'ilbs-alumni' ); ?></button>
				</form>
			</div>
		</div>

		<div class="ilbs-footer-bottom footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'ILBS Alumni Association. All Rights Reserved.', 'ilbs-alumni' ); ?></span>
			<div class="d-flex gap-3">
				<a href="#"><?php esc_html_e( 'Privacy Policy', 'ilbs-alumni' ); ?></a>
				<a href="#"><?php esc_html_e( 'Terms', 'ilbs-alumni' ); ?></a>
				<a href="#"><?php esc_html_e( 'Sitemap', 'ilbs-alumni' ); ?></a>
			</div>
		</div>
	</div>
</footer>
