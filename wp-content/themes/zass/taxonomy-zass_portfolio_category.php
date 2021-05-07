<?php

// The Taxonomy template file for zass-portfolio CPT.

get_header();
$zass_category_layout = json_decode(zass_get_option('portfoio_cat_layout'), true);

$zass_portfolio_style_class = $zass_category_layout['zass_portfolio_style_class'];
$zass_columns_class = $zass_category_layout['zass_columns_class'];


//If Masonry Fullwidth append fullwidth class to body
if ($zass_columns_class == 'zass_masonry_fullwidth') {

	$zass_inline_js ='(function ($) {"use strict"; $(document).ready(function () { $("#content > .inner").addClass("zass_masonry_fullwidth");});})(window.jQuery);';
	wp_add_inline_script('zass-front', $zass_inline_js);
	$zass_columns_class = '';
}

set_query_var('zass_portfolio_style_class', $zass_portfolio_style_class);
set_query_var('zass_columns_class', $zass_columns_class);

// Load the partial
get_template_part('partials/content', 'zass_portfolio_category');

get_footer();
