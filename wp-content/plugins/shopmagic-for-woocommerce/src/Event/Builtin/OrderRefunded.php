<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderRefunded extends OrderCommonEvent {
	public static function get_name() {
		return __( 'Order Refunded', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when the order has been refunded', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_order_status_refunded', array( $this, 'event_change_status_fired' ), 10, 2 );
	}

}
