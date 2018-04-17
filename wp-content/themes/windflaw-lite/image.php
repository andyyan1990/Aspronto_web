<?php
get_header();

$content = get_the_content();
if(strpos($post->post_mime_type, 'image') !== false){
	$description = $post->post_content;
	$content  = wp_get_attachment_image($post->ID, 'large') ;
	$content .= !empty($description) ? ('<p>' . esc_html($description) . '</p>') : '';
	$content .= '<div class="attachment-fullsize-btn"><a href="' . esc_url(wp_get_attachment_url()) . '">'. esc_html__('Full Size', 'windflaw-lite') . '</a></div>';
}
?>

			<article class="post">
				<header class="page-header align-center <?php echo esc_attr(get_option('windflaw_theme_colors_scheme', 'light')); ?>-page-header">
					<div class="container">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
				</header>
				<div class="entry"><?php echo $content; ?></div>
			</article>


<?php
get_footer();
?>