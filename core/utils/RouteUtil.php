<?php

namespace core\utils;

use core\Route;

class RouteUtil {
	private static $uri = "";
	private static $oldUri = "";
	private static $route;
	public static function getRoute() {
		if (empty ( self::$uri )) {
			self::$uri = $_SERVER ['REQUEST_URI'];
			self::$oldUri = "";
		}
		
		if (self::$uri != self::$oldUri) {
			self::$route = new Route ( self::$uri );
			self::$oldUri = self::$uri;
		}
		return self::$route;
	}
	public static function setRoute($newURI) {
		self::$route = new Route ( $newURI );
	}
	public static function setUri($newURI) {
		self::$oldUri = self::$uri;
		self::$uri = $newURI;
	}
	public static function getUri() {
		return self::$uri;
	}
}