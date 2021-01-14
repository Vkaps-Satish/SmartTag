<?php

namespace WPDesk\ShopMagic\Event;

abstract class OrderCommonEvent extends BasicEvent {
	/** @var \WC_Order */
	protected $order;

	public static function get_group_slug() {
		return EventFactory::GROUP_ORDERS;
	}

	public static function get_provided_data_domains() {
		return [ \WC_Order::class, \WP_User::class ];
	}

	public function get_provided_data() {
		return [ \WC_Order::class => $this->get_order(), \WP_User::class => $this->get_user() ];
	}

	public function event_change_status_fired( $order_id, $order ) {
		$this->order = $order;
		$this->run_actions();
	}

//		add_filter( 'shopmagic_placeholders_event_' . static::$slug, array( $this, 'product_add_placeholder' ) );
//		add_filter( 'shopmagic_placeholders_values_event_' . static::$slug, array(
//			$this,
//			'product_add_placeholder_value'
//		), 10 );

	/**
	 * Returns the order objects, associated with an event
	 *
	 * @return \WC_Order
	 * @since   1.0.0
	 */
	protected function get_order() {
		return $this->order;
	}

	/**
	 * Returns the user objects, associated with an event
	 *
	 * @return \WP_User
	 * @since   1.0.0
	 */
	protected function get_user() {
		return $this->get_order()->get_user();
	}
//
//	public function product_add_placeholder( $placeholders ) {
//		$placeholders_new = array_slice( $placeholders, 0, 5, true ) +
//		                    array( 'products_ordered' => 'List of ordered products' ) +
//		                    array_slice( $placeholders, 5, null, true );
//
//		return $placeholders_new;
//	}
//
//	public function product_add_placeholder_value( $placeholder_values ) {
//		$order = $this->get_order();
//		if ( $order instanceof WC_Abstract_Order ) {
//			$order_items = $order->get_items();
//
//			// Add product ordered placeholder value.
//			$placeholder_values['products_ordered'] = '<ul>';
//			foreach ( $order_items as $id => $val ) {
//				$placeholder_values['products_ordered'] .= '<li>' . $val['name'] . ' ' . ( print_r( $val ) ) . '</li>';
//			}
//			$placeholder_values['products_ordered'] .= '</ul>';
//		}
//
//		return $placeholder_values;
//	}

}
