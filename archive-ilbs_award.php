<?php
/**
 * ILBS Alumni — Awards Archive (Premium Batch Filter)
 *
 * Awards archive intentionally renders only ilbs_award entries.
 * Publications are handled by the publication archive/homepage sections and are not shown here.
 */

get_header();

$taxonomy    = 'ilbs_batch';
$archive_url = get_post_type_archive_link( 'ilbs_award' );
if ( ! $archive_url ) {
	$archive_url = remove_query_arg( [ 'batch', 'award_year' ] );
}

$terms = get_terms( [
	'taxonomy'   => $taxonomy,
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'      => 'DESC',
] );

$active_batch      = isset( $_GET['batch'] ) ? sanitize_text_field( wp_unslash( $_GET['batch'] ) ) : '';
$active_batch_term = $active_batch ? get_term_by( 'slug', $active_batch, $taxonomy ) : false;
$active_label      = $active_batch_term && ! is_wp_error( $active_batch_term ) ? $active_batch_term->name : __( 'All', 'ilbs-alumni' );

$tax_query = [];
if ( $active_batch ) {
	$tax_query[] = [
		'taxonomy' => $taxonomy,
		'field'    => 'slug',
		'terms'    => $active_batch,
	];
}

// Keep this archive award-only even if older data used an award category named "Publication".
$publication_terms = get_terms( [
	'taxonomy'   => 'ilbs_award_cat',
	'hide_empty' => false,
] );
$publication_term_ids = [];
if ( ! empty( $publication_terms ) && ! is_wp_error( $publication_terms ) ) {
	foreach ( $publication_terms as $publication_term ) {
		if ( false !== stripos( $publication_term->slug, 'publication' ) || false !== stripos( $publication_term->name, 'publication' ) ) {
			$publication_term_ids[] = (int) $publication_term->term_id;
		}
	}
}
if ( ! empty( $publication_term_ids ) ) {
	$tax_query[] = [
		'taxonomy' => 'ilbs_award_cat',
		'field'    => 'term_id',
		'terms'    => $publication_term_ids,
		'operator' => 'NOT IN',
	];
}

$args = [
	'post_type'      => 'ilbs_award',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
];

if ( ! empty( $tax_query ) ) {
	if ( count( $tax_query ) > 1 ) {
		$tax_query['relation'] = 'AND';
	}
	$args['tax_query'] = $tax_query;
}

$query = new WP_Query( $args );
?>

