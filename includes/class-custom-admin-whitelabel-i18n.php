<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://devnel.com
 * @since      1.0.0
 *
 * @package    Custom_Admin_Whitelabel
 * @subpackage Custom_Admin_Whitelabel/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Admin_Whitelabel
 * @subpackage Custom_Admin_Whitelabel/includes
 * @author     Kyle Nel <kyle@devnel.com>
 */
class Custom_Admin_Whitelabel_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-admin-whitelabel',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
