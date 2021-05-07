<?php
// Partial to use when displayng zass_portfolio_category category, archive and page template
global $wp;
// ZASS functions
$zass_current_url = home_url(add_query_arg(array(), $wp->request));
wp_localize_script('zass-libs-config', 'zass_isotope_infinite', array(
		'msgText' => esc_js(__('Loading ...', 'zass')),
		'finishedMsg' => esc_js(__('All portfolios loaded.', 'zass')),
		'perm_structure' => esc_js(get_option('permalink_structure')),
		'path' => esc_url($zass_current_url)
));

if (!isset($zass_portfolio_style_class)) {
	$zass_portfolio_style_class = 'grid-unit';
}

if (!isset($zass_columns_class)) {
	$zass_columns_class = 'portfolio-col-3';
}
// If the style is different than grid, we dont need columns
if ($zass_portfolio_style_class != 'grid-unit') {
	$zass_columns_class = '';
}
// If style is masonary no crop on images
if ($zass_portfolio_style_class == 'masonry-unit') {
	$zass_thumb_size = 'zass-portfolio-category-thumb-real';
} else {
	$zass_thumb_size = 'zass-portfolio-category-thumb';
}

// get the gaps style
if (zass_get_option('portfoio_cat_display')) {
	$zass_gaps_class = 'zass-10px-gap';
} else {
	$zass_gaps_class = '';
}

// none-overlay style
if (zass_get_option('none_overlay') && $zass_portfolio_style_class !== 'list-unit') {
	$zass_none_overlay_class = 'zass-none-overlay';
} else {
	$zass_none_overlay_class = '';
}

$zass_subtitle = '';
$zass_show_title_background = 0;
$zass_title_background_image = '';
$zass_title_alignment = 'left_title';

if (is_page()) {
// Get the zass custom options
	$zass_page_options = get_post_custom(get_the_ID());

	$zass_show_title_page = 'yes';
	$zass_show_breadcrumb = 'yes';
	$zass_featured_slider = 'none';
	$zass_rev_slider_before_header = 0;

	if (isset($zass_page_options['zass_show_title_page']) && trim($zass_page_options['zass_show_title_page'][0]) != '') {
		$zass_show_title_page = $zass_page_options['zass_show_title_page'][0];
	}

	if (isset($zass_page_options['zass_show_breadcrumb']) && trim($zass_page_options['zass_show_breadcrumb'][0]) != '') {
		$zass_show_breadcrumb = $zass_page_options['zass_show_breadcrumb'][0];
	}

	if (isset($zass_page_options['zass_rev_slider']) && trim($zass_page_options['zass_rev_slider'][0]) != '') {
		$zass_featured_slider = $zass_page_options['zass_rev_slider'][0];
	}

	if (isset($zass_page_options['zass_rev_slider_before_header']) && trim($zass_page_options['zass_rev_slider_before_header'][0]) != '') {
		$zass_rev_slider_before_header = $zass_page_options['zass_rev_slider_before_header'][0];
	}

	$zass_featured_flex_slider_imgs = zass_get_more_featured_images(get_the_ID());

	if (isset($zass_page_options['zass_page_subtitle']) && trim($zass_page_options['zass_page_subtitle'][0]) != '') {
		$zass_subtitle = $zass_page_options['zass_page_subtitle'][0];
	}

	if (isset($zass_page_options['zass_title_background']) && trim($zass_page_options['zass_title_background'][0]) != '') {
		$zass_show_title_background = $zass_page_options['zass_title_background'][0];
	}

	if (isset($zass_page_options['zass_title_background_imgid']) && trim($zass_page_options['zass_title_background_imgid'][0]) != '') {
		$zass_img = wp_get_attachment_image_src($zass_page_options['zass_title_background_imgid'][0], 'full');
		$zass_title_background_image = $zass_img ? $zass_img[0] : $zass_img;
	}

	if (isset($zass_page_options['zass_title_alignment']) && trim($zass_page_options['zass_title_alignment'][0]) != '') {
		$zass_title_alignment = $zass_page_options['zass_title_alignment'][0];
	}
}

