<?php

namespace WPDesk\ShopMagic\Placeholder\Builtin\Traits;

/**
 * Provides functions to format date to WP i18n.
 *
 * @package WPDesk\ShopMagic\Placeholder\Builtin\Traits
 */
trait DateFormatHelper {
	/**
	 * @param string|\WC_DateTime|int|null $date
	 *
	 * @return string
	 */
	private function format_date( $date ) {
		if ( $date === null ) {
			return '';
		}
		$wp_format = get_option( 'date_format', 'Y-m-d' );
		if ( is_string( $date ) ) {
			$date = strtotime( $date );
		}
		if ( is_int( $date ) ) {
			return date_i18n( $wp_format, $date );
		}
		if ( $date instanceof \WC_DateTime ) {
			return $date->date_i18n( $wp_format );
		}

		return '';
	}
}
