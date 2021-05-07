<?php
// Woocommerce specific functions
// Add support for woocommerce
add_theme_support('woocommerce');
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/** @var $product WC_Product */

// Disable WooCommerce styles
if (version_compare(WOOCOMMERCE_VERSION, "2.1") >= 0) {
	add_filter('woocommerce_enqueue_styles', '__return_false');
} else {
	define('WOOCOMMERCE_USE_CSS', false);
}

add_filter( 'woocommerce_breadcrumb_defaults', 'zass_woocommerce_breadcrumb_defaults' );
if ( ! function_exists( 'zass_woocommerce_breadcrumb_defaults' ) ) {
	function zass_woocommerce_breadcrumb_defaults( $args ) {
		$args['delimiter']   = ' | ';
		$args['wrap_before'] = '<div class="breadcrumb">';
		$args['wrap_after']  = '</div>';

		return $args;
	}
}

add_filter('woocommerce_breadcrumb_home_url', 'zass_woocommerce_breadcrumb_home_url');
if ( ! function_exists( 'zass_woocommerce_breadcrumb_home_url' ) ) {
	function zass_woocommerce_breadcrumb_home_url( $home_url ) {
		return zass_wpml_get_home_url();
	}
}

add_action( 'woocommerce_get_breadcrumb', 'zass_woocommerce_get_breadcrumb', 20, 2 );
if ( ! function_exists( 'zass_woocommerce_get_breadcrumb' ) ) {
	/**
	 * Hook into 'woocommerce_get_breadcrumb' in order to
	 * add path for the WCMP specific endpoints for vendor policies
	 * and reviews
	 *
	 * @param $crumbs
	 * @param $wc_breadcrumb
	 *
	 * @return array|mixed
	 */
	function zass_woocommerce_get_breadcrumb( $crumbs, $wc_breadcrumb ) {
		if ( class_exists( 'WCMp' ) ) {
			$vendor_query_var   = get_query_var( 'vendor', false );
			$reviews_query_var  = get_query_var( 'reviews', false ) === 'true';
			$policies_query_var = get_query_var( 'policies', false ) === 'true';

			if ( $vendor_query_var && ( $reviews_query_var || $policies_query_var ) ) {
				if ( empty( $crumbs[1][0] ) ) {
					unset( $crumbs[1] );
				}
				$crumbs[] = array( esc_html__( 'Vendor', 'zass' ), '' );
				$crumbs[] = array( esc_html( get_query_var( 'vendor' ) ), '' );
				if ( $reviews_query_var ) {
					$crumbs[] = array( esc_html__( 'Reviews', 'zass' ), '' );
				} elseif ( $policies_query_var ) {
					$crumbs[] = array( esc_html__( 'Policies', 'zass' ), '' );
				}
			}
		}

		return array_values( $crumbs );
	}
}

// removed breadcrumb from hook and call explicitly in wrapper-start
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Display the image part of the product in loop
 *
 * Takes into account product_hover_onproduct theme option
 */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_filter('woocommerce_before_shop_loop_item', 'zass_shop_loop_image', 10);

if ( ! function_exists( 'zass_shop_loop_image' ) ) {

	function zass_shop_loop_image() {
		global $post;
		echo '<div class="image">';

		?>

        <a href="<?php the_permalink(); ?>">
			<?php woocommerce_template_loop_product_thumbnail(); ?>
			<?php
			$second_image = zass_get_second_product_image_id( $post );
			// If we have swap image enabled and second image:
			if ( zass_get_option( 'product_hover_onproduct' ) == 'zass-prodhover-swap' && $second_image ):
				?>
				<?php
				$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

				$props = wc_get_product_attachment_props( $second_image, $post );
				echo wp_get_attachment_image( $second_image, $image_size, false, array(
					'title' => $props['title'],
					'alt'   => $props['alt']
				) );
				?>
			<?php endif; ?>
        </a>
        <!-- Small countdown -->
		<?php zass_shop_sale_countdown() ?>
		<?php
		echo '</div>';
	}

}

