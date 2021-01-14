<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\OrderCommonEvent;

final class OrderNew extends OrderCommonEvent {
	const PRIORITY_AFTER_DEFAULT = 100;

	public static function get_name() {
		return __( 'New Order', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when a new order is created', 'shopmagic-for-woocommerce' );
	}

	public function initialize() {
		add_action( 'woocommerce_new_order', array( $this, 'event_change_status_fired' ), self::PRIORITY_AFTER_DEFAULT, 2 );
	}

}
