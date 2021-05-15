<?php

namespace common\helper;

class AddressHelper {
	// public static function isPOBoxAddress($add) {
	// $pattern1 = '/[post.]{2,5}+[ofice. ]{1,8}+[box. ]{3,4}+[#\d]/i';
	// $pattern2 = '/[po.]{2}+[of. ]{1}+[box. ]{1,}+[#\d]/i';
	// $pattern3 = '/[p]{1}+[o ]{1}+[box. ]{1,4}+[#\d]/i';
	// $isMatch = preg_match ( $pattern1, $add ) || preg_match ( $pattern2, $add ) || preg_match ( $pattern3, $add );
	// return $isMatch;
	// }
	public static function isPOBoxAddress($add) {
		$strAdd = preg_replace ( "/[^a-z0-9 ]/i", "", $add );
		
		$pattern1 = '/^\s*(po|post)[\s#\d]/i';
		$pattern2 = '/^\s*(p\s+off|off|office)[\s#\d]/i';
		$pattern3 = '/^\s*(box|bin)[\s#\d]/i';
		$pattern4 = '/\s*o\s*b(ox|in)?\s*#?\d/i';
		// $pattern5 = '/[post ]{2,4}+[ofice ]{2,6}+[box ]{0,3}+[#\d]/i';
		// $pattern6 = '/[po]{2}+[of]{1}+[box]{1,}+[#\d]/i';
		$isMatch = preg_match ( $pattern1, $strAdd ) || preg_match ( $pattern2, $strAdd ) || preg_match ( $pattern3, $strAdd ) || preg_match ( $pattern4, $strAdd );
		
		return $isMatch;
	}
	/*
	 * example : AddressHelper::getWashingtonTax("6500 Linderson way", "aa", 985011001);
	 * return : array
	 * "status"=>false/true : ok or not ok 
	 * "rate"=>-1, //rate
	 * "code"=>500,//api code
	 * "message"=>"Internal error"// message
	 *
	 */
	public static function getWashingtonTax($addressStr, $city, $postalCode) {
		$result = array (
				"status" => false,
				"rate" => - 1,
				"code" => 500,
				"message" => "Internal error" 
		);
		$url = "http://dor.wa.gov/AddressRates.aspx?output=text&addr=" . urlencode ( $addressStr ) . "&city=" . urlencode ( $city ) . "&zip=" . urlencode ( $postalCode );
		\DatoLogUtil::info ( "Washington Tax URL:" . $url );
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$httpResult = curl_exec ( $ch );
		$httpcode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		curl_close ( $ch );
		
		if ($httpcode != "200") {
			$result ["code"] = $httpcode;
			\DatoLogUtil::info ( "Washington Tax Result:" . json_encode ( $result ) );
			return $result;
		}
		$elements = explode ( " ", $httpResult );
		
		foreach ( $elements as $element ) {
			$values = explode ( "=", $element );
			if (count ( $values ) > 1) {
				switch ($values [0]) {
					case "ResultCode" :
						$result ["code"] = $values [1];
						switch ($result ["code"]) {
							case 0 :
								$result ["message"] = "The address was found.";
								break;
							case 1 :
								$result ["message"] = "The address was not found, but the ZIP+4 was  located.";
								break;
							case 2 :
								$result ["message"] = "Neither the address or ZIP+4 was found, but  the 5-digit ZIP was located.";
								break;
							case 3 :
								$result ["message"] = "The address, ZIP+4, and ZIP could not be  found.";
								break;
							case 4 :
								$result ["message"] = "Invalid arguements.";
								break;
							case 5 :
								$result ["message"] = "Internal error.";
								break;
							default :
								$result ["message"] = "";
								break;
						}
						break;
					case "Rate" :
						$result ["rate"] = $values [1];
						if ($values [1] > 0) {
							$result ["status"] = true;
						}
						break;
					default :
						break;
				}
			}
		}
		\DatoLogUtil::info ( "Washington Tax Result:" . json_encode ( $result ) );
		return $result;
	}
}