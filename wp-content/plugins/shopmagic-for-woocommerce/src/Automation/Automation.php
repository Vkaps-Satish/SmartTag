<?php

namespace WPDesk\ShopMagic\Automation;

use WPDesk\ShopMagic\Action\ActionFactory;
use WPDesk\ShopMagic\Event\Event;
use WPDesk\ShopMagic\Event\EventFactory;
use WPDesk\ShopMagic\Filter\Builtin\ProductPurchased;
use WPDesk\ShopMagic\Filter\FilterLogic;
use WPDesk\ShopMagic\Filter\NullFilter;
use WPDesk\ShopMagic\Placeholder\PlaceholderFactory;
use WPDesk\ShopMagic\Placeholder\PlaceholderProcessor;


/**
 * Responsible for save/load data. Also a mediator pattern for event-action.
 *
 * @package WPDesk\ShopMagic\Automation
 */
final class Automation {
	/** @var int */
	private $id;

	/** @var Event */
	private $event;

	/** @var ActionFactory */
	private $action_factory;

	/** @var PlaceholderFactory */
	private $placeholder_factory;

	public function __construct(
		$automation_id,
		EventFactory $event_factory,
		ActionFactory $action_factory,
		PlaceholderFactory $placeholder_factory
	) {
		$this->id                  = $automation_id;
		$this->action_factory      = $action_factory;
		$this->placeholder_factory = $placeholder_factory;
		$this->event               = $this->create_event( $event_factory, $automation_id );
	}

	public static function create_active_automations(
		EventFactory $event_factory,
		ActionFactory $action_factory,
		PlaceholderFactory $placeholder_factory
	) {
		$args = array(
			'post_type'      => 'shopmagic_automation',
			'post_status'    => 'publish', // only active automations
			'posts_per_page' => - 1   // all of them
		);

		$automations = new \WP_Query( $args );

		if ( $automations->have_posts() ) {
			while ( $automations->have_posts() ) {
				$automations->the_post();

				$automation = new self( get_the_ID(), $event_factory, $action_factory, $placeholder_factory );
				$automation->initialize();

			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
	}

	/**
	 * @param int $automation_id
	 *
	 * @return FilterLogic
	 */
	private function create_filter( $automation_id ) {
		$filter = get_post_meta( $automation_id, '_filter', true );
		if ( ! empty( $filter ) ) { // TODO: makes no sense at the moment
			$filter = new ProductPurchased( $this->id );
		} else {
			$filter = new NullFilter();
		}

		return $filter;
	}

	/**
	 * @param EventFactory $event_factory
	 * @param int $automation_id
	 *
	 * @return Event
	 */
	private function create_event( EventFactory $event_factory, $automation_id ) {
		$event_slug = get_post_meta( $automation_id, '_event', true );
		$filter     = $this->create_filter( $automation_id );

		return $event_factory->create_event( $event_slug, $this, $filter );
	}

	public function initialize() {
		$this->event->initialize();
	}

	public function event_fired( Event $event ) {
		$actions = get_post_meta( $this->id, '_actions', true );

		// TODO: move to settings class
		$shopmagic_debug_setting          = get_option( 'wc_settings_sm_debug', false );
		$shopmagic_store_messages_setting = get_option( 'wc_settings_sm_store_messages', false );

		if ( is_array( $actions ) ) { // if meta exists and it is an array

			$placeholder_processor = new PlaceholderProcessor( $this->placeholder_factory, $event );

			foreach ( $actions as $key => $action_data ) { // run each registered action_data
				$action = $this->action_factory->create_action( $action_data['_action'], $action_data );
				$action->set_provided_data( $event->get_provided_data() );
				$action->set_placeholder_processor( $placeholder_processor );

//				$action_slug       = $action_data['_action'];
//				$action_class_name = $this->core->get_action( $action_slug );
//				$action            = $action_class_name( $this->core, $this->automation_id, $action_data );

				$is_action_delayed = false;

				if ( array_key_exists( '_action_delayed', $action_data ) && $action_data['_action_delayed'] === 'on' ) {
					$is_action_delayed = true;

					// Delay offset
					( $action_data['_action_delayed_offset_time'] == '' ) ? $action_delayed_offset_time = 0 : $action_delayed_offset_time = $action_data['_action_delayed_offset_time'];
				}

				if ( $is_action_delayed ) { // If delayed
					// time() + : to start concidering the delay from the current UTC time
					// default exec time even if 'after_event' option is selected from the _action_delay_after select box
					$action_exec_time = time() + $action_delayed_offset_time;

					if ( $action_data['_action_delay_after'] === 'after_last_action' && (int) ( $key ) > 0 ) {

						// Get offset time of last action_data if this is not the fist action_data not $key 0
						$offset_of_last_action = $actions[ ( $key - 1 ) ]['_action_delayed_offset_time'];

						// Update the execution time
						$action_exec_time = time() + $offset_of_last_action + $action_delayed_offset_time;
					}
					// Create the single schedule cron
					wp_schedule_single_event(
						$action_exec_time, 'shopmagic_delayed_action_hook', array(
							$action,
							$this,
							$event,
						)
					);

				} else {
					$action->execute( $this, $event );
				}
			}
		}
	}

}
