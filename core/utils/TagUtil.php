<?php

namespace core\utils;

class TagUtil {
	private static function getReplaceMap($tags) {
		$replaceMap = array ();
		$tagArr = explode ( ";", $tags );
		if (empty ( $tagArr )) {
			return $replaceMap;
		}
		foreach ( $tagArr as $tag ) {
			$arr = explode ( ":", $tag );
			if (2 !== count ( $arr )) {
				throw \Exception ( "Invalid tags" );
			}
			$replaceMap [$arr [0]] = $arr [1];
		}
		return $replaceMap;
	}
	public static function replaceTags($string, $tags, $object, $keyIsField = false) {
		$result = $string;
		$replaceMap = self::getReplaceMap ( $tags );
		foreach ( $replaceMap as $key => $value ) {
			$objectField = $keyIsField ? AppUtil::camelCase ( $key ) : $value;
			if (property_exists ( $object, $objectField )) {
				$result = str_replace ( "$(" . $key . ")", $object->$objectField, $result );
			}
		}
		return $result;
	}
}