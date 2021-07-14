<?php
get_header();

// The zass-portfolio CPT template file.
// Get the zass custom options
$zass_page_options = get_post_custom(get_the_ID());

$zass_show_title_page = 'yes';
$zass_show_breadcrumb = 'yes';
$zass_show_share = 'yes';
$zass_featured_slider = 'none';
$zass_rev_slider_before_header = 0;
$zass_subtitle = '';
$zass_show_title_background = 0;
$zass_title_background_image = '';
$zass_title_alignment = 'left_title';

$author_name = get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
$author_username = get_the_author_meta( 'display_name' );
// $author_id = get_the_author_meta('ID');
// $vendor = yith_get_vendor( $author_id, 'user' );
// $vendor_url = $vendor->get_url( 'frontend' );

if (isset($zass_page_options['zass_show_title_page']) && trim($zass_page_options['zass_show_title_page'][0]) != '') {
	$zass_show_title_page = $zass_page_options['zass_show_title_page'][0];
}

if (isset($zass_page_options['zass_show_breadcrumb']) && trim($zass_page_options['zass_show_breadcrumb'][0]) != '') {
	$zass_show_breadcrumb = $zass_page_options['zass_show_breadcrumb'][0];
}

if (isset($zass_page_options['zass_show_share']) && trim($zass_page_options['zass_show_share'][0]) != '') {
	$zass_show_share = $zass_page_options['zass_show_share'][0];
}

if (isset($zass_page_options['zass_rev_slider']) && trim($zass_page_options['zass_rev_slider'][0]) != '') {
	$zass_featured_slider = $zass_page_options['zass_rev_slider'][0];
}

if (isset($zass_page_options['zass_rev_slider_before_header']) && trim($zass_page_options['zass_rev_slider_before_header'][0]) != '') {
	$zass_rev_slider_before_header = $zass_page_options['zass_rev_slider_before_header'][0];
}

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