<main id="main-content" class="ilbs-awards-archive-page ilbs-awards-batch-page">

	<section class="ilbs-premium-subbanner ilbs-awards-hero ilbs-awards-hero--premium" data-reveal>
		<div class="ilbs-premium-subbanner__bg" aria-hidden="true">
			<span></span><span></span><span></span>
		</div>
		<div class="container premium-container ilbs-premium-subbanner__content">
			<nav class="ilbs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ilbs-alumni' ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a>
				&rsaquo; <?php esc_html_e( 'Alumni Awards', 'ilbs-alumni' ); ?>
			</nav>
			<span class="section-kicker ilbs-eyebrow"><?php esc_html_e( 'Achievements', 'ilbs-alumni' ); ?></span>
			<h1><?php esc_html_e( 'Alumni Awards', 'ilbs-alumni' ); ?></h1>
			<p class="ilbs-section-lead"><?php esc_html_e( 'A batch-wise archive showcasing outstanding achievements, academic excellence, and professional recognition of ILBS Alumni.', 'ilbs-alumni' ); ?></p>
		</div>
	</section>

	<section class="premium-section ilbs-ref-awards-block ilbs-awards-batch-section">
		<div class="container premium-container">

			<div class="ilbs-ref-awards-archive ilbs-ref-awards-layout ilbs-awards-batch-layout">

				<aside class="ilbs-ref-awards-sidebar ilbs-awards-batch-sidebar" data-reveal>
					<span class="section-kicker ilbs-eyebrow"><?php esc_html_e( 'Browse', 'ilbs-alumni' ); ?></span>
					<h3 class="ilbs-ref-awards-sidebar__title"><?php esc_html_e( 'Explore by Batch', 'ilbs-alumni' ); ?></h3>

					<nav class="ilbs-ref-year-nav ilbs-awards-batch-nav" aria-label="<?php esc_attr_e( 'Filter awards by batch', 'ilbs-alumni' ); ?>">
						<a href="<?php echo esc_url( $archive_url ); ?>" class="ilbs-ref-year-btn <?php echo empty( $active_batch ) ? 'is-active' : ''; ?>" <?php echo empty( $active_batch ) ? 'aria-current="true"' : ''; ?>>
							<?php esc_html_e( 'All', 'ilbs-alumni' ); ?>
						</a>

						<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
							<?php foreach ( $terms as $term ) : ?>
								<a href="<?php echo esc_url( add_query_arg( 'batch', $term->slug, $archive_url ) ); ?>"
									class="ilbs-ref-year-btn <?php echo $active_batch === $term->slug ? 'is-active' : ''; ?>"
									<?php echo $active_batch === $term->slug ? 'aria-current="true"' : ''; ?>>
									<?php echo esc_html( $term->name ); ?>
								</a>
							<?php endforeach; ?>
						<?php endif; ?>
					</nav>
				</aside>

				<div class="ilbs-ref-awards-main ilbs-awards-batch-main" data-reveal>
					<div class="ilbs-awards-batch-head">
						<div>
							<span class="section-kicker ilbs-eyebrow"><?php esc_html_e( 'Award Archive', 'ilbs-alumni' ); ?></span>
							<h2 class="ilbs-ref-year-heading"><span><?php echo esc_html( $active_label ); ?></span> <?php esc_html_e( 'Awards', 'ilbs-alumni' ); ?></h2>
						</div>
						<div class="ilbs-ref-awards-search ilbs-awards-volume-search">
							<label class="visually-hidden" for="ilbsAwardSearch"><?php esc_html_e( 'Search awards', 'ilbs-alumni' ); ?></label>
							<input type="search" id="ilbsAwardSearch" placeholder="<?php esc_attr_e( 'Looking for something?', 'ilbs-alumni' ); ?>" autocomplete="off">
							<i class="bi bi-search" aria-hidden="true"></i>
						</div>
					</div>

					<div class="ilbs-ref-awards-grid ilbs-student-awards-grid" data-awards-archive-grid>
						<?php if ( $query->have_posts() ) : ?>
							<?php while ( $query->have_posts() ) : $query->the_post();
								$post_id     = get_the_ID();
								$award_name  = function_exists( 'get_field' ) ? get_field( 'award_name', $post_id ) : '';
								$department  = function_exists( 'get_field' ) ? get_field( 'department_name', $post_id ) : '';
								$batch_terms = get_the_terms( $post_id, $taxonomy );
								$batch_name  = ( $batch_terms && ! is_wp_error( $batch_terms ) && ! empty( $batch_terms[0] ) ) ? $batch_terms[0]->name : '';
								$search_data = strtolower( implode( ' ', array_filter( [ get_the_title(), $award_name, $department, $batch_name ] ) ) );
								?>

								<article class="student-award-card glass-card" data-award-card data-search="<?php echo esc_attr( $search_data ); ?>" data-reveal-item>
									<div class="student-award-card__icon" aria-hidden="true">
										<i class="bi bi-trophy-fill"></i>
									</div>

									<div class="student-award-card__body">
										<?php if ( $award_name ) : ?>
											<div class="award-badge"><?php echo esc_html( $award_name ); ?></div>
										<?php endif; ?>

										<h3 class="student-name"><?php the_title(); ?></h3>

										<?php if ( $department ) : ?>
											<div class="student-department"><i class="bi bi-hospital" aria-hidden="true"></i><?php echo esc_html( $department ); ?></div>
										<?php endif; ?>

										<?php if ( $batch_name ) : ?>
											<div class="student-batch"><i class="bi bi-mortarboard" aria-hidden="true"></i><?php printf( esc_html__( 'Batch: %s', 'ilbs-alumni' ), esc_html( $batch_name ) ); ?></div>
										<?php endif; ?>
									</div>
								</article>

							<?php endwhile; ?>
						<?php else : ?>
							<div class="ilbs-empty-state ilbs-empty-state--wide">
								<p><?php esc_html_e( 'No awards found for the selected batch.', 'ilbs-alumni' ); ?></p>
							</div>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</div>
			</article>
		</div>
	</section>

</main>

<?php get_footer(); ?>
