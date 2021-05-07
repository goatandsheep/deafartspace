<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Zass_Transfer_Content')) {

	/**
	 * Singelton class to manage import/export functionality
	 *
	 * @author aatanasov
	 */
	class Zass_Transfer_Content {

		/**
		 * Current theme options
		 *
		 * @var String
		 */
		private $theme_options;

		/**
		 * Location of demo files
		 *
		 * @var String
		 */
		private $demo_location;

		/**
		 * Export file name
		 *
		 * @var String
		 */
		public $export_filename;

		/**
		 * Delimiter for separating different settings in the file
		 *
		 * @var String
		 */
		private $delimiter;

		/**
		 * Returns the *Zass_Transfer_Content* instance of this class.
		 *
		 * @staticvar Singleton $instance The *Zass_Transfer_Content* instances of this class.
		 *
		 * @return Singleton The *Zass_Transfer_Content* instance.
		 */
		public static function getInstance() {
			static $instance = null;
			if ($instance === null) {
				$instance = new Zass_Transfer_Content();
			}

			return $instance;
		}

		/**
		 * Protected constructor to prevent creating a new instance of the
		 * *Zass_Transfer_Content* via the `new` operator from outside of this class.
		 */
		protected function __construct() {

			$this->setDelimiter('|||');
			$this->export_filename = get_template_directory() . '/store/settings/' . get_bloginfo('name') . '_settings_' . date('Y_m_d') . '.txt';
			$this->demo_location = get_template_directory() . '/store/demo/';

			global $wp_filesystem;

			if (empty($wp_filesystem)) {
				require_once (ABSPATH . '/wp-admin/includes/file.php');
				WP_Filesystem();
			}
		}

		/**
		 * Private clone method to prevent cloning of the instance of the
		 * *Zass_Transfer_Content* instance.
		 *
		 * @return void
		 */
		private function __clone() {

		}

		/**
		 * Private unserialize method to prevent unserializing of the *Zass_Transfer_Content*
		 * instance.
		 *
		 * @return void
		 */
		private function __wakeup() {

		}

		/**
		 * Set delimiter
		 *
		 * @return String
		 */
		public function getDelimiter() {
			return $this->delimiter;
		}

		/**
		 * Get delimiter
		 *
		 * @param String $delimiter
		 */
		public function setDelimiter($delimiter) {
			$this->delimiter = $delimiter;
		}

		/**
		 * Get demo location
		 *
		 * @return String
		 */
		public function getDemoLocation() {
			return $this->demo_location;
		}

		/**
		 * Gets the theme name from the stylesheet (lowercase and without spaces)
		 *
		 * @return String
		 */
		private function getCurrentThemeDirToLower() {
			// This gets the theme name from the stylesheet (lowercase and without spaces)
			$themename_orig = get_option('stylesheet');
			$themename = preg_replace("/\W/", "_", strtolower($themename_orig));

			if(!get_option($themename)) {
				// remove the '_child' if there is
				$themename = substr($themename, 0,-6);
			}
			
			return $themename;
		}

		/**
		 * Get theme options
		 *
		 * @return String theme options
		 */
		private function getThemeOptions() {
			if (!$this->theme_options) {
				$this->theme_options = get_option($this->getCurrentThemeDirToLower());
			}

			return $this->theme_options;
		}

		/**
		 * Encodes the options and stores the export.
		 *
		 * @return int Result
		 */
		protected function getEncodedOptions() {

			$encodedOptions = json_encode($this->getThemeOptions());

			return $encodedOptions;
		}

		/**
		 * Stores given file.
		 *
		 * @param String $filename Filename of the export file
		 * @param String $data Data to be stored
		 * @return int Result
		 */
		protected function storeFile($filename, $data) {

			/**
			 * @global WP_Filesystem_Base $wp_filesystem subclass
			 */
			global $wp_filesystem;

			return $wp_filesystem->put_contents($filename, $data);
		}

		/**
		 * Decodes settings during Import
		 *
		 * @param String $encoded_settings Encoded settings
		 * @return mixed
		 */
		protected function decodeSettings($encoded_settings) {
			return json_decode($encoded_settings, TRUE);
		}

		/**
		 * Imports encoded options
		 *
		 * @param String $encoded_options Encoded options
		 */
		protected function importOptions($encoded_options) {
			$options = $this->decodeSettings($encoded_options);

			update_option($this->getCurrentThemeDirToLower(), $options);
		}

		/**
		 * Import WP content
		 */
		public function importWPContent($file) {

			global $wpdb;

			add_filter("http_request_args", array(&$this, "setHttpRequestTimeout"), 10, 1);

			if (class_exists('ZassImport')) {

				$wp_import = new ZassImport();
				$wp_import->fetch_attachments = true;
				$wp_import->import($file);
			}
		}

		public function setHttpRequestTimeout($req) {
			$req["timeout"] = 360;
			return $req;
		}

		protected function getEncodedWidgets() {

			$sidebars_array = get_option('sidebars_widgets');
			$widget_types = array();
			$all_widgets_options = array();

			// get all registered widget types
			foreach ($sidebars_array as $sidebar_name => $widgets) {
				if ('wp_inactive_widgets' !== $sidebar_name && is_array($widgets)) {
					foreach ($widgets as $widget_index) {
						$widget_types[] = trim(substr($widget_index, 0, strrpos($widget_index, '-')));
					}
				}
			}

			// remove duplicates
			array_unique($widget_types);

			// get widget values for each type
			foreach ($widget_types as $widget_type) {
				$all_widgets_options['widget_' . $widget_type] = get_option('widget_' . $widget_type);
			}

			$sidebars_and_widgets = array('sidebars' => $sidebars_array, 'widgets' => $all_widgets_options);
			$encodedWidgets = json_encode($sidebars_and_widgets);

			return $encodedWidgets;
		}

		public function exportSettings() {

			$encodedOptions = $this->getEncodedOptions();
			$encodedWidgets = $this->getEncodedWidgets();

			return $this->storeFile($this->export_filename, $encodedOptions . $this->getDelimiter() . $encodedWidgets);
		}

		public function importSettings($filename, $widget_menu_1, $widget_menu_2) {
			/**
			 * @global WP_Filesystem_Base $wp_filesystem subclass
			 */
			global $wp_filesystem;

			$file_error = false;
			$data = $wp_filesystem->get_contents($filename);

			if ($data) {
				$settings_array = explode($this->getDelimiter(), $data);

				if ( is_array( $settings_array ) && ! empty( $settings_array ) ) {
					$options              = $this->decodeSettings( $settings_array[0] );
					$sidebars_and_widgets = $this->decodeSettings( $settings_array[1] );

					update_option( $this->getCurrentThemeDirToLower(), $options );
					update_option( 'sidebars_widgets', $sidebars_and_widgets['sidebars'] );

					foreach ( $sidebars_and_widgets['widgets'] as $widget_option_name => $widget_options ) {

						if ( $widget_option_name == 'widget_nav_menu' ) {
							foreach ( $widget_options as $key => $option ) {
								if ( is_array( $option ) ) {
									if ( $option['title'] == 'Information' && $widget_menu_1 ) {
										$widget_options[ $key ]['nav_menu'] = $widget_menu_1->term_id;
									} elseif ( $option['title'] == 'Extras' && $widget_menu_2 ) {
										$widget_options[ $key ]['nav_menu'] = $widget_menu_2->term_id;
									}
								}
							}

						}
						update_option( $widget_option_name, $widget_options );


					}
				} else {
					$file_error = true;
				}
			}

			if ($file_error) {
				return new WP_Error('settings_import_file_error', esc_html__('There was error with settings file.', 'zass'));
			}
		}

		/**
		 * Import all revolution sliders
		 *
		 * @param string $demo_name
		 * @return boolean
		 */
		public function importRevSliders($demo_name = 'one') {
			if (!class_exists('RevSliderSliderImport')) {
				return false;
			}

			$rev_directory = $this->getDemoLocation() . $demo_name . '/revsliders/';
			foreach ( glob( $rev_directory . '*.zip' ) as $filename ) { // get all files from revsliders data dir
				$filename    = basename( $filename );
				$rev_files[] = $rev_directory . $filename;
			}

			if ( ! isset( $rev_files ) || ! is_array( $rev_files ) ) {
				return false;
			}

			$revSliderSliderImport = new RevSliderSliderImport();

			$is_template = false;
			$single_slide = true;
			$update_animation = true;
			$update_navigation = true;
			$install = true;
			foreach ($rev_files as $rev_file) { // finally import rev slider data files
				$importSliderResult = $revSliderSliderImport->import_slider( $update_animation, $rev_file, $is_template, $single_slide, $update_navigation, $install );
			}
		}

		public function doImportDemo($demo_name = 'one') {

			echo 'import started ' . date(DATE_RFC2822) . '<br/>';

			// Delete current menus
			$all_pages_menu_for_del = wp_get_nav_menu_object('Main menu');
			$top_menu_for_del = wp_get_nav_menu_object('Top menu');
			$footer_menu_for_del = wp_get_nav_menu_object('Footer Menu');

			$widget_menu_1_for_del =  wp_get_nav_menu_object('Widget menu 1');
			$widget_menu_2_for_del =  wp_get_nav_menu_object('Widget menu 2');

			if ($all_pages_menu_for_del) {
				wp_delete_nav_menu('Main menu');
			}
			if ($top_menu_for_del) {
				wp_delete_nav_menu('Top menu');
			}
			if ($footer_menu_for_del) {
				wp_delete_nav_menu('Footer Menu');
			}
			if ($widget_menu_1_for_del) {
				wp_delete_nav_menu('Widget menu 1');
			}
			if ($widget_menu_2_for_del) {
				wp_delete_nav_menu('Widget menu 2');
			}

			$this->importWPContent($this->getDemoLocation() . '/' . $demo_name . '/demo.xml');

			echo 'zass_wp_xml_import_success ' . date(DATE_RFC2822) . '<br/>';

			// Get Widget menus IDs so we can pass them to widget import, so we have propper options set
			$widget_menu_1 = wp_get_nav_menu_object('Widget menu 1');
			$widget_menu_2 = wp_get_nav_menu_object('Widget menu 2');

			$settings_imp_result = $this->importSettings($this->getDemoLocation() . '/' . $demo_name . '/demo.txt', $widget_menu_1, $widget_menu_2);
			if (is_wp_error($settings_imp_result)) {
				echo 'zass_settings_import_error';
				return false;
			}
			echo 'zass_settings_import_success ' . date(DATE_RFC2822) . '<br/>';

			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure('/%postname%/');
			$wp_rewrite->flush_rules();

			// Set menus
			$all_pages_menu = wp_get_nav_menu_object('Main menu');
			// Set mega menu on main demo
			if ($demo_name === 'zass0' && isset($all_pages_menu->term_id)) {
				$menu_items = wp_get_nav_menu_items($all_pages_menu->term_id);

				foreach ($menu_items as $item) {
					if (in_array($item->title, array('Shop', 'Elements'))) {
						update_post_meta($item->ID, '_zass-menu-item-is_megamenu', 'active');
					}

					// Menu descriptions that contain banners
					if(in_array($item->title, array('shop_menu_banner'))) {
						update_post_meta($item->ID, '_zass-menu-item-is_description', 'active');
					}

					// Menu labels settings: [menu name] => array([menu label], [menu color])
					$menu_labels_settings = array(
						'Shop' => array('NEW', '#7ebfbf'),
						'Shop Grid View' => array('LEFT SIDEBAR', ''),
						'Shop Video Background' => array('NO SOUND', '#7ebfbf'),
						'Limited Time Deal' => array('COUNTDOWN', '#f3a395')

					);
					// Now do the labels
					foreach ($menu_labels_settings as $title => $setting){
						if($item->title === $title) {
							update_post_meta($item->ID, '_zass-menu-item-custom_label', $setting[0]);
							update_post_meta($item->ID, '_zass-menu-item-label_color', $setting[1]);
						}
					}

					// Menu icons settings: [menu name] => [icon code]
					$menu_icons_settings = array(
						'Marketplace Demo' => 'fa fa-shopping-basket',
						'Typography &#038; Columns' => 'fa fa-columns',
						'Tabs and Tours' => 'fa fa-table',
						'Accordions &#038; Toggles' => 'fa fa-bars',
						'Icons' => 'fa fa-fort-awesome',
						'Buttons' => 'fa fa-external-link-square',
						'Progress Bars' => 'fa fa-tasks',
						'Pie Charts' => 'fa fa-pie-chart',
						'Round Charts' => 'fa fa-circle-o-notch',
						'Line Charts' => 'fa fa-signal',
						'Counters' => 'fa fa-sort-numeric-desc',
						'Countdown' => 'fa fa-clock-o',
						'Price Tables' => 'fa fa-money',
						'Typing Rotator' => 'fa fa-i-cursor',
						'Icon Teasers' => 'fa fa-globe',
						'Icon Boxes' => 'fa fa-clone',
						'Product Grids' => 'fa fa-shopping-basket',
						'Banners' => 'fa fa-crosshairs',
						'Galleries' => 'fa fa-camera-retro',
						'Map with Directions' => 'fa fa-map-signs'
					);

					// Now do the icons
					foreach ($menu_icons_settings as $title => $setting){
						if($item->title === $title) {
							update_post_meta($item->ID, '_zass-menu-item-icon', $setting);
						}
					}
				}
			}

			if ($demo_name === 'zass1' && isset($all_pages_menu->term_id)) {
				$menu_items = wp_get_nav_menu_items($all_pages_menu->term_id);

				foreach ($menu_items as $item) {
					if (in_array($item->title, array('Jewelry', 'Home & Living', 'Shops', 'Blog'))) {
						update_post_meta($item->ID, '_zass-menu-item-is_megamenu', 'active');
					}

					// Menu descriptions that contain banners
					if(in_array($item->title, array('jewelry_menu_banner', 'home_decor_menu_banner', 'bedding_menu_banner', 'bathroom_menu_banner', 'wall_menu_banner'))) {
						update_post_meta($item->ID, '_zass-menu-item-is_description', 'active');
					}

					// Menu labels settings: [menu name] => array([menu label], [menu color])
					$menu_labels_settings = array(
						'Jewelry' => array('MEGA MENU', '')

					);
					// Now do the labels
					foreach ($menu_labels_settings as $title => $setting){
						if($item->title === $title) {
							update_post_meta($item->ID, '_zass-menu-item-custom_label', $setting[0]);
							update_post_meta($item->ID, '_zass-menu-item-label_color', $setting[1]);
						}
					}

					// Menu icons settings: [menu name] => [icon code]
					$menu_icons_settings = array();

					// Now do the icons
					foreach ($menu_icons_settings as $title => $setting){
						if($item->title === $title) {
							update_post_meta($item->ID, '_zass-menu-item-icon', $setting);
						}
					}
				}
			}

			$top_menu = wp_get_nav_menu_object('Top menu');
			$footer_menu = wp_get_nav_menu_object('Footer Menu');

			$locations = get_theme_mod('nav_menu_locations');
			if ($all_pages_menu) {
				$locations['primary'] = $all_pages_menu->term_id;
			}
			if ($top_menu) {
				$locations['secondary'] = $top_menu->term_id;
			}
			if ($footer_menu) {
				$locations['tertiary'] = $footer_menu->term_id;
			}
			set_theme_mod('nav_menu_locations', $locations);

			// Set home and blog pages
			$front_page = get_page_by_path('Home');

			if(get_page_by_title('Blog')) {
				$blog_page = get_page_by_title( 'Blog' );
			} else {
				$blog_page = get_page_by_title( 'News' );
			}

			if ($front_page) {
				update_option('show_on_front', 'page');
				update_option('page_on_front', $front_page->ID);
			}

			if ($blog_page) {
				update_option('show_on_front', 'page');
				update_option('page_for_posts', $blog_page->ID);
			}

			// Install woocommerce pages
			if ( ZASS_IS_WOOCOMMERCE ) {
				// Set shop page to display both categories and products
				update_option( 'woocommerce_shop_page_display', 'both' );

				$my_account_page = get_page_by_path( 'my-account' );
				if ( ! is_null( $my_account_page ) ) {
					wp_delete_post( $my_account_page->ID, true );
				}

				WC_Install::create_pages();
				// We no longer need to install pages
				delete_option( '_wc_needs_pages' );
				WC_Admin_Notices::remove_notice( 'install' );
				delete_transient( '_wc_activation_redirect' );
			}

			// import rev sliders
			if (ZASS_IS_REVOLUTION) {
				$this->importRevSliders($demo_name);
			}

			return true;
		}

	}

}