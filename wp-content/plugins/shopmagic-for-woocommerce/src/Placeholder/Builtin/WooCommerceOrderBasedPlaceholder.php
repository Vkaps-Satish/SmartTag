<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin;

use WPDesk\ShopMagic\Placeholder\BasicPlaceholder;

abstract class WooCommerceOrderBasedPlaceholder extends BasicPlaceholder {
	protected static function is_user_guest( \WC_Order $order ) {
		return $order->get_customer_id();
	}

	public static function should_support_legacy_slug() {
		return false;
	}

	public static function get_required_object_type() {
		return \WC_Order::class;
	}
}
