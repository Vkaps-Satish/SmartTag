<?php

/**
 * Field type settings.
 */
class Flexible_Checkout_Fields_Field_Type {

	const FIELD_TYPE_TEXT     = 'text';
	const FIELD_TYPE_TEXTAREA = 'textarea';

	/**
	 * Field type data.
	 *
	 * @var array
	 */
	private $field_type_data;

	public function __construct( array $field_type_data ) {
		$this->field_type_data = $field_type_data;
	}

	/**
	 * .
	 *
	 * @return bool
	 */
	public function has_options() {
		return isset( $this->field_type_data['has_options'] ) && $this->field_type_data['has_options'];
	}

	/**
	 * .
	 *
	 * @return bool
	 */
	public function has_default_value() {
		return isset( $this->field_type_data['has_default_value'] ) && $this->field_type_data['has_default_value'];
	}

}
