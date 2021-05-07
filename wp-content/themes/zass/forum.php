<?php
// The Default Page template file.

get_header();

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

// For Forum subtitle and image background
if (ZASS_IS_BBPRESS && bbp_is_forum_archive()) {
	$zass_subtitle = zass_get_option('forum_subtitle');
	$zass_show_title_background = zass_get_option('show_forum_title_background');
	$zass_title_background_image = zass_get_option('forum_title_background_imgid');
	$zass_title_alignment = zass_get_option('forum_title_alignment');
	if ($zass_title_background_image) {
		$zass_img = wp_get_attachment_image_src($zass_title_background_image, 'full');
		$zass_title_background_image = $zass_img ? $zass_img[0] : $zass_img;
	}
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

	<?php if ($zass_show_title_page == 'yes' || $zass_show_breadcrumb == 'yes'): ?>
		<div id="zass_page_title" class="zass_title_holder <?php echo sanitize_html_class($zass_title_alignment) ?> <?php if ($zass_show_title_background && $zass_title_background_image): ?>title_has_image<?php endif; ?>">
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
			<div class="inner">
				<?php putRevSlider($zass_featured_slider) ?>
			</div>
		</div>
		<!-- END OF FEATURED REVOLUTION SLIDER -->
	<?php endif; ?>
	<div class="inner">
		<!-- CONTENT WRAPPER -->
		<div id="main" class="fixed box box-common">
			<div class="content_holder">
				<?php if (!empty($zass_featured_flex_slider_imgs)): ?>
					<div class="zass_flexslider post_slide">
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
				<?php elseif (has_post_thumbnail()): ?>
					<?php the_post_thumbnail('zass-blog-category-thumb'); ?>
				<?php endif; ?>

				<?php while (have_posts()) : the_post(); ?>
					<?php get_template_part('content', 'page'); ?>
					<?php comments_template('', true); ?>
				<?php endwhile; // end of the loop.  ?>
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
			<?php if (function_exists('zass_share_links')): ?>
				<?php zass_share_links(get_the_title(), get_permalink()); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- END OF MAIN CONTENT -->
<?php get_footer(); ?>