<?php
/**
 * Template Name: ILBS — Leadership
 * Template Post Type: page
 *
 * Maps to: pages/leadership.html
 * Shows Chancellor + Vice Chancellor messages with photo, bio, vision sections.
 */
get_header();

// ACF fields — set on this page in admin
$chancellor_name    = function_exists('get_field') ? get_field('chancellor_name')    : 'Sr. Prof. S.K. Sarin';
$chancellor_title   = function_exists('get_field') ? get_field('chancellor_title')   : 'Chancellor, ILBS';
$chancellor_message = function_exists('get_field') ? get_field('chancellor_message') : '';
$chancellor_bio     = function_exists('get_field') ? get_field('chancellor_bio')     : '';
$chancellor_vision  = function_exists('get_field') ? get_field('chancellor_vision')  : '';
$chancellor_photo   = function_exists('get_field') ? get_field('chancellor_photo')   : ''; // image URL

$vc_name            = function_exists('get_field') ? get_field('vc_name')            : 'Prof. Mradul Kumar Daga';
$vc_title           = function_exists('get_field') ? get_field('vc_title')           : 'Vice Chancellor, ILBS';
$vc_message         = function_exists('get_field') ? get_field('vc_message')         : '';
$vc_bio             = function_exists('get_field') ? get_field('vc_bio')             : '';
$vc_achievements    = function_exists('get_field') ? get_field('vc_achievements')    : '';
$vc_photo           = function_exists('get_field') ? get_field('vc_photo')           : ''; // image URL
?>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( get_permalink( get_page_by_path('about') ) ); ?>">About</a> &rsaquo;
			<?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Leadership</span>
		<h1>Messages &amp; Leadership</h1>
		<p class="lead">Institutional voices guiding alumni engagement, academic excellence and global collaboration.</p>
	</div>
</section>

<!-- Chancellor Message -->
<section class="ilbs-section" id="chancellor">
	<div class="container">
		<article class="message-card" style="grid-template-columns:160px 1fr;padding:40px;">

			<!-- Photo -->
			<div>
				<?php if ( $chancellor_photo ) : ?>
					<img src="<?php echo esc_url( $chancellor_photo ); ?>"
						alt="<?php echo esc_attr( $chancellor_name ); ?>"
						style="width:160px;height:190px;object-fit:cover;border-radius:8px;">
				<?php else : ?>
					<div class="portrait" style="width:160px;height:190px;font-size:4rem;">
						<i class="bi bi-person-fill"></i>
					</div>
				<?php endif; ?>
			</div>

			<!-- Content -->
			<div>
				<span class="eyebrow">Chancellor Message</span>
				<h2><?php echo esc_html( $chancellor_name ); ?></h2>
				<p style="color:var(--muted);font-weight:600;margin-bottom:20px;"><?php echo esc_html( $chancellor_title ); ?></p>

				<p><?php echo $chancellor_message
					? wp_kses_post( $chancellor_message )
					: 'The Institute of Liver and Biliary Sciences stands as a beacon of excellence in hepatology education and research. Our alumni carry forward the legacy of innovation, compassion and dedication to patient care that defines ILBS.';
				?></p>

				<?php if ( $chancellor_bio ) : ?>
					<h3 style="font-size:1.2rem;margin-top:24px;">Biography</h3>
					<p><?php echo wp_kses_post( $chancellor_bio ); ?></p>
				<?php else : ?>
					<h3 style="font-size:1.2rem;margin-top:24px;">Biography</h3>
					<p>Senior academic leader, institution builder and internationally recognised liver sciences expert.</p>
				<?php endif; ?>

				<?php if ( $chancellor_vision ) : ?>
					<h3 style="font-size:1.2rem;margin-top:24px;">Vision</h3>
					<p><?php echo wp_kses_post( $chancellor_vision ); ?></p>
				<?php else : ?>
					<h3 style="font-size:1.2rem;margin-top:24px;">Vision</h3>
					<p>To strengthen ILBS as a global academic community where alumni mentor, publish, collaborate and serve society.</p>
				<?php endif; ?>
			</div>

		</article>
	</div>
</section>

<!-- Vice Chancellor Message -->
<section class="ilbs-section band-light" id="vice-chancellor">
	<div class="container">
		<article class="message-card" style="grid-template-columns:160px 1fr;padding:40px;">

			<!-- Photo -->
			<div>
				<?php if ( $vc_photo ) : ?>
					<img src="<?php echo esc_url( $vc_photo ); ?>"
						alt="<?php echo esc_attr( $vc_name ); ?>"
						style="width:160px;height:190px;object-fit:cover;border-radius:8px;">
				<?php else : ?>
					<div class="portrait" style="width:160px;height:190px;font-size:4rem;">
						<i class="bi bi-person-fill"></i>
					</div>
				<?php endif; ?>
			</div>

			<!-- Content -->
			<div>
				<span class="eyebrow">Vice Chancellor Message</span>
				<h2><?php echo esc_html( $vc_name ); ?></h2>
				<p style="color:var(--muted);font-weight:600;margin-bottom:20px;"><?php echo esc_html( $vc_title ); ?></p>

				<p><?php echo $vc_message
					? wp_kses_post( $vc_message )
					: "As the world's only dedicated Liver University, ILBS continues to set unprecedented standards in medical education and research. Our alumni represent the finest in clinical care, mentorship and academic leadership.";
				?></p>

				<?php if ( $vc_achievements ) : ?>
					<h3 style="font-size:1.2rem;margin-top:24px;">Achievements</h3>
					<p><?php echo wp_kses_post( $vc_achievements ); ?></p>
				<?php else : ?>
					<h3 style="font-size:1.2rem;margin-top:24px;">Achievements</h3>
					<p>Academic stewardship, research mentorship and support for high-impact publications and international presentations.</p>
				<?php endif; ?>
			</div>

		</article>
	</div>
</section>

<?php get_footer(); ?>
