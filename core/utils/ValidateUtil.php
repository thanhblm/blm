<?php

namespace core\utils;

class ValidateUtil {
	public static function isInt($var, $min = null, $max = null) {
		$options = array ();
		if (! is_null ( $min )) {
			$options ["min_range"] = $min;
		}
		if (! is_null ( $max )) {
			$options ["max_range"] = $max;
		}
		if (count ( $options ) !== 0) {
			return false !== filter_var ( $var, FILTER_VALIDATE_INT, array (
					"options" => $options 
			) );
		}
		return false !== filter_var ( $var, FILTER_VALIDATE_INT ) || filter_var ( $var, FILTER_VALIDATE_INT ) === 0;
	}
	public static function intVal($var) {
		return filter_var ( $var, FILTER_VALIDATE_INT );
	}
	public static function isBool($var) {
		$boolArray = array (
				"true",
				"false",
				"yes",
				"no",
				"on",
				"off",
				"1",
				"0" 
		);
		return in_array ( strtolower ( $var ), $boolArray );
	}
	public static function boolVal($var) {
		return filter_var ( $var, FILTER_VALIDATE_BOOLEAN );
	}
	public static function isFloat($var) {
		return false !== filter_var ( $var, FILTER_VALIDATE_FLOAT );
	}
	public static function floatVal($var) {
		return filter_var ( $var, FILTER_VALIDATE_FLOAT );
	}
	public static function isEmail($var) {
		return false !== filter_var ( $var, FILTER_VALIDATE_EMAIL );
	}
	public static function isIp($var) {
		return false !== filter_var ( $var, FILTER_VALIDATE_IP );
	}
	public static function isRegExp($var, $exp) {
		return false !== filter_var ( $var, FILTER_VALIDATE_REGEXP, array (
				"options" => array (
						"regexp" => $exp 
				) 
		) );
	}
	public static function isUrl($var) {
		return false !== filter_var ( $var, FILTER_VALIDATE_URL );
	}
	public static function isDate($var) {
		$isDate = true;
		try {
			$date = DateTimeUtil::string2MySqlDate ( $var, DateTimeUtil::getDateFormat () );
		} catch ( \Exception $e ) {
			$isDate = false;
		}
		return $isDate;
	}
	public static function dateVal($var) {
		return DateTimeUtil::string2MySqlDate ( $var, DateTimeUtil::getDateFormat () );
	}
}