<?php

/**
 * Plain content as is.
 *
 * @package ShopMagic
 */
class ShopMagic_Template_Plain extends ShopMagic_Template {
	const NAME = 'plain';

	/**
	 * Can wrap given content in a template
	 *
	 * @param string $html_content
	 * @param array $args
	 *
	 * @return string
	 */
	public function wrap_content( $html_content, array $args = [] ) {
		return $html_content;
	}

}