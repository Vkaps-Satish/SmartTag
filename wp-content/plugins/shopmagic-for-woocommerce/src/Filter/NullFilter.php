<?php

namespace WPDesk\ShopMagic\Filter;

use WPDesk\ShopMagic\DataSharing\DataProvider;

/**
 * Filter lets everything go.
 *
 * @package WPDesk\ShopMagic\Filters
 */
final class NullFilter extends BasicFilter {
	/**
	 * @param $event
	 *
	 * @return bool
	 */
	public function passed( DataProvider $event ) {
		return true;
	}

	public static function get_name() {
		return 'null';
	}

	public static function get_required_data_domains() {
		return [];
	}
}
