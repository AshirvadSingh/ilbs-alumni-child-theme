<?php
/**
 * ILBS Alumni — Premium Search Results
 */
get_header();

$search_query     = get_search_query();
$paged            = max( 1, (int) get_query_var( 'paged' ) );
$post_type_filter = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
$allowed_types    = ilbs_get_search_post_types();

$query_args = [
	's'              => $search_query,
	'posts_per_page' => 12,
	'paged'          => $paged,
	'post_status'    => 'publish',
	'orderby'        => 'relevance',
];

if ( $post_type_filter && in_array( $post_type_filter, $allowed_types, true ) ) {
	$query_args['post_type'] = $post_type_filter;
} else {
	$query_args['post_type'] = $allowed_types;
}

$search_results = new WP_Query( $query_args );
$total          = (int) $search_results->found_posts;
$search_url     = home_url( '/' );
?>

<main id="main-content" class="ilbs-search-page">

	<!-- Hero -->
	<section class="ilbs-search-hero" aria-label="<?php esc_attr_e( 'Search', 'ilbs-alumni' ); ?>">
		<div class="ilbs-search-hero__bg" aria-hidden="true">
			<svg class="ilbs-search-hero__svg ilbs-search-hero__svg--grid" viewBox="0 0 800 400" preserveAspectRatio="xMidYMid slice">
				<defs>
					<pattern id="searchGrid" width="40" height="40" patternUnits="userSpaceOnUse">
						<path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(15,118,110,0.08)" stroke-width="1"/>
					</pattern>
					<linearGradient id="searchGlow" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" stop-color="#14B8A6" stop-opacity="0.2"/>
						<stop offset="100%" stop-color="#5EEAD4" stop-opacity="0"/>
					</linearGradient>
				</defs>
				<rect width="800" height="400" fill="url(#searchGrid)"/>
				<circle cx="650" cy="80" r="120" fill="url(#searchGlow)"/>
				<circle cx="120" cy="300" r="90" fill="url(#searchGlow)" opacity="0.6"/>
			</svg>
			<svg class="ilbs-search-hero__svg ilbs-search-hero__svg--rings" viewBox="0 0 200 200" aria-hidden="true">
				<circle cx="100" cy="100" r="70" fill="none" stroke="rgba(20,184,166,0.2)" stroke-width="1"/>
				<circle cx="100" cy="100" r="45" fill="none" stroke="rgba(94,234,212,0.25)" stroke-width="1"/>
				<circle cx="100" cy="100" r="18" fill="rgba(20,184,166,0.15)"/>
				<line x1="100" y1="30" x2="100" y2="55" stroke="rgba(15,118,110,0.3)" stroke-width="2"/>
				<line x1="100" y1="145" x2="100" y2="170" stroke="rgba(15,118,110,0.3)" stroke-width="2"/>
				<line x1="30" y1="100" x2="55" y2="100" stroke="rgba(15,118,110,0.3)" stroke-width="2"/>
				<line x1="145" y1="100" x2="170" y2="100" stroke="rgba(15,118,110,0.3)" stroke-width="2"/>
			</svg>
		</div>

		<div class="container ilbs-search-hero__content" data-reveal>
			<nav class="ilbs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ilbs-alumni' ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a>
				&rsaquo; <?php esc_html_e( 'Search', 'ilbs-alumni' ); ?>
			</nav>

			<span class="ilbs-eyebrow"><?php esc_html_e( 'Discover', 'ilbs-alumni' ); ?></span>
			<h1 class="ilbs-search-hero__title">
				<?php if ( $search_query ) : ?>
					<?php esc_html_e( 'Search Results', 'ilbs-alumni' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'Search the Alumni Portal', 'ilbs-alumni' ); ?>
				<?php endif; ?>
			</h1>

			<?php if ( $search_query ) : ?>
				<p class="ilbs-search-hero__lead">
					<?php
					printf(
						/* translators: 1: result count, 2: search query */
						esc_html( _n( '%1$d result for "%2$s"', '%1$d results for "%2$s"', $total, 'ilbs-alumni' ) ),
						(int) $total,
						esc_html( $search_query )
					);
					?>
				</p>
			<?php else : ?>
				<p class="ilbs-search-hero__lead"><?php esc_html_e( 'Find alumni, awards, publications, reunions, news and more across the ILBS network.', 'ilbs-alumni' ); ?></p>
			<?php endif; ?>

			<form class="ilbs-search-form" role="search" method="get" action="<?php echo esc_url( $search_url ); ?>">
				<label class="visually-hidden" for="ilbsSearchInput"><?php esc_html_e( 'Search', 'ilbs-alumni' ); ?></label>
				<div class="ilbs-search-form__wrap">
					<i class="bi bi-search ilbs-search-form__icon" aria-hidden="true"></i>
					<input
						type="search"
						id="ilbsSearchInput"
						class="ilbs-search-form__input"
						name="s"
						value="<?php echo esc_attr( $search_query ); ?>"
						placeholder="<?php esc_attr_e( 'Search alumni, awards, news, events…', 'ilbs-alumni' ); ?>"
						autocomplete="off"
						required
					>
					<?php if ( $post_type_filter ) : ?>
						<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type_filter ); ?>">
					<?php endif; ?>
					<button type="submit" class="ilbs-btn ilbs-btn--primary ilbs-search-form__submit" data-magnetic>
						<?php esc_html_e( 'Search', 'ilbs-alumni' ); ?>
					</button>
				</div>
			</form>
		</div>
	</section>

	<section class="ilbs-section ilbs-search-results-section">
		<div class="container">

			<?php if ( $search_query ) : ?>
			<nav class="ilbs-year-pills ilbs-search-filters" aria-label="<?php esc_attr_e( 'Filter by content type', 'ilbs-alumni' ); ?>" data-reveal>
				<?php
				$all_url = add_query_arg( 's', $search_query, $search_url );
				?>
				<a href="<?php echo esc_url( $all_url ); ?>"
					class="ilbs-year-pill <?php echo '' === $post_type_filter ? 'is-active' : ''; ?>"
					<?php echo '' === $post_type_filter ? 'aria-current="true"' : ''; ?>>
					<?php esc_html_e( 'All', 'ilbs-alumni' ); ?>
				</a>
				<?php foreach ( $allowed_types as $type ) :
					$meta     = ilbs_get_search_type_meta( $type );
					$type_url = add_query_arg(
						[ 's' => $search_query, 'post_type' => $type ],
						$search_url
					);
					?>
					<a href="<?php echo esc_url( $type_url ); ?>"
						class="ilbs-year-pill <?php echo $post_type_filter === $type ? 'is-active' : ''; ?>"
						<?php echo $post_type_filter === $type ? 'aria-current="true"' : ''; ?>>
						<i class="bi <?php echo esc_attr( $meta['icon'] ); ?>" aria-hidden="true"></i>
						<?php echo esc_html( $meta['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</nav>
			<?php endif; ?>

			<?php if ( $search_results->have_posts() ) : ?>
				<div class="ilbs-search-grid" data-reveal-stagger>
					<?php
					while ( $search_results->have_posts() ) :
						$search_results->the_post();
						$type     = get_post_type();
						$meta     = ilbs_get_search_type_meta( $type );
						$excerpt = wp_trim_words( get_the_excerpt(), 22 );
						$title   = get_the_title();
						if ( $search_query ) {
							$highlight = wp_kses(
								preg_replace(
									'/' . preg_quote( $search_query, '/' ) . '/iu',
									'<mark class="ilbs-search-mark">$0</mark>',
									$title
								),
								[ 'mark' => [ 'class' => true ] ]
							);
						} else {
							$highlight = esc_html( $title );
						}
						?>
						<article class="ilbs-card ilbs-search-card" data-reveal-item>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="ilbs-search-card__thumb" tabindex="-1" aria-hidden="true">
									<?php the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy' ] ); ?>
								</a>
							<?php else : ?>
								<div class="ilbs-search-card__thumb ilbs-search-card__thumb--icon" aria-hidden="true">
									<svg viewBox="0 0 80 80" fill="none" width="48" height="48">
										<circle cx="40" cy="40" r="36" stroke="rgba(15,118,110,0.2)" stroke-width="1"/>
										<circle cx="40" cy="40" r="8" fill="rgba(20,184,166,0.35)"/>
									</svg>
									<i class="bi <?php echo esc_attr( $meta['icon'] ); ?>"></i>
								</div>
							<?php endif; ?>

							<div class="ilbs-card__body">
								<div class="ilbs-search-card__meta">
									<span class="ilbs-badge">
										<i class="bi <?php echo esc_attr( $meta['icon'] ); ?>" aria-hidden="true"></i>
										<?php echo esc_html( $meta['label'] ); ?>
									</span>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								</div>

								<h2 class="ilbs-search-card__title">
									<a href="<?php the_permalink(); ?>"><?php echo $highlight; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above ?></a>
								</h2>

								<?php if ( $excerpt ) : ?>
									<p class="ilbs-search-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
								<?php endif; ?>

								<a href="<?php the_permalink(); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'View details', 'ilbs-alumni' ); ?></a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php if ( $search_results->max_num_pages > 1 ) : ?>
					<nav class="ilbs-search-pagination mt-5" aria-label="<?php esc_attr_e( 'Search results pages', 'ilbs-alumni' ); ?>" data-reveal>
						<?php
						echo paginate_links( [
							'total'     => $search_results->max_num_pages,
							'current'   => $paged,
							'format'    => '?paged=%#%',
							'add_args'  => array_filter( [
								's'         => $search_query,
								'post_type' => $post_type_filter ?: false,
							] ),
							'prev_text' => '<i class="bi bi-chevron-left" aria-hidden="true"></i>',
							'next_text' => '<i class="bi bi-chevron-right" aria-hidden="true"></i>',
							'type'      => 'list',
						] );
						?>
					</nav>
				<?php endif; ?>

			<?php elseif ( $search_query ) : ?>

				<div class="ilbs-search-empty" data-reveal>
					<svg class="ilbs-search-empty__svg" viewBox="0 0 240 200" fill="none" aria-hidden="true">
						<circle cx="100" cy="90" r="52" stroke="rgba(15,118,110,0.25)" stroke-width="3"/>
						<line x1="138" y1="128" x2="190" y2="175" stroke="rgba(15,118,110,0.35)" stroke-width="6" stroke-linecap="round"/>
						<path d="M78 90h44M100 68v44" stroke="rgba(20,184,166,0.4)" stroke-width="2" stroke-linecap="round"/>
						<circle cx="180" cy="40" r="6" fill="#5EEAD4" opacity="0.6"/>
						<circle cx="40" cy="160" r="4" fill="#14B8A6" opacity="0.5"/>
					</svg>
					<h2 class="h4"><?php esc_html_e( 'No results found', 'ilbs-alumni' ); ?></h2>
					<p><?php esc_html_e( 'Try different keywords, check spelling, or browse our quick links below.', 'ilbs-alumni' ); ?></p>
					<div class="ilbs-search-quick-links">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="ilbs-year-pill"><?php esc_html_e( 'Alumni Directory', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>" class="ilbs-year-pill"><?php esc_html_e( 'Awards', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>" class="ilbs-year-pill"><?php esc_html_e( 'Reunions', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_news' ) ); ?>" class="ilbs-year-pill"><?php esc_html_e( 'News', 'ilbs-alumni' ); ?></a>
					</div>
				</div>

			<?php else : ?>

				<div class="ilbs-search-suggestions" data-reveal-stagger>
					<h2 class="h5 mb-4" data-reveal-item><?php esc_html_e( 'Popular searches', 'ilbs-alumni' ); ?></h2>
					<div class="ilbs-search-suggestions__grid">
						<?php
						$suggestions = [
							[ 'label' => __( 'Alumni Directory', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_member' ), 'icon' => 'bi-people' ],
							[ 'label' => __( 'Awards & Publications', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_award' ), 'icon' => 'bi-trophy' ],
							[ 'label' => __( 'Upcoming Reunions', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_reunion' ), 'icon' => 'bi-calendar-heart' ],
							[ 'label' => __( 'Latest News', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_news' ), 'icon' => 'bi-megaphone' ],
							[ 'label' => __( 'Research Publications', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_publication' ), 'icon' => 'bi-journal-medical' ],
							[ 'label' => __( 'Photo Gallery', 'ilbs-alumni' ), 'url' => get_permalink( get_page_by_path( 'gallery' ) ), 'icon' => 'bi-images' ],
						];
						foreach ( $suggestions as $item ) :
							if ( empty( $item['url'] ) ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( $item['url'] ); ?>" class="ilbs-card ilbs-search-suggestion-card" data-reveal-item>
								<span class="ilbs-search-suggestion-card__icon" aria-hidden="true">
									<i class="bi <?php echo esc_attr( $item['icon'] ); ?>"></i>
								</span>
								<span class="ilbs-search-suggestion-card__label"><?php echo esc_html( $item['label'] ); ?></span>
								<i class="bi bi-arrow-right ilbs-search-suggestion-card__arrow" aria-hidden="true"></i>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		</div>
	</section>

</main>

<?php get_footer(); ?>
