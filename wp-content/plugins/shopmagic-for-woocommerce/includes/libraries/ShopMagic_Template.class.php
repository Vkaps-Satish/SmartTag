<?php

/**
 * Represents a template that can render a content inside.
 *
 * @package ShopMagic
 */
abstract class ShopMagic_Template {

	/**
	 * Can wrap given content in a template
	 *
	 * @param string $html_content
	 * @param array $args
	 *
	 * @return string
	 */
	abstract public function wrap_content( $html_content, array $args = [] );
}