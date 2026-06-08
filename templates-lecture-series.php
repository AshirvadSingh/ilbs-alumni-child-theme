<?php
/**
 * Template Name: Lecture Series
 */
get_header();

$lectures = get_field('lectures'); // repeater

/**
 * Helper: Extract embed URL + thumbnail from any video URL
 * Supports:
 *   YouTube:  youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID
 *   Vimeo:    vimeo.com/ID, player.vimeo.com/video/ID (with optional ?h= hash)
 *
 * Returns array: ['embed' => '...', 'thumb' => '...', 'type' => 'youtube|vimeo|']
 */
function ilbs_parse_video_url( $url ) {
	if ( ! $url ) return [ 'embed' => '', 'thumb' => '', 'type' => '' ];

	// ── YouTube ────────────────────────────────────────────
	$yt_id = '';
	if ( preg_match( '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{11})/i', $url, $m ) ) {
		$yt_id = $m[1];
	} elseif ( preg_match( '/youtu\.be\/([a-zA-Z0-9_-]{11})/i', $url, $m ) ) {
		$yt_id = $m[1];
	} elseif ( preg_match( '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/i', $url, $m ) ) {
		$yt_id = $m[1];
	}

	if ( $yt_id ) {
		return [
			'embed' => 'https://www.youtube.com/embed/' . $yt_id . '?autoplay=1&rel=0',
			'thumb' => 'https://img.youtube.com/vi/' . $yt_id . '/hqdefault.jpg',
			'type'  => 'youtube',
		];
	}

	// ── Vimeo ──────────────────────────────────────────────
	$vimeo_id = '';
	if ( preg_match( '/player\.vimeo\.com\/video\/(\d+)/i', $url, $m ) ) {
		$vimeo_id = $m[1];
	} elseif ( preg_match( '/vimeo\.com\/(\d+)/i', $url, $m ) ) {
		$vimeo_id = $m[1];
	}

	if ( $vimeo_id ) {
		$hash = '';
		if ( preg_match( '/[?&]h=([a-f0-9]+)/i', $url, $hm ) ) {
			$hash = '?h=' . $hm[1] . '&autoplay=1';
		}
		return [
			'embed' => 'https://player.vimeo.com/video/' . $vimeo_id . ( $hash ?: '?autoplay=1' ),
			'thumb' => 'https://vumbnail.com/' . $vimeo_id . '.jpg',
			'type'  => 'vimeo',
		];
	}

	return [ 'embed' => '', 'thumb' => '', 'type' => '' ];
}
?>

<main>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Media</span>
		<h1><?php the_title(); ?></h1>
		<p class="lead"><?php echo esc_html( get_field('page_description') ?: 'Distinguished alumni lecture archive with video recordings and presentations.' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">

		<?php if ( $lectures && is_array( $lectures ) ) : ?>
		<div class="row g-4">
			<?php foreach ( $lectures as $i => $lecture ) :
				$title    = $lecture['title']       ?? '';
				$speaker  = $lecture['speaker']     ?? '';
				$date     = $lecture['date']        ?? '';
				$video_url = $lecture['vimeo_url']  ?? ''; // field name kept as-is
				$thumb    = $lecture['thumbnail']   ?? '';
				$desc     = $lecture['description'] ?? '';
				$pdf      = $lecture['pdf_file']    ?? '';
				$duration = $lecture['duration']    ?? '';

				$parsed      = ilbs_parse_video_url( $video_url );
				$embed_url   = $parsed['embed'];
				$thumb_auto  = $parsed['thumb'];
				$final_thumb = $thumb ?: $thumb_auto;
			?>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 3) * 100; ?>">
				<article class="content-card">

					<!-- Thumbnail -->
					<div class="video-thumb"
						data-embed="<?php echo esc_attr( $embed_url ); ?>"
						style="cursor:<?php echo $embed_url ? 'pointer' : 'default'; ?>;position:relative;height:190px;border-radius:8px;overflow:hidden;background:linear-gradient(135deg,var(--secondary),var(--primary));margin-bottom:16px;">

						<?php if ( $final_thumb ) : ?>
							<img src="<?php echo esc_url( $final_thumb ); ?>"
								alt="<?php echo esc_attr( $title ); ?>"
								style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.65;">
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

						<?php if ( $date ) : ?>
							<span style="position:absolute;top:10px;left:12px;background:var(--primary);color:#fff;padding:3px 10px;border-radius:4px;font-size:.78rem;font-weight:700;">
								<?php echo esc_html( $date ); ?>
							</span>
						<?php endif; ?>
					</div>

					<!-- Info -->
					<h3 style="font-size:1.05rem;font-family:Inter,sans-serif;font-weight:900;"><?php echo esc_html( $title ); ?></h3>

					<?php if ( $speaker ) : ?>
						<p style="font-weight:700;color:var(--primary);margin:6px 0;">
							<i class="bi bi-person me-1"></i><?php echo esc_html( $speaker ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $desc ) : ?>
						<p><?php echo esc_html( wp_trim_words( $desc, 16 ) ); ?></p>
					<?php endif; ?>

					<!-- Actions -->
					<div class="d-flex gap-3 flex-wrap mt-2">
						<?php if ( $embed_url ) : ?>
							<button class="link-arrow video-thumb-btn"
								data-embed="<?php echo esc_attr( $embed_url ); ?>"
								style="background:none;border:0;padding:0;cursor:pointer;font-weight:900;color:var(--primary);">
								Watch Lecture
							</button>
						<?php elseif ( $video_url ) : ?>
							<a href="<?php echo esc_url( $video_url ); ?>" target="_blank" rel="noopener" class="link-arrow">Watch Video</a>
						<?php endif; ?>

						<?php if ( $pdf ) : ?>
							<a href="<?php echo esc_url( is_array($pdf) ? $pdf['url'] : $pdf ); ?>"
								target="_blank" rel="noopener"
								style="font-weight:900;color:var(--muted);">
								<i class="bi bi-file-earmark-pdf me-1"></i>Slides
							</a>
						<?php endif; ?>
					</div>

				</article>
			</div>
			<?php endforeach; ?>
		</div>

		<?php else : ?>
			<p class="text-muted">No lectures added yet. Add lectures via the WordPress admin.</p>
		<?php endif; ?>

	</div>
</section>

<!-- Video Lightbox (YouTube + Vimeo) -->
<div id="videoLightbox"
	style="display:none;position:fixed;inset:0;background:rgba(3,12,28,.92);z-index:99999;align-items:center;justify-content:center;padding:30px;">
	<button id="videoLightboxClose"
		type="button"
		style="position:absolute;top:20px;right:28px;width:46px;height:46px;border-radius:50%;border:0;background:#fff;color:#111;font-size:1.6rem;line-height:1;cursor:pointer;">&times;</button>
	<div style="width:min(900px,95vw);aspect-ratio:16/9;">
		<iframe id="videoLightboxFrame"
			src=""
			allow="autoplay; fullscreen; picture-in-picture"
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

	document.querySelectorAll('.video-thumb[data-embed]').forEach(function (thumb) {
		thumb.addEventListener('click', function () {
			var embed = this.dataset.embed;
			if (embed) openLightbox(embed);
		});
	});

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