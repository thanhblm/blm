<?php

namespace core;

class Application {
	public static function get($key) {
		return isset ( $GLOBALS [$key] ) ? $GLOBALS [$key] : null;
	}
	public static function set($key, $value) {
		$GLOBALS [$key] = $value;
	}
}