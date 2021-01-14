<?php
/*
 * Plugin Name: WooCommerce Payyo Payment Gateway
 * Description: Take credit card payments on your store.
 * Author: VKAPS Team
 * Author URI: http://vkaps.com
 * Version: 1.0.1
 *

 /*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'payyo_add_gateway_class' );
function payyo_add_gateway_class( $gateways ) {
  $gateways[] = 'WC_Payyo_Gateway'; // your class name is here
  return $gateways;
}
 
/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'payyo_init_gateway_class' );
function payyo_init_gateway_class() {
 
  class WC_Payyo_Gateway extends WC_Payment_Gateway {
 
    /**
     * Class constructor, more about it in Step 3
     */
    public function __construct() {
        $this->id = 'payyo'; // payment gateway plugin ID
        $this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
        $this->has_fields = true; // in case you need a custom credit card form
        $this->method_title = 'Payyo Gateway';
        $this->method_description = 'Description of Payyo payment gateway'; // will be displayed on the options page
     
        // gateways can support subscriptions, refunds, saved payment methods,
        // but in this tutorial we begin with simple payments
        $this->supports = array(
            'products'
        );
     
        // Method with all the options fields
        $this->init_form_fields();
     
        // Load the settings.
        $this->init_settings();
        $this->title = $this->get_option( 'title' );
        $this->description = $this->get_option( 'description' );
        $this->enabled = $this->get_option( 'enabled' );
        $this->merchant_id = $this->get_option( 'merchant_id' );
        $this->testmode = 'yes' === $this->get_option( 'testmode' );
        $this->private_key = $this->testmode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
        $this->publishable_key = $this->testmode ? $this->get_option( 'test_publishable_key' ) : $this->get_option( 'publishable_key' );
     
        // This action hook saves the settings
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
     
        // We need custom JavaScript to obtain a token
        add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );
     
        // You can also register a webhook here
        add_action( 'woocommerce_api_payyo-success', array( $this, 'success' ) );
        add_action( 'woocommerce_api_payyo-failed', array( $this, 'failed' ) );
     }
 
    /**
     * Plugin options, we deal with it in Step 3 too
     */
    public function init_form_fields(){
 
        $this->form_fields = array(
            'enabled' => array(
                'title'       => 'Enable/Disable',
                'label'       => 'Enable Payyo Gateway',
                'type'        => 'checkbox',
                'description' => '',
                'default'     => 'no'
            ),
            'title' => array(
                'title'       => 'Title',
                'type'        => 'text',
                'description' => 'This controls the title which the user sees during checkout.',
                'default'     => 'Credit Card',
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => 'Description',
                'type'        => 'textarea',
                'description' => 'This controls the description which the user sees during checkout.',
                'default'     => 'Pay with your credit card via our super-cool payment gateway.',
            ),
            'testmode' => array(
                'title'       => 'Test mode',
                'label'       => 'Enable Test Mode',
                'type'        => 'checkbox',
                'description' => 'Place the payment gateway in test mode using test API keys.',
                'default'     => 'yes',
                'desc_tip'    => true,
            ),
            'merchant_id' => array(
                'title'       => 'Merchant ID',
                'type'        => 'text'
            ),
            'test_publishable_key' => array(
                'title'       => 'Test Publishable Key',
                'type'        => 'text'
            ),
            'test_private_key' => array(
                'title'       => 'Test Private Key',
                'type'        => 'password',
            ),
            'publishable_key' => array(
                'title'       => 'Live Publishable Key',
                'type'        => 'text'
            ),
            'private_key' => array(
                'title'       => 'Live Private Key',
                'type'        => 'password'
            )
        );
    }
 
    /**
     * You will need it if you want your custom credit card form, Step 4 is about it
     */
    public function payment_fields() {
        // ok, let's display some description before the payment form
        if ( $this->description ) {
            // you can instructions for test mode, I mean test card numbers etc.
            if ( $this->testmode ) {
                $this->description .= ' TEST MODE ENABLED. In test mode, you can use the card numbers listed in <a href="#" target="_blank" rel="noopener noreferrer">documentation</a>.';
                $this->description  = trim( $this->description );
            }
            // display the description with <p> tags etc.
            echo wpautop( wp_kses_post( $this->description ) );
        }
     
        // I will echo() the form, but you can close PHP tags and print it directly in HTML
        echo '<fieldset id="wc-' . esc_attr( $this->id ) . '-cc-form" class="wc-credit-card-form wc-payment-form" style="background:transparent;">';
     
        // Add this action hook if you want your custom payment gateway to support it
        echo '<div class="clear"></div></fieldset>';
    }
 
    /*
     * Custom CSS and JS, in most cases required only when you decided to go with a custom credit card form
     */
    public function payment_scripts() {
        // we need JavaScript to process a token only on cart/checkout pages, right?
        if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) ) {
            return;
        }
     
        // if our payment gateway is disabled, we do not have to enqueue JS too
        if ( 'no' === $this->enabled ) {
            return;
        }
     
        // no reason to enqueue JavaScript if API keys are not set
        if ( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
            return;
        }
     
        // do not work with card detailes without SSL unless your website is in a test mode
        if ( ! $this->testmode && ! is_ssl() ) {
            return;
        }
    }
 
    /*
     * Fields validation, more in Step 5
     */
    public function validate_fields(){
 
        if( empty( $_POST[ 'billing_first_name' ]) ) {
            wc_add_notice(  'First name is required!', 'error' );
            return false;
        }
        return true;
     
    }
 
    /*
     * We're processing the payments here, everything about it is in Step 5
     */
    public function process_payment( $order_id ) {
 
        global $woocommerce;
     
        // we need it to get any order detailes
        $order     = wc_get_order( $order_id );
        $orderId   = $order->get_order_number();
        $cancelUrl = $order->get_cancel_order_url_raw();
        $amount    = $order->get_total();
        $amount    = str_replace(".", "", $amount);
        $return    = home_url("/wc-api/payyo-success?order_id=".$orderId);
        // die(get_woocommerce_currency());
        if($this->testmode){
            $api = "https://api.sandbox.trekkpay.io/v2";
        }else{
            $api = "https://api.trekkpay.io/v2";
        }

        $request = '{
          "jsonrpc": "2.0",
          "method": "paymentPage.initialize",
          "params": {
            "merchant_id": '.$this->merchant_id.',
            "merchant_reference": "'.$orderId.'",
            "expiration_time": 3600,
            "is_reusable": false,
            "description": "'.get_bloginfo( 'name' ).'",
            "currency": "'.get_woocommerce_currency().'",
            "amount": '.$amount.',
            "billing_descriptor": "'.strtoupper(get_bloginfo( 'name' )).'",
            "styling": {
              "favicon_url": "https://assets.payyo.ch/favicon/favicon-32x32.png",
              "accent_color": "rgba(255,0,0,1.0)",
              "background_color": "rgba(230,230,230,1.0)"
            },
            "return_urls": {
                "success": "'.$return.'",
                "error": "'.$cancelUrl.'",
                "abort": "'.$cancelUrl.'"
            },
            "language": "en"
          },
          "id": 1
        }';

        $requestEncode = $this->base64url_encode($request);
        $encodeData = hash_hmac('sha256', $requestEncode, $this->private_key);
        $auth = base64_encode($this->publishable_key.":".$encodeData);

        $arg = array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
                'cache-control' => 'no-cache',
                'authorization' => 'Basic '.$auth
            ),
            'body'    => $request,
            'method'  => 'POST',
        );
     
        /*
         * Your API interaction could be built with wp_remote_post()
         */
        $response = wp_remote_post( $api, $arg );

        if( !is_wp_error( $response ) ) {
     
             $body = json_decode( $response['body'], true );
             // it could be different depending on your payment processor
             if ( isset($body['result']) && isset($body['result']['checkout_url']) ) {
     
                // we received the payment
                /*$order->payment_complete();
                $order->reduce_order_stock();
     
                // some notes to customer (replace true with false to make it private)
                $order->add_order_note( 'Hey, your order is paid! Thank you!', true );
     
                // Empty cart
                $woocommerce->cart->empty_cart();*/
     
                // Redirect to the thank you page
                return array(
                    'result' => 'success',
                    'redirect' => $body['result']['checkout_url']
                );
     
             } else {
                wc_add_notice(  'Please try again.', 'error' );
                return;
            }
     
        } else {
            wc_add_notice(  'Connection error.', 'error' );
            return;
        }
     
    }

    public function base64url_encode($data){
        // First of all you should encode $data to Base64 string
        $b64 = base64_encode($data);

        // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
        if ($b64 === false) {
            return false;
        }

        // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
        $url = strtr($b64, '+/', '-_');

        // Remove padding character from the end of line and return the Base64URL result
        return rtrim($url, '=');
    }

    public function success() {
        global $woocommerce;

        $orderId = $_REQUEST['order_id'];
        $transId = $_REQUEST['transaction_id'];
        $order   = wc_get_order( $orderId );

        $order->payment_complete();
        $order->reduce_order_stock();

        // some notes to customer (replace true with false to make it private)
        $order->add_order_note( 'Hey, your order is paid! Thank you!', true );

        // Empty cart
        $woocommerce->cart->empty_cart();

        update_post_meta( $orderId, 'transaction', $transId );
        wp_redirect($this->get_return_url( $order ));
    }

    public function failed() {
        print_r($_REQUEST);
        die("mm");
    }
  }
}