$zass_sidebar_choice = apply_filters('zass_has_sidebar', '');

if ($zass_sidebar_choice != 'none') {
	$zass_has_sidebar = is_active_sidebar($zass_sidebar_choice);
} else {
	$zass_has_sidebar = false;
}
$zass_offcanvas_sidebar_choice = apply_filters('zass_has_offcanvas_sidebar', '');

if ($zass_offcanvas_sidebar_choice != 'none') {
	$zass_has_offcanvas_sidebar = is_active_sidebar($zass_offcanvas_sidebar_choice);
} else {
	$zass_has_offcanvas_sidebar = false;
}

$zass_sidebar_classes = array();
if ($zass_has_sidebar) {
	$zass_sidebar_classes[] = 'has-sidebar';
}
if ($zass_has_offcanvas_sidebar) {
	$zass_sidebar_classes[] = 'has-off-canvas-sidebar';
}

// Sidebar position
$zass_sidebar_classes[] =  apply_filters('zass_left_sidebar_position_class', '');
?>
<?php if ($zass_has_offcanvas_sidebar): ?>
	<?php get_sidebar('offcanvas'); ?>
<?php endif; ?>
<div id="content" <?php if (!empty($zass_sidebar_classes)) echo 'class="' . esc_attr(implode(' ', $zass_sidebar_classes)) . '"'; ?> >

	<div id="zass_page_title" class="zass_title_holder <?php echo esc_attr($zass_title_alignment) ?> <?php if ($zass_show_title_background && $zass_title_background_image): ?>title_has_image<?php endif; ?>">
		<?php if ($zass_show_title_background && $zass_title_background_image): ?><div class="zass-zoomable-background" style="background-image: url('<?php echo esc_url($zass_title_background_image) ?>');"></div><?php endif; ?>
		<div class="inner fixed">
			<!-- BREADCRUMB -->
			<?php if ((is_page() && $zass_show_breadcrumb == 'yes') || !is_page()): ?>
				<?php zass_breadcrumb() ?>
			<?php endif; ?>
			<!-- END OF BREADCRUMB -->
			<?php if (is_tax()): ?>
				<h1 class="heading-title"><?php single_term_title() ?></h1>
			<?php elseif (is_page() && $zass_show_title_page == 'yes'): ?>
				<h1 class="heading-title"><?php the_title(); ?></h1>
				<?php if ($zass_subtitle): ?>
					<h6><?php echo esc_html($zass_subtitle) ?></h6>
				<?php endif; ?>
			<?php elseif (!is_page()): ?>
				<h1 class="heading-title"><?php esc_html_e('Portfolio', 'zass') ?></h1>
			<?php endif; ?>
		</div>
	</div>
	<div class="inner">
		<!-- CONTENT WRAPPER -->
		<div id="main" class="fixed box box-common">
			<div class="content_holder">
				<?php if (is_page() && !empty($zass_featured_flex_slider_imgs)): ?>
					<div class="zass_flexslider  post_slide">
						<ul class="slides">
							<?php if (has_post_thumbnail()): ?>
								<li>
									<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'zass-blog-category-thumb'); ?>
								</li>
							<?php endif; ?>

							<?php foreach ($zass_featured_flex_slider_imgs as $zass_img_att_id): ?>
								<li>
									<?php echo wp_get_attachment_image($zass_img_att_id, 'zass-blog-category-thumb'); ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php elseif (is_page() && $zass_featured_slider != 'none' && function_exists('putRevSlider') && !$zass_rev_slider_before_header): ?>
					<!-- FEATURED REVOLUTION SLIDER -->
					<div class="slideshow">
						<?php putRevSlider($zass_featured_slider) ?>
					</div>
					<!-- END OF FEATURED REVOLUTION SLIDER -->
				<?php elseif (is_page() && has_post_thumbnail()): ?>
					<?php the_post_thumbnail('zass-blog-category-thumb'); ?>
				<?php endif; ?>

				<?php if (is_tax()): ?>
					<?php if (term_description()): ?>
						<div class="portfolio-cat-desc">
							<?php echo wp_kses_post(term_description()); ?>
						</div>
					<?php endif; ?>
					<?php $zass_curr_category = get_queried_object(); ?>
					<?php $zass_portgolio_categories = array($zass_curr_category) ?>
					<?php $zass_portfolio_categories = array_merge($zass_portgolio_categories, get_term_children($zass_curr_category->term_id, 'zass_portfolio_category')); ?>
				<?php else: ?>
					<?php if ($post->post_content): ?>
						<div class="portfolio-cat-desc">
							<?php echo apply_filters('the_content', $post->post_content); ?>
						</div>
					<?php endif; ?>
					<?php $zass_portfolio_categories = get_terms('zass_portfolio_category'); ?>
				<?php endif; ?>

				<?php if (count($zass_portfolio_categories) > 0): ?>
					<div class="zass-portfolio-categories">
						<ul>
							<?php if (!is_tax()): ?>
								<li><a class="is-checked" data-filter="*" href="#"><?php esc_html_e('show all', 'zass') ?></a></li>
							<?php endif; ?>
							<?php foreach ($zass_portfolio_categories as $zass_category): ?>
								<?php if (!is_object($zass_category)) $zass_category = get_term_by('id', $zass_category, 'zass_portfolio_category') ?>
								<li><a <?php if (is_tax() && get_queried_object()->term_id == $zass_category->term_id) echo 'class="is-checked"' ?> data-filter=".<?php echo esc_attr($zass_category->slug) ?>" href="#"><?php echo esc_html($zass_category->name) ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php $zass_counter = 0; ?>
				<?php
				global $query_string;

				if (is_page()) {
					//get all portfolios
					$zass_portfolios = new WP_Query('post_type=zass-portfolio&post_status=publish&posts_per_page=' . get_option("posts_per_page") . '&paged=' . get_query_var('paged'));
				} else {
					$zass_portfolios = new WP_Query($query_string . '&post_type=zass-portfolio');
				}
				?>
				<div class="portfolios">
					<?php while ($zass_portfolios->have_posts()): ?>
						<?php $zass_portfolios->the_post(); ?>
						<?php $zass_portfolio = get_post(); ?>
						<?php $zass_counter++; ?>
						<?php
						$zass_terms_arr = array();
						$zass_current_terms = get_the_terms($zass_portfolio->ID, 'zass_portfolio_category');
						$zass_current_terms_as_simple_array = array();

						if ($zass_current_terms) {
							foreach ($zass_current_terms as $zass_term) {
								$zass_current_terms_as_simple_array[] = $zass_term->name;

								$zass_ancestors = zass_get_zass_portfolio_category_parents($zass_term->term_id);
								foreach ($zass_ancestors as $zass_term_ancestor) {
									$zass_terms_arr[] = $zass_term_ancestor->slug;
								}
							}
							$zass_terms_arr = array_unique($zass_terms_arr);
						}

						$zass_portfolio_featured_imgs = zass_get_more_featured_images($zass_portfolio->ID);

						$zass_featured_image_attr = wp_get_attachment_image_src(get_post_thumbnail_id($zass_portfolio->ID), 'full');
						$zass_featured_image_src = '';
						if ($zass_featured_image_attr) {
							$zass_featured_image_src = $zass_featured_image_attr[0];
						}
						?>
						<div class="portfolio-unit <?php echo esc_attr($zass_none_overlay_class) ?> <?php echo esc_attr(implode(' ', $zass_terms_arr)) ?> <?php echo esc_attr($zass_portfolio_style_class) ?> <?php echo esc_attr($zass_columns_class) ?> <?php echo esc_attr($zass_gaps_class) ?>">
							<div class="portfolio-unit-holder">
								<!-- LIST -->
								<?php if ($zass_portfolio_style_class == 'list-unit'): ?>
									<div class="port-unit-image-holder">
										<a title="<?php esc_attr_e('View project', 'zass') ?>" href="<?php echo esc_url(get_the_permalink($zass_portfolio->ID)); ?>" class="portfolio-link">
											<?php if (has_post_thumbnail($zass_portfolio->ID)): ?>
												<?php echo get_the_post_thumbnail($zass_portfolio->ID, $zass_thumb_size); ?>
											<?php else: ?>
												<img src="<?php echo esc_attr(ZASS_IMAGES_PATH . 'cat_not_found.png') ?>" />
											<?php endif; ?>
										</a>
									</div>
									<div class="portfolio-unit-info">
										<a title="<?php esc_attr_e('View project', 'zass') ?>" href="<?php echo esc_url(get_the_permalink($zass_portfolio->ID)); ?>" class="portfolio-link">
											<small><?php the_time(get_option('date_format')); ?></small>
											<h4><?php echo esc_html(get_the_title($zass_portfolio->ID)); ?></h4>
										</a>
										<?php if ($zass_featured_image_src && zass_get_option('show_light_projects')): ?>
											<a class="portfolio-lightbox-link" href="<?php echo esc_url($zass_featured_image_src) ?>"><span></span></a>
										<?php endif; ?>
										<?php $zass_short_description = get_post_meta(get_the_ID(), 'zass_add_description', true); ?>
										<?php if ($zass_short_description): // If has short description - show it, else the excerpt  ?>
											<p><?php echo wp_trim_words($zass_short_description, 40, zass_new_excerpt_more('no_hash')); ?></p>
										<?php elseif (get_the_content()): ?>
											<p><?php the_excerpt(); ?></p>
										<?php endif; ?>
										<?php if ($zass_current_terms): ?>
											<h6><?php echo wp_kses_post(implode(' / ', $zass_current_terms_as_simple_array)) ?></h6>
										<?php endif; ?>
									</div>
									<!-- GRID and MASONRY -->
								<?php else: ?>
									<?php if (has_post_thumbnail($zass_portfolio->ID)): ?>
										<?php echo get_the_post_thumbnail($zass_portfolio->ID, $zass_thumb_size); ?>
									<?php else: ?>
										<img src="<?php echo esc_attr(ZASS_IMAGES_PATH . 'cat_not_found.png') ?>" />
									<?php endif; ?>
									<div class="portfolio-unit-info">
										<a title="<?php esc_attr_e('View project', 'zass') ?>" href="<?php echo esc_url(get_the_permalink($zass_portfolio->ID)); ?>" class="portfolio-link">
											<small><?php the_time(get_option('date_format')); ?></small>
											<h4><?php echo esc_html(get_the_title($zass_portfolio->ID)); ?></h4>
											<?php if ($zass_current_terms): ?>
												<h6><?php echo wp_kses_post(implode(' / ', $zass_current_terms_as_simple_array)) ?></h6>
											<?php endif; ?>
										</a>
										<?php if ($zass_featured_image_src && zass_get_option('show_light_projects')): ?>
											<a class="portfolio-lightbox-link" href="<?php echo esc_url($zass_featured_image_src) ?>"><span></span></a>
										<?php endif; ?>
									</div>
								<?php endif; ?>

							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<?php if (!$zass_portfolios->have_posts()): ?>
					<p><?php esc_html_e('No Portfolio found. Sorry!', 'zass'); ?></p>
				<?php endif; ?>
			</div>
			<!-- SIDEBARS -->
			<?php if ($zass_has_sidebar): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			<?php if ($zass_has_offcanvas_sidebar): ?>
				<a class="sidebar-trigger" href="#"><?php echo esc_html__('show', 'zass') ?></a>
			<?php endif; ?>
			<!-- END OF IDEBARS -->
			<div class="clear"></div>

			<!-- PAGINATION -->
			<div class="box box-common portfolio-nav">
				<?php if (function_exists('zass_pagination')) : zass_pagination('', $zass_portfolios); ?>
				<?php else : ?>

					<div class="navigation group">
						<div class="alignleft next-page-portfolio"><?php next_posts_link(esc_html__('Next &raquo;', 'zass')) ?></div>
						<div class="alignright prev-page-portfolio"><?php previous_posts_link(esc_html__('&laquo; Back', 'zass')) ?></div>
					</div>

				<?php endif; ?>
			</div>
			<!-- END OF PAGINATION -->

		</div>
		<!-- END OF CONTENT WRAPPER -->
	</div>
</div>