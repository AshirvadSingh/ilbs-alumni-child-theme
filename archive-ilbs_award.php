<?php
/**
 * Template: Awards Archive
 */

get_header();

$taxonomy = 'ilbs_batch';

$terms = get_terms([
	'taxonomy'   => $taxonomy,
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'      => 'DESC',
]);

$active_batch = isset($_GET['batch'])
	? sanitize_text_field(wp_unslash($_GET['batch']))
	: '';

$args = [
	'post_type'      => 'ilbs_award',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
];

if ($active_batch) {
	$args['tax_query'] = [
		[
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $active_batch,
		]
	];
}

$query = new WP_Query($args);

$archive_url = get_post_type_archive_link('ilbs_award');
?>

<main id="main-content">

	<section class="ilbs-awards-hero ilbs-awards-hero--premium">
		<div class="container position-relative">
			<span class="ilbs-eyebrow">Achievements</span>

			<h1>Alumni Awards & Publications</h1>

			<p class="ilbs-section-lead">
				A year-wise archive showcasing outstanding achievements,
				academic excellence and professional recognition of ILBS Alumni.
			</p>
		</div>
	</section>

	<section class="ilbs-section ilbs-ref-awards-block" style="padding-top:0;">
		<div class="container">

			<div class="ilbs-ref-awards-archive ilbs-ref-awards-layout">

				<aside class="ilbs-ref-awards-sidebar">

					<h3 class="ilbs-ref-awards-sidebar__title">
						Explore by Batch
					</h3>

					<nav class="ilbs-ref-year-nav">

						<a href="<?php echo esc_url($archive_url); ?>"
						   class="ilbs-ref-year-btn <?php echo empty($active_batch) ? 'is-active' : ''; ?>">
							All
						</a>

						<?php if (!empty($terms) && !is_wp_error($terms)) : ?>

							<?php foreach ($terms as $term) : ?>

								<a href="<?php echo esc_url(
									add_query_arg(
										'batch',
										$term->slug,
										$archive_url
									)
								); ?>"
								class="ilbs-ref-year-btn <?php echo $active_batch === $term->slug ? 'is-active' : ''; ?>">

									<?php echo esc_html($term->name); ?>

								</a>

							<?php endforeach; ?>

						<?php endif; ?>

					</nav>

				</aside>

				<div class="ilbs-ref-awards-main">

					<h2 class="ilbs-ref-year-heading">

						<span>
							<?php echo $active_batch ? esc_html($active_batch) : 'All'; ?>
						</span>

						Awards & Publications

					</h2>

					<div class="ilbs-ref-awards-grid">

						<?php if ($query->have_posts()) : ?>

							<?php while ($query->have_posts()) : $query->the_post();

								$award_name = function_exists('get_field')
									? get_field('award_name')
									: '';

								$department = function_exists('get_field')
									? get_field('department_name')
									: '';

								$batch_terms = get_the_terms(
									get_the_ID(),
									'ilbs_batch'
								);
								?>

								<article class="student-award-card">

									<?php if ($award_name) : ?>

										<div class="award-badge">
											<?php echo esc_html($award_name); ?>
										</div>

									<?php endif; ?>

									<h3 class="student-name">
										<?php the_title(); ?>
									</h3>

									<?php if ($department) : ?>

										<div class="student-department">
											<?php echo esc_html($department); ?>
										</div>

									<?php endif; ?>

									<?php if ($batch_terms && !is_wp_error($batch_terms)) : ?>

										<div class="student-batch">

											Batch:
											<?php echo esc_html($batch_terms[0]->name); ?>

										</div>

									<?php endif; ?>

								</article>

							<?php endwhile; ?>

						<?php else : ?>

							<div class="ilbs-empty-state">

								<p>
									No awards found for the selected batch.
								</p>

							</div>

						<?php endif; ?>

						<?php wp_reset_postdata(); ?>

					</div>

				</div>

			</div>

		</div>
	</section>

</main>

<?php get_footer(); ?>
