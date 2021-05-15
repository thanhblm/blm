<?php

namespace core\common;

use core\BaseArray;
use core\utils\AppUtil;

class JsonDeserializer {
	public function deserialize($json) {
		if (AppUtil::isEmptyString ( $json )) {
			return null;
		}
		$object = json_decode ( $json );
		if (is_array ( $object )) {
			return $this->deserializeArray ( $object );
		}
		return $this->deserializeObject ( $object );
	}
	private function getClassProperties($object) {
		return get_object_vars ( $object );
	}
	private function deserializeObject($object) {
		if (is_null ( $object )) {
			return null;
		}
		$properties = $this->getClassProperties ( $object );
		$result = new \stdClass ();
		foreach ( $properties as $property => $value ) {
			if (is_array ( $object->$property )) {
				$result->$property = $this->deserializeArray ( $value );
			} elseif (is_object ( $object->$property )) {
				$result->$property = $this->deserializeBaseArray ( $value );
			} else {
				$result->$property = $value;
			}
		}
		return $result;
	}
	private function deserializeBaseArray($array) {
		$properties = $this->getClassProperties ( $array );
		if (2 == count ( $properties ) && key_exists ( "type", $properties ) && key_exists ( "elements", $properties )) {
			$elementType = str_replace ( "\/", "\\", $array->type );
			$baseArray = new BaseArray ( $elementType );
			foreach ( $array->elements as $element ) {
				$item = new $elementType ();
				// Get property values of source object.
				$srcPropMap = array ();
				foreach ( get_object_vars ( $element ) as $srcKey => $srcValue ) {
					$srcPropMap [$srcKey] = $srcValue;
				}
				// Copy to destination object.
				foreach ( get_object_vars ( $item ) as $destKey => $destValue ) {
					if (isset ( $srcPropMap [$destKey] )) {
						$item->$destKey = $srcPropMap [$destKey];
					}
				}
				$baseArray->add ( $item );
			}
			return $baseArray;
		}
		return $array;
	}
	private function deserializeArray($array) {
		$result = array ();
		foreach ( $array as $key => $value ) {
			$result [$key] = $this->deserializeObject ( $value );
		}
		return $result;
	}
}