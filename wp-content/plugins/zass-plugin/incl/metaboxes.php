<?php

/**
 * Register page layout metaboxes
 */
add_action('add_meta_boxes', 'zass_add_layout_metabox');
add_action('save_post', 'zass_save_layout_postdata');

/* Adds a box to the side column on the Page edit screens */
if (!function_exists('zass_add_layout_metabox')) {

	function zass_add_layout_metabox() {

		$posttypes = array('page', 'post', 'zass-portfolio');
		if (ZASS_PLUGIN_IS_WOOCOMMERCE) {
			$posttypes[] = 'product';
		}
		if (ZASS_PLUGIN_IS_BBPRESS) {
			$posttypes[] = 'forum';
			$posttypes[] = 'topic';
		}
		if(post_type_exists('tribe_events')) {
			$posttypes[] = 'tribe_events';
		}

		foreach ($posttypes as $pt) {
			add_meta_box(
							'zass_layout', esc_html__('Page Layout Options', 'zass-plugin'), 'zass_layout_callback', $pt, 'side'
			);
		}
	}

}

/* Prints the box content */
if (!function_exists('zass_layout_callback')) {

	function zass_layout_callback($post) {
		// If current page is set as Blog page - don't show the options
		if ($post->ID == get_option('page_for_posts')) {
			echo esc_html__("Page Layout Options is disabled for this page, because the page is set as Blog page from Settings->Reading.", 'zass-plugin');
			return;
		}

		// If current page is set as Shop page - don't show the options
		if (ZASS_PLUGIN_IS_WOOCOMMERCE && $post->ID == wc_get_page_id('shop')) {
			echo esc_html__("Page Layout Options is disabled for this page, because the page is set as Shop page.", 'zass-plugin');
			return;
		}

		// Use nonce for verification
		wp_nonce_field('zass_save_layout_postdata', 'layout_nonce');

		$custom = get_post_custom($post->ID);

		// Set default values
		$values = array(
				'zass_override_default_layout' => 0,
				'zass_layout' => 'zass_fullwidth',
				'zass_top_header' => 'default',
				'zass_footer_style' => 'default',
				'zass_footer_size' => 'default',
				'zass_header_size' => 'default',
				'zass_header_syle' => '',
				'zass_page_subtitle' => '',
				'zass_title_background' => 0,
				'zass_title_background_imgid' => '',
				'zass_title_alignment' => 'left_title'
		);

		if (isset($custom['zass_override_default_layout']) && $custom['zass_override_default_layout'][0] != '') {
			$values['zass_override_default_layout'] = esc_attr($custom['zass_override_default_layout'][0]);
		}
		if (isset($custom['zass_layout']) && $custom['zass_layout'][0] != '') {
			$values['zass_layout'] = esc_attr($custom['zass_layout'][0]);
		}
		if (isset($custom['zass_top_header']) && $custom['zass_top_header'][0] != '') {
			$values['zass_top_header'] = esc_attr($custom['zass_top_header'][0]);
		}
		if (isset($custom['zass_footer_style']) && $custom['zass_footer_style'][0] != '') {
			$values['zass_footer_style'] = esc_attr($custom['zass_footer_style'][0]);
		}
		if (isset($custom['zass_footer_size']) && $custom['zass_footer_size'][0] != '') {
			$values['zass_footer_size'] = esc_attr($custom['zass_footer_size'][0]);
		}
		if (isset($custom['zass_header_size']) && $custom['zass_header_size'][0] != '') {
			$values['zass_header_size'] = esc_attr($custom['zass_header_size'][0]);
		}
		if (isset($custom['zass_header_syle']) && $custom['zass_header_syle'][0] != '') {
			$values['zass_header_syle'] = esc_attr($custom['zass_header_syle'][0]);
		}
		if (isset($custom['zass_page_subtitle']) && $custom['zass_page_subtitle'][0] != '') {
			$values['zass_page_subtitle'] = esc_attr($custom['zass_page_subtitle'][0]);
		}
		if (isset($custom['zass_title_background']) && $custom['zass_title_background'][0] != '') {
			$values['zass_title_background'] = esc_attr($custom['zass_title_background'][0]);
		}
		if (isset($custom['zass_title_background_imgid']) && $custom['zass_title_background_imgid'][0] != '') {
			$values['zass_title_background_imgid'] = esc_attr($custom['zass_title_background_imgid'][0]);
		}
		if (isset($custom['zass_title_alignment']) && $custom['zass_title_alignment'][0] != '') {
			$values['zass_title_alignment'] = esc_attr($custom['zass_title_alignment'][0]);
		}

		// description
		$output = '<p>' . esc_html__("You can define layout specific options here.", 'zass-plugin') . '</p>';

		// Override
		$output .= '<p><b>' . esc_html__("Full width or boxed layout", 'zass-plugin') . '</b></p>';
		$output .= '<p><label for="zass_override_default_layout">';
		$output .= "<input type='checkbox' id='zass_override_default_layout' name='zass_override_default_layout' value='1' " . checked(esc_attr($values['zass_override_default_layout']), 1, false) . ">" . esc_html__("Override the global layout setting", 'zass-plugin') . "</label></p>";

		// Layout
		$output .= '<input id="zass_layout_fullwidth" ' . checked($values['zass_layout'], 'zass_fullwidth', false) . ' type="radio" value="zass_fullwidth" name="zass_layout">';
		$output .= '<label for="zass_layout_fullwidth">' . esc_html__('Full-width', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_layout_boxed" ' . checked($values['zass_layout'], 'zass_boxed', false) . ' type="radio" value="zass_boxed" name="zass_layout">';
		$output .= '<label for="zass_layout_boxed">' . esc_html__('Boxed', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_layout_left_header" ' . checked($values['zass_layout'], 'zass_header_left', false) . ' type="radio" value="zass_header_left" name="zass_layout">';
		$output .= '<label for="zass_layout_left_header">' . esc_html__('Left Header', 'zass-plugin') . '</label>';

		// Top Menu Bar
		$output .= '<p><b>' . esc_html__("Top Menu Bar", 'zass-plugin') . '</b></p>';
		$output .= '<input id="zass_top_header_default" ' . checked($values['zass_top_header'], 'default', false) . ' type="radio" value="default" name="zass_top_header">';
		$output .= '<label for="zass_top_header_default">' . esc_html__('Default', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_top_header_show" ' . checked($values['zass_top_header'], 'show', false) . ' type="radio" value="show" name="zass_top_header">';
		$output .= '<label for="zass_top_header_show">' . esc_html__('Show', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_top_header_hide" ' . checked($values['zass_top_header'], 'hide', false) . ' type="radio" value="hide" name="zass_top_header">';
		$output .= '<label for="zass_top_header_hide">' . esc_html__('Hide', 'zass-plugin') . '</label>';

		// Footer Size
		$output .= '<p><b>' . esc_html__("Footer size", 'zass-plugin') . '</b></p>';
		$output .= '<input id="zass_footer_size_default" ' . checked($values['zass_footer_size'], 'default', false) . ' type="radio" value="default" name="zass_footer_size">';
		$output .= '<label for="zass_footer_size_default">' . esc_html__('Default', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_footer_size_standard" ' . checked($values['zass_footer_size'], 'standard', false) . ' type="radio" value="standard" name="zass_footer_size">';
		$output .= '<label for="zass_footer_size_standard">' . esc_html__('Standard', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_footer_size_hide" ' . checked($values['zass_footer_size'], 'zass-stretched-footer', false) . ' type="radio" value="zass-stretched-footer" name="zass_footer_size">';
		$output .= '<label for="zass_footer_size_hide">' . esc_html__('Fullwidth', 'zass-plugin') . '</label>';

		// Footer Style
		$output .= '<p><b>' . esc_html__("Footer style", 'zass-plugin') . '</b></p>';
		$output .= '<input id="zass_footer_style_default" ' . checked($values['zass_footer_style'], 'default', false) . ' type="radio" value="default" name="zass_footer_style">';
		$output .= '<label for="zass_footer_style_default">' . esc_html__('Default', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_footer_style_show" ' . checked($values['zass_footer_style'], 'standart', false) . ' type="radio" value="standart" name="zass_footer_style">';
		$output .= '<label for="zass_footer_style_show">' . esc_html__('Standard', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_footer_style_hide" ' . checked($values['zass_footer_style'], 'zass-reveal-footer', false) . ' type="radio" value="zass-reveal-footer" name="zass_footer_style">';
		$output .= '<label for="zass_footer_style_hide">' . esc_html__('Reveal', 'zass-plugin') . '</label>';

		// Header Size
		$output .= '<p><b>' . esc_html__("Header size", 'zass-plugin') . '</b></p>';
		$output .= '<input id="zass_header_size_default" ' . checked($values['zass_header_size'], 'default', false) . ' type="radio" value="default" name="zass_header_size">';
		$output .= '<label for="zass_header_size_default">' . esc_html__('Default', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_header_size_standard" ' . checked($values['zass_header_size'], 'standard', false) . ' type="radio" value="standard" name="zass_header_size">';
		$output .= '<label for="zass_header_size_standard">' . esc_html__('Standard', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_header_size_hide" ' . checked($values['zass_header_size'], 'zass-stretched-header', false) . ' type="radio" value="zass-stretched-header" name="zass_header_size">';
		$output .= '<label for="zass_header_size_hide">' . esc_html__('Fullwidth', 'zass-plugin') . '</label>';

		// Transparent header and Title with Image Background (only on posts, pages, forum, portfolio and topic)
		$screen = get_current_screen();
		if ($screen && in_array($screen->post_type, array('post', 'page', 'forum', 'topic', 'zass-portfolio', 'tribe_events'), true)) {
			// Header style header
			$output .= '<p><b>' . esc_html__("Header Style", 'zass-plugin') . '</b></p>';
			$output .= '<p><label for="zass_header_syle">';

			$output .= "<select name='zass_header_syle'>";
			// Add a default option
			$output .= "<option";
			if ($values['zass_header_syle'] === '') {
				$output .= " selected='selected'";
			}
			$output .= " value=''>" . esc_html__('Normal', 'zass-plugin') . "</option>";

			// Fill the select element
			$header_style_values = array(
					'zass_transparent_header' => esc_html__('Transparent', 'zass-plugin'),
			);

			foreach ($header_style_values as $header_style_val => $header_style_option) {
				$output .= "<option";
				if ($header_style_val === $values['zass_header_syle']) {
					$output .= " selected='selected'";
				}
				$output .= " value='" . esc_attr($header_style_val) . "'>" . esc_html($header_style_option) . "</option>";
			}

			$output .= "</select>";

			// Title with Image Background and Subtitle
			$output .= '<p><b>' . esc_html__("Title with Image Background", 'zass-plugin') . '</b></p>';
			$output .= '<p><label for="zass_title_background">';
			$output .= "<input type='checkbox' id='zass_title_background' name='zass_title_background' value='1' " . checked(esc_attr($values['zass_title_background']), 1, false) . ">" . esc_html__("Use image background for title", 'zass-plugin') . "</label></p>";

			// The image
			$image_id = get_post_meta(
							$post->ID, 'zass_title_background_imgid', true
			);

			$add_link_style = '';
			$del_link_style = '';

			$output .= '<p class="hide-if-no-js">';
			$output .= '<span id="zass_title_background_imgid_images" class="zass_featured_img_holder">';

			if ($image_id) {
				$add_link_style = 'style="display:none"';
				$output .= wp_get_attachment_image($image_id, 'medium');
			} else {
				$del_link_style = 'style="display:none"';
			}

			$output .= '</span>';
			$output .= '</p>';
			$output .= '<p class="hide-if-no-js">';
			$output .= '<input id="zass_title_background_imgid" name="zass_title_background_imgid" type="hidden" value="' . esc_attr($image_id) . '" />';
			$output .= '<input type="button" value="' . esc_attr__('Manage Images', 'zass-plugin') . '" id="upload_zass_title_background_imgid" class="zass_upload_image_button" data-uploader_title="' . esc_attr__('Select Title Background Image', 'zass-plugin') . '" data-uploader_button_text="' . esc_attr__('Select', 'zass-plugin') . '">';
			$output .= '</p>';

			$output .= '<p><label for="zass_page_subtitle">' . esc_html__("Page Subtitle", 'zass-plugin') . '</label></p>';
			$output .= '<input type="text" id="zass_page_subtitle" name="zass_page_subtitle" value="' . esc_attr($values['zass_page_subtitle']) . '" class="large-text" />';
			$output .= '<p><label for="zass_title_alignment">' . esc_html__("Title alignment", 'zass-plugin') . '</label></p>';
			$output .= '<select name="zass_title_alignment">';
			$output .= '<option ' . ($values['zass_title_alignment'] == 'left_title' ? 'selected="selected"' : '') . ' value="left_title">Left</option>';
			$output .= '<option ' . ($values['zass_title_alignment'] == 'centered_title' ? 'selected="selected"' : '') . ' value="centered_title">Center</option>';
			$output .= '</select>';
		}

		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_layout_postdata')) {

	function zass_save_layout_postdata($post_id) {
		global $pagenow;

		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times
		if (isset($_POST['layout_nonce']) && !wp_verify_nonce($_POST['layout_nonce'], 'zass_save_layout_postdata')) {
			return;
		}

		if (!current_user_can('edit_pages', $post_id)) {
			return;
		}

		if ('post-new.php' == $pagenow) {
			return;
		}

		if (isset($_POST['zass_override_default_layout']) && $_POST['zass_override_default_layout']) {
			update_post_meta($post_id, "zass_override_default_layout", 1);
		} else {
			update_post_meta($post_id, "zass_override_default_layout", 0);
		}

		if (isset($_POST['zass_layout'])) {
			update_post_meta($post_id, "zass_layout", sanitize_text_field($_POST['zass_layout']));
		}

		if (isset($_POST['zass_top_header'])) {
			update_post_meta($post_id, "zass_top_header", sanitize_text_field($_POST['zass_top_header']));
		}

		if (isset($_POST['zass_footer_style'])) {
			update_post_meta($post_id, "zass_footer_style", sanitize_text_field($_POST['zass_footer_style']));
		}

		if (isset($_POST['zass_footer_size'])) {
			update_post_meta($post_id, "zass_footer_size", sanitize_text_field($_POST['zass_footer_size']));
		}

		if (isset($_POST['zass_header_size'])) {
			update_post_meta($post_id, "zass_header_size", sanitize_text_field($_POST['zass_header_size']));
		}

		if (isset($_POST['zass_page_subtitle'])) {
			update_post_meta($post_id, "zass_page_subtitle", sanitize_text_field($_POST['zass_page_subtitle']));
		}

		if (isset($_POST['zass_header_syle'])) {
			update_post_meta($post_id, "zass_header_syle", sanitize_text_field($_POST['zass_header_syle']));
		}

		if (isset($_POST['zass_title_background']) && $_POST['zass_title_background']) {
			update_post_meta($post_id, "zass_title_background", 1);
		} else {
			update_post_meta($post_id, "zass_title_background", 0);
		}

		if (isset($_POST['zass_title_background_imgid'])) {
			update_post_meta($post_id, 'zass_title_background_imgid', sanitize_text_field($_POST['zass_title_background_imgid']));
		}

		if (isset($_POST['zass_title_alignment'])) {
			update_post_meta($post_id, 'zass_title_alignment', sanitize_text_field($_POST['zass_title_alignment']));
		}
	}

}

/**
 * Register metaboxes
 */
add_action('add_meta_boxes', 'zass_add_page_options_metabox');
add_action('save_post', 'zass_save_page_options_postdata');

/* Adds a box to the side column on the Page edit screens */
if (!function_exists('zass_add_page_options_metabox')) {

	function zass_add_page_options_metabox() {

		$posttypes = array('page', 'post', 'zass-portfolio', 'tribe_events');

		if (ZASS_PLUGIN_IS_BBPRESS) {
			$posttypes[] = 'forum';
			$posttypes[] = 'topic';
		}
		if(post_type_exists('tribe_events')) {
			$posttypes[] = 'tribe_events';
		}

		foreach ($posttypes as $pt) {
			add_meta_box(
							'zass_page_options', esc_html__('Page Structure Options', 'zass-plugin'), 'zass_page_options_callback', $pt, 'side'
			);
		}
	}

}

/* Prints the box content */
if (!function_exists('zass_page_options_callback')) {

	function zass_page_options_callback($post) {
		// If current page is set as Blog page - don't show the options
		if ($post->ID == get_option('page_for_posts')) {
			echo esc_html__("Page Structure Options are disabled for this page, because the page is set as Blog page from Settings->Reading.", 'zass-plugin');
			return;
		}
		// If current page is set as Shop page - don't show the options
		if (ZASS_PLUGIN_IS_WOOCOMMERCE && $post->ID == wc_get_page_id('shop')) {
			echo esc_html__("Page Structure Options are disabled for this page, because the page is set as Shop page.", 'zass-plugin');
			return;
		}

		// Use nonce for verification
		wp_nonce_field('zass_save_page_options_postdata', 'page_options_nonce');
		global $wp_registered_sidebars;

		$custom = get_post_custom($post->ID);

		// Set default values
		$values = array(
				'zass_top_menu' => 'default',
				'zass_show_title_page' => 'yes',
				'zass_show_breadcrumb' => 'yes',
				'zass_show_sidebar' => 'yes',
				'zass_sidebar_position' => 'default',
				'zass_show_footer_sidebar' => 'yes',
				'zass_show_offcanvas_sidebar' => 'yes',
				'zass_show_share' => 'default',
				'zass_custom_sidebar' => 'default',
				'zass_custom_footer_sidebar' => 'default',
				'zass_custom_offcanvas_sidebar' => 'default'
		);

		if (isset($custom['zass_top_menu']) && $custom['zass_top_menu'][0] != '') {
			$values['zass_top_menu'] = $custom['zass_top_menu'][0];
		}
		if (isset($custom['zass_show_title_page']) && $custom['zass_show_title_page'][0] != '') {
			$values['zass_show_title_page'] = $custom['zass_show_title_page'][0];
		}
		if (isset($custom['zass_show_breadcrumb']) && $custom['zass_show_breadcrumb'][0] != '') {
			$values['zass_show_breadcrumb'] = $custom['zass_show_breadcrumb'][0];
		}
		if (isset($custom['zass_show_sidebar']) && $custom['zass_show_sidebar'][0] != '') {
			$values['zass_show_sidebar'] = $custom['zass_show_sidebar'][0];
		}
		if (isset($custom['zass_sidebar_position']) && $custom['zass_sidebar_position'][0] != '') {
			$values['zass_sidebar_position'] = $custom['zass_sidebar_position'][0];
		}
		if (isset($custom['zass_show_footer_sidebar']) && $custom['zass_show_footer_sidebar'][0] != '') {
			$values['zass_show_footer_sidebar'] = $custom['zass_show_footer_sidebar'][0];
		}
		if (isset($custom['zass_show_offcanvas_sidebar']) && $custom['zass_show_offcanvas_sidebar'][0] != '') {
			$values['zass_show_offcanvas_sidebar'] = $custom['zass_show_offcanvas_sidebar'][0];
		}
		if (isset($custom['zass_show_share']) && $custom['zass_show_share'][0] != '') {
			$values['zass_show_share'] = $custom['zass_show_share'][0];
		}
		if (isset($custom['zass_custom_sidebar']) && $custom['zass_custom_sidebar'][0] != '') {
			$values['zass_custom_sidebar'] = $custom['zass_custom_sidebar'][0];
		}
		if (isset($custom['zass_custom_footer_sidebar']) && $custom['zass_custom_footer_sidebar'][0] != '') {
			$values['zass_custom_footer_sidebar'] = $custom['zass_custom_footer_sidebar'][0];
		}
		if (isset($custom['zass_custom_offcanvas_sidebar']) && $custom['zass_custom_offcanvas_sidebar'][0] != '') {
			$values['zass_custom_offcanvas_sidebar'] = $custom['zass_custom_offcanvas_sidebar'][0];
		}

		// description
		$output = '<p>' . esc_html__("You can configure the page structure, using this options.", 'zass-plugin') . '</p>';

		// Top Menu
		$choose_menu_options = zass_get_choose_menu_options();
		$output .= '<p><label for="zass_top_menu"><b>' . esc_html__("Choose Top Menu", 'zass-plugin') . '</b></label></p>';
		$output .= "<select name='zass_top_menu'>";
		// Add a default option
		foreach ($choose_menu_options as $key => $val) {
			$output .= "<option value='" . esc_attr($key) . "' " . esc_attr(selected($values['zass_top_menu'], $key, false)) . " >" . esc_html($val) . "</option>";
		}
		$output .= "</select>";

		// Show title
		$output .= '<p><label for="zass_show_title_page"><b>' . esc_html__("Show Title", 'zass-plugin') . '</b></label></p>';
		$output .= '<input id="zass_show_title_page_yes" ' . checked($values['zass_show_title_page'], 'yes', false) . ' type="radio" value="yes" name="zass_show_title_page">';
		$output .= '<label for="zass_show_title_page_yes">Yes </label>&nbsp;';
		$output .= '<input id="zass_show_title_page_no" ' . checked($values['zass_show_title_page'], 'no', false) . ' type="radio" value="no" name="zass_show_title_page">';
		$output .= '<label for="zass_show_title_page_no">No</label>';

		// Show breadcrumb
		$output .= '<p><label for="zass_show_breadcrumb"><b>' . esc_html__("Show Breadcrumb", 'zass-plugin') . '</b></label></p>';
		$output .= "<input id='zass_show_breadcrumb_yes' " . checked($values['zass_show_breadcrumb'], 'yes', false) . " type='radio' value='yes' name='zass_show_breadcrumb'>";
		$output .= '<label for="zass_show_breadcrumb_yes">Yes </label>&nbsp;';
		$output .= '<input id="zass_show_breadcrumb_no" ' . checked($values['zass_show_breadcrumb'], 'no', false) . ' type="radio" value="no" name="zass_show_breadcrumb">';
		$output .= '<label for="zass_show_breadcrumb_no">No</label>';

		// Show share
		$output .= '<p><label for="zass_show_share"><b>' . esc_html__("Show Social Share Links", 'zass-plugin') . '</b></label></p>';
		$output .= '<input id="zass_show_share_default" ' . checked($values['zass_show_share'], 'default', false) . ' type="radio" value="default" name="zass_show_share">';
		$output .= '<label for="zass_show_share_default">' . esc_html__('Default', 'zass-plugin') . '</label>&nbsp;';
		$output .= '<input id="zass_show_share_yes" ' . checked($values['zass_show_share'], 'yes', false) . ' type="radio" value="yes" name="zass_show_share">';
		$output .= '<label for="zass_show_share_yes">Yes </label>&nbsp;';
		$output .= '<input id="zass_show_share_no" ' . checked($values['zass_show_share'], 'no', false) . ' type="radio" value="no" name="zass_show_share">';
		$output .= '<label for="zass_show_share_no">No</label>';

		// Show Main sidebar
		$output .= '<p><label for="zass_show_sidebar"><b>' . esc_html__("Main Sidebar", 'zass-plugin') . '</b></label></p>';
		$output .= '<input id="zass_show_sidebar_yes" ' . checked($values['zass_show_sidebar'], 'yes', false) . ' type="radio" value="yes" name="zass_show_sidebar">';
		$output .= '<label for="zass_show_sidebar_yes">Show </label>&nbsp;';
		$output .= '<input id="zass_show_sidebar_no" ' . checked($values['zass_show_sidebar'], 'no', false) . ' type="radio" value="no" name="zass_show_sidebar">';
		$output .= '<label for="zass_show_sidebar_no">Hide </label>';

		// Select Main sidebar
		$output .= "<select name='zass_custom_sidebar'>";
		// Add a default option
		$output .= "<option";
		if ($values['zass_custom_sidebar'] == "default") {
			$output .= " selected='selected'";
		}
		$output .= " value='default'>" . esc_html__('default', 'zass-plugin') . "</option>";

		// Fill the select element with all registered sidebars
		foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
			if ($sidebar_id != 'bottom_footer_sidebar' && $sidebar_id != 'pre_header_sidebar') {
				$output .= "<option";
				if ($sidebar_id == $values['zass_custom_sidebar']) {
					$output .= " selected='selected'";
				}
				$output .= " value='" . esc_attr($sidebar_id) . "'>" . esc_html($sidebar['name']) . "</option>";
			}
		}

		$output .= "</select>";

		// Main Sidebar Position
		$output .= '<p><label for="zass_sidebar_position"><b>' . esc_html__("Main Sidebar Position", 'zass-plugin') . '</b></label></p>';
		$output .= '<select name="zass_sidebar_position">';
		$output .= '<option value="default" '.esc_attr(selected($values['zass_sidebar_position'], 'default', false)).' >' . esc_html__("default", 'zass-plugin') . '</option>';
		$output .= '<option value="zass-left-sidebar" '.esc_attr(selected($values['zass_sidebar_position'], 'zass-left-sidebar', false)).'>' . esc_html__("Left", 'zass-plugin') . '</option>';
		$output .= '<option value="zass-right-sidebar" '.esc_attr(selected($values['zass_sidebar_position'], 'zass-right-sidebar', false)).'>' . esc_html__("Right", 'zass-plugin') . '</option>';
		$output .= '</select>';

		// Show offcanvas sidebar
		$output .= '<p><label for="zass_show_offcanvas_sidebar"><b>' . esc_html__("Off Canvas Sidebar", 'zass-plugin') . '</b></label></p>';
		$output .= '<input id="zass_show_offcanvas_sidebar_yes" ' . checked($values['zass_show_offcanvas_sidebar'], 'yes', false) . ' type="radio" value="yes" name="zass_show_offcanvas_sidebar">';
		$output .= '<label for="zass_show_offcanvas_sidebar_yes">Show </label>&nbsp;';
		$output .= '<input id="zass_show_offcanvas_sidebar_no" ' . checked($values['zass_show_offcanvas_sidebar'], 'no', false) . ' type="radio" value="no" name="zass_show_offcanvas_sidebar">';
		$output .= '<label for="zass_show_offcanvas_sidebar_no">Hide </label>';

		// Select offcanvas sidebar
		$output .= "<select name='zass_custom_offcanvas_sidebar'>";

		// Add a default option
		$output .= "<option";
		if ($values['zass_custom_offcanvas_sidebar'] == "default") {
			$output .= " selected='selected'";
		}
		$output .= " value='default'>" . esc_html__('default', 'zass-plugin') . "</option>";

		// Fill the select element with all registered sidebars
		foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
			if ($sidebar_id != 'pre_header_sidebar') {
				$output .= "<option";
				if ($sidebar_id == $values['zass_custom_offcanvas_sidebar']) {
					$output .= " selected='selected'";
				}
				$output .= " value='" . esc_attr($sidebar_id) . "'>" . esc_html($sidebar['name']) . "</option>";
			}
		}

		$output .= "</select>";

		// Show footer sidebar
		$output .= '<p><label for="zass_show_footer_sidebar"><b>' . esc_html__("Footer Sidebar", 'zass-plugin') . '</b></label></p>';
		$output .= '<input id="zass_show_footer_sidebar_yes" ' . checked($values['zass_show_footer_sidebar'], 'yes', false) . ' type="radio" value="yes" name="zass_show_footer_sidebar">';
		$output .= '<label for="zass_show_footer_sidebar_yes">Show </label>&nbsp;';
		$output .= '<input id="zass_show_footer_sidebar_no" ' . checked($values['zass_show_footer_sidebar'], 'no', false) . ' type="radio" value="no" name="zass_show_footer_sidebar">';
		$output .= '<label for="zass_show_footer_sidebar_no">Hide </label>';

		// Select footer sidebar
		$output .= "<select name='zass_custom_footer_sidebar'>";

		// Add a default option
		$output .= "<option";
		if ($values['zass_custom_footer_sidebar'] == "default") {
			$output .= " selected='selected'";
		}
		$output .= " value='default'>" . esc_html__('default', 'zass-plugin') . "</option>";

		// Fill the select element with all registered sidebars
		foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
			if ($sidebar_id != 'pre_header_sidebar') {
				$output .= "<option";
				if ($sidebar_id == $values['zass_custom_footer_sidebar']) {
					$output .= " selected='selected'";
				}
				$output .= " value='" . esc_attr($sidebar_id) . "'>" . esc_html($sidebar['name']) . "</option>";
			}
		}

		$output .= "</select>";

		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_page_options_postdata')) {

	function zass_save_page_options_postdata($post_id) {
		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times
		if (isset($_POST['page_options_nonce']) && !wp_verify_nonce($_POST['page_options_nonce'], 'zass_save_page_options_postdata')) {
			return;
		}

		if (!current_user_can('edit_pages', $post_id)) {
			return;
		}

		if (isset($_POST['zass_top_menu'])) {
			update_post_meta($post_id, "zass_top_menu", sanitize_text_field($_POST['zass_top_menu']));
		}
		if (isset($_POST['zass_show_title_page'])) {
			update_post_meta($post_id, "zass_show_title_page", sanitize_text_field($_POST['zass_show_title_page']));
		}
		if (isset($_POST['zass_show_breadcrumb'])) {
			update_post_meta($post_id, "zass_show_breadcrumb", sanitize_text_field($_POST['zass_show_breadcrumb']));
		}
		if (isset($_POST['zass_show_sidebar'])) {
			update_post_meta($post_id, "zass_show_sidebar", sanitize_text_field($_POST['zass_show_sidebar']));
		}
		if (isset($_POST['zass_sidebar_position'])) {
			update_post_meta($post_id, "zass_sidebar_position", sanitize_text_field($_POST['zass_sidebar_position']));
		}
		if (isset($_POST['zass_show_footer_sidebar'])) {
			update_post_meta($post_id, "zass_show_footer_sidebar", sanitize_text_field($_POST['zass_show_footer_sidebar']));
		}
		if (isset($_POST['zass_show_offcanvas_sidebar'])) {
			update_post_meta($post_id, "zass_show_offcanvas_sidebar", sanitize_text_field($_POST['zass_show_offcanvas_sidebar']));
		}
		if (isset($_POST['zass_show_share'])) {
			update_post_meta($post_id, "zass_show_share", sanitize_text_field($_POST['zass_show_share']));
		}
		if (isset($_POST['zass_custom_sidebar'])) {
			update_post_meta($post_id, "zass_custom_sidebar", sanitize_text_field($_POST['zass_custom_sidebar']));
		}
		if (isset($_POST['zass_custom_footer_sidebar'])) {
			update_post_meta($post_id, "zass_custom_footer_sidebar", sanitize_text_field($_POST['zass_custom_footer_sidebar']));
		}
		if (isset($_POST['zass_custom_offcanvas_sidebar'])) {
			update_post_meta($post_id, "zass_custom_offcanvas_sidebar", sanitize_text_field($_POST['zass_custom_offcanvas_sidebar']));
		}
	}

}

// If Revolution slider is active add the meta box
if (ZASS_PLUGIN_IS_REVOLUTION) {
	add_action('add_meta_boxes', 'zass_add_revolution_slider_metabox');
	add_action('save_post', 'zass_save_revolution_slider_postdata');
}

/* Adds a box to the side column on the Post, Page and Portfolio edit screens */
if (!function_exists('zass_add_revolution_slider_metabox')) {

	function zass_add_revolution_slider_metabox() {
		add_meta_box(
						'zass_revolution_slider', esc_html__('Revolution Slider', 'zass-plugin'), 'zass_revolution_slider_callback', 'page', 'side'
		);

		add_meta_box(
						'zass_revolution_slider', esc_html__('Revolution Slider', 'zass-plugin'), 'zass_revolution_slider_callback', 'post', 'side'
		);

		add_meta_box(
						'zass_revolution_slider', esc_html__('Revolution Slider', 'zass-plugin'), 'zass_revolution_slider_callback', 'zass-portfolio', 'side'
		);

		add_meta_box(
						'zass_revolution_slider', esc_html__('Revolution Slider', 'zass-plugin'), 'zass_revolution_slider_callback', 'tribe_events', 'side'
		);
	}

}

/* Prints the box content */
if (!function_exists('zass_revolution_slider_callback')) {

	function zass_revolution_slider_callback($post) {

		// If current page is set as Blog page - don't show the options
		if ($post->ID == get_option('page_for_posts')) {
			echo esc_html__("Revolution slider is disabled for this page, because the page is set as Blog page from Settings->Reading.", 'zass-plugin');
			return;
		}

		// If current page is set as Shop page - don't show the options
		if (ZASS_PLUGIN_IS_WOOCOMMERCE && $post->ID == wc_get_page_id('shop')) {
			echo esc_html__("Revolution slider is disabled for this page, because the page is set as Shop page.", 'zass-plugin');
			return;
		}

		// Use nonce for verification
		wp_nonce_field('zass_save_revolution_slider_postdata', 'zass_revolution_slider');

		$custom = get_post_custom($post->ID);

		if (isset($custom['zass_rev_slider'])) {
			$val = $custom['zass_rev_slider'][0];
		} else {
			$val = "none";
		}

		if (isset($custom['zass_rev_slider_before_header']) && $custom['zass_rev_slider_before_header'][0] != '') {
			$val_before_header = esc_attr($custom['zass_rev_slider_before_header'][0]);
		} else {
			$val_before_header = 0;
		}

		// description
		$output = '<p>' . esc_html__("You can choose a Revolution slider to be attached. It will show up on the top of this page/post.", 'zass-plugin') . '</p>';

		// select
		$output .= '<p><label for="zass_rev_slider"><b>' . esc_html__("Select slider", 'zass-plugin') . '</b></label></p>';
		$output .= "<select name='zass_rev_slider'>";

		// Add a default option
		$output .= "<option";
		if ($val == "none") {
			$output .= " selected='selected'";
		}
		$output .= " value='none'>" . esc_html__('none', 'zass-plugin') . "</option>";

		// Get defined revolution slides
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSlidersShort();

		// Fill the select element with all registered slides
		foreach ($arrSliders as $id => $title) {
			$output .= "<option";
			if ($id == $val)
				$output .= " selected='selected'";
			$output .= " value='" . esc_attr($id) . "'>" . esc_html($title) . "</option>";
		}

		$output .= "</select>";
		$screen = get_current_screen();
		// only for pages
		if ($screen && in_array($screen->post_type, array('page'), true)) {
			// place before header
			$output .= '<p><label for="zass_rev_slider_before_header">';
			$output .= "<input type='checkbox' id='zass_rev_slider_before_header' name='zass_rev_slider_before_header' value='1' " . checked(esc_attr($val_before_header), 1, false) . "><b>" . esc_html__("Place before header", 'zass-plugin') . "</b></label></p>";
		}
		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_revolution_slider_postdata')) {

	function zass_save_revolution_slider_postdata($post_id) {
		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times
		if (isset($_POST['zass_revolution_slider']) && !wp_verify_nonce($_POST['zass_revolution_slider'], 'zass_save_revolution_slider_postdata')) {
			return;
		}

		if (!current_user_can('edit_pages', $post_id)) {
			return;
		}

		if (isset($_POST['zass_rev_slider'])) {
			update_post_meta($post_id, "zass_rev_slider", sanitize_text_field($_POST['zass_rev_slider']));
		}

		if (isset($_POST['zass_rev_slider_before_header']) && $_POST['zass_rev_slider_before_header']) {
			update_post_meta($post_id, "zass_rev_slider_before_header", 1);
		} else {
			update_post_meta($post_id, "zass_rev_slider_before_header", 0);
		}
	}

}

/**
 * Register video background metaboxes
 */
add_action('add_meta_boxes', 'zass_add_video_bckgr_metabox');
add_action('save_post', 'zass_save_video_bckgr_postdata');

/* Adds a box to the side column on the Page edit screens */
if (!function_exists('zass_add_video_bckgr_metabox')) {

	function zass_add_video_bckgr_metabox() {

		$posttypes = array('page', 'post', 'zass-portfolio', 'tribe_events');
		if (ZASS_PLUGIN_IS_WOOCOMMERCE) {
			$posttypes[] = 'product';
		}
		if (ZASS_PLUGIN_IS_BBPRESS) {
			$posttypes[] = 'forum';
			$posttypes[] = 'topic';
		}

		foreach ($posttypes as $pt) {
			add_meta_box(
							'zass_video_bckgr', esc_html__('Video Background', 'zass-plugin'), 'zass_video_bckgr_callback', $pt, 'side'
			);
		}
	}

}

/* Prints the box content */
if (!function_exists('zass_video_bckgr_callback')) {

	function zass_video_bckgr_callback($post) {
		// If current page is set as Blog page - don't show the options
		if ($post->ID == get_option('page_for_posts')) {
			echo esc_html__("Video Background options are disabled for this page, because the page is set as Blog page from Settings->Reading.", 'zass-plugin');
			return;
		}

		// If current page is set as Shop page - don't show the options
		if (ZASS_PLUGIN_IS_WOOCOMMERCE && $post->ID == wc_get_page_id('shop')) {
			echo esc_html__("Video Background options are disabled for this page, because the page is set as Shop page.", 'zass-plugin');
			return;
		}


		// Use nonce for verification
		wp_nonce_field('zass_save_video_bckgr_postdata', 'video_bckgr_nonce');

		$custom = get_post_custom($post->ID);

		// Set default values
		$values = array(
				'zass_video_bckgr_url' => '',
				'zass_video_bckgr_start' => '',
				'zass_video_bckgr_end' => '',
				'zass_video_bckgr_loop' => 1,
				'zass_video_bckgr_mute' => 1
		);

		if (isset($custom['zass_video_bckgr_url']) && $custom['zass_video_bckgr_url'][0] != '') {
			$values['zass_video_bckgr_url'] = esc_attr($custom['zass_video_bckgr_url'][0]);
		}
		if (isset($custom['zass_video_bckgr_start']) && $custom['zass_video_bckgr_start'][0] != '') {
			$values['zass_video_bckgr_start'] = esc_attr($custom['zass_video_bckgr_start'][0]);
		}
		if (isset($custom['zass_video_bckgr_end']) && $custom['zass_video_bckgr_end'][0] != '') {
			$values['zass_video_bckgr_end'] = esc_attr($custom['zass_video_bckgr_end'][0]);
		}
		if (isset($custom['zass_video_bckgr_loop']) && $custom['zass_video_bckgr_loop'][0] != '') {
			$values['zass_video_bckgr_loop'] = esc_attr($custom['zass_video_bckgr_loop'][0]);
		}
		if (isset($custom['zass_video_bckgr_mute']) && $custom['zass_video_bckgr_mute'][0] != '') {
			$values['zass_video_bckgr_mute'] = esc_attr($custom['zass_video_bckgr_mute'][0]);
		}

		// description
		$output = '<p>' . esc_html__("Define the video background options for this page/post.", 'zass-plugin') . '</p>';

		// Video URL
		$output .= '<p><label for="zass_video_bckgr_url"><b>' . esc_html__("YouTube video URL", 'zass-plugin') . '</b></label></p>';
		$output .= '<input type="text" id="zass_video_bckgr_url" name="zass_video_bckgr_url" value="' . esc_attr($values['zass_video_bckgr_url']) . '" class="large-text" />';

		// Start time
		$output .= '<p><label for="zass_video_bckgr_start"><b>' . esc_html__("Start time in seconds", 'zass-plugin') . '</b></label></p>';
		$output .= '<input type="text" id="zass_video_bckgr_start" name="zass_video_bckgr_start" value="' . esc_attr($values['zass_video_bckgr_start']) . '" size="8" />';

		// End time
		$output .= '<p><label for="zass_video_bckgr_end"><b>' . esc_html__("End time in seconds", 'zass-plugin') . '</b></label></p>';
		$output .= '<input type="text" id="zass_video_bckgr_end" name="zass_video_bckgr_end" value="' . esc_attr($values['zass_video_bckgr_end']) . '" size="8" />';

		// Loop
		$output .= '<p><label for="zass_video_bckgr_loop">';
		$output .= "<input type='checkbox' id='zass_video_bckgr_loop' name='zass_video_bckgr_loop' value='1' " . checked(esc_attr($values['zass_video_bckgr_loop']), 1, false) . "><b>" . esc_html__("Loop", 'zass-plugin') . "</b></label></p>";

		// Mute
		$output .= '<p><label for="zass_video_bckgr_mute">';
		$output .= "<input type='checkbox' id='zass_video_bckgr_mute' name='zass_video_bckgr_mute' value='1' " . checked(esc_attr($values['zass_video_bckgr_mute']), 1, false) . "><b>" . esc_html__("Mute", 'zass-plugin') . "</b></label></p>";


		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_video_bckgr_postdata')) {

	function zass_save_video_bckgr_postdata($post_id) {
		global $pagenow;

		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times

		if (isset($_POST['video_bckgr_nonce']) && !wp_verify_nonce($_POST['video_bckgr_nonce'], 'zass_save_video_bckgr_postdata')) {
			return;
		}

		if (!current_user_can('edit_pages', $post_id)) {
			return;
		}

		if ('post-new.php' == $pagenow) {
			return;
		}

		if (isset($_POST['zass_video_bckgr_url'])) {
			update_post_meta($post_id, "zass_video_bckgr_url", esc_url($_POST['zass_video_bckgr_url']));
		}
		if (isset($_POST['zass_video_bckgr_start'])) {
			update_post_meta($post_id, "zass_video_bckgr_start", sanitize_text_field($_POST['zass_video_bckgr_start']));
		}
		if (isset($_POST['zass_video_bckgr_end'])) {
			update_post_meta($post_id, "zass_video_bckgr_end", sanitize_text_field($_POST['zass_video_bckgr_end']));
		}
		if (isset($_POST['zass_video_bckgr_loop']) && $_POST['zass_video_bckgr_loop']) {
			update_post_meta($post_id, "zass_video_bckgr_loop", 1);
		} else {
			update_post_meta($post_id, "zass_video_bckgr_loop", 0);
		}
		if (isset($_POST['zass_video_bckgr_mute']) && $_POST['zass_video_bckgr_mute']) {
			update_post_meta($post_id, "zass_video_bckgr_mute", 1);
		} else {
			update_post_meta($post_id, "zass_video_bckgr_mute", 0);
		}
	}

}

/**
 * Supersized slider
 */
add_action('add_meta_boxes', 'zass_add_supersized_slider_metabox');
add_action('save_post', 'zass_save_supersized_slider_postdata');

/* Adds a box to the side column on the Post and Page edit screens */
if (!function_exists('zass_add_supersized_slider_metabox')) {

	function zass_add_supersized_slider_metabox() {

		$posttypes = array('page', 'post', 'zass-portfolio', 'tribe_events');
		if (ZASS_PLUGIN_IS_WOOCOMMERCE) {
			$posttypes[] = 'product';
		}
		if (ZASS_PLUGIN_IS_BBPRESS) {
			$posttypes[] = 'forum';
			$posttypes[] = 'topic';
		}

		foreach ($posttypes as $pt) {
			add_meta_box(
							'zass_supersized_slider', esc_html__('Supersized Slider', 'zass-plugin'), 'zass_supersized_slider_callback', $pt, 'side'
			);
		}
	}

}

/* Prints the box content */
if (!function_exists('zass_supersized_slider_callback')) {

	function zass_supersized_slider_callback($post) {

		// If current page is set as Blog page - don't show the options
		if ($post->ID == get_option('page_for_posts')) {
			echo esc_html__("Supersized slider is disabled for this page, because the page is set as Blog page from Settings->Reading.", 'zass-plugin');
			return;
		}

		// If current page is set as Shop page - don't show the options
		if (ZASS_PLUGIN_IS_WOOCOMMERCE && $post->ID == wc_get_page_id('shop')) {
			echo esc_html__("Supersized slider is disabled for this page, because the page is set as Shop page.", 'zass-plugin');
			return;
		}

		// Use nonce for verification
		wp_nonce_field('zass_save_supersized_slider_postdata', 'zass_supersized_slider');

		$custom = get_post_custom($post->ID);

		// get stored ids
		$image_ids = '';
		if (array_key_exists('zass_super_slider_ids', $custom)) {
			$image_ids = $custom['zass_super_slider_ids'][0];
		}
		$ids_arr = array();
		if ($image_ids) {
			$ids_arr = explode(';', $image_ids);
		}

		// description
		$output = '<p>' . esc_html__("Select images for the Supersized slider which will be used for this page/post.", 'zass-plugin') . '</p>';

		$output .= '<input id="zass_super_slider_ids" name="zass_super_slider_ids" type="hidden" value="' . esc_attr($image_ids) . '" />';
		$output .= '<input type="button" value="' . esc_html__('Manage images', 'zass-plugin') . '" id="upload_zass_super_slider_ids" class="zass_upload_image_button is_multiple" data-uploader_title="' . esc_attr__('Choose Supersized Images', 'zass-plugin') . '" data-uploader_button_text="' . esc_attr__('Insert', 'zass-plugin') . '">';

		$output .= '<div id="zass_super_slider_ids_images">';

		foreach ($ids_arr as $id) {
			$image_arr = wp_get_attachment_image_src($id, 'zass-general-small-size');
			$output .= '<img src="' . esc_url($image_arr[0]) . '">';
		}

		$output .= '</div>';

		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_supersized_slider_postdata')) {

	function zass_save_supersized_slider_postdata($post_id) {
		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times

		if (isset($_POST['zass_supersized_slider']) && !wp_verify_nonce($_POST['zass_supersized_slider'], 'zass_save_supersized_slider_postdata')) {
			return;
		}

		if (!current_user_can('edit_pages', $post_id)) {
			return;
		}

		if (isset($_POST['zass_super_slider_ids'])) {
			update_post_meta($post_id, "zass_super_slider_ids", sanitize_text_field($_POST['zass_super_slider_ids']));
		}
	}

}

/**
 * Portfolio CPT metaboxes
 */
add_action('add_meta_boxes', 'zass_add_portfolio_metabox');
add_action('save_post', 'zass_save_portfolio_postdata');

/* Adds the custom fields for zass-portfolio CPT */
if (!function_exists('zass_add_portfolio_metabox')) {

	function zass_add_portfolio_metabox() {
		add_meta_box(
						'zass_portfolio_details', esc_html__('Portfolio details', 'zass-plugin'), 'zass_portfolio_callback', 'zass-portfolio', 'normal', 'high'
		);
	}

}

/* Prints the portfolio content */
if (!function_exists('zass_portfolio_callback')) {

	function zass_portfolio_callback($post) {
		// Use nonce for verification
		wp_nonce_field('zass_save_portfolio_postdata', 'zass_portfolio_nonce');

		echo '<h4>' . esc_html__('Fill any of the following fields. If you leave some of them empty, they won\'t show on the page.', 'zass-plugin') . '</h4>';

		echo '<label for="zass_collection">';
		_e('Collection', 'zass-plugin');
		echo '</label> ';
		echo '<div><input type="text" id="zass_collection" name="zass_collection" value="' . esc_attr(get_post_meta($post->ID, 'zass_collection', true)) . '" class="regular-text" /></div>';

		echo '<label for="zass_materials">';
		_e('Materials', 'zass-plugin');
		echo '</label> ';
		echo '<div><input type="text" id="zass_materials" name="zass_materials" value="' . esc_attr(get_post_meta($post->ID, 'zass_materials', true)) . '" class="regular-text" /></div>';

		echo '<label for="zass_model">';
		_e('Model', 'zass-plugin');
		echo '</label> ';
		echo '<div><input type="text" id="zass_model" name="zass_model" value="' . esc_attr(get_post_meta($post->ID, 'zass_model', true)) . '" class="regular-text" /></div>';

		echo '<label for="zass_status">';
		_e('Current status of project', 'zass-plugin');
		echo '</label> ';
		echo '<div><input type="text" id="zass_status" name="zass_status" value="' . esc_attr(get_post_meta($post->ID, 'zass_status', true)) . '" class="regular-text" /></div>';


		echo '<h4>' . esc_html__('Project External Link:', 'zass-plugin') . '</h4>';
		echo '<label for="zass_ext_link_button_title">';
		_e('Button Title', 'zass-plugin');
		echo '</label> ';
		echo '<div><input type="text" id="zass_ext_link_button_title" name="zass_ext_link_button_title" value="' . esc_attr(get_post_meta($post->ID, 'zass_ext_link_button_title', true)) . '" class="regular-text" /></div>';

		echo '<label for="zass_ext_link_url">';
		_e('Url', 'zass-plugin');
		echo '</label> ';
		echo '<div><input type="text" id="zass_ext_link_url" name="zass_ext_link_url" value="' . esc_attr(get_post_meta($post->ID, 'zass_ext_link_url', true)) . '" class="regular-text" /></div>';

		echo '<h4>' . esc_html__('Project features list:', 'zass-plugin') . '</h4>';

		echo '<div><input type="text" id="zass_feature_1" name="zass_feature_1" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_1', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_2" name="zass_feature_2" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_2', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_3" name="zass_feature_3" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_3', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_4" name="zass_feature_4" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_4', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_5" name="zass_feature_5" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_5', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_6" name="zass_feature_6" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_6', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_7" name="zass_feature_7" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_7', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_8" name="zass_feature_8" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_8', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_9" name="zass_feature_9" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_9', true)) . '" class="regular-text" /></div>';
		echo '<div><input type="text" id="zass_feature_10" name="zass_feature_10" value="' . esc_attr(get_post_meta($post->ID, 'zass_feature_10', true)) . '" class="regular-text" /></div>';

		echo '<h4>' . esc_html__('Short Description', 'zass-plugin') . '</h4>';
		wp_editor(wp_kses_post(get_post_meta($post->ID, 'zass_add_description', true)), 'zassadddescription', $settings = array('textarea_name' => 'zass_add_description', 'textarea_rows' => 5));
	}

}

/* When the portfolio is saved, saves our custom data */
if (!function_exists('zass_save_portfolio_postdata')) {

	function zass_save_portfolio_postdata($post_id) {

		// Check if our nonce is set.
		if (!isset($_POST['zass_portfolio_nonce'])) {
			return;
		}

		// Verify that the nonce is valid.
		if (!wp_verify_nonce($_POST['zass_portfolio_nonce'], 'zass_save_portfolio_postdata')) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// Check the user's permissions.
		if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {

			if (!current_user_can('edit_pages', $post_id)) {
				return;
			}
		} else {

			if (!current_user_can('edit_posts', $post_id)) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		// Make sure that it is set.
		if (!isset($_POST['zass_collection'], $_POST['zass_materials'], $_POST['zass_model'], $_POST['zass_status'], $_POST['zass_ext_link_button_title'], $_POST['zass_ext_link_url'], $_POST['zass_feature_1'], $_POST['zass_feature_2'], $_POST['zass_feature_3'], $_POST['zass_feature_4'], $_POST['zass_feature_5'], $_POST['zass_feature_6'], $_POST['zass_feature_7'], $_POST['zass_feature_8'], $_POST['zass_feature_9'], $_POST['zass_feature_10'], $_POST['zass_add_description'])) {
			return;
		}

		update_post_meta($post_id, 'zass_collection', sanitize_text_field($_POST['zass_collection']));
		update_post_meta($post_id, 'zass_materials', sanitize_text_field($_POST['zass_materials']));
		update_post_meta($post_id, 'zass_model', sanitize_text_field($_POST['zass_model']));
		update_post_meta($post_id, 'zass_status', sanitize_text_field($_POST['zass_status']));
		update_post_meta($post_id, 'zass_ext_link_button_title', sanitize_text_field($_POST['zass_ext_link_button_title']));
		update_post_meta($post_id, 'zass_ext_link_url', esc_url($_POST['zass_ext_link_url']));
		update_post_meta($post_id, 'zass_feature_1', sanitize_text_field($_POST['zass_feature_1']));
		update_post_meta($post_id, 'zass_feature_2', sanitize_text_field($_POST['zass_feature_2']));
		update_post_meta($post_id, 'zass_feature_3', sanitize_text_field($_POST['zass_feature_3']));
		update_post_meta($post_id, 'zass_feature_4', sanitize_text_field($_POST['zass_feature_4']));
		update_post_meta($post_id, 'zass_feature_5', sanitize_text_field($_POST['zass_feature_5']));
		update_post_meta($post_id, 'zass_feature_6', sanitize_text_field($_POST['zass_feature_6']));
		update_post_meta($post_id, 'zass_feature_7', sanitize_text_field($_POST['zass_feature_7']));
		update_post_meta($post_id, 'zass_feature_8', sanitize_text_field($_POST['zass_feature_8']));
		update_post_meta($post_id, 'zass_feature_9', sanitize_text_field($_POST['zass_feature_9']));
		update_post_meta($post_id, 'zass_feature_10', sanitize_text_field($_POST['zass_feature_10']));
		update_post_meta($post_id, 'zass_add_description', wp_kses_post($_POST['zass_add_description']));
	}

}

/**
 * Register additional featured images metaboxes (5)
 */
add_action('add_meta_boxes', 'zass_add_additonal_featured_meta');
add_action('save_post', 'zass_save_additonal_featured_meta_postdata');

/* Adds a box to the side column on the Page/Post/Portfolio edit screens */
if (!function_exists('zass_add_additonal_featured_meta')) {

	function zass_add_additonal_featured_meta() {
		$post_types_array = array('page', 'post', 'zass-portfolio', 'tribe_events');

		for ($i = 2; $i <= 5; $i++) {
			foreach ($post_types_array as $post_type) {
				add_meta_box(
								'zass_featured_' . $i, esc_html__('Featured Image', 'zass-plugin') . ' ' . $i, 'zass_additonal_featured_meta_callback', $post_type, 'side', 'default', array('num' => $i)
				);
			}
		}
	}

}

/* Prints the box content */
if (!function_exists('zass_additonal_featured_meta_callback')) {

	function zass_additonal_featured_meta_callback($post, $args) {
		// Use nonce for verification
		wp_nonce_field('zass_save_additonal_featured_meta_postdata', 'zass_featuredmeta');

		$num = esc_attr($args['args']['num']);

		$image_id = get_post_meta(
						$post->ID, 'zass_featured_imgid_' . $num, true
		);

		$add_link_style = '';
		$del_link_style = '';

		$output = '<p class="hide-if-no-js">';
		$output .= '<span id="zass_featured_imgid_' . esc_attr($num) . '_images" class="zass_featured_img_holder">';

		if ($image_id) {
			$add_link_style = 'style="display:none"';
			$output .= wp_get_attachment_image($image_id, 'medium');
		} else {
			$del_link_style = 'style="display:none"';
		}

		$output .= '</span>';
		$output .= '</p>';

		$output .= '<p class="hide-if-no-js">';
		$output .= '<input id="zass_featured_imgid_' . esc_attr($num) . '" name="zass_featured_imgid_' . esc_attr($num) . '" type="hidden" value="' . esc_attr($image_id) . '" />';

		// delete link
		$output .= '<a id="delete_zass_featured_imgid_' . esc_attr($num) . '" ' . wp_kses_data($del_link_style) . ' class="zass_delete_image_button" href="#" title="' . esc_attr__('Remove featured image', 'zass-plugin') . ' ' . esc_attr($num) . '">' . esc_html__('Remove featured image', 'zass-plugin') . ' ' . esc_attr($num) . '</a>';

		// add link
		$output .= '<a id="upload_zass_featured_imgid_' . esc_attr($num) . '" ' . wp_kses_data($add_link_style) . ' data-uploader_title="' . esc_attr__('Select Featured Image', 'zass-plugin') . ' ' . esc_attr($num) . '" data-uploader_button_text="' . esc_attr__('Set Featured Image', 'zass-plugin') . ' ' . esc_attr($num) . '" class="zass_upload_image_button is_upload_link" href="#" title="' . esc_attr__('Set featured image', 'zass-plugin') . ' ' . esc_attr($num) . '">' . esc_html__('Set featured image', 'zass-plugin') . ' ' . esc_attr($num) . '</a>';


		$output .= '</p>';

		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_additonal_featured_meta_postdata')) {

	function zass_save_additonal_featured_meta_postdata($post_id) {
		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times

		if (isset($_POST['zass_featuredmeta']) && !wp_verify_nonce($_POST['zass_featuredmeta'], 'zass_save_additonal_featured_meta_postdata')) {
			return;
		}

		if (!current_user_can('edit_pages', $post_id)) {
			return;
		}

		foreach ($_POST as $key => $value) {
			if (strstr($key, 'zass_featured_imgid_')) {
				update_post_meta($post_id, sanitize_key($key), sanitize_text_field($value));
			}
		}
	}

}

/**
 * Register Portfolio enable Cloud Zoom metabox
 */
add_action('add_meta_boxes', 'zass_add_portfolio_cz_metabox');
add_action('save_post', 'zass_save_portfolio_cz_postdata');

if (!function_exists('zass_add_portfolio_cz_metabox')) {

	function zass_add_portfolio_cz_metabox() {
		add_meta_box(
						'zass_portfolio_cz', esc_html__('Portfolio Options', 'zass-plugin'), 'zass_portfolio_cz_callback', 'zass-portfolio', 'side', 'low'
		);
	}

}

/* Prints the box content */
if (!function_exists('zass_portfolio_cz_callback')) {

	function zass_portfolio_cz_callback($post) {

		// Use nonce for verification
		wp_nonce_field('zass_save_portfolio_cz_postdata', 'portfolio_cz_nonce');

		$custom = get_post_custom($post->ID);

		// Set default
		$zass_prtfl_custom_content = 0;
		$zass_prtfl_gallery = 'flex';

		if (isset($custom['zass_prtfl_custom_content']) && $custom['zass_prtfl_custom_content'][0]) {
			$zass_prtfl_custom_content = $custom['zass_prtfl_custom_content'][0];
		}
		if (isset($custom['zass_prtfl_gallery']) && $custom['zass_prtfl_gallery'][0]) {
			$zass_prtfl_gallery = $custom['zass_prtfl_gallery'][0];
		}

		$output = '<p><b>' . esc_html__('Custom Content:', 'zass-plugin') . '</b></p>';

		$output .= '<p><label for="zass_prtfl_custom_content">';
		$output .= "<input type='checkbox' id='zass_prtfl_custom_content' name='zass_prtfl_custom_content' value='1' " .
						checked(esc_attr($zass_prtfl_custom_content), 1, false) . ">" .
						esc_html__("Don't use the portfolio gallery and all portfolio related fields. Use only the content.", 'zass-plugin') . "</label></p>";

		$output .= '<p><b>' . esc_html__('Portfolio gallery will appear as:', 'zass-plugin') . '</b></p>';

		$output .= '<div><input id="zass_prtfl_gallery_flex" ' . checked($zass_prtfl_gallery, 'flex', false) . ' type="radio" value="flex" name="zass_prtfl_gallery">';
		$output .= '<label for="zass_prtfl_gallery_flex">' . esc_html__('Flex Slider', 'zass-plugin') . '</label></div>';
		$output .= '<div><input id="zass_prtfl_gallery_cloud" ' . checked($zass_prtfl_gallery, 'cloud', false) . ' type="radio" value="cloud" name="zass_prtfl_gallery">';
		$output .= '<label for="zass_prtfl_gallery_cloud">' . esc_html__('Cloud Zoom', 'zass-plugin') . '</label></div>';
		$output .= '<div><input id="zass_prtfl_gallery_list" ' . checked($zass_prtfl_gallery, 'list', false) . ' type="radio" value="list" name="zass_prtfl_gallery">';
		$output .= '<label for="zass_prtfl_gallery_list">' . esc_html__('Image List', 'zass-plugin') . '</label></div>';

		echo $output; // All dynamic data escaped
	}

}

/* When the post is saved, saves our custom data */
if (!function_exists('zass_save_portfolio_cz_postdata')) {

	function zass_save_portfolio_cz_postdata($post_id) {
		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// verify this came from our screen and with proper authorization,
		// because save_post can be triggered at other times

		if (isset($_POST['portfolio_cz_nonce']) && !wp_verify_nonce($_POST['portfolio_cz_nonce'], 'zass_save_portfolio_cz_postdata')) {
			return;
		}

		// Check the user's permissions.
		if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {

			if (!current_user_can('edit_pages', $post_id)) {
				return;
			}
		} else {

			if (!current_user_can('edit_posts', $post_id)) {
				return;
			}
		}

		if (isset($_POST['zass_prtfl_custom_content']) && $_POST['zass_prtfl_custom_content']) {
			update_post_meta($post_id, "zass_prtfl_custom_content", 1);
		} else {
			update_post_meta($post_id, "zass_prtfl_custom_content", 0);
		}

		// It is checkbox - if is in the post - is set, if not - is not set
		if (isset($_POST['zass_prtfl_gallery'])) {
			update_post_meta($post_id, "zass_prtfl_gallery", sanitize_text_field($_POST['zass_prtfl_gallery']));
		}
	}

}