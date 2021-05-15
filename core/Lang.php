<?php

namespace core;

use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\config\ApplicationConfig;

class Lang {
	private static $instance;
	private static function getInstance() {
		if (! isset ( self::$instance )) {
			self::$instance = new Dictionary ();
		}
		return self::$instance;
	}
	public static function get($key) {
		// return $key;
		return self::getInstance ()->get ( self::getLangCode (), $key);
	}
	public static function getWithFormat() {
		$n = func_num_args ();
		if (1 > $n) {
			throw new \Exception ( "Please call Lang::getWithFormat with key and optional variables." );
		}
		$text = self::getInstance ()->get ( self::getLangCode (), func_get_arg ( 0 ) );
		$formats = self::getFormats ( $text );
		if (empty ( $formats )) {
			return $text;
		}
		$replaceMap = array ();
		foreach ( $formats as $format ) {
			$i = intval ( substr ( $format, 1, strlen ( $format ) - 1 ) );
			if ($i + 1 < $n) {
				$replaceMap [$format] = func_get_arg ( $i + 1 );
			}
		}
		return AppUtil::replaceByMap ( $replaceMap, $text );
	}
	private static function getFormats($str) {
		$pattern = "/{[0-9]+}/";
		if (preg_match_all ( $pattern, $str, $matches )) {
			return $matches [0];
		}
		return false;
	}
	private static function getLangCode() {
		$langCode = SessionUtil::get ( "language.default.code" );
		if (AppUtil::isEmptyString ( $langCode )) {
			$langCode = ApplicationConfig::get ( "language.default.code" );
		}
		if (AppUtil::isEmptyString ( $langCode )) {
			$langCode = "en";
		}
		return $langCode;
	}
}