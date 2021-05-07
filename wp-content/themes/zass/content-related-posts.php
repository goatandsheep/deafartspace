<?php
$zass_custom_options = get_post_custom(get_the_ID());

$zass_featured_slider = 'none';

if (isset($zass_custom_options['zass_rev_slider']) && trim($zass_custom_options['zass_rev_slider'][0]) != '' && function_exists('putRevSlider')) {
	$zass_featured_slider = $zass_custom_options['zass_rev_slider'][0];
}
$zass_rev_slider_before_header = 0;
if (isset($zass_custom_options['zass_rev_slider_before_header']) && trim($zass_custom_options['zass_rev_slider_before_header'][0]) != '') {
	$zass_rev_slider_before_header = $zass_custom_options['zass_rev_slider_before_header'][0];
}

$zass_featured_flex_slider_imgs = zass_get_more_featured_images(get_the_ID());

// Blog style
$zass_general_blog_style = zass_get_option('general_blog_style');

// Featured image size
$zass_featured_image_size = 'zass-blog-category-thumb';

// If is related posts
$zass_featured_image_size = 'zass-related-posts';

$zass_post_classes = array('blog-post');
if (!has_post_thumbnail()) {
	array_push($zass_post_classes, 'zass-post-no-image');
}
?>

<div id="post-<?php the_ID(); ?>" <?php post_class($zass_post_classes); ?>>
	<?php if (isset($zass_is_latest_posts) && isset($zass_blogposts_param_hide_image) && $zass_blogposts_param_hide_image === 'no' || !isset($zass_blogposts_param_hide_image)): ?>
		<?php if (!empty($zass_featured_flex_slider_imgs) && is_singular()): // if there is slider or featured image attached and it is single post view, display it  ?>
			<div class="zass_flexslider post_slide">
				<ul class="slides">
					<?php if (has_post_thumbnail()): ?>
						<li>
							<?php echo wp_get_attachment_image(get_post_thumbnail_id(), $zass_featured_image_size); ?>
						</li>
					<?php endif; ?>

					<?php foreach ($zass_featured_flex_slider_imgs as $zass_img_att_id): ?>
						<li>
							<?php echo wp_get_attachment_image($zass_img_att_id, $zass_featured_image_size); ?>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php if (!is_single()): ?>
					<div class="portfolio-unit-info">
						<a class="go_to_page go_to_page_blog" title="<?php esc_attr_e('View', 'zass') ?>" href="<?php echo esc_url(get_permalink()) ?>"><?php the_title() ?></a>
					</div>
				<?php endif; ?>
			</div>
		<?php elseif (!$zass_rev_slider_before_header && $zass_featured_slider != 'none' && function_exists('putRevSlider')): ?>
			<div class="slideshow">
				<?php putRevSlider($zass_featured_slider) ?>
			</div>
		<?php elseif (has_post_thumbnail()): ?>
			<div class="post-unit-holder">
				<?php the_post_thumbnail($zass_featured_image_size); ?>
				<?php if (!is_single()): ?>
					<div class="portfolio-unit-info">
						<a class="go_to_page go_to_page_blog" title="<?php esc_attr_e('View', 'zass') ?>" href="<?php echo esc_url(get_permalink()) ?>"><?php the_title() ?></a>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php
	// Show or not the author avatar
	$zass_show_author_avatar = false;
	if ((!is_singular() && zass_get_option('show_author_avatar')) || (is_singular() && !zass_get_option('show_author_info') && zass_get_option('show_author_avatar'))) {
		$zass_show_author_avatar = true;
	}
	?>

	<div class="zass_post_data_holder<?php if (!$zass_show_author_avatar) echo ' zass-no-avatar' ?>">

		<?php if ($zass_show_author_avatar): ?>
			<?php $zass_avatar_img = get_avatar(get_the_author_meta('ID'), 60); ?>
			<?php if ($zass_avatar_img): ?>
				<span class="zass-post-avatar"><?php echo wp_kses_post($zass_avatar_img) ?></span>
			<?php endif; ?>
		<?php endif; ?>
		<?php if (!is_single()): ?>
			<h2	class="heading-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h2>
		<?php endif; ?>

		<div class="blog-post-meta">
			<?php
			if (get_post_format()) {
				echo '<span class="post_format">';

				switch (get_post_format()) {
					case 'aside':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('aside')) . '"><i class="fa fa-file-text-o"></i> ' . esc_html__('Aside', 'zass') . '</a>';
						break;
					case 'gallery':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('gallery')) . '"><i class="fa fa-picture-o"></i> ' . esc_html__('Gallery', 'zass') . '</a>';
						break;
					case 'link':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('link')) . '"><i class="fa fa-link"></i> ' . esc_html__('Link', 'zass') . '</a>';
						break;
					case 'image':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('image')) . '"><i class="fa fa-camera"></i> ' . esc_html__('Image', 'zass') . '</a>';
						break;
					case 'quote':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('quote')) . '"><i class="fa fa-quote-left"></i> ' . esc_html__('Quote', 'zass') . '</a>';
						break;
					case 'status':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('status')) . '"><i class="fa fa-info"></i> ' . esc_html__('Status', 'zass') . '</a>';
						break;
					case 'video':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('video')) . '"><i class="fa fa-video-camera"></i> ' . esc_html__('Video', 'zass') . '</a>';
						break;
					case 'audio':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('audio')) . '"><i class="fa fa-volume-up"></i> ' . esc_html__('Audio', 'zass') . '</a>';
						break;
					case 'chat':
						echo ' <a class="post_format-link" href="' . esc_url(get_post_format_link('chat')) . '"><i class="fa fa-comments-o"></i> ' . esc_html__('Chat', 'zass') . '</a>';
						break;
				}

				echo '</span>';
			}
			?>
			<?php if (!isset($zass_is_latest_posts)): ?>
				<?php if (is_sticky()): ?>
					<span class="sticky_post"><i class="fa fa-exclamation"></i> <?php esc_html_e('Sticky', 'zass') ?></span>
				<?php endif; ?>
				<?php if (zass_get_option('date_fromat') == 'default'): ?>
					<span class="post-meta-date">
						<?php the_time(get_option('date_format')); ?>
					</span>
				<?php endif; ?>
				<span class="posted_by"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
			<?php endif; ?>
			<?php if ($zass_categories = get_the_category()): ?>
				<span class="posted_in"><i class="fa fa-folder-open"></i>
					<?php $zass_lastElmnt = end($zass_categories); ?>
					<?php foreach ($zass_categories as $zass_category): ?>
						<a href="<?php echo esc_url(get_category_link($zass_category->term_id)) ?>" title="<?php echo sprintf(esc_attr__("View all posts in %s", 'zass'), esc_attr($zass_category->name)) ?>"><?php echo esc_html($zass_category->name) ?></a><?php if ($zass_category != $zass_lastElmnt): ?>,<?php endif; ?>
					<?php endforeach; ?>
				</span>
			<?php endif; ?>
			<?php if (!isset($zass_is_latest_posts)): ?>
				<?php the_tags('<i class="fa fa-tags"></i> '); ?>
				<span class="count_comments"><i class="fa fa-comments"></i> <a href="<?php echo esc_url(get_comments_link()) ?>" title="View comments"><?php echo get_comments_number() ?></a></span>
			<?php endif; ?>
		</div>

		<?php if (zass_get_option('date_fromat') == 'zass_format'): ?>
			<div class="post-date"><a href="<?php echo esc_url(get_the_permalink()) ?>" title="<?php echo esc_attr(get_the_title()) ?>"><span class="num"><?php the_time('d'); ?></span><?php the_time('M'); ?></a></div>
		<?php endif; ?>

		<?php if (is_single()): ?>
			<?php the_content(); ?>
			<div class="clear"></div>
			<?php if (zass_get_option('show_author_info') && (trim(get_the_author_meta('description')))): ?>
				<div class="zass-author-info">
					<div class="title">
						<h2><?php echo esc_html__('About the Author:', 'zass'); ?> <?php the_author_posts_link(); ?></h2>
					</div>
					<div class="zass-author-content">
						<div class="avatar">
							<?php echo get_avatar(get_the_author_meta('email'), 72); ?>
						</div>
						<div class="description">
							<?php the_author_meta("description"); ?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			<?php endif; ?>
			<?php wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'zass'), 'after' => '</div>')); ?>
		<?php endif; ?>
	</div>
</div>