<?php
/**
 * ILBS Alumni — Homepage (Screenshot Reference Layout)
 * ACF-ready with fallbacks. Section order matches design mockup.
 */
get_header();

$has_slides   = function_exists( 'have_rows' ) && have_rows( 'banner_slides' );
$stats        = ilbs_get_home_stats();
$videos       = ilbs_get_videos_from_page();
$gallery_imgs = ilbs_get_gallery_preview_images( 8 );
$resources    = ilbs_get_home_resources();
$award_years  = ilbs_get_award_years();
if ( empty( $award_years ) ) {
	$award_years = [ '2023', '2022', '2020', '2018', '2017', '2016', '2015', '2014' ];
}
$default_year = $award_years[0];

$about_heading = function_exists( 'get_field' ) ? ( get_field( 'about_heading' ) ?: __( 'Our Network at a Glance', 'ilbs-alumni' ) ) : __( 'Our Network at a Glance', 'ilbs-alumni' );
$about_text    = function_exists( 'get_field' ) ? ( get_field( 'about_text' ) ?: __( 'The ILBS Alumni Association connects graduates, researchers and clinicians dedicated to advancing hepatology, liver transplantation and biliary sciences across the globe.', 'ilbs-alumni' ) ) : __( 'The ILBS Alumni Association connects graduates, researchers and clinicians dedicated to advancing hepatology, liver transplantation and biliary sciences across the globe.', 'ilbs-alumni' );

