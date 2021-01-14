<?php

use \ShopMagicVendor\Pelago\Emogrifier;

/**
 * Emogrifier factory. Emogrifier is a class for converting CSS styles into inline style attributes in your HTML code.
 *
 * @package ShopMagic
 */
class ShopMagic_Emogrifier_Factory {

	/**
	 * @param string $html HTML to mess with.
	 * @param string $css Css to be inlined and injected into HTML.
	 *
	 * @throws ShopMagic_Emogrifier_Factory_NotFound_Exception
	 * @return Emogrifier
	 */
	public static function create_Emogrifier( $html, $css) {
		if ( ! class_exists( 'DOMDocument' ) ) {
			throw new ShopMagic_Emogrifier_Factory_NotFound_Exception('Emogrifier is not supported as DOMDocument is not defined');
		}
		try {
			return new Emogrifier( $html, $css );
		} catch (\Exception $e) {
			throw new ShopMagic_Emogrifier_Factory_NotFound_Exception('Emogrifier cant be created', $e);
		}
	}

}
