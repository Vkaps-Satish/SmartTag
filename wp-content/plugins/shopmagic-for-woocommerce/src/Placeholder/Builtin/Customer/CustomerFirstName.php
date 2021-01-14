<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Customer;

use WPDesk\ShopMagic\Placeholder\Builtin\UserBasedPlaceholder;

final class CustomerFirstName extends UserBasedPlaceholder {

	public static function get_slug() {
		return parent::get_slug() . '.first_name';
	}

	/**
	 * @param \WP_User $user
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $user, array $parameters ) {
		$order = $this->provided_data[ \WC_Order::class ];
		if ( $order instanceof \WC_Order ) {
			$fallback = $order->get_billing_first_name();
		} else {
			$fallback = '';
		}

		return ( ! empty( $user->first_name ) ? $user->first_name : $fallback );
	}
}
