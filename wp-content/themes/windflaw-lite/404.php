<?php
get_header();
?>

	<article class="post">
		<header class="page-header align-center <?php echo esc_attr(get_option('windflaw_theme_colors_scheme', 'light')); ?>-page-header">
			<div class="post-header-inner">
				<h1 class="post-title"><?php esc_html_e('Sorry, but nothing found.', 'windflaw-lite'); ?></h1>
			</div>
		</header>
	</article>

<?php
get_footer();
?>