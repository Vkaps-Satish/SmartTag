<?php
if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
if ( !class_exists('Wwp_Wholesale_Pricing_Frontend') ) {

	class Wwp_Wholesale_Pricing_Frontend {

		public function __construct() {
			add_action('wp_enqueue_scripts', array($this, 'wwp_script_style'));
		}
		public function wwp_script_style() {
			wp_enqueue_script( 'wwp-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array(), '1.0.0', true );
		}
	}
	new Wwp_Wholesale_Pricing_Frontend();
}
