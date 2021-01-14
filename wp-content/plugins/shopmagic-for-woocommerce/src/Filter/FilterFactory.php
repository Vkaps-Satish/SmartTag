<?php

namespace WPDesk\ShopMagic\Filter;


use WPDesk\ShopMagic\Filter\Builtin\ProductPurchased;
use WPDesk\ShopMagic\Filter\Filter;

final class FilterFactory {

	/**
	 * @return string[]|Filter[]
	 */
	public function get_event_classes_list() {
		return apply_filters( 'shopmagic/core/filters',
			apply_filters( 'shopmagic_filters', // legacy filter
				$this->get_build_in_filter_classes() ) );
	}


	/**
	 * @param string
	 *
	 * @return string|Filter
	 */
	public function get_filter_class( $slug ) {
		return $this->get_event_classes_list()[ $slug ];
	}

	/**
	 * @return string[]|Filter[]
	 */
	private function get_build_in_filter_classes() {
		return array(
			'shopmagic_product_purchased_filter' => ProductPurchased::class,
		);
	}
}
