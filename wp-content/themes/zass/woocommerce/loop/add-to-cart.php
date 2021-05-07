<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
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
	exit;
}

global $product;
echo '<div class="links">';
echo apply_filters('woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf('<a href="%s" data-quantity="%s" class="%s" title="%s" %s>%s</a>',
								esc_url($product->add_to_cart_url()),
								esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
								esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
								esc_attr($product->add_to_cart_text()),
								isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
								esc_html($product->add_to_cart_text())
							), $product, $args);

// Do not show quickview link for composite products as it is too complex for the user
if (zass_get_option('use_quickview') && $product->get_type() != 'composite') {
	echo '<a href="#" class="zass-quick-view-link" data-id="' . esc_attr($product->get_id()) . '" title="' . esc_attr__('Quick View', 'zass') . '"><i class="fa fa-eye"></i></a>';
}
// show compare link
if (defined('YITH_WOOCOMPARE')) {
	zass_add_compare_link();
}

// Append Add to wishlist shortcode if it exists
if (shortcode_exists('yith_wcwl_add_to_wishlist')) {
	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}
echo '</div>';
