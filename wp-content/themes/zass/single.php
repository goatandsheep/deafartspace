<?php
get_header();

// Default to single post
// Get the zass custom options
$zass_page_options = get_post_custom(get_the_ID());

$zass_show_title_page = 'yes';
$zass_show_breadcrumb = 'yes';
$zass_show_share = 'yes';
$zass_featured_slider = 'none';
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
$zass_sidebar_classes[] = apply_filters('zass_left_sidebar_position_class', '');
?>
<?php if ($zass_has_offcanvas_sidebar): ?>
	<?php get_sidebar('offcanvas'); ?>
<?php endif; ?>
<div id="content" <?php if (!empty($zass_sidebar_classes)) echo 'class="' . esc_attr(implode(' ', $zass_sidebar_classes)) . '"'; ?> >
	<?php while (have_posts()) : the_post(); ?>
		<?php if ($zass_show_title_page == 'yes' || $zass_show_breadcrumb == 'yes'): ?>
			<div id="zass_page_title" class="zass_title_holder <?php echo esc_attr($zass_title_alignment) ?> <?php if ($zass_show_title_background && $zass_title_background_image): ?>title_has_image<?php endif; ?>">
				<?php if ($zass_show_title_background && $zass_title_background_image): ?><div class="zass-zoomable-background" style="background-image: url('<?php echo esc_url($zass_title_background_image) ?>');"></div><?php endif; ?>
				<div class="inner fixed">
					<!-- BREADCRUMB -->
					<?php if ($zass_show_breadcrumb == 'yes'): ?>
						<?php zass_breadcrumb() ?>
					<?php endif; ?>
					<!-- END OF BREADCRUMB -->
					<?php if ($zass_show_title_page == 'yes'): ?>
						<h1	class="heading-title"	>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h1>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="inner">
			<!-- CONTENT WRAPPER -->
			<div id="main" class="fixed box box-common">
				<div class="content_holder">
					<?php get_template_part('content', get_post_format()); ?>
					<?php
					if (comments_open() || get_comments_number()) :
						comments_template('', true);
					endif;
					?>
					<?php if (zass_get_option('show_related_posts')): ?>
						<?php
						// Get random post from the same category as the current one
						$zass_related_posts_args = array(
							    'posts_per_page' => zass_get_option('number_related_posts'),
								'post__not_in' => array($post->ID),
								'orderby' => 'rand',
								'post_type' => 'post',
								'post_status' => 'publish'
						);
						$zass_get_terms_args = array(
								'orderby' => 'name',
								'order' => 'ASC',
								'fields' => 'slugs'
						);
						$zass_categories = wp_get_post_terms($post->ID, 'category', $zass_get_terms_args);
						if (!$zass_categories instanceof WP_Error && !empty($zass_categories)) {
							$zass_related_posts_args['tax_query'] = array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => $zass_categories));
						}

						$zass_is_latest_posts = true;
						query_posts($zass_related_posts_args);
						?>
						<?php if (have_posts()) : ?>
							<?php
							// owl carousel
							wp_localize_script('zass-libs-config', 'zass_owl_carousel', array(
									'include' => 'true'
							));
							?>
							<div class="zass-related-blog-posts zass_shortcode_latest_posts zass_blog_masonry full_width">
								<h4><?php esc_html_e('Related posts', 'zass') ?></h4>
								<div <?php if (zass_get_option('owl_carousel')): ?> class="owl-carousel zass-owl-carousel" <?php endif; ?>>
								<?php endif; ?>

								<?php while (have_posts()) : ?>
									<?php the_post(); ?>
							        <?php get_template_part('content', 'related-posts'); ?>
								<?php endwhile; ?>

								<?php if (have_posts()): ?>
								</div>
								<div class="clear"></div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php wp_reset_query();	?>
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
		<!-- END OF CONTENT WRAPPER -->
	<?php endwhile; // end of the loop.    ?>
</div>
<?php
get_footer();
