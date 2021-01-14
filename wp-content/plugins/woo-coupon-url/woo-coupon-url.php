<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://personaldiscount.io
 * @since             1.0.0
 * @package           Woo_Coupon_Url
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Coupon URL
 * Plugin URI:        https://personaldiscount.io/woo-coupon-url
 * Description:       Attach a coupon code to yout URL and apply it automatically to the cart.
 * Version:           1.0.0
 * Author:            PersonalDiscount
 * Author URI:        https://personaldiscount.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-coupon-url
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_COUPON_URL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-coupon-url-activator.php
 */
function activate_woo_coupon_url() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-coupon-url-activator.php';
	Woo_Coupon_Url_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-coupon-url-deactivator.php
 */
function deactivate_woo_coupon_url() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-coupon-url-deactivator.php';
	Woo_Coupon_Url_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_coupon_url' );
register_deactivation_hook( __FILE__, 'deactivate_woo_coupon_url' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-coupon-url.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_coupon_url() {

	$plugin = new Woo_Coupon_Url();
	$plugin->run();

}
run_woo_coupon_url();