if ( ! function_exists( 'zass_get_second_product_image_id' ) ) {
	/**
	 * Returns the second product image ID (if any)
	 * Else returns false
	 *
	 * @param mixed $post Post object or post ID of the product.
	 *
	 * @return int|bool false if no second image OR the attachment ID of the image
	 */
	function zass_get_second_product_image_id( $post ) {
		$product  = wc_get_product( $post );
		$imageIds = $product->get_gallery_image_ids();

		if ( array_key_exists( 0, $imageIds ) ) {
			return $imageIds[0];
		}

		return false;
	}
}

/**
 * Checks if the product is in the new period
 *
 * @param WC_Product $product
 * @return boolean
 */
if (!function_exists('zass_is_product_new')) {

	function zass_is_product_new($product) {
	    /** @var $product WC_Product */

		$days_product_is_new = zass_get_option('new_label_period', 45);
		$post_date_dt = date_create($product->get_date_created());
		$curr_date_dt = date_create('now');
		$post_date_ts = $post_date_dt->format('Y-m-d');
		$curr_date_ts = $curr_date_dt->format('Y-m-d');

		$diff = abs(strtotime($post_date_ts) - strtotime($curr_date_ts));
		$diff/= 3600 * 24;

		if ($diff < $days_product_is_new) {
			return true;
		}

		return false;
	}

}

/**
 * Returns the "not sale" price.
 * Used by zass_get_product_saving()
 *
 * @param WC_Product $product
 * @return type
 */
if (!function_exists('zass_get_product_not_sale_price')) {

	function zass_get_product_not_sale_price($product) {

		/** @var $product WC_Product */

		if($product->is_type('variable')) {
		    return $product->get_variation_regular_price('min');
        } else {
		    return $product->get_regular_price();
        }
	}

}

/**
 * Gets product saving
 *
 * @param WC_Product $product
 * @return type
 */
if (!function_exists('zass_get_product_saving')) {

	function zass_get_product_saving($product) {
		/** @var $product WC_Product */
		if ($product->is_on_sale()) {
			$sale_price = $product->get_price();
			$not_sale_price = zass_get_product_not_sale_price($product);

			$saving = 0;
			if($not_sale_price) {
				$saving = 100 - $sale_price / $not_sale_price * 100;
			}

			return round($saving);
		}
	}

}

// Unload PrettyPhoto init for Woocommerce only
add_action('wp_enqueue_scripts', 'zass_remove_wc_prettyphoto');

if (!function_exists('zass_remove_wc_prettyphoto')) {

	function zass_remove_wc_prettyphoto() {
		wp_dequeue_script('prettyPhoto-init');
	}

}

// remove result count showing on top of category
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

// Display content holder
add_action('woocommerce_before_shop_loop', 'zass_add_content_holder', 5);
if (!function_exists('zass_add_content_holder')) {

	function zass_add_content_holder() {

		echo '<div class="content_holder">';

		$style_class = 'columns-' . zass_get_option('category_columns_num');

		if (zass_get_option('enable_shop_cat_carousel')) {
			// owl carousel
			wp_localize_script('zass-libs-config', 'zass_owl_carousel_cat', array(
					'columns' => esc_js(zass_get_option('category_columns_num'))
			));

			$style_class = 'owl-carousel zass-owl-carousel';
		}

		$display_type = woocommerce_get_loop_display_mode();
		if ( 'subcategories' === $display_type || 'both' === $display_type ) {
			$before_categories_html = '<div class="zass_woo_categories_shop woocommerce ' . esc_attr( $style_class ) . '">';
			echo woocommerce_maybe_show_product_subcategories($before_categories_html);
			echo '</div>';
		}



		if (zass_get_option('show_refine_area') && woocommerce_products_will_display()) {
			echo '<div class="box-sort-filter">';
			echo '<h2 class="heading-title">' . esc_html__('Refine Products', 'zass') . '</h2>';
			echo '<div class="product-filter">';
		}
	}

}

add_filter( 'woocommerce_price_filter_widget_step', 'zass_set_price_filter_widget_step' );
if ( ! function_exists( 'zass_set_price_filter_widget_step' ) ) {
	function zass_set_price_filter_widget_step() {
		return zass_get_option( 'price_filter_widget_step' );
	}
}

// Price filter on category pages
if (zass_get_option('show_pricefilter', 1) && zass_get_option('show_refine_area')) {
	add_action('woocommerce_before_shop_loop', 'zass_price_filter', 10);
}

