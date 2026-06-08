<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="ilbs-scroll-progress" aria-hidden="true"></div>
<div class="ilbs-cursor-dot" aria-hidden="true"></div>
<div class="ilbs-cursor-ring" aria-hidden="true"></div>

<?php include get_stylesheet_directory() . '/template-parts/header.php'; ?>
