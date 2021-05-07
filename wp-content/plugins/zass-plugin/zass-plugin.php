<?php

/*
  Plugin Name: Zass Plugin
  Plugin URI: http://www.althemist.com/
  Description: Plugin containing the Zass theme functionality
  Version: 2.3.8
  Author: theAlThemist
  Author URI: http://www.althemist.com/
  Author Email: visibleone@gmail.com
  WC requires at least: 3.6
  WC tested up to: 5
  License: Themeforest Split Licence
  License URI: -
 */
defined( 'ABSPATH' ) || exit;

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists('WooCommerce') ) {
	define('ZASS_PLUGIN_IS_WOOCOMMERCE', TRUE);
} else {
	define('ZASS_PLUGIN_IS_WOOCOMMERCE', FALSE);
}

if (class_exists('bbPress')) {
	define('ZASS_PLUGIN_IS_BBPRESS', TRUE);
} else {
	define('ZASS_PLUGIN_IS_BBPRESS', FALSE);
}

if (class_exists('RevSliderBase')) {
	define('ZASS_PLUGIN_IS_REVOLUTION', TRUE);
} else {
	define('ZASS_PLUGIN_IS_REVOLUTION', FALSE);
}

// Check if WC Marketplace is active
if ( in_array( 'dc-woocommerce-multi-vendor/dc_product_vendor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists('WCMp') ) {
	define('ZASS_PLUGIN_IS_WC_MARKETPLACE', TRUE);
} else {
	define('ZASS_PLUGIN_IS_WC_MARKETPLACE', FALSE);
}
add_action('plugins_loaded', 'zass_plugin_after_plugins_loaded' );

function zass_plugin_after_plugins_loaded() {
	load_plugin_textdomain('zass-plugin', FALSE, dirname(plugin_basename(__FILE__)) . '/languages/');

	/* widgets */
	foreach (array('ZassAboutWidget', 'ZassContactsWidget', 'ZassPaymentOptionsWidget', 'ZassPopularPostsWidget', 'ZassLatestProjectsWidget') as $file) {
		require_once( plugin_dir_path(__FILE__) . 'widgets/' . $file . '.php' );
	}

	if(ZASS_PLUGIN_IS_WOOCOMMERCE) {
	    require_once(plugin_dir_path( __FILE__ ) . '/incl/woocommerce-metaboxes.php');

		// subcategories after 3.3.1 - will need refactoring in future
		remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
	}

	/* shortcodes */
	require_once( plugin_dir_path(__FILE__) . 'shortcodes/shortcodes.php' );

	/* include metaboxes.php */
	require_once( plugin_dir_path(__FILE__) . '/incl/metaboxes.php');

	/* include customizer class */
	require_once( plugin_dir_path(__FILE__) . '/incl/customizer/class-zass-customizer.php');
}

// Fix bbpress  Notice: bp_setup_current_user was called incorrectly
if (class_exists( 'bbPress' )) {
	remove_action('set_current_user', 'bbp_setup_current_user', 10);
	add_action('set_current_user', 'zass_bbp_setup_current_user', 10);
}

if (!function_exists('zass_bbp_setup_current_user')) {

	function zass_bbp_setup_current_user() {
		do_action('bbp_setup_current_user');
	}

}

if (!function_exists('get_plugin_data')) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if (!defined('ZASS_PLUGIN_IMAGES_PATH')) {
	define('ZASS_PLUGIN_IMAGES_PATH', plugins_url('/assets/image/', plugin_basename(__FILE__)));
}

/**
 * Generate excerpt by post Id
 *
 * @param type $post_id
 * @param type $excerpt_length
 * @param type $dots_to_link
 * @return string
 */
if (!function_exists('zass_get_excerpt_by_id')) {

	function zass_get_excerpt_by_id($post_id, $excerpt_length = 35, $dots_to_link = false) {

		$the_post = get_post($post_id); //Gets post
		$the_excerpt = strip_tags($the_post->post_excerpt);
		$the_excerpt = '<p>' . $the_excerpt . '</p>';

		return $the_excerpt;
	}

}

/**
 * Define Portfolio custom post type
 * 'zass-portfolio'
 */
if (!function_exists('zass_register_cpt_zass_portfolio')) {
	add_action('init', 'zass_register_cpt_zass_portfolio', 5);

	function zass_register_cpt_zass_portfolio() {

		$labels = array(
				'name' => esc_html__('Portfolios', 'zass-plugin'),
				'singular_name' => esc_html__('Portfolio', 'zass-plugin'),
				'add_new' => esc_html__('Add New', 'zass-plugin'),
				'add_new_item' => esc_html__('Add New Portfolio', 'zass-plugin'),
				'edit_item' => esc_html__('Edit Portfolio', 'zass-plugin'),
				'new_item' => esc_html__('New Portfolio', 'zass-plugin'),
				'view_item' => esc_html__('View Portfolio', 'zass-plugin'),
				'search_items' => esc_html__('Search Portfolios', 'zass-plugin'),
				'not_found' => esc_html__('No portfolios found', 'zass-plugin'),
				'not_found_in_trash' => esc_html__('No portfolios found in Trash', 'zass-plugin'),
				'parent_item_colon' => esc_html__('Parent Portfolio:', 'zass-plugin'),
				'menu_name' => esc_html__('Portfolios', 'zass-plugin'),
		);

		$args = array(
				'labels' => $labels,
				'hierarchical' => false,
				'description' => 'Zass portfolio post type',
				'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes'),
				'taxonomies' => array('zass_portfolio_category'),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'has_archive' => true,
				'query_var' => true,
				'can_export' => true,
				'rewrite' => true,
				'capability_type' => 'page',
				'menu_icon' => 'dashicons-portfolio',
				'rewrite' => array(
						'slug' => esc_html__('portfolios', 'zass-plugin')
				)
		);

		register_post_type('zass-portfolio', $args);
	}

}

