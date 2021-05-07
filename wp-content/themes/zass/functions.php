<?php
/* Load core functions */
require_once (get_template_directory() . '/incl/system/core-functions.php');

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/*
 * Loads the Options Panel
 */
if (!function_exists('zass_optionsframework_init')) {
	define('ZASS_OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/incl/zass-options-framework/');
	// framework
	require_once get_template_directory() . '/incl/zass-options-framework/zass-options-framework.php';
	// custom functions
	require_once get_template_directory() . '/incl/zass-options-framework/zass-options-functions.php';
}

/* Load configuration */
require_once (get_template_directory() . '/incl/system/config.php');

/**
 * Echo the pagination
 */
if (!function_exists('zass_pagination')) {

	function zass_pagination($pages = '', $wp_query = '') {
		if (empty($wp_query)) {
			global $wp_query;
		}

		$range = 3;
		$posts_per_page = get_query_var('posts_per_page');
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$html = '';

		if ($pages == '') {

			if (isset($wp_query->max_num_pages)) {
				$pages = $wp_query->max_num_pages;
			}

			if (!$pages) {
				$pages = 1;
			}
		}

		if (1 != $pages) {
			$html .= "<div class='pagination'><div class='links'>";
			if ($paged > 2) {
				$html .= "<a href='" . esc_url(get_pagenum_link(1)) . "'>&laquo;</a>";
			}
			if ($paged > 1) {
				$html .= "<a href='" . esc_url(get_pagenum_link($paged - 1)) . "'>&lsaquo;</a>";
			}

			for ($i = 1; $i <= $pages; $i++) {
				if (1 != $pages && (!( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) )) {
					$class = ( $paged == $i ) ? " class='selected'" : '';
					$html .= "<a href='" . esc_url(get_pagenum_link($i)) . "'$class >$i</a>";
				}
			}

			if ($paged < $pages) {
				$html .= "<a class='next_page' href='" . esc_url(get_pagenum_link($paged + 1)) . "'>&rsaquo;</a>";
			}
			if ($paged < $pages - 1) {
				$html .= "<a href='" . esc_url(get_pagenum_link($pages)) . "'>&raquo;</a>";
			}

			$first_article_on_page = ( $posts_per_page * $paged ) - $posts_per_page + 1;

			$last_article_on_page = min($wp_query->found_posts, $wp_query->get('posts_per_page') * $paged);

			$html .= "</div><div class='results'>";
			$html .= sprintf(esc_html__('Showing %1$s to %2$s of %3$s (%4$s Pages)', 'zass'), $first_article_on_page, $last_article_on_page, $wp_query->found_posts, $pages);
			$html .= "</div></div>";
		}

		echo apply_filters('zass_pagination', $html);
	}

}

/**
 * Return the page breadcrumbs
 *
 */
