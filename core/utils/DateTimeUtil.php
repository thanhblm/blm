<?php

namespace core\utils;

use core\config\ApplicationConfig;
use common\helper\SettingHelper;

class DateTimeUtil {
	public static function mySqlStringDate2String($mysqlDateStr, $format) {
		if (is_null ( $mysqlDateStr ) || trim ( $mysqlDateStr ) == '' || "0000-00-00 00:00:00" == trim ( $mysqlDateStr )) {
			return null;
		}
		$d = date_create_from_format ( 'Y-m-d H:i:s', $mysqlDateStr );
		if (false === $d) {
			throw new \Exception ( "Invalid date" );
		}
		$str = $d->format ( $format );
		return (false != $str) ? $str : null;
	}
	public static function mySqlStringDate2Date($mysqlDateStr) {
		if (is_null ( $mysqlDateStr ) || trim ( $mysqlDateStr ) == '' || "0000-00-00 00:00:00" == trim ( $mysqlDateStr )) {
			return null;
		}
		$d = date_create_from_format ( 'Y-m-d H:i:s', $mysqlDateStr );
		if (false === $d) {
			throw new \Exception ( "Invalid date" );
		}
		return $d;
	}
	public static function string2MySqlDate($str, $format) {
		if (is_null ( $str ) || trim ( $str ) == '') {
			return null;
		}
		$d = date_create_from_format ( $format, $str );
		if (false === $d) {
			throw new \Exception ( "Invalid date" );
		}
		$str = $d->format ( "Y-m-d H:i:s" );
		return (false != $str) ? $str : null;
	}
	public static function getDateFormat() {
		$format = SettingHelper::getSettingValue ( "Date format" );
		$format = is_null ( $format ) ? ApplicationConfig::get ( "Date format" ) : $format;
		$format = is_null ( $format ) ? "d-m-Y" : $format;
		return $format;
	}
	public static function getDateTimeFormat() {
		$format = SettingHelper::getSettingValue ( "Date time format" );
		$format = is_null ( $format ) ? ApplicationConfig::get ( "Date time format" ) : $format;
		$format = is_null ( $format ) ? "d-m-Y H:i:s" : $format;
		return $format;
	}
	public static function getDatePickerFormat() {
		$format = SettingHelper::getSettingValue ( "Date picker format" );
		$format = is_null ( $format ) ? ApplicationConfig::get ( "Date picker format" ) : $format;
		$format = is_null ( $format ) ? "dd-mm-yyyy" : $format;
		return $format;
	}
	public static function appendTime($str, $isFirstDay = true) {
		if (! is_null ( $str ) && trim ( $str ) != '') {
			$str .= $isFirstDay ? " 00:00:00" : " 23:59:59";
		}
		return $str;
	}
}