if (!function_exists('zass_price_filter')) {

	function zass_price_filter() {
		global $wp;

		// Requires lookup table added in 3.6.
		if ( version_compare( get_option( 'woocommerce_db_version', null ), '3.6', '<' ) ) {
			return;
		}

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		// If there are not posts and we're not filtering, hide the widget.
		if ( ! WC()->query->get_main_query()->post_count && ! isset( $_GET['min_price'] ) && ! isset( $_GET['max_price'] ) ) { // WPCS: input var ok, CSRF ok.
			return;
		}

		wp_enqueue_style('jquery-ui');
		wp_enqueue_script( 'zass-price-slider', get_template_directory_uri() . '/js/zass-price-slider.js', array('jquery-ui-slider', 'wc-jquery-ui-touchpunch', 'accounting' ), false, true );

		// Round values to nearest 10 by default.
		$step = max( apply_filters( 'woocommerce_price_filter_widget_step', 10 ), 1 );

		// Find min and max price in current result set.
		$prices    = zass_get_filtered_price();
		$min_price = $prices->min_price;
		$max_price = $prices->max_price;

		// Check to see if we should add taxes to the prices if store are excl tax but display incl.
		$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );

		if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === $tax_display_mode ) {
			$tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
			$tax_rates = WC_Tax::get_rates( $tax_class );

			if ( $tax_rates ) {
				$min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
				$max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
			}
		}

		$min_price = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price / $step ) * $step );
		$max_price = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price / $step ) * $step );

		// If both min and max are equal, we don't need a slider.
		if ( $min_price === $max_price ) {
			return;
		}

		$current_min_price = isset( $_GET['min_price'] ) ? floor( floatval( wp_unslash( $_GET['min_price'] ) ) / $step ) * $step : $min_price; // WPCS: input var ok, CSRF ok.
		$current_max_price = isset( $_GET['max_price'] ) ? ceil( floatval( wp_unslash( $_GET['max_price'] ) ) / $step ) * $step : $max_price; // WPCS: input var ok, CSRF ok.

		// Remember current filters/search
		$fields = '';

		if (get_search_query()) {
			$fields .= '<input type="hidden" name="s" value="' . get_search_query() . '" />';
		}

		if (!empty($_GET['post_type'])) {
			$fields .= '<input type="hidden" name="post_type" value="' . esc_attr($_GET['post_type']) . '" />';
		}

		if (!empty($_GET['product_cat'])) {
			$fields .= '<input type="hidden" name="product_cat" value="' . esc_attr($_GET['product_cat']) . '" />';
		}

		if (!empty($_GET['product_tag'])) {
			$fields .= '<input type="hidden" name="product_tag" value="' . esc_attr($_GET['product_tag']) . '" />';
		}

		if (!empty($_GET['orderby'])) {
			$fields .= '<input type="hidden" name="orderby" value="' . esc_attr($_GET['orderby']) . '" />';
		}

		if (!empty($_GET['min_rating'])) {
			$fields .= '<input type="hidden" name="min_rating" value="' . esc_attr($_GET['min_rating']) . '" />';
		}

		if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
			foreach ($_chosen_attributes as $attribute => $data) {
				$taxonomy_filter = 'filter_' . str_replace('pa_', '', $attribute);

				$fields .= '<input type="hidden" name="' . esc_attr($taxonomy_filter) . '" value="' . esc_attr(implode(',', $data['terms'])) . '" />';

				if ('or' == $data['query_type']) {
					$fields .= '<input type="hidden" name="' . esc_attr(str_replace('pa_', 'query_type_', $attribute)) . '" value="or" />';
				}
			}
		}

		if ('' === get_option('permalink_structure')) {
			$form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));
		}

		echo '<form id="zass-price-filter-form" data-currency_pos="' . esc_attr(get_option('woocommerce_currency_pos')) . '" data-currency_symbol="' . esc_attr(get_woocommerce_currency_symbol()) . '"  method="get" action="' . esc_url($form_action) . '">
									<div id="price-filter" class="price_slider_wrapper">
										<div class="price_slider_amount" data-step="' . esc_attr( $step ) . '">
												<input type="hidden" id="min_price" name="min_price" value="' . esc_attr($current_min_price) . '" data-min="' . esc_attr($min_price) . '" placeholder="' . esc_attr__('Min price', 'zass') . '" />
												<input type="hidden" id="max_price" name="max_price" value="' . esc_attr($current_max_price) . '" data-max="' . esc_attr($max_price) . '" placeholder="' . esc_attr__('Max price', 'zass') . '" />
												<div class="price_label">
														<p>
																' . esc_html__('Price range:', 'zass') . ' <span id="zass_price_range"><span class="from"></span> &mdash; <span class="to"></span></span>
														</p>
												</div>
												' . $fields . '
												<div class="clear"></div>
										</div>
										<div class="price_slider"></div>
								</div>
						</form>';
	}

}

