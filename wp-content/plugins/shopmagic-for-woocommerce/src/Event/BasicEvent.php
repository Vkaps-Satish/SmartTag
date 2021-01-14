<?php

namespace WPDesk\ShopMagic\Event;

use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\Filter\Filter;
use WPDesk\ShopMagic\Filter\FilterLogic;

/**
 * ShopMagic Events Base class
 *
 * @package ShopMagic
 * @since   1.0.0
 */
abstract class BasicEvent implements Event {
	/** @var Automation */
	protected $automation;

	/** @var FilterLogic */
	private $filter;

	public static function get_provided_data_domains() {
		return [];
	}

	public function get_provided_data() {
		return [];
	}

	public function set_automation( Automation $automation ) {
		$this->automation = $automation;
	}

	public function set_filter_logic( FilterLogic $filter ) {
		$this->filter = $filter;
	}

	/**
	 * Checks all filters in event.
	 *
	 * @param Filter[] $filters
	 * @param BasicEvent $event
	 *
	 * @return bool True if all filters passed.
	 */
	private function filters_passed( array $filters, BasicEvent $event ) {
		foreach ( $filters as $filter ) {
			if ( $filter instanceof FilterLogic && ! $filter->passed( $event ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Run registered actions from automation
	 *
	 * @since 1.0.0
	 */
	protected function run_actions() {
		if ( $this->filters_passed( [ $this->filter ], $this ) ) {
			$this->automation->event_fired( $this );
		}
	}

	/**
	 * Show parameters window in an admin side widget
	 *
	 * @param $automation_id integer current displayed automation
	 *
	 * @since   1.0.0
	 */
	public static function show_parameters( $automation_id ) {

	}

	/**
	 * Save parameters from POST request, called from an admin side widget
	 *
	 * @param $automation_id integer current displayed automation
	 *
	 * @since   1.0.0
	 */
	public static function save_parameters( $automation_id ) {

	}

	/**
	 * Returns the description of the current Event
	 *
	 * @return string Event description
	 * @since   1.0.4
	 */
	public static function get_description() {
		return __( 'No description provided for this event.', 'shopmagic' );
	}
}
