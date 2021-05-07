<?php
defined( 'ABSPATH' ) || exit;

/**
 * Widget to show an excerpt of the About us page
 *
 * @author aatanasov
 */
class ZassAboutWidget extends WP_Widget {

	public function __construct() {
		$widget_ops = array('description' => esc_html__('Shows excerpt of the About us page', 'zass-plugin'));
		parent::__construct('zass_about_widget', 'Zass About us excerpt', $widget_ops);
	}

	public function widget($args, $instance) {
		extract($args);
		$title = esc_attr(apply_filters('widget_title', $instance['title']));

		echo wp_kses_post($before_widget);
		if (!empty($title)) {
			echo wp_kses_post($before_title . $title . $after_title);
		}
		?>
		<?php echo zass_get_excerpt_by_id(intval($instance['aboutus_page'])) ?>
		<a class="r_more" href="<?php echo esc_url(get_permalink(intval($instance['aboutus_page']))) ?>"><?php esc_html_e('Read more', 'zass-plugin') ?>...</a>
		<?php
		echo wp_kses_post($after_widget);
	}

	public function form($instance) {
		// Defaults
		$defaults = array(
				'title' => sprintf(esc_html__('About %s store', 'zass-plugin'), get_bloginfo('name')),
				'aboutus_page' => ''
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		$pages = get_pages();
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'zass-plugin'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('aboutus_page')); ?>"><?php esc_html_e('Choose the About us page:', 'zass-plugin'); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('aboutus_page')); ?>" name="<?php echo esc_attr($this->get_field_name('aboutus_page')); ?>">
				<?php
				foreach ($pages as $page) {
					echo '<option value="' . intval($page->ID) . '"'
					. selected($instance['aboutus_page'], $page->ID, false)
					. '>' . $page->post_title . "</option>\n";
				}
				?>
			</select>
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['aboutus_page'] = $new_instance['aboutus_page'];

		return $instance;
	}

}

add_action('widgets_init', 'zass_register_zass_about_widget');
if (!function_exists('zass_register_zass_about_widget')) {

	function zass_register_zass_about_widget() {
		register_widget('ZassAboutWidget');
	}

}
?>
