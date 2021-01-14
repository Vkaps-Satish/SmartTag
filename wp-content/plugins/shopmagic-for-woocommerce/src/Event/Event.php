<?php

namespace WPDesk\ShopMagic\Event;

use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\DataSharing\DataProvider;
use WPDesk\ShopMagic\Filter\FilterLogic;

/**
 * When event knows it fires it should check if there are no filters that blocks it.
 * If no filter blocked the Event then it notifies the Automation object about it.
 * Automation decides what to do with it next.
 *
 * @package WPDesk\ShopMagic\Event
 */
interface Event extends DataProvider {
	public static function get_name();

	public static function get_group_slug();

	public static function get_description();

	public function initialize();

	public function set_filter_logic( FilterLogic $filter );

	public function set_automation( Automation $automation );
}
