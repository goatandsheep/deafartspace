<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce\Templates
 * @version     3.3.0
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
global $wp_query;
$woocommerce_sidebar = zass_get_option('woocommerce_sidebar');

$show_sidebar_class = '';

if (zass_get_option('show_sidebar_shop') && $woocommerce_sidebar && $woocommerce_sidebar != 'none' && !is_product()) {
	$show_sidebar_class = 'has-sidebar';
} elseif (zass_get_option('show_sidebar_product') && $woocommerce_sidebar && $woocommerce_sidebar != 'none' && is_product()) {
	$show_sidebar_class = 'has-sidebar';
}

$zass_offcanvas_sidebar_choice = apply_filters('zass_has_offcanvas_sidebar', '');

if ($zass_offcanvas_sidebar_choice != 'none') {
	$zass_has_offcanvas_sidebar = is_active_sidebar($zass_offcanvas_sidebar_choice);
} else {
	$zass_has_offcanvas_sidebar = false;
}

$sidebar_classes[] = $show_sidebar_class;

// Sidebar position
$sidebar_classes[] = apply_filters('zass_left_sidebar_position_class', '');

if ($zass_has_offcanvas_sidebar) {
	$sidebar_classes[] = 'has-off-canvas-sidebar';
}

// get Shop subtitle
$shop_subtitle = zass_get_option('shop_subtitle');
$show_title_background = zass_get_option('show_shop_title_background');
$title_background_image = zass_get_option('shop_title_background_imgid');

if ($title_background_image) {
	$img = wp_get_attachment_image_src($title_background_image, 'full');
	$title_background_image = $img[0];
}

// If it is product category - check if it has header image
$zass_prod_category_header_img_id = 0;
if (is_product_category()) {
    $zass_current_cat = $wp_query->get_queried_object();

    if (isset($zass_current_cat->term_id)) {
        $zass_prod_category_header_img_id = absint( get_term_meta( $zass_current_cat->term_id, 'zass_term_header_img_id', true ) );
    }
}
?>
<?php if ($zass_has_offcanvas_sidebar): ?>
	<?php get_sidebar('offcanvas'); ?>
<?php endif; ?>
<div id="content" class="content-area <?php echo esc_attr(implode(' ', $sidebar_classes)) ?>">
	<?php if (is_shop()): ?>
		<div id="zass_page_title" class="zass_title_holder <?php echo esc_attr(zass_get_option('shop_title_alignment')) ?> <?php if ($show_title_background && $title_background_image): ?>title_has_image<?php endif; ?>">
			<?php if ($show_title_background && $title_background_image): ?><div class="zass-zoomable-background" style="background-image: url('<?php echo esc_url($title_background_image) ?>');"></div><?php endif; ?>
		<?php elseif($zass_prod_category_header_img_id): ?>
		    <?php $zass_prod_category_header_img = wp_get_attachment_image_src($zass_prod_category_header_img_id, 'full'); ?>
		    <div id="zass_page_title" class="<?php echo implode(" ", array("zass_title_holder", "title_has_image", esc_attr(zass_get_option('shop_title_alignment')))) ?>">
			<div class="zass-zoomable-background" style="background-image: url('<?php echo esc_url($zass_prod_category_header_img[0]) ?>');"></div>
		<?php else: ?>
			<div id="zass_page_title" class="zass_title_holder" >
			<?php endif; ?>

			<div class="inner fixed">
				<!-- BREADCRUMB -->
				<?php woocommerce_breadcrumb() ?>
				<!-- END OF BREADCRUMB -->

				<!-- TITLE -->
				<?php if (!is_product() && apply_filters('woocommerce_show_page_title', true)): ?>
					<h1 class="product_title entry-title heading-title"><?php woocommerce_page_title(); ?></h1>
					<?php if (is_shop() && $shop_subtitle): ?>
						<h6><?php echo esc_html($shop_subtitle) ?></h6>
					<?php endif; ?>
				<?php endif; ?>
				<!-- END OF TITLE -->
			</div>

		</div>
		<div id="products-wrapper" class="inner site-main" role="main">
			<?php if ($zass_has_offcanvas_sidebar): ?>
				<a class="sidebar-trigger" href="#"><?php echo esc_html__('show', 'zass') ?></a>
			<?php endif; ?>