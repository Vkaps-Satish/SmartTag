<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderCompleted extends OrderCommonEvent {
	public static function get_name() {
		return __( 'Order Completed', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when order status is set to completed', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_order_status_completed', array( $this, 'event_change_status_fired' ), 10, 2 );
	}

}