if (!function_exists('zass_get_filtered_price')) {

	function zass_get_filtered_price() {
		global $wpdb;

		$args       = WC()->query->get_main_query()->query_vars;
		$tax_query  = isset($args['tax_query']) ? $args['tax_query'] : array();
		$meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = WC()->query->get_main_tax_query();
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
				unset($meta_query[$key]);
			}
		}

		$meta_query = new WP_Meta_Query($meta_query);
		$tax_query = new WP_Tax_Query($tax_query);
		$search     = WC_Query::get_main_search_query_sql();

		$meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
		$tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');
		$search_query_sql = $search ? ' AND ' . $search : '';

		$sql = "
			SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
			FROM {$wpdb->wc_product_meta_lookup}
			WHERE product_id IN (
				SELECT ID FROM {$wpdb->posts}
				" . $tax_query_sql['join'] . $meta_query_sql['join'] . "
				WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = 'publish'
				" . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
			)';

		$sql = apply_filters( 'woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql );

		return $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.
	}

}

add_action('woocommerce_after_shop_loop', 'zass_wrap_after_shop_loop', 5);
if (!function_exists('zass_wrap_after_shop_loop')) {

	function zass_wrap_after_shop_loop() {
		echo '</div>'; // closes box-products
		echo '</div>'; // closes box-products container
	}

}

add_action('woocommerce_before_shop_loop', 'zass_wrap_before_shop_loop_after', 60);
if (!function_exists('zass_wrap_before_shop_loop_after')) {

	function zass_wrap_before_shop_loop_after() {

		$shop_default_product_columns = zass_get_option('shop_default_product_columns');

		if (zass_get_option('show_refine_area') && woocommerce_products_will_display()) {
			echo '<div class="clear"></div>';
			echo '</div>';
			echo '</div>';
		}

		echo '<div class="box-product-list">';
		echo '<div class="box-products woocommerce ' . esc_attr($shop_default_product_columns) . '">';
	}

}

// Changing products per page
add_filter('loop_shop_per_page', 'zass_set_products_per_page', 20);

if (!function_exists('zass_set_products_per_page')) {

	function zass_set_products_per_page() {
		$per_page = zass_get_option('products_per_page');
		if (array_key_exists('per_page', $_GET)) {
			$per_page = esc_attr($_GET['per_page']);
		}

		return $per_page;
	}

}

/**
 * Return the start and end sales dates for product on sale
 * If not on sale, return false
 *
 * @param type $post
 * @return boolean
 */
if (!function_exists('zass_get_product_sales_dates')) {

	function zass_get_product_sales_dates($post) {
		/** @var $product WC_Product */
		$start_sales_date = 9999999999;
		$end_sales_date = 0;

		$product = wc_get_product($post);
		if (!$product || !$product->is_on_sale())
			return false;

		$child_products = $product->get_children();
// If is variation product
		if (count($child_products)) {
			foreach ($child_products as $child_id) {
				$sale_price_dates_from = get_post_meta($child_id, '_sale_price_dates_from', true);
				$sale_price_dates_to = get_post_meta($child_id, '_sale_price_dates_to', true);

				if ($sale_price_dates_from && $sale_price_dates_from < $start_sales_date) {
					$start_sales_date = $sale_price_dates_from;
				}

				if ($sale_price_dates_to && $sale_price_dates_to > $end_sales_date) {
					$end_sales_date = $sale_price_dates_to;
				}
			}
		} else {
			$start_sales_date = get_post_meta($post->ID, '_sale_price_dates_from', true);
			$end_sales_date = get_post_meta($post->ID, '_sale_price_dates_to', true);
		}

		return array('from' => $start_sales_date, 'to' => $end_sales_date);
	}

}

