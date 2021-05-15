<?php

namespace core\config;

class FilterConfig {
	private static $settings = array ();
	public static function getModuleFilters($module = "") {
		$module = strtolower ( $module );
		return isset ( self::$settings [$module] ) ? self::$settings [$module] : null;
	}
	public static function setModuleFilters($module = "", $filters) {
		self::$settings [$module] = $filters;
	}
}