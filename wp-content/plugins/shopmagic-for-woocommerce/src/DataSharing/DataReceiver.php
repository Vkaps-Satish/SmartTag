<?php

namespace WPDesk\ShopMagic\DataSharing;

interface DataReceiver {
	/** @return string[] */
	public static function get_required_data_domains();

	public function set_provided_data(array $data);
}
