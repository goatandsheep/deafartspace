<!-- FOOTER -->
<?php
global $zass_is_blank;
?>
<!-- If it is not a blank page template -->
<?php if (!$zass_is_blank) : ?>
	<div id="footer" role="contentinfo">
		<?php
		$zass_meta_options = array();
		if (is_single() || is_page()) {
			$zass_meta_options = get_post_custom(get_queried_object_id());
		}

		$zass_show_sidebar = 'yes';
		if (isset($zass_meta_options['zass_show_footer_sidebar']) && trim($zass_meta_options['zass_show_footer_sidebar'][0]) != '') {
			$zass_show_sidebar = $zass_meta_options['zass_show_footer_sidebar'][0];
		}

		$zass_footer_sidebar_choice = zass_get_option('footer_sidebar');
		if (isset($zass_meta_options['zass_custom_footer_sidebar']) && $zass_meta_options['zass_custom_footer_sidebar'][0] !== 'default') {
			$zass_footer_sidebar_choice = $zass_meta_options['zass_custom_footer_sidebar'][0];
		}

		if ($zass_show_sidebar === 'no') {
			$zass_footer_sidebar_choice = 'none';
		}
		?>
		<?php if (function_exists('dynamic_sidebar') && $zass_footer_sidebar_choice != 'none' && is_active_sidebar($zass_footer_sidebar_choice)) : ?>
			<div class="inner">
				<?php dynamic_sidebar($zass_footer_sidebar_choice) ?>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
		<div id="powered">
			<div class="inner">
				<?php
				/* Tertiary menu */
				$zass_footer_nav_args = array(
					'theme_location' => 'tertiary',
					'container' => 'div',
					'container_id' => 'zass_footer_menu_container',
					'menu_class' => '',
					'menu_id' => 'zass_footer_menu',
					'depth' => 1,
					'fallback_cb' => '',
				);
				wp_nav_menu($zass_footer_nav_args);
				?>
				<?php if (zass_get_option('show_logo_in_footer') && (zass_get_option('theme_logo') || zass_get_option('footer_logo'))) : ?>
					<div id="zass_footer_logo">
						<a href="<?php echo esc_url(zass_wpml_get_home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
							<?php
							$zass_theme_logo_img = zass_get_option('theme_logo');
							$zass_footer_logo_img = zass_get_option('footer_logo');

							// If footer logo, show footer logo, else main logo
							if ($zass_footer_logo_img) {
								echo wp_get_attachment_image($zass_footer_logo_img, 'full', false);
							} elseif ($zass_theme_logo_img) {
								echo wp_get_attachment_image($zass_theme_logo_img, 'full', false);
							}
							?>
						</a>
					</div>
				<?php endif; ?>
				<!--	Social profiles in footer -->
				<?php if (zass_get_option('social_in_footer')) : ?>
					<?php get_template_part('partials/social-profiles'); ?>
				<?php endif; ?>

				<div class="author_credits"><?php echo wp_kses_post(str_replace('%current_year%', date('Y'), zass_get_option('copyright_text'))) ?></div>
			</div>
		</div>
	</div>
	<!-- END OF FOOTER -->
	<!-- Previous / Next links -->
	<?php if (zass_get_option('show_prev_next')) : ?>
		<?php echo zass_post_nav(); ?>
	<?php endif; ?>
<?php endif; ?>
</div>
<!-- END OF MAIN WRAPPER -->
<?php
$zass_is_compare = false;
if (isset($_GET['action']) && $_GET['action'] === 'yith-woocompare-view-table') {
	$zass_is_compare = true;
}

