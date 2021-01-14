<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       geeksperhour.com
 * @since      1.0.0
 *
 * @package    Twillo_api_int
 * @subpackage Twillo_api_int/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Twillo_api_int
 * @subpackage Twillo_api_int/public
 * @author     geeksperhour <gaurav@vkaps.com>
 */

require_once($_SERVER['DOCUMENT_ROOT'].'wp-content/plugins/twillo_api_int/lib/twilio-php-master/src/Twilio/autoload.php');

use Twilio\Rest\Client;

class Twillo_api_int_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Twillo_api_int_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Twillo_api_int_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/twillo_api_int-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Twillo_api_int_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Twillo_api_int_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/twillo_api_int-public.js', array( 'jquery' ), $this->version, false );

	}

	public function send_message_using_parameter($to, $message, $sender_id = 0){

		//gets our api details from the database.
		$api_details = get_option($this->plugin_name); #sendex is what we use to identify our option, it can be anything
		

        if(is_array($api_details) && count($api_details) != 0) {
            $TWILIO_SID = $api_details['api_sid'];
            $TWILIO_TOKEN = $api_details['api_auth_token'];
        }

        if (empty($sender_id) && is_array($api_details) && count($api_details) != 0) {
        	$sender_id = $api_details['sender_id'];
        }

        try{
        	$to = explode(',', $to);
        	$client = new Client($TWILIO_SID, $TWILIO_TOKEN);
        	$response = $client->messages->create(
                $to ,
                array(
                  'from' => $sender_id,
                 'body' => $message
                )
            );
            return array("success" => 1, "msg" => "Successful!");
        } catch (Exception $e) {
        	return array("success" => 0, "msg" => $e->getMessage());
        } 
	}

}
