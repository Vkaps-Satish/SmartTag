<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       geeksperhour.com
 * @since      1.0.0
 *
 * @package    Twillo_api_int
 * @subpackage Twillo_api_int/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Twillo_api_int
 * @subpackage Twillo_api_int/includes
 * @author     geeksperhour <gaurav@vkaps.com>
 */
class Twillo_api_int_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'twillo_api_int',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
