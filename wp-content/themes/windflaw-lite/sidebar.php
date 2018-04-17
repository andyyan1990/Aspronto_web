<?php
/**
* Sidebar template
*/
?>

<?php if(is_active_sidebar('sidebar-1')) : ?>
	<div class="container"><?php dynamic_sidebar('sidebar-1'); ?></div>
<?php endif; ?>