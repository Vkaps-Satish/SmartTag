<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Customer;

use WPDesk\ShopMagic\Placeholder\Builtin\UserBasedPlaceholder;

final class CustomerEmail extends UserBasedPlaceholder {
	public static function get_slug() {
		return parent::get_slug() . '.email';
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
			$fallback = $order->get_billing_email();
		} else {
			$fallback = '';
		}

		return ! empty( $user->user->user_email ) ? $user->user->user_email : $fallback;
	}
}
