<?php
/**
 * ILBS Alumni — Awards & Publications Archive (Premium Year Filters)
 */

get_header();

$taxonomy = 'ilbs_batch';

if ( empty( $years ) ) {
	$years = [ '2023', '2022', '2020', '2018', '2017', '2016', '2015', '2014' ];
}
if ( ! $active_year ) {
	$active_year = $years[0];
}

$all_items     = ilbs_get_award_publication_items();
$items         = array_values( array_filter( $all_items, function ( $item ) use ( $active_year ) {
	return (string) ilbs_get_award_item_year( $item->ID ) === (string) $active_year;
} ) );
$award_items   = array_values( array_filter( $items, function ( $item ) {
	return ! ilbs_is_publication_item( $item->ID );
} ) );
$pub_items     = array_values( array_filter( $items, function ( $item ) {
	return ilbs_is_publication_item( $item->ID );
} ) );
$archive_url   = get_post_type_archive_link( 'ilbs_award' );
$active_index  = array_search( (string) $active_year, array_map( 'strval', $years ), true );
$volume_number = false === $active_index ? count( $years ) : count( $years ) - (int) $active_index;
?>

<main id="main-content" class="ilbs-awards-archive-page">

	<section class="ilbs-premium-subbanner ilbs-awards-hero ilbs-awards-hero--premium" data-reveal>
		<div class="ilbs-premium-subbanner__bg" aria-hidden="true">
			<span></span><span></span><span></span>
		</div>
		<div class="container premium-container ilbs-premium-subbanner__content">
			<nav class="ilbs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ilbs-alumni' ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a>
				&rsaquo; <?php esc_html_e( 'Awards & Publications', 'ilbs-alumni' ); ?>
			</nav>
			<span class="section-kicker ilbs-eyebrow"><?php esc_html_e( 'Archive', 'ilbs-alumni' ); ?></span>
			<h1><?php esc_html_e( 'Alumni awards & publications.', 'ilbs-alumni' ); ?></h1>
			<p class="ilbs-section-lead"><?php esc_html_e( 'A scholarly record of recognition, research output, and academic milestones — year by year.', 'ilbs-alumni' ); ?></p>
		</div>
	</section>

	<section class="premium-section ilbs-awards-volume-section">
		<div class="container premium-container">
			<div class="ilbs-awards-toolbar glass-card">
				<div>
					<span class="section-kicker ilbs-eyebrow"><?php esc_html_e( 'Browse by year', 'ilbs-alumni' ); ?></span>
					<h2><?php esc_html_e( 'Select an academic volume', 'ilbs-alumni' ); ?></h2>
				</div>
				<nav class="ilbs-ref-year-nav ilbs-awards-year-pills" aria-label="<?php esc_attr_e( 'Filter by year', 'ilbs-alumni' ); ?>">
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
			</div>

			<article class="ilbs-awards-volume-card" data-reveal>
				<aside class="ilbs-awards-volume-card__year">
					<div>
						<p><?php printf( esc_html__( 'Volume %d', 'ilbs-alumni' ), (int) $volume_number ); ?></p>
						<strong><?php echo esc_html( $active_year ); ?></strong>
					</div>
					<a href="#awardVolumeContent" class="ilbs-awards-volume-card__jump"><?php esc_html_e( 'Explore', 'ilbs-alumni' ); ?> <i class="bi bi-arrow-down-right"></i></a>
				</aside>

				<div class="ilbs-awards-volume-card__content" id="awardVolumeContent">
					<div class="ilbs-awards-volume-card__head">
						<div>
							<span class="section-kicker ilbs-eyebrow"><?php esc_html_e( 'Institutional Archive', 'ilbs-alumni' ); ?></span>
							<h2><span><?php echo esc_html( $active_year ); ?></span> <?php esc_html_e( 'Awards & Publications', 'ilbs-alumni' ); ?></h2>
						</div>
						<div class="ilbs-ref-awards-search ilbs-awards-volume-search">
							<label class="visually-hidden" for="ilbsAwardSearch"><?php esc_html_e( 'Search awards and publications', 'ilbs-alumni' ); ?></label>
							<input type="search" id="ilbsAwardSearch" placeholder="<?php esc_attr_e( 'Looking for something?', 'ilbs-alumni' ); ?>" autocomplete="off">
							<i class="bi bi-search" aria-hidden="true"></i>
						</div>
					</div>

					<div class="ilbs-awards-volume-grid" data-awards-archive-grid>
						<section class="ilbs-awards-volume-column" aria-label="<?php esc_attr_e( 'Award winners', 'ilbs-alumni' ); ?>">
							<div class="ilbs-awards-volume-column__title">
								<i class="bi bi-award"></i>
								<h3><?php esc_html_e( 'Award Winners', 'ilbs-alumni' ); ?></h3>
							</div>
							<div class="ilbs-awards-volume-list">
								<?php if ( ! empty( $award_items ) ) :
									foreach ( $award_items as $item ) :
										ilbs_render_award_card( $item->ID );
									endforeach;
								else : ?>
									<div class="ilbs-empty-state ilbs-empty-state--compact"><p><?php esc_html_e( 'No award entries found for this year.', 'ilbs-alumni' ); ?></p></div>
								<?php endif; ?>
							</div>
						</section>

						<section class="ilbs-awards-volume-column" aria-label="<?php esc_attr_e( 'Publications', 'ilbs-alumni' ); ?>">
							<div class="ilbs-awards-volume-column__title">
								<i class="bi bi-file-earmark-text"></i>
								<h3><?php esc_html_e( 'Publications', 'ilbs-alumni' ); ?></h3>
							</div>
							<div class="ilbs-awards-volume-list">
								<?php if ( ! empty( $pub_items ) ) :
									foreach ( $pub_items as $item ) :
										ilbs_render_award_card( $item->ID );
									endforeach;
								else : ?>
									<div class="ilbs-empty-state ilbs-empty-state--compact"><p><?php esc_html_e( 'No publication entries found for this year.', 'ilbs-alumni' ); ?></p></div>
								<?php endif; ?>
							</div>
						</section>
					</div>
				</div>
			</article>
		</div>
	</section>

</main>

<?php get_footer(); ?>