/**
 * Define zass_portfolio_category taxonomy
 * used by zass-portfolio post type
 */
if (!function_exists('zass_register_taxonomy_zass_portfolio_category')) {
	add_action('init', 'zass_register_taxonomy_zass_portfolio_category', 5);

	function zass_register_taxonomy_zass_portfolio_category() {

		$labels = array(
				'name' => esc_html__('Portfolio Category', 'zass-plugin'),
				'singular_name' => esc_html__('Portfolio categories', 'zass-plugin'),
				'search_items' => esc_html__('Search Portfolio Category', 'zass-plugin'),
				'popular_items' => esc_html__('Popular Portfolio Category', 'zass-plugin'),
				'all_items' => esc_html__('All Portfolio Category', 'zass-plugin'),
				'parent_item' => esc_html__('Parent Portfolio categories', 'zass-plugin'),
				'parent_item_colon' => esc_html__('Parent Portfolio categories:', 'zass-plugin'),
				'edit_item' => esc_html__('Edit Portfolio categories', 'zass-plugin'),
				'update_item' => esc_html__('Update Portfolio categories', 'zass-plugin'),
				'add_new_item' => esc_html__('Add New Portfolio categories', 'zass-plugin'),
				'new_item_name' => esc_html__('New Portfolio categories', 'zass-plugin'),
				'separate_items_with_commas' => esc_html__('Separate portfolio category with commas', 'zass-plugin'),
				'add_or_remove_items' => esc_html__('Add or remove portfolio category', 'zass-plugin'),
				'choose_from_most_used' => esc_html__('Choose from the most used portfolio category', 'zass-plugin'),
				'menu_name' => esc_html__('Portfolio Category', 'zass-plugin'),
		);

		$args = array(
				'labels' => $labels,
				'public' => true,
				'show_in_nav_menus' => true,
				'show_ui' => true,
				'show_tagcloud' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => true,
				'query_var' => true,
				'rewrite' => array(
						'slug' => 'portfolios-category'
				)
		);

		register_taxonomy('zass_portfolio_category', array('zass-portfolio'), $args);
	}

}

add_action('init', 'zass_theme_options_link');
if(!function_exists('zass_theme_options_link')) {
	function zass_theme_options_link() {
		if ( wp_get_theme()->get_template() === 'zass' && current_user_can( 'edit_theme_options' ) ) {
			add_action( 'wp_before_admin_bar_render', 'zass_optionsframework_adminbar' );
		}
	}
}

