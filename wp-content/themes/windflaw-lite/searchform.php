<!-- .site search -->
<div class="search-wrapper">
	<div>
		<form method="get" action="<?php echo esc_url(home_url()); ?>">
			<input name="s" type="text" placeholder="<?php esc_attr_e('Search...', 'windflaw-lite'); ?>">
			<button class="search" type="submit" name="submit">
				<span><?php esc_html_e('Search', 'windflaw-lite'); ?></span>
			</button>
		</form>
	</div>
</div>
<!-- end of .site search -->