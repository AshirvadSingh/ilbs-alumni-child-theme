<?php
/**
 * Template Name: ILBS — Chancellor Message
 * Template Post Type: page
 *
 * Maps to: pages/chancellor-message.html
 * Full-page dedicated chancellor message (linked from homepage).
 */
get_header();

$name    = function_exists('get_field') ? get_field('chancellor_name')    : 'Sr. Prof. S.K. Sarin';
$title   = function_exists('get_field') ? get_field('chancellor_title')   : 'Chancellor, Institute of Liver &amp; Biliary Sciences';
$message = function_exists('get_field') ? get_field('chancellor_message') : '';
$bio     = function_exists('get_field') ? get_field('chancellor_bio')     : '';
$vision  = function_exists('get_field') ? get_field('chancellor_vision')  : '';
$photo   = function_exists('get_field') ? get_field('chancellor_photo')   : '';
?>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Chancellor</span>
		<h1><?php echo esc_html( $name ); ?></h1>
		<p class="lead"><?php echo esc_html( $title ); ?></p>
	</div>
</section>

<section class="ilbs-section">
	<div class="container">
		<div class="row g-5">

			<!-- Photo + Quick Info -->
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

			<!-- Full Message -->
			<div class="col-lg-8">
				<div class="content-card mb-4">
					<span class="eyebrow">Message</span>
					<div class="mt-3" style="font-size:1.08rem;line-height:1.8;">
						<?php if ( get_the_content() ) :
							the_content();
						elseif ( $message ) :
							echo wp_kses_post( $message );
						else : ?>
							<p>The Institute of Liver and Biliary Sciences stands as a beacon of excellence in hepatology education and research. Our alumni carry forward the legacy of innovation, compassion and dedication to patient care that defines ILBS.</p>
							<p>I am deeply proud of each graduate who goes on to contribute meaningfully to liver sciences — through clinical practice, research, teaching and global collaboration. The alumni association is the living embodiment of ILBS's lasting impact.</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $bio ) : ?>
				<div class="content-card mb-4">
					<span class="eyebrow">Biography</span>
					<div class="mt-3"><?php echo wp_kses_post( $bio ); ?></div>
				</div>
				<?php endif; ?>

				<?php if ( $vision ) : ?>
				<div class="content-card">
					<span class="eyebrow">Vision</span>
					<div class="mt-3"><?php echo wp_kses_post( $vision ); ?></div>
				</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
