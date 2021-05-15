<?php

namespace frontend\service;

class CreditCardHelper {
	private static $maskChar = '*';
	public static function maskCCNumber($ccNumber) {
		$maskedCCNumber = null;
		$card_length = strlen ( $ccNumber );
		$maskedCCNumber = substr ( $ccNumber, 0, 4 ) . str_pad ( '', $card_length - 8, self::$maskChar ) . substr ( $ccNumber, - 4 );
		
		return $maskedCCNumber;
	}
	public static function maskCCCode($code) {
		$strLen = strlen ( $code );
		return str_pad ( '', $strLen, self::$maskChar );
	}
	public static function maskCCNumberInContent($string) {
		$regex = '/(?:\d[ \t-]*?){13,19}/m';
		
		$matches = [ ];
		
		preg_match_all ( $regex, $string, $matches );
		
		// No credit card found
		if (! isset ( $matches [0] ) || empty ( $matches [0] )) {
// 			\DatoLogUtil::debug ( $string );
			return $string;
		}
		
		foreach ( $matches as $match_group ) {
			foreach ( $match_group as $match ) {
				$stripped_match = preg_replace ( '/[^\d]/', '', $match );
				
				// Is it a valid Luhn one?
				if (false === self::isLuhn ( $stripped_match )) {
					continue;
				}
				
				$replacement = self::maskCCNumber ( $stripped_match );
				
				// If so, replace the match
				$string = str_replace ( $match, $replacement, $string );
			}
		}
// 		\DatoLogUtil::debug ( $string );
		return $string;
	}
	private static function isLuhn($input) {
		if (! is_numeric ( $input )) {
			return false;
		}
		
		$numeric_string = ( string ) preg_replace ( '/\D/', '', $input );
		
		$sum = 0;
		
		$numDigits = strlen ( $numeric_string ) - 1;
		
		$parity = $numDigits % 2;
		
		for($i = $numDigits; $i >= 0; $i --) {
			$digit = substr ( $numeric_string, $i, 1 );
			
			if (! $parity == ($i % 2)) {
				$digit <<= 1;
			}
			
			$digit = ($digit > 9) ? ($digit - 9) : $digit;
			
			$sum += $digit;
		}
		
		return (0 == ($sum % 10));
	}
}