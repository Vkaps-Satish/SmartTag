<?php

namespace WPDesk\ShopMagic\Placeholder;

abstract class BasicPlaceholder implements Placeholder {
	protected $provided_data;

	public static function get_slug() {
		return PlaceholderGroup::class_to_group( static::get_required_object_type() );
	}

	public function set_provided_data( array $data ) {
		$this->provided_data = $data;
	}

	public static function get_supported_parameters() {
		return [];
	}

	public static function get_description() {
		return __( 'No description provided for this placeholder.', 'shopmagic' );
	}

	/**
	 * DataSharing layer compatibility. Thanks to this we can use Placeholder as standard DataReceiver
	 *
	 * @return string[]
	 */
	public static function get_required_data_domains() {
		return [ static::get_required_object_type() ];
	}
}
