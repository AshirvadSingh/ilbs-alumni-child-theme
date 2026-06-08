<?php
/**
 * Template Name: About
 */
get_header();

$hero_eyebrow = get_field('about_hero_eyebrow') ?: 'Institutional Identity';
$hero_title   = get_field('about_hero_title')   ?: get_the_title();
$hero_desc    = get_field('about_hero_description');

$mission_title = get_field('mission_title');
$mission       = get_field('mission');
$mission_img   = get_field('mission_image_url');

$vision_title  = get_field('vision_title');
$vision        = get_field('vision');
$vision_img    = get_field('vision_image_url');

// SAHI — post ID 13 (front-page) se fetch hoga
$chancellor_name    = get_field('chancellor_name',    13);
$chancellor_title   = get_field('chancellor_title',   13) ?: 'Chancellor, ILBS';
$chancellor_message = get_field('chancellor_message', 13);
$chancellor_bio     = get_field('chancellor_bio',     13);
$chancellor_vision  = get_field('chancellor_vision',  13);
$chancellor_photo   = get_field('chancellor_photo',   13);

$vc_name         = get_field('vc_name',         13);
$vc_title        = get_field('vc_title',        13) ?: 'Vice Chancellor, ILBS';
$vc_message      = get_field('vc_message',      13);
$vc_bio          = get_field('vc_bio',          13);
$vc_achievements = get_field('vc_achievements', 13);
$vc_photo        = get_field('vc_photo',        13);
?>

<main>

<!-- ===================== PAGE HERO ===================== -->
<section class="page-hero">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo esc_url( home_url() ); ?>">Home</a>
				</li>
				<li class="breadcrumb-item active"><?php echo esc_html( $hero_title ); ?></li>
			</ol>
		</nav>
		<span class="eyebrow text-warning"><?php echo esc_html( $hero_eyebrow ); ?></span>
		<h1><?php echo esc_html( $hero_title ); ?></h1>
		<?php if ( $hero_desc ) : ?>
			<p class="lead"><?php echo esc_html( $hero_desc ); ?></p>
		<?php endif; ?>
	</div>
</section>

<!-- ===================== SUBNAV ===================== -->
<nav class="subnav">
	<div class="container">
		<a href="#mission">Mission</a>
		<a href="#leadership">Leadership</a>
		<a href="#objectives">Objectives</a>
		<a href="#governance">Governance</a>
		<a href="#history">History</a>
		<a href="#downloads">Downloads</a>
	</div>
</nav>

<!-- ===================== MISSION & VISION ===================== -->
<section class="section" id="mission">
	<div class="container">
		<div class="row g-4">

			<div class="col-lg-6">
				<div class="content-card">
					<span class="eyebrow">Mission</span>
					<?php if ( $mission_title ) : ?>
						<h3><?php echo esc_html( $mission_title ); ?></h3>
					<?php endif; ?>
					<?php if ( $mission ) : ?>
						<?php echo wp_kses_post( $mission ); ?>
					<?php endif; ?>
					<?php if ( $mission_img ) : ?>
						<img src="<?php echo esc_url( $mission_img ); ?>" alt="Mission" class="about-section-img">
					<?php endif; ?>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="content-card">
					<span class="eyebrow">Vision</span>
					<?php if ( $vision_title ) : ?>
						<h3><?php echo esc_html( $vision_title ); ?></h3>
					<?php endif; ?>
					<?php if ( $vision ) : ?>
						<?php echo wp_kses_post( $vision ); ?>
					<?php endif; ?>
					<?php if ( $vision_img ) : ?>
						<img src="<?php echo esc_url( $vision_img ); ?>" alt="Vision" class="about-section-img">
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- ===================== LEADERSHIP ===================== -->
<section class="section band-light" id="leadership">
	<div class="container">

		<div class="section-head compact mb-5">
			<span class="eyebrow">Leadership</span>
			<h2>Messages &amp; Leadership</h2>
		</div>

		<!-- Chancellor -->
		<article class="message-card mb-4" style="grid-template-columns:160px 1fr;padding:36px;">
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
			<div>
				<span class="eyebrow">Chancellor Message</span>
				<h2><?php echo esc_html( $chancellor_name ); ?></h2>
				<p style="color:var(--muted);font-weight:600;margin-bottom:16px;"><?php echo esc_html( $chancellor_title ); ?></p>
				<p><?php echo $chancellor_message
					? wp_kses_post( $chancellor_message )
					: 'The Institute of Liver and Biliary Sciences stands as a beacon of excellence in hepatology education and research. Our alumni carry forward the legacy of innovation, compassion and dedication to patient care that defines ILBS.';
				?></p>
				<?php if ( $chancellor_bio ) : ?>
					<h3 style="font-size:1.1rem;margin-top:18px;">Biography</h3>
					<p><?php echo wp_kses_post( $chancellor_bio ); ?></p>
				<?php endif; ?>
				<?php if ( $chancellor_vision ) : ?>
					<h3 style="font-size:1.1rem;margin-top:18px;">Vision</h3>
					<p><?php echo wp_kses_post( $chancellor_vision ); ?></p>
				<?php endif; ?>
			</div>
		</article>

		<!-- Vice Chancellor -->
		<article class="message-card" style="grid-template-columns:160px 1fr;padding:36px;">
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
			<div>
				<span class="eyebrow">Vice Chancellor Message</span>
				<h2><?php echo esc_html( $vc_name ); ?></h2>
				<p style="color:var(--muted);font-weight:600;margin-bottom:16px;"><?php echo esc_html( $vc_title ); ?></p>
				<p><?php echo $vc_message
					? wp_kses_post( $vc_message )
					: "As the world's only dedicated Liver University, ILBS continues to set unprecedented standards in medical education and research. Our alumni represent the finest in clinical care, mentorship and academic leadership.";
				?></p>
				<?php if ( $vc_achievements ) : ?>
					<h3 style="font-size:1.1rem;margin-top:18px;">Achievements</h3>
					<p><?php echo wp_kses_post( $vc_achievements ); ?></p>
				<?php endif; ?>
				<?php if ( $vc_bio ) : ?>
					<h3 style="font-size:1.1rem;margin-top:18px;">Biography</h3>
					<p><?php echo wp_kses_post( $vc_bio ); ?></p>
				<?php endif; ?>
			</div>
		</article>

	</div>
