<?php

namespace WPDesk\ShopMagic\Placeholder;

use WPDesk\ShopMagic\DataSharing\DataReceiver;

/**
 * Static function are responsible for the info that is required to estabilish a contract:
 * what should be prepared for this class to successfully instantiate and will the instance be used.
 * We should avoid changes in these static conditions during runtime. If these conditions needs to change then we
 * should refactor the static part to another class. Now it's here to greatly simplyfy the extending of the class for external devs.
 *er ins
 * Three responsibilities:
 * - Has info how the placeholder should look in admin panel: name, description, parameters to render
 * - DataReceiver.
 * - Receives data for processing placeholder shortcode and processes it.
 *
 * @package WPDesk\ShopMagic\Placeholder
 */
interface Placeholder extends DataReceiver {
	/**
	 * Shortcode for the placeholder. Have to be unique. Can be in any format but
	 * most placeholder should use groupname.name-of-the-placeholder format.
	 * In form input the groupname.name-of-the-placeholder should looks like {{ groupname.name-of-the-placeholder }}
	 *
	 * @return string
	 */
	public static function get_slug();

	/**
	 * Description of the placeholder that will be shown in admin panel.
	 *
	 * @return string
	 */
	public static function get_description();

	/**
	 * Placeholder should say what data object is required to return a value.
	 * Object of the returned class will be passed to value method as first argument.
	 * Also this value will be used in admin panel to match placeholders with events.
	 *
	 * @return string Name of the required class. If no class is required it should return @TODO: null?
	 */
	public static function get_required_object_type();

	/**
	 * @return Parameter[]
	 */
	public static function get_supported_parameters();

	/**
	 * Placeholder value to replace the shortcode of given name.
	 *
	 * @param object $object Instance of the class from get_required_object_type.
	 * @param string[] $parameters
	 *
	 * @return string
	 */
	public function value( $object, array $parameters );

}