if ( ! function_exists( 'zass_breadcrumb' ) ) {

	function zass_breadcrumb( $delimiter = ' | ' ) {

		if ( zass_get_option( 'show_breadcrumb', 1 ) && ! is_404() ) {
			$home      = esc_html__( 'Home', 'zass' ); // text for the 'Home' link
			$before    = '<span class="current-crumb">'; // tag before the current crumb
			$after     = '</span>'; // tag after the current crumb
			$brdcrmb   = '';
			$delimiter = esc_html( $delimiter );

			global $post;
			global $wp_query;
			$homeLink = esc_url(zass_wpml_get_home_url());

			if ( ! is_home() && ! is_front_page() ) {
				$brdcrmb .= '<a class="home" href="' . esc_url( $homeLink ) . '">' . $home . '</a> ' . $delimiter . ' ';
			}

			if ( is_category() ) {
				$cat_obj   = $wp_query->get_queried_object();
				$thisCat   = $cat_obj->term_id;
				$thisCat   = get_category( $thisCat );
				$parentCat = get_category( $thisCat->parent );

				if ( $thisCat->parent != 0 ) {
					$brdcrmb .= get_category_parents( $parentCat, true, ' ' . $delimiter . ' ' );
				}

				$brdcrmb .= $before . single_cat_title( '', false ) . $after;
				/* If is taxonomy or BBPress topic tag */
			} elseif ( is_tax() || get_query_var( 'bbp_topic_tag' ) ) {
				$cat_obj   = $wp_query->get_queried_object();
				$thisCat   = $cat_obj->term_id;
				$thisCat   = get_term( $thisCat, $cat_obj->taxonomy );
				$parentCat = get_term( $thisCat->parent, $cat_obj->taxonomy );
				$tax_obj   = get_taxonomy( $cat_obj->taxonomy );
				$brdcrmb .= $tax_obj->labels->name . ': ';

				if ( $thisCat->parent != 0 ) {
					$brdcrmb .= zass_get_taxonomy_parents( $parentCat, $cat_obj->taxonomy, true, ' ' . $delimiter . ' ' );
				}
				$brdcrmb .= $before . $thisCat->name . $after;
			} elseif ( is_day() ) {
				$brdcrmb .= '<a class="no-link" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				$brdcrmb .= '<a class="no-link" href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
				$brdcrmb .= $before . get_the_time( 'd' ) . $after;
			} elseif ( is_month() ) {
				$brdcrmb .= '<a class="no-link" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				$brdcrmb .= $before . get_the_time( 'F' ) . $after;
			} elseif ( is_year() ) {
				$brdcrmb .= $before . get_the_time( 'Y' ) . $after;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( get_post_type( $wp_query->post->ID ) == 'zass-portfolio' ) {

					$post_type = get_post_type_object( 'zass-portfolio' );
					$slug      = $post_type->rewrite;
					$brdcrmb .= '<a class="no-link" href="' . esc_url( $homeLink . '/' . $slug['slug'] ) . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';

					$terms = get_the_terms( $post->ID, 'zass_portfolio_category' );

					if ( $terms ) {
						$first_cat       = reset( $terms );
						$parent_term_ids = zass_get_zass_portfolio_category_parents( $first_cat->term_id );

						$term_links = '';
						foreach ( $parent_term_ids as $term_id ) {
							$term = get_term( $term_id, 'zass_portfolio_category' );
							$term_links .= '<a href="' . esc_url( get_term_link( $term_id ) ) . '">' . $term->name . '</a>' . $delimiter;
						}

						$brdcrmb .= $term_links;
					}

					$brdcrmb .= $before . get_the_title( $wp_query->post->ID ) . $after;
				} elseif ( get_post_type( $wp_query->post->ID ) != 'post' ) {
					$post_type = get_post_type_object( get_post_type( $wp_query->post->ID ) );
					$slug      = $post_type->rewrite;
					$real_slug = $slug['slug'];
					if ( $slug['slug'] == 'forums/forum' ) {
						$real_slug = 'forums';
					}
					if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() ) { // If is Topic
						if ( is_singular() ) {
							$ancestors = array_reverse( (array) get_post_ancestors( $wp_query->post->ID ) );
							// Ancestors exist
							if ( ! empty( $ancestors ) ) {
								// Loop through parents
								foreach ( (array) $ancestors as $parent_id ) {
									// Parents
									$parent = get_post( $parent_id );
									// Skip parent if empty or error
									if ( empty( $parent ) || is_wp_error( $parent ) ) {
										continue;
									}
									// Switch through post_type to ensure correct filters are applied
									switch ( $parent->post_type ) {
										// Forum
										case bbp_get_forum_post_type() :
											$crumbs[] = '<a href="' . esc_url( bbp_get_forum_permalink( $parent->ID ) ) . '" >' . bbp_get_forum_title( $parent->ID ) . '</a>';
											break;
										// Topic
										case bbp_get_topic_post_type() :
											$crumbs[] = '<a href="' . esc_url( bbp_get_topic_permalink( $parent->ID ) ) . '" >' . bbp_get_topic_title( $parent->ID ) . '</a>';
											break;
										// Reply (Note: not in most themes)
										case bbp_get_reply_post_type() :
											$crumbs[] = '<a href="' . esc_url( bbp_get_reply_permalink( $parent->ID ) ) . '" >' . bbp_get_reply_title( $parent->ID ) . '</a>';
											break;
										// WordPress Post/Page/Other
										default :
											$crumbs[] = '<a href="' . esc_url( get_permalink( $parent->ID ) ) . '" >' . get_the_title( $parent->ID ) . '</a>';
											break;
									}
								}

								// Edit topic tag
							}
						}

						$page = bbp_get_page_by_path( bbp_get_root_slug() );
						if ( ! empty( $page ) ) {
							$root_url = get_permalink( $page->ID );

							// Use the root slug
						} else {
							$root_url = get_post_type_archive_link( bbp_get_forum_post_type() );
						}

						$brdcrmb .= '<a class="no-link" href="' . esc_url( $root_url ) . '">' . esc_html__( 'Forums', 'zass' ) . '</a> ' . $delimiter . ' ';
						foreach ( $crumbs as $crumb ) {
							$brdcrmb .= $crumb . ' ' . $delimiter;
						}

					} elseif ( ! in_array( $post_type->name, array( 'tribe_venue', 'tribe_organizer' ) ) ) {
						$brdcrmb .= '<a class="no-link" href="' . esc_url( $homeLink . '/' . $real_slug ) . '/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
					} else {
						$brdcrmb .= '<span>' . $post_type->labels->name . '</span> ' . $delimiter . ' ';
					}

					$brdcrmb .= $before . get_the_title( $wp_query->post->ID ) . $after;
				} else {
					$cat = get_the_category();
					$cat = $cat[0];
					$brdcrmb .= get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
					$brdcrmb .= $before . get_the_title( $wp_query->post->ID ) . $after;
				}
			} elseif ( ! is_single() && ! is_page() && ! is_404() && ! is_search() && isset($wp_query->post->ID) && get_post_type( $wp_query->post->ID ) != 'post') {
				$post_type = get_post_type_object( get_post_type( $wp_query->post->ID ) );
				if ( $post_type ) {
					$brdcrmb .= $before . $post_type->labels->singular_name . $after;
				}
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );
				if ( ! empty( $cat ) ) {
					$cat         = $cat[0];
					$cat_parents = get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
					if ( ! is_wp_error( $cat_parents ) ) {
						$brdcrmb .= get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
					}
				}
				$brdcrmb .= '<a class="no-link" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
				$brdcrmb .= $before . get_the_title( $wp_query->post->ID ) . $after;
			} elseif ( is_page() && ! $post->post_parent ) {
				$brdcrmb .= $before . get_the_title( $wp_query->post->ID ) . $after;
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();

				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$breadcrumbs[] = '<a class="no-link" href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id     = $page->post_parent;
				}

				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					$brdcrmb .= $crumb . ' ' . $delimiter . ' ';
				}

				$brdcrmb .= $before . get_the_title( $wp_query->post->ID ) . $after;
			} elseif ( is_search() ) {
				$brdcrmb .= $before . 'Search results for "' . get_search_query() . '"' . $after;
			} elseif ( is_tag() ) {
				$brdcrmb .= $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				$brdcrmb .= $before . 'Articles posted by ' . esc_attr( $userdata->display_name ) . $after;
			} elseif ( is_404() ) {
				$brdcrmb .= $before . 'Error 404' . $after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					$brdcrmb .= ' (';
				}

				$brdcrmb .= $before . esc_html__( 'Page', 'zass' ) . ' ' . get_query_var( 'paged' ) . $after;

				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					$brdcrmb .= ')';
				}
			}

			if ( $brdcrmb ) {
				echo '<div class="breadcrumb">';
				echo wp_kses_post( $brdcrmb );
				echo '</div>';
			}
		} else {
			return false;
		}
	}

}

