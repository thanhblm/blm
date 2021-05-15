<?php
namespace common\config;
abstract class BaseEnum {
	public static function getName($value) {
		$name = null;
		$contants = self::getConstants ();
		foreach ( $contants as $key => $val ) {
			if ($val == $value) {
				$name = $key;
				break;
			}
		}
		return $name;
	}
	public static function getConstants() {
		$oClass = new ReflectionClass ( get_called_class () );
		return $oClass->getConstants ();
	}
}