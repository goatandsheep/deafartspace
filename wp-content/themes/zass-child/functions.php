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