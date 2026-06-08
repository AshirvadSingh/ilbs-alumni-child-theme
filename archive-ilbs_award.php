<?php
/**
 * ILBS Alumni — Awards & Publications Archive (Sidebar Year Filter)
 */
get_header();

$years       = ilbs_get_award_years();
$active_year = isset( $_GET['award_year'] ) ? sanitize_text_field( wp_unslash( $_GET['award_year'] ) ) : '';

if ( ! $active_year && ! empty( $years ) ) {
	$active_year = $years[0];
}
if ( ! $active_year ) {
	$active_year = '2023';
}

$args = [
	'post_type'      => 'ilbs_award',
	'posts_per_page' => -1,
	'meta_key'       => 'award_year',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
];

if ( $active_year ) {
	$args['meta_query'] = [
		[ 'key' => 'award_year', 'value' => $active_year, 'compare' => '=' ],
	];
}

$awards      = new WP_Query( $args );
$archive_url = get_post_type_archive_link( 'ilbs_award' );

if ( empty( $years ) ) {
	$years = [ '2023', '2022', '2020', '2018', '2017', '2016', '2015', '2014' ];
}
?>

<main id="main-content">

	<section class="ilbs-awards-hero" data-reveal>
		<div class="container position-relative">
			<span class="ilbs-eyebrow"><?php esc_html_e( 'Achievements', 'ilbs-alumni' ); ?></span>
			<h1><?php esc_html_e( 'Alumni Awards & Publications', 'ilbs-alumni' ); ?></h1>
			<p class="ilbs-section-lead"><?php esc_html_e( 'Celebrating excellence and academic contributions of our alumni.', 'ilbs-alumni' ); ?></p>
		</div>
	</section>

	<section class="ilbs-section" style="padding-top:0;">
		<div class="container">
			<div class="ilbs-ref-awards-archive ilbs-ref-awards-layout">

				<aside class="ilbs-ref-awards-sidebar" aria-label="<?php esc_attr_e( 'Filter by year', 'ilbs-alumni' ); ?>">
					<h3 class="ilbs-ref-awards-sidebar__title"><?php esc_html_e( 'Filter by Year', 'ilbs-alumni' ); ?></h3>
					<nav class="ilbs-ref-year-nav">
						<?php foreach ( $years as $year ) :
							$url = add_query_arg( 'award_year', $year, $archive_url );
							?>
							<a href="<?php echo esc_url( $url ); ?>"
								class="ilbs-ref-year-btn <?php echo (string) $year === (string) $active_year ? 'is-active' : ''; ?>"
								<?php echo (string) $year === (string) $active_year ? 'aria-current="true"' : ''; ?>>
								<?php echo esc_html( $year ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				</aside>

				<div class="ilbs-ref-awards-main">
					<h2 class="ilbs-ref-year-heading">
						<span><?php echo esc_html( $active_year ); ?></span> <?php esc_html_e( 'Awards & Publications', 'ilbs-alumni' ); ?>
					</h2>

					<div class="ilbs-ref-awards-search">
						<label class="visually-hidden" for="ilbsAwardSearch"><?php esc_html_e( 'Search awards', 'ilbs-alumni' ); ?></label>
						<input type="search" id="ilbsAwardSearch" placeholder="<?php esc_attr_e( 'Looking for something?', 'ilbs-alumni' ); ?>" autocomplete="off">
						<i class="bi bi-search" aria-hidden="true"></i>
					</div>

					<div class="ilbs-ref-awards-grid" data-reveal-stagger>
						<?php if ( $awards->have_posts() ) :
							while ( $awards->have_posts() ) : $awards->the_post();
								ilbs_render_award_card( get_the_ID() );
							endwhile;
							wp_reset_postdata();
						else : ?>
							<div class="ilbs-empty-state" style="grid-column:1/-1;">
								<p><?php esc_html_e( 'No awards or publications found for this year.', 'ilbs-alumni' ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
