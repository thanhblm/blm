<?php

namespace core\utils;

use core\common\JsonDeserializer;
use core\common\JsonSerializer;

class JsonUtil {
	public static function encode($object) {
		$jsonSerializer = new JsonSerializer ();
		return $jsonSerializer->serialize ( $object );
	}
	public static function decode($str) {
		$jsonDeserializer = new JsonDeserializer ();
		return $jsonDeserializer->deserialize ( $str );
	}
	public static function base64Encode($object) {
		return base64_encode ( self::encode ( $object ) );
	}
	public static function base64Decode($str) {
		return self::decode ( base64_decode ( $str ) );
	}
	public static function isBase64($str) {
		$isBase64 = false;
		if (base64_encode ( base64_decode ( $str ) ) === $str) {
			$isBase64 = true;
		}
		return;
	}
}