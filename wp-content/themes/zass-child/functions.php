<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-style' )
	);

	if ( is_rtl() ) {
		wp_enqueue_style( 'parent-rtl', get_template_directory_uri() . '/rtl.css' );
		wp_enqueue_style( 'child-rtl',
			get_stylesheet_directory_uri() . '/rtl.css',
			array( 'parent-rtl' )
		);
	}
}

add_filter( 'wpml_sl_blacklist_requests', 'deaf_wpml_sl_blacklist_requests', 10, 2 );
function deaf_wpml_sl_blacklist_requests( $blacklist, $sitepress ) {
        $blacklist[] = 'dashboard/storefront';
        $blacklist[] = 'dashboard/vendor-policies';
        $blacklist[] = 'dashboard/vendor-bill';
        $blacklist[] = 'dashboard/products';
        $blacklist[] = 'dashboard/add-product'; 
        $blacklist[] = 'dashboard/coupons';
        $blacklist[] = 'dashboard/add-coupon';   
        $blacklist[] = 'dashboard/vendor-report';
        $blacklist[] = 'dashboard/banking-ov'; 
        $blacklist[] = 'dashboard/vendor-orders';
        $blacklist[] = 'dashboard/vendor-withdrawal'; 
        $blacklist[] = 'dashboard/transaction-details';
        $blacklist[] = 'dashboard/vendor-knowledgebase'; 
        $blacklist[] = 'dashboard/vendor-tools';           
    return $blacklist;
}

add_action( 'woocommerce_register_form', 'deaf_add_registration_privacy_policy', 11 );
   
function deaf_add_registration_privacy_policy() {
 
woocommerce_form_field( 'privacy_policy_reg', array(
   'type'          => 'checkbox',
   'class'         => array('form-row privacy'),
   'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
   'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
   'required'      => true,
   'label'         => 'I\'ve read and accept the <a href="/privacy-policy">Privacy Policy</a>',
));
  
}
  
// Show error if user does not tick
   
add_filter( 'woocommerce_registration_errors', 'deaf_validate_privacy_registration', 10, 3 );
  
function deaf_validate_privacy_registration( $errors, $username, $email ) {
if ( ! is_checkout() ) {
    if ( ! (int) isset( $_POST['privacy_policy_reg'] ) ) {
        $errors->add( 'privacy_policy_reg_error', __( 'Privacy Policy consent is required!', 'woocommerce' ) );
    }
}
return $errors;
}

function role_exists( $role ) {

  if( ! empty( $role ) ) {
    return $GLOBALS['wp_roles']->is_role( $role );
  }
  
  return false;
}

add_action('after_setup_theme', 'deaf_remove_unused_roles');
function deaf_remove_unused_roles () {
	if( role_exists( 'dc_vendor' ) ) {
		remove_role( 'dc_rejected_vendor' );
		remove_role( 'dc_pending_vendor' );
		remove_role( 'dc_vendor' );
	}
}

add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );

// add_action( 'admin_menu', 'deaf_add_shop_orders_menu_item', 99 );
// function deaf_add_shop_orders_menu_item(){
// 	$vendor = yith_get_vendor( 'current', 'user' );
// 	if( $vendor->is_valid() && $vendor->has_limited_access() )	{
// 		global $menu;
// 		$find = false;
// 		$menu_slug = 'edit.php?post_type=zass-portfolio';
// 		foreach ( $menu as $k => $item  ){
// 			if( $menu_slug == $item[2] ){
// 				$find = true;
// 				break;
// 			}
// 		}

// 		if( ! $find ){
// 			$page_title = $menu_title = esc_html__( 'Portfolios', 'yith_woocommerce_product_vendors' );
// 			$capability = 'edit_shop_orders';
// 			add_menu_page( $page_title, $menu_title, $capability, $menu_slug, '', 'dashicons-cart', 56 );
// 		}
// 	}
// }

// add_filter( 'yith_wcmv_register_taxonomy_object_type', 'deaf_yith_wcmv_register_taxonomy_object_type', 99, 1);
// function deaf_yith_wcmv_register_taxonomy_object_type( $object_types ) {
// 	$object_types[] = 'zass-portfolio';
// 	return $object_types;
// }


// add_filter('yith_wpv_vendor_menu_items', 'deaf_yith_wpv_vendor_menu_items', 99, 1);
// function deaf_yith_wpv_vendor_menu_items( $menu_items ){
// 	$menu_items[] = 'edit.php?post_type=zass-portfolio';
//     file_put_contents(ABSPATH . 'deaf_yith_wpv_vendor_menu_items.log', json_encode($menu_items) . PHP_EOL, FILE_APPEND);
// 	return $menu_items;
// }

// add_filter('yith_wpv_vendors_allowed_post_types', 'deaf_yith_wpv_vendors_allowed_post_types', 99, 1);
// function deaf_yith_wpv_vendors_allowed_post_types($allowed_post_types) {
// 	$allowed_post_types[] = 'zass-portfolio';
// 	file_put_contents(ABSPATH . 'deaf_yith_wpv_vendors_allowed_post_types.log', json_encode($allowed_post_types) . PHP_EOL, FILE_APPEND);
// 	return $allowed_post_types;
// }



// function deaf_translate_text( $translated ) {
// 	if (ICL_LANGUAGE_CODE == 'fr') {
// 		$translated = str_ireplace( "Produit", "L'art", $translated );
// 		$translated = str_ireplace( "produit", "l'art", $translated );
// 	} else {
// 		$translated = str_ireplace( 'Product', 'Art', $translated );
// 		$translated = str_ireplace( 'product', 'art', $translated );	
// 	}
	
// 	return $translated;
// }
// add_filter( 'gettext', 'deaf_translate_text' );
// add_filter( 'ngettext', 'deaf_translate_text' );