/**
 * Add Theme Options menu item to Admin Bar.
 */
if(!function_exists('zass_optionsframework_adminbar')) {
	function zass_optionsframework_adminbar() {

		global $wp_admin_bar;

		$wp_admin_bar->add_menu( array(
			'parent' => false,
			'id'     => 'zass_of_theme_options',
			'title'  => esc_html__( 'Theme Options', 'zass-plugin' ),
			'href'   => esc_url( admin_url( 'themes.php?page=zass-optionsframework' ) ),
			'meta'   => array( 'class' => 'althemist-admin-opitons' )
		) );
	}
}

// Register scripts
add_action('wp_enqueue_scripts', 'zass_register_plugin_scripts');
if (!function_exists('zass_register_plugin_scripts')) {

	function zass_register_plugin_scripts() {

		/* include minifined css for js plugins: flexslider, owl-carousel, cloud-zoom-min, jquery-tipsy, jquery-plugin, jquery-countdown, imagesloaded, magnific-popup */
		wp_enqueue_style('zass-plugins', get_template_directory_uri() . "/styles/zass-js-plugins-css/zass-plugins.min.css");
		/* include minifined js plugins: flexslider, owl-carousel, cloud-zoom-min, jquery-tipsy, jquery-plugin, jquery-countdown, imagesloaded, magnific-popup */
		wp_enqueue_script('zass-plugins', get_template_directory_uri() . "/js/zass-plugins.min.js", array('jquery'), false, true);
		// Isotope
		wp_register_script('isotope', get_template_directory_uri() . "/js/isotope/dist/isotope.pkgd.min.js", array('jquery'), false, true);
		// Infinitescroll
		wp_register_script('infinitescroll', get_template_directory_uri() . "/js/infinite/jquery.infinitescroll.min.js", array('jquery'), false, true);
		// google maps
		if(function_exists('zass_get_option')) {
			wp_register_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?' . ( zass_get_option( 'google_maps_api_key' ) ? 'key=' . zass_get_option( 'google_maps_api_key' ) . '&' : '' ) . 'sensor=false', array( 'jquery' ), false, true );
		}
	}

}

// Enqueue the script for proper positioning the custom added font in vc edit form
add_filter('vc_edit_form_enqueue_script', 'zass_enqueue_edit_form_scripts');
if (!function_exists('zass_enqueue_edit_form_scripts')) {

	function zass_enqueue_edit_form_scripts($scripts) {
		$scripts[] = plugin_dir_url(__FILE__) . 'assets/js/zass-vc-edit-form.js';
		return $scripts;
	}

}

add_filter('vc_iconpicker-type-etline', 'zass_vc_iconpicker_type_etline');

