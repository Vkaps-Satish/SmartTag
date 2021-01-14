<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Traits;

/**
 * Provides functions to format country to WP i18n.
 *
 * @package WPDesk\ShopMagic\Placeholder\Builtin\Traits
 */
trait CountryFormatHelper {
	/**
	 * @param string $shortcut ie. PL
	 *
	 * @return string ie. Poland
	 */
	private function country_full_name( $shortcut ) {
		$countries = WC()->countries->get_countries();
		if ( isset( $countries[ $shortcut ] ) ) {
			return $countries[ $shortcut ];
		}

		return $shortcut;
	}
}
