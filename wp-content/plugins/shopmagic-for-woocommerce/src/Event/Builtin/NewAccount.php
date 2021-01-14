<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\Event\UserCommonEvent;

final class NewAccount extends UserCommonEvent {
	/**
	 * @var int
	 */
	private $user_id;

	public static function get_name() {
		return __( 'New Account Event', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when new customer account gets created via WooCommerce', 'shopmagic-for-woocommerce' );
	}

	public static function get_provided_data_domains() {
		return [ \WP_User::class ];
	}

	public function get_provided_data() {
		return [ \WP_User::class => $this->get_user() ];
	}

	public function initialize() {
		add_action( 'user_register', array( $this, 'process_event' ), 10, 1 );
	}

	public function process_event( $user_id ) {
		$this->user_id = $user_id;
		$this->run_actions();
	}

	/**
	 * Returns the user objects, associated with an event
	 *
	 * @return \WP_User
	 */
	private function get_user() {
		return new \WP_User( $this->user_id );
	}
}
