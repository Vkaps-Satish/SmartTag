<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderCancelled extends OrderCommonEvent {
	public static function get_name() {
		return __( 'Order Cancelled', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when order status is set to cancelled', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_order_status_cancelled', array( $this, 'event_change_status_fired' ), 10, 2 );
	}

}
