<?php
/**
 * View Subscription
 *
 * Shows the details of a particular subscription on the account page
 *
 * @author  Prospress
 * @package WooCommerce_Subscription/Templates
 * @version 2.5.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

/**
 * Gets subscription details table template
 * @param WC_Subscription $subscription A subscription object
 * @since 2.2.19
 */

//ocean-woocommerce_subscription_details_table
do_action( 'woocommerce_subscription_details_table', $subscription );

/**
 * Gets subscription totals table template
 * @param WC_Subscription $subscription A subscription object
 * @since 2.2.19
 */
// print_r($subscription);
//ocean-woocommerce_subscription_totals_table
do_action( 'woocommerce_subscription_totals_table', $subscription );

//do_action( 'woocommerce_subscription_details_after_subscription_table', $subscription );

//wc_get_template( 'order/order-details-customer.php', array( 'order' => $subscription ) );
wc_get_template( 'order/order-detail.php', array( 'order' => $subscription ) );
?>

<div class="clear 111"></div>
