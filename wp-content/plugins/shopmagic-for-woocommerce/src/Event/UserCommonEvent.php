<?php

namespace WPDesk\ShopMagic\Event;

abstract class UserCommonEvent extends BasicEvent {
	public static function get_group_slug() {
		return EventFactory::GROUP_USERS;
	}

}
