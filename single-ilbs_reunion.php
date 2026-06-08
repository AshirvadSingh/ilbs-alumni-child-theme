<?php
/**
 * Single Reunion — Photo Gallery
 */
get_header();

while ( have_posts() ) :
	the_post();

	$gallery = function_exists( 'get_field' ) ? get_field( 'gallery_images' ) : [];
	?>

<main id="main-content">

	<section class="page-hero ilbs-page-hero">
		<div class="container">
			<nav class="ilbs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ilbs-alumni' ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a> &rsaquo;
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>"><?php esc_html_e( 'Reunions', 'ilbs-alumni' ); ?></a> &rsaquo;
				<?php the_title(); ?>
			</nav>
			<span class="ilbs-eyebrow"><?php esc_html_e( 'Gallery', 'ilbs-alumni' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<?php
			$event_date = function_exists( 'get_field' ) ? get_field( 'event_date' ) : '';
			$venue      = function_exists( 'get_field' ) ? get_field( 'venue' ) : '';
			if ( $event_date || $venue ) :
				?>
				<p class="lead">
					<?php echo esc_html( trim( $event_date . ( $event_date && $venue ? ' · ' : '' ) . $venue ) ); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<section class="ilbs-section ilbs-gallery-page ilbs-reunion-gallery">
		<div class="container">

			<div class="ilbs-gallery-filters mb-4" role="toolbar" aria-label="<?php esc_attr_e( 'Gallery filters', 'ilbs-alumni' ); ?>">
				<button type="button" class="ilbs-year-pill is-active" data-gallery-filter="all"><?php esc_html_e( 'All Photos', 'ilbs-alumni' ); ?></button>
			</div>

			<?php if ( $gallery && is_array( $gallery ) ) : ?>
				<div class="ilbs-photo-grid" data-reveal-stagger>
					<?php foreach ( $gallery as $index => $image ) :
						if ( empty( $image['url'] ) ) {
							continue;
						}
						$thumb = $image['sizes']['large'] ?? $image['url'];
						$alt   = $image['alt'] ?? get_the_title();
						?>
						<button type="button"
							class="ilbs-photo-tile"
							data-reveal-item
							data-gallery-lightbox="<?php echo esc_url( $image['url'] ); ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'View photo %d', 'ilbs-alumni' ), $index + 1 ) ); ?>">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
							<span class="ilbs-photo-tile__overlay">
								<span><?php echo esc_html( get_the_title() ); ?></span>
								<i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
							</span>
						</button>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="ilbs-empty-state">
					<h3 class="h5"><?php esc_html_e( 'No gallery images found', 'ilbs-alumni' ); ?></h3>
					<p class="mb-0"><?php esc_html_e( 'Upload photos via the reunion editor in WordPress admin.', 'ilbs-alumni' ); ?></p>
				</div>
			<?php endif; ?>

		</div>
	</section>

</main>

<?php endwhile; ?>

<?php get_footer(); ?>
