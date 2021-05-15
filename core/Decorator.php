<?php

namespace core;

class Decorator {
	private static $bodyPath;
	public static function setBodyPath($bodyPath) {
		self::$bodyPath = $bodyPath;
	}
	public static function getBodyPath() {
		return isset ( self::$bodyPath ) ? self::$bodyPath : '';
	}
}