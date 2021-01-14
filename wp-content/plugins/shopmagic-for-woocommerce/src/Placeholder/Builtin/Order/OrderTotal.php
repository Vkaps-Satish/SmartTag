<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;


final class OrderTotal extends WooCommerceOrderBasedPlaceholder {


	public static function get_slug() {
		return parent::get_slug() . '.total';
	}

	/**
	 * @param \WC_Order $order
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $order, array $parameters ) {
		return wc_price( $order->get_total() );
	}
}
