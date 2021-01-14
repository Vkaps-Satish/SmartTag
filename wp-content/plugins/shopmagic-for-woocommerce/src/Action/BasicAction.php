<?php

namespace WPDesk\ShopMagic\Action;

use WPDesk\ShopMagic\Placeholder\PlaceholderProcessor;

abstract class BasicAction implements Action {
	/**
	 * @var array current action settings
	 */
	protected $data;

	protected $provided_data;

	/** @var PlaceholderProcessor */
	protected $placeholder_processor;

	function __construct( array $data ) {
		$this->data = $data;
	}

	public function set_placeholder_processor( PlaceholderProcessor $processor ) {
		$this->placeholder_processor = $processor;
	}

	public function set_provided_data( array $provided_data ) {
		$this->provided_data = $provided_data;
	}

}
