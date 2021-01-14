<?php

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class Serial_Numbers_Checkout {

    public $have_updated_serial_numbers = false;

    function __construct() {
        $this->have_updated_serial_numbers = false;
        add_action( 'woocommerce_checkout_create_order_line_item', array( $this,
            'woocommerce_checkout_create_order_line_item' ), 10, 4 );
        add_action( 'woocommerce_new_order_item', array( $this, 'woocommerce_new_order_item' ), 10, 3 );
        add_action( 'woocommerce_order_status_processing', array( $this, 'woocommerce_order_status_processing' ) );
        add_action( 'woocommerce_order_status_completed', array( $this, 'woocommerce_order_status_processing' ) );
    }

    function woocommerce_order_status_processing( $order_id ) {
        $order = new WC_Order( $order_id );
        $order_items = $order->get_items();
        global $serial_numbers_page;
        global $serial_numbers_name;
        foreach ( $order_items as $item_id => $item ) {
            $serial_numbers = wc_get_order_item_meta( $item_id, $serial_numbers_name, true );
            if ( !empty( $serial_numbers ) ) {
                continue;
            }
            $post_id = $item[ 'product_id' ];
            $how_serial_numbers_chosen = $serial_numbers_page->how_serial_numbers_chosen( $post_id );
            if ( $how_serial_numbers_chosen == 'auto_assigned' ) {
                $variation_id = value( $item, 'variation_id' );
                if ( !empty( $variation_id ) ) {
                    $post_id = $variation_id;
                }
                $quantity = apply_filters( 'woocommerce_order_item_quantity', $item[ 'qty' ], $order, $item );
                $available_serial_numbers = $serial_numbers_page->get_available_serial_numbers( $post_id );
                $serial_numbers = array();
                for ( $i = 0;
                            $i < $quantity && count( $available_serial_numbers )
                        > 0; $i++ ) {
                    $serial_numbers[] = array_pop( $available_serial_numbers );
                }
                if ( !empty( $serial_numbers ) ) {
                    $serial_numbers_formatted = $this->format( $serial_numbers );
                    $this->have_updated_serial_numbers = true;
                    wp_mail('ankit@geeksperhour.com','serial_numbers_formatted',print_r($serial_numbers_formatted,true));
                    wp_mail('ankit@geeksperhour.com','serial_numbers_formatted',print_r($item_id,true));
                     wc_add_order_item_meta( $item_id, $serial_numbers_name, $serial_numbers_formatted, true );
                     //added by Ankit to show add pet profile on order success page.
                    $petprofilebutton = "<a href='".get_home_url()."/my-account/pet-profile/?id=".$serial_numbers_formatted."'>Add Pet Profile</a>";
                    $buttonTitle = "<div style='display:none;'>Add Pet Profile</div>";
                    //add order item meta into the database.
                    wc_add_order_item_meta( $item_id, $buttonTitle , $petprofilebutton, true );
                }
            }
        }
    }

    function format( $serial_numbers ) {
        return join( ', ', $serial_numbers );
    }

    function woocommerce_new_order_item( $item_id, $item, $order_id ) {
        if ( empty( $item ) ) {
            return;
        }
        global $serial_numbers_name;
        $advanced_serial_numbers_settings = get_option( '_serial_numbers_advanced_settings', array() );
        $name = value( $advanced_serial_numbers_settings, 'serial_numbers_name', __( 'Serial Number', 'serial-numbers' ) );
        $serial_numbers = explode( ', ', $item->get_meta( $name, true ) );
        if ( !empty( $serial_numbers ) && !empty( $serial_numbers[ 0 ] ) ) {
            $formatted_serial_numbers = $this->format( $serial_numbers );
             wp_mail('ankit@geeksperhour.com','Item',print_r($formatted_serial_numbers,true));
            wc_add_order_item_meta( $item_id, $serial_numbers_name, $formatted_serial_numbers, true );
        }
    }

    /**
     * Adds options to order item meta
     */
    function woocommerce_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
        global $serial_numbers_name;
        if ( !empty( $values[ 'serial_numbers' ] ) ) {
            $serial_numbers = explode( ', ', value( value( $values[ 'serial_numbers' ], 0, array() ), 'value' ) );
            wp_mail('ankit@geeksperhour.com','Itemdfd',print_r($serial_numbers,true));
           $item->add_meta_data( $serial_numbers_name, $this->format( $serial_numbers ), true );
        }
       
    }

}

$serial_numbers_checkout = new Serial_Numbers_Checkout();
?>