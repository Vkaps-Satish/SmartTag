<?php

namespace WPDesk\ShopMagic\Event;

use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\Event\Builtin\NewAccount;
use WPDesk\ShopMagic\Event\Builtin\OrderCancelled;
use WPDesk\ShopMagic\Event\Builtin\OrderCompleted;
use WPDesk\ShopMagic\Event\Builtin\OrderFailed;
use WPDesk\ShopMagic\Event\Builtin\OrderNew;
use WPDesk\ShopMagic\Event\Builtin\OrderOnHold;
use WPDesk\ShopMagic\Event\Builtin\OrderPending;
use WPDesk\ShopMagic\Event\Builtin\OrderProcessing;
use WPDesk\ShopMagic\Event\Builtin\OrderRefunded;
use WPDesk\ShopMagic\Event\Builtin\PasswordReset;
use WPDesk\ShopMagic\Filter\FilterLogic;

final class EventFactory {
	const GROUP_USERS = 'users';
	const GROUP_ORDERS = 'orders';

	/** @return Event */
	public function create_event( $slug, Automation $automation, FilterLogic $filters ) {
		$className = $this->get_event_classes_list()[ $slug ];

		/** @var Event $event */
		$event = new $className();
		$event->set_automation( $automation );
		$event->set_filter_logic( $filters );

		return $event;
	}

	/**
	 * @return string[]|Event[]
	 */
	public function get_event_classes_list() {
		return apply_filters( 'shopmagic/core/events',
			apply_filters( 'shopmagic_events', // legacy filter
				$this->get_build_in_event_classes() ) );
	}

	/**
	 * @param string $group_id
	 *
	 * @return string
	 */
	public function event_group_name( $group_id ) {
		$groups = apply_filters( 'shopmagic/core/groups',
			apply_filters( 'shopmagic_event_groups', [
				self::GROUP_ORDERS => __( 'Orders', 'shopmagic-for-woocommerce' ),
				self::GROUP_USERS  => __( 'User Management', 'shopmagic-for-woocommerce' )
			] ) );

		return $groups[ $group_id ] ?: '';
	}

	/**
	 * @param string
	 *
	 * @return string|Event
	 */
	public function get_event_class( $slug ) {
		return $this->get_event_classes_list()[ $slug ];
	}

	/**
	 * @return string[]|Event[]
	 */
	private function get_build_in_event_classes() {
		return array(
			'shopmagic_order_new_event'        => OrderNew::class,
			'shopmagic_order_pending_event'    => OrderPending::class,
			'shopmagic_order_processing_event' => OrderProcessing::class,
			'shopmagic_order_cancelled_event'  => OrderCancelled::class,
			'shopmagic_order_completed_event'  => OrderCompleted::class,
			'shopmagic_order_failed_event'     => OrderFailed::class,
			'shopmagic_order_on_hold_event'    => OrderOnHold::class,
			'shopmagic_order_refunded_event'   => OrderRefunded::class,

			'shopmagic_password_reset_event' => PasswordReset::class,
			'shopmagic_new_account_event'    => NewAccount::class,
		);
	}
}
