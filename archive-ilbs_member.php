<?php
/**
 * ILBS Alumni — Alumni Directory Archive
 * Maps to: pages/members.html
 */
get_header();

// Get taxonomy terms for filters
$batches         = get_terms( [ 'taxonomy' => 'ilbs_batch',          'hide_empty' => false ] );
$specializations = get_terms( [ 'taxonomy' => 'ilbs_specialization', 'hide_empty' => false ] );
$locations       = get_terms( [ 'taxonomy' => 'ilbs_location',       'hide_empty' => false ] );
?>

<main id="main-content">

<section class="page-hero ilbs-page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; Members
		</div>
		<span class="eyebrow text-warning">Members</span>
		<h1>Alumni Directory</h1>
		<p class="lead">Search alumni by batch, specialization, location, profession, achievements and research interests.</p>
	</div>
</section>

<section class="ilbs-section section">
	<div class="container">

		<!-- Filter Panel -->
		<div class="filter-panel" id="memberFilterPanel">
			<div class="row g-3">
				<div class="col-md-3">
					<input class="form-control" id="memberSearch" type="search" name="search" placeholder="Search alumni" autocomplete="off">
				</div>
				<div class="col-md-2">
					<select class="form-select" id="filterBatch" name="batch">
						<option value="">Batch</option>
						<?php foreach ( $batches as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3">
					<select class="form-select" id="filterSpec" name="specialization">
						<option value="">Specialization</option>
						<?php foreach ( $specializations as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2">
					<select class="form-select" id="filterLocation" name="location">
						<option value="">Location</option>
						<?php foreach ( $locations as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-primary w-100" id="btnFilterMembers">Search</button>
				</div>
			</div>
		</div>

		<!-- Member Cards Grid -->
		<div class="ilbs-members-grid directory-grid" id="memberGrid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					$batches_t = wp_get_post_terms( get_the_ID(), 'ilbs_batch' );
					$batch_label = ( $batches_t && ! is_wp_error( $batches_t ) ) ? $batches_t[0]->name : '';
					$spec = wp_get_post_terms( get_the_ID(), 'ilbs_specialization' );
					$spec_label = ( $spec && ! is_wp_error( $spec ) ) ? $spec[0]->name : '';
					?>
					<article class="member-card">
						<?php if ( has_post_thumbnail() ) :
							echo get_the_post_thumbnail( null, 'thumbnail', [ 'class' => 'avatar', 'style' => 'width:82px;height:82px;object-fit:cover;border-radius:8px;margin-bottom:16px;' ] );
						else : ?>
							<div class="avatar"><i class="bi bi-person-fill"></i></div>
						<?php endif; ?>
						<h3><?php the_title(); ?></h3>
						<p><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
						<?php if ( $batch_label ) : ?>
							<span>Batch <?php echo esc_html( $batch_label ); ?></span>
						<?php endif; ?>
						<?php if ( $spec_label ) : ?>
							<p style="font-size:.85rem;margin-top:6px;color:var(--muted)"><?php echo esc_html( $spec_label ); ?></p>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="link-arrow" style="display:block;margin-top:12px">Profile</a>
					</article>
					<?php
				endwhile;
			else : ?>
				<p class="text-muted" style="grid-column:1/-1">No alumni members found. Start adding members via the WordPress admin.</p>
			<?php endif; ?>
		</div>

		<!-- Pagination -->
		<div class="mt-5 d-flex justify-content-center">
			<?php
			the_posts_pagination( [
				'mid_size'  => 2,
				'prev_text' => '<i class="bi bi-chevron-left"></i>',
				'next_text' => '<i class="bi bi-chevron-right"></i>',
			] );
			?>
		</div>

	</div>
</section>

<script>
(function() {
	const btn    = document.getElementById('btnFilterMembers');
	const grid   = document.getElementById('memberGrid');

	if (!btn || !grid) return;

	btn.addEventListener('click', function() {
		const search = document.getElementById('memberSearch').value;
		const batch  = document.getElementById('filterBatch').value;
		const spec   = document.getElementById('filterSpec').value;
		const loc    = document.getElementById('filterLocation').value;

		grid.innerHTML = '<p class="text-muted" style="grid-column:1/-1">Searching...</p>';

		const formData = new FormData();
		formData.append('action', 'ilbs_filter_members');
		formData.append('nonce',  ilbsData.nonce);
		formData.append('search', search);
		formData.append('batch',  batch);
		formData.append('specialization', spec);
		formData.append('location', loc);

		fetch(ilbsData.ajaxUrl, { method: 'POST', body: formData })
			.then(r => r.json())
			.then(data => {
				if (data.success) grid.innerHTML = data.data.html;
			})
			.catch(() => {
				grid.innerHTML = '<p class="text-muted" style="grid-column:1/-1">An error occurred. Please try again.</p>';
			});
	});

	// Allow pressing Enter in search box
	document.getElementById('memberSearch').addEventListener('keydown', e => {
		if (e.key === 'Enter') btn.click();
	});
})();
</script>

</main>

<?php get_footer(); ?>
