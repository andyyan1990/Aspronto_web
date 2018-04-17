<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<?php if(is_singular() && pings_open(get_queried_object())) : ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'windflaw-lite'); ?></a>
		<?php do_action('windflaw_site_header'); ?>

		<div id="main" class="<?php echo esc_attr(get_option('windflaw_theme_colors_scheme', 'light')) . '-color-scheme'; ?>">