$zass_to_include_backgr_video = zass_has_to_include_backgr_video($zass_is_compare);
?>
<?php if ($zass_to_include_backgr_video) : ?>
	<?php
	$zass_video_bckgr_url = $zass_video_bckgr_start = $zass_video_bckgr_end = $zass_video_bckgr_loop = $zass_video_bckgr_mute = '';

	switch ($zass_to_include_backgr_video) {
		case 'postmeta':
			$zass_custom = zass_has_post_video_bckgr();
			$zass_video_bckgr_url = isset($zass_custom['zass_video_bckgr_url'][0]) ? $zass_custom['zass_video_bckgr_url'][0] : '';
			$zass_video_bckgr_start = isset($zass_custom['zass_video_bckgr_start'][0]) ? $zass_custom['zass_video_bckgr_start'][0] : '';
			$zass_video_bckgr_end = isset($zass_custom['zass_video_bckgr_end'][0]) ? $zass_custom['zass_video_bckgr_end'][0] : '';
			$zass_video_bckgr_loop = isset($zass_custom['zass_video_bckgr_loop'][0]) ? $zass_custom['zass_video_bckgr_loop'][0] : '';
			$zass_video_bckgr_mute = isset($zass_custom['zass_video_bckgr_mute'][0]) ? $zass_custom['zass_video_bckgr_mute'][0] : '';
			break;
		case 'blog':
			$zass_video_bckgr_url = zass_get_option('blog_video_bckgr_url');
			$zass_video_bckgr_start = zass_get_option('blog_video_bckgr_start');
			$zass_video_bckgr_end = zass_get_option('blog_video_bckgr_end');
			$zass_video_bckgr_loop = zass_get_option('blog_video_bckgr_loop');
			$zass_video_bckgr_mute = zass_get_option('blog_video_bckgr_mute');
			break;
		case 'shop':
		case 'shopwide':
			$zass_video_bckgr_url = zass_get_option('shop_video_bckgr_url');
			$zass_video_bckgr_start = zass_get_option('shop_video_bckgr_start');
			$zass_video_bckgr_end = zass_get_option('shop_video_bckgr_end');
			$zass_video_bckgr_loop = zass_get_option('shop_video_bckgr_loop');
			$zass_video_bckgr_mute = zass_get_option('shop_video_bckgr_mute');
			break;
		case 'global':
			$zass_video_bckgr_url = zass_get_option('video_bckgr_url');
			$zass_video_bckgr_start = zass_get_option('video_bckgr_start');
			$zass_video_bckgr_end = zass_get_option('video_bckgr_end');
			$zass_video_bckgr_loop = zass_get_option('video_bckgr_loop');
			$zass_video_bckgr_mute = zass_get_option('video_bckgr_mute');
			break;
		default:
			break;
	}
	?>
	<div id="bgndVideo" class="zass_bckgr_player" data-property="{videoURL:'<?php echo esc_url($zass_video_bckgr_url) ?>',containment:'body',autoPlay:true, loop:<?php echo esc_js($zass_video_bckgr_loop) ? 'true' : 'false'; ?>, mute:<?php echo esc_js($zass_video_bckgr_mute) ? 'true' : 'false'; ?>, startAt:<?php echo esc_js($zass_video_bckgr_start) ? esc_js($zass_video_bckgr_start) : 0; ?>, opacity:.9, showControls:false, addRaster:true, useNoCookie:false, quality:'default'<?php if ($zass_video_bckgr_end) : ?>, stopAt:<?php echo esc_js($zass_video_bckgr_end) ?><?php endif; ?>}">
	</div>
	<?php if (!$zass_video_bckgr_mute) : ?>
		<div class="video_controlls">
			<a id="video-volume" href="#" onclick="<?php echo esc_js('jQuery("#bgndVideo").YTPToggleVolume()') ?>"><i class="fa fa-volume-up"></i></a>
			<a id="video-play" href="#" onclick="<?php echo esc_js('jQuery("#bgndVideo").YTPPlay()') ?>"><i class="fa fa-play"></i></a>
			<a id="video-pause" href="#" onclick="<?php echo esc_js('jQuery("#bgndVideo").YTPPause()') ?>"><i class="fa fa-pause"></i></a>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>