<?php
/**
 * Award / Publication card partial
 *
 * @var int $post_id Post ID.
 */
if ( empty( $post_id ) ) {
	return;
}

$is_pub      = ilbs_is_publication_item( $post_id );
$year        = ilbs_get_award_item_year( $post_id );
$post_title  = get_the_title( $post_id );
$award_title = $post_title;
if ( ! $is_pub && function_exists( 'get_field' ) ) {
	$award_title = get_field( 'award_display_name', $post_id ) ?: get_field( 'award_name', $post_id ) ?: get_field( 'award_title', $post_id ) ?: $post_title;
}
$name        = $is_pub && function_exists( 'get_field' ) && get_field( 'authors', $post_id ) ? get_field( 'authors', $post_id ) : ilbs_get_award_recipient_name( $post_id );
if ( is_array( $name ) ) {
	$name = implode( ', ', $name );
}
$dept    = ilbs_get_award_department( $post_id );
$journal = function_exists( 'get_field' ) ? ( get_field( 'journal_name', $post_id ) ?: get_field( 'journal', $post_id ) ) : '';
$pdf     = function_exists( 'get_field' ) ? ( get_field( 'pdf_file', $post_id ) ?: get_field( 'publication_pdf', $post_id ) ) : '';
if ( is_array( $pdf ) && isset( $pdf['url'] ) ) {
	$pdf = $pdf['url'];
}
$summary      = function_exists( 'get_field' ) ? ( get_field( 'summary', $post_id ) ?: get_field( 'abstract', $post_id ) ) : '';
$excerpt      = wp_trim_words( $summary ?: ( get_post_field( 'post_excerpt', $post_id ) ?: get_post_field( 'post_content', $post_id ) ), 22 );
$display_name = $is_pub ? $post_title : ( $name ?: $post_title );
$search_data  = strtolower( implode( ' ', array_filter( [ $post_title, $award_title, $name, $dept, $journal, $excerpt, $year, get_post_type( $post_id ) ] ) ) );
?>
<article class="ilbs-card ilbs-award-card ilbs-award-card--ref <?php echo $is_pub ? 'ilbs-award-card--publication' : 'ilbs-award-card--award'; ?>"
	data-award-card
	data-award-year="<?php echo esc_attr( $year ); ?>"
	data-search="<?php echo esc_attr( $search_data ); ?>"
	data-reveal-item>
	<div class="ilbs-award-card__icon" aria-hidden="true">
		<i class="bi <?php echo $is_pub ? 'bi-file-earmark-pdf-fill' : 'bi-trophy-fill'; ?>"></i>
	</div>
	<div class="ilbs-award-card__content">
		<div class="ilbs-award-card__topline">
			<?php if ( $year ) : ?><span class="ilbs-badge"><?php echo esc_html( $year ); ?></span><?php endif; ?>
			<span class="ilbs-award-card__type"><?php echo $is_pub ? esc_html__( 'Publication', 'ilbs-alumni' ) : esc_html__( 'Award', 'ilbs-alumni' ); ?></span>
		</div>
		<h3>
			<?php if ( $is_pub ) : ?>
				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( $display_name ); ?></a>
			<?php else : ?>
				<?php echo esc_html( $display_name ); ?>
			<?php endif; ?>
		</h3>

		<?php if ( $is_pub ) : ?>
			<?php if ( $name ) : ?>
				<p class="ilbs-award-card__meta"><strong><?php esc_html_e( 'Authors:', 'ilbs-alumni' ); ?></strong> <?php echo esc_html( $name ); ?></p>
			<?php endif; ?>
			<?php if ( $journal || $dept ) : ?>
				<p class="ilbs-award-card__meta"><strong><?php esc_html_e( 'Journal:', 'ilbs-alumni' ); ?></strong> <?php echo esc_html( $journal ?: $dept ); ?></p>
			<?php endif; ?>
			<?php if ( $excerpt ) : ?>
				<p><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>
			<div class="d-flex flex-wrap gap-3 mt-2">
				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="ilbs-link-arrow"><?php esc_html_e( 'Read More', 'ilbs-alumni' ); ?></a>
				<?php if ( $pdf ) : ?>
					<a href="<?php echo esc_url( $pdf ); ?>" class="ilbs-link-arrow" target="_blank" rel="noopener"><?php esc_html_e( 'PDF', 'ilbs-alumni' ); ?></a>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<div class="ilbs-award-card__details" aria-label="<?php esc_attr_e( 'Award details', 'ilbs-alumni' ); ?>">
				<?php if ( $award_title ) : ?>
					<p class="ilbs-award-card__meta"><strong><?php esc_html_e( 'Award:', 'ilbs-alumni' ); ?></strong> <?php echo esc_html( $award_title ); ?></p>
				<?php endif; ?>
				<?php if ( $dept ) : ?>
					<p class="ilbs-award-card__meta"><strong><?php esc_html_e( 'Department:', 'ilbs-alumni' ); ?></strong> <?php echo esc_html( $dept ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</article>
