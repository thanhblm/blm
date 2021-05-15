<?php

namespace common\utils;

class DateUtil {
	const DATE_FORMAT = 'Y-m-d';
	const TIME_FORMAT = 'H:i:s';
	const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
	const EMPTY_DATE = '0000-00-00';
	const EMPTY_TIME = '00:00:00';
	const EMPTY_DATE_TIME = '0000-00-00 00:00:00';
	public static function getCurrentDT() {
		return date ( self::DATE_TIME_FORMAT );
	}
	public static function getCurrentDate() {
		return date ( self::DATE_FORMAT );
	}
	public static function getCurrentTime() {
		return date ( self::TIME_FORMAT );
	}
	public static function dateAdjust($params) {
		return self::dateAdjustByTime ( time (), $params );
	}
	public static function dateAdjustByTime($time, $params, $format = self::DATE_TIME_FORMAT) {
		$sec = 0;
		if (! empty ( $params ['year'] ))
			$sec += ($params ['month'] * 60 * 60 * 24 * 365);
		if (! empty ( $params ['month'] ))
			$sec += ($params ['month'] * 60 * 60 * 24 * 30);
		if (! empty ( $params ['day'] ))
			$sec += ($params ['day'] * 60 * 60 * 24);
		if (! empty ( $params ['hour'] ))
			$sec += ($params ['hour'] * 60 * 60);
		if (! empty ( $params ['min'] ))
			$sec += ($params ['min'] * 60);
		if (! empty ( $params ['sec'] ))
			$sec += $params ['sec'];
		return date ( $format, $time + $sec );
	}
	public static function formatDateTimeToDate($dt) {
		$date = substr ( $dt, 0, 10 );
		return $date;
	}
	public static function getEmptyDt() {
		return self::EMPTY_DATE_TIME;
	}
	public static function convertDateTimeToTimestamp($date) {
		// Date format 2015-01-01 12:00:00 example
		list ( $year, $month, $day, $hour, $minute, $sec ) = split ( '[- :]', $date );
		
		// The variables should be arranged according to your date format and so the separators
		return mktime ( $hour, $minute, $sec, $month, $day, $year );
	}
}