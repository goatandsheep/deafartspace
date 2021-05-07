<?php

if (!defined('ZASS_IMAGES_PATH')) {
	define('ZASS_IMAGES_PATH', get_template_directory_uri() . '/image/');
}

if (!defined('ZASS_BACKGROUNDS_PATH')) {
	define('ZASS_BACKGROUNDS_PATH', ZASS_IMAGES_PATH . 'backgrounds/');
}

if (class_exists('bbPress')) {
	define('ZASS_IS_BBPRESS', TRUE);
} else {
	define('ZASS_IS_BBPRESS', FALSE);
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists('WooCommerce') ) {
	define('ZASS_IS_WOOCOMMERCE', TRUE);
	require_once(get_template_directory() . '/incl/woocommerce-functions.php');
} else {
	define('ZASS_IS_WOOCOMMERCE', FALSE);
}

if (class_exists('Tribe__Events__Main')) {
	define('ZASS_IS_EVENTS', TRUE);
} else {
	define('ZASS_IS_EVENTS', FALSE);
}

if (class_exists('YITH_WCWL')) {
	define('ZASS_IS_WISHLIST', TRUE);
} else {
	define('ZASS_IS_WISHLIST', FALSE);
}

if ( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists('RevSliderBase') ) {
	define('ZASS_IS_REVOLUTION', TRUE);
} else {
	define('ZASS_IS_REVOLUTION', FALSE);
}

if (class_exists('Envato_Market')) {
	define('ZASS_IS_ENVATO_MARKET', TRUE);
} else {
	define('ZASS_IS_ENVATO_MARKET', FALSE);
}

// Is blank page template
global $zass_is_blank;
$zass_is_blank = false;

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if (!function_exists('zass_set_vc_as_theme')) {
	add_action('vc_before_init', 'zass_set_vc_as_theme');

	function zass_set_vc_as_theme() {
		vc_set_as_theme(true);
	}

}

add_action('init', 'zass_vc_set_cpt');
if (!function_exists('zass_vc_set_cpt')) {

	/**
	 * Define the post types that will use VC
	 */
	function zass_vc_set_cpt() {
		if (class_exists('WPBakeryVisualComposerAbstract')) {
			$list = array(
					'post',
					'page',
					'product',
					'product_variation',
					'zass-portfolio'
			);
			vc_set_default_editor_post_types($list);
		}
	}

}

/**
 * Include Zass_Font_Awesome
 */
require_once(get_template_directory() . '/incl/Zass_Font_Awesome.php');

/**
 * Include TGM-Plugin-Activation
 */
require_once(get_template_directory() . '/incl/tgm-plugin-activation/class-tgm-plugin-activation.php');

/**
 * Include Zass_Transfer_Content
 */
require_once(get_template_directory() . '/incl/ZassTransferContent.class.php');

/**
 * Include ZassWalker
 */
require_once(get_template_directory() . '/incl/ZassMegaMenu.php');

/*
 * Register theme text domain
 */
add_action('after_setup_theme', 'zass_lang_setup');
if (!function_exists('zass_lang_setup')) {

	function zass_lang_setup() {
		load_theme_textdomain('zass', get_template_directory() . '/languages');
	}

}

/**
 * Include the dynamic css
 */
require_once(get_template_directory() . '/styles/dynamic-css.php');

/**
 * Include the dynamic css for Gutenberg in the admin area
 */
require_once(get_template_directory() . '/styles/zass-gutenberg-dynamic-css.php');
