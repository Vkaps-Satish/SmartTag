<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin;

use WPDesk\ShopMagic\Placeholder\BasicPlaceholder;

abstract class UserBasedPlaceholder extends BasicPlaceholder {
	public static function get_required_object_type() {
		return \WP_User::class;
	}
}
