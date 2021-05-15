<?php

namespace core\config;

use core\utils\AppUtil;

class ActionConfig {
	private static $settings = array ();
	private static $actionModules = array ();
	private static $duplicatedActionModules = array ();
	public static function getSettings() {
		return self::$settings;
	}
	public static function getActionModules() {
		return self::$actionModules;
	}
	public static function getDuplicatedActionModules() {
		return self::$duplicatedActionModules;
	}
	public static function setModuleActionMap($module = "", $actionMap) {
		self::$settings = array ();
		self::$duplicatedActionModules = array ();
		if (isset ( $actionMap )) {
			self::$settings = $actionMap;
			foreach ( ( array ) $actionMap as $key => $value ) {
				if (isset ( self::$actionModules [$key] )) {
					self::$duplicatedActionModules [] = array (
							$key => $module
					);
					self::$duplicatedActionModules [] = array (
							$key => $module
					);
				}
				self::$actionModules [$key] = $module;
			}
		}
	}
	public static function addModuleActionMap($module = "", $actionMap) {
		if (! isset ( $actionMap ) || empty ( $actionMap )) {
			return;
		}
		foreach ( ( array ) $actionMap as $key => $value ) {
			self::$settings [$key] = $value;
			if (isset ( self::$actionModules [$key] )) {
				self::$duplicatedActionModules [] = array (
						$key => self::$actionModules [$key]
				);
				self::$duplicatedActionModules [] = array (
						$key => $module
				);
			}
			self::$actionModules [$key] = $module;
		}
	}
	public static function getActionMap($actionPath) {
		$actionPath = AppUtil::isEmptyString ( $actionPath ) ? "" : strtolower ( $actionPath );
		return isset (self::$settings [$actionPath])?self::$settings [$actionPath]:null;
	}
	public static function getModule($actionPath) {
		$actionPath = AppUtil::isEmptyString ( $actionPath ) ? "" : strtolower ( $actionPath );
		return isset ( self::$actionModules [$actionPath] ) ? self::$actionModules [$actionPath] : null;
	}
}