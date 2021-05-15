<?php

namespace common\utils;

use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;

class StringUtil{
	/**
	 * sample camelCase::camelCase (error convert all to strtolower)
	 * input image_url -> ouput: imageUrl
	 *
	 * @param string $str
	 * @return string
	 */
	public static function camelCase($str){
		$arr = explode("_", $str);
		// $first = strtolower ( $arr [0] );
		$first = trim($arr [0]);
		$result = $first;
		for ($i = 1; $i < count($arr); $i++) {
			$result .= ucfirst($arr [$i]);
		}
		return $result;
	}

	/*
	 * If value empty to null
	 * else trim him
	 */
	public static function clearObject($object){
		if (gettype($object) == "object") {
			$objInfo = get_object_vars($object);
			foreach ($objInfo as $key => $val) {
				if (AppUtil::isEmptyString($val)) {
					$object->$key = null;
				} else {
					$object->$key = trim($val);
				}
			}
			return $object;
		} else {
			throw new \Exception ("[$object] is not object !");
		}
	}

	public static function validName($str){
		return true;
		//! preg_match ( '/[^ _()A-Za-z0-9.#\\-$]/', $strNew);

	}

	public static function validUserName($str){
		return !preg_match('/[^A-Za-z0-9.#\\-$]/', $str);
	}

	public static function validPhone($str){
		$re = '/^\+?+[\d ]+$/';
		return preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
		//return !AppUtil::isEmptyString($str);
// 		$regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
// 		return preg_match ( $regex, $str );
	}

	/**
	 *
	 * @param unknown $listObject
	 *            EX: listUserGroupVo
	 * @param unknown $keyElement
	 *            is property of Object EX: permissionActionCode
	 * @param unknown $valueElement
	 *            is value of permissionActionCode using compare EX: "user_add"
	 * @return unknown|array is array child
	 */
	public static function groupListObject($listObject, $keyElement, $valueElement){
		if (!is_array($listObject)) {
			return Lang::get("Array input requied!");
		}
		if (gettype($listObject [0]) != "object") {
			return Lang::get("Array Object input requied!");
		}
		$listObjectChild = array();
		foreach ($listObject as $object) {
			if ($valueElement == $object->$keyElement) {
				array_push($listObjectChild, $object);
			}
		}
		return $listObjectChild;
	}

	public static function stringPadLeft($value, $character, $count = 3){
		return str_pad($value, $count, $character, STR_PAD_LEFT);
	}

	public static function encrypt($pure_string, $encryption_key = null){
		try {
			if (AppUtil::isEmptyString($encryption_key)) {
				$encryption_key = AppUtil::defaultIfEmpty(ApplicationConfig::get("session.prefix"), "dato");
			}
			$encryption_key = base64_decode($encryption_key);
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
			$encrypted = openssl_encrypt($pure_string, 'aes-256-cbc', $encryption_key, 0, $iv);
			return base64_encode($encrypted . '::' . $iv);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public static function decrypt($encrypted_string, $encryption_key = null){
		try {
			if (AppUtil::isEmptyString($encryption_key)) {
				$encryption_key = AppUtil::defaultIfEmpty(ApplicationConfig::get("session.prefix"), "dato");
			}
			$encryption_key = base64_decode($encryption_key);
			list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_string), 2);
			return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
		} catch (\Exception $e) {
			throw $e;
		}

	}

	public static function calculatePerPrice($per, $price){
		return number_format(floatval(($per * $price) / 100), 2, ".", "");
	}

	/**
	 * *
	 *
	 * @param unknown $arrayObj
	 * @param unknown $objectFilter
	 * @param unknown $objectValue
	 * @throws \Exception
	 * @return $arrayObj with new value
	 */
	public static function updateObjInArayByFilter($arrayObj, $objectFilter, $objectValue){
		if ("object" != gettype($objectValue)) {
			throw new \Exception ("[$objectValue] is not object !");
		}
		if ("object" != gettype($objectFilter)) {
			throw new \Exception ("[$objectFilter] is not object !");
		}
		if (get_class($objectFilter) !== get_class($objectValue)) {
			throw new \Exception ("[$objectFilter] required same type [$objectValue]");
		}

		$objFilterInfo = get_object_vars($objectFilter);
		$objValueInfo = get_object_vars($objectFilter);

		foreach ($arrayObj as $object) {
			$objInfo = get_object_vars($object);
			$isTrue = false;
			foreach ($objFilterInfo as $key => $val) {
				foreach ($objInfo as $keyObj => $valObj) {
					if (!AppUtil::isEmptyString($val) && $key == $keyObj && $val == $valObj) {
						$isTrue = true;
					} else {
						$isTrue = false;
					}
				}
			}
			if ($isTrue) {
				$object = $objectValue;
			}
		}
		return $arrayObj;
	}

