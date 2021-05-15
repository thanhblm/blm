<?php

namespace core\database;

use core\utils\AppUtil;

class InsertBuilder {
	private $insert = "";
	private $object = null;
	private $fields = "";
	private $values = "";
	public function __construct(BaseVo $object, $insert) {
		$this->object = $object;
		$this->insert = $insert;
	}
	public function appendField($column, $field, $allowEmpty = true) {
		if (is_null ( $this->object )) {
			return $this;
		}
		$checkField = $allowEmpty ? is_null ( $this->object->$field ) : AppUtil::isEmptyString ( $this->object->$field );
		if (! $checkField) {
			if (AppUtil::isEmptyString ( $this->fields )) {
				$this->fields .= $column;
				$this->values .= "#{" . $field . "}";
			} else {
				$this->fields .= ", " . $column;
				$this->values .= ", #{" . $field . "}";
			}
		}
		return $this;
	}
	public function getSql() {
		if (! isset ( $this->object )) {
			throw new \Exception ( "Object cannot be null" );
		}
		if (AppUtil::isEmptyString ( $this->fields )) {
			throw new \Exception ( "There isn't field for inserting" );
		}
		if (AppUtil::isEmptyString ( $this->values )) {
			throw new \Exception ( "There isn't value for inserting" );
		}
		$result = $this->insert;
		$result .= " (" . $this->fields . ")";
		$result .= " values (" . $this->values . ")";
		return $result;
	}
}