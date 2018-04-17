	<article class="post">
		<header class="post-header align-center">
			<div class="container">
				<h1 class="post-title"><?php the_title(); ?></h1>
				<aside class="post-meta">
					<?php echo Windflaw_Front::get_author_meta(); ?>
					<?php echo Windflaw_Front::get_date_meta(); ?>
					<?php echo Windflaw_Front::get_taxonomy_meta(); ?>
					<?php echo Windflaw_Front::get_comment_meta(true); ?>
				</aside>
			</div>
			<?php
				$media = apply_filters('windflaw_get_post_format_media', false);
				echo empty($media) ? (has_post_thumbnail($post->ID) ? sprintf('<figure>%s</figure>', get_the_post_thumbnail()) : '') : $media;
			?>
		</header>
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
			<?php echo windflaw_get_post_tags(); ?>
		</div>
	</article>
	<?php
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Next', 'windflaw-lite') . '</span> ' .
				'<span class="screen-reader-text">' . esc_html__('Next post:', 'windflaw-lite') . '</span> ' .
				'<span class="post-title">%title</span>',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Previous', 'windflaw-lite') . '</span> ' .
				'<span class="screen-reader-text">' . esc_html__('Previous post:', 'windflaw-lite') . '</span> ' .
				'<span class="post-title">%title</span>',
		));
	?>

	<?php $author_info = windflaw_get_author_info(); ?>
	<aside class="author-bio">
		<div class="author-bio-inner">
			<?php if(!empty($author_info['image'])) : ?>
				<div class="author-photo"><?php echo $author_info['image']; ?></div>
			<?php endif; ?>
			<div class="author-info">
				<span class="author-tag"><?php esc_html_e('Author', 'windflaw-lite'); ?></span>
				<h4>
					<a href="<?php echo $author_info['url']; ?>"><?php echo esc_html($author_info['name']); ?></a>
				</h4>
				<?php echo !empty($author_info['bio']) ? $author_info['bio'] : ''; ?>
			</div>
		</div>
	</aside>

	<?php comments_template(); ?>