/**
 * Elegant Icons Font icons
 *
 * @param $icons - taken from filter - vc_map param field settings['source'] provided icons (default empty array).
 * If array categorized it will auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
if (!function_exists('zass_vc_iconpicker_type_etline')) {

	function zass_vc_iconpicker_type_etline($icons) {
		// Categorized icons ( you can also output simple array ( key=> value ), where key = icon class, value = icon readable name ).
		$etline_icons = array(
				array('icon-mobile' => 'Mobile'),
				array('icon-laptop' => 'Laptop'),
				array('icon-desktop' => 'Desktop'),
				array('icon-tablet' => 'Tablet'),
				array('icon-phone' => 'Phone'),
				array('icon-document' => 'Document'),
				array('icon-documents' => 'Documents'),
				array('icon-search' => 'Search'),
				array('icon-clipboard' => 'Clipboard'),
				array('icon-newspaper' => 'Newspaper'),
				array('icon-notebook' => 'Notebook'),
				array('icon-book-open' => 'Open'),
				array('icon-browser' => 'Browser'),
				array('icon-calendar' => 'Calendar'),
				array('icon-presentation' => 'Presentation'),
				array('icon-picture' => 'Picture'),
				array('icon-pictures' => 'Pictures'),
				array('icon-video' => 'Video'),
				array('icon-camera' => 'Camera'),
				array('icon-printer' => 'Printer'),
				array('icon-toolbox' => 'Toolbox'),
				array('icon-briefcase' => 'Briefcase'),
				array('icon-wallet' => 'Wallet'),
				array('icon-gift' => 'Gift'),
				array('icon-bargraph' => 'Bargraph'),
				array('icon-grid' => 'Grid'),
				array('icon-expand' => 'Expand'),
				array('icon-focus' => 'Focus'),
				array('icon-edit' => 'Edit'),
				array('icon-adjustments' => 'Adjustments'),
				array('icon-ribbon' => 'Ribbon'),
				array('icon-hourglass' => 'Hourglass'),
				array('icon-lock' => 'Lock'),
				array('icon-megaphone' => 'Megaphone'),
				array('icon-shield' => 'Shield'),
				array('icon-trophy' => 'Trophy'),
				array('icon-flag' => 'Flag'),
				array('icon-map' => 'Map'),
				array('icon-puzzle' => 'Puzzle'),
				array('icon-basket' => 'Basket'),
				array('icon-envelope' => 'Envelope'),
				array('icon-streetsign' => 'Streetsign'),
				array('icon-telescope' => 'Telescope'),
				array('icon-gears' => 'Gears'),
				array('icon-key' => 'Key'),
				array('icon-paperclip' => 'Paperclip'),
				array('icon-attachment' => 'Attachment'),
				array('icon-pricetags' => 'Pricetags'),
				array('icon-lightbulb' => 'Lightbulb'),
				array('icon-layers' => 'Layers'),
				array('icon-pencil' => 'Pencil'),
				array('icon-tools' => 'Tools'),
				array('icon-tools-2' => '2'),
				array('icon-scissors' => 'Scissors'),
				array('icon-paintbrush' => 'Paintbrush'),
				array('icon-magnifying-glass' => 'Glass'),
				array('icon-circle-compass' => 'Compass'),
				array('icon-linegraph' => 'Linegraph'),
				array('icon-mic' => 'Mic'),
				array('icon-strategy' => 'Strategy'),
				array('icon-beaker' => 'Beaker'),
				array('icon-caution' => 'Caution'),
				array('icon-recycle' => 'Recycle'),
				array('icon-anchor' => 'Anchor'),
				array('icon-profile-male' => 'Male'),
				array('icon-profile-female' => 'Female'),
				array('icon-bike' => 'Bike'),
				array('icon-wine' => 'Wine'),
				array('icon-hotairballoon' => 'Hotairballoon'),
				array('icon-globe' => 'Globe'),
				array('icon-genius' => 'Genius'),
				array('icon-map-pin' => 'Pin'),
				array('icon-dial' => 'Dial'),
				array('icon-chat' => 'Chat'),
				array('icon-heart' => 'Heart'),
				array('icon-cloud' => 'Cloud'),
				array('icon-upload' => 'Upload'),
				array('icon-download' => 'Download'),
				array('icon-target' => 'Target'),
				array('icon-hazardous' => 'Hazardous'),
				array('icon-piechart' => 'Piechart'),
				array('icon-speedometer' => 'Speedometer'),
				array('icon-global' => 'Global'),
				array('icon-compass' => 'Compass'),
				array('icon-lifesaver' => 'Lifesaver'),
				array('icon-clock' => 'Clock'),
				array('icon-aperture' => 'Aperture'),
				array('icon-quote' => 'Quote'),
				array('icon-scope' => 'Scope'),
				array('icon-alarmclock' => 'Alarmclock'),
				array('icon-refresh' => 'Refresh'),
				array('icon-happy' => 'Happy'),
				array('icon-sad' => 'Sad'),
				array('icon-facebook' => 'Facebook'),
				array('icon-twitter' => 'Twitter'),
				array('icon-googleplus' => 'Googleplus'),
				array('icon-rss' => 'Rss'),
				array('icon-tumblr' => 'Tumblr'),
				array('icon-linkedin' => 'Linkedin'),
				array('icon-dribbble' => 'Dribbble'),
		);

		return array_merge($icons, $etline_icons);
	}

}

if (!function_exists('zass_portfolio_category_field_search')) {

	function zass_portfolio_category_field_search($search_string) {
		$data = array();

		$vc_taxonomies_types = array('zass_portfolio_category');
		$vc_taxonomies = get_terms($vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string,
		));
		if (is_array($vc_taxonomies) && !empty($vc_taxonomies)) {
			foreach ($vc_taxonomies as $t) {
				if (is_object($t)) {
					$data[] = vc_get_term_object($t);
				}
			}
		}

		return $data;
	}

}

if (!function_exists('zass_latest_posts_category_field_search')) {

	function zass_latest_posts_category_field_search($search_string) {
		$data = array();

		$vc_taxonomies_types = array('category');
		$vc_taxonomies = get_terms($vc_taxonomies_types, array(
				'hide_empty' => false,
				'search' => $search_string,
		));
		if (is_array($vc_taxonomies) && !empty($vc_taxonomies)) {
			foreach ($vc_taxonomies as $t) {
				if (is_object($t)) {
					$data[] = vc_get_term_object($t);
				}
			}
		}

		return $data;
	}

}
add_action('admin_init', 'zass_load_incl_importer', 99);
if (!function_exists('zass_load_incl_importer')) {

	function zass_load_incl_importer() {
		/* load required files */

		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if (!class_exists('WP_Importer')) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if (file_exists($class_wp_importer)) {
				require_once $class_wp_importer;
			}
		}

        $class_zass_importer = plugin_dir_path(__FILE__) . "importer/zass-wordpress-importer.php";
        if (file_exists($class_zass_importer)) {
            require_once $class_zass_importer;
        }
	}

}

