<?php

namespace core\config;

class ModuleConfig {
	private static $settings = array ();
	public static function getModuleConfig($module = "") {
		$module = strtolower ( $module );
		return isset ( self::$settings [$module] ) ? self::$settings [$module] : null;
	}
	public static function addModuleConfig($module = "", $key = "", $value = "") {
		if (isset(self::$settings[$module]) && isset($key) && isset($value)){
			self::$settings[$module][$key] = $value;
		}
	}
	public static function setConfig($moduleConfig) {
		self::$settings = $moduleConfig;
	}
	public static function getModules() {
		return self::$settings ;
	}
}