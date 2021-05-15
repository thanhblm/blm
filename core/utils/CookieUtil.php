<?php

namespace core\utils;

use core\config\ApplicationConfig;

class CookieUtil {
	const SESSION = null;
	const DAY = 86400;
	const WEEK = 604800;
	const MONTH = 2592000;
	const SIX_MONTH = 15811200;
	const YEAR = 31536000;
	const LIFE_TIME = - 1;
	public static function exists($name) {
		$cookieName = CookieUtil::generateCookieName ( $name );
		return isset ( $_COOKIE [$cookieName] );
	}
	public static function get($name) {
		$cookieName = CookieUtil::generateCookieName ( $name );
		return isset ( $_COOKIE [$cookieName] ) ? $_COOKIE [$cookieName] : null;
	}
	public static function set($name, $value, $expiry = self::YEAR, $path = "/", $domain = false) {
		$cookieName = CookieUtil::generateCookieName ( $name );
		$retVal = false;
		if (! headers_sent ()) {
			if (false === $domain) {
				$domain = $_SERVER ["HTTP_HOST"];
			}
			if (- 1 === $expiry) {
				$expiry = 1893456000; // Lifetime = 2030-01-01 00:00:00
			} elseif (is_numeric ( $expiry )) {
				$expiry += time ();
			} else {
				$expiry = strtotime ( $expiry );
			}
			$retval = @setcookie ( $cookieName, $value, $expiry, $path, $domain );
			if ($retval) {
				$_COOKIE [$cookieName] = $value;
			}
		}
		return $retVal;
	}
	public static function delete($name, $path = "/", $domain = false, $removeFromGlobal = false) {
		$cookieName = CookieUtil::generateCookieName ( $name );
		$retval = false;
		if (! headers_sent ()) {
			if (false === $domain) {
				$domain = $_SERVER ['HTTP_HOST'];
			}
			$retval = setcookie ( $cookieName, '', time () - 3600, $path, $domain );
			if ($removeFromGlobal) {
				unset ( $_COOKIE [$cookieName] );
			}
		}
		return $retval;
	}
	private static function generateCookieName($name) {
		$siteName = ApplicationConfig::get ( "site.name" );
		$version = ApplicationConfig::get ( "version" );
		return md5 ( $name . $siteName . $version );
	}
}