// Show countdown for sales on product list
if (!function_exists('zass_shop_sale_countdown')) {

	function zass_shop_sale_countdown() {
		/**
		 * @var WC_Product $product
		 */
		global $post, $product;

		$sales_dates = zass_get_product_sales_dates($post);
		$now = time();

		if (zass_get_option('use_countdown', 'enabled') == 'enabled' && $product->is_on_sale() && $sales_dates['to'] && $now < $sales_dates['to']) {
			$random_num = uniqid();

			$inline_js = "jQuery(function () { jQuery('#zassCountSmallLatest" . esc_js($post->ID . $random_num) . "').countdown({until: new Date(\"" . esc_js(date('F j, Y G:i:s', $sales_dates['to'])) . "\"), compact: false});});";
			wp_add_inline_script('zass-plugins', $inline_js);
			?>
			<div class="count_holder_small">
				<div id="zassCountSmallLatest<?php echo esc_attr($post->ID . $random_num) ?>"></div>
				<div class="clear"></div>
			</div>
			<?php
		}
	}

}

// Show countdown for sales on the product page
add_filter('woocommerce_single_product_summary', 'zass_product_sale_countdown', 6);

if (!function_exists('zass_product_sale_countdown')) {

	function zass_product_sale_countdown() {
		global $post, $product;

		$sales_dates = zass_get_product_sales_dates($post);
		$now = time();

		if (zass_get_option('use_countdown', 'enabled') == 'enabled' && $product->is_on_sale() && $sales_dates['to'] && $now < $sales_dates['to']) {
			$unique_id = uniqid('zass_sale_countdown');

			// Below is in comments as it doesn't run in ajax quickview ('zass-plugins' is never enqueued)
			//$inline_js = "jQuery(function () { jQuery('#" . esc_attr($unique_id) . "').countdown({until: new Date(\"" . esc_js(date('F j, Y G:i:s', $sales_dates['to'])) . "\"), compact: false});});";
			//wp_add_inline_script('zass-plugins', $inline_js);
			?>
            <script>
                (function ($) {
                    "use strict";
                    $(window).on("load", function () {
                        $('#<?php echo esc_attr( $unique_id )?>').countdown({until: new Date("<?php echo esc_js( date( 'F j, Y G:i:s', $sales_dates['to'] ) )?>"), compact: false});
                    });
                })(window.jQuery);
            </script>
			<div class="count_holder"> <span class="offer_title"><?php esc_html_e('This limited offer ends in', 'zass') ?>:</span>
				<div id="<?php echo esc_attr($unique_id) ?>"></div>
				<?php if ($product->managing_stock()): ?>
					<div class="count_info"><?php echo wp_kses_post(sprintf(__('Hurry! Only <b>%u</b> left', 'zass'), $product->get_stock_quantity())) ?></div>
				<?php endif; ?>
				<div class="count_info_left"><?php esc_html_e('Saving', 'zass') ?>: <b><?php echo zass_get_product_saving($product) ?>%</b></div>
				<div class="clear"></div>
			</div>
			<?php
		}
	}

}

// Wrap cart with div before
add_filter('woocommerce_before_cart_table', 'zass_wrap_cart_before', 10);

if (!function_exists('zass_wrap_cart_before')) {

	function zass_wrap_cart_before() {
		echo '<div class="cart-info">';
	}

}

// Wrap cart with div after
add_filter('woocommerce_after_cart_table', 'zass_wrap_cart_after', 10);

if (!function_exists('zass_wrap_cart_after')) {

	function zass_wrap_cart_after() {
		echo '</div>';
	}

}

// Ensure cart contents update when products are added to the cart via AJAX
add_filter('woocommerce_add_to_cart_fragments', 'zass_header_add_to_cart_fragment');
if (!function_exists('zass_header_add_to_cart_fragment')) {

	function zass_header_add_to_cart_fragment($fragments) {
		ob_start();

		zass_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}

}

