<?php

namespace WPDesk\ShopMagic\DataSharing;

/**
 *
 * @package WPDesk\ShopMagic\DataSharing
 */
interface DataProvider {
	/**
	 * List of classes that an provider can provide.
	 *
	 * @return string[]
	 */
	public static function get_provided_data_domains();

	/**
	 * Object instances promised in get_provided_data_domains.
	 *
	 * object[]
	 */
	public function get_provided_data();
}
