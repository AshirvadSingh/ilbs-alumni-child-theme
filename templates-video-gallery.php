<?php
/**
 * Template Name: Video Gallery
 */
get_header();

$videos = get_field('videos'); // repeater
?>

<main>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Media</span>
		<h1><?php the_title(); ?></h1>
		<p class="lead"><?php echo esc_html( get_field('page_description') ?: 'Event highlights, campus tours and alumni interviews.' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">

		<?php if ( $videos && is_array( $videos ) ) : ?>
		<div class="row g-4">
			<?php foreach ( $videos as $i => $video ) :
				$title    = $video['title']       ?? '';
				$vimeo    = $video['vimeo_url']   ?? '';
				$thumb    = $video['thumbnail']   ?? '';
				$duration = $video['duration']    ?? '';
				$desc     = $video['description'] ?? '';
				$category = $video['category']    ?? '';

				// Extract Vimeo ID from any format:
				//   https://vimeo.com/255157080
				//   https://vimeo.com/255157080?h=44919ccb28
				//   https://player.vimeo.com/video/255157080
				//   https://player.vimeo.com/video/255157080?h=44919ccb28
				$vimeo_id = '';
				if ( $vimeo ) {
					if ( preg_match( '/player\.vimeo\.com\/video\/(\d+)/i', $vimeo, $m ) ) {
						$vimeo_id = $m[1];
					} elseif ( preg_match( '/vimeo\.com\/(\d+)/i', $vimeo, $m ) ) {
						$vimeo_id = $m[1];
					}
				}

				// Preserve ?h= hash for private videos
				$hash = '';
				if ( $vimeo_id && preg_match( '/[?&]h=([a-f0-9]+)/i', $vimeo, $hm ) ) {
					$hash = '?h=' . $hm[1] . '&autoplay=1';
				}
				$embed_url  = $vimeo_id ? 'https://player.vimeo.com/video/' . $vimeo_id . ( $hash ?: '?autoplay=1' ) : '';
				$thumb_auto = $vimeo_id ? 'https://vumbnail.com/' . $vimeo_id . '.jpg' : '';
				$final_thumb = $thumb ?: $thumb_auto;
			?>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 3) * 100; ?>">
				<article class="content-card">

					<!-- Video Thumbnail — click opens lightbox -->
					<div class="video-thumb"
						data-embed="<?php echo esc_attr( $embed_url ); ?>"
						style="cursor:<?php echo $embed_url ? 'pointer' : 'default'; ?>;position:relative;height:190px;border-radius:8px;overflow:hidden;background:linear-gradient(135deg,var(--secondary),var(--primary));margin-bottom:16px;">

						<?php if ( $final_thumb ) : ?>
							<img src="<?php echo esc_url( $final_thumb ); ?>"
								alt="<?php echo esc_attr( $title ); ?>"
								style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.7;">
						<?php endif; ?>

						<?php if ( $embed_url ) : ?>
						<div style="position:absolute;inset:0;display:grid;place-items:center;">
							<i class="bi bi-play-circle-fill" style="font-size:3.2rem;color:#fff;filter:drop-shadow(0 4px 12px rgba(0,0,0,.4));"></i>
						</div>
						<?php endif; ?>

						<?php if ( $duration ) : ?>
							<span style="position:absolute;bottom:10px;right:12px;background:rgba(0,0,0,.75);color:#fff;padding:3px 10px;border-radius:4px;font-size:.8rem;font-weight:700;">
								<?php echo esc_html( $duration ); ?>
							</span>
						<?php endif; ?>

						<?php if ( $category ) : ?>
							<span style="position:absolute;top:10px;left:12px;background:var(--primary);color:#fff;padding:3px 10px;border-radius:4px;font-size:.78rem;font-weight:700;">
								<?php echo esc_html( $category ); ?>
							</span>
						<?php endif; ?>
					</div>

					<h3 style="font-size:1.05rem;font-family:Inter,sans-serif;font-weight:900;"><?php echo esc_html( $title ); ?></h3>

					<?php if ( $desc ) : ?>
						<p><?php echo esc_html( wp_trim_words( $desc, 16 ) ); ?></p>
					<?php endif; ?>

					<?php if ( $embed_url ) : ?>
						<button class="link-arrow video-thumb-btn"
							data-embed="<?php echo esc_attr( $embed_url ); ?>"
							style="background:none;border:0;padding:0;cursor:pointer;font-weight:900;color:var(--primary);">
							Watch Video
						</button>
					<?php elseif ( $vimeo ) : ?>
						<a href="<?php echo esc_url( $vimeo ); ?>" target="_blank" rel="noopener" class="link-arrow">Watch on Vimeo</a>
					<?php endif; ?>

				</article>
			</div>
			<?php endforeach; ?>
		</div>

		<?php else : ?>
			<p class="text-muted">No videos added yet. Add videos via the WordPress admin.</p>
		<?php endif; ?>

	</div>
</section>

<!-- Vimeo Lightbox -->
<div id="videoLightbox"
	style="display:none;position:fixed;inset:0;background:rgba(3,12,28,.92);z-index:99999;align-items:center;justify-content:center;padding:30px;">
	<button id="videoLightboxClose"
		type="button"
		style="position:absolute;top:20px;right:28px;width:46px;height:46px;border-radius:50%;border:0;background:#fff;color:#111;font-size:1.6rem;line-height:1;cursor:pointer;">&times;</button>
	<div style="width:min(900px,95vw);aspect-ratio:16/9;">
		<iframe id="videoLightboxFrame"
			src=""
			allow="autoplay; fullscreen"
			allowfullscreen
			style="width:100%;height:100%;border:0;border-radius:12px;">
		</iframe>
	</div>
</div>

</main>

<script>
(function () {
	var lightbox = document.getElementById('videoLightbox');
	var frame    = document.getElementById('videoLightboxFrame');
	var closeBtn = document.getElementById('videoLightboxClose');

	function openLightbox(embed) {
		frame.src = embed;
		lightbox.style.display = 'flex';
	}

	function closeLightbox() {
		lightbox.style.display = 'none';
		frame.src = '';
	}

	// Thumbnail click
	document.querySelectorAll('.video-thumb[data-embed]').forEach(function (thumb) {
		thumb.addEventListener('click', function () {
			var embed = this.dataset.embed;
			if (embed) openLightbox(embed);
		});
	});

	// Watch Video button click
	document.querySelectorAll('.video-thumb-btn').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var embed = this.dataset.embed;
			if (embed) openLightbox(embed);
		});
	});

	closeBtn.addEventListener('click', closeLightbox);
	lightbox.addEventListener('click', function (e) {
		if (e.target === lightbox) closeLightbox();
	});
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') closeLightbox();
	});
})();
</script>

<?php get_footer(); ?>