// Adding content holder (closed in content-single-product)
add_action('woocommerce_before_single_product_summary', 'zass_insert_content_holder', 5);
if (!function_exists('zass_insert_content_holder')) {

	function zass_insert_content_holder() {
		echo '<div class="content_holder">';
	}

}

/**
 * Override woocommerce_taxonomy_archive_description
 * Show an archive description on taxonomy archives
 *
 * @return void
 */
function woocommerce_taxonomy_archive_description() {
	if (is_tax(array('product_cat', 'product_tag')) && get_query_var('paged') == 0) {
		$description = wpautop(do_shortcode(term_description()));

		$thumbnail_id = get_metadata( 'woocommerce_term', get_queried_object()->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url($thumbnail_id);

		if ($description || $image) {
			if ($image) {
				$output = '<img class="pic-cat-main" src="' . esc_url($image) . '" alt="' . esc_attr(single_term_title('', false)) . '" />' . $description;
			} else {
				$output = $description;
			}

			echo '<div class="term-description fixed ' . sanitize_html_class( zass_get_option( 'category_description_position' ) ) . '">' . $output . '</div>';
		}
	}
}

/**
 * Override the woocommerce function
 * Show a shop page description on product archives
 *
 * @subpackage	Archives
 */
function woocommerce_product_archive_description() {
	if (is_post_type_archive('product') && get_query_var('paged') == 0) {
		$shop_page = get_post(wc_get_page_id('shop'));
		if ($shop_page) {
			$description = wc_format_content($shop_page->post_content);
			if ($description) {
				echo '<div class="page-description fixed">' . $description . '</div>';
			}
		}
	}
}

// Cutting of the product title if exceeds 36 chars
if (!function_exists('zass_short_product_title')) {

	function zass_short_product_title($title, $short_title_length = 52) {

		if (mb_strlen($title) > $short_title_length) {
			return mb_substr($title, 0, $short_title_length - 3) . '...';
		}

		return $title;
	}

}

// Override Woocommerce Compare add link
// if Woocompare is activated
if (defined('YITH_WOOCOMPARE')) {
	global $yith_woocompare;

	$woocompareFrontEnd = $yith_woocompare->obj;
	remove_action('woocommerce_after_shop_loop_item', array($woocompareFrontEnd, 'add_compare_link'), 20);

	if (!function_exists('zass_add_compare_link')) {

		function zass_add_compare_link($product_id = false, $args = array()) {
			extract($args);

			global $yith_woocompare;
			$woocompareFrontEnd = $yith_woocompare->obj;

			if (!method_exists($woocompareFrontEnd, 'add_product_url')) {
				return false;
			}

			if (!$product_id) {
				global $product;
				$product_id = ($product->get_id()) && $product->exists() ? $product->get_id() : 0;
			}

			// return if product doesn't exist
			if (empty($product_id)) {
				return;
			}

			$is_button = !isset($button_or_link) || !$button_or_link ? get_option('yith_woocompare_is_button') : $button_or_link;

			if (!isset($button_text) || $button_text == 'default') {
				$button_text = get_option('yith_woocompare_button_text', esc_html__('Compare', 'zass'));
				$button_text = function_exists('icl_translate') ? icl_translate('Plugins', 'plugin_yit_compare_button_text', $button_text) : $button_text;
			}

			printf('<a href="%s" class="%s" data-product_id="%d" title="%s"><i class="fa fa-tasks"></i></a>', esc_url($woocompareFrontEnd->add_product_url($product_id)), 'compare' . ( $is_button == 'button' ? ' button' : '' ), esc_attr($product_id), esc_attr($button_text));
		}

	}
}

// Move woocommerce_template_loop_price to be below the title
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

// If related products are set to zero hide them
if(zass_get_option('number_related_products') == 0) {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}

add_filter('woocommerce_output_related_products_args', 'zass_related_products_args');
if (!function_exists('zass_related_products_args')) {

	/**
	 * WooCommerce Extra Feature
	 * --------------------------
	 *
	 * Change number of related products on product page
	 * Set your own value for 'posts_per_page'
	 *
	 */
	function zass_related_products_args($args) {

		$args['posts_per_page'] = zass_get_option('number_related_products'); // number_related_products theme option
		$args['columns'] = 1; // arranged in 1 columns

		return $args;
	}

}

add_action('woocommerce_single_product_summary', 'zass_add_this_share', 99);
if (!function_exists('zass_add_this_share')) {

	/**
	 * Display share links on product pages
	 */
	function zass_add_this_share() {
		if (function_exists('zass_share_links')) {
			zass_share_links( get_the_title(), get_permalink());
		}
	}

}

/**
 * Cart Link
 * Displayed a link to the cart including the number of items present and the cart total
 * @param  array $settings Settings
 * @return array           Settings
 */
if (!function_exists('zass_cart_link')) {

	function zass_cart_link() {
		if (is_cart()) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<li class="<?php echo sanitize_html_class($class); ?>">
			<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'zass'); ?>">
				<span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</a>
		</li>
		<?php
	}

}

