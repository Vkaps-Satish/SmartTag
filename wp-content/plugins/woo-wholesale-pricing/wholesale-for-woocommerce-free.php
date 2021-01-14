<?php
/**
 * Plugin Name: Wholesale For WooCommerce Lite
 * Plugin URI: https://wpexperts.io/
 * Description: A WooCommerce extention that gives an ability to your store to better success with wholesale pricing. You can easily manage your existing store with wholesale pricing. Just you need to add a wholesaler customer by selecting his role "Wholesaler", wholesale pricing is not view for public users only wholesaler customer can see them.
 * Version: 1.5
 * Author: wpexpertsio
 * Author URI: https://wpexperts.io/
 * Developer: wpexpertsio
 * Developer URI: https://wpexperts.io/
 * Text Domain: woocommerce-wholesale-pricing
 * 
 * WC requires at least: 3.0
 * WC tested up to: 3.7
 * 
 * Copyright: © 2009-2015 WooCommerce.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
if (!defined('ABSPATH')) {
	exit();
}
if (!defined('WWP_PLUGIN_URL')) {
	define('WWP_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('WWP_PLUGIN_PATH')) {
	define('WWP_PLUGIN_PATH', plugin_dir_path(__FILE__));
}
if (!defined('WWP_PLUGIN_DIRECTORY_NAME')) {
	define('WWP_PLUGIN_DIRECTORY_NAME', dirname(__FILE__));
}
if (!class_exists('Wwp_Wholesale_Pricing')) {

	class Wwp_Wholesale_Pricing {

		public function __construct() {
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
				self::init();
			} else {
				add_action('admin_notices', array(__Class__, 'wholesale_admin_notice_error'));
			}
		}
		public static function init() {
			if (function_exists('load_plugin_textdomain')) {
				load_plugin_textdomain('woocommerce-wholesale-pricing', false, dirname(plugin_basename(__FILE__)) . '/languages/');
			}
			if (is_admin()) {
			    require_once WWP_PLUGIN_PATH.'/inc/class-wwp-wholesale-user-roles.php';
				include_once WWP_PLUGIN_PATH . 'inc/class-wwp-wholesale-backend.php';
				
			} else {
				include_once WWP_PLUGIN_PATH . '/inc/class-wwp-wholesale-frontend.php';
				add_action('init', array(__Class__, 'include_wholesale_functionality'));
			}
		}
		public static function include_wholesale_functionality() {
			if (is_user_logged_in()) {
				$user_info = get_userdata(get_current_user_id());
				$user_role = (array) $user_info->roles;
				if ( !empty($user_role) && in_array('wwp_wholesaler', $user_role) ) {
				    include_once WWP_PLUGIN_PATH . 'inc/class-wwp-wholesale.php';
					include_once WWP_PLUGIN_PATH . 'inc/class-wwp-wholesale-functions.php';
				}
			}
		}
		public static function wholesale_admin_notice_error() {
			$class = 'notice notice-error';
			$message = esc_html__('The plugin Wholesale For WooCommerce requires Woocommerce to be installed and activated, in order to work', 'woocommerce-wholesale-pricing');
			printf('<div class="%1$s"><p>%2$s</p></div>', esc_html($class), esc_html($message)); 
		}
	}   
	new Wwp_Wholesale_Pricing();
}
