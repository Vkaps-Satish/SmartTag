<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderFailed extends OrderCommonEvent {
	public static function get_name() {
		return __( 'Order Failed', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when an order fails', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_order_status_failed', array( $this, 'event_change_status_fired' ), 10, 2 );
	}

}
