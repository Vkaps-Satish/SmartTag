<?php

namespace WPDesk\ShopMagic\Filter;

abstract class BasicFilter implements Filter {
	protected $provided_data;

	public function set_provided_data( array $data ) {
		$this->provided_data = $data;
	}
}
