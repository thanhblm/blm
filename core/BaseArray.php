<?php

namespace core;

final class BaseArray {
	private $type;
	private $array;
	public function __construct($type) {
		if (! class_exists ( $type )) {
			throw new \Exception ( "The class [$type] doesn't exists." );
		}
		$this->array = array ();
		$this->type = $type;
	}
	public function add($object) {
		// Check null.
		if (! is_null ( $object )) {
			// Check type of object.
			if ($this->isValidType ( $object )) {
				$this->array [] = $object;
			} else {
				throw new \Exception ( "Invalid type of array element." );
			}
		} else {
			throw new \Exception ( "Cannot add empty element into the array." );
		}
	}
	public function remove($object) {
		if (is_null ( $object )) {
			return false;
		}
		// Check type of object.
		if (! $this->isValidType ( $object )) {
			throw new \Exception ( "Invalid type of array element." );
		}
		$tmpArr = array();
		foreach ( $this->array as $value ) {
			if ($value !== $object) {
				$tmpArr[]= $value ;
			}
		}
		$this->array = $tmpArr;
		return $this->array;
	}
	public function removeAt($index) {
		if ($index >= count ( $this->array )) {
			return false;
		}
		array_splice( $this->array,$index,1);
		return $this->array;
	}
	public function get($index) {
		if ($index >= count ( $this->array )) {
			return null;
		}
		return $this->array [$index];
	}
	private function isValidType($object) {
		return get_class ( $object ) == $this->type;
	}
	public function getType() {
		return $this->type;
	}
	public function getArray() {
		return $this->array;
	}
}