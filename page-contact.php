<?php
/**
 * ILBS Alumni — Contact Page Template
 * Template Name: Contact
 */
get_header();

$hero_eyebrow = get_field('contact_hero_eyebrow') ?: 'Contact';
$hero_title   = get_field('contact_hero_title') ?: 'Alumni Office';
$hero_desc    = get_field('contact_hero_description') ?: '';

$form_title    = get_field('contact_form_title') ?: 'Support Form';
$form_shortcode = get_field('contact_form_shortcode');

$office_title   = get_field('office_title') ?: 'Office Details';
$office_name    = get_field('office_name');
$office_address = get_field('office_address');
$office_email   = get_field('office_email');
$office_phone   = get_field('office_phone');
$map_embed      = get_field('map_embed_code');
?>

<main>

<section class="page-hero">
	<div class="container">
		<span class="eyebrow text-warning"><?php echo esc_html($hero_eyebrow); ?></span>
		<h1><?php echo esc_html($hero_title); ?></h1>

		<?php if ($hero_desc) : ?>
			<p class="lead"><?php echo esc_html($hero_desc); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="row g-4">

			<div class="col-lg-6">
				<div class="content-card">
					<h3><?php echo esc_html($form_title); ?></h3>

					<?php if ($form_shortcode) : ?>
						<?php echo do_shortcode($form_shortcode); ?>
					<?php else : ?>
						<form class="row g-3">
							<div class="col-md-6">
								<input class="form-control" placeholder="Full name">
							</div>
							<div class="col-md-6">
								<input class="form-control" placeholder="Email">
							</div>
							<div class="col-12">
								<select class="form-select">
									<option>Membership support</option>
									<option>Event support</option>
									<option>Publication submission</option>
									<option>Feedback</option>
								</select>
							</div>
							<div class="col-12">
								<textarea class="form-control" rows="5" placeholder="Message"></textarea>
							</div>
							<div class="col-12">
								<button class="btn btn-primary">Send Message</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="content-card">
					<h3><?php echo esc_html($office_title); ?></h3>

					<?php if ($office_name || $office_address) : ?>
						<p>
							<?php if ($office_name) : ?>
								<strong><?php echo esc_html($office_name); ?></strong><br>
							<?php endif; ?>

							<?php if ($office_address) : ?>
								<?php echo nl2br(esc_html($office_address)); ?>
							<?php endif; ?>
						</p>
					<?php endif; ?>

					<?php if ($office_email || $office_phone) : ?>
						<p>
							<?php if ($office_email) : ?>
								<a href="mailto:<?php echo esc_attr($office_email); ?>">
									<?php echo esc_html($office_email); ?>
								</a><br>
							<?php endif; ?>

							<?php if ($office_phone) : ?>
								<a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $office_phone)); ?>">
									<?php echo esc_html($office_phone); ?>
								</a>
							<?php endif; ?>
						</p>
					<?php endif; ?>

					<?php if ($map_embed) : ?>
						<div class="contact-map">
							<?php echo $map_embed; ?>
						</div>
					<?php else : ?>
						<div style="height:240px;border-radius:8px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:grid;place-items:center;color:#fff;font-weight:900;">
							Map Embed
						</div>
					<?php endif; ?>

					<?php if (have_rows('social_links')) : ?>
						<div class="socials mt-3">
							<?php while (have_rows('social_links')) : the_row(); 
								$icon = get_sub_field('icon_class');
								$url  = get_sub_field('url');
							?>
								<?php if ($url) : ?>
									<a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
										<i class="<?php echo esc_attr($icon ?: 'bi bi-link'); ?>"></i>
									</a>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>
</section>

</main>

<style>
.contact-map iframe {
	width: 100%;
	height: 280px;
	border: 0;
	border-radius: 12px;
	display: block;
}
</style>

<?php get_footer(); ?>