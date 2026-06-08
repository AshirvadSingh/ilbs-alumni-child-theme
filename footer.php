<button type="button" class="ilbs-back-top" aria-label="<?php esc_attr_e( 'Back to top', 'ilbs-alumni' ); ?>">
	<i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>

<div id="ilbsPhotoLightbox" class="ilbs-photo-lightbox" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Photo preview', 'ilbs-alumni' ); ?>">
	<button type="button" class="ilbs-photo-lightbox__close" aria-label="<?php esc_attr_e( 'Close', 'ilbs-alumni' ); ?>">&times;</button>
	<button type="button" class="ilbs-photo-lightbox__nav ilbs-photo-lightbox__prev" aria-label="<?php esc_attr_e( 'Previous photo', 'ilbs-alumni' ); ?>"><i class="bi bi-chevron-left" aria-hidden="true"></i></button>
	<img src="" alt="" class="ilbs-photo-lightbox__img">
	<button type="button" class="ilbs-photo-lightbox__nav ilbs-photo-lightbox__next" aria-label="<?php esc_attr_e( 'Next photo', 'ilbs-alumni' ); ?>"><i class="bi bi-chevron-right" aria-hidden="true"></i></button>
</div>

<div id="ilbsVideoLightbox" class="ilbs-video-lightbox" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Video player', 'ilbs-alumni' ); ?>">
	<button type="button" id="ilbsVideoLightboxClose" class="ilbs-video-lightbox__close" aria-label="<?php esc_attr_e( 'Close video', 'ilbs-alumni' ); ?>">&times;</button>
	<div class="ilbs-video-lightbox__frame">
		<iframe id="ilbsVideoLightboxFrame" src="" allow="autoplay; fullscreen" allowfullscreen title="<?php esc_attr_e( 'Video', 'ilbs-alumni' ); ?>"></iframe>
	</div>
</div>

<?php include get_stylesheet_directory() . '/template-parts/footer.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