// Contact form ajax actions
if (!function_exists('zass_submit_contact')) {

	function zass_submit_contact() {

		check_ajax_referer('zass_contactform', false, true);

		$unique_id = array_key_exists('unique_id', $_POST) ? sanitize_text_field($_POST['unique_id']) : '';
		$nonce = array_key_exists('_ajax_nonce', $_POST) ? sanitize_text_field($_POST['_ajax_nonce']) : '';

		ob_start();
		?>
		<script type="text/javascript">
            //<![CDATA[
            "use strict";
            jQuery(document).ready(function () {
                var submitButton = jQuery('#holder_<?php echo esc_js($unique_id) ?> input:submit');
                var loader = jQuery('<img id="<?php echo esc_js($unique_id) ?>_loading_gif" class="zass-contacts-loading" src="<?php echo esc_url(plugin_dir_url(__FILE__)) ?>assets/image/contacts_ajax_loading.png" />').prependTo('#holder_<?php echo esc_attr($unique_id) ?> div.buttons div.left').hide();

                jQuery('#holder_<?php echo esc_js($unique_id) ?> form').ajaxForm({
                    target: '#holder_<?php echo esc_js($unique_id) ?>',
                    data: {
                        // additional data to be included along with the form fields
                        unique_id: '<?php echo esc_js($unique_id) ?>',
                        action: 'zass_submit_contact',
                        _ajax_nonce: '<?php echo esc_js($nonce); ?>'
                    },
                    beforeSubmit: function (formData, jqForm, options) {
                        // optionally process data before submitting the form via AJAX
                        submitButton.hide();
                        loader.show();
                    },
                    success: function (responseText, statusText, xhr, $form) {
                        // code that's executed when the request is processed successfully
                        loader.remove();
                        submitButton.show();
                    }
                });
            });
            //]]>
		</script>
		<?php
		require(plugin_dir_path( __FILE__ ) . 'shortcodes/partials/contact-form.php');

		$output = ob_get_contents();
		ob_end_clean();

		echo $output; // All dynamic data escaped
		wp_die();
	}

}

add_action('wp_ajax_zass_submit_contact', 'zass_submit_contact');
add_action('wp_ajax_nopriv_zass_submit_contact', 'zass_submit_contact');

//function to generate response
if (!function_exists('zass_contact_form_generate_response')) {

	function zass_contact_form_generate_response($type, $message) {

		$zass_contactform_response = '';

		if ($type == "success") {
			$zass_contactform_response = "<div class='success-message'>{$message}</div>";
		} else {
			$zass_contactform_response .= "<div class='error-message'>{$message}</div>";
		}

		return $zass_contactform_response;
	}

}

