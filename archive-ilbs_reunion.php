<?php
/**
 * ILBS Alumni — Reunions Archive
 */
get_header();

$today = date('Ymd');
?>

<main>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url(home_url()); ?>">Home</a> &rsaquo; Reunions
		</div>
		<span class="eyebrow text-warning">Reunions</span>
		<h1>Reunions &amp; Alumni Events</h1>
		<p class="lead">Upcoming reunions, past memories, registration and photo galleries.</p>
	</div>
</section>

<nav class="subnav">
	<div class="container">
		<a href="#upcoming">Upcoming</a>
		<a href="#past">Past</a>
		<a href="#register">Registration</a>
	</div>
</nav>

<section class="section" id="upcoming">
	<div class="container">
		<div class="section-title">
			<span class="eyebrow">Upcoming</span>
			<h2>Upcoming Reunions</h2>
		</div>

		<div class="timeline">
			<?php
			$upcoming = new WP_Query([
				'post_type'      => 'ilbs_reunion',
				'posts_per_page' => -1,
				'meta_key'       => 'start_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => [
					[
						'key'     => 'start_date',
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'DATE',
					],
				],
			]);

			if ($upcoming->have_posts()) :
				while ($upcoming->have_posts()) : $upcoming->the_post();
					$start = get_field('start_date');
					$venue = get_field('venue');
			?>
				<div class="timeline-item">
					<div class="timeline-date">
						<?php echo esc_html($start ? date('M Y', strtotime($start)) : get_the_date('M Y')); ?>
					</div>

					<div class="content-card">
						<h3><?php the_title(); ?></h3>
						<p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>

						<?php if ($venue) : ?>
							<p><i class="bi bi-geo-alt me-1"></i><?php echo esc_html($venue); ?></p>
						<?php endif; ?>

						<a class="link-arrow" href="<?php the_permalink(); ?>">View Gallery</a>
					</div>
				</div>
			<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p class="text-muted">No upcoming reunions found.</p>';
			endif;
			?>
		</div>
	</div>
</section>

<section class="section" id="past">
	<div class="container">
		<div class="timeline">
<div class="section-title">
			<span class="eyebrow">Past</span>
			<h2>Past Reunions</h2>
		</div
			<?php
			$upcoming = new WP_Query([
				'post_type'      => 'ilbs_reunion',
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order'          => 'DESC'
			]);

			if ($upcoming->have_posts()) :
				while ($upcoming->have_posts()) : $upcoming->the_post();

					$start_date = get_field('start_date');
			?>

				<div class="timeline-item">

					<div class="timeline-date">
						<?php
						if ($start_date) {
							echo date('M Y', strtotime($start_date));
						} else {
							echo get_the_date('M Y');
						}
						?>
					</div>

					<div class="content-card">
						<h3><?php the_title(); ?></h3>

						<p>
							<?php
							if (get_the_excerpt()) {
								echo wp_trim_words(get_the_excerpt(), 20);
							} else {
								echo wp_trim_words(get_the_content(), 20);
							}
							?>
						</p>

						<a class="link-arrow" href="<?php the_permalink(); ?>">
							View Gallery
						</a>
					</div>

				</div>

			<?php
				endwhile;
				wp_reset_postdata();
			else :
			?>

				<div class="timeline-item">
					<div class="content-card">
						<p>No reunions found.</p>
					</div>
				</div>

			<?php endif; ?>

		</div>
	</div>
</section>
<section class="section" id="gallery">
	<div class="container">
		<div class="section-title">
			<span class="eyebrow">Gallery</span>
			<h2>Photo Memories</h2>
		</div>

		<div class="gallery-preview">
			<?php
			$gallery_posts = new WP_Query([
				'post_type'      => 'ilbs_reunion',
				'posts_per_page' => 3,
			]);

			while ($gallery_posts->have_posts()) : $gallery_posts->the_post();
			?>
				<a class="gallery-tile" href="<?php the_permalink(); ?>">
					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('large'); ?>
					<?php endif; ?>
					<span><?php the_title(); ?></span>
				</a>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>

<section class="section band-light" id="register">
	<div class="container">
		<div class="content-card">
			<h3>Registration Form</h3>

			<form class="row g-3">
				<div class="col-md-6">
					<input class="form-control" placeholder="Full name">
				</div>
				<div class="col-md-6">
					<input class="form-control" placeholder="Batch">
				</div>
				<div class="col-md-6">
					<input class="form-control" placeholder="Email">
				</div>
				<div class="col-md-6">
					<select class="form-select">
						<option>Attendance type</option>
						<option>In person</option>
						<option>Virtual</option>
					</select>
				</div>
				<div class="col-12">
					<button class="btn btn-primary">Register Interest</button>
				</div>
			</form>
		</div>
	</div>
</section>

</main>

<?php get_footer(); ?>