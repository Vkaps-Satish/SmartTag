<?php

namespace WPDesk\ShopMagic\Event\Builtin;

use WPDesk\ShopMagic\DataSharing\DataAccess\NewUserAccount;
use WPDesk\ShopMagic\Event\UserCommonEvent;


final class PasswordReset extends UserCommonEvent {
	/**
	 * @var \WP_User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $new_pass;

	public static function get_name() {
		return __( 'Password Reset Event', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Triggered when a customer resets their password', 'shopmagic-for-woocommerce' );
	}

	public static function get_provided_data_domains() {
		return [ \WP_User::class, NewUserAccount::class ];
	}

	public function get_provided_data() {
		return [ \WP_User::class => $this->get_user(), NewUserAccount::class => new NewUserAccount( $this->new_pass ) ];
	}

	public function initialize() {
		add_action( 'password_reset', array( $this, 'process_event' ), 10, 2 );
	}

	public function process_event( \WP_User $user, $new_pass ) {
		$this->user     = $user;
		$this->new_pass = $new_pass;
		$this->run_actions();
	}

	private function get_user() {
		return $this->user;
	}

}
