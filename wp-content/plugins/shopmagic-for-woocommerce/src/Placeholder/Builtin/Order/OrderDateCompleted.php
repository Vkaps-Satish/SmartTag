<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Placeholder\Builtin\Traits\DateFormatHelper;
use WPDesk\ShopMagic\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;


final class OrderDateCompleted extends WooCommerceOrderBasedPlaceholder {
	use DateFormatHelper;

	public static function get_slug() {
		return parent::get_slug() . '.date_completed';
	}

	/**
	 * @param \WC_Order $order
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $order, array $parameters ) {
		return $this->format_date( $order->get_date_completed() );
	}
}