/**
 * Template for comments and pingbacks.
 */
if (!function_exists('zass_comment')) {

	function zass_comment($comment, $args, $depth) {
		if ( $comment->comment_author !== 'ActionScheduler' ) {
			$GLOBALS['comment'] = $comment;
			switch ( $comment->comment_type ) {
				case 'pingback' :
				case 'trackback' :
					?>
                    <li class="post pingback">
                    <p><?php esc_html_e( 'Pingback:', 'zass' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'zass' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>" class="comment-body">
						<?php
						$avatar_size = 70;
						echo get_avatar( $comment, $avatar_size );
						echo sprintf( '<span class="tuser">%s</span>', get_comment_author_link() );
						echo sprintf( '<span>%1$s</span>',
							/* translators: 1: date, 2: time */ sprintf( esc_html__( '%1$s at %2$s', 'zass' ), get_comment_date(), get_comment_time() )
						);
						?>
						<?php edit_comment_link( esc_html__( 'Edit', 'zass' ), '<span class="edit-link">', '</span>' ); ?>
						<?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'zass' ); ?></em>
                            <br/>
						<?php endif; ?>

                        <p><?php comment_text(); ?></p>

						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'zass' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

                    </div><!-- #comment-## -->

					<?php
					break;
			}
		}
	}
}

	/*
	 * Add custom image sizes for the zass theme blog part
	 */
	if (function_exists('add_image_size')) {
		add_image_size('zass-blog-category-thumb', 1130); //1130 pixels wide (and unlimited height)
		add_image_size('zass-portfolio-single-thumb', 800);
		add_image_size('zass-general-big-size', 800, 800, true); //(cropped)
		add_image_size('zass-640x480', 640, 480, true); //(cropped)
		add_image_size('zass-portfolio-category-thumb', 550, 550, true); //(cropped)
		add_image_size('zass-portfolio-category-thumb-real', 550);
		add_image_size('zass-blog-small-image-size', 400, 400, true); //(cropped)
		add_image_size('zass-general-medium-size', 200, 150);
		add_image_size('zass-general-small-size', 100, 100, true); //(cropped)
		add_image_size('zass-general-small-size-nocrop', 100); // (not cropped)
		add_image_size('zass-widgets-thumb', 60, 60, true); //(cropped)
		add_image_size('zass-icon', 50, 50);
		add_image_size('zass-related-posts', 300, 225, true); //(cropped)

	}

	add_filter('wp_prepare_attachment_for_js', 'zass_append_image_sizes_js', 10, 3);
	if (!function_exists('zass_append_image_sizes_js')) {

		/**
		 * Append the 'zass-general-medium-size', 'zass-general-small-size' custom
		 * sizes to the attachment elements returned by the wp.media
		 *
		 * @param type $response
		 * @param type $attachment
		 * @param type $meta
		 * @return string
		 */
		function zass_append_image_sizes_js($response, $attachment, $meta) {

			$size_array = array('zass-general-medium-size', 'zass-general-small-size');

			foreach ($size_array as $size):

				if (isset($meta['sizes'][$size])) {
					$attachment_url = wp_get_attachment_url($attachment->ID);
					$base_url = str_replace(wp_basename($attachment_url), '', $attachment_url);
					$size_meta = $meta['sizes'][$size];

					$response['sizes'][str_replace('-', '_', $size)] = array(
							'height' => $size_meta['height'],
							'width' => $size_meta['width'],
							'url' => $base_url . $size_meta['file'],
							'orientation' => $size_meta['height'] > $size_meta['width'] ? 'portrait' : 'landscape',
					);
				}

			endforeach;

			return $response;
		}

	}

	add_action('init', 'zass_enable_page_attributes');

	/**
	 * Add page attributes to page post type
	 * - Gives option to select template
	 * Adds excerpt support for pages - mainly used by the About widget
	 */
	if (!function_exists('zass_enable_page_attributes')) {

		function zass_enable_page_attributes() {
			add_post_type_support('page', 'page-attributes');
			add_post_type_support('page', 'excerpt');
		}

	}

	/**
	 * Display language switcher
	 *
	 * @return String
	 */
	if (!function_exists('zass_language_selector_flags')) {

		function zass_language_selector_flags() {
			$languages = icl_get_languages('skip_missing=0&orderby=code');

			if (!empty($languages)) {
				foreach ($languages as $l) {
					if (!$l['active']) {
						echo '<a title="' . esc_attr($l['native_name']) . '" href="' . esc_url($l['url']) . '">';
					}

					echo '<img src="' . esc_url($l['country_flag_url']) . '" height="12" alt="' . esc_attr($l['language_code']) . '" width="18" />';

					if (!$l['active']) {
						echo '</a>';
					}
				}
			}
		}

	}

    add_filter('excerpt_more', 'zass_new_excerpt_more');
	if (!function_exists('zass_new_excerpt_more')) {

		/**
		 * Set custom excerpt more
		 *
		 * @param type $more If is set as 'no_hash' #more keyword is not appended in the url
		 * @return string
		 */
		function zass_new_excerpt_more($more) {

			$more_html = ' ...<a class="r_more_blog" href="';
			if ('no_hash' === $more) {
				$more_html .= esc_url(get_the_permalink());
			} else {
				$more_html .= esc_url(get_the_permalink() . '#more-' . esc_attr(get_the_ID()));
			}

			$more_html .= '"><i class="fa fa-sign-in"></i> ' . esc_html__('read more', 'zass') . '</a>';

			return $more_html;
		}

	}

	/**
	 * Set custom content more link
	 *
	 * @return String
	 */
	add_filter('the_content_more_link', 'zass_content_more_link');

	if (!function_exists('zass_content_more_link')) {

		function zass_content_more_link() {
			return '<a class="r_more_blog" href="' . esc_url(get_permalink() . '#more-' . esc_attr(get_the_ID())) . '"><i class="fa fa-sign-in"></i> ' . esc_html__('read more', 'zass') . '</a>';
		}

	}

	/**
	 * Adds one-half one-third one-forth class to footer widgets
	 */
	if (!function_exists('zass_widget_class_append')) {

		function zass_widget_class_append($params) {

			$sidebar_id = $params[0]['id']; // Get the id for the current sidebar we're processing

			if ($sidebar_id != 'bottom_footer_sidebar' && $sidebar_id != 'pre_header_sidebar') {
				return $params;
			}

			$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets
			$num_widgets_sidebar = count($arr_registered_widgets[$sidebar_id]);
			$class = 'class="';

			switch ($num_widgets_sidebar) {
				case 0:
				case 1:
					break;
				case 2:
					$class .= 'one_half ';
					break;
				case 3:
					$class .= 'one_third ';
					break;
				default:
					$class .= 'one_fourth ';
			}

			if (!isset($arr_registered_widgets[$sidebar_id]) || !is_array($arr_registered_widgets[$sidebar_id])) { // Check if the current sidebar has no widgets
				return $params; // No widgets in this sidebar.
			}

			$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

			return $params;
		}

	}
	add_filter('dynamic_sidebar_params', 'zass_widget_class_append');

	if (!function_exists('zass_get_zass_portfolio_category_parents')) {

		/**
		 * Get list of all parent zass_portfolio_category-s
		 *
		 * @param int $term_id
		 * @return Array with term ids
		 */
		function zass_get_zass_portfolio_category_parents($term_id) {
			$parents = array();
			// start from the current term
			$parent = get_term_by('id', $term_id, 'zass_portfolio_category');
			$parents[] = $parent;
			// climb up the hierarchy until we reach a term with parent = '0'
			while ($parent->parent != '0') {
				$term_id = $parent->parent;

				$parent = get_term_by('id', $term_id, 'zass_portfolio_category');
				$parents[] = $parent;
			}
			return $parents;
		}

	}

	add_action('wp_ajax_zass_ajax_search', 'zass_ajax_search');
	add_action('wp_ajax_nopriv_zass_ajax_search', 'zass_ajax_search');

	if (!function_exists('zass_ajax_search')) {

		function zass_ajax_search() {

			unset($_REQUEST['action']);
			if (empty($_REQUEST['s'])) {
				$_REQUEST['s'] = array_shift(array_values($_REQUEST));
			}
			if (empty($_REQUEST['s'])) {
				wp_die();
			}


			$defaults = array('numberposts' => 5, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false);
			$_REQUEST['s'] = apply_filters('get_search_query', $_REQUEST['s']);

			$parameters = array_merge($defaults, $_REQUEST);
			$query = http_build_query($parameters);
			$result = get_posts($query);

			// If there are WC products in the result and visibility is not set for search - remove them
			if(ZASS_IS_WOOCOMMERCE) {
				foreach ( $result as $key => $post ) {
					$product = wc_get_product( $post );
					if ( is_a($product, 'WC_Product') && !('visible' === $product->get_catalog_visibility() || 'search' === $product->get_catalog_visibility()) ) {
						unset($result[$key]);
					}
				}
			}

			$search_messages = array(
					'no_criteria_matched' => esc_html__("Sorry, no posts matched your criteria", 'zass'),
					'another_search_term' => esc_html__("Please try another search term", 'zass'),
					'time_format' => esc_attr(get_option('date_format')),
					'all_results_query' => http_build_query($_REQUEST),
					'all_results_link' => esc_url(home_url('?' . http_build_query($_REQUEST))),
					'view_all_results' => esc_html__('View all results', 'zass')
			);

			if (empty($result)) {
				$output = "<ul>";
				$output .= "<li>";
				$output .= "<span class='ajax_search_unit ajax_not_found'>";
				$output .= "<span class='ajax_search_content'>";
				$output .= "    <span class='ajax_search_title'>";
				$output .= $search_messages['no_criteria_matched'];
				$output .= "    </span>";
				$output .= "    <span class='ajax_search_excerpt'>";
				$output .= $search_messages['another_search_term'];
				$output .= "    </span>";
				$output .= "</span>";
				$output .= "</span>";
				$output .= "</li>";
				$output .= "</ul>";
				echo wp_kses_post($output);
				wp_die();
			}

			// reorder posts by post type
			$output = "";
			$sorted = array();
			$post_type_obj = array();
			foreach ($result as $post) {
				$sorted[$post->post_type][] = $post;
				if (empty($post_type_obj[$post->post_type])) {
					$post_type_obj[$post->post_type] = get_post_type_object($post->post_type);
				}
			}

			//preapre the output
			foreach ($sorted as $key => $post_type) {
				if (isset($post_type_obj[$key]->labels->name)) {
					$label = $post_type_obj[$key]->labels->name;
					$output .= "<h4>" . esc_html($label) . "</h4>";
				} else {
					$output .= "<hr />";
				}

				$output .= "<ul>";

				foreach ($post_type as $post) {
					$image = get_the_post_thumbnail($post->ID, 'zass-widgets-thumb');

					$excerpt = "";

					if (!empty($post->post_excerpt)) {
						$excerpt = zass_generate_excerpt($post->post_excerpt, 70, " ", "...", true, '', true);
					} else {
						$excerpt = get_the_time($search_messages['time_format'], $post->ID);
					}

					$link = get_permalink($post->ID);

					$output .= "<li>";
					$output .= "<a class ='ajax_search_unit' href='" . esc_url($link) . "'>";
					if ($image) {
						$output .= "<span class='ajax_search_image'>";
						$output .= $image;
						$output .= "</span>";
					}
					$output .= "<span class='ajax_search_content'>";
					$output .= "    <span class='ajax_search_title'>";
					$output .= get_the_title($post->ID);
					$output .= "    </span>";
					$output .= "    <span class='ajax_search_excerpt'>";
					$output .= $excerpt;
					$output .= "    </span>";
					$output .= "</span>";
					$output .= "</a>";
					$output .= "</li>";
				}

				$output .= "</ul>";
			}

			$output .= "<a class='ajax_search_unit ajax_search_unit_view_all' href='" . esc_url($search_messages['all_results_link']) . "'>" . esc_html($search_messages['view_all_results']) . "</a>";

			echo wp_kses_post($output);
			wp_die();
		}

	}

	add_filter('wp_import_post_data_processed', 'zass_preserve_post_ids', 10, 2);

	if (!function_exists('zass_preserve_post_ids')) {

		/**
		 * WP Import.
		 * Add post id if the record exists
		 *
		 * @param type $postdata
		 * @param type $post
		 * @return Array
		 */
		function zass_preserve_post_ids($postdata, $post) {

			if (is_array($post) && isset($post['post_id']) && get_post($post['post_id'])) {
				$postdata['ID'] = $post['post_id'];
			}

			return $postdata;
		}

	}

	/* Define ajax calls for each import */
	for ($i = 0; $i <= 1; $i++) {
		add_action('wp_ajax_zass_import_zass' . $i, 'zass_import_zass' . $i . '_callback');
	}

	if (!function_exists('zass_import_zass0_callback')) {

		/**
		 * Import zass0 demo
		 */
		function zass_import_zass0_callback() {
			@set_time_limit(1200);
			$transfer = Zass_Transfer_Content::getInstance();
			$result = $transfer->doImportDemo('zass0');

			if ($result) {
				echo 'zass_import_done';
			}
		}

	}

	if (!function_exists('zass_import_zass1_callback')) {

		/**
		 * Import zass1 demo
		 */
		function zass_import_zass1_callback() {
			@set_time_limit(1200);
			$transfer = Zass_Transfer_Content::getInstance();
			$result = $transfer->doImportDemo('zass1');

			if ($result) {
				echo 'zass_import_done';
			}
		}

	}

	// Replace OF textarea sanitization with zass one - in admin_init, because we will allow <script> tag
	add_action('admin_init', 'zass_add_script_to_allowed');
	if (!function_exists('zass_add_script_to_allowed')) {

		function zass_add_script_to_allowed() {
			// Add script to allowed tags only for the logged users - to be able to add tracking code
			global $allowedposttags;
			$allowedposttags['script'] = array('type' => TRUE);
		}

	}

	/**
	 * Returns selected subsets from options to pass to google
	 */
	if (!function_exists('zass_get_google_subsets')) {

		function zass_get_google_subsets() {
			$selected_subsets = zass_get_option('google_subsets');
			$choosen = array();

			foreach ($selected_subsets as $subset => $is_selected) {
				if ($is_selected != '0') {
					$choosen[] = $subset;
				}
			}

			return implode(',', $choosen);
		}

	}

	/**
	 * WPML HOME URL
	 */
	if (!function_exists('zass_wpml_get_home_url')) {

		function zass_wpml_get_home_url() {
			if (function_exists('icl_get_home_url')) {
				return icl_get_home_url();
			} else {
				return home_url('/');
			}
		}

	}

	// Add classes to body
	add_filter('body_class', 'zass_append_body_classes');
	if (!function_exists('zass_append_body_classes')) {

		function zass_append_body_classes($classes) {
			global $wp_query;

			// the layout class
			$general_layout = zass_get_option('general_layout');
			if(isset($wp_query->post->ID)) {
				$specific_layout = get_post_meta( $wp_query->post->ID, 'zass_layout', true );
			} else {
				$specific_layout = '';
			}
			// check is singular and not Blog/Shop/Forum so we get the real post_meta
			if (!(ZASS_IS_WOOCOMMERCE && is_shop()) && !zass_is_blog() && !(ZASS_IS_BBPRESS && bbp_is_forum_archive()) && is_singular()) {
				$specific_header_size = get_post_meta($wp_query->post->ID, 'zass_header_size', true) == '' ? 'default' : get_post_meta($wp_query->post->ID, 'zass_header_size', true);
				$specific_footer_size = get_post_meta($wp_query->post->ID, 'zass_footer_size', true) == '' ? 'default' : get_post_meta($wp_query->post->ID, 'zass_footer_size', true);
				$specific_footer_style = get_post_meta($wp_query->post->ID, 'zass_footer_style', true) == '' ? 'default' : get_post_meta($wp_query->post->ID, 'zass_footer_style', true);
				$to_override_layout = get_post_meta($wp_query->post->ID, 'zass_override_default_layout', true);
			} else {
				$specific_header_size = 'default';
				$specific_footer_size = 'default';
				$specific_footer_style = 'default';
				$to_override_layout = 0;
			}

			if ($to_override_layout) {
				$classes[] = sanitize_html_class($specific_layout);
			} else {
				$classes[] = sanitize_html_class($general_layout);
			}

			// logo and menu postions class
			$logo_menu_position = zass_get_option('logo_menu_position');

			if ( $logo_menu_position != 'zass_logo_left_menu_right' && ! in_array( 'zass_header_left', $classes ) ) {
				$classes[] = sanitize_html_class( $logo_menu_position );
			}
			if ( $logo_menu_position == 'zass_logo_left_menu_right' ) {
				$classes[] = sanitize_html_class( zass_get_option( 'main_menu_alignment' ) );
			}

			// add left-header-scrollable if Scrollable is selected
			if (in_array('zass_header_left', $classes)) {
				$classes[] = sanitize_html_class(zass_get_option('left_header_setting'));
			}

			// header style
			if(isset($wp_query->post->ID)) {
				$is_header_style_meta = get_post_meta( $wp_query->post->ID, 'zass_header_syle', true );
			} else {
				$is_header_style_meta = '';
			}
			$is_header_style_blog = zass_get_option('blog_header_style');
			$is_header_style_shop = zass_get_option('shop_header_style');
			$is_header_style_forum = zass_get_option('forum_header_style');
			$is_header_style_events = zass_get_option('events_header_style');

			$header_style_class = '';
			if ($is_header_style_blog && (zass_is_blog() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())) {
				$header_style_class = $is_header_style_blog;
			} else if (ZASS_IS_WOOCOMMERCE && is_shop() && $is_header_style_shop) {
				$header_style_class = $is_header_style_shop;
			} else if (ZASS_IS_BBPRESS && bbp_is_forum_archive() && $is_header_style_forum) {
				$header_style_class = $is_header_style_forum;
			} else if (ZASS_IS_EVENTS && zass_is_events_part()) {
				$header_style_class = $is_header_style_events;
			} else if (is_singular()) {
				$header_style_class = $is_header_style_meta;
			}

			if ($header_style_class) {
				$classes[] = sanitize_html_class($header_style_class);
			}

			// if no header-top
			if (!zass_get_option('enable_top_header')) {
				$classes[] = sanitize_html_class('euxno-no-top-header');
			}

			// footer reveal
			if (zass_get_option('footer_style') && $specific_footer_style === 'default') {
				$classes[] = sanitize_html_class(zass_get_option('footer_style'));
			} elseif ($specific_footer_style !== 'standard' && $specific_footer_style !== 'default') {
				$classes[] = sanitize_html_class($specific_footer_style);
			}

			// Header size
			if (zass_get_option('header_width') && $specific_header_size === 'default') {
				$classes[] = sanitize_html_class(zass_get_option('header_width'));
			} else if ($specific_header_size !== 'standard' && $specific_header_size !== 'default') {
				$classes[] = sanitize_html_class($specific_header_size);
			}

			// Footer size
			if (zass_get_option('footer_width') && $specific_footer_size === 'default') {
				$classes[] = sanitize_html_class(zass_get_option('footer_width'));
			} else if ($specific_footer_size !== 'standard' && $specific_footer_size !== 'default') {
				$classes[] = sanitize_html_class($specific_footer_size);
			}

			// Sub-menu color Scheme
			if (zass_get_option('submenu_color_scheme')) {
				$classes[] = sanitize_html_class(zass_get_option('submenu_color_scheme'));
			}

			// If using video background
			if (zass_has_to_include_backgr_video()) {
				$classes[] = 'zass-page-has-video-background';
			}

			// Site design accent
			if ( zass_get_option( 'design_accent' ) && zass_get_option( 'design_accent' ) != 'none' ) {
				$classes[] = zass_get_option( 'design_accent' );
			}

			// return the $classes array
			return $classes;
		}

	}

	add_filter('wp_setup_nav_menu_item', 'zass_setup_nav_menu_item');

	if (!function_exists('zass_setup_nav_menu_item')) {

		function zass_setup_nav_menu_item($menu_item) {
			if ($menu_item->db_id != 0) {
				$menu_item->description = apply_filters('nav_menu_description', $menu_item->post_content);
			}

			return $menu_item;
		}

	}

	if (!function_exists('zass_post_nav')) {

		/**
		 * Returns output for the prev / next links on posts and portfolios
		 *
		 * @param bool|type $same_category
		 * @param string|type $taxonomy
		 * @return string
		 * @global type $wp_version
		 */
		function zass_post_nav($same_category = false, $taxonomy = 'category') {
			global $wp_version;
			$excluded_terms = '';

			$type = get_post_type(get_queried_object_id());

			if (!is_singular() || is_post_type_hierarchical($type)) {
				$is_hierarchical = true;
			}

			if (!empty($is_hierarchical)) {
				return;
			}

			$entries = array();
			$prev_translated_key = esc_html__('prev', 'zass');
			$next_translated_key = esc_html__('next', 'zass');

			if (version_compare($wp_version, '3.8', '>=')) {
				$entries[$prev_translated_key] = get_previous_post($same_category, $excluded_terms, $taxonomy);
				$entries[$next_translated_key] = get_next_post($same_category, $excluded_terms, $taxonomy);
			} else {
				$entries[$prev_translated_key] = get_previous_post($same_category);
				$entries[$next_translated_key] = get_next_post($same_category);
			}

			$output = "";

			foreach ($entries as $key => $entry) {
				if (empty($entry)) {
					continue;
				}

				$the_title = zass_generate_excerpt(get_the_title($entry->ID), 75, " ", " ", true, '', true);
				$link = get_permalink($entry->ID);
				$image = get_the_post_thumbnail($entry->ID, 'zass-general-small-size');

				$tc1 = $tc2 = "";

				$output .= "<a class='zass-post-nav zass-post-{$key} ' href='" . esc_url($link) . "' >";
				$output .= "    <i class='fa fa-angle-" . ($key == 'prev' ? 'left' : 'right') . "'></i>";
				$output .= "    <span class='entry-info-wrap'>";
				$output .= "        <span class='entry-info'>";
				$tc1 = "            <span class='entry-title'>{$the_title}</span>";
				if ($image) {
					$tc2 = "            <span class='entry-image'>{$image}</span>";
				}
				$output .= $key == $prev_translated_key ? $tc1 . $tc2 : $tc2 . $tc1;
				$output .= "        </span>";
				$output .= "    </span>";
				$output .= "</a>";
			}
			return $output;
		}

	}

	// Disable autoptimize for bbPress pages
	add_filter('autoptimize_filter_noptimize', 'zass_bbpress_noptimize', 10, 0);
	if (!function_exists('zass_bbpress_noptimize')) {

		function zass_bbpress_noptimize() {
			global $post;
			if (function_exists('is_bbpress') && is_bbpress() || (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'bbp-forum-index'))) {
				return true;
			} else {
				return false;
			}
		}

	}

