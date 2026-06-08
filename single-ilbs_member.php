<?php
/**
 * ILBS Alumni — Single Member Profile
 * Maps to: pages/member-single.html
 */
get_header();

while ( have_posts() ) :
	the_post();

	$batch         = wp_get_post_terms( get_the_ID(), 'ilbs_batch' );
	$batch_label   = ( $batch && ! is_wp_error( $batch ) ) ? $batch[0]->name : '';
	$spec          = wp_get_post_terms( get_the_ID(), 'ilbs_specialization' );
	$spec_label    = ( $spec && ! is_wp_error( $spec ) ) ? $spec[0]->name : '';
	$location      = wp_get_post_terms( get_the_ID(), 'ilbs_location' );
	$loc_label     = ( $location && ! is_wp_error( $location ) ) ? $location[0]->name : '';

	// ACF fields (graceful fallback if ACF not installed)
	$profession    = function_exists('get_field') ? get_field('profession')    : '';
	$organization  = function_exists('get_field') ? get_field('organization')  : '';
	$email         = function_exists('get_field') ? get_field('email')         : '';
	$phone         = function_exists('get_field') ? get_field('phone')         : '';
	$linkedin      = function_exists('get_field') ? get_field('linkedin')      : '';
	$achievements  = function_exists('get_field') ? get_field('achievements')  : '';
	$research      = function_exists('get_field') ? get_field('research')      : '';
	$publications  = function_exists('get_field') ? get_field('publications')  : '';
	$awards_list   = function_exists('get_field') ? get_field('awards')        : '';
?>

<!-- Page Hero -->
<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( get_post_type_archive_link('ilbs_member') ); ?>">Members</a> &rsaquo;
			<?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Member Profile</span>
		<h1><?php the_title(); ?></h1>
		<?php if ( $profession || $organization ) : ?>
			<p class="lead"><?php echo esc_html( trim( $profession . ( $organization ? ', ' . $organization : '' ) ) ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="row g-5">

			<!-- Left — Profile Card -->
			<div class="col-lg-4">
				<div class="content-card text-center">
					<?php if ( has_post_thumbnail() ) :
						echo get_the_post_thumbnail( null, 'medium', [ 'style' => 'width:160px;height:180px;object-fit:cover;border-radius:8px;margin:0 auto 20px;display:block;' ] );
					else : ?>
						<div class="portrait" style="margin:0 auto 20px;width:160px;height:180px;font-size:4rem;"><i class="bi bi-person-fill"></i></div>
					<?php endif; ?>

					<h2 style="font-size:1.5rem;margin-bottom:6px"><?php the_title(); ?></h2>
					<?php if ( $spec_label ) : ?>
						<p class="eyebrow"><?php echo esc_html( $spec_label ); ?></p>
					<?php endif; ?>

					<div class="meta-row justify-content-center mt-3">
						<?php if ( $batch_label ) : ?>
							<span class="meta-badge">Batch <?php echo esc_html( $batch_label ); ?></span>
						<?php endif; ?>
						<?php if ( $loc_label ) : ?>
							<span class="meta-badge"><i class="bi bi-geo-alt"></i> <?php echo esc_html( $loc_label ); ?></span>
						<?php endif; ?>
					</div>

					<hr style="border-color:var(--line);margin:20px 0;">

					<!-- Contact Info -->
					<div style="text-align:left">
						<?php if ( $email ) : ?>
							<p><i class="bi bi-envelope me-2" style="color:var(--primary)"></i><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
						<?php endif; ?>
						<?php if ( $phone ) : ?>
							<p><i class="bi bi-telephone me-2" style="color:var(--primary)"></i><?php echo esc_html( $phone ); ?></p>
						<?php endif; ?>
						<?php if ( $linkedin ) : ?>
							<p><i class="bi bi-linkedin me-2" style="color:var(--primary)"></i><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">LinkedIn Profile</a></p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Right — Details -->
			<div class="col-lg-8">

				<!-- Bio -->
				<?php if ( get_the_content() ) : ?>
				<div class="content-card mb-4">
					<h3>About</h3>
					<div class="entry-content mt-3">
						<?php the_content(); ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Achievements -->
				<?php if ( $achievements ) : ?>
				<div class="content-card mb-4">
					<h3>Achievements</h3>
					<p class="mt-3"><?php echo wp_kses_post( $achievements ); ?></p>
				</div>
				<?php endif; ?>

				<!-- Research Interests -->
				<?php if ( $research ) : ?>
				<div class="content-card mb-4">
					<h3>Research Interests</h3>
					<p class="mt-3"><?php echo wp_kses_post( $research ); ?></p>
				</div>
				<?php endif; ?>

				<!-- Publications -->
				<?php if ( $publications ) : ?>
				<div class="content-card mb-4">
					<h3>Publications</h3>
					<div class="mt-3"><?php echo wp_kses_post( $publications ); ?></div>
				</div>
				<?php endif; ?>

				<!-- Awards -->
				<?php if ( $awards_list ) : ?>
				<div class="content-card">
					<h3>Awards &amp; Recognitions</h3>
					<div class="mt-3"><?php echo wp_kses_post( $awards_list ); ?></div>
				</div>
				<?php endif; ?>

			</div>
		</div>

		<!-- Back Link -->
		<div class="mt-5">
			<a href="<?php echo esc_url( get_post_type_archive_link('ilbs_member') ); ?>" class="btn btn-primary">
				<i class="bi bi-arrow-left me-2"></i> Back to Directory
			</a>
		</div>
	</div>
</section>

<?php endwhile; ?>
<?php get_footer(); ?>