$hero_quick_links = [
	[ 'icon' => 'bi-mortarboard', 'label' => __( 'Alumni Directory', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_member' ) ],
	[ 'icon' => 'bi-calendar-event', 'label' => __( 'Events', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_reunion' ) ],
	[ 'icon' => 'bi-trophy', 'label' => __( 'Awards', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_award' ) ],
	[ 'icon' => 'bi-journal-medical', 'label' => __( 'Publications', 'ilbs-alumni' ), 'url' => get_post_type_archive_link( 'ilbs_publication' ) ],
];
?>

<main id="main-content" class="ilbs-home">

	<!-- 1. HERO — full-width slider, centered copy, search, glass quick cards -->
	<section class="ilbs-ref-hero hero-slider" aria-label="<?php esc_attr_e( 'Welcome', 'ilbs-alumni' ); ?>">
		<div class="swiper banner-swiper">
			<div class="swiper-wrapper">
				<?php if ( $has_slides ) :
					$si = 0;
					while ( have_rows( 'banner_slides' ) ) : the_row();
						$si++;
						$img = get_sub_field( 'image' );
						?>
						<div class="swiper-slide ilbs-ref-hero__slide">
							<?php if ( $img ) : ?>
								<img class="ilbs-ref-hero__bg-img" src="<?php echo esc_url( $img ); ?>" alt="" <?php echo 1 === $si ? 'loading="eager"' : 'loading="lazy"'; ?>>
							<?php endif; ?>
							<div class="ilbs-ref-hero__overlay"></div>
							<div class="container ilbs-ref-hero__inner">
								<div class="ilbs-ref-hero__copy" data-hero-copy>
									<?php if ( get_sub_field( 'eyebrow' ) ) : ?>
										<span class="ilbs-ref-hero__eyebrow"><?php echo esc_html( get_sub_field( 'eyebrow' ) ); ?></span>
									<?php endif; ?>
									<?php
									$heading = get_sub_field( 'heading' ) ?: __( 'Welcome to the ILBS Alumni Network', 'ilbs-alumni' );
									echo 1 === $si ? '<h1 class="ilbs-ref-hero__title">' : '<h2 class="ilbs-ref-hero__title">';
									echo esc_html( $heading );
									echo 1 === $si ? '</h1>' : '</h2>';
									?>
									<?php if ( get_sub_field( 'description' ) ) : ?>
										<p class="ilbs-ref-hero__desc"><?php echo esc_html( get_sub_field( 'description' ) ); ?></p>
									<?php endif; ?>
									<form class="ilbs-ref-hero__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
										<i class="bi bi-search" aria-hidden="true"></i>
										<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search alumni, awards, news…', 'ilbs-alumni' ); ?>" autocomplete="off">
										<button type="submit" class="ilbs-btn ilbs-btn--primary"><?php esc_html_e( 'Search', 'ilbs-alumni' ); ?></button>
									</form>
									<?php if ( get_sub_field( 'btn1_text' ) || get_sub_field( 'btn2_text' ) ) : ?>
									<div class="ilbs-ref-hero__btns">
										<?php if ( get_sub_field( 'btn1_text' ) ) : ?>
											<a href="<?php echo esc_url( get_sub_field( 'btn1_link' ) ?: '#' ); ?>" class="ilbs-btn ilbs-btn--primary" data-magnetic><?php echo esc_html( get_sub_field( 'btn1_text' ) ); ?></a>
										<?php endif; ?>
										<?php if ( get_sub_field( 'btn2_text' ) ) : ?>
											<a href="<?php echo esc_url( get_sub_field( 'btn2_link' ) ?: '#' ); ?>" class="ilbs-btn ilbs-btn--ghost ilbs-btn--on-dark" data-magnetic><?php echo esc_html( get_sub_field( 'btn2_text' ) ); ?></a>
										<?php endif; ?>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endwhile;
				else : ?>
					<div class="swiper-slide ilbs-ref-hero__slide ilbs-ref-hero__slide--fallback">
						<div class="ilbs-ref-hero__overlay"></div>
						<div class="container ilbs-ref-hero__inner">
							<div class="ilbs-ref-hero__copy" data-hero-copy>
								<span class="ilbs-ref-hero__eyebrow"><?php esc_html_e( 'ILBS Alumni Association', 'ilbs-alumni' ); ?></span>
								<h1 class="ilbs-ref-hero__title"><?php esc_html_e( 'Welcome to the ILBS Alumni Network', 'ilbs-alumni' ); ?></h1>
								<p class="ilbs-ref-hero__desc"><?php esc_html_e( 'A distinguished community shaped by clinical excellence, research leadership and service to liver sciences.', 'ilbs-alumni' ); ?></p>
								<form class="ilbs-ref-hero__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<i class="bi bi-search" aria-hidden="true"></i>
									<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search alumni, awards, news…', 'ilbs-alumni' ); ?>">
									<button type="submit" class="ilbs-btn ilbs-btn--primary"><?php esc_html_e( 'Search', 'ilbs-alumni' ); ?></button>
								</form>
								<div class="ilbs-ref-hero__btns">
									<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="ilbs-btn ilbs-btn--primary" data-magnetic><?php esc_html_e( 'Join Network', 'ilbs-alumni' ); ?></a>
									<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="ilbs-btn ilbs-btn--ghost ilbs-btn--on-dark" data-magnetic><?php esc_html_e( 'View All Members', 'ilbs-alumni' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="ilbs-ref-hero__nav">
				<button type="button" class="banner-prev ilbs-ref-hero__arrow" aria-label="<?php esc_attr_e( 'Previous', 'ilbs-alumni' ); ?>"><i class="bi bi-chevron-left"></i></button>
				<div class="banner-pagination swiper-pagination"></div>
				<button type="button" class="banner-next ilbs-ref-hero__arrow" aria-label="<?php esc_attr_e( 'Next', 'ilbs-alumni' ); ?>"><i class="bi bi-chevron-right"></i></button>
			</div>
		</div>

		<div class="container ilbs-ref-hero__dock">
			<div class="ilbs-ref-quick-cards" data-reveal-stagger>
				<?php foreach ( $hero_quick_links as $ql ) : ?>
					<a href="<?php echo esc_url( $ql['url'] ); ?>" class="ilbs-ref-quick-card" data-reveal-item>
						<span class="ilbs-ref-quick-card__icon"><i class="bi <?php echo esc_attr( $ql['icon'] ); ?>" aria-hidden="true"></i></span>
						<span class="ilbs-ref-quick-card__label"><?php echo esc_html( $ql['label'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>


	<!-- 2. WELCOME / ABOUT -->
	<section class="ilbs-ref-section ilbs-ref-welcome" id="about" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Institutional Identity', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php echo esc_html( $about_heading ); ?></h2>
			</div>
			<div class="ilbs-ref-welcome__grid">
				<div class="ilbs-ref-welcome__text">
					<p><?php echo esc_html( $about_text ); ?></p>
					<?php $about_page = get_page_by_path( 'about' ); if ( $about_page ) : ?>
						<a href="<?php echo esc_url( get_permalink( $about_page ) ); ?>" class="ilbs-link-arrow mt-3 d-inline-flex"><?php esc_html_e( 'Learn more about ILBS Alumni', 'ilbs-alumni' ); ?></a>
					<?php endif; ?>
				</div>
				<div class="ilbs-ref-welcome__features">
					<?php
					$features = function_exists( 'have_rows' ) && have_rows( 'about_features' )
						? null
						: [
							__( 'Lifelong professional networking among ILBS graduates', 'ilbs-alumni' ),
							__( 'Research collaboration and publication support', 'ilbs-alumni' ),
							__( 'Reunions, lectures and institutional events', 'ilbs-alumni' ),
							__( 'Recognition of alumni excellence and achievements', 'ilbs-alumni' ),
						];
					if ( function_exists( 'have_rows' ) && have_rows( 'about_features' ) ) :
						while ( have_rows( 'about_features' ) ) : the_row(); ?>
							<div class="ilbs-ref-feature-item">
								<i class="bi bi-check-circle-fill" aria-hidden="true"></i>
								<span><?php echo esc_html( get_sub_field( 'text' ) ); ?></span>
							</div>
						<?php endwhile;
					else :
						foreach ( $features as $feat ) : ?>
							<div class="ilbs-ref-feature-item">
								<i class="bi bi-check-circle-fill" aria-hidden="true"></i>
								<span><?php echo esc_html( $feat ); ?></span>
							</div>
						<?php endforeach;
					endif; ?>
				</div>
			</div>
		</div>
	</section>


	<!-- 3. ALUMNI NETWORK STATS -->
	<section class="ilbs-ref-section ilbs-ref-stats" aria-label="<?php esc_attr_e( 'Alumni statistics', 'ilbs-alumni' ); ?>">
		<div class="container">
			<div class="ilbs-ref-stats__grid" data-reveal-stagger>
				<?php foreach ( $stats as $stat ) : ?>
					<div class="ilbs-ref-stat" data-reveal-item>
						<div class="ilbs-ref-stat__icon"><i class="bi <?php echo esc_attr( $stat['icon'] ?? 'bi-graph-up' ); ?>" aria-hidden="true"></i></div>
						<strong data-counter="<?php echo esc_attr( $stat['number'] ?? 0 ); ?>">0</strong>
						<span><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>


	<!-- 4. TESTIMONIALS -->
	<section class="ilbs-ref-section" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Voices', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'What Our Alumni Say', 'ilbs-alumni' ); ?></h2>
			</div>
			<div class="swiper testimonial-swiper" data-reveal>
				<div class="swiper-wrapper">
					<?php
					$has_testimonials = function_exists( 'have_rows' ) && have_rows( 'testimonials' );
					if ( $has_testimonials ) :
						while ( have_rows( 'testimonials' ) ) : the_row(); ?>
							<div class="swiper-slide">
								<blockquote class="ilbs-ref-testimonial">
									<i class="bi bi-quote ilbs-ref-testimonial__quote-icon" aria-hidden="true"></i>
									<p><?php echo esc_html( get_sub_field( 'quote' ) ); ?></p>
									<footer>
										<?php if ( get_sub_field( 'avatar' ) ) : ?>
											<img src="<?php echo esc_url( get_sub_field( 'avatar' ) ); ?>" alt="" class="ilbs-ref-testimonial__avatar" loading="lazy">
										<?php else : ?>
											<span class="ilbs-ref-testimonial__avatar ilbs-ref-testimonial__avatar--placeholder"><i class="bi bi-person-fill"></i></span>
										<?php endif; ?>
										<cite><?php echo esc_html( get_sub_field( 'name' ) ); ?><span><?php echo esc_html( get_sub_field( 'role' ) ); ?></span></cite>
									</footer>
								</blockquote>
							</div>
						<?php endwhile;
					else :
						$fallback_voices = [
							[ 'quote' => __( 'ILBS gave me the foundation to pursue hepatology research at the highest level. The alumni network continues to inspire collaboration across institutions.', 'ilbs-alumni' ), 'name' => __( 'Dr. Alumni Member', 'ilbs-alumni' ), 'role' => __( 'Batch 2018 · Hepatology', 'ilbs-alumni' ) ],
							[ 'quote' => __( 'Staying connected with ILBS alumni has opened doors to mentorship, publications and meaningful clinical partnerships worldwide.', 'ilbs-alumni' ), 'name' => __( 'Research Fellow', 'ilbs-alumni' ), 'role' => __( 'ILBS Graduate', 'ilbs-alumni' ) ],
							[ 'quote' => __( 'The reunions and lecture series keep our institutional spirit alive — a true community of excellence in liver sciences.', 'ilbs-alumni' ), 'name' => __( 'Senior Clinician', 'ilbs-alumni' ), 'role' => __( 'Alumni Association Member', 'ilbs-alumni' ) ],
						];
						foreach ( $fallback_voices as $v ) : ?>
							<div class="swiper-slide">
								<blockquote class="ilbs-ref-testimonial">
									<i class="bi bi-quote ilbs-ref-testimonial__quote-icon" aria-hidden="true"></i>
									<p>"<?php echo esc_html( $v['quote'] ); ?>"</p>
									<footer>
										<span class="ilbs-ref-testimonial__avatar ilbs-ref-testimonial__avatar--placeholder"><i class="bi bi-person-fill"></i></span>
										<cite><?php echo esc_html( $v['name'] ); ?><span><?php echo esc_html( $v['role'] ); ?></span></cite>
									</footer>
								</blockquote>
							</div>
						<?php endforeach;
					endif; ?>
				</div>
				<div class="swiper-pagination testimonial-pagination"></div>
			</div>
		</div>
	</section>


	<!-- 5. FEATURED MEMBERS -->
	<section class="ilbs-ref-section ilbs-ref-section--soft" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head">
				<div>
					<span class="ilbs-eyebrow"><?php esc_html_e( 'Network', 'ilbs-alumni' ); ?></span>
					<h2 class="ilbs-ref-title"><?php esc_html_e( 'Featured Alumni Members', 'ilbs-alumni' ); ?></h2>
				</div>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'View directory', 'ilbs-alumni' ); ?></a>
			</div>
			<div class="ilbs-ref-members" data-reveal-stagger>
				<?php
				$members = new WP_Query( [ 'post_type' => 'ilbs_member', 'posts_per_page' => 4 ] );
				if ( $members->have_posts() ) :
					while ( $members->have_posts() ) : $members->the_post();
						$batches = wp_get_post_terms( get_the_ID(), 'ilbs_batch' );
						$batch   = ( $batches && ! is_wp_error( $batches ) ) ? $batches[0]->name : '';
						$specs   = wp_get_post_terms( get_the_ID(), 'ilbs_specialization' );
						$spec    = ( $specs && ! is_wp_error( $specs ) ) ? $specs[0]->name : '';
						$linkedin = function_exists( 'get_field' ) ? get_field( 'linkedin' ) : '';
						?>
						<article class="ilbs-ref-member-card" data-reveal-item>
							<div class="ilbs-ref-member-card__photo">
								<?php if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'medium', [ 'loading' => 'lazy' ] );
								else : ?>
									<i class="bi bi-person-fill" aria-hidden="true"></i>
								<?php endif; ?>
							</div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( $batch ) : ?><p class="ilbs-ref-member-card__batch"><?php printf( esc_html__( 'Batch %s', 'ilbs-alumni' ), esc_html( $batch ) ); ?></p><?php endif; ?>
							<?php if ( $spec ) : ?><p class="ilbs-ref-member-card__dept"><?php echo esc_html( $spec ); ?></p><?php endif; ?>
							<?php if ( $linkedin ) : ?>
								<a href="<?php echo esc_url( $linkedin ); ?>" class="ilbs-ref-member-card__social" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
							<?php endif; ?>
						</article>
					<?php endwhile;
					wp_reset_postdata();
				endif; ?>
			</div>
		</div>
	</section>


	<!-- 6. UPCOMING EVENTS — horizontal rows -->
	<section class="ilbs-ref-section" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head">
				<div>
					<span class="ilbs-eyebrow"><?php esc_html_e( 'Events', 'ilbs-alumni' ); ?></span>
					<h2 class="ilbs-ref-title"><?php esc_html_e( 'Upcoming Reunions & Events', 'ilbs-alumni' ); ?></h2>
				</div>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'All events', 'ilbs-alumni' ); ?></a>
			</div>
			<div class="ilbs-ref-events" data-reveal-stagger>
				<?php
				$events = new WP_Query( [ 'post_type' => 'ilbs_reunion', 'posts_per_page' => 4 ] );
				if ( $events->have_posts() ) :
					while ( $events->have_posts() ) : $events->the_post();
						$raw_date = function_exists( 'get_field' ) ? ( get_field( 'event_date' ) ?: get_field( 'start_date' ) ) : '';
						$venue    = function_exists( 'get_field' ) ? get_field( 'venue' ) : '';
						$reg_url  = function_exists( 'get_field' ) && get_field( 'registration_url' ) ? get_field( 'registration_url' ) : get_permalink();
						$day = $month = '';
						if ( $raw_date ) {
							$ts = strtotime( $raw_date );
							if ( $ts ) {
								$day   = gmdate( 'd', $ts );
								$month = strtoupper( gmdate( 'M', $ts ) );
							}
						}
						?>
						<article class="ilbs-ref-event-row" data-reveal-item>
							<?php if ( $day && $month ) : ?>
								<div class="ilbs-ref-event-row__date">
									<strong><?php echo esc_html( $day ); ?></strong>
									<span><?php echo esc_html( $month ); ?></span>
								</div>
							<?php endif; ?>
							<div class="ilbs-ref-event-row__thumb">
								<?php if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'medium', [ 'loading' => 'lazy' ] );
								else : ?>
									<div class="ilbs-ref-event-row__thumb-placeholder"><i class="bi bi-calendar-event"></i></div>
								<?php endif; ?>
							</div>
							<div class="ilbs-ref-event-row__body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php if ( $venue ) : ?><p><i class="bi bi-geo-alt"></i> <?php echo esc_html( $venue ); ?></p><?php endif; ?>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
								<a href="<?php echo esc_url( $reg_url ); ?>" class="ilbs-btn ilbs-btn--primary ilbs-btn--sm"><?php esc_html_e( 'Register Now', 'ilbs-alumni' ); ?></a>
							</div>
						</article>
					<?php endwhile;
					wp_reset_postdata();
				endif; ?>
			</div>
		</div>
	</section>


	<!-- 7. AWARDS & PUBLICATIONS — sidebar year filter + grid -->
	<section class="ilbs-ref-section ilbs-ref-section--soft ilbs-ref-awards-block" id="awards" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center mb-5">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Achievements', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'Alumni Awards & Publications', 'ilbs-alumni' ); ?></h2>
			</div>
			<div class="ilbs-ref-awards-layout">
				<aside class="ilbs-ref-awards-sidebar" aria-label="<?php esc_attr_e( 'Filter by year', 'ilbs-alumni' ); ?>">
					<h3 class="ilbs-ref-awards-sidebar__title"><?php esc_html_e( 'Filter by Year', 'ilbs-alumni' ); ?></h3>
					<nav class="ilbs-ref-year-nav">
						<?php foreach ( $award_years as $yr ) : ?>
							<button type="button"
								class="ilbs-ref-year-btn <?php echo (string) $yr === (string) $default_year ? 'is-active' : ''; ?>"
								data-home-award-year="<?php echo esc_attr( $yr ); ?>">
								<?php echo esc_html( $yr ); ?>
							</button>
						<?php endforeach; ?>
					</nav>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>" class="ilbs-link-arrow mt-4 d-inline-flex"><?php esc_html_e( 'View full archive', 'ilbs-alumni' ); ?></a>
				</aside>
				<div class="ilbs-ref-awards-main">
					<h3 class="ilbs-ref-year-heading" id="homeAwardYearHeading">
						<span><?php echo esc_html( $default_year ); ?></span> <?php esc_html_e( 'Awards & Publications', 'ilbs-alumni' ); ?>
					</h3>
					<div class="ilbs-ref-awards-search">
						<input type="search" id="homeAwardSearch" placeholder="<?php esc_attr_e( 'Looking for something?', 'ilbs-alumni' ); ?>" autocomplete="off">
						<i class="bi bi-search"></i>
					</div>
					<div class="ilbs-ref-awards-grid" id="homeAwardsGrid" data-reveal-stagger>
						<?php
						$all_awards = new WP_Query( [
							'post_type'      => 'ilbs_award',
							'posts_per_page' => -1,
							'meta_key'       => 'award_year',
							'orderby'        => 'meta_value_num',
							'order'          => 'DESC',
						] );
						if ( $all_awards->have_posts() ) :
							while ( $all_awards->have_posts() ) : $all_awards->the_post();
								$yr = function_exists( 'get_field' ) ? get_field( 'award_year' ) : '';
								$hidden = (string) $yr !== (string) $default_year;
								echo '<div class="ilbs-ref-award-wrap' . ( $hidden ? ' is-hidden' : '' ) . '" data-award-year-wrap="' . esc_attr( $yr ) . '">';
								ilbs_render_award_card( get_the_ID() );
								echo '</div>';
							endwhile;
							wp_reset_postdata();
						else :
							for ( $i = 0; $i < 4; $i++ ) : ?>
								<article class="ilbs-card ilbs-award-card ilbs-award-card--ref ilbs-ref-award-placeholder" data-reveal-item>
									<div class="ilbs-award-card__icon"><i class="bi bi-trophy-fill"></i></div>
									<div>
										<span class="ilbs-badge"><?php echo esc_html( $default_year ); ?></span>
										<h3><?php esc_html_e( 'Award placeholder', 'ilbs-alumni' ); ?></h3>
										<p><?php esc_html_e( 'Add awards via WordPress admin to populate this section.', 'ilbs-alumni' ); ?></p>
									</div>
								</article>
							<?php endfor;
						endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- 8. RESEARCH & PUBLICATIONS SHOWCASE -->
	<section class="ilbs-ref-section" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head">
				<div>
					<span class="ilbs-eyebrow"><?php esc_html_e( 'Research', 'ilbs-alumni' ); ?></span>
					<h2 class="ilbs-ref-title"><?php esc_html_e( 'Research & Publications', 'ilbs-alumni' ); ?></h2>
				</div>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_publication' ) ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'All publications', 'ilbs-alumni' ); ?></a>
			</div>
			<div class="ilbs-ref-pub-grid" data-reveal-stagger>
				<?php
				$pubs = new WP_Query( [ 'post_type' => 'ilbs_publication', 'posts_per_page' => 3 ] );
				if ( $pubs->have_posts() ) :
					while ( $pubs->have_posts() ) : $pubs->the_post();
						$pdf = function_exists( 'get_field' ) ? get_field( 'pdf_file' ) : '';
						if ( is_array( $pdf ) && isset( $pdf['url'] ) ) {
							$pdf = $pdf['url'];
						}
						$abstract = function_exists( 'get_field' ) ? get_field( 'abstract' ) : '';
						?>
						<article class="ilbs-ref-pub-card" data-reveal-item>
							<div class="ilbs-ref-pub-card__cover">
								<?php if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'medium', [ 'loading' => 'lazy' ] );
								else : ?>
									<i class="bi bi-journal-medical" aria-hidden="true"></i>
								<?php endif; ?>
							</div>
							<div class="ilbs-ref-pub-card__body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( $abstract ?: get_the_excerpt(), 20 ) ); ?></p>
								<div class="d-flex gap-3 flex-wrap">
									<a href="<?php the_permalink(); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'Read more', 'ilbs-alumni' ); ?></a>
									<?php if ( $pdf ) : ?>
										<a href="<?php echo esc_url( $pdf ); ?>" class="ilbs-link-arrow" target="_blank" rel="noopener"><?php esc_html_e( 'Download PDF', 'ilbs-alumni' ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						</article>
					<?php endwhile;
					wp_reset_postdata();
				endif; ?>
			</div>
		</div>
	</section>


	<!-- 9. GALLERY — Memories & Moments -->
	<section class="ilbs-ref-section ilbs-ref-section--soft" id="gallery" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Gallery', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'Memories & Moments', 'ilbs-alumni' ); ?></h2>
			</div>
			<?php if ( ! empty( $gallery_imgs ) ) : ?>
				<div class="ilbs-ref-masonry" data-reveal-stagger>
					<?php foreach ( $gallery_imgs as $gi => $img ) : ?>
						<button type="button" class="ilbs-ref-masonry__item" data-reveal-item data-gallery-lightbox="<?php echo esc_url( $img['url'] ); ?>" style="--h:<?php echo esc_attr( ( $gi % 3 ) + 1 ); ?>">
							<img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" loading="lazy">
						</button>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="ilbs-ref-masonry ilbs-ref-masonry--placeholder" data-reveal-stagger>
					<?php for ( $g = 1; $g <= 6; $g++ ) : ?>
						<div class="ilbs-ref-masonry__item ilbs-ref-masonry__item--ph" data-reveal-item style="--h:<?php echo esc_attr( ( $g % 3 ) + 1 ); ?>">
							<i class="bi bi-images"></i>
						</div>
					<?php endfor; ?>
				</div>
			<?php endif;
			$gallery_page = get_page_by_path( 'gallery' );
			if ( $gallery_page ) : ?>
				<div class="text-center mt-4">
					<a href="<?php echo esc_url( get_permalink( $gallery_page ) ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'View full gallery', 'ilbs-alumni' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>


	<!-- 10. VIDEO — Alumni Stories & Memories -->
	<section class="ilbs-ref-section ilbs-ref-video-block" id="videos" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Media', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'Alumni Stories & Memories', 'ilbs-alumni' ); ?></h2>
			</div>
			<?php if ( ! empty( $videos ) ) : ?>
				<div class="swiper video-swiper ilbs-ref-video-swiper">
					<div class="swiper-wrapper">
						<?php foreach ( $videos as $vi => $video ) :
							$vtitle = $video['title'] ?: sprintf( __( 'Alumni Story %d', 'ilbs-alumni' ), $vi + 1 );
							?>
							<div class="swiper-slide">
								<article class="ilbs-ref-video-feature"
									<?php if ( ! empty( $video['embed'] ) ) : ?>
										role="button" tabindex="0" data-video-embed="<?php echo esc_attr( $video['embed'] ); ?>"
									<?php endif; ?>>
									<?php if ( ! empty( $video['thumb'] ) ) : ?>
										<img src="<?php echo esc_url( $video['thumb'] ); ?>" alt="" loading="lazy">
									<?php endif; ?>
									<div class="ilbs-ref-video-feature__play"><i class="bi bi-play-fill"></i></div>
									<h3><?php echo esc_html( $vtitle ); ?></h3>
								</article>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination video-swiper-pagination"></div>
				</div>
				<div class="ilbs-video-nav mt-3">
					<button type="button" class="video-swiper-prev" aria-label="<?php esc_attr_e( 'Previous', 'ilbs-alumni' ); ?>"><i class="bi bi-chevron-left"></i></button>
					<button type="button" class="video-swiper-next" aria-label="<?php esc_attr_e( 'Next', 'ilbs-alumni' ); ?>"><i class="bi bi-chevron-right"></i></button>
				</div>
			<?php else : ?>
				<article class="ilbs-ref-video-feature ilbs-ref-video-feature--placeholder">
					<div class="ilbs-ref-video-feature__play"><i class="bi bi-play-fill"></i></div>
					<h3><?php esc_html_e( 'Add videos on the Video page to populate this section', 'ilbs-alumni' ); ?></h3>
				</article>
			<?php endif; ?>
		</div>
	</section>


	<!-- 11. ALUMNI LEADERS -->
	<section class="ilbs-ref-section" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Leadership', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'Alumni Leaders', 'ilbs-alumni' ); ?></h2>
			</div>
			<div class="ilbs-ref-leaders" data-reveal-stagger>
				<?php
				$leaders = [];
				if ( function_exists( 'have_rows' ) && have_rows( 'leadership' ) ) {
					while ( have_rows( 'leadership' ) ) : the_row();
						$leaders[] = [
							'name'  => get_sub_field( 'name' ),
							'role'  => get_sub_field( 'role' ),
							'photo' => get_sub_field( 'photo' ),
							'link'  => get_sub_field( 'link' ),
						];
					endwhile;
				} else {
					if ( function_exists( 'get_field' ) && get_field( 'chancellor_name' ) ) {
						$leaders[] = [ 'name' => get_field( 'chancellor_name' ), 'role' => __( 'Chancellor, ILBS', 'ilbs-alumni' ), 'photo' => get_field( 'chancellor_photo' ), 'link' => get_field( 'chancellor_link' ) ];
					}
					if ( function_exists( 'get_field' ) && get_field( 'vc_name' ) ) {
						$leaders[] = [ 'name' => get_field( 'vc_name' ), 'role' => __( 'Vice Chancellor, ILBS', 'ilbs-alumni' ), 'photo' => get_field( 'vc_photo' ), 'link' => get_field( 'vc_link' ) ];
					}
				}
				if ( empty( $leaders ) ) {
					$leaders = [
						[ 'name' => __( 'Institutional Leader', 'ilbs-alumni' ), 'role' => __( 'Chancellor, ILBS', 'ilbs-alumni' ), 'photo' => '', 'link' => '' ],
						[ 'name' => __( 'Academic Leader', 'ilbs-alumni' ), 'role' => __( 'Vice Chancellor, ILBS', 'ilbs-alumni' ), 'photo' => '', 'link' => '' ],
					];
				}
				foreach ( $leaders as $leader ) : ?>
					<article class="ilbs-ref-leader-card" data-reveal-item>
						<div class="ilbs-ref-leader-card__photo">
							<?php if ( ! empty( $leader['photo'] ) ) : ?>
								<img src="<?php echo esc_url( $leader['photo'] ); ?>" alt="<?php echo esc_attr( $leader['name'] ); ?>" loading="lazy">
							<?php else : ?>
								<i class="bi bi-person-fill"></i>
							<?php endif; ?>
						</div>
						<h3><?php echo esc_html( $leader['name'] ); ?></h3>
						<p><?php echo esc_html( $leader['role'] ); ?></p>
						<?php if ( ! empty( $leader['link'] ) ) : ?>
							<a href="<?php echo esc_url( $leader['link'] ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'Read message', 'ilbs-alumni' ); ?></a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>


	<!-- 12. LATEST BLOG -->
	<section class="ilbs-ref-section ilbs-ref-section--soft" id="news" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head">
				<div>
					<span class="ilbs-eyebrow"><?php esc_html_e( 'Updates', 'ilbs-alumni' ); ?></span>
					<h2 class="ilbs-ref-title"><?php esc_html_e( 'Latest Alumni News & Updates', 'ilbs-alumni' ); ?></h2>
				</div>
				<?php $blog_page = get_page_by_path( 'blog' ); ?>
				<a href="<?php echo esc_url( $blog_page ? get_permalink( $blog_page ) : get_post_type_archive_link( 'ilbs_news' ) ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'View all', 'ilbs-alumni' ); ?></a>
			</div>
			<div class="ilbs-ref-blog-grid" data-reveal-stagger>
				<?php
				$blog_q = new WP_Query( [ 'post_type' => [ 'post', 'ilbs_news' ], 'posts_per_page' => 3 ] );
				if ( $blog_q->have_posts() ) :
					while ( $blog_q->have_posts() ) : $blog_q->the_post();
						$cats = get_the_category();
						$cat  = $cats ? $cats[0]->name : ( function_exists( 'get_field' ) ? get_field( 'news_category_label' ) : '' );
						?>
						<article class="ilbs-ref-blog-card" data-reveal-item>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="ilbs-ref-blog-card__thumb"><?php the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy' ] ); ?></a>
							<?php endif; ?>
							<div class="ilbs-ref-blog-card__body">
								<?php if ( $cat ) : ?><span class="ilbs-badge"><?php echo esc_html( $cat ); ?></span><?php endif; ?>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'Read more', 'ilbs-alumni' ); ?></a>
							</div>
						</article>
					<?php endwhile;
					wp_reset_postdata();
				endif; ?>
			</div>
		</div>
	</section>


	<!-- 13. RESOURCES & DOWNLOADS -->
	<section class="ilbs-ref-section" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Resources', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'Alumni Resources & Downloads', 'ilbs-alumni' ); ?></h2>
			</div>
			<div class="ilbs-ref-resources" data-reveal-stagger>
				<?php foreach ( $resources as $res ) : ?>
					<a href="<?php echo esc_url( $res['link'] ?: '#' ); ?>" class="ilbs-ref-resource-card" data-reveal-item>
						<span class="ilbs-ref-resource-card__icon"><i class="bi <?php echo esc_attr( $res['icon'] ); ?>"></i></span>
						<h3><?php echo esc_html( $res['title'] ); ?></h3>
						<p><?php echo esc_html( $res['desc'] ); ?></p>
						<span class="ilbs-link-arrow"><?php esc_html_e( 'Explore', 'ilbs-alumni' ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>


	<!-- 14. CONTACT -->
	<section class="ilbs-ref-section ilbs-ref-section--soft ilbs-ref-contact" id="contact" data-reveal>
		<div class="container">
			<div class="ilbs-ref-section-head ilbs-ref-section-head--center mb-5">
				<span class="ilbs-eyebrow"><?php esc_html_e( 'Get in Touch', 'ilbs-alumni' ); ?></span>
				<h2 class="ilbs-ref-title"><?php esc_html_e( 'Contact ILBS Alumni', 'ilbs-alumni' ); ?></h2>
			</div>
			<div class="ilbs-ref-contact__grid">
				<div class="ilbs-ref-contact__form-wrap">
					<form class="ilbs-ref-contact-form" action="#" method="post">
						<div class="ilbs-ref-field">
							<label for="contact-name"><?php esc_html_e( 'Your Name', 'ilbs-alumni' ); ?></label>
							<input type="text" id="contact-name" name="name" required placeholder="<?php esc_attr_e( 'Full name', 'ilbs-alumni' ); ?>">
						</div>
						<div class="ilbs-ref-field">
							<label for="contact-email"><?php esc_html_e( 'Email Address', 'ilbs-alumni' ); ?></label>
							<input type="email" id="contact-email" name="email" required placeholder="<?php esc_attr_e( 'you@email.com', 'ilbs-alumni' ); ?>">
						</div>
						<div class="ilbs-ref-field">
							<label for="contact-message"><?php esc_html_e( 'Message', 'ilbs-alumni' ); ?></label>
							<textarea id="contact-message" name="message" rows="4" required placeholder="<?php esc_attr_e( 'How can we help?', 'ilbs-alumni' ); ?>"></textarea>
						</div>
						<button type="submit" class="ilbs-btn ilbs-btn--primary" data-magnetic><?php esc_html_e( 'Send Message', 'ilbs-alumni' ); ?></button>
					</form>
				</div>
				<div class="ilbs-ref-contact__info">
					<div class="ilbs-ref-contact-card">
						<h3><?php esc_html_e( 'Contact Details', 'ilbs-alumni' ); ?></h3>
						<p><i class="bi bi-geo-alt"></i> <?php esc_html_e( 'Institute of Liver & Biliary Sciences, D-1 Vasant Kunj, New Delhi – 110070', 'ilbs-alumni' ); ?></p>
						<p><i class="bi bi-envelope"></i> <a href="mailto:alumni@ilbs.in">alumni@ilbs.in</a></p>
						<p><i class="bi bi-telephone"></i> +91 11 4630 0000</p>
						<div class="ilbs-ref-contact-card__social">
							<a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
							<a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
							<a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
						</div>
					</div>
					<div class="ilbs-ref-contact-map" aria-hidden="true">
						<svg viewBox="0 0 400 200" fill="none">
							<rect width="400" height="200" rx="16" fill="#134e4a" opacity="0.15"/>
							<circle cx="200" cy="100" r="40" fill="rgba(20,184,166,0.35)"/>
							<circle cx="200" cy="100" r="8" fill="#0F766E"/>
							<path d="M200 60v80M160 100h80" stroke="rgba(15,118,110,0.25)" stroke-width="1"/>
						</svg>
						<span><?php esc_html_e( 'ILBS Campus · New Delhi', 'ilbs-alumni' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- 15. CTA -->
	<section class="ilbs-ref-cta" data-reveal>
		<div class="container">
			<div class="ilbs-ref-cta__inner">
				<div>
					<h2><?php echo esc_html( function_exists( 'get_field' ) && get_field( 'cta_heading' ) ? get_field( 'cta_heading' ) : __( 'Stay Connected With The ILBS Alumni Network', 'ilbs-alumni' ) ); ?></h2>
					<p><?php echo esc_html( function_exists( 'get_field' ) && get_field( 'cta_description' ) ? get_field( 'cta_description' ) : __( 'Join thousands of graduates advancing liver science through collaboration, mentorship and lifelong institutional pride.', 'ilbs-alumni' ) ); ?></p>
				</div>
				<a href="<?php echo esc_url( function_exists( 'get_field' ) && get_field( 'cta_button_link' ) ? get_field( 'cta_button_link' ) : get_post_type_archive_link( 'ilbs_member' ) ); ?>" class="ilbs-btn ilbs-btn--white" data-magnetic>
					<?php echo esc_html( function_exists( 'get_field' ) && get_field( 'cta_button_text' ) ? get_field( 'cta_button_text' ) : __( 'Join Now', 'ilbs-alumni' ) ); ?>
				</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
