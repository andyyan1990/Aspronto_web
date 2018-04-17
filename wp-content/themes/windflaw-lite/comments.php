<?php
/**
 * Comments html template
 *
 * @package   windflaw
 * @link	  http://www.loftocean.com/
 * @author	  Suihai Huang from Loft Ocean Team
 * @copyright Copyright (c) 2016
 */
if(post_password_required()){
	return;
}

if(have_comments() || comments_open()){
	$commentNum = get_comments_number();
	$hasComment = have_comments();
	wp_enqueue_script('comment-reply');
?>
	<div class="comments" id="comments">
		<?php if($hasComment) : ?>
			<h2 class="comments-title">
				<?php
					printf(
						esc_html(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $commentNum, 'comments title', 'windflaw-lite')),
						number_format_i18n($commentNum),
						get_the_title()
					);
				?>
			</h2>
			<ol class="comment-list"><?php wp_list_comments(array('style' => 'ol', 'short_ping' => true, 'avatar_size' => 115)); ?></ol>
			<?php if(paginate_comments_links(array('echo' => false))) : ?>
				<div class="navigation"><?php paginate_comments_links(); ?></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(comments_open()) : comment_form(); endif; ?>
	</div>
<?php
}
?>