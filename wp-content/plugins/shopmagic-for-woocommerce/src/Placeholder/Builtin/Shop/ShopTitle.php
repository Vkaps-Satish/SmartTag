<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Shop;

use WPDesk\ShopMagic\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;


final class ShopTitle extends WooCommerceOrderBasedPlaceholder {

	public static function get_slug() {
		return parent::get_slug() . '.title';
	}

	public static function get_required_object_type() {
		return \stdClass::class;
	}

	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $shopData, array $parameters ) {
		return ''; // DISABLED FOR NOW
	}
}
