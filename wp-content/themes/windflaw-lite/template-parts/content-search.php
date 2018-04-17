		<?php
			while(have_posts()) : the_post();
				$author = windflaw_get_author_info();
		?>
			<article <?php post_class(); ?>>
				<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="post-meta">
					<?php if(!is_author()) : ?>
						<a href="<?php echo $author['url']; ?>">
							<span class="author-name"><?php echo esc_html($author['name']); ?></span>
						</a>
					<?php endif; ?>
					<?php get_template_part('template-parts/search/metas', get_post_type()); ?>
				</div>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>

		<?php
			the_posts_pagination(array(
				'mid_size' => 2,
				'prev_text' => '<span><i class="fa fa-angle-left"></i></span>',
				'next_text' => '<span><i class="fa fa-angle-right"></i></span>'
			));
		?>