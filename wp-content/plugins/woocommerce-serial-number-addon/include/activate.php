<?php 

/**
* @package GeekSerialNumber
* Trigger this file on plugin activation
**/

class GeekSerialNumberActivate {

	static function activate(){
		flush_rewrite_rules();
	}
}