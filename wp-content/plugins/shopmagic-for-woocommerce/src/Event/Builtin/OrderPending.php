<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderPending extends OrderCommonEvent {
	public static function get_name() {
		return __( 'Order Pending', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when order is pending', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_order_status_pending', array( $this, 'event_change_status_fired' ), 10, 2 );
	}

}
