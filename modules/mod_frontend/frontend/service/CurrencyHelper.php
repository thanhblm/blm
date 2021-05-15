<?php

namespace frontend\service;

class CurrencyHelper {
	public static function getCurrencyFormat($amt) {
		return number_format ( $amt, 2 );
	}
	public static function getDoubleFormat($amt) {
		return ereg_replace ( "[^0-9.]", "", self::getCurrencyFormat ( $amt ) );
		;
	}
}