if (!function_exists('zass_share_links')) {

	/**
	 * Displays social networks share links
	 *
	 * @param $title
	 * @param $link
	 */
	function zass_share_links($title, $link) {

		$has_to_show_share = zass_has_to_show_share();

		if ( $has_to_show_share ) {
			global $post;

			$media = get_the_post_thumbnail_url( $post->ID, 'large' );
			$share_links_html = '<span>' . esc_html__( 'Share', 'zass-plugin' ) . ':</span>';

			$share_links_html .= sprintf(
				'<a class="zass-share-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank" ></a>',
				esc_attr__( 'Share on Facebook', 'zass-plugin' ),
				urlencode( $link ),
				urlencode( html_entity_decode($title) )
			);
			$share_links_html .= sprintf(
				'<a class="zass-share-twitter"  title="%s" href="http://twitter.com/share?text=%s&url=%s" target="_blank"></a>',
				esc_attr__( 'Share on Twitter', 'zass-plugin' ),
				urlencode( html_entity_decode($title) ),
				urlencode( $link )
			);
			$share_links_html .= sprintf(
				'<a class="zass-share-pinterest" title="%s"  href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" target="_blank"></a>',
				esc_attr__( 'Share on Pinterest', 'zass-plugin' ),
				urlencode( $media ),
				urlencode( $link ),
				urlencode( html_entity_decode($title) )
			);
			$share_links_html .= sprintf(
				'<a class="zass-share-linkedin" title="%s" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" target="_blank"></a>',
				esc_attr__( 'Share on LinkedIn', 'zass-plugin' ),
				urlencode( $link ),
				urlencode( html_entity_decode($title) )
			);
			$share_links_html .= sprintf(
				'<a class="zass-share-vkontakte" title="%s"  href="http://vk.com/share.php?url=%s&title=%s&image=%s" target="_blank"></a>',
				esc_attr__( 'Share on VK', 'zass-plugin' ),
				urlencode( $link ),
				urlencode( html_entity_decode($title) ),
				urlencode( $media )
			);

			printf( '<div class="zass-share-links">%s<div class="clear"></div></div>', $share_links_html );
		}

	}
}

if (!function_exists('zass_has_to_show_share')) {
	function zass_has_to_show_share() {

		if(function_exists('zass_get_option')) {
			$general_option = get_option( 'zass_share_on_posts' ) === 'yes';
			$general_option_product = get_option( 'zass_share_on_products' ) === 'yes';
			if ( ! get_option( 'zass_share_on_products' ) && function_exists( 'zass_get_option' ) ) {
				$general_option_product = zass_get_option( 'show_share_shop' );
			}
			$single_meta            = get_post_meta( get_the_ID(), 'zass_show_share', true );

			$target = 'single';
			if (function_exists('is_product') && is_product()) {
				$target = 'product';
			}

			$has_to_show_share = false;

			if ( $target === 'single' && $single_meta === 'yes' ) {
				$has_to_show_share = true;
			} elseif ( $target === 'single' && $general_option && $single_meta !== 'no' ) {
				$has_to_show_share = true;
			} elseif ( $target === 'product' && $general_option_product ) {
				$has_to_show_share = true;
			}

			return $has_to_show_share;
		}

		return false;
	}
}

// Allow HTML descriptions in WordPress Menu (related to Mega menu)
remove_filter('nav_menu_description', 'strip_tags');

if ( ! function_exists( 'zass_default_share_on_products' ) ) {
	function zass_default_share_on_products() {
		if ( function_exists( 'zass_get_option' ) && zass_get_option( 'show_share_shop' ) ) {
			return zass_get_option( 'show_share_shop' ) ? 'yes' : 'no';
		}

		return 'no';
	}
}

add_action( 'after_setup_theme', 'zass_after_setup_theme' );
if ( ! function_exists( 'zass_after_setup_theme' ) ) {
	/**
	 * Doing stuff which require theme to be loaded so we have 'zass_get_option' function available etc.
	 */
	function zass_after_setup_theme() {
		// Move product taxonomy description below products if 'category_description_position' = 'bottom'
		if ( function_exists( 'zass_get_option' ) && zass_get_option( 'category_description_position' ) === 'zass-bottom-description' ) {
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			add_action( 'woocommerce_after_main_content', 'woocommerce_taxonomy_archive_description', 1 );
		}
	}
}