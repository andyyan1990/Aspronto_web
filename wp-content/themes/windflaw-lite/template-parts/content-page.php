	<article class="post">
		<?php windflaw_get_page_header(); ?>
		<div class="entry">
			<?php the_content(); ?>
			<?php 
				wp_link_pages(array(
					'next_or_number' => 'number',
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'windflaw-lite') . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				));
			?>
		</div>
	</article>

	<?php comments_template(); ?>