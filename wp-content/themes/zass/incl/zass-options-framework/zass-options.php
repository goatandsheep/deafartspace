<?php

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */
function zass_optionsframework_options() {

	// general layout values
	$general_layout_values = array(
			'zass_fullwidth' => ZASS_IMAGES_PATH . 'zass_fullwidth.jpg',
			'zass_boxed' => ZASS_IMAGES_PATH . 'zass_boxed.jpg',
			'zass_header_left' => ZASS_IMAGES_PATH . 'zass_header_left.jpg'
	);

	// logo and menu postions
	$logo_and_menu_position_values = array(
			'zass_logo_left_menu_right' => ZASS_IMAGES_PATH . 'zass_logo_left_menu_right.jpg',
			'zass_logo_center_menu_below' => ZASS_IMAGES_PATH . 'zass_logo_center_menu_below.jpg'
	);
	// Blog style options
	$general_blog_style_values = array(
			'' => esc_html__('Standard', 'zass'),
			'zass_blog_masonry' => esc_html__('Masonry', 'zass')
	);

	// Header Background Defaults
	$header_background_defaults = array(
			'color' => '#ffffff',
			'image' => '',
			'repeat' => '',
			'position' => '',
			'attachment' => 'scroll'
	);

	// Footer Background Defaults
	$footer_background_defaults = array(
			'color' => '#f0eeea',
			'image' => '',
			'repeat' => '',
			'position' => '',
			'attachment' => 'scroll'
	);

	// Number of columns on products list
	$shop_default_product_columns_values = array(
			'columns-1' => '1',
			'columns-2' => '2',
			'columns-3' => '3',
			'columns-4' => '4',
			'columns-5' => '5',
			'columns-6' => '6',
			'zass-products-list-view' => esc_html__('List View', 'zass')
	);

	$header_style_list = array(
			'' => esc_html__('Normal', 'zass'),
			'zass_transparent_header' => esc_html__('Transparent', 'zass'),
	);

	$choose_menu_options = zass_get_choose_menu_options();

	// Date format values
	$date_fromat_default = array(
			'zass_format' => esc_html_x('Day/Month styled date format', 'theme-options', 'zass'),
			'default' => esc_html_x('WP date format', 'theme-options', 'zass')
	);

	// Show/hide seasrchform
	$show_searchform_default = 1;

	// Search options values Array
	$search_options_array = array(
			'use_ajax' => esc_html_x('Use Ajax', 'theme-options', 'zass')
	);

	if (defined('ZASS_IS_WOOCOMMERCE') && ZASS_IS_WOOCOMMERCE) {
		$search_options_array['only_products'] = esc_html_x('Search only in Products', 'theme-options', 'zass');
	}

	// Search options Defaults
	$search_options_defaults = array(
			'use_ajax' => '1'
	);

	// Enabled / Disabled select
	$enable_disable_array = array(
			'enabled' => esc_html_x('Enabled', 'theme-options', 'zass'),
			'disabled' => esc_html_x('Disabled', 'theme-options', 'zass')
	);

	// "NEW" label active period (days)
	$new_label_period_array = array(
			'10' => 10,
			'20' => 20,
			'30' => 30,
			'45' => 45,
			'60' => 60,
			'90' => 90
	);

	$os_faces = zass_typography_get_os_fonts();
	$body_fonts = array('Open Sans' => '"Open Sans", sans-serif') + $os_faces;

	$google_fonts = zass_typography_get_google_fonts();
	$typography_mixed_fonts = array_merge($os_faces, $google_fonts);
	asort($typography_mixed_fonts);

	// Default google subsets
	$google_subsets_defaults = array('latin' => '1');

	// Google subsets
	$google_subsets_options = array(
			'cyrillic-ext' => 'Cyrillic Extended (cyrillic-ext)',
			'latin' => 'Latin (latin)',
			'greek-ext' => 'Greek Extended (greek-ext)',
			'greek' => 'Greek (greek)',
			'vietnamese' => 'Vietnamese (vietnamese)',
			'latin-ext' => 'Latin Extended (latin-ext)',
			'cyrillic' => 'Cyrillic (cyrillic)'
	);

	// body font default
	$body_font_default = array(
			'face' => 'Open Sans',
			'size' => '14px',
			'color' => '#999999'
	);

	// Headings font face default
	$headings_font_default = array(
			'face' => 'Raleway'
	);

	// Heading fonts style and weight options
	$headings_fonts_styles_weight = array('false' => 'default');

	for ($n = 1; $n < 10; $n++) {
		$headings_fonts_styles_weight['{"font-weight":"' . $n . '00","font-style":"normal"}'] = $n . '00';
		$headings_fonts_styles_weight['{"font-weight":"' . $n . '00","font-style":"italic"}'] = $n . '00 italic';
	}

	// H1 deault
	$h1_font_default = array(
			'face' => $headings_font_default['face'],
			'size' => '62px',
			'color' => '#2b3033',
			'style' => '{"font-weight":"800","font-style":"normal"}'
	);

	// H2 deault
	$h2_font_default = array(
			'face' => $headings_font_default['face'],
			'size' => '44px',
			'color' => '#2b3033',
			'style' => '{"font-weight":"800","font-style":"normal"}'
	);

	// H3 deault
	$h3_font_default = array(
			'face' => $headings_font_default['face'],
			'size' => '34px',
			'color' => '#2b3033',
			'style' => '{"font-weight":"700","font-style":"normal"}'
	);

	// H4 deault
	$h4_font_default = array(
			'face' => $headings_font_default['face'],
			'size' => '24px',
			'color' => '#2b3033',
			'style' => '{"font-weight":"500","font-style":"normal"}'
	);

	// H5 deault
	$h5_font_default = array(
			'face' => $headings_font_default['face'],
			'size' => '18px',
			'color' => '#2b3033',
			'style' => '{"font-weight":"500","font-style":"normal"}'
	);

	// H6 deault
	$h6_font_default = array(
			'face' => $headings_font_default['face'],
			'size' => '16px',
			'color' => '#2b3033',
			'style' => 'false'
	);

	// CloudZoom Values
	$cloudzoom_multicheck_vals = array(
			'single' => esc_html_x('Single product gallery', 'theme-options', 'zass')
	);

	// CloudZoom Defaults
	$cloudzoom_multicheck_defaults = array(
			'single' => '1'
	);

	// Stores registered sidebars
	global $wp_registered_sidebars;
	$registered_sidebars_array = array('none' => 'none');

	foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
		if ($sidebar_id != 'pre_header_sidebar') {
			$registered_sidebars_array[$sidebar_id] = $sidebar['name'];
		}
	}

	$wp_editor_settings = array(
			'wpautop' => true, // Default
			'textarea_rows' => 5,
			'tinymce' => array('plugins' => 'wordpress'),
			'media_buttons' => true
	);

	$options = array();

	/*
	 * GENERAL SETTNIGS
	 */

	$options[] = array(
			'name' => esc_html_x('General', 'theme-options', 'zass'),
			'type' => 'heading'
	);
	$options[] = array(
			'name' => esc_html_x('Responsive', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enable responsive design.', 'theme-options', 'zass'),
			'id' => 'is_responsive',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Use Site Preloader', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enable preloader for the whole site.', 'theme-options', 'zass'),
			'id' => 'show_preloader',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Layout', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose layout to be used sitewide.', 'theme-options', 'zass'),
			'id' => 'general_layout',
			'std' => 'zass_fullwidth',
			'type' => 'images',
			'options' => $general_layout_values
	);
	$options[] = array(
			'name' => esc_html_x('Logo', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose or upload new logo.', 'theme-options', 'zass'),
			'id' => 'theme_logo',
			'std' => '',
			'type' => 'zass_upload'
	);
	$options[] = array(
			'name' => esc_html_x('Transparent Header Alternative Logo', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose or upload new logo.', 'theme-options', 'zass'),
			'id' => 'transparent_theme_logo',
			'type' => 'zass_upload'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Logo (Needs to be enabled from Footer area->Show logo in footer)', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose or upload new logo.', 'theme-options', 'zass'),
			'id' => 'footer_logo',
			'type' => 'zass_upload'
	);
	$options[] = array(
			'name' => esc_html_x('Text Logo Typography', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set font options for text logo (only active if there is no image logo selected).', 'theme-options', 'zass'),
			'id' => 'text_logo_typography',
			'std' => array(
					'size' => '24px',
					'style' => '{"font-weight":"800","font-style":"normal"}',
					'color' => '#333333'
			),
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'color' => true
			)
	);
	$options[] = array(
		'name' => esc_html_x( 'Google Maps JavaScript API key', 'theme-options', 'zass' ),
		'desc' => sprintf( wp_kses( _x( 'Enter your Google Maps JavaScript API key, to be used for google map integration in Map shortcode. <a target="_blank" href="%s">Generate Google Maps JavaScript API key</a>', 'theme-options', 'zass' ), array(
			'a' => array(
				'target' => array(),
				'href'   => array()
			)
		) ), esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key' ) ),
		'id'   => 'google_maps_api_key',
		'std'  => '',
		'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Enable Smooth Scroll', 'theme-options', 'zass'),
			'desc' => esc_html_x('Smooth scrolling, when using anchors (known as one-pager).', 'theme-options', 'zass'),
			'id' => 'enable_smooth_scroll',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Show Previous / Next Links', 'theme-options', 'zass'),
			'desc' => esc_html_x('Show Previous / Next Links for posts, products and portfolios.', 'theme-options', 'zass'),
			'id' => 'show_prev_next',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Date Format on Posts List', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose between the WordPress settings format and the theme format', 'theme-options', 'zass'),
			'id' => 'date_fromat',
			'std' => 'zass_format',
			'type' => 'radio',
			'options' => $date_fromat_default
	);
	$options[] = array(
			'name' => esc_html_x('Enable Carousel Effect', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enable Carousel effect on related posts, portfolios and products.', 'theme-options', 'zass'),
			'id' => 'owl_carousel',
			'std' => 1,
			'type' => 'checkbox'
	);
	// When 'expandable_option' class is used,
	// the options with class as the id if this element will be shown/hide
	$options[] = array(
			'name' => esc_html_x('Show Search in Header', 'theme-options', 'zass'),
			'desc' => esc_html_x('Show search form in header.', 'theme-options', 'zass'),
			'id' => 'show_searchform',
			'std' => $show_searchform_default,
			'class' => 'expandable_option',
			'type' => 'checkbox'
	);
	$options[] = array(
			//'name' => esc_html__('Multicheck' , 'zass'),
			'desc' => esc_html_x('Choose whether to use Ajax or ordinary form. Search only in products or in the whole site (only if WooCommerce is activated).', 'theme-options', 'zass'),
			'id' => 'search_options',
			'std' => $search_options_defaults, // These items get checked by default
			'type' => 'multicheck',
			'options' => $search_options_array,
			'class' => 'show_searchform'
	);
	$options[] = array(
			'name' => esc_html_x('Enable Breadcrumb', 'theme-options', 'zass'),
			'desc' => esc_html_x('Show breadcrumb.', 'theme-options', 'zass'),
			'id' => 'show_breadcrumb',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Custom CSS', 'theme-options', 'zass'),
			'desc' => esc_html_x('You can define custom CSS rules here. They will override all other CSS. In some cases you may need to add !important', 'theme-options', 'zass'),
			'id' => 'custom_css',
			'std' => '',
			'type' => 'textarea'
	);
	/*
	 * HEADER AREA SETTNIGS
	 */
	$options[] = array(
			'name' => esc_html_x('Header area', 'theme-options', 'zass'),
			'type' => 'heading',
			'class' => 'zass-expandable-cont'
	);
	$options[] = array(
			'name' => esc_html_x('Logo and Top Menu Positions', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select how the logo and top menu will appear.', 'theme-options', 'zass'),
			'id' => 'logo_menu_position',
			'std' => 'zass_logo_center_menu_below',
			'type' => 'images',
			'options' => $logo_and_menu_position_values,
			'class' => 'expandable_option'
	);
	$options[] = array(
		'name' => esc_html_x('Main Menu Alignment', 'theme-options', 'zass'),
		'desc' => esc_html_x('Set main menu alignment position.', 'theme-options', 'zass'),
		'id' => 'main_menu_alignment',
		'std' => 'zass-main-menu-right',
		'type' => 'select',
		'class' => 'logo_menu_position_zass_logo_left_menu_right',
		'options' => array(
			'zass-main-menu-left' => esc_html_x('Left', 'theme-options', 'zass'),
			'zass-main-menu-center' => esc_html_x('Center', 'theme-options', 'zass'),
			'zass-main-menu-right' => esc_html_x('Right', 'theme-options', 'zass')
		)
	);
	$options[] = array(
			'name' => esc_html_x('Header Size', 'theme-options', 'zass'),
			'desc' => esc_html_x('Standard / Fullwidth.', 'theme-options', 'zass'),
			'id' => 'header_width',
			'std' => '',
			'type' => 'select',
			'options' => array(
					'' => esc_html_x('Standard', 'theme-options', 'zass'),
					'zass-stretched-header' => esc_html_x('Fullwidth', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html_x('Sticky Header', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enable sticky header functionality. (not available in header-left layout)', 'theme-options', 'zass'),
			'id' => 'sticky_header',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Left Header Settings', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select fixed or scrollable left header.', 'theme-options', 'zass'),
			'id' => 'left_header_setting',
			'std' => '',
			'type' => 'select',
			'options' => array(
					'' => esc_html_x('Fixed', 'theme-options', 'zass'),
					'left-header-scrollable' => esc_html_x('Scrollable', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html__('Header Background', 'zass'),
			'desc' => esc_html__('Set Header Background image and/or color.', 'zass'),
			'id' => 'header_background',
			'std' => $header_background_defaults,
			'type' => 'background'
	);
	$options[] = array(
			'name' => esc_html_x('Top Menu Bar', 'theme-options', 'zass'),
			'desc' => esc_html_x('Show the top menu bar', 'theme-options', 'zass'),
			'id' => 'enable_top_header',
			'std' => 0,
			'type' => 'checkbox',
			'class' => 'expandable_option'
	);
	$options[] = array(
			'name' => esc_html_x('Top Menu Bar Visible on Mobile', 'theme-options', 'zass'),
			'desc' => esc_html_x('Will be vsible on mobile devices', 'theme-options', 'zass'),
			'id' => 'header_top_mobile_visibility',
			'std' => 1,
			'type' => 'checkbox',
			'class' => 'enable_top_header'
	);
	$options[] = array(
			'name' => esc_html_x('Short Top Header Message', 'theme-options', 'zass'),
			'desc' => esc_html_x('The message will appear in the top menu bar.', 'theme-options', 'zass'),
			'id' => 'top_bar_message',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'desc' => esc_html_x('Append Phone Number.', 'theme-options', 'zass'),
			'id' => 'top_bar_message_phone',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
		'desc' => esc_html_x('Make phone number a link to dial.', 'theme-options', 'zass'),
		'id' => 'top_bar_message_phone_link',
		'std' => 1,
		'type' => 'checkbox',
	);
	$options[] = array(
			'desc' => esc_html_x('Append Email Address.', 'theme-options', 'zass'),
			'id' => 'top_bar_message_email',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
		'desc' => esc_html_x('Make email address a link to open default mail client.', 'theme-options', 'zass'),
		'id' => 'top_bar_message_email_link',
		'std' => 1,
		'type' => 'checkbox',
	);
	$options[] = array(
			'name' => esc_html_x('Collapsible Pre-Header', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enable Collapsible Pre-Header widget area', 'theme-options', 'zass'),
			'id' => 'enable_pre_header',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Collapsible Pre-Header Background Color', 'theme-options', 'zass'),
			'id' => 'collapsible_bckgr_color',
			'std' => '#e9e7e2',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Collapsible Pre-Header Titles Color', 'theme-options', 'zass'),
			'id' => 'collapsible_titles_color',
			'std' => '#333333',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Collapsible Pre-Header Titles Border Color', 'theme-options', 'zass'),
			'id' => 'collapsible_titles_border_color',
			'std' => '#e7e5e1',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Collapsible Pre-Header Links Color', 'theme-options', 'zass'),
			'id' => 'collapsible_links_color',
			'std' => '#666666',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Header Top Bar Background Color', 'theme-options', 'zass'),
			'id' => 'header_top_bar_color',
			'std' => '#ffffff',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Header Top Bar Border Color', 'theme-options', 'zass'),
			'id' => 'header_top_bar_border_color',
			'std' => '#f5f5f5',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Header Top Bar Menu Links Color', 'theme-options', 'zass'),
			'id' => 'top_bar_menu_links_color',
			'std' => '#887f6e',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Header Top Bar Menu Links Hover Color', 'theme-options', 'zass'),
			'id' => 'top_bar_menu_links_hover_color',
			'std' => '#0eccf2',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Header Top Bar Menu Links Hover Background Color', 'theme-options', 'zass'),
			'id' => 'top_bar_menu_links_bckgr_color',
			'std' => '',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Typography', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose Main menu font size and style.', 'theme-options', 'zass'),
			'id' => 'main_menu_typography',
			'std' => array(
					'size' => '14px',
					'style' => '{"font-weight":"600","font-style":"normal"}'
			),
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'color' => false
			)
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Icons Color', 'theme-options', 'zass'),
			'id' => 'main_menu_icons_color',
			'std' => '',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Transform to Uppercase', 'theme-options', 'zass'),
			'desc' => esc_html_x('Transform main menu top level to uppercase.', 'theme-options', 'zass'),
			'id' => 'main_menu_transf_to_uppercase',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Background Color', 'theme-options', 'zass'),
			'desc' => esc_html_x('*Note: Only applies for Logo left/Menu below and Logo Center/Menu below header layouts!', 'theme-options', 'zass'),
			'id' => 'main_menu_bckgr_color',
			'std' => '',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Links Color', 'theme-options', 'zass'),
			'id' => 'main_menu_links_color',
			'std' => '#887f6e',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Links Hover Color', 'theme-options', 'zass'),
			'id' => 'main_menu_links_hover_color',
			'std' => '#665f50',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Main Menu Links Hover Background Color', 'theme-options', 'zass'),
			'desc' => esc_html_x('*Note: Also applies for highlighted menu items. Not active for transparent header.!', 'theme-options', 'zass'),
			'id' => 'main_menu_links_bckgr_hover_color',
			'std' => '',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Transparent Header Menu Color', 'theme-options', 'zass'),
			'id' => 'transparent_header_menu_color',
			'std' => '#FFFFFF',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Transparent Header Menu Hover Color', 'theme-options', 'zass'),
			'id' => 'transparent_header_menu_hover_color',
			'std' => '',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Sub-Menu Color Scheme', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select color scheme for the sub-menu.', 'theme-options', 'zass'),
			'id' => 'submenu_color_scheme',
			'std' => '',
			'type' => 'select',
			'options' => array(
					'' => esc_html_x('Light', 'theme-options', 'zass'),
					'zass-dark-menu' => esc_html_x('Dark', 'theme-options', 'zass')
			)
	);
	/*
	 * FOOTER AREA SETTNIGS
	 */
	$options[] = array(
			'name' => esc_html_x('Footer area', 'theme-options', 'zass'),
			'type' => 'heading'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Style', 'theme-options', 'zass'),
			'desc' => esc_html_x('*Note: Reveal footer is only available in fullwidth layout mode and not available on mobile/touch devices and screens with height lower than 768px for compatibility reasons. Use this feature with extra attention on large footer, because of the fixed footer position, which could prevent the full footer visibility on smaller screens.', 'theme-options', 'zass'),
			'id' => 'footer_style',
			'std' => '',
			'type' => 'select',
			'options' => array(
					'' => esc_html_x('Standard', 'theme-options', 'zass'),
					'zass-reveal-footer' => esc_html_x('Reveal', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html_x('Footer Size', 'theme-options', 'zass'),
			'desc' => esc_html_x('Standard / Fullwidth.', 'theme-options', 'zass'),
			'id' => 'footer_width',
			'std' => '',
			'type' => 'select',
			'options' => array(
					'' => esc_html_x('Standard', 'theme-options', 'zass'),
					'zass-stretched-footer' => esc_html_x('Fullwidth', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html_x('Show Logo in Footer', 'theme-options', 'zass'),
			'desc' => esc_html_x('Main logo will be displayed in footer, unless General->Footer Logo is selected. In that case "Footer Logo" will be displayed.', 'theme-options', 'zass'),
			'id' => 'show_logo_in_footer',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html__('Footer Background', 'zass'),
			'desc' => esc_html__('Set Footer Background image and/or color.', 'zass'),
			'id' => 'footer_background',
			'std' => $footer_background_defaults,
			'type' => 'background'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Titles Color', 'theme-options', 'zass'),
			'id' => 'footer_titles_color',
			'std' => '#333333',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Titles Border Color', 'theme-options', 'zass'),
			'id' => 'footer_title_border_color',
			'std' => '#e7e5e1',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Menu Links Color', 'theme-options', 'zass'),
			'id' => 'footer_menu_links_color',
			'std' => '#333333',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Widgets Links Color', 'theme-options', 'zass'),
			'id' => 'footer_links_color',
			'std' => '#333333',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Text Color', 'theme-options', 'zass'),
			'id' => 'footer_text_color',
			'std' => '#999999',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Copyright Bar Background Color', 'theme-options', 'zass'),
			'id' => 'footer_copyright_bar_bckgr_color',
			'std' => '#f5f4f1',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Copyright Bar Text Color', 'theme-options', 'zass'),
			'id' => 'footer_copyright_bar_text_color',
			'std' => '#999999',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Footer Copyright Bar Text', 'theme-options', 'zass'),
			'desc' => sprintf(esc_html_x('Enter Copyright text. Use %s as wildcard to be replaced by current year.', 'theme-options', 'zass'), '%current_year%'),
			'id' => 'copyright_text',
			'std' => 'Zass theme by <a target="_blank" title="theAlThemist\'s portfolio" href="http://themeforest.net/user/theAlThemist/portfolio?ref=theAlThemist">theAlThemist</a> | &#169; %current_year% All rights reserved!',
			'type' => 'textarea'
	);

	/*
	 * COMMON STYLES
	 */
	$options[] = array(
			'name' => esc_html_x('Common Styles', 'theme-options', 'zass'),
			'type' => 'heading'
	);
	$options[] = array(
		'name' => esc_html_x('Site Design Accent', 'theme-options', 'zass'),
		'desc' => esc_html_x('Choose preferred global site effect.', 'theme-options', 'zass'),
		'id' => 'design_accent',
		'std' => 'zass-accent-tearoff',
		'type' => 'radio',
		'options' => array(
			'none' => esc_html_x('None', 'theme-options', 'zass'),
			'zass-accent-tearoff' => esc_html_x('Tear-off', 'theme-options', 'zass')
		)
	);
	$options[] = array(
			'name' => esc_html_x('Site Main Accent Color', 'theme-options', 'zass'),
			'id' => 'accent_color',
			'std' => '#f3a395',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Links Color', 'theme-options', 'zass'),
			'id' => 'links_color',
			'std' => '#f3a395',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Links Hover Color', 'theme-options', 'zass'),
			'id' => 'links_hover_color',
			'std' => '#d18d81',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Widgets Title Color', 'theme-options', 'zass'),
			'id' => 'sidebar_titles_color',
			'std' => '#333333',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Default Buttons Style', 'theme-options', 'zass'),
			'id' => 'all_buttons_style',
			'std' => 'round',
			'type' => 'select',
			'class' => 'mini',
			'options' => array(
					'classic' => esc_html__('Classic', 'zass'),
					'round' => esc_html__('Round', 'zass'),
			)
	);
	$options[] = array(
			'name' => esc_html_x('Default Buttons Color', 'theme-options', 'zass'),
			'id' => 'all_buttons_color',
			'std' => '#7ebfbf',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Default Buttons Hover Color', 'theme-options', 'zass'),
			'id' => 'all_buttons_hover_color',
			'std' => '#333333',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('NEW Label Color', 'theme-options', 'zass'),
			'id' => 'new_label_color',
			'std' => '#92dede',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('SALE Label Color', 'theme-options', 'zass'),
			'id' => 'sale_label_color',
			'std' => '#f3a395',
			'type' => 'color'
	);
	$options[] = array(
		'name' => esc_html_x('Page Title Scroll/Fade Effect', 'theme-options', 'zass'),
		'desc' => esc_html_x('Enable fade effect for page title on scroll.', 'theme-options', 'zass'),
		'id' => 'page_title_fade',
		'std' => 1,
		'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Standard page title color (no background image)', 'theme-options', 'zass'),
			'id' => 'page_title_color',
			'std' => '#474237',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Standard page subtitle color (no background image)', 'theme-options', 'zass'),
			'id' => 'page_subtitle_color',
			'std' => '#666666',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Standard page title background color (no background image)', 'theme-options', 'zass'),
			'id' => 'page_title_bckgr_color',
			'std' => '#e9e7e2',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Standard page title border color (no background image)', 'theme-options', 'zass'),
			'id' => 'page_title_border_color',
			'std' => '#f1f1f1',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Customized page title color (with background image)', 'theme-options', 'zass'),
			'id' => 'custom_page_title_color',
			'std' => '#FFFFFF',
			'desc' => esc_html_x('Also applies for subtitle and breadcrumb.', 'theme-options', 'zass'),
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Post Date Background Color', 'theme-options', 'zass'),
			'id' => 'post_date_backgr_color',
			'std' => '#92dede',
			'type' => 'color'
	);
	/*
	 * Portfolio
	 */
	$options[] = array(
			'name' => esc_html_x('Portfolio', 'theme-options', 'zass'),
			'type' => 'heading'
	);
	$options[] = array(
			'name' => esc_html_x('Portfolio Category Layout', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose the layout for the portfolio category view.', 'theme-options', 'zass'),
			'id' => 'portfoio_cat_layout',
			'std' => '{"zass_portfolio_style_class":"grid-unit","zass_columns_class":"portfolio-col-3"}',
			'type' => 'select',
			'options' => array(
					'{"zass_portfolio_style_class":"grid-unit","zass_columns_class":"portfolio-col-2"}' => esc_html_x('Grid 2 Columns', 'theme-options', 'zass'),
					'{"zass_portfolio_style_class":"grid-unit","zass_columns_class":"portfolio-col-3"}' => esc_html_x('Grid 3 Columns', 'theme-options', 'zass'),
					'{"zass_portfolio_style_class":"grid-unit","zass_columns_class":"portfolio-col-4"}' => esc_html_x('Grid 4 Columns', 'theme-options', 'zass'),
					'{"zass_portfolio_style_class":"list-unit","zass_columns_class":false}' => esc_html_x('List', 'theme-options', 'zass'),
					'{"zass_portfolio_style_class":"masonry-unit","zass_columns_class":"zass_masonry_fullwidth"}' => esc_html_x('Masonry Fullwidth', 'theme-options', 'zass'),
					'{"zass_portfolio_style_class":"masonry-unit","zass_columns_class":false}' => esc_html_x('Masonry Grid', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html_x('None-Overlay', 'theme-options', 'zass'),
			'desc' => esc_html_x('Use none-overlay style for projects in category view.', 'theme-options', 'zass'),
			'id' => 'none_overlay',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Portfolio Gaps', 'theme-options', 'zass'),
			'desc' => esc_html_x('Will there be a gap between projects in category view.', 'theme-options', 'zass'),
			'id' => 'portfoio_cat_display',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Show Similar Projects', 'theme-options', 'zass'),
			'desc' => esc_html_x('Display similar projects on single project page.', 'theme-options', 'zass'),
			'id' => 'show_related_projects',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Lightbox', 'theme-options', 'zass'),
			'desc' => esc_html_x('Show link that opens the featured image in lightbox.', 'theme-options', 'zass'),
			'id' => 'show_light_projects',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Portfolio Overlay Background Color', 'theme-options', 'zass'),
			'id' => 'portfolio_overlay_bckgr_color',
			'std' => '#303038',
			'type' => 'color'
	);
	$options[] = array(
			'name' => esc_html_x('Portfolio Overlay Text Color', 'theme-options', 'zass'),
			'id' => 'portfolio_overlay_text_color',
			'std' => '#ffffff',
			'type' => 'color'
	);
	/*
	 * FONTS
	 */
	$options[] = array(
			'name' => esc_html_x('Fonts', 'theme-options', 'zass'),
			'type' => 'heading'
	);
	$options[] = array(
			'name' => esc_html_x('Body Font', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose font parameters for the body text.', 'theme-options', 'zass') . '<br>' .
			          '<b>' . esc_html_x('Note', 'zass') . ': </b>' . esc_html_x('Choose -- None -- to use custom font, not managed by Zass. Preview will be disabled.', 'zass'),
			'id' => 'body_font',
			'std' => $body_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => $body_fonts,
					'styles' => false,
					'preview' => true
			)
	);
	$options[] = array(
			'name' => esc_html_x('Accent and Headings Google Font Face', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose Font Face.', 'theme-options', 'zass') . '<br>' .
			          '<b>' . esc_html_x('Note', 'zass') . ': </b>' . esc_html_x('Choose -- None -- to use custom font, not managed by Zass. Preview will be disabled.', 'zass'),
			'id' => 'headings_font',
			'std' => $headings_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => $typography_mixed_fonts,
					'styles' => false,
					'color' => false,
					'sizes' => false
			)
	);
	$options[] = array(
			'desc' => esc_html_x('Use selected google font face also for', 'theme-options', 'zass'),
			'id' => 'use_google_face_for',
			'std' => array(
					'main_menu' => 1,
					'buttons' => 1
			),
			'type' => 'multicheck',
			'options' => array(
					'main_menu' => esc_html_x('Main Menu', 'theme-options', 'zass'),
					'buttons' => esc_html_x('Buttons', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html__('Google Font Subsets', 'zass'),
			'desc' => esc_html_x('Choose Subsets.', 'theme-options', 'zass'),
			'id' => 'google_subsets',
			'std' => $google_subsets_defaults, // These items get checked by default
			'type' => 'multicheck',
			'options' => $google_subsets_options
	);
	$options[] = array(
			'name' => esc_html_x('H1 Font Options', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose H1 size, style and color.', 'theme-options', 'zass'),
			'id' => 'h1_font',
			'std' => $h1_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'preview' => true
			)
	);
	$options[] = array(
			'name' => esc_html_x('H2 Font Options', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose H2 size, style and color.', 'theme-options', 'zass'),
			'id' => 'h2_font',
			'std' => $h2_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'preview' => true
			)
	);
	$options[] = array(
			'name' => esc_html_x('H3 Font Options', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose H3 size, style and color.', 'theme-options', 'zass'),
			'id' => 'h3_font',
			'std' => $h3_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'preview' => true
			)
	);
	$options[] = array(
			'name' => esc_html_x('H4 Font Options', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose H4 size, style and color.', 'theme-options', 'zass'),
			'id' => 'h4_font',
			'std' => $h4_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'preview' => true
			)
	);
	$options[] = array(
			'name' => esc_html_x('H5 Font Options', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose H5 size, style and color.', 'theme-options', 'zass'),
			'id' => 'h5_font',
			'std' => $h5_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'preview' => true
			)
	);
	$options[] = array(
			'name' => esc_html_x('H6 Font Options', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose H6 size, style and color.', 'theme-options', 'zass'),
			'id' => 'h6_font',
			'std' => $h6_font_default,
			'type' => 'typography',
			'options' => array(
					'faces' => false,
					'styles' => $headings_fonts_styles_weight,
					'preview' => true
			)
	);
	/*
	 * Advanced Backgrounds
	 */
	$options[] = array(
			'name' => esc_html_x('Advanced Backgrounds', 'theme-options', 'zass'),
			'type' => 'heading',
	);
	$options[] = array(
			'name' => esc_html_x('Enable YouTube Video Background Sitewide.', 'theme-options', 'zass'),
			'desc' => esc_html_x('Check to enable below youtube video to be set as background on the whole site. Note that it will override any supersized and ordinary backgrounds.', 'theme-options', 'zass'),
			'id' => 'show_video_bckgr',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('YouTube Video URL', 'theme-options', 'zass'),
			'desc' => esc_html_x('Paste the YouTube URL.', 'theme-options', 'zass'),
			'id' => 'video_bckgr_url',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Start Time', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set the seconds the video should start at.', 'theme-options', 'zass'),
			'id' => 'video_bckgr_start',
			'class' => 'mini',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('End Time', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set the seconds the video should stop at.', 'theme-options', 'zass'),
			'id' => 'video_bckgr_end',
			'class' => 'mini',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Loop', 'theme-options', 'zass'),
			'desc' => esc_html_x('Loops the movie once ended.', 'theme-options', 'zass'),
			'id' => 'video_bckgr_loop',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Mute', 'theme-options', 'zass'),
			'desc' => esc_html_x('Mute the audio.', 'theme-options', 'zass'),
			'id' => 'video_bckgr_mute',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Enable supersized slider sitewide.', 'theme-options', 'zass'),
			'desc' => esc_html_x('Check to enable below slider to be set as background on the whole site. Note that it will override your current background.', 'theme-options', 'zass'),
			'id' => 'show_super_gallery',
			'std' => '0',
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Choose images for the sitewide supersized slider.', 'theme-options', 'zass'),
			'desc' => esc_html_x('Use to manage / upload images.', 'theme-options', 'zass'),
			'id' => 'supersized_images',
			'std' => '',
			'type' => 'zass_upload',
			'is_multiple' => true
	);
	/*
	 * If Woocommerce is activated show the shop options
	 */
	if (defined('ZASS_IS_WOOCOMMERCE') && ZASS_IS_WOOCOMMERCE) {
		/*
		 * SHOP
		 */
		$options[] = array(
				'name' => esc_html_x('Shop', 'theme-options', 'zass'),
				'type' => 'heading',
		);
		$options[] = array(
				'name' => esc_html_x('Shop Page Header Style', 'theme-options', 'zass'),
				'desc' => esc_html_x('Choose the header style for the page set as Shop page.', 'theme-options', 'zass'),
				'id' => 'shop_header_style',
				'std' => '',
				'type' => 'select',
				'class' => '', //mini, tiny, small
				'options' => $header_style_list
		);
		$options[] = array(
				'name' => esc_html_x('Shop Page Top Menu', 'theme-options', 'zass'),
				'desc' => esc_html_x('Choose top menu for the shop page.', 'theme-options', 'zass'),
				'id' => 'shop_top_menu',
				'std' => 'default',
				'type' => 'select',
				'class' => '', //mini, tiny, small
				'options' => $choose_menu_options
		);
		$options[] = array(
				'name' => esc_html_x('Subtitle', 'theme-options', 'zass'),
				'desc' => esc_html_x('Subtitle for shop page.', 'theme-options', 'zass'),
				'id' => 'shop_subtitle',
				'std' => '',
				'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('Title with Image Background on Shop Page', 'theme-options', 'zass'),
				'desc' => esc_html_x('Use image background for title on shop page.', 'theme-options', 'zass'),
				'id' => 'show_shop_title_background',
				'std' => 0,
				'type' => 'checkbox'
		);
		$options[] = array(
				'desc' => esc_html_x('Use to manage / upload images.', 'theme-options', 'zass'),
				'id' => 'shop_title_background_imgid',
				'std' => '',
				'type' => 'zass_upload',
				'is_multiple' => false
		);
		$options[] = array(
				'desc' => esc_html_x('Title alignment.', 'theme-options', 'zass'),
				'id' => 'shop_title_alignment',
				'std' => 'none',
				'type' => 'select',
				'options' => array(
						'left_title' => esc_html_x('Left', 'theme-options', 'zass'),
						'centered_title' => esc_html_x('Center', 'theme-options', 'zass'),
				)
		);
		$options[] = array(
				'name' => esc_html_x('Show Refine Products Area', 'theme-options', 'zass'),
				'desc' => esc_html_x('Show the area with price range and sorting options on product archives', 'theme-options', 'zass'),
				'id' => 'show_refine_area',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
			'name' => esc_html_x('Show "My Account" Icon', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose whether to display "My Account" icon link in header.', 'theme-options', 'zass'),
			'id' => 'show_my_account',
			'std' => 1,
			'type' => 'checkbox'
		);
		$options[] = array(
			'name' => esc_html_x('My Account Page Display Style', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose the style of the My Account page.', 'theme-options', 'zass'),
			'id' => 'my_account_display_style',
			'std' => 'carousel',
			'type' => 'select',
			'options' => array(
				'carousel' => esc_html_x('Carousel', 'theme-options', 'zass'),
				'standard' => esc_html_x('Standard', 'theme-options', 'zass')
			)
		);
		$options[] = array(
				'name' => esc_html_x('Show Shopping Cart', 'theme-options', 'zass'),
				'desc' => esc_html_x('Choose whether to display shopping cart in header.', 'theme-options', 'zass'),
				'id' => 'show_shopping_cart',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
			'name' => esc_html_x('Enable AJAX Add to Cart on Single Product Pages', 'theme-options', 'zass'),
			'desc' => esc_html_x('Use AJAX when adding product to cart on single product pages.', 'theme-options', 'zass'),
			'id' => 'ajax_to_cart_single',
			'std' => 1,
			'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Add to Cart Color', 'theme-options', 'zass'),
				'desc' => esc_html_x('Set color for "Add to Cart" button on products.', 'theme-options', 'zass'),
				'id' => 'add_to_cart_color',
				'std' => '#f3a395',
				'type' => 'color'
		);
		$options[] = array(
				'name' => esc_html_x('Add to Cart Sound', 'theme-options', 'zass'),
				'desc' => esc_html_x('Play sound notification when product is added to shopping cart.', 'theme-options', 'zass'),
				'id' => 'add_to_cart_sound',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Wishlist Counter in Header', 'theme-options', 'zass'),
				'desc' => esc_html_x('Display wishlist counter in header.', 'theme-options', 'zass'),
				'id' => 'show_wish_in_header',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Enable Product Quickview', 'theme-options', 'zass'),
				'desc' => esc_html_x('Enable Quick view on product listings.', 'theme-options', 'zass'),
				'id' => 'use_quickview',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
			'name'    => esc_html_x( 'Category Description Position', 'theme-options', 'zass' ),
			'desc'    => esc_html_x( 'Choose position for category description.', 'theme-options', 'zass' ),
			'id'      => 'category_description_position',
			'std'     => '',
			'type'    => 'select',
			'class'   => 'mini', //mini, tiny, small
			'options' => array( '' => esc_html_x( 'Top', 'theme-options', 'zass' ),
			                    'zass-bottom-description' => esc_html_x( 'Bottom', 'theme-options', 'zass')
			)
		);
		$options[] = array(
			'name'    => esc_html_x( 'Hover Product Behaviour on Product List', 'theme-options', 'zass' ),
			'desc'    => esc_html_x( 'Choose hover behaviour for product listing.', 'theme-options', 'zass' ),
			'id'      => 'product_hover_onproduct',
			'std'     => 'zass-prodhover-swap',
			'type'    => 'select',
			'class'   => 'mini', //mini, tiny, small
			'options' => array( 'zass-prodhover-zoom' => esc_html_x( 'Zoom', 'theme-options', 'zass' ),
			                    'zass-prodhover-swap' => esc_html_x( 'Image Swap', 'theme-options', 'zass'),
			                    'none'                => esc_html_x( 'No Effect', 'theme-options', 'zass' )
			)
		);
		$options[] = array(
				'name' => esc_html_x('Enable Products Hover Effect (Fade)', 'theme-options', 'zass'),
				'desc' => esc_html_x('When hovering over a product in product list fade rest of the products.', 'theme-options', 'zass'),
				'id' => 'products_hover',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Enable Carousel for Shop Categories', 'theme-options', 'zass'),
				'desc' => esc_html_x('Enable carousel effect for the listed categories on shop pages (If categories are enabled from WooCommerce settings).', 'theme-options', 'zass'),
				'id' => 'enable_shop_cat_carousel',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Columns Number for Shop Categories', 'theme-options', 'zass'),
				'desc' => esc_html_x('Select the number of columns for the listed categories on shop pages (If categories are enabled from WooCommerce settings).', 'theme-options', 'zass'),
				'id' => 'category_columns_num',
				'std' => '3',
				'type' => 'select',
				'class' => 'mini', //mini, tiny, small
				'options' => array(2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6)
		);
		$options[] = array(
				'name' => esc_html_x('Shop Pages Default Product Columns', 'theme-options', 'zass'),
				'desc' => esc_html_x('Select the default number of product columns on shop/category pages.', 'theme-options', 'zass'),
				'id' => 'shop_default_product_columns',
				'std' => 'zass-products-list-view',
				'type' => 'select',
				'class' => 'mini', //mini, tiny, small
				'options' => $shop_default_product_columns_values
		);
		$options[] = array(
			'name' => esc_html_x('Number of Products per Page', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set the number of products per page for product listings, like shop and product category pages.', 'theme-options', 'zass'),
			'id' => 'products_per_page',
			'std' => 12,
			'class' => 'mini',
			'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('Number of Related Products', 'theme-options', 'zass'),
				'desc' => esc_html_x('Set the number of related products shown on single product page. Set to -1 to display all.', 'theme-options', 'zass'),
				'id' => 'number_related_products',
				'std' => 5,
				'class' => 'mini',
				'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('Show Sidebar on Shop Page', 'theme-options', 'zass'),
				'desc' => esc_html_x('Show sidebar on Shop and category pages.', 'theme-options', 'zass'),
				'id' => 'show_sidebar_shop',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Show Sidebar on Product Pages', 'theme-options', 'zass'),
				'desc' => esc_html_x('Show sidebar on product pages.', 'theme-options', 'zass'),
				'id' => 'show_sidebar_product',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Enable Price Filter on Product Categories', 'theme-options', 'zass'),
				'desc' => esc_html_x('Show Price Filter.', 'theme-options', 'zass'),
				'id' => 'show_pricefilter',
				'class' => 'expandable_option',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
			'name' => esc_html_x('Price Filter Slider Step', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set the step at which the slider changes and rounds min and max price boundaries.', 'theme-options', 'zass'),
			'id' => 'price_filter_widget_step',
			'std' => 10,
			'class' => 'mini show_pricefilter',
			'type' => 'text'
		);
		$options[] = array(
			'name' => esc_html_x('Enable Product Per Page on Product Categories', 'theme-options', 'zass'),
			'desc' => esc_html_x('Limit products on product category pages.', 'theme-options', 'zass'),
			'id' => 'show_products_limit',
			'std' => 1,
			'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Use Countdown on Sales', 'theme-options', 'zass'),
				'desc' => esc_html_x('Show countdown meter for products on sale.', 'theme-options', 'zass'),
				'id' => 'use_countdown',
				'std' => 'enabled',
				'type' => 'select',
				'class' => 'mini', //mini, tiny, small
				'options' => $enable_disable_array
		);
		$options[] = array(
				'name' => esc_html_x('"NEW" Label Active Period', 'theme-options', 'zass'),
				'desc' => esc_html_x('in Days', 'theme-options', 'zass'),
				'id' => 'new_label_period',
				'std' => 45,
				'type' => 'select',
				'class' => 'mini', //mini, tiny, small
				'options' => $new_label_period_array
		);
		$options[] = array(
				'name' => esc_html_x('Cloud Zoom Settings', 'theme-options', 'zass'),
				'desc' => esc_html_x('Select to enable Cloud Zoom on Single product gallery.', 'theme-options', 'zass'),
				'id' => 'cloud_zoom',
				'std' => $cloudzoom_multicheck_defaults, // These items get checked by default
				'type' => 'multicheck',
				'options' => $cloudzoom_multicheck_vals
		);
		// Video background
		$options[] = array(
				'name' => esc_html_x('Enable YouTube video background for Shop page.', 'theme-options', 'zass'),
				'desc' => esc_html_x('Check to enable below youtube video to be set as background on the Shop page.', 'theme-options', 'zass'),
				'id' => 'show_shop_video_bckgr',
				'std' => 0,
				'type' => 'checkbox'
		);
		$options[] = array(
				'desc' => esc_html_x('Enable the video background for the whole shop area. NOTE: It will override all other video backgrounds in the shop area.', 'theme-options', 'zass'),
				'id' => 'shopwide_video_bckgr',
				'std' => '0',
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('YouTube Video URL', 'theme-options', 'zass'),
				'desc' => esc_html_x('Paste the YouTube URL.', 'theme-options', 'zass'),
				'id' => 'shop_video_bckgr_url',
				'std' => '',
				'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('Start Time', 'theme-options', 'zass'),
				'desc' => esc_html_x('Set the seconds the video should start at.', 'theme-options', 'zass'),
				'id' => 'shop_video_bckgr_start',
				'class' => 'mini',
				'std' => '',
				'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('End Time', 'theme-options', 'zass'),
				'desc' => esc_html_x('Set the seconds the video should stop at.', 'theme-options', 'zass'),
				'id' => 'shop_video_bckgr_end',
				'class' => 'mini',
				'std' => '',
				'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('Loop', 'theme-options', 'zass'),
				'desc' => esc_html_x('Loops the movie once ended.', 'theme-options', 'zass'),
				'id' => 'shop_video_bckgr_loop',
				'std' => 1,
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Mute', 'theme-options', 'zass'),
				'desc' => esc_html_x('Mute the audio.', 'theme-options', 'zass'),
				'id' => 'shop_video_bckgr_mute',
				'std' => 1,
				'type' => 'checkbox'
		);
		// Supersized
		$options[] = array(
				'name' => esc_html_x('Enable supersized slider on Shop page.', 'theme-options', 'zass'),
				'desc' => esc_html_x('Check to enable below slider to be set as background on the Shop page.', 'theme-options', 'zass'),
				'id' => 'show_shop_super_gallery',
				'std' => '0',
				'type' => 'checkbox'
		);
		$options[] = array(
				'desc' => esc_html_x('Enable the slider for the whole shop area. NOTE: It will override all other supersized sliders in the shop area.', 'theme-options', 'zass'),
				'id' => 'shopwide_super_gallery',
				'std' => '0',
				'type' => 'checkbox'
		);
		$options[] = array(
				'name' => esc_html_x('Choose images for the Shop page supersized slider.', 'theme-options', 'zass'),
				'desc' => esc_html_x('Use to manage / upload images.', 'theme-options', 'zass'),
				'id' => 'shop_supersized_images',
				'std' => '',
				'type' => 'zass_upload',
				'is_multiple' => true
		);
	}
	/*
	 * If The Events Calendar is activated show the Events options
	 */
	if (defined('ZASS_IS_EVENTS') && ZASS_IS_EVENTS) {
		/*
		 * EVENTS
		 */
		$options[] = array(
			'name' => esc_html_x('Events', 'theme-options', 'zass'),
			'type' => 'heading',
		);
		$options[] = array(
			'desc' => esc_html_x('Options specific to The Events Calendar plugin.', 'theme-options', 'zass'),
			'type' => 'info'
		);
		$options[] = array(
			'name' => esc_html_x('Top Menu for Events Category View Pages', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose top menu for the Main Calendar Page, Calendar Category Pages, Main Events List, Category Events List.', 'theme-options', 'zass'),
			'id' => 'events_top_menu',
			'std' => 'default',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $choose_menu_options
		);
		$options[] = array(
			'name' => esc_html_x('Header Style for Events Category View Pages', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose the header style for Main Calendar Page, Calendar Category Pages, Main Events List, Category Events List.', 'theme-options', 'zass'),
			'id' => 'events_header_style',
			'std' => '',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $header_style_list
		);
		$options[] = array(
			'name' => esc_html_x('Events Title', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enter the title for Main Calendar Page, Main Events List. Use empty for default.', 'theme-options', 'zass'),
			'id' => 'events_title',
			'std' => '',
			'type' => 'text'
		);
		$options[] = array(
			'name' => esc_html_x('Events Subtitle', 'theme-options', 'zass'),
			'desc' => esc_html_x('Subtitle for Main Calendar Page, Main Events List.', 'theme-options', 'zass'),
			'id' => 'events_subtitle',
			'std' => '',
			'type' => 'text'
		);
		$options[] = array(
			'name' => esc_html_x('Title with Image Background for Events', 'theme-options', 'zass'),
			'desc' => esc_html_x('Use image background for title on Main Calendar Page, Calendar Category Pages, Main Events List, Category Events List.', 'theme-options', 'zass'),
			'id' => 'show_events_title_background',
			'std' => 0,
			'type' => 'checkbox'
		);
		$options[] = array(
			'desc' => esc_html_x('Use to manage / upload images', 'theme-options', 'zass'),
			'id' => 'events_title_background_imgid',
			'std' => '',
			'type' => 'zass_upload',
			'is_multiple' => false
		);
		$options[] = array(
			'desc' => esc_html_x('Title alignment', 'theme-options', 'zass'),
			'id' => 'events_title_alignment',
			'std' => 'none',
			'type' => 'select',
			'options' => array(
				'left_title' => esc_html_x('Left', 'theme-options', 'zass'),
				'centered_title' => esc_html_x('Center', 'theme-options', 'zass'),
			)
		);
		$options[] = array(
			'name' => esc_html_x('Use Countdown on Events', 'theme-options', 'zass'),
			'desc' => esc_html_x('Show countdown meter for starting time for an Event. Visible on single event pages.', 'theme-options', 'zass'),
			'id' => 'event_use_countdown',
			'std' => 1,
			'type' => 'checkbox'
		);
	}
	/*
	 * If bbPress is activated show the forum options
	 */
	if (defined('ZASS_IS_BBPRESS') && ZASS_IS_BBPRESS) {
		/*
		 * bbPress
		 */
		$options[] = array(
				'name' => esc_html_x('bbPress', 'theme-options', 'zass'),
				'type' => 'heading',
		);
		$options[] = array(
				'name' => esc_html_x('Header Style for Forum Root Page', 'theme-options', 'zass'),
				'desc' => esc_html_x('Choose the header style for the forum root page.', 'theme-options', 'zass'),
				'id' => 'forum_header_style',
				'std' => '',
				'type' => 'select',
				'class' => '', //mini, tiny, small
				'options' => $header_style_list
		);
		$options[] = array(
				'name' => esc_html_x('Forum Root Page Top Menu', 'theme-options', 'zass'),
				'desc' => esc_html_x('Choose top menu for the forum root page.', 'theme-options', 'zass'),
				'id' => 'forum_top_menu',
				'std' => 'default',
				'type' => 'select',
				'class' => '', //mini, tiny, small
				'options' => $choose_menu_options
		);
		$options[] = array(
				'name' => esc_html_x('Subtitle', 'theme-options', 'zass'),
				'desc' => esc_html_x('Subtitle for Forum Root Page.', 'theme-options', 'zass'),
				'id' => 'forum_subtitle',
				'std' => '',
				'type' => 'text'
		);
		$options[] = array(
				'name' => esc_html_x('Title with Image Background on Forum Root Page', 'theme-options', 'zass'),
				'desc' => esc_html_x('Use image background for title.', 'theme-options', 'zass'),
				'id' => 'show_forum_title_background',
				'std' => 0,
				'type' => 'checkbox'
		);
		$options[] = array(
				'desc' => esc_html_x('Use to manage / upload images.', 'theme-options', 'zass'),
				'id' => 'forum_title_background_imgid',
				'std' => '',
				'type' => 'zass_upload',
				'is_multiple' => false
		);
		$options[] = array(
				'desc' => esc_html_x('Title alignment.', 'theme-options', 'zass'),
				'id' => 'forum_title_alignment',
				'std' => 'none',
				'type' => 'select',
				'options' => array(
						'left_title' => esc_html_x('Left', 'theme-options', 'zass'),
						'centered_title' => esc_html_x('Center', 'theme-options', 'zass'),
				)
		);
	}
	/*
	 * BLOG
	 */
	$options[] = array(
			'name' => esc_html_x('Blog', 'theme-options', 'zass'),
			'type' => 'heading',
	);
	$options[] = array(
			'name' => esc_html_x('Blog Style', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose how the posts will appear on the Blog.', 'theme-options', 'zass'),
			'id' => 'general_blog_style',
			'std' => 'standard',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $general_blog_style_values
	);
	$options[] = array(
			'name' => esc_html_x('Top Menu for Blog page', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose top menu for Blog page.', 'theme-options', 'zass'),
			'id' => 'blog_top_menu',
			'std' => 'default',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $choose_menu_options
	);
	$options[] = array(
			'name' => esc_html_x('Header Style for Blog page, Category, Tags and Search', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose the header style for Blog page, Category, Tags and Search.', 'theme-options', 'zass'),
			'id' => 'blog_header_style',
			'std' => '',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $header_style_list
	);
	$options[] = array(
			'name' => esc_html_x('Show Title on the Blog page.', 'theme-options', 'zass'),
			'desc' => esc_html_x('If selected, the page set as Blog page will have its title displayed.', 'theme-options', 'zass'),
			'id' => 'show_blog_title',
			'std' => '1',
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Blog Title', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enter the title of the Blog page as set up in the Settings->Reading.', 'theme-options', 'zass'),
			'id' => 'blog_title',
			'std' => 'Blog',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Blog Subtitle', 'theme-options', 'zass'),
			'desc' => esc_html_x('Subtitle for blog page.', 'theme-options', 'zass'),
			'id' => 'blog_subtitle',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Title with Image Background on Blog page, Category, Tags and Search', 'theme-options', 'zass'),
			'desc' => esc_html_x('Use image background for title on Blog page, Category, Tags and Search.', 'theme-options', 'zass'),
			'id' => 'show_blog_title_background',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'desc' => esc_html_x('Use to manage / upload images', 'theme-options', 'zass'),
			'id' => 'blog_title_background_imgid',
			'std' => '',
			'type' => 'zass_upload',
			'is_multiple' => false
	);
	$options[] = array(
			'desc' => esc_html_x('Title alignment', 'theme-options', 'zass'),
			'id' => 'blog_title_alignment',
			'std' => 'none',
			'type' => 'select',
			'options' => array(
					'left_title' => esc_html_x('Left', 'theme-options', 'zass'),
					'centered_title' => esc_html_x('Center', 'theme-options', 'zass'),
			)
	);
	$options[] = array(
			'name' => esc_html_x('Show Related Posts', 'theme-options', 'zass'),
			'desc' => esc_html_x('Display random posts from the same categories on single post page.', 'theme-options', 'zass'),
			'id' => 'show_related_posts',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
		'name' => esc_html_x('Number of Related Posts', 'theme-options', 'zass'),
		'desc' => esc_html_x('Set the number of related posts shown on single post page. Set to -1 to display all.', 'theme-options', 'zass'),
		'id' => 'number_related_posts',
		'std' => 6,
		'class' => 'mini',
		'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Show Author Info on Blog Posts', 'theme-options', 'zass'),
			'desc' => esc_html_x('If selected, Author section will be displayed below the post.', 'theme-options', 'zass'),
			'id' => 'show_author_info',
			'std' => '1',
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Show Author Avatar', 'theme-options', 'zass'),
			'desc' => esc_html_x('If selected, Author avatar will be displayed on posts.', 'theme-options', 'zass'),
			'id' => 'show_author_avatar',
			'std' => '1',
			'type' => 'checkbox'
	);
	// Video background
	$options[] = array(
			'name' => esc_html_x('Enable YouTube video background for Blog page', 'theme-options', 'zass'),
			'desc' => esc_html_x('Check to enable below youtube video to be set as background on the Blog page.', 'theme-options', 'zass'),
			'id' => 'show_blog_video_bckgr',
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('YouTube Video URL', 'theme-options', 'zass'),
			'desc' => esc_html_x('Paste the YouTube URL.', 'theme-options', 'zass'),
			'id' => 'blog_video_bckgr_url',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Start Time', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set the seconds the video should start at.', 'theme-options', 'zass'),
			'id' => 'blog_video_bckgr_start',
			'class' => 'mini',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('End Time', 'theme-options', 'zass'),
			'desc' => esc_html_x('Set the seconds the video should stop at.', 'theme-options', 'zass'),
			'id' => 'blog_video_bckgr_end',
			'class' => 'mini',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Loop', 'theme-options', 'zass'),
			'desc' => esc_html_x('Loops the movie once ended.', 'theme-options', 'zass'),
			'id' => 'blog_video_bckgr_loop',
			'std' => 1,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Mute', 'theme-options', 'zass'),
			'desc' => esc_html_x('Mute the audio.', 'theme-options', 'zass'),
			'id' => 'blog_video_bckgr_mute',
			'std' => 1,
			'type' => 'checkbox'
	);
	// Supersized
	$options[] = array(
			'name' => esc_html_x('Enable Supersized Slider on Blog Page', 'theme-options', 'zass'),
			'desc' => esc_html_x('Check to enable below slider to be set as background on the Blog page.', 'theme-options', 'zass'),
			'id' => 'show_blog_super_gallery',
			'std' => '0',
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Choose images for the Blog page supersized slider', 'theme-options', 'zass'),
			'desc' => esc_html_x('Use to manage / upload images.', 'theme-options', 'zass'),
			'id' => 'blog_supersized_images',
			'std' => '',
			'type' => 'zass_upload',
			'is_multiple' => true
	);
	/*
	 * SIDEBARS
	 */
	$options[] = array(
			'name' => esc_html_x('Sidebars', 'theme-options', 'zass'),
			'type' => 'heading',
	);
	$options[] = array(
			'name' => esc_html_x('Sidebars Default Position', 'theme-options', 'zass'),
			'desc' => esc_html_x('Choose sitewide sidebars position. Can be changed in page/post edit.', 'theme-options', 'zass'),
			'id' => 'sidebar_position',
			'std' => '',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => array(
					'zass-right-sidebar' => esc_html_x('Right', 'theme-options', 'zass'),
					'zass-left-sidebar' => esc_html_x('Left', 'theme-options', 'zass')
			)
	);
	$options[] = array(
			'name' => esc_html_x('Create new custom sidebar', 'theme-options', 'zass'),
			'desc' => esc_html_x('Enter the name of the custom sidebar.', 'theme-options', 'zass'),
			'id' => 'sidebar_ids',
			'std' => '',
			'type' => 'sidebar'
	);
	$options[] = array(
			'name' => esc_html_x('Sidebar for Blog, Archive and Category Pages', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select sidebar to be displayed on Blog page and all post category, tag and search pages.', 'theme-options', 'zass'),
			'id' => 'blog_categoty_sidebar',
			'std' => 'none',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $registered_sidebars_array
	);
	$options[] = array(
			'name' => esc_html_x('Sidebar for Portfolio Archive and Category Pages', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select sidebar to be displayed on all Portfolio Archive and Category Pages.', 'theme-options', 'zass'),
			'id' => 'portfolio_categoty_sidebar',
			'std' => 'none',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $registered_sidebars_array
	);
	if (defined('ZASS_IS_WOOCOMMERCE') && ZASS_IS_WOOCOMMERCE) {
		$default_shop_sdbr = 'none';
		if (array_key_exists('shop', $registered_sidebars_array)) {
			$default_shop_sdbr = 'shop';
		}
		$options[] = array(
				'name' => esc_html_x('Sidebar for WooCommerce part', 'theme-options', 'zass'),
				'desc' => esc_html_x('Select sidebar to be displayed on all WooCommerce pages that can have sidebar', 'theme-options', 'zass'),
				'id' => 'woocommerce_sidebar',
				'std' => $default_shop_sdbr,
				'type' => 'select',
				'class' => '', //mini, tiny, small
				'options' => $registered_sidebars_array
		);
	}
	if (defined('ZASS_IS_BBPRESS') && ZASS_IS_BBPRESS) {
		$default_forum_sdbr = 'none';
		if (array_key_exists('zass_forum', $registered_sidebars_array)) {
			$default_forum_sdbr = 'zass_forum';
		}
		$options[] = array(
				'name' => esc_html_x('Sidebar for bbPress part', 'theme-options', 'zass'),
				'desc' => esc_html_x('Select sidebar to be displayed by default on all bbPress pages. May be overridden on specific forums and topics.', 'theme-options', 'zass'),
				'id' => 'bbpress_sidebar',
				'std' => $default_forum_sdbr,
				'type' => 'select',
				'class' => '', //mini, tiny, small
				'options' => $registered_sidebars_array
		);
	}
	if (defined('ZASS_IS_EVENTS') && ZASS_IS_EVENTS) {
		$default_events_sdbr = 'none';
		if (array_key_exists('right_sidebar', $registered_sidebars_array)) {
			$default_events_sdbr = 'right_sidebar';
		}
		$options[] = array(
			'name' => esc_html_x('Sidebar for Events Calendar part', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select sidebar to be displayed by default on all Events Calendar pages. May be overridden on specific Events.', 'theme-options', 'zass'),
			'id' => 'events_sidebar',
			'std' => $default_events_sdbr,
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $registered_sidebars_array
		);
	}
	$options[] = array(
			'name' => esc_html_x('Off Canvas Sidebar', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select sidebar to be displayed off canvas.', 'theme-options', 'zass'),
			'id' => 'offcanvas_sidebar',
			'std' => 'none',
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $registered_sidebars_array
	);
	$default_footer_sdbr = 'bottom_footer_sidebar';
	$options[] = array(
			'name' => esc_html_x('Footer Sidebar', 'theme-options', 'zass'),
			'desc' => esc_html_x('Select sidebar to be displayed in footer. May be overriden for the specific pages, posts and custom post types.', 'theme-options', 'zass'),
			'id' => 'footer_sidebar',
			'std' => $default_footer_sdbr,
			'type' => 'select',
			'class' => '', //mini, tiny, small
			'options' => $registered_sidebars_array
	);

	/*
	 * Social profiles settings
	 */
	$options[] = array(
			'name' => esc_html_x('Social Profiles', 'theme-options', 'zass'),
			'type' => 'heading'
	);
	$options[] = array(
			'desc' => esc_html_x('Fill in your social profiles URLs and select where to appear.', 'theme-options', 'zass'),
			'type' => 'info'
	);
	$options[] = array(
			'name' => esc_html_x('Show in Header', 'theme-options', 'zass'),
			'id' => 'social_in_header',
			'desc' => esc_html_x('Show profiles in header.', 'theme-options', 'zass'),
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Show in Footer', 'theme-options', 'zass'),
			'id' => 'social_in_footer',
			'desc' => esc_html_x('Show profiles in footer.', 'theme-options', 'zass'),
			'std' => 0,
			'type' => 'checkbox'
	);
	$options[] = array(
			'name' => esc_html_x('Facebook Profile URL', 'theme-options', 'zass'),
			'id' => 'facebook_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Twitter Profile URL', 'theme-options', 'zass'),
			'id' => 'twitter_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Google+ Profile URL', 'theme-options', 'zass'),
			'id' => 'google_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('YouTube Profile URL', 'theme-options', 'zass'),
			'id' => 'youtube_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Vimeo Profile URL', 'theme-options', 'zass'),
			'id' => 'vimeo_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Dribbble Profile URL', 'theme-options', 'zass'),
			'id' => 'dribbble_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('LinkedIn Profile URL', 'theme-options', 'zass'),
			'id' => 'linkedin_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('StumbleUpon Profile URL', 'theme-options', 'zass'),
			'id' => 'stumbleupon_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Flickr Profile URL', 'theme-options', 'zass'),
			'id' => 'flicker_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Instagram Profile URL', 'theme-options', 'zass'),
			'id' => 'instegram_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Pinterest Profile URL', 'theme-options', 'zass'),
			'id' => 'pinterest_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('VKontakte Profile URL', 'theme-options', 'zass'),
			'id' => 'vkontakte_profile',
			'std' => '',
			'type' => 'text'
	);
	$options[] = array(
			'name' => esc_html_x('Behance Profile URL', 'theme-options', 'zass'),
			'id' => 'behance_profile',
			'std' => '',
			'type' => 'text'
	);
	/*
	 * Demo import
	 */
	$options[] = array(
			'name' => esc_html_x('Import Demo', 'theme-options', 'zass'),
			'type' => 'heading',
	);
	$options[] = array(
			'desc' => '<p><b>' . esc_html__('NOTE THAT THE IMPORT CAN OVERRIDE YOUR DATA AND SETTINGS.', 'zass') . '</b></p>' . sprintf(_x("<p><b>Make sure that the required plugins for the corresponding import are installed and activated.</b></p><p>Note also that the demos are using many images and takes longer to import. You may need to increase some of the PHP parameters, described here: %s . If for some reason is not possible to increase <i>max_execution_time</i> and still can't run the import, you may need to run it again, in order to import all the images.</p><p><b>Click the image of the desired demo to import.</b>The import can take several minutes. For best result use fresh WP installation.</p><p>You can use following plugin to reset WordPress: %s .</p>", 'theme-options', 'zass'), '<a href="http://althemist.com/are-you-sure-you-want-to-do-this/" target="_blank">Recommended settings for successfull import</a>', '<a href="https://wordpress.org/plugins/wordpress-reset/" target="_blank">WordPress Reset</a>'),
			'type' => 'info'
	);
	$options[] = array(
			'name' => esc_html_x('Import Zass Demo', 'theme-options', 'zass'),
			'desc' => sprintf(_x("<p><b>Demo Location:</b> %s <br/><b>NOTE:</b> Usually takes less than 3 minutes, but depending on the server it may take up to 10.</p><p><b>Required plugins for the import:</b><br/><b><a target=\"_blank\" href=\"https://wordpress.org/plugins/woocommerce/\">WooCommerce</a></b></p>", 'theme-options', 'zass'), '<a target="_blank" href="https://althemist.com/zass/" >Zass Demo</a>'),
			'id' => 'import_zass0',
			'type' => 'images',
			'class' => 'import_zass_demo',
			'options' => array(
					'zass' => ZASS_IMAGES_PATH . 'demo-image0.jpg'
			)
	);
	$options[] = array(
			'name' => esc_html_x('Import Zass Marketplace Demo', 'theme-options', 'zass'),
			'desc' => sprintf(_x("<p><b>Demo Location:</b> %s <br/><b>NOTE:</b> Usually takes less than 3 minutes, but depending on the server it may take up to 10.</p><p><b>Required plugins for the import:</b><br/><b><a target=\"_blank\" href=\"https://wordpress.org/plugins/woocommerce/\">WooCommerce</a></b><br/><b><a target=\"_blank\" href=\"https://wordpress.org/plugins/dc-woocommerce-multi-vendor/\">WC Marketplace</a></b><br/></p>", 'theme-options', 'zass'), '<a target="_blank" href="https://althemist.com/zassmarketplace/" >Zass Marketplace Demo</a>'),
			'id' => 'import_zass1',
			'type' => 'images',
			'class' => 'import_zass_demo',
			'options' => array(
					'zass' => ZASS_IMAGES_PATH . 'demo-image1.jpg'
			)
	);


	/*
	 * Zass Updates
	 */
	$options[] = array(
		'name' => esc_html_x('Zass Updates', 'theme-options', 'zass'),
		'type' => 'heading',
		'tab_id' => 'zassupdates'
	);

	if(defined('ZASS_IS_ENVATO_MARKET') && ZASS_IS_ENVATO_MARKET) {
		$options[] = array(
			'desc' => '<p>' . esc_html__( 'Zass automatic updates are managed by the Envato Market plugin (bundled with the theme).', 'zass' ) . '</p>' .
			          '<p><a class="zass-theme-updates" href="' . esc_url( admin_url( 'admin.php?page=envato-market' ) ) . '">' . esc_html_x( 'Manage your Envato purchased items', 'theme-options', 'zass' ) . '</a></p>',
			'type' => 'info'
		);
	} else {
		$options[] = array(
			'desc' => '<p>' . esc_html__( 'Zass automatic updates are managed by the Envato Market plugin (bundled with the theme).', 'zass' ) . '</p><p>' .
			          esc_html_x( 'Please install and activate "Envato Market" in order to manage all your WordPress themes and plugins purchased from Envato.', 'theme-options', 'zass' ) .
			          '</p><p><a class="zass-theme-updates" href="' . esc_url( admin_url( 'admin.php?page=tgmpa-install-plugins' ) ) . '">' . esc_html_x( 'Install/Activate Envato Market plugin', 'theme-options', 'zass' ) . '</a></p>',
			'type' => 'info'
		);
	}

	return $options;
}
