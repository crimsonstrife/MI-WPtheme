<?php

/**
 * This is the class that adds the theme settings page on admin
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}


class Basepress_Modern_Theme_Settings
{

	/**
	 * basepress_sections_page constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{

		add_action('admin_menu', array($this, 'add_theme_page'), 20);

		add_action('init', array($this, 'add_ajax_callbacks'));

		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
	}


	/**
	 * Adds the Sections page on admin
	 *
	 * @since 1.0.0
	 */
	public function add_theme_page()
	{

		//Check that the user has the required capability
		if (current_user_can('manage_options')) {
			//Add a submenu on basepress for the theme
			add_submenu_page('basepress', 'BasePress Modern Theme', 'Modern Theme', 'manage_options', 'basepress_modern_theme', array($this, 'display_screen'));
		}
	}



	/**
	 * Defines the ajax calls for this screen
	 *
	 * @since 1.0.0
	 */
	public function add_ajax_callbacks()
	{
		add_action('wp_ajax_basepress_modern_theme_save', array($this, 'basepress_modern_theme_save'));
	}



	/**
	 * Enqueues admin scripts for this screen
	 *
	 * @since 1.0.0
	 *
	 * @param $hook
	 */
	public function enqueue_admin_scripts($hook)
	{
		global $basepress_utils;
		//Enqueue admin script
		if ('basepress_page_basepress_modern_theme' == $hook) {
			$script_path = $basepress_utils->get_theme_file_uri('settings/js/basepress-modern-theme.min.js');
			$css_path = $basepress_utils->get_theme_file_uri('settings/style.min.css');
			wp_enqueue_media();
			wp_enqueue_style('wp-color-picker');
			wp_register_script('basepress-modern-theme-js', $script_path, array('jquery', 'wp-color-picker'), BASEPRESS_VER, true);
			wp_enqueue_script('basepress-modern-theme-js');
			wp_enqueue_style('basepress-modern-theme-settings-css', $css_path, array(), BASEPRESS_VER);
		}
	}


	/**
	 * Generates the page content
	 *
	 * @since 1.0.0
	 */
	public function display_screen()
	{

		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', 'basepress'));
		}

		$defaults = array(
			'enable_settings'      => true,
			'font_family'          => '',
			'font_size'            => '',
			'header_title'         => 'Help Articles',
			'full_width_header'    => '',
			'header_offset'        => '',
			'header_image'         => '',
			'sticky_sidebar'       => '',
			'sidebar_threshold'    => '100px',
			'enable_custom_colors' => false,
			'header_color'         => '#404040',
			'header_text_color'    => '#ffffff',
			'accent_color'         => '#007f7b',
			'buttons_text_color'   => '#ffffff',
			'custom_css'           => '',
		);

		$settings = get_option('basepress_modern_theme');
		$settings = wp_parse_args($settings, $defaults);
		$header_image = wp_get_attachment_image_src($settings['header_image'], 'medium');

