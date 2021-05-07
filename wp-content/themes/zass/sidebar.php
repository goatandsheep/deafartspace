<?php
// Sidebar template
$zass_sidebar_choice = apply_filters('zass_has_sidebar', '');
?>

<?php if (function_exists('dynamic_sidebar') && $zass_sidebar_choice != 'none' && is_active_sidebar($zass_sidebar_choice) ) : ?>
	<div class="sidebar">
		<?php dynamic_sidebar($zass_sidebar_choice); ?>
	</div>
<?php endif;