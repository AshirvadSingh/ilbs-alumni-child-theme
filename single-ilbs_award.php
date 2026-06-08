<?php
/**
 * ILBS Alumni — Single Award / Publication (Simple Premium Layout)
 */
get_header();

while ( have_posts() ) :
	the_post();

	$post_id    = get_the_ID();
	$award_year = function_exists( 'get_field' ) ? get_field( 'award_year' ) : get_the_date( 'Y' );
	$title      = function_exists( 'get_field' ) && get_field( 'award_display_name' ) ? get_field( 'award_display_name' ) : get_the_title();
	$name       = ilbs_get_award_recipient_name( $post_id );
	$dept       = ilbs_get_award_department( $post_id );
	$is_pub     = ilbs_award_is_publication( $post_id );
	$pdf        = function_exists( 'get_field' ) ? get_field( 'pdf_file' ) : '';
	if ( is_array( $pdf ) && isset( $pdf['url'] ) ) {
		$pdf = $pdf['url'];
	}

	$related_args = [
		'post_type'      => 'ilbs_award',
		'posts_per_page' => 3,
		'post__not_in'   => [ $post_id ],
		'meta_key'       => 'award_year',
		'orderby'        => 'rand',
	];
	if ( $award_year ) {
		$related_args['meta_query'] = [
			[ 'key' => 'award_year', 'value' => $award_year, 'compare' => '=' ],
		];
	}
	$related = new WP_Query( $related_args );
	?>

<main id="main-content">

	<section class="ilbs-page-hero page-hero">
		<div class="container">
			<nav class="ilbs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ilbs-alumni' ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a> &rsaquo;
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>"><?php esc_html_e( 'Awards & Publications', 'ilbs-alumni' ); ?></a> &rsaquo;
				<span><?php echo esc_html( wp_trim_words( $title, 6 ) ); ?></span>
			</nav>
			<?php if ( $award_year ) : ?>
				<span class="ilbs-badge mb-3"><?php echo esc_html( $award_year ); ?></span>
			<?php endif; ?>
			<h1><?php echo esc_html( $title ); ?></h1>
		</div>
	</section>

	<section class="ilbs-section">
		<div class="container">
			<article class="ilbs-single-award">

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="ilbs-single-award__thumb">
						<?php the_post_thumbnail( 'large', [ 'loading' => 'lazy' ] ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $name ) : ?>
					<p><strong><?php echo esc_html( $is_pub ? __( 'Authors', 'ilbs-alumni' ) : __( 'Recipient', 'ilbs-alumni' ) ); ?>:</strong> <?php echo esc_html( $name ); ?></p>
				<?php endif; ?>

				<?php if ( $dept ) : ?>
					<p><strong><?php esc_html_e( 'Department', 'ilbs-alumni' ); ?>:</strong> <?php echo esc_html( $dept ); ?></p>
				<?php endif; ?>

				<div class="entry-content ilbs-section-lead" style="max-width:100%;">
					<?php the_content(); ?>
				</div>

				<div class="ilbs-single-award__actions">
					<?php if ( $pdf ) : ?>
						<a href="<?php echo esc_url( $pdf ); ?>" class="ilbs-btn ilbs-btn--primary" target="_blank" rel="noopener">
							<i class="bi bi-file-earmark-pdf" aria-hidden="true"></i> <?php esc_html_e( 'Download PDF', 'ilbs-alumni' ); ?>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>" class="ilbs-btn ilbs-btn--outline">
						<i class="bi bi-arrow-left" aria-hidden="true"></i> <?php esc_html_e( 'Back to Awards', 'ilbs-alumni' ); ?>
					</a>
				</div>

				<?php if ( $related->have_posts() ) : ?>
					<div class="mt-5 pt-5 border-top">
						<h2 class="h4 mb-4"><?php esc_html_e( 'Related Awards & Publications', 'ilbs-alumni' ); ?></h2>
						<div class="ilbs-related-grid">
							<?php while ( $related->have_posts() ) : $related->the_post(); ?>
								<article class="ilbs-card ilbs-card__body">
									<h3 class="h6 mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<a href="<?php the_permalink(); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'View', 'ilbs-alumni' ); ?></a>
								</article>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
				<?php endif; ?>

			</article>
		</div>
	</section>

</main>

<?php endwhile; ?>

<?php get_footer(); ?>