?>
		<div class="wrap">
			<h1><?php _e('Modern Theme Settings', 'basepress'); ?></h1>
			<div class="bpmt-body">
				<form id="bpmt-modern-theme">
					<div id="settings-menu" class="bpmt-card">
						<input type="checkbox" id="enable-setting" name="enable_settings" <?php checked($settings['enable_settings'], 1); ?> value="1">
						<div id="enable-setting-title"><?php _e('Enable Settings', 'basepress'); ?></div>
						<input id="save-settings" type="submit" value="<?php _e('Save Settings', 'basepress'); ?>">
					</div>

					<div class="bpmt-card settings-card">
						<table class="form-table">
							<tbody>
								<tr>
									<th class="setting-title"><?php _e('Google Font @import', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="text" value="<?php echo stripslashes($settings['font_family']); ?>" name="font_family" size="100">
										<p class="description">
											<?php _e('Go to fonts.google.com, choose the font you like with a regular and bold size. Paste here the @import code for the font you chose.<br>Leave empty to inherit the font family from the website theme.', 'basepress'); ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Font Size', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="number" value="<?php echo $settings['font_size']; ?>" name="font_size">
										<p class="description">
											<?php _e('Insert the size in pixels for the knowledge base font.<br>Leave empty to inherit size from the website theme.', 'basepress'); ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Header Title', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="text" value="<?php echo stripslashes($settings['header_title']); ?>" name="header_title" size="100">
										<p class="description"><?php _e('Default is <b>Knowledge Base</b>.', 'basepress'); ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Force Full Width Header', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="checkbox" value="1" name="full_width_header" <?php checked($settings['full_width_header'], 1); ?>>
										<p class="description">
											<?php _e('This will force the header to stretch over website container and take full window width.<br> Will also set the body overflow-x to hidden.', 'basepress'); ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Header top offset', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="text" value="<?php echo $settings['header_offset']; ?>" name="header_offset">
										<p class="description">
											<?php _e('Insert the top offset value including unit( px, %, em etc.) to properly distance the header from the top of the page.<br>You can use positive and negative values.', 'basepress'); ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Header Background Image', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="text" value="<?php echo $settings['header_image']; ?>" name="header_image" id="header_image" hidden>
										<div id="header-image-preview" class="image-preview" style="background-image:url(<?php echo $header_image[0]; ?>)"></div>
										<p>
											<button id="select-header-image" class="button button-primary"><?php _e('Select image', 'basepress'); ?></button>
											<button id="remove-header-image" class="button button-primary"><?php _e('Remove image', 'basepress'); ?></button>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Make Sidebar Sticky', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="checkbox" value="1" name="sticky_sidebar" <?php checked($settings['sticky_sidebar'], 1); ?>>
										<p class="description">
											<?php _e('If activated the sidebar will remain fixed in the page while scrolling.', 'basepress'); ?>
										</p>
									</td>
								</tr>
								<tr>
									<th class="setting-title"><?php _e('Sticky Sidebar Threshold', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="text" value="<?php echo $settings['sidebar_threshold']; ?>" name="sidebar_threshold">
										<p class="description">
											<?php _e('Distance from top of screen including unit( px, %, em etc.) before sidebar becomes sticky.', 'basepress'); ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Enable Custom Colors', 'basepress'); ?></th>
									<td class="setting-control">
										<input type="checkbox" value="1" name="enable_custom_colors" <?php checked($settings['enable_custom_colors'], 1); ?>>
										<p class="description">
											<?php _e('Enable this to apply the custom colors below.', 'basepress'); ?></p>
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Header Background Color', 'basepress'); ?></th>
									<td class="setting-control">
										<input name="header_color" type="text" value="<?php echo $settings['header_color']; ?>" class="bp-color-field" data-default-color="#34424c" />
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Header Text Color', 'basepress'); ?></th>
									<td class="setting-control">
										<input name="header_text_color" type="text" value="<?php echo $settings['header_text_color']; ?>" class="bp-color-field" data-default-color="#ffffff" />
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Accent Color', 'basepress'); ?></th>
									<td class="setting-control">
										<input name="accent_color" type="text" value="<?php echo $settings['accent_color']; ?>" class="bp-color-field" data-default-color="#17aacf" />
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Buttons Text Color', 'basepress'); ?></th>
									<td class="setting-control">
										<input name="buttons_text_color" type="text" value="<?php echo $settings['buttons_text_color']; ?>" class="bp-color-field" data-default-color="#ffffff" />
									</td>
								</tr>

								<tr>
									<th class="setting-title"><?php _e('Custom Css', 'basepress'); ?></th>
									<td class="setting-control">
										<textarea name="custom_css" rows="10" cols="100"><?php echo $settings['custom_css']; ?></textarea>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
<?php }


	/**
	 *  Saves Theme Settings on db
	 */
	public function basepress_modern_theme_save()
	{
		$settings = array();
		parse_str($_POST['settings'], $settings);
		$sanitized_settings = array();

		if (!empty($settings)) {
			$settings['enable_settings'] = isset($settings['enable_settings']) ? $settings['enable_settings'] : 0;

			foreach ($settings as $name => $value) {
				switch ($name) {
					case 'font_family':
					case 'font_size':
					case 'header_offset':
					case 'header_title':
					case 'sidebar_threshold':
						$sanitized_settings[$name] = sanitize_text_field($value);
						break;
					case 'custom_css':
						$sanitized_settings[$name] = sanitize_textarea_field($value);
					default:
						$sanitized_settings[$name] = $value;
				}
			}

			update_option('basepress_modern_theme', $settings, false);
			_e('Settings saved!', 'basepress');
		} else {
			_e('The settings could not be saved. Try Again.', 'basepress');
		}

		wp_die();
	}
} //End Class

new Basepress_Modern_Theme_Settings();

?>
