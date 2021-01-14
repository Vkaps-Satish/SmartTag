<?php

namespace WPDesk\ShopMagic\Filter;

use WPDesk\ShopMagic\DataSharing\DataProvider;

/**
 * Filter are connected in ChainOfResponsibility pattern.
 *
 * @package WPDesk\ShopMagic\Filters
 */
interface FilterLogic {

	/**
	 *
	 * @return bool
	 */
	public function passed( DataProvider $event );
}
