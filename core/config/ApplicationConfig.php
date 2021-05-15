<?php

namespace core\config;

use core\utils\AppUtil;
class ApplicationConfig {
	protected static $settings = array ();
	public static function get($key) {
		return isset ( self::$settings [$key] ) ? self::$settings [$key] : null;
	}
	public static function set($key, $value) {
		self::$settings [$key] = $value;
	}
	
	public static function getSettings() {
		return AppUtil::cloneObj(self::$settings);
	}
}