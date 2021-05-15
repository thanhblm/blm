<?php
namespace frontend\service;
use core\Lang;

class SelectHelper {
	public static function getCCTypeArr() {
		$arr = array (
				'' => Lang::get('Select Type'),
				'visa' => Lang::get('VISA'),
				'mastercard' => Lang::get('Master Card'),
				'discover' => Lang::get('Discover'),
				'amex' => Lang::get('Amex') 
		)
		;
		return $arr;
	}
	public static function getCCMonthArr() {
		$arr = array (
				'' => Lang::get('Select Month'),
				'01' => Lang::get('1 - January'),
				'02' => Lang::get('2 - February'),
				'03' => Lang::get('3 - March'),
				'04' => Lang::get('4 - April'),
				'05' => Lang::get('5 - May'),
				'06' => Lang::get('6 - June'),
				'07' => Lang::get('7 - July'),
				'08' => Lang::get('8 - August'),
				'09' => Lang::get('9 - September'),
				'10' => Lang::get('10 - October'),
				'11' => Lang::get('11 - November'),
				'12' => Lang::get('12 - December') 
		);
		return $arr;
	}
	public static function getCCYearArr() {
		$arr = array ();
		$year = date ( 'Y' );
		$arr [''] = Lang::get('Select Year');
		for($x = 0; $x < 10; $x ++) {
			$arr [$year] = $year;
			$year ++;
		}
		return $arr;
	}
}