add_action('activate_the-events-calendar/the-events-calendar.php', 'zass_set_skeleton_styles_events');

if (!function_exists('zass_set_skeleton_styles_events')) {

	/**
	 * Set skeleton styles option upon The Events Calendar plugin activation
	 */
	function zass_set_skeleton_styles_events() {
		$events_options = get_option('tribe_events_calendar_options');
		if(is_array($events_options)) {
			$events_options['stylesheetOption'] = 'skeleton';

			update_option('tribe_events_calendar_options', $events_options);
		}
	}
}

// AllImport fix
add_action('pmxi_saved_post', 'zass_remove_page_template', 10, 1);
if ( ! function_exists( 'zass_remove_page_template' ) ) {
	function zass_remove_page_template( $id ) {
		delete_post_meta( $id, '_wp_page_template' );
	}
}

if ( ! function_exists( 'zass_comments_are_valid_for_post' ) ) {
	/**
	 * Check if all comments are generated by the ActionScheduler
	 *
	 * @param $post_id
	 *
	 * @return array    Assoc array like this: array('valid_comments' => true, 'valid_comments_count' => 0)
	 */
	function zass_comments_valid_for_post( $post_id ) {
		$to_return = array('valid_comments' => true, 'valid_comments_count' => 0);

		$comments                            = get_comments( array( 'post_id' => $post_id, 'status' => 'approve' ) );
		$number_of_action_scheduler_comments = 0;
		/** @var WP_Comment $comment */
		foreach ( $comments as $comment ) {
			if ( $comment->comment_author === 'ActionScheduler' ) {
				$number_of_action_scheduler_comments ++;
			}
		}
		if ( is_array( $comments ) && count( $comments ) === $number_of_action_scheduler_comments ) {
			$to_return['valid_comments'] = false;
		}

		$to_return['valid_comments_count'] = count($comments) - $number_of_action_scheduler_comments;

		return $to_return;
	}
}

