<?php
/**
 * Template Name: Photo Gallery
 *
 * ACF Repeater: galleries
 */
get_header();

$galleries = function_exists( 'get_field' ) ? get_field( 'galleries' ) : [];
?>

<main id="main-content">

	<section class="page-hero ilbs-page-hero">
		<div class="container">
			<nav class="ilbs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ilbs-alumni' ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a> &rsaquo; <?php the_title(); ?>
			</nav>
			<span class="ilbs-eyebrow"><?php esc_html_e( 'Media', 'ilbs-alumni' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p class="lead">
				<?php echo esc_html( get_field( 'page_description' ) ?: __( 'Convocation ceremonies, reunion highlights and campus memories.', 'ilbs-alumni' ) ); ?>
			</p>
		</div>
	</section>

	<section class="ilbs-section ilbs-gallery-page">
		<div class="container">

			<?php if ( $galleries && is_array( $galleries ) ) : ?>

				<div class="ilbs-gallery-filters mb-4" role="toolbar" aria-label="<?php esc_attr_e( 'Gallery filters', 'ilbs-alumni' ); ?>">
					<button type="button" class="ilbs-year-pill is-active" data-gallery-filter="all"><?php esc_html_e( 'All Albums', 'ilbs-alumni' ); ?></button>
				</div>

				<div class="convocation-grid" data-reveal-stagger>
					<?php foreach ( $galleries as $i => $item ) :
						$title        = $item['title'] ?? '';
						$date         = $item['date'] ?? '';
						$guest_name   = $item['Name'] ?? ( $item['name'] ?? '' );
						$role         = $item['role'] ?? '';
						$quote        = $item['quote'] ?? '';
						$gallery_link = $item['gallery_link'] ?? '';

						// ACF image: URL string or array
						$photo_raw = $item['photo'] ?? '';
						$photo_url = '';
						$photo_alt = $guest_name ?: $title;
						if ( is_array( $photo_raw ) ) {
							$photo_url = $photo_raw['url'] ?? ( $photo_raw['sizes']['large'] ?? '' );
							$photo_alt = $photo_raw['alt'] ?? $photo_alt;
						} elseif ( is_numeric( $photo_raw ) ) {
							$photo_url = wp_get_attachment_image_url( (int) $photo_raw, 'large' );
						} else {
							$photo_url = (string) $photo_raw;
						}
						?>
						<article class="convocation-card ilbs-card" data-reveal-item data-gallery-item>

							<?php if ( $date ) : ?>
								<span class="convocation-year-badge"><?php echo esc_html( $date ); ?></span>
							<?php endif; ?>

							<div class="convocation-oval">
								<?php if ( $photo_url ) : ?>
									<button type="button"
										class="convocation-photo-btn"
										data-gallery-lightbox="<?php echo esc_url( $photo_url ); ?>"
										aria-label="<?php echo esc_attr( sprintf( __( 'View photo: %s', 'ilbs-alumni' ), $guest_name ?: $title ) ); ?>">
										<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $photo_alt ); ?>" loading="lazy">
									</button>
								<?php else : ?>
									<i class="bi bi-person-fill" aria-hidden="true"></i>
								<?php endif; ?>
							</div>

							<?php if ( $title && $guest_name ) : ?>
								<p class="convocation-event-title"><?php echo esc_html( $title ); ?></p>
							<?php endif; ?>

							<?php if ( $guest_name ) : ?>
								<h3 class="convocation-name"><?php echo esc_html( $guest_name ); ?></h3>
							<?php elseif ( $title ) : ?>
								<h3 class="convocation-name"><?php echo esc_html( $title ); ?></h3>
							<?php endif; ?>

							<?php if ( $role ) : ?>
								<p class="convocation-role"><?php echo nl2br( esc_html( $role ) ); ?></p>
							<?php endif; ?>

							<div class="convocation-divider" aria-hidden="true"></div>

							<?php if ( $quote ) : ?>
								<blockquote class="convocation-quote-text">
									<i class="bi bi-quote" aria-hidden="true"></i>
									<?php echo nl2br( esc_html( $quote ) ); ?>
								</blockquote>
							<?php endif; ?>

							<?php if ( $gallery_link ) : ?>
								<a href="<?php echo esc_url( $gallery_link ); ?>" class="convocation-gallery-btn">
									<i class="bi bi-images" aria-hidden="true"></i>
									<?php esc_html_e( 'View album', 'ilbs-alumni' ); ?>
								</a>
							<?php else : ?>
								<span class="convocation-no-link">
									<i class="bi bi-image" aria-hidden="true"></i> <?php esc_html_e( 'Photo preview', 'ilbs-alumni' ); ?>
								</span>
							<?php endif; ?>

						</article>
					<?php endforeach; ?>
				</div>

			<?php else : ?>
				<div class="ilbs-empty-state">
					<p><?php esc_html_e( 'No galleries added yet. Add entries via the WordPress admin.', 'ilbs-alumni' ); ?></p>
				</div>
			<?php endif; ?>

		</div>
	</section>

</main>

<?php get_footer(); ?>
