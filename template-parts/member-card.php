<?php
/**
 * ILBS Alumni — Member Card Partial (AJAX + archive)
 */
$batches_t   = wp_get_post_terms( get_the_ID(), 'ilbs_batch' );
$batch_label = ( $batches_t && ! is_wp_error( $batches_t ) ) ? $batches_t[0]->name : '';
$spec        = wp_get_post_terms( get_the_ID(), 'ilbs_specialization' );
$spec_label  = ( $spec && ! is_wp_error( $spec ) ) ? $spec[0]->name : '';
?>
<article class="ilbs-card ilbs-member-card member-card">
	<?php if ( has_post_thumbnail() ) :
		the_post_thumbnail( 'thumbnail', [
			'class'   => 'avatar',
			'loading' => 'lazy',
		] );
	else : ?>
		<div class="avatar d-grid place-items-center mx-auto" style="width:88px;height:88px;border-radius:50%;"><i class="bi bi-person-fill" aria-hidden="true"></i></div>
	<?php endif; ?>

	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 10 ) ); ?></p>

	<?php if ( $batch_label ) : ?>
		<span class="ilbs-badge"><?php printf( esc_html__( 'Batch %s', 'ilbs-alumni' ), esc_html( $batch_label ) ); ?></span>
	<?php endif; ?>

	<?php if ( $spec_label ) : ?>
		<p class="mt-2 mb-0" style="font-size:.85rem;color:var(--text-muted);"><?php echo esc_html( $spec_label ); ?></p>
	<?php endif; ?>

	<a href="<?php the_permalink(); ?>" class="ilbs-link-arrow d-inline-flex mt-3"><?php esc_html_e( 'View profile', 'ilbs-alumni' ); ?></a>
</article>
