<?php

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_Zass_Content_Slider|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 *
 * Copied from vc-tta-global.php
 */
$el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$this->resetVariables($atts, $content);
extract($atts);

$this->setGlobalTtaInfo();

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);

$unique_id = uniqid('zass_content_slider');

$output_escaped = '<div id="' . esc_attr($unique_id) . '" class="zass_content_slider' . ($css_class ? ' ' . esc_attr($css_class) : '') . '">';
$output_escaped .= $this->getTemplateVariable('title');
$output_escaped .= '<div class="vc_tta-panels owl-carousel">';
$output_escaped .= $this->getTemplateVariable('content');
$output_escaped .= '</div>';
$output_escaped .= $this->getTemplateVariable('tabs-list-bottom');
$output_escaped .= $this->getTemplateVariable('tabs-list-right');
$output_escaped .= '</div>';

$autoplay_owl_option = 'false';
$autoplayTimeout_owl_option = '5000';
if ($autoplay !== 'none') {
	$autoplay_owl_option = 'true';
	$autoplayTimeout_owl_option = $autoplay . '000';
}

$navigation_owl_option = 'false';
if ($navigation === 'yes') {
	$navigation_owl_option = 'true';
}

$pagination_owl_option = 'false';
if ($pagination === 'yes') {
	$pagination_owl_option = 'true';
}

$animateOut = 'false';
$animateIn = 'false';
if ($transition === 'fade') {
	$animateOut = 'fadeOut';
	$animateIn = 'fadeIn';
} elseif ($transition === 'slide-flip') {
	$animateOut = 'slideOutDown';
	$animateIn = 'flipInX';
}

$inline_js = '(function ($) {
		"use strict";
		$(window).on("load", function () {
			setTimeout(function(){
				jQuery("#' . esc_js($unique_id) . ' > .vc_tta-panels").owlCarousel({
					rtl: '.( is_rtl() ? 'true' : 'false' ).',
					items: 1,
					loop: true,
					autoplayHoverPause: true,
					stopOnHover: true,
					autoplay: ' . esc_js($autoplay_owl_option) . ',
					autoplayTimeout: ' . esc_js($autoplayTimeout_owl_option) . ',
					autoplaySpeed: 800,
					dots: ' . esc_js($pagination_owl_option) . ',
					nav: ' . esc_js($navigation_owl_option) . ',
					navText: [
						"<i class=\'fas fa-angle-left\'></i>",
						"<i class=\'fas fa-angle-right\'></i>"
					],
					animateOut: ' . ($animateOut == 'false' ? 'false' : '"' . esc_js($animateOut) . '"') . ',
					animateIn: ' . ($animateIn == 'false' ? 'false' : '"' . esc_js($animateIn) . '"') . ', ' . ($transition === 'slide-flip' ? 'smartSpeed:450,' : '') . '
				}, 10)
			});
		});
	})(window.jQuery);';
wp_add_inline_script('zass-plugins', $inline_js);

// This variable has been safely escaped in the following file: zass/vc_templates/vc_zass_content_slider.php Line: 26 - 33
echo $output_escaped; // All dynamic data escaped.
