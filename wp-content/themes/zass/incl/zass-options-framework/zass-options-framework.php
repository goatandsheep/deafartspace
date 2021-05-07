<?php
/* Make sure we don't expose any info if called directly */

if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a little extension, don't mind me.";
	exit;
}

/* If the user can't edit theme options, no use running this plugin */

add_action('init', 'zass_optionsframework_rolescheck');

function zass_optionsframework_rolescheck() {
	if (current_user_can('edit_theme_options')) {
		// If the user can edit theme options, let the fun begin!
		add_action('admin_menu', 'zass_optionsframework_add_page');
		add_action('admin_init', 'zass_optionsframework_init');
	}
}

/* Loads the file for option sanitization */

add_action('init', 'zass_optionsframework_load_sanitization');

function zass_optionsframework_load_sanitization() {
	require_once get_template_directory() . '/incl/zass-options-framework/zass-options-sanitize.php';
}

/*
 * Creates the settings in the database by looping through the array
 * we supplied in zass-options.php.  This is a neat way to do it since
 * we won't have to save settings for headers, descriptions, or arguments.
 *
 * Read more about the Settings API in the WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

// Loads the options array from the theme
require_once get_template_directory() . '/incl/zass-options-framework/zass-options.php';

function zass_optionsframework_init() {

	// Include the required files
	require_once get_template_directory() . '/incl/zass-options-framework/zass-options-interface.php';
	require_once get_template_directory() . '/incl/zass-options-framework/zass-options-medialibrary-uploader.php';

	// Loads the options array from the theme
	require_once get_template_directory() . '/incl/zass-options-framework/zass-options.php';

	$option_name = 'zass';

	// If the option has no saved data, load the defaults
	if (!get_option($option_name)) {
		zass_optionsframework_setdefaults();
	}

	// Registers the settings fields and callback
	register_setting('zass-optionsframework', $option_name, 'zass_optionsframework_validate');
}

/**
 * Ensures that a user with the 'edit_theme_options' capability can actually set the options
 * See: http://core.trac.wordpress.org/ticket/14365
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function zass_optionsframework_page_capability($capability) {
	return 'edit_theme_options';
}

/*
 * Adds default options to the database if they aren't already present.
 * May update this later to load only on plugin activation, or theme
 * activation since most people won't be editing the zass-options.php
 * on a regular basis.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */

function zass_optionsframework_setdefaults() {

	$option_name = 'zass';

	// If the options haven't been added to the database yet, they are added now
	$values = zass_get_default_values();

	if (isset($values)) {
		add_option($option_name, $values); // Add option with default settings
	}
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if (!function_exists('zass_optionsframework_add_page')) {

	function zass_optionsframework_add_page() {
		$zass_page = add_theme_page(esc_html__('Theme Options', 'zass'), esc_html__('Theme Options', 'zass'), 'edit_theme_options', 'zass-optionsframework', 'zass_optionsframework_page');

		// Load the required CSS and javscript
		add_action('admin_enqueue_scripts', 'zass_optionsframework_load_scripts');
	}

}

/* Loads the javascript */

function zass_optionsframework_load_scripts($hook) {

	if ('appearance_page_zass-optionsframework' != $hook) {
		return;
	}

	// Enqueued scripts
	wp_enqueue_script('zass-options-custom', ZASS_OPTIONS_FRAMEWORK_DIRECTORY . 'js/zass-options-custom.js', array('jquery'), false, true);

	// Enqueued styles
	wp_enqueue_style('zass-optionsframework', ZASS_OPTIONS_FRAMEWORK_DIRECTORY . 'css/zass-optionsframework.css');

	// Inline scripts from zass-options-interface.php
	do_action('zass_optionsframework_custom_scripts');
}

/*
 * Builds out the options panel.
 *
 * If we were using the Settings API as it was likely intended we would use
 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
 * we'll call our own custom zass_optionsframework_fields.  See zass-options-interface.php
 * for specifics on how each individual field is generated.
 *
 * Nonces are provided using the settings_fields()
 *
 */

if (!function_exists('zass_optionsframework_page')) {

	function zass_optionsframework_page() {
		settings_errors();
		?>

		<div id="zass-optionsframework-wrap" class="wrap">
			<div class="nav-tab-wrapper">
				<?php echo zass_optionsframework_tabs(); ?>
			</div>
			<div id="zass-optionsframework-metabox" class="metabox-holder">
				<div id="zass-optionsframework" class="postbox">
					<form action="options.php" method="post">
						<div class="zass-optionsframework-submit-top">
							<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e('Save All Options', 'zass'); ?>" />
                            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e('Restore Defaults', 'zass'); ?>" onclick="<?php echo esc_js(sprintf('return confirm("%1$s")', __('Click OK to reset. Any theme settings will be lost!', 'zass'))) ?>" />
							<div class="clear"></div>
						</div>
						<?php settings_fields('zass-optionsframework'); ?>
						<?php zass_optionsframework_fields(); /* Settings */ ?>
						<div class="zass-optionsframework-submit">
							<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e('Save All Options', 'zass'); ?>" />
                            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e('Restore Defaults', 'zass'); ?>" onclick="<?php echo esc_js(sprintf('return confirm("%1$s")', __('Click OK to reset. Any theme settings will be lost!', 'zass'))) ?>" />
							<div class="clear"></div>
						</div>
					</form>
				</div> <!-- / #container -->
			</div>
			<?php do_action('zass_optionsframework_after'); ?>
		</div> <!-- / .wrap -->

		<?php
	}

}

/**
 * Validate Options.
 *
 * This runs after the submit/reset button has been clicked and
 * validates the inputs.
 *
 * @uses $_POST['reset'] to restore default options
 */
function zass_optionsframework_validate($input) {

	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's zass-options.php
	 * file will be added to the option for the active theme.
	 */

	if (isset($_POST['reset'])) {
		add_settings_error('zass-optionsframework', 'restore_defaults', esc_html__('Default options restored.', 'zass'), 'updated fade');
		return zass_get_default_values();
	} else {

		/*
		 * Update Settings
		 *
		 * This used to check for $_POST['update'], but has been updated
		 * to be compatible with the theme customizer introduced in WordPress 3.4
		 */

		$clean = array();
		$options = zass_optionsframework_options();

		foreach ($options as $option) {

			if (!isset($option['id'])) {
				continue;
			}

			if (!isset($option['type'])) {
				continue;
			}

			$id = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($option['id']));

			// Set checkbox to false if it wasn't sent in the $_POST
			if ('checkbox' == $option['type'] && !isset($input[$id])) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ('multicheck' == $option['type'] && !isset($input[$id])) {
				foreach ($option['options'] as $key => $value) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if (isset($input[$id])) {
				if (has_filter('zass_sanitize_' . $option['type'])) {
					$clean[$id] = apply_filters('zass_sanitize_' . $option['type'], $input[$id], $option);
				}
			}
		}

		add_settings_error('zass-optionsframework', 'save_options', esc_html__('Options saved.', 'zass'), 'updated fade');
		return $clean;
	}
}

/**
 * Format Configuration Array.
 *
 * Get an array of all default values as set in
 * zass-options.php. The 'id','std' and 'type' keys need
 * to be defined in the configuration array. In the
 * event that these keys are not present the option
 * will not be included in this function's output.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */
function zass_get_default_values() {
	$output = array();
	$config = zass_optionsframework_options();
	foreach ((array) $config as $option) {
		if (!isset($option['id'])) {
			continue;
		}
		if (!isset($option['std'])) {
			continue;
		}
		if (!isset($option['type'])) {
			continue;
		}
		if (has_filter('zass_sanitize_' . $option['type'])) {
			$output[$option['id']] = apply_filters('zass_sanitize_' . $option['type'], $option['std'], $option);
		}
	}
	return $output;
}

// Search in the options array
if (!function_exists('zass_search_array')) {

	function zass_search_array($name, $array) {
		foreach ($array as $key => $val) {
			if (array_key_exists('id', $val) && $val['id'] === $name) {
				return $key;
			}
		}

		return null;
	}

}