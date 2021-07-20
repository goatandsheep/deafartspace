<?php
// Off Canvas Sidebar template
$zass_sidebar_choice = apply_filters('zass_has_offcanvas_sidebar', '');
?>

<?php if (function_exists('dynamic_sidebar') && $zass_sidebar_choice != 'none' && is_active_sidebar($zass_sidebar_choice)) : ?>
  <aside class="sidebar off-canvas-sidebar" aria-label="Product Categories Sidebar">
    <a class="close-off-canvas" alt="close" title="close" href="#"></a>
    <div class="off-canvas-wrapper">
      <?php dynamic_sidebar($zass_sidebar_choice); ?>
    </div>
  </aside>
<?php endif; ?>