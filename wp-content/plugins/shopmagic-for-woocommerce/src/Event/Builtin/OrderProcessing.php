<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderProcessing extends OrderCommonEvent {
	public static function get_name() {
		return __( 'Order Processing', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when order status is processing', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_order_status_processing', array( $this, 'event_change_status_fired' ), 10, 2 );
	}

}
