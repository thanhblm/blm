<?php

namespace core\utils;

class RequestUtil {
	public static function get($key) {
		return isset ( $_REQUEST [$key] ) ? $_REQUEST [$key] : null;
	}
	public static function set($key, $value) {
		$_REQUEST [$key] = $value;
	}
	public static function hasErrors() {
		return self::hasFieldErrors () || self::hasActionErrors ();
	}
	public static function hasFieldErrors() {
		if (! isset ( $_REQUEST [CTX] [FIELD_ERRORS] )) {
			return false;
		}
		return count ( $_REQUEST [CTX] [FIELD_ERRORS] ) > 0;
	}
	public static function hasActionErrors() {
		if (! isset ( $_REQUEST [CTX] [ACTION_ERRORS] )) {
			return false;
		}
		return count ( $_REQUEST [CTX] [ACTION_ERRORS] ) > 0;
	}
	public static function hasActionMessages() {
		if (! isset ( $_REQUEST [CTX] [ACTION_MESSAGES] )) {
			return false;
		}
		return count ( $_REQUEST [CTX] [ACTION_MESSAGES] ) > 0;
	}
	public static function getFieldError($fieldName) {
		if (! isset ( $_REQUEST [CTX] [FIELD_ERRORS] ) || ! isset ( $_REQUEST [CTX] [FIELD_ERRORS] [$fieldName] ) || count ( $_REQUEST [CTX] [FIELD_ERRORS] [$fieldName] ) == 0) {
			return null;
		}
		return self::getFieldErrorMessage ( $_REQUEST [CTX] [FIELD_ERRORS] [$fieldName] );
	}
	public static function getFieldErrors() {
		if (! isset ( $_REQUEST [CTX] [FIELD_ERRORS] ) || count ( $_REQUEST [CTX] [FIELD_ERRORS] ) == 0) {
			return "";
		}
		$result = "";
		$count = 0;
		$size = count ( $_REQUEST [CTX] [FIELD_ERRORS] );
		foreach ( $_REQUEST [CTX] [FIELD_ERRORS] as $fieldName => $fieldErrors ) {
			if ($count == $size) {
				$result .= self::getFieldErrorMessage ( $fieldErrors );
			} else {
				$result .= self::getFieldErrorMessage ( $fieldErrors ) . "\n";
			}
		}
		return $result;
	}
	private static function getFieldErrorMessage($errors) {
		if (! isset ( $errors ) || count ( $errors ) == 0) {
			return "";
		}
		$count = 0;
		$size = count ( $errors );
		$result = "";
		foreach ( $errors as $error ) {
			$count ++;
			if ($count == $size) {
				$result .= $error;
			} else {
				$result .= $error . "\n";
			}
		}
		return $result;
	}
	public static function getErrorMessage() {
		if (! isset ( $_REQUEST [CTX] [ACTION_ERRORS] )) {
			return null;
		}
		$result = "";
		$count = 0;
		$size = count ( $_REQUEST [CTX] [ACTION_ERRORS] );
		if ($size == 0) {
			return null;
		}
		foreach ( $_REQUEST [CTX] [ACTION_ERRORS] as $error ) {
			if ($count == $size) {
				$result .= $error;
			} else {
				$result .= $error . "\n";
			}
		}
		return $result;
	}
	public static function getActionMessage() {
		if (! isset ( $_REQUEST [CTX] [ACTION_MESSAGES] )) {
			return null;
		}
		$result = "";
		$count = 0;
		$size = count ( $_REQUEST [CTX] [ACTION_MESSAGES] );
		if ($size == 0) {
			return null;
		}
		foreach ( $_REQUEST [CTX] [ACTION_MESSAGES] as $error ) {
			if ($count == $size) {
				$result .= $error;
			} else {
				$result .= $error . "\n";
			}
		}
		return $result;
	}
	public static function getMethod() {
		return $_SERVER ['REQUEST_METHOD'];
	}
	public static function isPost() {
		return "POST" == $_SERVER ['REQUEST_METHOD'];
	}
	public static function isGet() {
		return "GET" == $_SERVER ['REQUEST_METHOD'];
	}
	public static function isPut() {
		return "PUT" == $_SERVER ['REQUEST_METHOD'];
	}
	public static function isDelete() {
		return "DELETE" == $_SERVER ['REQUEST_METHOD'];
	}
	public static function isPostBack() {
		return ! isset ( $_POST );
	}
	public static function isFieldError($field) {
		return ! AppUtil::isEmptyString ( self::getFieldError ( $field ) );
	}
}