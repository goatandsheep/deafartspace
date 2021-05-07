<?php
/**
 * Insert the customized css from selected options on wp_head hook + the custom css
 */
add_action('wp_enqueue_scripts', 'zass_add_custom_css', 99);

if (!function_exists('zass_add_custom_css')) {

	function zass_add_custom_css() {
		ob_start();
		?>
		<style media="all" type="text/css">
			/* Site main accent color */
			div.widget_categories ul li.current-cat > a:before, p.woocommerce-thankyou-order-received, .wpb_zass_banner a span.zass_banner-icon, .toggler:before, .zass-product-slider.owl-carousel .owl-nav .owl-prev:hover, .zass-product-slider.owl-carousel .owl-nav .owl-next:hover, .widget_shopping_cart_content p.buttons .button.checkout, .zass-portfolio-categories ul li a:hover, .zass-portfolio-categories ul li a.is-checked, .zass-event-countdown .is-countdown, .video_controlls a#video-volume:after, div.widget_categories ul li > a:hover:before, #main-menu ul.menu > li > a:hover, #main-menu ul.menu > li.current-menu-item > a, li.product-category.product a h3, .otw-input-wrap:before, .summary.entry-summary .yith-wcwl-add-to-wishlist a:before, .summary.entry-summary .yith-wcwl-add-to-wishlist a:after, .summary.entry-summary .compare::before, .prod_hold .price_hold:before, a.bbp-forum-title:hover, .portfolio_top .project-data .main-features .checklist li:before, body.zass_transparent_header #main-menu ul.menu > li.current_page_item > a:before, body.zass_transparent_header #main-menu ul.menu > li.current-menu-item > a:before, body.zass_transparent_header #main-menu ul.menu > li > a:hover:before {
				color:<?php echo esc_attr(zass_get_option('accent_color')) ?>;
			}
			a.sidebar-trigger, #cart-module .cart-contents span.count, .wcmp_sorted_vendors:before, td.tribe-events-present > div:first-of-type, a.mob-close-toggle:hover, #main-menu ul.menu > li > a:before, .pagination .links a:hover, .dokan-pagination-container .dokan-pagination li a:hover, a.mob-menu-toggle i, .bbp-pagination-links a:hover, .zass-search-cart-holder #search.active > span:hover, a.close-off-canvas:hover, .zass_content_slider .owl-dot.active span, #main-menu ul.menu > li > .zass-custom-menu-label, li.product-category.product h3 mark:after, div.product-category.product h3 mark:after, #main-menu li ul.sub-menu li.zass_colum_title > a:after, #main-menu li ul.sub-menu li.zass_colum_title > a:before, .blog-post-meta span.sticky_post, #zass_price_range, .zass_image_list a.zass-magnific-gallery-item:before, #bbpress-forums > #subscription-toggle a.subscription-toggle, .widget > h3:first-child:before, .widget > h3:first-child:after, .zass-portfolio-categories ul li a:hover:before, .zass-portfolio-categories ul li a.is-checked:before, .zass-portfolio-categories ul li a:hover:after, .zass-portfolio-categories ul li a.is-checked:after, .flex-direction-nav a, ul.status-closed li.bbp-topic-title .bbp-topic-permalink:before, ul.sticky li.bbp-topic-title .bbp-topic-permalink:before, ul.super-sticky li.bbp-topic-title .bbp-topic-permalink:before {
				background-color:<?php echo esc_attr(zass_get_option('accent_color')) ?>;
			}
			.bbp-topics-front ul.super-sticky, .blog-post.sticky, #main-menu li ul.sub-menu li.zass-highlight-menu-item:after, .error404 div.blog-post-excerpt, .zass_blog_masonry:not(.zass-related-blog-posts) .sticky .zass_post_data_holder, .zass-none-overlay.zass-10px-gap .portfolio-unit-holder:hover, .portfolio-unit-info a.portfolio-lightbox-link:hover, .zass-product-slider.owl-carousel .owl-nav .owl-prev:hover, .zass-product-slider.owl-carousel .owl-nav .owl-next:hover, .widget_shopping_cart_content p.buttons .button.checkout, .zass_banner_text:before, .zass_banner_text:after, body table.booked-calendar td.today .date span, .vc_tta-color-white.vc_tta-style-modern .vc_tta-tab.vc_active > a, .bbp-topics ul.super-sticky, .bbp-topics ul.sticky, .bbp-forum-content ul.sticky, a.sidebar-trigger:hover:after, .zass-pulsator-accent .wpb_wrapper:after, ul.tabs li.active a {
				border-color:<?php echo esc_attr(zass_get_option('accent_color')) ?> !Important;
			}
			::-moz-selection {
				background:<?php echo esc_attr(zass_get_option('accent_color')) ?>;
			}
			::selection {
				background:<?php echo esc_attr(zass_get_option('accent_color')) ?>;
			}
			.box-sort-filter .ui-slider-horizontal .ui-slider-handle, .widget_price_filter .ui-slider-handle.ui-state-default.ui-corner-all {
				background:<?php echo esc_attr(zass_get_option('accent_color')) ?> !Important;
			}
			li.product-category.product h3 mark, div.product-category.product h3 mark, .widget_shopping_cart_content a.remove:hover, .col2-set.addresses header a.edit { background:#main-site-color; }
			blockquote, q { border-left-color:<?php echo esc_attr(zass_get_option('accent_color')) ?>; }
			.double-bounce2 { background-color:<?php echo esc_attr(zass_get_option('accent_color')) ?>; }
			/* Links color */
			a, div.widget_categories ul li a:hover, div.widget_nav_menu ul li a:hover, div.widget_archive ul li a:hover, div.widget_recent_comments ul li a:hover, div.widget_pages ul li a:hover, div.widget_links ul li a:hover, div.widget_recent_entries ul a:hover, div.widget_meta ul li a:hover, div.widget_display_forums ul li a:hover, .widget_display_replies ul li a:hover, .widget_display_topics li > a.bbp-forum-title:hover, .widget_display_stats dt:hover, .widget_display_stats dd:hover, div.widget_display_views ul li a:hover, .widget_layered_nav ul li a:hover, .widget_product_categories ul li a:hover {color:<?php echo esc_attr(zass_get_option('links_color')) ?>;}
			/* Links hover color */
			a:hover{color:<?php echo esc_attr(zass_get_option('links_hover_color')) ?>;}
			/* Widgets Title Color */
			.sidebar .box h3, .wpb_widgetised_column .box h3, h2.widgettitle, h2.wpb_flickr_heading{color:<?php echo esc_attr(zass_get_option('sidebar_titles_color')) ?>;}
			/* Buttons Default style */
			<?php if (zass_get_option('all_buttons_style') === 'round'): ?>
    		a.button, .wcv-navigation ul.menu.horizontal li a, .wcv-pro-dashboard input[type="submit"], .zass-pricing-table-button a, button.wcv-button, .widget_shopping_cart_content p.buttons .button, input.button, button.button, a.button-inline, #submit_btn, #submit, .wpcf7-submit, #bbpress-forums #bbp-search-form #bbp_search, form.mc4wp-form input[type=submit], form.mc4wp-form input[type=email] {
    		border-radius: 2em !important;
			}
			<?php endif; ?>
			/* WordPress Default Buttons Color */
			a.button, button.wcv-button, input.button, .wcv-navigation ul.menu.horizontal li a, nav.woocommerce-MyAccount-navigation ul li a, button.button, a.button-inline, #submit_btn, #submit, .wpcf7-submit, .col2-set.addresses header a.edit, input.otw-submit, form.mc4wp-form input[type=submit], .tribe-events-button, input[type="submit"] {border-color:<?php echo esc_attr(zass_get_option('all_buttons_color')) ?>; color:<?php echo esc_attr(zass_get_option('all_buttons_color')) ?>;}
			.wcmp_regi_main .button {border-color:<?php echo esc_attr(zass_get_option('all_buttons_color')) ?> !important; color:<?php echo esc_attr(zass_get_option('all_buttons_color')) ?> !important;}
			/* WordPress Default Buttons Hover Color */
			a.button:hover, button.wcv-button:hover, input.button:hover, .wcv-navigation ul.menu.horizontal li a:hover, .wcv-navigation ul.menu.horizontal li.active a, button.button:hover, nav.woocommerce-MyAccount-navigation ul li.is-active a, nav.woocommerce-MyAccount-navigation ul li a:hover, a.button-inline:hover, #submit_btn:hover, #submit:hover, .wpcf7-submit:hover, .r_more:hover, .r_more_right:hover, div.prod_hold a.button.add_to_cart_button:hover, button.single_add_to_cart_button:hover, .zass-product-slide-cart .button.add_to_cart_button:hover, input.otw-submit:hover, form.mc4wp-form input[type=submit]:hover, .wc-proceed-to-checkout a.checkout-button.button:hover {border-color:<?php echo esc_attr(zass_get_option('all_buttons_hover_color')) ?> !important; color:<?php echo esc_attr(zass_get_option('all_buttons_hover_color')) ?> !important;}
			.wcmp_regi_main .button:hover {border-color:<?php echo esc_attr(zass_get_option('all_buttons_hover_color')) ?> !important; color:<?php echo esc_attr(zass_get_option('all_buttons_hover_color')) ?> !important;}
			/* NEW label color */
			div.prod_hold .new_prod{background-color:<?php echo esc_attr(zass_get_option('new_label_color')) ?>;}
			/* SALE label color */
			div.prod_hold .sale, span.onsale, .count_holder_small .count_info:first-child {background-color:<?php echo esc_attr(zass_get_option('sale_label_color')) ?>;}
			/* Standard page title color (no background image) */
			#zass_page_title h1.heading-title, #zass_page_title h1.heading-title a, .breadcrumb,.breadcrumb a, .zass-dark-skin #zass_page_title h1.heading-title a {color:<?php echo esc_attr(zass_get_option('page_title_color')) ?>;}
			/* Standard page subtitle color (no background image) */
			.zass_title_holder h6 {color:<?php echo esc_attr(zass_get_option('page_subtitle_color')) ?>;}
			/* Customized page title color (with background image) */
			#zass_page_title.zass_title_holder.title_has_image h1.heading-title, #zass_page_title.zass_title_holder.title_has_image h6, #zass_page_title.zass_title_holder.title_has_image .breadcrumb, #zass_page_title.zass_title_holder.title_has_image .breadcrumb a {
				color:<?php echo esc_attr(zass_get_option('custom_page_title_color')) ?>;
			}
			/* Standard page title background color (no background image) */
			.zass_title_holder, .zass_title_holder .inner:before, body.zass_header_left .zass_title_holder:not(.title_has_image) .inner {background-color:<?php echo esc_attr(zass_get_option('page_title_bckgr_color')) ?>;}
			/* Standard page title border color (no background image) */
			.zass_title_holder, body.zass_header_left .zass_title_holder:not(.title_has_image) .inner { border-color:<?php echo esc_attr(zass_get_option('page_title_border_color')) ?>; }
			.zass_title_holder .inner:before { border-color: transparent <?php echo esc_attr(zass_get_option('page_title_border_color')) ?> <?php echo esc_attr(zass_get_option('page_title_border_color')) ?> transparent; }
			/* Post Date  background color */
			div.post .post-date, div.product.type-product .post-date, div.page.type-page .post-date, div.attachment .post-date {background-color:<?php echo esc_attr(zass_get_option('post_date_backgr_color')) ?>; }
			/* Portfolio overlay background color */
			.portfolio-unit-holder, .zass_image_list a.zass-magnific-gallery-item:before {background-color:<?php echo esc_attr(zass_get_option('portfolio_overlay_bckgr_color')) ?>;}
			/* Portfolio overlay text color */
			div:not(.zass-none-overlay).portfolio-unit.masonry-unit a.portfolio-link, div:not(.zass-none-overlay).portfolio-unit.masonry-unit a.portfolio-link small, div:not(.zass-none-overlay).portfolio-unit.masonry-unit a.portfolio-link h4, div:not(.zass-none-overlay).portfolio-unit.masonry-unit,
			div:not(.zass-none-overlay).portfolio-unit.masonry-unit a.portfolio-link p, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-2 a.portfolio-link, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-2 a.portfolio-link small, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-2 a.portfolio-link h4,
			div:not(.zass-none-overlay).portfolio-unit.portfolio-col-2, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-2 a.portfolio-link p, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-3 a.portfolio-link, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-3 a.portfolio-link small,
			div:not(.zass-none-overlay).portfolio-unit.portfolio-col-3 a.portfolio-link h4, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-3, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-3 a.portfolio-link p, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-4 a.portfolio-link,
			div:not(.zass-none-overlay).portfolio-unit.portfolio-col-4 a.portfolio-link small, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-4 a.portfolio-link h4, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-4, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-4 a.portfolio-link p,
			div:not(.zass-none-overlay).similar_projects .portfolio-unit a.portfolio-link, div:not(.zass-none-overlay).similar_projects .portfolio-unit a.portfolio-link small, div:not(.zass-none-overlay).similar_projects .portfolio-unit a.portfolio-link h4, div:not(.zass-none-overlay).similar_projects .portfolio-unit,
			div:not(.zass-none-overlay).similar_projects .portfolio-unit a.portfolio-link p, div:not(.zass-none-overlay).owl-item .portfolio-unit a.portfolio-link, div:not(.zass-none-overlay).owl-item .portfolio-unit a.portfolio-link small, div:not(.zass-none-overlay).owl-item .portfolio-unit a.portfolio-link h4,
			div:not(.zass-none-overlay).owl-item .portfolio-unit, div:not(.zass-none-overlay).owl-item .portfolio-unit a.portfolio-link p, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-5 a.portfolio-link, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-5 a.portfolio-link small,
			div:not(.zass-none-overlay).portfolio-unit.portfolio-col-5 a.portfolio-link h4, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-5, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-5 a.portfolio-link p, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-6 a.portfolio-link,
			div:not(.zass-none-overlay).portfolio-unit.portfolio-col-6 a.portfolio-link small, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-6 a.portfolio-link h4, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-6, div:not(.zass-none-overlay).portfolio-unit.portfolio-col-6 a.portfolio-link p, div:not(.zass-none-overlay).zass_image_list a.zass-magnific-gallery-item:after {
				color:<?php echo esc_attr(zass_get_option('portfolio_overlay_text_color')) ?>;
			}
			.portfolio-unit-info a.portfolio-lightbox-link span {
				border-color:<?php echo esc_attr(zass_get_option('portfolio_overlay_text_color')) ?>;
			}
			/* Top Menu Bar Visible on Mobile */
			<?php if (!zass_get_option('header_top_mobile_visibility')): ?>
				<?php echo '@media only screen and (max-width: 1023px) {#header_top {display: none !Important}}'; ?>
			<?php endif; ?>
			/* Header top bar background color */
			#header_top { background-color:<?php echo esc_attr(zass_get_option('header_top_bar_color')) ?>; border-color:<?php echo esc_attr(zass_get_option('header_top_bar_border_color')) ?> !Important;}
			body.zass-overlay-header #header_top .inner { background-color:<?php echo esc_attr(zass_get_option('header_top_bar_color')) ?>; border-color:<?php echo esc_attr(zass_get_option('header_top_bar_border_color')) ?> !Important;}
			/* Header middle section background color */
			#header_bottom, #header_bottom .inner:before {background-color:<?php echo esc_attr(zass_get_option('header_bottom_bar_color')) ?>;}
			/* Header middle section bar border color */
			#header_bottom, #header_bottom .inner:before {border-color:<?php echo esc_attr(zass_get_option('header_top_bar_border_color')) ?> !Important;}
			<?php if (zass_get_option('header_middle_content_color')): ?>
				/* Header middle section content and links color */
				#header_bottom #welcome, #header_bottom #welcome a, #cart-module a.cart-contents, #cart-module a.cart-contents:before, .zass-search-cart-holder #search > span:after {color:<?php echo esc_attr(zass_get_option('header_middle_content_color')) ?>;}
			<?php endif; ?>
			/* Main menu links color and typography */
			<?php
			$main_menu_typography = zass_get_option('main_menu_typography');
			$main_menu_typography_style = json_decode($main_menu_typography['style'], true);
			$main_menu_typography_css_style = '';
			if ($main_menu_typography_style) {
				$main_menu_typography_css_style = 'font-weight:' . esc_attr($main_menu_typography_style['font-weight'] . ';font-style:' . $main_menu_typography_style['font-style'] . ';');
			}
			?>
			#main-menu ul.menu > li > a, #main-menu li div.zass-mega-menu > ul.sub-menu > li > a, .zass-wishlist-counter a, .zass-search-cart-holder a.sidebar-trigger:before, #header .zass-search-cart-holder .video_controlls a {color:<?php echo esc_attr(zass_get_option('main_menu_links_color')) ?>;font-size:<?php echo esc_attr($main_menu_typography['size']) ?>;<?php echo esc_attr($main_menu_typography_css_style) ?>}
			/* Main menu links hover color */
			ul#mobile-menu.menu li a {font-size:<?php echo esc_attr($main_menu_typography['size']) ?>;<?php echo esc_attr($main_menu_typography_css_style) ?>}
			/* Main menu links hover color */
			#main-menu ul.menu > li > a:hover, #main-menu ul.menu > li.current-menu-item > a, #main-menu ul.menu > li.zass-highlight-menu-item > a, body.zass_transparent_header #header #main-menu ul.menu > li > a:hover, body.zass_transparent_header #header #main-menu ul.menu > li.current-menu-item > a, #cart-module a.cart-contents, #main-menu li div.zass-mega-menu > ul.sub-menu > li > a:hover {color:<?php echo esc_attr(zass_get_option('main_menu_links_hover_color')) ?>;}
			/* Main menu background hover color */
			<?php if (zass_get_option('main_menu_links_bckgr_hover_color')): ?>
				body:not(.zass_transparent_header) #main-menu ul.menu > li > a:hover, body:not(.zass_transparent_header) #main-menu ul.menu > li.current-menu-item > a, body:not(.zass_transparent_header) #main-menu ul.menu > li > a:hover, #header2 #main-menu ul.menu > li.current-menu-item > a, #header2 #main-menu ul.menu > li > a:hover { background-color: <?php echo esc_attr(zass_get_option('main_menu_links_bckgr_hover_color')) ?>;}
				#main-menu ul.menu > li.zass-highlight-menu-item > a, #main-menu ul.menu > li.zass-highlight-menu-item:after, #main-menu li ul.sub-menu li a:hover { background-color: <?php echo esc_attr(zass_get_option('main_menu_links_bckgr_hover_color')) ?>;}
				#main-menu ul.menu > li.zass-highlight-menu-item:after { border-color: <?php echo esc_attr(zass_get_option('main_menu_links_bckgr_hover_color')) ?>;}
				#main-menu ul.menu > li > a:before {color:<?php echo esc_attr(zass_get_option('main_menu_links_hover_color')) ?>;}
			<?php endif; ?>
			<?php if (!zass_get_option('main_menu_links_bckgr_hover_color')): ?>
				#main-menu ul.menu > li.zass-highlight-menu-item > a, #main-menu ul.menu > li.zass-highlight-menu-item:after, #main-menu li ul.sub-menu li a:hover { background-color: <?php echo esc_attr(zass_get_option('accent_color')) ?>;}
				#main-menu ul.menu > li.zass-highlight-menu-item:after { border-color: <?php echo esc_attr(zass_get_option('accent_color')) ?>;}
			<?php endif; ?>
			<?php if (zass_get_option('main_menu_transf_to_uppercase')): ?>
				#main-menu ul.menu > li > a {text-transform: uppercase;}
			<?php endif; ?>
			/* Main menu icons color */
			<?php if (zass_get_option('main_menu_icons_color')): ?>
			#main-menu ul.menu li a i {color: <?php echo esc_attr(zass_get_option('main_menu_icons_color')) ?>;}
			<?php endif; ?>
			/* Header top bar menu links color */
			ul#topnav2 > li a, .zass-top-bar-message, #header_top .zass-social ul li a {color:<?php echo esc_attr(zass_get_option('top_bar_menu_links_color')) ?>}
			/* Header top bar menu links hover color */
			ul#topnav2 li a:hover, body.zass_transparent_header ul#topnav2 > li a:hover {color:<?php echo esc_attr(zass_get_option('top_bar_menu_links_hover_color')) ?>;}
			ul#topnav2 ul.sub-menu li a:hover, .zass-dark-skin ul#topnav2 ul.sub-menu a:hover, .zass-dark-skin ul#topnav2 li:hover ul.sub-menu a:hover {background-color:<?php echo esc_attr(zass_get_option('top_bar_menu_links_hover_color')) ?>;}
			/* Header top bar menu links hover background color */
			ul#topnav2 li a:hover {background-color:<?php echo esc_attr(zass_get_option('top_bar_menu_links_bckgr_color')) ?>;}
			/* Collapsible Pre-Header background color */
			#pre_header, .toggler {background-color:<?php echo esc_attr(zass_get_option('collapsible_bckgr_color')) ?>;}
			.toggler {border-color:<?php echo esc_attr(zass_get_option('collapsible_bckgr_color')) ?>;}
			/* Collapsible Pre-Header titles color */
			#pre_header .widget > h3:first-child {color:<?php echo esc_attr(zass_get_option('collapsible_titles_color')) ?>;}
			/* Collapsible Pre-Header titles border color */
			#pre_header .widget > h3:first-child, #pre_header > .inner ul.product_list_widget li, #pre_header > .inner div.widget_nav_menu ul li a, #pre_header > .inner ul.products-list li {border-color:<?php echo esc_attr(zass_get_option('collapsible_titles_border_color')) ?>;}
			#pre_header > .inner div.widget_categories ul li, #pre_header > .inner div.widget_archive ul li, #pre_header > .inner div.widget_recent_comments ul li, #pre_header > .inner div.widget_pages ul li,
			#pre_header > .inner div.widget_links ul li, #pre_header > .inner div.widget_recent_entries ul li, #pre_header > .inner div.widget_meta ul li, #pre_header > .inner div.widget_display_forums ul li,
			#pre_header > .inner .widget_display_replies ul li, #pre_header > .inner .widget_display_views ul li {border-color: <?php echo esc_attr(zass_get_option('collapsible_titles_border_color')) ?>;}
			/* Collapsible Pre-Header links color */
			#pre_header a {color:<?php echo esc_attr(zass_get_option('collapsible_links_color')) ?>;}
			/* Transparent Header menu color */
			@media only screen and (min-width: 1024px) {
				body.zass_transparent_header #header #logo .zass-logo-title, body.zass_transparent_header #header #zass-account-holder a, body.zass_transparent_header #header #zass-account-holder a i, body.zass_transparent_header #header .zass-search-cart-holder .video_controlls a, body.zass_transparent_header #header #logo .zass-logo-subtitle, body.zass_transparent_header #header #main-menu ul.menu > li > a, body.zass_transparent_header #header .zass-search-cart-holder #search > span:after, body.zass_transparent_header .zass-search-cart-holder a.sidebar-trigger:before, body.zass_transparent_header #header #cart-module a.cart-contents, body.zass_transparent_header #header #cart-module a.cart-contents:before, body.zass_transparent_header #header .zass-wishlist-counter a, body.zass_transparent_header #header .zass-wishlist-counter a i {
					color:<?php echo esc_attr(zass_get_option('transparent_header_menu_color')) ?> !Important;
				}
				/* Transparent menu hover color */
				<?php if (zass_get_option('transparent_header_menu_hover_color')): ?>
					body.zass_transparent_header #header #main-menu ul.menu > li > a:hover, body.zass_transparent_header #header #main-menu ul.menu > li.current-menu-item > a { color: <?php echo esc_attr(zass_get_option('transparent_header_menu_hover_color')) ?> !Important;}
				<?php endif; ?>
			}
			/* Header background */
			<?php $header_backgr = zass_get_option('header_background'); ?>
			<?php if ($header_backgr['image']): ?>
				#header, #header2 {background: url("<?php echo esc_url(wp_get_attachment_image_url($header_backgr['image'], 'full')) ?>") <?php echo esc_attr($header_backgr['position']) ?> <?php echo esc_attr($header_backgr['repeat']) ?> <?php echo esc_attr($header_backgr['attachment']) ?>;}
				body.zass-overlay-header #header .main_menu_holder {background: url("<?php echo esc_url(wp_get_attachment_image_url($header_backgr['image'], 'full')) ?>") <?php echo esc_attr($header_backgr['position']) ?> <?php echo esc_attr($header_backgr['repeat']) ?> <?php echo esc_attr($header_backgr['attachment']) ?>;}
			<?php endif; ?>

			#header, #header2 {background-color: <?php echo esc_attr($header_backgr['color']) ?>;}
			<?php if ($header_backgr['color'] != "#ffffff"): ?>
				.zass-search-cart-holder #search > span:after, .zass-search-cart-holder a.sidebar-trigger:before, .zass-search-cart-holder #cart-module a.cart-contents, .zass-search-cart-holder #cart-module a.cart-contents:before, .zass-search-cart-holder .zass-wishlist-counter a, .zass-search-cart-holder .zass-wishlist-counter a i, .zass-search-cart-holder  #zass-account-holder a, .zass-search-cart-holder  #zass-account-holder a i {
					color:<?php echo esc_attr(zass_get_option('main_menu_links_color')) ?>;}
				#header, #header2, #header_top {border:none;}
				#main-menu ul.menu > li > a::before {color:<?php echo esc_attr(zass_get_option('main_menu_links_hover_color')) ?>;}
			body.zass_header_left #header, body.zass_header_left.zass_transparent_header #header {
				border-right: none;
			}
			<?php endif; ?>
			body.zass-overlay-header #header .main_menu_holder {background-color: <?php echo esc_attr($header_backgr['color']) ?>;}
			/* footer_background */
			<?php $footer_backgr = zass_get_option('footer_background'); ?>
			<?php if ($footer_backgr['image']): ?>
				#footer {background: url("<?php echo esc_url(wp_get_attachment_image_url($footer_backgr['image'], 'full')) ?>") <?php echo esc_attr($footer_backgr['position']) ?> <?php echo esc_attr($footer_backgr['repeat']) ?> <?php echo esc_attr($footer_backgr['attachment']) ?>;}
			<?php endif; ?>
			#footer {background-color: <?php echo esc_attr($footer_backgr['color']) ?>;}
            <?php if ($footer_backgr['repeat'] === 'no-repeat' ): ?>
            #footer {
                background-size: cover;
            }
            <?php endif; ?>

			@media only screen and (min-width: 1024px) {
				body.zass_header_left.zass-overlay-header #footer, body.zass_header_left.zass-overlay-header #powered {background: none;}
				body.zass_header_left.zass-overlay-header #footer .inner {background-color: <?php echo esc_attr($footer_backgr['color']) ?>;}
				body.zass_header_left.zass-overlay-header #powered .inner {background-color: <?php echo esc_attr(zass_get_option('footer_copyright_bar_bckgr_color')) ?>;}
			}


			/* footer_titles_color + footer_title_border_color */
			#footer .widget > h3:first-child {color:<?php echo esc_attr(zass_get_option('footer_titles_color')) ?>; border-color: <?php echo esc_attr(zass_get_option('footer_title_border_color')) ?>;}
			#footer > .inner ul.product_list_widget li, #footer > .inner div.widget_nav_menu ul li a, #footer > .inner ul.products-list li, #zass_footer_menu > li {border-color: <?php echo esc_attr(zass_get_option('footer_title_border_color')) ?>;}
			/* footer_menu_links_color */
			#zass_footer_menu > li a, #powered a, #powered .zass-social ul li a {color: <?php echo esc_attr(zass_get_option('footer_menu_links_color')) ?>;}
			/* footer_links_color */
			#footer > .inner a {color: <?php echo esc_attr(zass_get_option('footer_links_color')) ?>;}
			/* footer_text_color */
			#footer {color: <?php echo esc_attr(zass_get_option('footer_text_color')) ?>;}
			#footer > .inner div.widget_categories ul li, #footer > .inner div.widget_archive ul li, #footer > .inner div.widget_recent_comments ul li, #footer > .inner div.widget_pages ul li,
			#footer > .inner div.widget_links ul li, #footer > .inner div.widget_recent_entries ul li, #footer > .inner div.widget_meta ul li, #footer > .inner div.widget_display_forums ul li,
			#footer > .inner .widget_display_replies ul li, #footer > .inner .widget_display_views ul li, #footer > .inner div.widget_nav_menu ul li a {border-color: <?php echo esc_attr(zass_get_option('footer_title_border_color')) ?>;}
			/* footer_copyright_bar_bckgr_color */
			#powered{background-color: <?php echo esc_attr(zass_get_option('footer_copyright_bar_bckgr_color')) ?>; color: <?php echo esc_attr(zass_get_option('footer_copyright_bar_text_color')) ?>;}
			/* Body font */
			<?php $body_font = zass_get_option('body_font'); ?>
			body {
                <?php if(!empty($body_font['face'])): ?>
				    font-family:<?php echo esc_attr($body_font['face']) ?>;
                <?php endif; ?>
				font-size:<?php echo esc_attr($body_font['size']) ?>;
				color:<?php echo esc_attr($body_font['color']) ?>;
			}
			#header #logo .zass-logo-subtitle, #header2 #logo .zass-logo-subtitle {
				color: <?php echo esc_attr($body_font['color']) ?>;
			}
			/* Text logo color and typography */
			<?php
			$text_logo_typography = zass_get_option('text_logo_typography');
			$text_logo_typography_style = json_decode($text_logo_typography['style'], true);
			$text_logo_typography_color = $text_logo_typography['color'];
			$text_logo_typography_css_style = '';
			if ($text_logo_typography_style) {
				$text_logo_typography_css_style = 'font-weight:' . esc_attr($text_logo_typography_style['font-weight'] . ';font-style:' . $text_logo_typography_style['font-style'] . ';');
			}
			?>
			#header #logo .zass-logo-title, #header2 #logo .zass-logo-title {color: <?php echo esc_attr($text_logo_typography_color) ?>;font-size:<?php echo esc_attr($text_logo_typography['size']) ?>;<?php echo esc_attr($text_logo_typography_css_style) ?>}
			/* Heading fonts */
			<?php $headings_font = zass_get_option('headings_font'); ?>
            <?php if(!empty($headings_font['face'])): ?>
                h1, h2, h3, h4, h5, h6, .tribe-countdown-text, div.prod_hold .name, .vendor_address p, .zass-event-countdown .is-countdown, #header #logo .zass-logo-title, #header2 #logo .zass-logo-title, .zass-counter-h1, .zass-typed-h1, .zass-typed-h2, .zass-typed-h3, .zass-typed-h4, .zass-typed-h5, .zass-typed-h6, .zass-counter-h2, body.woocommerce-account #customer_login.col2-set .owl-nav, .zass-counter-h3, .error404 div.blog-post-excerpt:before, #yith-wcwl-popup-message #yith-wcwl-message, div.added-product-text strong, .vc_pie_chart .vc_pie_chart_value, .countdown-amount, .zass-product-slide-price, .zass-counter-h4, .zass-counter-h5, .zass-search-cart-holder #search input[type="text"], .zass-counter-h6, .vc_tta-tabs:not(.vc_tta-style-modern) .vc_tta-tab, div.product .price span, a.bbp-forum-title, p.logged-in-as, .zass-pricing-table-price, li.bbp-forum-info, li.bbp-topic-title .bbp-topic-permalink, .breadcrumb, .offer_title, ul.tabs a, .wpb_tabs .wpb_tabs_nav li a, .wpb_tour .wpb_tabs_nav a, .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a, .post-date .num, .zass-products-list-view div.prod_hold .name, .zass_shortcode_count_holder .countdown-amount, .post-date, .blog-post-meta span a, .widget_shopping_cart_content p.total, #cart-module a.cart-contents, .zass-wishlist-counter, .portfolio_top .project-data .project-details .simple-list-underlined li, .portfolio_top .project-data .main-features .checklist li, .summary.entry-summary .yith-wcwl-add-to-wishlist a {
                    font-family:<?php echo esc_attr($headings_font['face']) ?>;
                }
                <?php $use_google_face_for = zass_get_option('use_google_face_for'); ?>

                <?php if ($use_google_face_for['main_menu']): ?>
                    #main-menu ul.menu li a, ul#mobile-menu.menu li a, #main-menu li div.zass-mega-menu > ul.sub-menu > li.zass_colum_title > a {
                        font-family:<?php echo esc_attr($headings_font['face']) ?>;
                    }
                <?php endif; ?>

                <?php if ($use_google_face_for['buttons']): ?>
                    a.button, input.button, button.button, a.button-inline, #submit_btn, #submit, .wpcf7-submit, .col2-set.addresses header a.edit, div.product input.qty, .zass-pricing-table-button a, .vc_btn3, nav.woocommerce-MyAccount-navigation ul li a {
                        font-family:<?php echo esc_attr($headings_font['face']) ?>;
                    }
                .wcmp_regi_main .button {
                    font-family:<?php echo esc_attr($headings_font['face']) ?> !important;
                }
                <?php endif; ?>
            <?php endif; ?>
			/* H1 */
			<?php
			$h1_font = zass_get_option('h1_font');
			$h1_style = json_decode($h1_font['style'], true);
			$h1_css_style = '';
			if ($h1_style) {
				$h1_css_style = 'font-weight:' . esc_attr($h1_style['font-weight'] . ';font-style:' . $h1_style['font-style'] . ';');
			}
			?>
			h1, .zass-counter-h1, .zass-typed-h1, .term-description p:first-of-type:first-letter, .zass-dropcap p:first-letter, .zass-dropcap h1:first-letter, .zass-dropcap h2:first-letter, .zass-dropcap h3:first-letter, .zass-dropcap h4:first-letter, .zass-dropcap h5:first-letter, .zass-dropcap h6:first-letter{color:<?php echo esc_attr($h1_font['color']) ?>;font-size:<?php echo esc_attr($h1_font['size']) ?>;<?php echo esc_attr($h1_css_style) ?>}
			/* H2 */
			<?php
			$h2_font = zass_get_option('h2_font');
			$h2_style = json_decode($h2_font['style'], true);
			$h2_css_style = '';
			if ($h2_style) {
				$h2_css_style = 'font-weight:' . esc_attr($h2_style['font-weight'] . ';font-style:' . $h2_style['font-style'] . ';');
			}
			?>
			h2, .zass-counter-h2, .zass-typed-h2, .icon_teaser h3:first-child, body.woocommerce-account #customer_login.col2-set .owl-nav button, #customer_login.u-columns.col2-set .owl-nav button {color:<?php echo esc_attr($h2_font['color']) ?>;font-size:<?php echo esc_attr($h2_font['size']) ?>;<?php echo esc_attr($h2_css_style) ?>}
			/* H3 */
			<?php
			$h3_font = zass_get_option('h3_font');
			$h3_style = json_decode($h3_font['style'], true);
			$h3_css_style = '';
			if ($h3_style) {
				$h3_css_style = 'font-weight:' . esc_attr($h3_style['font-weight'] . ';font-style:' . $h3_style['font-style'] . ';');
			}
			?>
			h3, .zass-counter-h3, .zass-typed-h3{color:<?php echo esc_attr($h3_font['color']) ?>;font-size:<?php echo esc_attr($h3_font['size']) ?>;<?php echo esc_attr($h3_css_style) ?>}
			/* H4 */
			<?php
			$h4_font = zass_get_option('h4_font');
			$h4_style = json_decode($h4_font['style'], true);
			$h4_css_style = '';
			if ($h4_style) {
				$h4_css_style = 'font-weight:' . esc_attr($h4_style['font-weight'] . ';font-style:' . $h4_style['font-style'] . ';');
			}
			?>
			h4, .zass-counter-h4, .zass-typed-h4{color:<?php echo esc_attr($h4_font['color']) ?>;font-size:<?php echo esc_attr($h4_font['size']) ?>;<?php echo esc_attr($h4_css_style) ?>}
			/* H5 */
			<?php
			$h5_font = zass_get_option('h5_font');
			$h5_style = json_decode($h5_font['style'], true);
			$h5_css_style = '';
			if ($h5_style) {
				$h5_css_style = 'font-weight:' . esc_attr($h5_style['font-weight'] . ';font-style:' . $h5_style['font-style'] . ';');
			}
			?>
			h5, .zass-counter-h5, .zass-typed-h5{color:<?php echo esc_attr($h5_font['color']) ?>;font-size:<?php echo esc_attr($h5_font['size']) ?>;<?php echo esc_attr($h5_css_style) ?>}
			/* H6 */
			<?php
			$h6_font = zass_get_option('h6_font');
			$h6_style = json_decode($h6_font['style'], true);
			$h6_css_style = '';
			if ($h6_style) {
				$h6_css_style = 'font-weight:' . esc_attr($h6_style['font-weight'] . ';font-style:' . $h6_style['font-style'] . ';');
			}
			?>
			h6, .zass-counter-h6, .zass-typed-h6{color:<?php echo esc_attr($h6_font['color']) ?>;font-size:<?php echo esc_attr($h6_font['size']) ?>;<?php echo esc_attr($h6_css_style) ?>}
			<?php if (zass_get_option('custom_css')): ?>
				<?php echo esc_attr(zass_get_option('custom_css')); ?>
			<?php endif; ?>
			/* Add to Cart Color */
			div.prod_hold a.button.add_to_cart_button, button.single_add_to_cart_button, .wc-proceed-to-checkout a.checkout-button.button, .zass-product-slide-cart .button.add_to_cart_button {border-color:<?php echo esc_attr(zass_get_option('add_to_cart_color')); ?> !important; color:<?php echo esc_attr(zass_get_option('add_to_cart_color')); ?> !important;}
			/* Main menu background color */
			<?php if (zass_get_option('main_menu_bckgr_color')): ?>
				body.zass_logo_center_menu_below #main-menu {background-color:<?php echo esc_attr(zass_get_option('main_menu_bckgr_color')) ?>; padding-left:12px; padding-right:12px;}
			<?php endif; ?>
			table.compare-list .add-to-cart td a.zass-quick-view-link, table.compare-list .add-to-cart td a.compare.button {
				display:none !important;
			}</style>
		<?php
		$custom_css = ob_get_clean();
		$custom_css = trim(preg_replace('#<style[^>]*>(.*)</style>#is', '$1', $custom_css));

		wp_add_inline_style('zass-style', $custom_css); // All dynamic data escaped
	}

}