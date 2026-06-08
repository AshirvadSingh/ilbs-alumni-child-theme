<?php
/**
 * ILBS Alumni — Generic Single Template
 */
get_header();

$post_type       = get_post_type();
$post_type_obj   = get_post_type_object($post_type);
$archive_link    = get_post_type_archive_link($post_type);
$post_type_label = $post_type_obj->labels->name ?? 'Blog';

while (have_posts()) :
	the_post();

	$start_date = function_exists('get_field') ? get_field('start_date') : '';
	$venue      = function_exists('get_field') ? get_field('venue') : '';
	$speaker    = function_exists('get_field') ? get_field('speaker') : '';
	$video_url  = function_exists('get_field') ? get_field('video_url') : '';
	$pdf_file   = function_exists('get_field') ? get_field('pdf_file') : '';
	$reg_url    = function_exists('get_field') ? get_field('registration_url') : '';
	$doi        = function_exists('get_field') ? get_field('doi') : '';
	$abstract   = function_exists('get_field') ? get_field('abstract') : '';

	$cats = get_the_category();
	$hero_label = ($post_type === 'post' && !empty($cats)) ? $cats[0]->name : $post_type_label;

	$related = new WP_Query([
		'post_type'      => $post_type,
		'posts_per_page' => 2,
		'post__not_in'   => [get_the_ID()],
	]);
?>

<main>

<section class="page-hero">
	<div class="container">
		<span class="eyebrow text-warning"><?php echo esc_html($hero_label); ?></span>
		<h1><?php the_title(); ?></h1>

		<p class="lead">
			<?php if ($post_type === 'post') : ?>
				By <?php the_author(); ?> | <?php echo esc_html(get_the_date('M d, Y')); ?>
			<?php else : ?>
				<?php
				echo $start_date ? esc_html(date('M d, Y', strtotime($start_date))) : esc_html(get_the_date('M d, Y'));
				if ($venue) echo ' | ' . esc_html($venue);
				if ($speaker) echo ' | ' . esc_html($speaker);
				?>
			<?php endif; ?>
		</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="row g-4">

			<article class="col-lg-8">
				<div class="content-card">

					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('large', [
							'style' => 'width:100%;height:360px;object-fit:cover;border-radius:12px;margin-bottom:24px;'
						]); ?>
					<?php endif; ?>

					<?php if ($abstract) : ?>
						<p><?php echo wp_kses_post($abstract); ?></p>
					<?php endif; ?>

					<?php the_content(); ?>

					<?php if ($video_url || $pdf_file || $reg_url || $doi) : ?>
						<h3>Resources</h3>
						<div class="resource-list">

							<?php if ($video_url) : ?>
								<a href="<?php echo esc_url($video_url); ?>" target="_blank">
									<span>Watch Video</span>
									<em>Video</em>
								</a>
							<?php endif; ?>

							<?php if ($pdf_file) :
								$pdf_url = is_array($pdf_file) ? $pdf_file['url'] : $pdf_file;
							?>
								<a href="<?php echo esc_url($pdf_url); ?>" target="_blank">
									<span>Download PDF</span>
									<em>PDF</em>
								</a>
							<?php endif; ?>

							<?php if ($doi) : ?>
								<a href="<?php echo esc_url($doi); ?>" target="_blank">
									<span>View DOI</span>
									<em>Research</em>
								</a>
							<?php endif; ?>

							<?php if ($reg_url) : ?>
								<a href="<?php echo esc_url($reg_url); ?>" target="_blank">
									<span>Register Now</span>
									<em>Event</em>
								</a>
							<?php endif; ?>

						</div>
					<?php endif; ?>

					<?php if ($related->have_posts()) : ?>
						<h3>Related Posts</h3>
						<div class="resource-list">
							<?php while ($related->have_posts()) : $related->the_post(); ?>
								<a href="<?php the_permalink(); ?>">
									<span><?php the_title(); ?></span>
									<em><?php echo esc_html($hero_label); ?></em>
								</a>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					<?php endif; ?>

					

				</div>
			</article>

			<aside class="col-lg-4">
				<div class="content-card">

					<?php if ($post_type === 'post') : ?>
						<h3>Author</h3>
						<p>
							<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
								<?php the_author(); ?>
							</a><br>
							<?php
							$bio = get_the_author_meta('description');
							echo $bio ? esc_html($bio) : 'Research contributor and alumni editor.';
							?>
						</p>
					<?php else : ?>
						<h3><?php echo esc_html($post_type_label); ?> Details</h3>
						<p>
							<?php if ($start_date) : ?>
								Date: <?php echo esc_html(date('M d, Y', strtotime($start_date))); ?><br>
							<?php endif; ?>

							<?php if ($venue) : ?>
								Venue: <?php echo esc_html($venue); ?><br>
							<?php endif; ?>

							<?php if ($speaker) : ?>
								Speaker: <?php echo esc_html($speaker); ?><br>
							<?php endif; ?>
						</p>

						<?php if ($archive_link) : ?>
							<a href="<?php echo esc_url($archive_link); ?>" class="btn btn-primary">
								Back to <?php echo esc_html($post_type_label); ?>
							</a>
						<?php endif; ?>
					<?php endif; ?>

				</div>
			</aside>

		</div>
	</div>
</section>

</main>

<?php endwhile; ?>

<?php get_footer(); ?>