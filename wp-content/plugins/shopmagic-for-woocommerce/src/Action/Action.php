<?php

namespace WPDesk\ShopMagic\Action;

use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\DataSharing\DataReceiver;
use WPDesk\ShopMagic\Event\Event;
use WPDesk\ShopMagic\Placeholder\PlaceholderProcessor;

interface Action extends DataReceiver {

	public static function get_name();

	public function set_placeholder_processor(PlaceholderProcessor $processor);

	public function execute(Automation $automation, Event $event);
}
