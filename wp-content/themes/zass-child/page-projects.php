<?php
// The Default Page template file.

get_header();
global $wp_query;

// Get the zass custom options
$zass_page_options = get_post_custom($wp_query->post->ID);
$zass_current_post_type = get_post_type($wp_query->post->ID);

$zass_show_title_page = 'yes';
$zass_show_breadcrumb = 'yes';
$zass_show_share = 'yes';
$zass_featured_slider = 'none';
$zass_rev_slider_before_header = 0;
$zass_subtitle = '';
$zass_show_title_background = 0;
$zass_title_background_image = '';
$zass_title_alignment = 'left_title';
$zass_featured_flex_slider_imgs = array();

if ( is_singular() && in_array($zass_current_post_type, array('page', 'tribe_events')) ) {

	if ( isset( $zass_page_options['zass_show_title_page'] ) && trim( $zass_page_options['zass_show_title_page'][0] ) != '' ) {
		$zass_show_title_page = $zass_page_options['zass_show_title_page'][0];
	}

	if ( isset( $zass_page_options['zass_show_breadcrumb'] ) && trim( $zass_page_options['zass_show_breadcrumb'][0] ) != '' ) {
		$zass_show_breadcrumb = $zass_page_options['zass_show_breadcrumb'][0];
	}

	if ( isset( $zass_page_options['zass_show_share'] ) && trim( $zass_page_options['zass_show_share'][0] ) != '' ) {
		$zass_show_share = $zass_page_options['zass_show_share'][0];
	}

	if ( isset( $zass_page_options['zass_rev_slider'] ) && trim( $zass_page_options['zass_rev_slider'][0] ) != '' ) {
		$zass_featured_slider = $zass_page_options['zass_rev_slider'][0];
	}

	if ( isset( $zass_page_options['zass_rev_slider_before_header'] ) && trim( $zass_page_options['zass_rev_slider_before_header'][0] ) != '' ) {
		$zass_rev_slider_before_header = $zass_page_options['zass_rev_slider_before_header'][0];
	}

	if ( isset( $zass_page_options['zass_page_subtitle'] ) && trim( $zass_page_options['zass_page_subtitle'][0] ) != '' ) {
		$zass_subtitle = $zass_page_options['zass_page_subtitle'][0];
	}

	if ( isset( $zass_page_options['zass_title_background'] ) && trim( $zass_page_options['zass_title_background'][0] ) != '' ) {
		$zass_show_title_background = $zass_page_options['zass_title_background'][0];
	}

	if ( isset( $zass_page_options['zass_title_background_imgid'] ) && trim( $zass_page_options['zass_title_background_imgid'][0] ) != '' ) {
		$zass_img                    = wp_get_attachment_image_src( $zass_page_options['zass_title_background_imgid'][0], 'full' );
		$zass_title_background_image = $zass_img ? $zass_img[0] : $zass_img;
	}

	if ( isset( $zass_page_options['zass_title_alignment'] ) && trim( $zass_page_options['zass_title_alignment'][0] ) != '' ) {
		$zass_title_alignment = $zass_page_options['zass_title_alignment'][0];
	}

	$zass_featured_flex_slider_imgs = zass_get_more_featured_images($wp_query->post->ID);
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

// Title and events
$zass_events_mode_and_title = zass_get_current_events_display_mode_and_title( $wp_query->post->ID );
$zass_title                 = $zass_events_mode_and_title['title'];
$zass_events_mode           = $zass_events_mode_and_title['display_mode'];

if ( ZASS_IS_EVENTS && in_array( $zass_events_mode, array(
		'MAIN_CALENDAR',
		'CALENDAR_CATEGORY',
		'MAIN_EVENTS',
		'CATEGORY_EVENTS',
		'SINGLE_EVENT_DAYS'
	) )
) {
	$zass_show_title_background = zass_get_option( 'show_events_title_background' );
	$zass_img                   = wp_get_attachment_image_src( zass_get_option( 'events_title_background_imgid' ), 'full' );
	if ( $zass_img ) {
		$zass_title_background_image = $zass_img[0];
	}
	$zass_subtitle        = zass_get_option( 'events_subtitle' );
	$zass_title_alignment = zass_get_option( 'events_title_alignment' );

}
// END title and events
?>
<?php if ($zass_has_offcanvas_sidebar): ?>
	<?php get_sidebar('offcanvas'); ?>
<?php endif; ?>
<div id="content" <?php if (!empty($zass_sidebar_classes)) echo 'class="' . esc_attr(implode(' ', $zass_sidebar_classes)) . '"'; ?> >
	<?php if ($zass_show_title_page == 'yes' || $zass_show_breadcrumb == 'yes'): ?>
		<div id="zass_page_title" class="zass_title_holder <?php echo esc_attr($zass_title_alignment) ?> <?php if ($zass_show_title_background && $zass_title_background_image): ?>title_has_image<?php endif; ?>">
			<?php if ($zass_show_title_background && $zass_title_background_image): ?>
				<div class="zass-zoomable-background" style="background-image: url('<?php echo esc_url($zass_title_background_image) ?>');"></div>
			<?php endif; ?>
			<div class="inner fixed">
				<!-- BREADCRUMB -->
				<?php if ($zass_show_breadcrumb == 'yes'): ?>
					<?php zass_breadcrumb() ?>
				<?php endif; ?>
				<!-- END OF BREADCRUMB -->
				<!-- TITLE -->
				<?php if ($zass_show_title_page == 'yes'): ?>
					<h1 class="heading-title"><?php echo wp_filter_post_kses($zass_title); ?></h1>
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
		<div id="main" class="fixed box box-common custom-page-projects">
			<div class="content_holder">
				<?php if ( is_singular() ): ?>
					<?php if ( ! empty( $zass_featured_flex_slider_imgs ) ): ?>
						<div class="zass_flexslider post_slide">
							<ul class="slides">
								<?php if ( has_post_thumbnail( $wp_query->post->ID ) ): ?>
									<li>
										<?php echo wp_get_attachment_image( get_post_thumbnail_id( $wp_query->post->ID ), 'zass-blog-category-thumb' ); ?>
									</li>
								<?php endif; ?>

								<?php foreach ( $zass_featured_flex_slider_imgs as $zass_img_att_id ): ?>
									<li>
										<?php echo wp_get_attachment_image( $zass_img_att_id, 'zass-blog-category-thumb' ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php elseif ( has_post_thumbnail( $wp_query->post->ID ) ): ?>
						<?php echo get_the_post_thumbnail( $wp_query->post->ID, 'zass-blog-category-thumb' ); ?>
					<?php endif; ?>
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
			<!-- END OF SIDEBARS -->
			<div class="clear"></div>
			<?php if (function_exists('zass_share_links')): ?>
				<?php zass_share_links(get_the_title(), get_permalink()); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- END OF MAIN CONTENT -->

<?php
get_footer();