/**
 * If is set list view for product categories remove the links from current action
 * they are appended in content-product.php
 */
if (zass_get_option('shop_default_product_columns') == 'zass-products-list-view') {
	// div .links section
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
}

// Quickview ajax actions
if (!function_exists('zass_quickview')) {

	function zass_quickview() {
		global $post, $product;
		$prod_id = esc_attr($_POST["productid"]);
		$post = get_post($prod_id);
		$product = wc_get_product($prod_id);

		wc_get_template('content-single-product-zass-quickview.php');

		wp_die();
	}

}

add_action('wp_ajax_zass_quickview', 'zass_quickview');
add_action('wp_ajax_nopriv_zass_quickview', 'zass_quickview');

// Ajax add to cart on product single
if (!function_exists('zass_wc_add_cart_ajax')) {
	function zass_wc_add_cart_ajax() {

		$wc_notices = WC()->session->get('wc_notices');
		WC()->session->set('wc_notices', array());

		if ( is_array( $wc_notices ) ) {
			foreach ( $wc_notices as $notice_level => $notice ) {
				if ( $notice_level === 'error' ) {
					$notice_message = is_array( $notice[0] ) ? $notice[0]['notice'] : $notice[0];

					// regex to remove html tags and content
					$regex         = '/<[^>]*>[^<]*<[^>]*>/';
					$alert_message = html_entity_decode( preg_replace( $regex, '', $notice_message ) );
					$response      = array(
						'error_message' => $alert_message
					);

					wp_send_json( $response );
				}
			}
		}

		WC_AJAX::get_refreshed_fragments();

		wp_die();
	}
}

add_action('wp_ajax_zass_wc_add_cart', 'zass_wc_add_cart_ajax');
add_action('wp_ajax_nopriv_zass_wc_add_cart', 'zass_wc_add_cart_ajax');

// Force variable attributes to show below the product
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );

add_action('woocommerce_after_shop_loop', 'zass_shop_sidebar', 15);
if (!function_exists('zass_shop_sidebar')) {

	function zass_shop_sidebar() {
		echo '</div>'; // closes content_holder
		if (zass_get_option('show_sidebar_shop')) {
			do_action('woocommerce_sidebar');
			echo '<div class="clear"></div>';
		}
	}

}

// WCMp store page callback
add_action( 'wcmp_before_main_content', 'zass_wcmp_before_main_content' );
if ( ! function_exists( 'zass_wcmp_before_main_content' ) ) {
	function zass_wcmp_before_main_content() {
		wc_get_template( 'global/wrapper-start.php' );
		echo '<div id="main" class="fixed box box-common">';
	}
}

add_action( 'init', 'zass_wcmp_hooks', 99 );
if ( ! function_exists( 'zass_wcmp_hooks' ) ) {
	function zass_wcmp_hooks() {
		global $WCMp;
		if ( isset( $WCMp->frontend ) ) {
			remove_action( 'wcmp_after_main_content', array( $WCMp->frontend, 'wcmp_after_main_content' ) );
		}
	}
}

add_action( 'wcmp_after_main_content', 'zass_wcmp_after_main_content' );
if ( ! function_exists( 'zass_wcmp_after_main_content' ) ) {
	function zass_wcmp_after_main_content() {
		wc_get_template( 'global/wrapper-end.php' );
		echo "</div>";
	}
}