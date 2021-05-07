<?php
/*
 * Partial for showing social site profiles
 */

/* Array holding the available social profiles: name => array( title => fa class name) */
$zass_social_profiles = array(
		'facebook' => array('title' => esc_html__('Follow on Facebook', 'zass'), 'class' => 'fa fa-facebook'),
		'twitter' => array('title' => esc_html__('Follow on Twitter', 'zass'), 'class' => 'fa fa-twitter'),
		'google' => array('title' => esc_html__('Follow on Google+', 'zass'), 'class' => 'fa fa-google-plus'),
		'youtube' => array('title' => esc_html__('Follow on YouTube', 'zass'), 'class' => 'fa fa-youtube-play'),
		'vimeo' => array('title' => esc_html__('Follow on Vimeo', 'zass'), 'class' => 'fa fa-vimeo-square'),
		'dribbble' => array('title' => esc_html__('Follow on Dribbble', 'zass'), 'class' => 'fa fa-dribbble'),
		'linkedin' => array('title' => esc_html__('Follow on LinkedIn', 'zass'), 'class' => 'fa fa-linkedin'),
		'stumbleupon' => array('title' => esc_html__('Follow on StumbleUpon', 'zass'), 'class' => 'fa fa-stumbleupon'),
		'flicker' => array('title' => esc_html__('Follow on Flickr', 'zass'), 'class' => 'fa fa-flickr'),
		'instegram' => array('title' => esc_html__('Follow on Instagram', 'zass'), 'class' => 'fa fa-instagram'),
		'pinterest' => array('title' => esc_html__('Follow on Pinterest', 'zass'), 'class' => 'fa fa-pinterest'),
		'vkontakte' => array('title' => esc_html__('Follow on VKontakte', 'zass'), 'class' => 'fa fa-vk'),
		'behance' => array('title' => esc_html__('Follow on Behance', 'zass'), 'class' => 'fa fa-behance')
);
?>
<div class="zass-social">
	<ul>
		<?php foreach ($zass_social_profiles as $zass_social_name => $zass_details): ?>
			<?php if (zass_get_option($zass_social_name . '_profile')): ?>
				<li><a title="<?php echo esc_attr($zass_details['title']) ?>" class="<?php echo esc_attr($zass_social_name) ?>" target="_blank"  href="<?php echo esc_url(zass_get_option($zass_social_name . '_profile')) ?>"><i class="<?php echo esc_attr($zass_details['class']) ?>"></i></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>