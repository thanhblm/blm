<?php

namespace core\common;

use core\BaseArray;

class JsonSerializer {
	public function serialize($object) {
		return json_encode ( $this->serializeInternal ( $object ) );
	}
	private function serializeInternal($object) {
		if (is_array ( $object )) {
			$result = $this->serializeArray ( $object );
		} elseif (is_object ( $object )) {
			if (get_class ( $object ) === BaseArray::class) {
				$data = array ();
				$data ["type"] = str_replace ( "\\", "\/", $object->getType () );
				$data ["elements"] = $this->serializeArray ( $object->getArray () );
				$result = $data;
			} else {
				$result = $this->serializeObject ( $object );
			}
		} else {
			$result = $object;
		}
		return $result;
	}
	private function getClassProperties($object) {
		return array_keys ( get_object_vars ( $object ) );
	}
	private function serializeObject($object) {
		$properties = $this->getClassProperties ( $object );
		$data = array ();
		foreach ( $properties as $property ) {
			$data [$property] = $this->serializeInternal ( $object->$property );
		}
		return $data;
	}
	private function serializeArray($array) {
		$result = array ();
		foreach ( $array as $key => $value ) {
			$result [$key] = $this->serializeInternal ( $value );
		}
		return $result;
	}
}