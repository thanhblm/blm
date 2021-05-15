<?php

namespace core\utils;

use common\utils\StringUtil;
use core\BaseArray;
use core\config\FConstants;
use core\config\ModuleConfig;

class AppUtil {
	public static function isEmptyString($string) {
		if (! isset ( $string ) || trim ( $string ) === '') {
			return true;
		}
		return false;
	}
	public static function ucName($string, $ucFirst = true) {
		if ($ucFirst) {
			$string = ucfirst ( $string );
		}
		foreach ( array (
				'-',
				'_' 
		) as $delimiter ) {
			if (strpos ( $string, $delimiter ) !== false) {
				$string = implode ( $delimiter, array_map ( 'ucfirst', explode ( $delimiter, $string ) ) );
			}
			$string = str_ireplace ( $delimiter, "", $string );
		}
		return $string;
	}
	public static function resource_url($path = null) {
		if (! isset ( $path ) || $path == "/") {
			return RouteUtil::getRoute ()->getWebRoot () . "/";
		}
		return RouteUtil::getRoute ()->getWebRoot () . str_ireplace ( DS, "/", DS . ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::RELATIVE_RESOURCE_PATH] ) . str_ireplace ( DS, "/", DS . $path );
	}
	public static function web_url($path) {
		if (! isset ( $path ) || $path == "/") {
			return RouteUtil::getRoute ()->getWebRoot () . "/";
		}
		return RouteUtil::getRoute ()->getWebRoot () . str_ireplace ( DS, "/", DS . $path );
	}
	public static function current_action() {
		return RouteUtil::getRoute ()->getPath ();
	}
	public static function array2Object($array, $className, $refObj = null) {
		if (! class_exists ( $className )) {
			return null;
		}
		// Check if the class name is Base Array.
		if ($className == BaseArray::class) {
			$object = new BaseArray ( $refObj->getType () );
			foreach ( $array as $element ) {
				$object->add ( self::array2Object ( $element, $refObj->getType () ) );
			}
			return $object;
		}
		// Get properties map of the class first.
		$object = new $className ();
		foreach ( $array as $key => $value ) {
			// If value is an object.
			if (is_array ( $value )) {
				// Get type of property.
				$type = get_class ( $object->$key );
				$object->$key = self::array2Object ( $value, $type, $object->$key );
			} else {
				$object->$key = $value;
			}
		}
		return $object;
	}
	public static function object2Array($object) {
		$class = get_class ( $object );
		// If the object is BaseArray or array then returns it.
		if ($class == BaseArray::class || is_array ( $object )) {
			return $object->getArray ();
		}
		$instance = new \ReflectionClass ( $class );
		$properties = $instance->getProperties ( \ReflectionProperty::IS_PUBLIC );
		$array = array ();
		foreach ( $properties as $property ) {
			$value = $property->getValue ( $object );
			if (is_object ( $value )) {
				$array [$property->getName ()] = self::object2Array ( $value );
			} else {
				$array [$property->getName ()] = $value;
			}
		}
		return $array;
	}
	public static function phpRequest2Array() {
		$array = array ();
		foreach ( $_REQUEST as $key => $value ) {
			$array = array_merge_recursive ( $array, self::phpParam2Array ( $key, $value ) );
		}
		return $array;
	}
	public static function phpParam2Array($key, $value) {
		if (AppUtil::isEmptyString ( $key )) {
			return null;
		}
		$array = array ();
		$props = explode ( "_", $key );
		if (count ( $props ) == 0) {
			return null;
		}
		if (count ( $props ) == 1) {
			$array [$key] = $value;
			return $array;
		}
		// Get new key & value.
		$newKey = current ( $props );
		array_shift ( $props );
		$newValue = self::phpParam2Array ( implode ( "_", $props ), $value );
		$array [$newKey] = $newValue;
		return $array;
	}
	public static function array2PhpRequest($array, $prefix = null) {
		foreach ( $array as $key => $value ) {
			if (is_array ( $value )) {
				self::array2PhpRequest ( $value, $prefix . $key . "_" );
			} else {
				$_REQUEST [$prefix . $key] = $value;
			}
		}
	}
	public static function debugInfo($var) {
		echo "<pre>";
		print_r ( $var );
		echo "</pre>";
	}
	public static function getMicroTime() {
		$microtime = microtime ();
		$parts = explode ( " ", $microtime );
		return $parts [1];
	}
	public static function camelCase($str) {
		$arr = explode ( "_", $str );
		$first = strtolower ( $arr [0] );
		$result = $first;
		for($i = 1; $i < count ( $arr ); $i ++) {
			$result .= ucfirst ( $arr [$i] );
		}
		return $result;
	}
	public static function pascalCase($str) {
		return ucfirst ( self::camelCase ( $str ) );
	}
	public static function replaceByMap($map, $string) {
		if (is_null ( $map ) || count ( $map ) == 0) {
			return $string;
		}
		if (self::isEmptyString ( $string )) {
			return $string;
		}
		$result = $string;
		foreach ( $map as $key => $value ) {
			$result = str_replace ( $key, $value, $result );
		}
		return $result;
	}
	public static function getInbetweenStrings($start, $end, $str) {
		$matches = array ();
		$regex = "/$start([a-zA-Z0-9_:]*)$end/";
		preg_match_all ( $regex, $str, $matches );
		return $matches [1];
	}
	public static function startsWith($haystack, $needle) {
		$length = strlen ( $needle );
		return (substr ( $haystack, 0, $length ) === $needle);
	}
	public static function endsWith($haystack, $needle) {
		$length = strlen ( $needle );
		if ($length == 0) {
			return true;
		}
		return (substr ( $haystack, - $length ) === $needle);
	}
	/**
	 * clone object or array in order to keep original source Object.
	 */
	public static function cloneObj($obj) {
		if (isset ( $obj )) {
			if (is_object ( $obj )) {
				return clone $obj;
			} else if (is_array ( $obj )) {
				$arrObject = new \ArrayObject ( $obj );
				return $arrObject->getArrayCopy ();
			} else {
				return $obj;
			}
		} else {
			return $obj;
		}
	}
	public static function copyProperties($source, $destination) {
		if (! isset ( $source ) || ! isset ( $destination ))
			return;
		
		$reflect = new \ReflectionClass ( $source );
		$props = $reflect->getProperties ( \ReflectionProperty::IS_PUBLIC );
		$propMap = array ();
		foreach ( $props as $prop ) {
			$propMap [strtolower ( $prop->getName () )] = $prop;
		}
		
		$reflect = new \ReflectionClass ( $destination );
		$props = $reflect->getProperties ( \ReflectionProperty::IS_PUBLIC );
		
		foreach ( $props as $prop ) {
			if (isset ( $propMap [strtolower ( $prop->getName () )] )) {
				$prop->setValue ( $destination, $propMap [strtolower ( $prop->getName () )]->getValue ( $source ) );
			}
		}
	}
	public static function defaultIfEmpty($var, $default = '') {
		return (! isset ( $var ) || is_null ( $var ) || empty ( $var )) ? $default : $var;
	}
	public static function arrayValue($array, $key, $default = null) {
		if (isset ( $array ) && isset ( $key ) && isset ( $array [$key] )) {
			return $array [$key];
		} else {
			return $default;
		}
	}
	public static function mapFromArray($array = array(), $keyColumn) {
		$map = array ();
		if (empty ( $array ) || count ( $array ) == 0) {
			return $map;
		}
		foreach ( $array as $item ) {
			$map [$item->$keyColumn] = $item;
		}
		return $map;
	}
	public static function getFullUrl($use_forwarded_host = false) {
		$s = $_SERVER;
		$ssl = (! empty ( $s ['HTTPS'] ) && $s ['HTTPS'] == 'on');
		$sp = strtolower ( $s ['SERVER_PROTOCOL'] );
		$protocol = substr ( $sp, 0, strpos ( $sp, '/' ) ) . (($ssl) ? 's' : '');
		$port = $s ['SERVER_PORT'];
		$port = ((! $ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
		$host = ($use_forwarded_host && isset ( $s ['HTTP_X_FORWARDED_HOST'] )) ? $s ['HTTP_X_FORWARDED_HOST'] : (isset ( $s ['HTTP_HOST'] ) ? $s ['HTTP_HOST'] : null);
		$host = isset ( $host ) ? $host : $s ['SERVER_HOST'] . $port;
		return $protocol . '://' . $host . $s ['REQUEST_URI'];
	}
	public static function cleanName($string) {
		return StringUtil::makeSlugs($string);

		$string = str_replace ( ' ', '-', $string ); // Replaces all spaces with hyphens.
		$string = preg_replace ( '/[^A-Za-z0-9\-]/', '', $string ); // Removes special chars.
		return strtolower ( preg_replace ( '/-+/', '-', $string ) ); // Replaces multiple hyphens with single one.
	}
	public static function appendQuery(&$link, $query) {
		if (! AppUtil::isEmptyString ( $query )) {
			if (strpos ( $link, '?' ) !== false) {
				$link .= "&" . $query;
			} else {
				$link .= "?" . $query;
			}
		}
	}
	public static function perfectCopyProperties($source, &$dest) {
		// Get property values of source object.
		$srcPropMap = array ();
		foreach ( get_object_vars ( $source ) as $srcKey => $srcValue ) {
			$srcPropMap [$srcKey] = $srcValue;
		}
		// Copy to destination object.
		foreach ( get_object_vars ( $dest ) as $destKey => $destValue ) {
			if (isset ( $srcPropMap [$destKey] )) {
				$dest->$destKey = $srcPropMap [$destKey];
			}
		}
	}
	public static function generateCartTxnId($cartId) {
		$strTxnId = $cartId;
		if (! is_numeric ( $strTxnId )) {
			$strTxnId = 1;
		}
		
		if ($strTxnId < 1) {
			$strTxnId = 1;
		}
		
		while ( strlen ( $strTxnId ) < 7 ) {
			$strTxnId = "0" . $strTxnId;
		}
		$strTxnId = "T" . date ( "ym" ) . $strTxnId;
		return $strTxnId;
	}
	public static function getCartIdFromTxnId($txnId) {
		if (strlen ( $txnId ) > 5) {
			return intval ( substr ( $txnId, 5 ) );
		}
	}
	public static function formatNumber($number, $symbol, $decimals = 0, $dec_point = ".", $thousands_sep = ",") {
		return $symbol . number_format ( $number, $decimals, $dec_point, $thousands_sep );
	}
}