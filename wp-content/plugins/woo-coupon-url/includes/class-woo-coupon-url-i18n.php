<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://personaldiscount.io
 * @since      1.0.0
 *
 * @package    Woo_Coupon_Url
 * @subpackage Woo_Coupon_Url/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Coupon_Url
 * @subpackage Woo_Coupon_Url/includes
 * @author     PersonalDiscount <conact@personaldicount.io>
 */
class Woo_Coupon_Url_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-coupon-url',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
