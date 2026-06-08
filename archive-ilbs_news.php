<?php
/**
 * ILBS Alumni — News Archive
 */
get_header();

$paged  = get_query_var('paged') ? get_query_var('paged') : 1;
$search = isset($_GET['news_search']) ? sanitize_text_field($_GET['news_search']) : '';
$type   = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';

$args = [
	'post_type'      => 'ilbs_news',
	'posts_per_page' => 9,
	'paged'          => $paged,
];

if ($search) {
	$args['s'] = $search;
}

if ($type) {
	$args['tax_query'] = [
		[
			'taxonomy' => 'ilbs_event_type',
			'field'    => 'slug',
			'terms'    => $type,
		],
	];
}

$news_query = new WP_Query($args);
$ann_types  = get_terms([
	'taxonomy'   => 'ilbs_event_type',
	'hide_empty' => false,
]);
?>

<main>

<section class="page-hero">
	<div class="container">
		<span class="eyebrow text-warning">News</span>
		<h1>News &amp; Announcements</h1>
		<p class="lead">Converted from homepage updates into searchable announcement listings.</p>
	</div>
</section>

<section class="section">
	<div class="container">

		<form class="filter-panel" method="get" action="<?php echo esc_url(get_post_type_archive_link('ilbs_news')); ?>">
			<div class="row g-3">
				<div class="col-md-7">
					<input 
						class="form-control" 
						name="news_search"
						value="<?php echo esc_attr($search); ?>"
						placeholder="Search announcements"
					>
				</div>

				<div class="col-md-3">
					<select class="form-select" name="type">
						<option value="">All Types</option>

						<?php if (!empty($ann_types) && !is_wp_error($ann_types)) : ?>
							<?php foreach ($ann_types as $term) : ?>
								<option value="<?php echo esc_attr($term->slug); ?>" <?php selected($type, $term->slug); ?>>
									<?php echo esc_html($term->name); ?>
								</option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>

				<div class="col-md-2">
					<button class="btn btn-primary w-100" type="submit">Search</button>
				</div>
			</div>
		</form>

		<div class="card-grid">

			<?php if ($news_query->have_posts()) : ?>
				<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>

					<?php
					$terms = get_the_terms(get_the_ID(), 'ilbs_event_type');
					$label = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : 'Announcement';
					?>

					<article class="story-card">
						<span><?php echo esc_html($label); ?></span>

						<h3><?php the_title(); ?></h3>

						<p><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>

						<a href="<?php the_permalink(); ?>">Read</a>
					</article>

				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<p class="text-muted" style="grid-column:1/-1;">No news found.</p>
			<?php endif; ?>

		</div>

		<div class="mt-5 d-flex justify-content-center">
			<?php
			echo paginate_links([
				'total'     => $news_query->max_num_pages,
				'current'   => $paged,
				'add_args'  => [
					'news_search' => $search,
					'type'        => $type,
				],
				'prev_text' => '<i class="bi bi-chevron-left"></i>',
				'next_text' => '<i class="bi bi-chevron-right"></i>',
			]);
			?>
		</div>

	</div>
</section>

</main>

<?php get_footer(); ?>