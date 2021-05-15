<?php

namespace core\workflow;

class WorkFlowConfig {
	private static $settings = array ();
	public static function getFlow($flowName) {
		if (! isset ( $flowName ) || empty ( $flowName )) {
			return null;
		}
		
		$key = strtolower ( $flowName );
		return isset ( self::$settings [$key] ) ? self::$settings [$key] : null;
	}
	public static function clear() {
		self::$settings = array ();
	}
	public static function addConfig(array $cfgs) {
		if (isset ( $cfgs )) {
			foreach ( $cfgs as $key => $value ) {
				self::$settings [strtolower ( $key )] = $value;
			}
		}
	}
	public static function addFlow(string $flowName, $flowInfo) {
		self::$settings [strtolower ( $flowName )] = $flowInfo;
	}
}