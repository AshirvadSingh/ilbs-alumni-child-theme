<?php
/**
 * ILBS Alumni — Generic Page Template
 */
get_header();
while ( have_posts() ) :
	the_post();
?>
<section class="page-hero ilbs-premium-subbanner">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url(home_url()); ?>">Home</a> &rsaquo; <?php the_title(); ?>
		</div>
		<h1><?php the_title(); ?></h1>
	</div>
</section>
<section class="ilbs-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-9">
				<div class="content-card">
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endwhile; ?>
<?php get_footer(); ?>
