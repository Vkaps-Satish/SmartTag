<?php

namespace WPDesk\ShopMagic\Placeholder;

use WPDesk\ShopMagic\DataSharing\DataProvider;
use WPDesk\ShopMagic\DataSharing\DataReceiver;
use WPDesk\ShopMagic\DataSharing\ProviderReceiverMatcher;
use WPDesk\ShopMagic\Placeholder\Builtin\Order;
use WPDesk\ShopMagic\Placeholder\Builtin\Customer;

class PlaceholderFactory {
	/**
	 * @param Placeholder[]|string[] $hashmap
	 *
	 * @return Placeholder[]|string[]
	 */
	private function append_legacy_placeholders( $hashmap ) {
		$legacy = [
			'customer_id'         => Customer\CustomerId::class,
			'customer_name'       => Customer\CustomerName::class,
			'customer_first_name' => Customer\CustomerFirstName::class,
			'customer_last_name'  => Customer\CustomerLastName::class,
			'customer_email'      => Customer\CustomerEmail::class,
			'new_password'        => Customer\CustomerNewPassword::class,

			'user_id'         => Customer\CustomerId::class,
			'user_name'       => Customer\CustomerName::class,
			'user_first_name' => Customer\CustomerFirstName::class,
			'user_last_name'  => Customer\CustomerLastName::class,
			'user_email'      => Customer\CustomerEmail::class,

			'customer_billing_address'           => Order\OrderBillingAddress::class,
			'customer_billing_address_2'         => Order\OrderBillingAddress2::class,
			'customer_billing_city'              => Order\OrderBillingCity::class,
			'customer_billing_country'           => Order\OrderBillingCountry::class,
			'customer_billing_first_name'        => Order\OrderBillingFirstName::class,
			'customer_billing_formatted_address' => Order\OrderBillingFormattedAddress::class,
			'customer_billing_last_name'         => Order\OrderBillingLastName::class,
			'customer_billing_postcode'          => Order\OrderBillingPostCode::class,
			'customer_billing_state'             => Order\OrderBillingState::class,

			'customer_shipping_address'           => Order\OrderShippingAddress::class,
			'customer_shipping_address_2'         => Order\OrderShippingAddress2::class,
			'customer_shipping_city'              => Order\OrderShippingCity::class,
			'customer_shipping_country'           => Order\OrderShippingCountry::class,
			'customer_shipping_first_name'        => Order\OrderShippingFirstName::class,
			'customer_shipping_formatted_address' => Order\OrderShippingFormattedAddress::class,
			'customer_shipping_last_name'         => Order\OrderShippingLastName::class,
			'customer_shipping_postcode'          => Order\OrderShippingPostCode::class,
			'customer_shipping_state'             => Order\OrderShippingState::class,

			'order_id'    => Order\OrderId::class,
			'order_total' => Order\OrderTotal::class,
			'order_date'  => Order\OrderDateCreated::class,

			'products_ordered'  => Order\OrderProductsOrdered::class,
		];

		return array_merge( $hashmap, apply_filters( 'shopmagic/core/placeholders/legacy', $legacy ) );
	}

	private function get_build_in_placeholders() {
		return [
			Customer\CustomerName::class,
			Customer\CustomerFirstName::class,
			Customer\CustomerLastName::class,
			Customer\CustomerEmail::class,
			Customer\CustomerNewPassword::class,

			Order\OrderCustomerId::class,
			Order\OrderBillingEmail::class,
			Order\OrderBillingAddress::class,
			Order\OrderBillingAddress2::class,
			Order\OrderBillingCity::class,
			Order\OrderBillingCountry::class,
			Order\OrderBillingFirstName::class,
			Order\OrderBillingFormattedAddress::class,
			Order\OrderBillingLastName::class,
			Order\OrderBillingPostCode::class,
			Order\OrderBillingState::class,

			Order\OrderShippingAddress::class,
			Order\OrderShippingAddress2::class,
			Order\OrderShippingCity::class,
			Order\OrderShippingCountry::class,
			Order\OrderShippingFirstName::class,
			Order\OrderShippingFormattedAddress::class,
			Order\OrderShippingLastName::class,
			Order\OrderShippingPostCode::class,
			Order\OrderShippingState::class,

			Order\OrderId::class,
			Order\OrderTotal::class,
			Order\OrderDateCreated::class,
			Order\OrderDatePaid::class,
			Order\OrderDateCompleted::class,

			Order\OrderProductsOrdered::class
		];
	}

	/**
	 * @param DataProvider $provider
	 * @param string $slug
	 *
	 * @return Placeholder
	 */
	public function create_placeholder( DataProvider $provider, $slug ) {
		$hashmap          = $this->get_slug_to_placeholder_hashmap( $provider );
		$placeholderClass = $hashmap[ $slug ];
		/** @var Placeholder $placeholder */
		$placeholder = new $placeholderClass();

		$placeholder->set_provided_data( $provider->get_provided_data() );

		return $placeholder;
	}

	public function is_placeholder_available( $provider, $slug ) {
		$hashmap = $this->get_slug_to_placeholder_hashmap( $provider );

		return ! empty( $hashmap[ $slug ] );
	}

	/**
	 * @return Placeholder[]
	 */
	public function get_placeholder_list() {
		return apply_filters( 'shopmagic/core/placeholders', $this->get_build_in_placeholders() );
	}

	/**
	 * TODO: move
	 *
	 * @param DataProvider $class_or_object
	 *
	 * @return string[]|DataReceiver[]|Placeholder[]
	 */
	public function get_placeholder_list_to_handle( $class_or_object ) {
		return ProviderReceiverMatcher::matchReceivers( $class_or_object, $this->get_placeholder_list() );
	}

	/**
	 * @param Placeholder[]|string[] $list
	 *
	 * @return string[]
	 */
	public static function convert_to_admin_slug_names( array $list ) {
		return array_map( function ( $item ) {
			/** @var Placeholder $item */
			return "<span class='placeholder' title='{$item::get_description()}'>{{ {$item::get_slug()} }}</span>";
		}, $list );
	}

	/**
	 * @param Placeholder[]|string[] $hashmap
	 *
	 * @return Placeholder[]|string[]
	 */
	private function get_slug_to_placeholder_hashmap( $class_or_object ) {
		$list    = $this->get_placeholder_list_to_handle( $class_or_object );
		$hashmap = [];
		foreach ( $list as $item ) {
			$hashmap[ $item::get_slug() ] = $item;
		}

		return $this->append_legacy_placeholders( $hashmap );
	}
}
