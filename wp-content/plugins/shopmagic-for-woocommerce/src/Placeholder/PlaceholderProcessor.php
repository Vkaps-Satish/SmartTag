<?php

namespace WPDesk\ShopMagic\Placeholder;

use WPDesk\ShopMagic\DataSharing\DataProvider;

class PlaceholderProcessor {
	const PARAM_SEPARATOR = ',';
	const PARAM_VALUE_SEPARATOR = ':';
	const PARAM_VALUE_WRAP = "'";
	const PARAMS_SEPARATOR = '|';

	/** @var PlaceholderFactory */
	private $placeholder_factory;

	/** @var DataProvider */
	private $provider;

	/**
	 * @param PlaceholderFactory $placeholder_factory
	 */
	public function __construct( PlaceholderFactory $placeholder_factory, DataProvider $provider_for_placeholder ) {
		$this->placeholder_factory = $placeholder_factory;
		$this->provider            = $provider_for_placeholder;
	}

	/**
	 * @param string $params_string
	 *
	 * @return array
	 */
	private function extract_parameters( $params_string ) {
		$params = array_map( function ( $param_string ) {
			list( $param_name, $param_value ) = @explode( self::PARAM_VALUE_SEPARATOR, trim( $param_string ) );

			return [ trim( $param_name ), trim( trim( $param_value ), self::PARAM_VALUE_WRAP ) ];
		}, explode( self::PARAM_SEPARATOR, $params_string ) );

		return array_combine( array_column( $params, 0 ), array_column( $params, 1 ) );
	}

	/**
	 * @param string $string
	 *
	 * @return string|string[]|null
	 */
	public function process( $string ) {
		$replacement_count = 0;
		do {
			$string = preg_replace_callback( '/{{[ ]*([^}]+)[ ]*}}/', function ( $full_placeholder ) {
				list( $placeholder_slug, $params_string ) = array_map( 'trim',
					@explode( self::PARAMS_SEPARATOR, $full_placeholder[1] )
				);

				$params = $this->extract_parameters( $params_string );

				if ( $this->placeholder_factory->is_placeholder_available( $this->provider, $placeholder_slug ) ) {
					$placeholder   = $this->placeholder_factory->create_placeholder(
						$this->provider,
						$placeholder_slug
					);
					$provided_data = $this->provider->get_provided_data();
					$required_object = $provided_data[ $placeholder::get_required_object_type() ];

					return $placeholder->value( $required_object, $params );
				}

				return '';
			}, $string, 1, $replacement_count );
		} while ( $replacement_count > 0 );

		return $string;
	}
}
