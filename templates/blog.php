<?php
/**
 * Template Name: ILBS — Blog Listing
 * Template Post Type: page
 *
 * Maps to: pages/blog.html
 * Shows WordPress native posts.
 */
get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
$cat_slug     = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';
$tag_slug     = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

$args = [
	'post_type'      => 'post',
	'posts_per_page' => 9,
	'paged'          => $paged,
];

if ($search_query) {
	$args['s'] = $search_query;
}

if ($cat_slug) {
	$args['category_name'] = $cat_slug;
}

if ($tag_slug) {
	$args['tag'] = $tag_slug;
}

$blog_query = new WP_Query($args);

$categories = get_categories([
	'hide_empty' => false,
]);

$tags = get_tags([
	'hide_empty' => false,
]);
?>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url(home_url()); ?>">Home</a> &rsaquo; <?php the_title(); ?>
		</div>

		<span class="eyebrow text-warning">Blog</span>
		<h1>Stories &amp; Articles</h1>
		<p class="lead">Alumni spotlights, research updates, event reports and editorial articles.</p>
	</div>
</section>

<section class="ilbs-section">
	<div class="container">

		<form class="filter-panel mb-5" method="get" action="<?php echo esc_url(get_permalink()); ?>">
			<div class="row g-3 align-items-end">

				<div class="col-md-5">
					<input 
						class="form-control" 
						id="blogSearch" 
						type="search" 
						name="search"
						value="<?php echo esc_attr($search_query); ?>"
						placeholder="Search posts..." 
						autocomplete="off"
					>
				</div>

				<div class="col-md-3">
					<select class="form-select" id="catFilter" name="cat">
						<option value="">All Categories</option>

						<?php foreach ($categories as $cat) : ?>
							<option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($cat_slug, $cat->slug); ?>>
								<?php echo esc_html($cat->name); ?> (<?php echo esc_html($cat->count); ?>)
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-2">
					<select class="form-select" id="tagFilter" name="tag">
						<option value="">All Tags</option>

						<?php foreach ($tags as $tag) : ?>
							<option value="<?php echo esc_attr($tag->slug); ?>" <?php selected($tag_slug, $tag->slug); ?>>
								<?php echo esc_html($tag->name); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-2">
					<button class="btn btn-primary w-100" type="submit">Filter</button>
				</div>

			</div>
		</form>

		<div class="row g-4" id="blogGrid">
			<?php if ($blog_query->have_posts()) :
				$delay = 0;

				while ($blog_query->have_posts()) :
					$blog_query->the_post();

					$cats      = get_the_category();
					$cat_label = $cats ? $cats[0]->name : 'Article';
			?>

				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
					<article class="story-card">

						<?php if (has_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php echo get_the_post_thumbnail(null, 'medium', [
									'style' => 'width:100%;height:160px;object-fit:cover;border-radius:6px;margin-bottom:16px;'
								]); ?>
							</a>
						<?php endif; ?>

						<span><?php echo esc_html($cat_label); ?></span>

						<h3>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>

						<p><?php echo wp_trim_words(get_the_excerpt(), 16); ?></p>

						<small style="color:var(--muted);">
							By <?php the_author(); ?> &middot; <?php echo esc_html(get_the_date()); ?>
						</small>

						<br>

						<a href="<?php the_permalink(); ?>" class="link-arrow" style="display:inline-block;margin-top:10px;">
							Read more
						</a>

					</article>
				</div>

			<?php
					$delay += 100;
				endwhile;
				wp_reset_postdata();
			else :
			?>
				<p class="text-muted">No posts found. Start writing from the WordPress admin.</p>
			<?php endif; ?>
		</div>

		<div class="mt-5 d-flex justify-content-center">
			<?php
			echo paginate_links([
				'total'     => $blog_query->max_num_pages,
				'current'   => $paged,
				'format'    => '?paged=%#%',
				'add_args'  => [
					'search' => $search_query,
					'cat'    => $cat_slug,
					'tag'    => $tag_slug,
				],
				'prev_text' => '<i class="bi bi-chevron-left"></i>',
				'next_text' => '<i class="bi bi-chevron-right"></i>',
			]);
			?>
		</div>

	</div>
</section>


<?php get_footer(); ?>