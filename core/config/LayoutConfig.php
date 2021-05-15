<?php

namespace core\config;

class LayoutConfig {
	private static $settings = array ();
	public static function getModuleLayoutConfig($module = "") {
		$module = strtolower ( $module );
		return isset ( self::$settings [$module] ) ? self::$settings [$module] : null;
	}
	public static function setModuleLayoutConfig($module = "", $layoutConfig) {
		self::$settings [$module] = $layoutConfig;
	}
}