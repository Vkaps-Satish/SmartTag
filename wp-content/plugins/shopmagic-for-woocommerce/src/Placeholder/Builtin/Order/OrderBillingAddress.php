<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;


final class OrderBillingAddress extends WooCommerceOrderBasedPlaceholder {
	public static function get_slug() {
		return parent::get_slug() . '.billing_address';
	}

	/**
	 * @param \WC_Order $order
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $order, array $parameters ) {
		return $order->get_billing_address_1();
	}
}