add_filter( 'wcml_multi_currency_ajax_actions', 'zass_add_action_to_multi_currency_ajax', 10, 1 );
if (!function_exists('zass_add_action_to_multi_currency_ajax')) {
	/**
	 * This function is recommended way by WPML: https://wpml.org/forums/topic/mini-cart-not-showing-correct-currency/
	 * To add any ajax functions called in the theme, to be filtered by WPML
	 *
	 * @param $ajax_actions
	 *
	 * @return array
	 */
	function zass_add_action_to_multi_currency_ajax( $ajax_actions ) {

		$ajax_actions[] = 'wptf_fragment_refresh'; // Add a AJAX action to the array
		$ajax_actions[] = 'wptf_ajax_add_to_cart';

		// Zass actions below
		$ajax_actions[] = 'zass_quickview';
		$ajax_actions[] = 'zass_wc_add_cart';

		return $ajax_actions;
	}
}

add_filter( 'yith_wcwl_localize_script', 'zass_add_wishlist_settings', 99 );
if ( ! function_exists( 'zass_add_wishlist_settings' ) ) {
	/**
	 * We need this to enable notifications for Wishlist.
	 * This setting is included in their pro version.
	 * Below function enables notices only if the setting is not already defined.
	 *
	 * @param $wishlist_settings_array
	 *
	 * @return array
	 */
	function zass_add_wishlist_settings( $wishlist_settings_array ) {
		if ( is_array( $wishlist_settings_array ) && ! array_key_exists( 'enable_notices', $wishlist_settings_array ) ) {
			$wishlist_settings_array['enable_notices'] = true;
		}

		return $wishlist_settings_array;
	}
}