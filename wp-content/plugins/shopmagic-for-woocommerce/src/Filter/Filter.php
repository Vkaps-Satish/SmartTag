<?php

namespace WPDesk\ShopMagic\Filter;

use WPDesk\ShopMagic\DataSharing\DataReceiver;
use WPDesk\ShopMagic\Event\Event;

/**
 * Filter are connected in ChainOfResponsibility pattern.
 *
 * @package WPDesk\ShopMagic\Filters
 */
interface Filter extends DataReceiver, FilterLogic {
	public static function get_name();
}