</section>

<!-- ===================== OBJECTIVES ===================== -->
<section class="section" id="objectives">
	<div class="container">
		<div class="section-head">
			<span>
				<span class="eyebrow">Objectives</span>
				<h2><?php echo esc_html( get_field('objectives_heading') ?: 'What The Association Enables' ); ?></h2>
			</span>
		</div>
		<?php if ( have_rows('objectives1') ) : ?>
			<div class="card-grid">
				<?php while ( have_rows('objectives1') ) : the_row(); ?>
					<div class="content-card">
						<?php if ( get_sub_field('icon_class') ) : ?>
							<i class="<?php echo esc_attr( get_sub_field('icon_class') ); ?>"></i>
						<?php endif; ?>
						<h3><?php echo esc_html( get_sub_field('title') ); ?></h3>
						<p><?php echo esc_html( get_sub_field('description') ); ?></p>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- ===================== GOVERNANCE ===================== -->
<section class="section band-light" id="governance">
	<div class="container">
		<div class="row g-4">
			<div class="col-lg-4">
				<h2><?php echo esc_html( get_field('governance_title') ?: 'Governance Structure' ); ?></h2>
				<?php if ( get_field('governance_description') ) : ?>
					<p><?php echo esc_html( get_field('governance_description') ); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-lg-8">
				<?php if ( have_rows('governance_rows') ) : ?>
					<table class="wp-table">
						<tr>
							<th>Body</th>
							<th>Role</th>
						</tr>
						<?php while ( have_rows('governance_rows') ) : the_row(); ?>
							<tr>
								<td><?php echo esc_html( get_sub_field('body') ); ?></td>
								<td><?php echo esc_html( get_sub_field('role') ); ?></td>
							</tr>
						<?php endwhile; ?>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- ===================== HISTORY / TIMELINE ===================== -->
<section class="section" id="history">
	<div class="container">
		<?php if ( have_rows('history') ) : ?>
			<div class="timeline">
				<?php while ( have_rows('history') ) : the_row(); ?>
					<div class="timeline-item">
						<div class="timeline-date">
							<?php echo esc_html( get_sub_field('year') ); ?>
						</div>
						<div class="content-card">
							<h3><?php echo esc_html( get_sub_field('title') ); ?></h3>
							<p><?php echo esc_html( get_sub_field('description') ); ?></p>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- ===================== DOWNLOADS ===================== -->
<section class="section band-light" id="downloads">
	<div class="container">
		<div class="section-head">
			<span>
				<span class="eyebrow">Downloads</span>
				<h2><?php echo esc_html( get_field('downloads_heading') ?: 'Brochure & Annual Reports' ); ?></h2>
			</span>
		</div>
		<?php if ( have_rows('downloads') ) : ?>
			<div class="resource-list">
				<?php while ( have_rows('downloads') ) : the_row();
					$file = get_sub_field('file');
					$url  = is_array($file) ? $file['url'] : '';
				?>
					<a href="<?php echo esc_url( $url ?: '#' ); ?>" target="_blank">
						<i class="<?php echo esc_attr( get_sub_field('icon_class') ?: 'bi bi-file-earmark-pdf' ); ?>"></i>
						<span><?php echo esc_html( get_sub_field('label') ); ?></span>
						<em><?php echo esc_html( get_sub_field('type_text') ?: 'PDF' ); ?></em>
					</a>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

</main>

<?php get_footer(); ?>