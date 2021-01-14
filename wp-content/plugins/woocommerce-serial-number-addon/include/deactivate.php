<?php

/**
* @package GeekSerialNumber
* Trigger this file on plugin deactivation
**/

class GeekSerialNumberDeactivate {

	static function deactivate(){
		flush_rewrite_rules();
	}
}
