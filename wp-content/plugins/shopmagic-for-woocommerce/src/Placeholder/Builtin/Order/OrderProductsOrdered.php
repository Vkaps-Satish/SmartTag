<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;

final class OrderProductsOrdered extends WooCommerceOrderBasedPlaceholder {
	public static function get_slug() {
		return parent::get_slug() . '.products_ordered';
	}

	/**
	 * @param \WC_Order $order
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $order, array $parameters ) {
		$result = '<ul>';

		foreach ( $order->get_items() as $id => $val ) {
			$result .= '<li>' . $val['name'] . ' ' . ( print_r( $val ) ) . '</li>';
		}

		$result .= '</ul>';

		return $result;
	}
}