	public static function sumElementInArrayObj($array, $columnSum){
		$total = 0;
		foreach ($array as $object) {
			$total = ($total + AppUtil::defaultIfEmpty($object->$columnSum, 0));
		}
		return $total;
	}

	public static function findEmailOrderHistory($string){
		foreach (preg_split('/&lt;/', $string) as $token) {
			$token = str_replace("&gt;<br>To: Endoca", "", $token);
			$email = filter_var($token, FILTER_VALIDATE_EMAIL);
			if ($email != false) {
				return $email;
			}
		}
		return null;
	}

	public static function findNameOrderHistory($string){
		try {
			return preg_split('/&lt;/', preg_split('/From: /', $string)[1])[0];
		} catch (\Exception $e) {
			return "";
		}
	}

	public static function loadViewCheckoutMethod($id){
		if (AppUtil::isEmptyString($id)) {
			return "methods/not_found_view_method_data.php";
		}
		$name = "";
		switch ($id) {
			case 1:
				$name = "Zone Table";
				break;
			case 2:
				$name = "Flat Rate";
				break;
		}
		$name = strtolower(trim($name));
		$name = str_replace(" ", "_", $name);
		return "methods/" . $name . "/" . $name . "_data.php";
	}

	public static function loadShippingMethodName($shippingMethodInfo, $shippingMethodId){
		if (isset($shippingMethodInfo)) {
			$methodName = "";
			switch ($shippingMethodId) {
				case 1: // Zone table
					if (isset($shippingMethodInfo->methodTitle)) {
						$methodName = $shippingMethodInfo->methodTitle;
					}
					break;
				case 2: // Flat Rate
					if (isset($shippingMethodInfo->name)) {
						$methodName = $shippingMethodInfo->name;
					}
					break;
			}
			return $methodName;
		}
	}

	public static function getContentLineByKeyword($string, $keyword){
		$str_tmp = explode($keyword, $string)[1];
		return str_replace('";', "", str_replace('="', "", explode("\n", $str_tmp)[0]));
	}

	public static function getContentLineByKeywordJsonV($string, $keyword){
		$str_tmp = explode($keyword, $string)[1];
		return str_replace(';', "", str_replace('=', "", explode("];", $str_tmp)[0])) . "]";
	}

	public static function getContentLineByKeywordJsonN($string, $keyword){
		$str_tmp = explode($keyword, $string)[1];
		return str_replace(';', "", str_replace('=', "", explode("};", $str_tmp)[0])) . "}";
	}

	public static function getContentByTagName($string, $tagName){
		$str_tmp = explode("<" . $tagName . ">", $string)[1];
		return explode("</" . $tagName . ">", $str_tmp)[0];
	}

	public static function getContentByTagFullName($string, $contentTag, $tagName){
		$str_tmp = explode("<" . $contentTag . ">", $string)[1];
		return explode("</" . $tagName . ">", $str_tmp)[0];
	}

	public static function getContentByTagEndStart($string, $startTag, $endTag){
		$str_tmp = explode($startTag, $string)[1];
		return explode($endTag, $str_tmp)[0];
	}

	public static function getContentByMeta($string, $metaName){
		$str_tmp = explode('<meta name="' . $metaName . '" content="', $string)[1];
		return explode(" />", $str_tmp)[0];
	}

