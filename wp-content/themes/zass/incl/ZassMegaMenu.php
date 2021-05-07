<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Created at WP 4.1
 */
if (!class_exists('Zass_Back_Walker')) {

	/**
	 * Renders the menu on backend
	 *
	 * @author aatanasov
	 */
	class Zass_Back_Walker extends Walker_Nav_Menu {

		/**
		 * @see Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of page.
		 */
		function start_lvl(&$output, $depth = 0, $args = array()) {

		}

		/**
		 * @see Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of page.
		 */
		function end_lvl(&$output, $depth = 0, $args = array()) {

		}

		/**
		 * Start the element output.
		 * Copied from Walker_Nav_Menu_Edit
		 *
		 * @see Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 * @param int    $id     Not used.
		 */
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id = esc_attr($item->ID);
			$removed_args = array(
					'action',
					'customlink-tab',
					'edit-menu-item',
					'menu-item',
					'page-tab',
					'_wpnonce',
			);

			$original_title = '';
			if ('taxonomy' == $item->type) {
				$original_title = get_term_field('name', $item->object_id, $item->object, 'raw');
				if (is_wp_error($original_title))
					$original_title = false;
			} elseif ('post_type' == $item->type) {
				$original_object = get_post($item->object_id);
				$original_title = get_the_title($original_object->ID);
			}

			$classes = array(
					'menu-item menu-item-depth-' . $depth,
					'menu-item-' . esc_attr($item->object),
					'menu-item-edit-' . ( ( isset($_GET['edit-menu-item']) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if (!empty($item->_invalid)) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf(esc_html__('%s (Invalid)', 'zass'), $item->title);
			} elseif (isset($item->post_status) && 'draft' == $item->post_status) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf(esc_html__('%s (Pending)', 'zass'), $item->title);
			}

			$title = (!isset($item->label) || '' == $item->label ) ? $title : $item->label;

			// Check is mega menu
			$is_set_megamenu = false;
			$submenu_text = '';

			if (0 == $depth) {
				$submenu_text = 'style="display: none;"';
				$is_set_megamenu = get_post_meta($item->ID, '_zass-menu-item-is_megamenu', true) == 'active' ? true : false;

				if ($is_set_megamenu) {
					$classes[] = 'zass_is_mega';
				}
			}
			?>
			<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html($title); ?></span>
						<?php if ($depth > 0): ?>
							<span class="is-submenu" <?php echo esc_attr($submenu_text); ?>><?php esc_html_e('sub item', 'zass'); ?></span>
						<?php endif; ?>
					</span>
					<span class="item-controls">
						<span class="item-type item-type-wpdef"><?php echo esc_html($item->type_label); ?></span>
						<span class="item-type item-type-zass-column">[<?php esc_html_e('Column', 'zass'); ?>]</span>
						<span class="item-type item-type-zass-mega">[<?php esc_html_e('Mega Menu', 'zass'); ?>]</span>
						<span class="item-order hide-if-js">
							<a href="<?php
							echo esc_url(wp_nonce_url(
															add_query_arg(
																			array(
									'action' => 'move-up-menu-item',
									'menu-item' => $item_id,
																			), remove_query_arg($removed_args, admin_url('nav-menus.php'))
															), 'move-menu_item'
							));
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'zass'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
							echo esc_url(wp_nonce_url(
															add_query_arg(
																			array(
									'action' => 'move-down-menu-item',
									'menu-item' => $item_id,
																			), remove_query_arg($removed_args, admin_url('nav-menus.php'))
															), 'move-menu_item'
							));
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'zass'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'zass'); ?>" href="<?php
						echo esc_url(( isset($_GET['edit-menu-item']) && $item_id == $_GET['edit-menu-item'] ) ? admin_url('nav-menus.php') : add_query_arg('edit-menu-item', $item_id, remove_query_arg($removed_args, admin_url('nav-menus.php#menu-item-settings-' . $item_id))));
						?>"><?php esc_html_e('Edit Menu Item', 'zass'); ?></a>
					</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
					<?php if ('custom' == $item->type) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
								<?php esc_html_e('URL', 'zass'); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->url); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin">
						<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e('Navigation Label', 'zass'); ?>
							<span class='zass_mega_column_label'><?php esc_html_e('(Enter "-" to hide)', 'zass'); ?></span><br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->title); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e('Title Attribute', 'zass'); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->post_excerpt); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked($item->target, '_blank'); ?> />
							<?php esc_html_e('Open link in a new window/tab', 'zass'); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e('CSS Classes (optional)', 'zass'); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr(implode(' ', $item->classes)); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e('Link Relationship (XFN)', 'zass'); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->xfn); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e('Description', 'zass'); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html($item->description); // textarea_escaped                                                ?></textarea>
							<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'zass'); ?></span>
						</label>
					</p>

					<div class='zass-megamenu-custom'>
						<!-- START zass custom options -->
						<?php
						$title = esc_html__('Custom Menu Label', 'zass');
						$key = "zass-menu-item-custom_label";
						$value = get_post_meta($item->ID, '_' . $key, true);
						?>

						<p class="description description-thin zass_custom_label">
							<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>"><?php echo esc_html($title); ?>
								<input type="text" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="widefat edit-menu-item-attr-title" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" value="<?php echo esc_attr($value); ?>" />
							</label>
						</p>
						<?php
						$title = esc_html__('Label Color', 'zass');
						$key = "zass-menu-item-label_color";
						$value = get_post_meta($item->ID, '_' . $key, true);
						?>

                        <p class="description description-thin zass_label_color">
                            <span><?php echo esc_html($title); ?></span>
                            <input type="text" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="widefat edit-menu-item-attr-title zass-menu-colorpicker" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" value="<?php echo esc_attr($value); ?>" />
                        </p>
						<?php
						$title = esc_html__('Icon', 'zass');
						$key = "zass-menu-item-icon";
						$value = get_post_meta($item->ID, '_' . $key, true);
						?>

						<p class="description description-thin">
							<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>"><?php echo esc_html($title); ?><br/>
								<input type="text" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="zass-menu-icons" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" value="<?php echo esc_attr($value); ?>" />
							</label>
						</p>

						<?php
						$title = esc_html__('Highlight menu item', 'zass');
						$key = "zass-menu-item-highlight";
						$value = get_post_meta($item->ID, '_' . $key, true);

						if ($value != "") {
							$value = "checked='checked'";
						}
						?>

						<p class="description description-wide zass_checkbox">
							<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>">
								<input type="checkbox" value="active" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class=" <?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" <?php echo esc_attr($value); ?> /><?php echo esc_html($title); ?>
							</label>
						</p>

						<?php
						$title = esc_html__('Set as Mega Menu', 'zass');
						$key = "zass-menu-item-is_megamenu";
						$value = get_post_meta($item->ID, '_' . $key, true);

						if ($value != "") {
							$value = "checked='checked'";
						}
						?>

						<p class="description description-wide zass_checkbox zass_is_mega_field">
							<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>">
								<input type="checkbox" value="active" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class=" <?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" <?php echo esc_attr($value); ?> /><?php echo esc_html($title); ?>
							</label>
						</p>

						<?php
						$title = esc_html__('Use the Description to create a Text Block. It will hide the Navigation Label and display the description instead. (note: dont remove the label text, otherwise WordPress will delete the item)', 'zass');
						$key = "zass-menu-item-is_description";
						$value = get_post_meta($item->ID, '_' . $key, true);

						if ($value != "")
							$value = "checked='checked'";
						?>

						<p class="description description-wide zass_checkbox zass_is_description_field">
							<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>">
								<input type="checkbox" value="active" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class=" <?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" <?php echo esc_attr($value); ?> /><span><?php echo esc_html($title); ?></span>
							</label>
						</p>

						<!-- END zass custom options -->
					</div>

					<p class="field-move hide-if-no-js description description-wide">
						<label>
							<span><?php esc_html_e('Move', 'zass'); ?></span>
							<a href="#" class="menus-move-up"><?php esc_html_e('Up one', 'zass'); ?></a>
							<a href="#" class="menus-move-down"><?php esc_html_e('Down one', 'zass'); ?></a>
							<a href="#" class="menus-move-left"></a>
							<a href="#" class="menus-move-right"></a>
							<a href="#" class="menus-move-top"><?php esc_html_e('To the top', 'zass'); ?></a>
						</label>
					</p>

					<div class="menu-item-actions description-wide submitbox">
						<?php if ('custom' != $item->type && $original_title !== false) : ?>
							<p class="link-to-original">
								<?php printf(__('Original: %s', 'zass'), '<a href="' . esc_url($item->url) . '">' . esc_html($original_title) . '</a>'); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
						echo esc_url(wp_nonce_url(
														add_query_arg(
																		array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
																		), admin_url('nav-menus.php')
														), 'delete-menu_item_' . $item_id
						));
						?>"><?php esc_html_e('Remove', 'zass'); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url(add_query_arg(array('edit-menu-item' => $item_id, 'cancel' => time()), admin_url('nav-menus.php')));
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'zass'); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->object_id); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->object); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->menu_item_parent); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->menu_order); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->type); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
				<?php
				$output .= ob_get_clean();
			}

		}

	}

	if (!class_exists('ZassFrontWalker')) {

		/**
		 * Renders the menu on frontend
		 *
		 * @author aatanasov
		 */
		class ZassFrontWalker extends Walker_Nav_Menu {

			/**
			 * @see Walker::$tree_type
			 * @var string
			 */
			var $tree_type = array('post_type', 'taxonomy', 'custom');

			/**
			 * @see Walker::$db_fields
			 * @todo Decouple this.
			 * @var array
			 */
			var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

			/**
			 * @var int $columns
			 */
			var $columns = 0;

			/**
			 * @var int $max_columns maximum number of columns within one mega menu
			 */
			var $max_columns = 0;

			/**
			 * @var string $is_mega_active hold information whetever we are currently rendering a mega menu or not
			 */
			var $is_mega_active = 0;

			/**
			 * @see Walker::start_lvl()
			 *
			 * @param string $output Passed by reference. Used to append additional content.
			 * @param int $depth Depth of page. Used for padding.
			 */
			function start_lvl(&$output, $depth = 0, $args = array()) {
				$indent = str_repeat("\t", $depth);

				if ($depth === 0 && $this->is_mega_active) {
					$output .= '<div class="zass-mega-menu" style="display:none">';
				}

				$output .= "\n$indent<ul class=\"sub-menu\">\n";
			}

			/**
			 * @see Walker::end_lvl()
			 *
			 * @param string $output Passed by reference. Used to append additional content.
			 * @param int $depth Depth of page. Used for padding.
			 */
			function end_lvl(&$output, $depth = 0, $args = array()) {
				$indent = str_repeat("\t", $depth);
				$output .= "$indent</ul>\n";

				if ($depth === 0 && $this->is_mega_active) {
					$output .= '</div>';
				}
			}

			/**
			 * @see Walker::start_el()
			 *
			 * @param string $output Passed by reference. Used to append additional content.
			 * @param object $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @param int $current_page Menu item ID.
			 * @param object $args
			 */
			public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
				$indent = ( $depth ) ? str_repeat("\t", $depth) : '';

				if ($depth === 0) {
					$this->is_mega_active = get_post_meta($item->ID, '_zass-menu-item-is_megamenu', true);
				}

				$classes = empty($item->classes) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;

				$item_output = $args->before;

				// Mega column headings class
				if ($this->is_mega_active && $depth === 1) {
					$classes[] = 'zass_colum_title';
				}

				// Highlight item
				$highlight_it = get_post_meta($item->ID, '_zass-menu-item-highlight', true);
				if ($highlight_it) {
					$classes[] = 'zass-highlight-menu-item';
				}

				$has_mega_description = false;
				if ($depth >= 2 && $this->is_mega_active && get_post_meta($item->ID, '_zass-menu-item-is_description', true)) {
					$has_mega_description = true;
					$classes[] = 'zass_mega_text_block';
					$item_output.= do_shortcode($item->post_content);
				}

				// handle the FA icons on menu items
				$font_awesome_icon = get_post_meta($item->ID, '_zass-menu-item-icon', true);
				if($font_awesome_icon) {
					$classes[] = 'zass-link-has-icon';
				}

				$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
				$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

				$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
				$id = $id ? ' id="' . esc_attr($id) . '"' : '';

				$output .= $indent . '<li' . $id . $class_names . '>';

				$atts = array();
				$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
				$atts['target'] = !empty($item->target) ? $item->target : '';
				$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
				$atts['href'] = esc_url(!empty($item->url) ? $item->url : '');

				$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

				$attributes = '';
				foreach ($atts as $attr => $value) {
					if (!empty($value)) {
						$value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}

				/** This filter is documented in wp-includes/post-template.php */
				$title = apply_filters('the_title', $item->title, $item->ID);

				if ($title != '-' && $title != '"-"' && $title != '&#8211;' && !$has_mega_description) {
					// Show the label and color in the menu
					$custom_menu_label_val = get_post_meta($item->ID, '_zass-menu-item-custom_label', true);
					$custom_menu_label_color = get_post_meta($item->ID, '_zass-menu-item-label_color', true);
					if ($custom_menu_label_val) {
						$item_output .= '<span class="zass-custom-menu-label" ' . ($custom_menu_label_color ? 'style="background-color:' . esc_attr($custom_menu_label_color) . '"' : '') . ' >' . esc_html($custom_menu_label_val) . '</span>';
					}
					$item_output .= '<a' . $attributes . '>';
					if ($font_awesome_icon) {
						$item_output .= '<i class="' . $font_awesome_icon . '"></i> ';
					}
					$item_output .= $args->link_before . $title . $args->link_after;
					$item_output .= '</a>';
				}

				$item_output .= $args->after;

				$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
			}

			/**
			 * @see Walker::end_el()
			 *
			 * @param string $output Passed by reference. Used to append additional content.
			 * @param object $item Page data object. Not used.
			 * @param int $depth Depth of page. Not Used.
			 */
			function end_el(&$output, $item, $depth = 0, $args = array()) {
				$output .= "</li>\n";
			}

		}

	}

	if (!class_exists('ZassMegaMenu')) {

		/**
		 * Handle Mega Menu
		 */
		class ZassMegaMenu {

			function __construct() {
				//set the backend menu walker
				add_filter('wp_edit_nav_menu_walker', array(&$this, 'editBackendWalker'), 100, 2);

				//save the custom options:
				add_action('wp_update_nav_menu_item', array(&$this, 'updateNavMenu'), 100, 3);
			}

			/**
			 * Use Zass_Back_Walker for backend menu editing
			 */
			public function editBackendWalker($class, $menu_id) {

				$menu_locations = get_nav_menu_locations();

				// If we are editing menu on location that starts with 'primary' - assign 'Zass_Back_Walker'
				foreach($menu_locations as $location => $stored_menu_id) {
					if(substr($location, 0, 7) === 'primary' && $stored_menu_id == $menu_id) {
						$class = 'Zass_Back_Walker';
					}
				}

				return $class;
			}

			/*
			 * Save the custom menu item elements (is_megamenu, text_field, ...)
			 *
			 * @param int $menu_id
			 * @param int $menu_item_db
			 */

			public function updateNavMenu($menu_id, $menu_item_db) {
				$fields = array('is_megamenu', 'is_description', 'custom_label', 'label_color', 'highlight', 'icon');

				foreach ($fields as $field) {
					if (!isset($_POST['zass-menu-item-' . $field][$menu_item_db])) {
						$_POST['zass-menu-item-' . $field][$menu_item_db] = "";
					}

					$value = $_POST['zass-menu-item-' . $field][$menu_item_db];
					update_post_meta($menu_item_db, '_zass-menu-item-' . $field, $value);
				}
			}

		}

	}

