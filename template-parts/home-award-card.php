<?php
/**
 * Award / Publication card partial
 *
 * @var int $post_id Post ID.
 */
if ( empty( $post_id ) ) {
	return;
}

$is_pub  = ilbs_award_is_publication( $post_id );
$year    = function_exists( 'get_field' ) ? get_field( 'award_year', $post_id ) : '';
$name    = ilbs_get_award_recipient_name( $post_id );
$dept    = ilbs_get_award_department( $post_id );
$pdf     = function_exists( 'get_field' ) ? get_field( 'pdf_file', $post_id ) : '';
if ( is_array( $pdf ) && isset( $pdf['url'] ) ) {
	$pdf = $pdf['url'];
}
$excerpt = wp_trim_words( get_post_field( 'post_excerpt', $post_id ) ?: get_post_field( 'post_content', $post_id ), 18 );
$search_data = strtolower( implode( ' ', array_filter( [ get_the_title( $post_id ), $name, $dept, $excerpt, $year ] ) ) );
?>
<article class="ilbs-card ilbs-award-card ilbs-award-card--ref"
	data-award-card
	data-award-year="<?php echo esc_attr( $year ); ?>"
	data-search="<?php echo esc_attr( $search_data ); ?>"
	data-reveal-item>
	<div class="ilbs-award-card__icon" aria-hidden="true">
		<i class="bi <?php echo $is_pub ? 'bi-journal-medical' : 'bi-trophy-fill'; ?>"></i>
	</div>
	<div>
		<?php if ( $year ) : ?><span class="ilbs-badge mb-2"><?php echo esc_html( $year ); ?></span><?php endif; ?>
		<h3><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
		<?php if ( $name ) : ?>
			<p class="ilbs-award-card__meta"><?php echo esc_html( $is_pub ? __( 'Authors:', 'ilbs-alumni' ) . ' ' . $name : $name ); ?></p>
		<?php endif; ?>
		<?php if ( $dept ) : ?>
			<p class="ilbs-award-card__meta"><?php echo esc_html( $dept ); ?></p>
		<?php endif; ?>
		<?php if ( $excerpt ) : ?>
			<p><?php echo esc_html( $excerpt ); ?></p>
		<?php endif; ?>
		<div class="d-flex flex-wrap gap-3 mt-2">
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="ilbs-link-arrow">
				<?php echo $is_pub ? esc_html__( 'Read publication', 'ilbs-alumni' ) : esc_html__( 'View details', 'ilbs-alumni' ); ?>
			</a>
			<?php if ( $pdf ) : ?>
				<a href="<?php echo esc_url( $pdf ); ?>" class="ilbs-link-arrow" target="_blank" rel="noopener"><?php esc_html_e( 'PDF', 'ilbs-alumni' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</article>