	public static function slugify($text){
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	/**
	 * @param $array
	 * @param bool $isAll if($isAll) get All Franchise when $array Empty
	 * @return string
	 */
	public static function convertArrayToStringForSelectIn($array, $isAll = false){
		if ($isAll && empty($array)) {
			return "";
		}
		$listId = implode($array, ",");
		if (AppUtil::isEmptyString($listId)) {
			$listId = "''";
		}
		return "(" . $listId . ")";
	}

	public static function normalize($str){
		$str = str_replace(" ", "", $str);
		$str = strtolower($str);
		return $str;
	}

	public static function removeCData($string){
		$pattern = '/\<\!\[CDATA\[(((?!\<\!\[CDATA\[).)*)\]\]\>/';
		$replacement = '${1}';
		return preg_replace($pattern, $replacement, $string);
	}

	public static function escapeSpecialChars($str){
		return htmlspecialchars($str, ENT_QUOTES, "utf-8");
	}


	public static function myStrSplit($string){
		$slen = strlen($string);
		$sArray = array();
		for ($i = 0; $i < $slen; $i++) {
			$sArray[$i] = $string{$i};
		}
		return $sArray;
	}

	public static function noDiacritics($string){
		//cyrylic transcription
		$cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$cyrylicTo = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia');


		$from = array("ự","Ự","ấ","Ấ","ă","Ă","ạ","Ạ","ờ","Ờ","ẻ","Ẻ","ầ","Ầ","đ","Đ","ỗ","Ỗ", "Á", "À", "Â", "Ä", "A", "A", "Ã", "Å", "A", "Æ", "C", "C", "C", "C", "Ç", "D", "Ð", "Ð", "É", "È", "E", "Ê", "Ë", "E", "E", "E", "?", "G", "G", "G", "G", "á", "à", "â", "ä", "a", "a", "ã", "å", "a", "æ", "c", "c", "c", "c", "ç", "d", "d", "ð", "é", "è", "e", "ê", "ë", "e", "e", "e", "?", "g", "g", "g", "g", "H", "H", "I", "Í", "Ì", "I", "Î", "Ï", "I", "I", "?", "J", "K", "L", "L", "N", "N", "Ñ", "N", "Ó", "Ò", "Ô", "Ö", "Õ", "O", "Ø", "O", "Œ", "h", "h", "i", "í", "ì", "i", "î", "ï", "i", "i", "?", "j", "k", "l", "l", "n", "n", "ñ", "n", "ó", "ò", "ô", "ö", "õ", "o", "ø", "o", "œ", "R", "R", "S", "S", "Š", "S", "T", "T", "Þ", "Ú", "Ù", "Û", "Ü", "U", "U", "U", "U", "U", "U", "W", "Ý", "Y", "Ÿ", "Z", "Z", "Ž", "r", "r", "s", "s", "š", "s", "ß", "t", "t", "þ", "ú", "ù", "û", "ü", "u", "u", "u", "u", "u", "u", "w", "ý", "y", "ÿ", "z", "z", "ž");
		$to = array("u","U","a","A","a","A","a","A","o","O","e","E","a","A","d","D","o","O","A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


		$aPatterns = array (
			"a" => "á|à|ạ|ả|ã|ă|ắ|ằ|ặ|ẳ|ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Á|À|Ạ|Ả|Ã|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ",
			"o" => "ó|ò|ọ|ỏ|õ|ô|ố|ồ|ộ|ổ|ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ó|Ò|Ọ|Ỏ|Õ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ",
			"e" => "é|è|ẹ|ẻ|ẽ|ê|ế|ề|ệ|ể|ễ|É|È|Ẹ|Ẻ|Ẽ|Ê|Ế|Ề|Ệ|Ể|Ễ",
			"u" => "ú|ù|ụ|ủ|ũ|ư|ứ|ừ|ự|ử|ữ|Ú|Ù|Ụ|Ủ|Ũ|Ư|Ứ|Ừ|Ự|Ử|Ữ",
			"i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ",
			"y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ",
			"d" => "đ|Đ",
		);
		$fromArray = array();
		$toArray = array();
		foreach ($aPatterns as $to=>$froms){
			$fromArrays = explode("|", $froms);
			foreach ($fromArrays as $from){
				array_push($fromArray, $from);
				array_push($toArray, $to);
			}
		}
		$newstring = str_replace($fromArray, $toArray, $string);
		return $newstring;
	}

	public static function makeSlugs($string, $maxlen = 0){
		$newStringTab = array();
		$string = strtolower(self::noDiacritics($string));
		if (function_exists('str_split')) {
			$stringTab = str_split($string);
		} else {
			$stringTab = self::myStrSplit($string);
		}

		$numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-");

		foreach ($stringTab as $letter) {
			if (in_array($letter, range("a", "z")) || in_array($letter, $numbers)) {
				$newStringTab[] = $letter;
			} elseif ($letter == " ") {
				$newStringTab[] = "-";
			}
		}

		if (count($newStringTab)) {
			$newString = implode($newStringTab);
			if ($maxlen > 0) {
				$newString = substr($newString, 0, $maxlen);
			}

			$newString = self::removeDuplicates('--', '-', $newString);
		} else {
			$newString = '';
		}

		return $newString;
	}


	public static function checkSlug($sSlug){
		if (preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9\-]*$/", $sSlug) == 1) {
			return true;
		}

		return false;
	}

	public static function removeDuplicates($sSearch, $sReplace, $sSubject){
		$i = 0;
		do {

			$sSubject = str_replace($sSearch, $sReplace, $sSubject);
			$pos = strpos($sSubject, $sSearch);

			$i++;
			if ($i > 100) {
				die('removeDuplicates() loop error');
			}

		} while ($pos !== false);

		return $sSubject;
	}
}