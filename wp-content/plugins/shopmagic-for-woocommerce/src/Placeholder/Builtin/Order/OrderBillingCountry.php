<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Placeholder\Builtin\Traits\CountryFormatHelper;
use WPDesk\ShopMagic\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;

final class OrderBillingCountry extends WooCommerceOrderBasedPlaceholder {
	use CountryFormatHelper;

	public static function get_slug() {
		return parent::get_slug() . '.billing_country';
	}

	/**
	 * @param \WC_Order $order
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $order, array $parameters ) {
		return $this->country_full_name( $order->get_billing_country() );
	}
}
