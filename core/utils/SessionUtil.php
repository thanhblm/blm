<?php

namespace core\utils;

use core\config\ApplicationConfig;

class SessionUtil {
	public function __construct() {
	}
	public static function get($key) {
		$sessionKey = SessionUtil::generateSessionKey ( $key );
		return isset ( $_SESSION [$sessionKey] ) ? $_SESSION [$sessionKey] : null;
	}
	public static function set($key, $value) {
		$sessionKey = SessionUtil::generateSessionKey ( $key );
		$_SESSION [$sessionKey] = $value;
	}
	public static function remove($key) {
		$sessionKey = SessionUtil::generateSessionKey ( $key );
		if (isset ( $_SESSION [$sessionKey] )) {
			unset ( $_SESSION [$sessionKey] );
		}
	}
	public static function clear() {
		foreach ( $_SESSION as $key ) {
			unset ( $_SESSION [$key] );
		}
		session_destroy ();
	}
	public static function getId(){
		return session_id();
	}
	private static function generateSessionKey($key) {
		// $siteName = ApplicationConfig::get ( "site.name" );
		// $version = ApplicationConfig::get ( "version" );
		// return md5 ( $siteName . $version ) . "_" . $key;
		if (! empty ( ApplicationConfig::get ( "session.prefix" ) )) {
			$key = ApplicationConfig::get ( "session.prefix" ) . "_" . $key;
		}
		return $key;
	}
}