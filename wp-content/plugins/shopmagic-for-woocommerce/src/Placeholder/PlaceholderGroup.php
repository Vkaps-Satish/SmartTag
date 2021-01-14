<?php

namespace WPDesk\ShopMagic\Placeholder;

use WPDesk\ShopMagic\DataSharing\DataAccess\NewUserAccount;

final class PlaceholderGroup {
	const ORDER = 'order';
	const USER = 'customer';
	const SHOP = 'shop';

	/**
	 * @param string $class
	 *
	 * @return string
	 */
	public static function class_to_group( $class ) {
		if ( is_a( $class, \WC_Abstract_Order::class, true ) ) {
			return self::ORDER;
		}
		if ( is_a( $class, \WP_User::class, true ) ) {
			return self::USER;
		}
		if ( is_a( $class, NewUserAccount::class, true ) ) {
			return self::USER;
		}

		return self::SHOP;
	}
}
