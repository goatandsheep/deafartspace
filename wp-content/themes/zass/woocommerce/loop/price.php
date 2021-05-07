<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
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
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;

$product_excerpt = '';

if (zass_get_option('shop_default_product_columns') == 'zass-products-list-view') {
	$product_excerpt = wp_trim_words(get_the_excerpt(), 30, ' ...');
}
?>
<!-- If List view is set show the product excerpt  -->
<?php if (zass_get_option('shop_default_product_columns') == 'zass-products-list-view') : ?>
	<div class="zass-product-excerpt">
		<?php echo esc_html($product_excerpt) ?>
	</div>
<?php endif; ?>

<?php if ($price_html = $product->get_price_html()) : ?>
	<div class="price_hold"><?php echo wp_kses_post($price_html); ?></div>
<?php endif; ?>