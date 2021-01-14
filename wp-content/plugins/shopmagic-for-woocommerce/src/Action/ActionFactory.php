<?php

namespace WPDesk\ShopMagic\Action;

use WPDesk\ShopMagic\Action\Builtin\AddToMailChimpList;
use WPDesk\ShopMagic\Action\Builtin\SendMail;

final class ActionFactory {
	/** @return Action */
	public function create_action( $slug, $data ) {
		$className = $this->get_action_classes_list()[ $slug ];

		return new $className( $data );
	}

	/**
	 * @param string
	 *
	 * @return string|Action
	 */
	public function get_action_class( $slug ) {
		return $this->get_action_classes_list()[ $slug ];
	}

	/**
	 * @return string[]|Action[]
	 */
	public function get_action_classes_list() {
		return apply_filters( 'shopmagic/core/actions',
			apply_filters( 'shopmagic_actions', // legacy filter
				$this->get_build_in_action_classes() ) );
	}

	/**
	 * @return string[]|Action[]
	 */
	private function get_build_in_action_classes() {
		return array(
			'shopmagic_sendemail_action'          => SendMail::class,
			'shopmagic_addtomailchimplist_action' => AddToMailChimpList::class
		);
	}
}
