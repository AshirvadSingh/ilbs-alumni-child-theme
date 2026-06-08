<?php
/**
 * Template Name: ILBS — Vice Chancellor Message
 * Template Post Type: page
 *
 * Maps to: pages/vice-chancellor-message.html
 */
get_header();

$name         = function_exists('get_field') ? get_field('vc_name')         : 'Prof. Mradul Kumar Daga';
$title        = function_exists('get_field') ? get_field('vc_title')        : 'Vice Chancellor, Institute of Liver &amp; Biliary Sciences';
$message      = function_exists('get_field') ? get_field('vc_message')      : '';
$bio          = function_exists('get_field') ? get_field('vc_bio')          : '';
$achievements = function_exists('get_field') ? get_field('vc_achievements') : '';
$photo        = function_exists('get_field') ? get_field('vc_photo')        : '';
?>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Vice Chancellor</span>
		<h1><?php echo esc_html( $name ); ?></h1>
		<p class="lead"><?php echo esc_html( $title ); ?></p>
	</div>
</section>

<section class="ilbs-section">
	<div class="container">
		<div class="row g-5">

			<div class="col-lg-4">
				<div class="content-card text-center">
					<?php if ( $photo ) : ?>
						<img src="<?php echo esc_url( $photo ); ?>"
							alt="<?php echo esc_attr( $name ); ?>"
							style="width:180px;height:210px;object-fit:cover;border-radius:8px;margin:0 auto 20px;display:block;">
					<?php else : ?>
						<div class="portrait" style="width:180px;height:210px;font-size:4.5rem;margin:0 auto 20px;">
							<i class="bi bi-person-fill"></i>
						</div>
					<?php endif; ?>
					<h2 style="font-size:1.4rem;margin-bottom:6px;"><?php echo esc_html( $name ); ?></h2>
					<p class="eyebrow"><?php echo esc_html( $title ); ?></p>
				</div>
			</div>

			<div class="col-lg-8">
				<div class="content-card mb-4">
					<span class="eyebrow">Message</span>
					<div class="mt-3" style="font-size:1.08rem;line-height:1.8;">
						<?php if ( get_the_content() ) :
							the_content();
						elseif ( $message ) :
							echo wp_kses_post( $message );
						else : ?>
							<p>As the world's only dedicated Liver University, ILBS continues to set unprecedented standards in medical education and research. Our alumni represent the finest in clinical care, mentorship and academic leadership.</p>
							<p>The alumni network is a testament to what a focused, passionate community can achieve — connecting practitioners and researchers across the globe in service of advancing liver and biliary sciences.</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $achievements ) : ?>
				<div class="content-card mb-4">
					<span class="eyebrow">Achievements</span>
					<div class="mt-3"><?php echo wp_kses_post( $achievements ); ?></div>
				</div>
				<?php endif; ?>

				<?php if ( $bio ) : ?>
				<div class="content-card">
					<span class="eyebrow">Biography</span>
					<div class="mt-3"><?php echo wp_kses_post( $bio ); ?></div>
				</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
