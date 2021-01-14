<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Customer;

use WPDesk\ShopMagic\DataSharing\DataAccess\NewUserAccount;
use WPDesk\ShopMagic\Placeholder\Builtin\UserBasedPlaceholder;


final class CustomerNewPassword extends UserBasedPlaceholder {

	public static function get_slug() {
		return parent::get_slug() . '.new_password';
	}

	public static function get_required_object_type() {
		return NewUserAccount::class;
	}

	/**
	 * @param NewUserAccount $password
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function value( $password, array $parameters ) {
		return $password->get_password();
	}
}
