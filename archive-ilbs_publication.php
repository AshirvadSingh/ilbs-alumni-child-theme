<?php
/**
 * ILBS Alumni — Publications Archive
 * Maps to: pages/publications.html
 */
get_header();
$pub_types = get_terms(['taxonomy'=>'ilbs_pub_type','hide_empty'=>false]);
$active_type = sanitize_text_field($_GET['type'] ?? '');
$icon_map = ['Research Paper'=>'bi-file-earmark-pdf','Newsletter'=>'bi-journal-richtext','Annual Report'=>'bi-bar-chart-line'];
?>
<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb"><a href="<?php echo esc_url(home_url()); ?>">Home</a> &rsaquo; Publications</div>
		<span class="eyebrow text-warning">Publications</span>
		<h1>Research &amp; Publications</h1>
		<p class="lead">Research papers, alumni newsletters, annual reports and academic milestones.</p>
	</div>
</section>
<section class="ilbs-section">
	<div class="container">
		<!-- Type filter tabs -->
		<div class="d-flex flex-wrap gap-2 mb-5" id="pubTabs">
			<a href="<?php echo esc_url(get_post_type_archive_link('ilbs_publication')); ?>" class="btn btn-sm <?php echo !$active_type ? 'btn-primary' : ''; ?>" style="<?php echo $active_type ? 'border:1px solid var(--line);color:var(--text)' : ''; ?>">All</a>
			<?php foreach ($pub_types as $type) :
				$is_active = ($active_type === $type->slug);
				?>
				<a href="?type=<?php echo esc_attr($type->slug); ?>" class="btn btn-sm <?php echo $is_active ? 'btn-primary' : ''; ?>" style="<?php echo !$is_active ? 'border:1px solid var(--line);color:var(--text)' : ''; ?>"><?php echo esc_html($type->name); ?></a>
			<?php endforeach; ?>
		</div>
		<div class="resource-list">
			<?php if (have_posts()) :
				while (have_posts()) : the_post();
					$pub_type_terms = get_the_terms(get_the_ID(),'ilbs_pub_type');
					$type_name      = ($pub_type_terms && !is_wp_error($pub_type_terms)) ? $pub_type_terms[0]->name : 'Publication';
					$icon           = $icon_map[$type_name] ?? 'bi-file-earmark';
					$authors        = function_exists('get_field') ? get_field('authors') : '';
					$year           = function_exists('get_field') ? get_field('year') : get_the_date('Y');
					?>
					<a href="<?php the_permalink(); ?>">
						<i class="bi <?php echo esc_attr($icon); ?>"></i>
						<span>
							<?php the_title(); ?>
							<?php if ($authors) : ?><br><small style="font-weight:400;color:var(--muted)"><?php echo esc_html($authors); ?></small><?php endif; ?>
						</span>
						<em><?php echo esc_html($year); ?> &middot; <?php echo esc_html($type_name); ?></em>
					</a>
				<?php endwhile;
			else : ?>
				<p class="text-muted">No publications found. Add publications via the WordPress admin.</p>
			<?php endif; ?>
		</div>
		<div class="mt-5 d-flex justify-content-center">
			<?php the_posts_pagination(['prev_text'=>'<i class="bi bi-chevron-left"></i>','next_text'=>'<i class="bi bi-chevron-right"></i>']); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
