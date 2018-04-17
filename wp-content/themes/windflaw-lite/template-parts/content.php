	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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