$zass_featured_flex_slider_imgs = zass_get_more_featured_images(get_the_ID());

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
<?php while (have_posts()) : the_post(); ?>
	<?php if ($zass_has_offcanvas_sidebar): ?>
		<?php get_sidebar('offcanvas'); ?>
	<?php endif; ?>
	<div id="content" <?php if (!empty($zass_sidebar_classes)) echo 'class="' . esc_attr(implode(' ', $zass_sidebar_classes)) . '"'; ?> >
		<?php if ($zass_show_title_page == 'yes' || $zass_show_breadcrumb == 'yes'): ?>

			<div id="zass_page_title" class="zass_title_holder <?php echo esc_attr($zass_title_alignment) ?> <?php if ($zass_show_title_background && $zass_title_background_image): ?>title_has_image<?php endif; ?>">
				<?php if ($zass_show_title_background && $zass_title_background_image): ?><div class="zass-zoomable-background" style="background-image: url('<?php echo esc_url($zass_title_background_image) ?>');"></div><?php endif; ?>
				<div class="inner fixed">
					<!-- BREADCRUMB -->
					<?php if ($zass_show_breadcrumb == 'yes'): ?>
						<?php zass_breadcrumb() ?>
					<?php endif; ?>
					<!-- END OF BREADCRUMB -->
					<!-- TITLE -->
					<?php if ($zass_show_title_page == 'yes'): ?>
						<h1 class="heading-title"><?php the_title(); ?></h1>
						<?php if ($zass_subtitle): ?>
							<h6><?php echo esc_html($zass_subtitle) ?></h6>
						<?php endif; ?>
					<?php endif; ?>
					<!-- END OF TITLE -->
				</div>
			</div>
		<?php endif; ?>
		<?php if ($zass_featured_slider != 'none' && function_exists('putRevSlider') && !$zass_rev_slider_before_header): ?>
			<!-- FEATURED REVOLUTION SLIDER -->
			<div class="slideshow">
				<?php putRevSlider($zass_featured_slider) ?>
			</div>
			<!-- END OF FEATURED REVOLUTION SLIDER -->
		<?php endif; ?>
		<div class="inner">
			<!-- CONTENT WRAPPER -->
			<div id="main" class="fixed box box-common">
				<div class="content_holder">
					<?php $zass_curr_portfolio_id = get_the_ID(); ?>
					<?php $zass_portfolio_custom = get_post_custom(); ?>
					<?php
					$zass_collection = isset($zass_portfolio_custom['zass_collection']) ? $zass_portfolio_custom['zass_collection'][0] : '';
					$zass_materials = isset($zass_portfolio_custom['zass_materials']) ? $zass_portfolio_custom['zass_materials'][0] : '';
					$zass_model = isset($zass_portfolio_custom['zass_model']) ? $zass_portfolio_custom['zass_model'][0] : '';
					$zass_status = isset($zass_portfolio_custom['zass_status']) ? $zass_portfolio_custom['zass_status'][0] : '';
					$zass_ext_link_button_title = isset($zass_portfolio_custom['zass_ext_link_button_title']) ? $zass_portfolio_custom['zass_ext_link_button_title'][0] : '';
					$zass_ext_link_url = isset($zass_portfolio_custom['zass_ext_link_url']) ? $zass_portfolio_custom['zass_ext_link_url'][0] : '';

					// What gallery to be used
					$zass_prtfl_gallery = isset($zass_portfolio_custom['zass_prtfl_gallery']) ? $zass_portfolio_custom['zass_prtfl_gallery'][0] : 'flex';
					// Custom content
					$zass_use_custom_content = isset($zass_portfolio_custom['zass_prtfl_custom_content']) ? $zass_portfolio_custom['zass_prtfl_custom_content'][0] : 0;
					?>
					<?php if (!$zass_use_custom_content): ?>
						<div class="portfolio_top<?php if ($zass_prtfl_gallery == 'list'): ?> zass_image_list_portfolio<?php endif; ?>" >
							<div class="two_third portfolio-main-image-holder">
								<?php if ($zass_prtfl_gallery == 'cloud' && has_post_thumbnail()): ?>
									<!-- Cloud Zoom -->
									<?php
									$zass_featured_image_id = get_post_thumbnail_id();

									if ($zass_featured_image_id) {
										array_unshift($zass_featured_flex_slider_imgs, $zass_featured_image_id);
									}

									$zass_image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
									$zass_image_link = wp_get_attachment_url(get_post_thumbnail_id());
									$zass_image = get_the_post_thumbnail(null, 'zass-portfolio-single-thumb');
									?>
									<?php echo sprintf('<a id="zoom1" href="%s" itemprop="image" class="cloud-zoom " title="%s"  rel="position: \'inside\' , showTitle: false, adjustX:-4, adjustY:-4">%s</a>', esc_url($zass_image_link), esc_attr($zass_image_title), $zass_image); ?>

									<?php if (!empty($zass_featured_flex_slider_imgs)): // If there are additional images show CloudZoom gallery  ?>
										<ul class="additional-images">
											<?php foreach ($zass_featured_flex_slider_imgs as $zass_img_id): ?>
												<?php
												$zass_image_title = esc_attr(get_the_title($zass_img_id));
												$zass_image_link = wp_get_attachment_url($zass_img_id);
												$zass_small_image_link = wp_get_attachment_url($zass_img_id, 'zass-portfolio-single-thumb');
												$zass_thumb_image = wp_get_attachment_image($zass_img_id, 'zass-widgets-thumb');
												?>
												<li>
													<?php echo sprintf('<a rel="useZoom: \'zoom1\', smallImage: \'%s\'" title="%s" class="cloud-zoom-gallery" href="%s">%s</a>', esc_url($zass_small_image_link), esc_attr($zass_image_title), esc_url($zass_image_link), $zass_thumb_image); ?>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								<?php elseif ($zass_prtfl_gallery == 'flex' && !empty($zass_featured_flex_slider_imgs)): ?>
									<!-- FEATURED SLIDER/IMAGE -->
									<div class="zass_flexslider">
										<ul class="slides">
											<?php if (has_post_thumbnail()): ?>
												<li>
													<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'zass-portfolio-single-thumb'); ?>
												</li>
											<?php endif; ?>

											<?php foreach ($zass_featured_flex_slider_imgs as $zass_img_att_id): ?>
												<li>
													<?php echo wp_get_attachment_image($zass_img_att_id, 'zass-portfolio-single-thumb'); ?>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php elseif ($zass_prtfl_gallery == 'list' && has_post_thumbnail()): ?>
									<!-- Image List -->
									<div class="zass_image_list">
										<?php if (has_post_thumbnail()): ?>
											<?php $zass_attach_url = wp_get_attachment_url(get_post_thumbnail_id()); ?>
											<?php $zass_image_title = get_the_title(get_post_thumbnail_id()); ?>
											<?php $zass_img_tag = wp_get_attachment_image(get_post_thumbnail_id(), 'zass-portfolio-single-thumb'); ?>
											<?php echo sprintf('<a href="%s" class="zass-magnific-gallery-item" title="%s" >%s</a>', esc_url($zass_attach_url), esc_attr($zass_image_title), $zass_img_tag); ?>
										<?php endif; ?>
										<?php foreach ($zass_featured_flex_slider_imgs as $zass_img_att_id): ?>
											<?php $zass_attach_url = wp_get_attachment_url($zass_img_att_id); ?>
											<?php $zass_image_title = get_the_title($zass_img_att_id); ?>
											<?php $zass_img_tag = wp_get_attachment_image($zass_img_att_id, 'zass-portfolio-single-thumb'); ?>
											<?php echo sprintf('<a href="%s" class="zass-magnific-gallery-item" title="%s" >%s</a>', esc_url($zass_attach_url), esc_attr($zass_image_title), $zass_img_tag); ?>
										<?php endforeach; ?>
									</div>
								<?php elseif (has_post_thumbnail()): ?>
									<?php the_post_thumbnail('zass-portfolio-single-thumb'); ?>
								<?php endif; ?>
								<!-- END OF FEATURED SLIDER/IMAGE -->
							</div>
							<div class="one_third last project-data">
								<div class="project-data-holder">
									<?php if ($zass_portfolio_custom['zass_add_description'][0]): ?>
										<div class="more-details">
											<h4><?php esc_html_e('Short Description', 'zass') ?></h4>
											<?php echo wp_kses_post($zass_portfolio_custom['zass_add_description'][0]) ?>
										</div>
									<?php endif; ?>
									<?php
									if ($zass_collection || $zass_materials ||
													$zass_model || $zass_status || $zass_ext_link_button_title || $zass_ext_link_url):
										?>
										<div class="project-details">
											<h4><?php esc_html_e('Details', 'zass') ?></h4>
											<ul class="simple-list-underlined">
												<li><strong>Posted by:</strong> <a href="/author/<?php echo $author_username ?>"><?php echo $author_name ?></a></li>
												<?php if ($zass_collection): ?>
													<li><strong><?php esc_html_e('Collection', 'zass') ?>:</strong> <?php echo esc_html($zass_collection) ?></li>
												<?php endif; ?>
												<?php if ($zass_materials): ?>
													<li><strong><?php esc_html_e('Materials', 'zass') ?>:</strong> <?php echo esc_html($zass_materials) ?></li>
												<?php endif; ?>
												<?php if ($zass_model): ?>
													<li><strong><?php esc_html_e('Model', 'zass') ?>:</strong> <?php echo esc_html($zass_model) ?></li>
												<?php endif; ?>
												<?php if ($zass_status): ?>
													<li><strong><?php esc_html_e('Status', 'zass') ?>:</strong> <?php echo esc_html($zass_status) ?></li>
												<?php endif; ?>
												<?php if ($zass_ext_link_button_title && $zass_ext_link_url): ?>
													<li><a class="button" target="_blank" href="<?php echo esc_url($zass_ext_link_url) ?>" title="<?php echo esc_attr($zass_ext_link_button_title) ?>"><?php echo esc_attr($zass_ext_link_button_title) ?></a></li>
												<?php endif; ?>
											</ul>
										</div>
									<?php endif; ?>

									<?php
									// Check if the portfolio has features
									$zass_has_features = false;

									for ($i = 1; $i <= 10; $i++) {
										if ($zass_portfolio_custom['zass_feature_' . $i][0]) {
											$zass_has_features = true;
										}
									}
									?>
									<?php if ($zass_has_features): ?>
										<div class="main-features">
											<h4><?php esc_html_e('Main Features', 'zass') ?></h4>
											<ul class="checklist">
												<?php for ($i = 1; $i <= 10; $i++): ?>
													<?php if ($zass_portfolio_custom['zass_feature_' . $i][0]): ?>
														<li><?php echo esc_html($zass_portfolio_custom['zass_feature_' . $i][0]) ?></li>
													<?php endif; ?>
												<?php endfor; ?>
											</ul>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					<?php endif; ?>

					<?php if ($post->post_content != ""): ?>
						<div class="full_width zass-project-description">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
					<?php
					// Get random portfolio projects from the same category as the current one
					$zass_get_portfolio_args = array(
							'nopaging' => true,
							'post__not_in' => array($zass_curr_portfolio_id),
							'orderby' => 'rand',
							'post_type' => 'zass-portfolio',
							'post_status' => 'publish'
					);

					$zass_get_terms_args = array(
							'orderby' => 'name',
							'order' => 'ASC',
							'fields' => 'slugs'
					);
					$zass_portfolio_categories = wp_get_object_terms(get_the_ID(), 'zass_portfolio_category', $zass_get_terms_args);
					if (array_key_exists(0, $zass_portfolio_categories)) {
						$zass_get_portfolio_args['tax_query'] = array(array('taxonomy' => 'zass_portfolio_category', 'field' => 'slug', 'terms' => $zass_portfolio_categories));
					}

					wp_reset_postdata();

					$zass_similar_portfolios = new WP_Query($zass_get_portfolio_args);
					?>
					<?php if (zass_get_option('show_related_projects')): ?>
						<?php if ($zass_similar_portfolios->have_posts()): ?>
							<?php
							// owl carousel
							wp_localize_script('zass-libs-config', 'zass_owl_carousel', array(
									'include' => 'true'
							));
							?>
							<div class="similar_projects full_width">
								<h4><?php esc_html_e('Similar projects', 'zass') ?></h4>
								<div <?php if (zass_get_option('owl_carousel')): ?> class="owl-carousel zass-owl-carousel" <?php endif; ?>>
								<?php endif; ?>

								<?php $zass_counter = 0; ?>
								<?php while ($zass_similar_portfolios->have_posts()): ?>
									<?php $zass_similar_portfolios->the_post(); ?>
									<?php
									$zass_counter++;
									$zass_current_terms = get_the_terms(get_the_ID(), 'zass_portfolio_category');
									$zass_current_terms_as_simple_array = array();

									if ($zass_current_terms) {
										foreach ($zass_current_terms as $zass_term) {
											$zass_current_terms_as_simple_array[] = $zass_term->name;
										}
									}
									?>
									<div class="portfolio-unit grid-unit <?php //if (($zass_counter % 3) == 0) echo 'last'                                       ?>">
										<div class="portfolio-unit-holder">

											<?php if (has_post_thumbnail()): ?>
												<?php the_post_thumbnail('zass-portfolio-category-thumb'); ?>
											<?php else: ?>
												<img src="<?php echo esc_attr(ZASS_IMAGES_PATH . 'cat_not_found.png') ?>" />
											<?php endif; ?>
											<div class="portfolio-unit-info">
												<a title="<?php esc_attr_e('View project', 'zass') ?>" href="<?php the_permalink(); ?>" class="portfolio-link">
													<small><?php the_time(get_option('date_format')); ?></small>
													<h4><?php the_title(); ?></h4>
													<?php if ($zass_current_terms): ?>
														<h6><?php echo wp_kses_post(implode(' / ', $zass_current_terms_as_simple_array)) ?></h6>
													<?php endif; ?>
												</a>
											</div>

										</div>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>

								<?php if ($zass_similar_portfolios->have_posts()): ?>
								</div>
								<div class="clear"></div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<?php if ($zass_has_sidebar): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
				<?php if ($zass_has_offcanvas_sidebar): ?>
					<a class="sidebar-trigger" href="#"><?php echo esc_html__('show', 'zass') ?></a>
				<?php endif; ?>

				<div class="clear"></div>
				<?php if (function_exists('zass_share_links')): ?>
					<?php zass_share_links(get_the_title(), get_permalink()); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endwhile; ?>
<!-- END OF MAIN CONTENT -->

<?php
get_footer();
