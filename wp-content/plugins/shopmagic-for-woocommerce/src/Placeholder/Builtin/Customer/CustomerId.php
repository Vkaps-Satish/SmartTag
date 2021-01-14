<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Customer;

use WPDesk\ShopMagic\Placeholder\Builtin\UserBasedPlaceholder;

final class CustomerId extends UserBasedPlaceholder {
	public static function get_slug() {
		return parent::get_slug() . '.id';
	}

	/**
	 * @param \WP_User $user
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $user, array $parameters ) {
		return ! empty( $user->ID ) ? $user->ID : '';
	}
}
