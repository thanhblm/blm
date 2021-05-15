<?php

namespace core\database;

use core\utils\AppUtil;

class UpdateBuilder {
	private $update = "";
	private $object = null;
	private $fieldValues = "";
	private $condition = "";
	public function __construct(BaseVo $object, $update) {
		$this->object = $object;
		$this->update = $update;
	}
	public function appendField($column, $field, $allowEmpty = true) {
		if (is_null ( $this->object )) {
			return $this;
		}
		$checkField = $allowEmpty ? is_null ( $this->object->$field ) : AppUtil::isEmptyString ( $this->object->$field );
		if (! $checkField) {
			if (AppUtil::isEmptyString ( $this->fieldValues )) {
				$this->fieldValues .= $column . " = #{" . $field . "}";
			} else {
				$this->fieldValues .= ", " . $column . " = #{" . $field . "}";
			}
		}
		return $this;
	}
	private function appendCondition($condition) {
		if (is_null ( $this->object )) {
			return $this;
		}
		$this->condition = $condition;
		return $this;
	}
	public function getSql() {
		if (! isset ( $this->object )) {
			throw new \Exception ( "Object cannot be null" );
		}
		if (AppUtil::isEmptyString ( $this->fieldValues )) {
			throw new \Exception ( "There isn't value for updating" );
		}
		// if (AppUtil::isEmptyString ( $this->condition )) {
		// throw new \Exception ( "There isn't condition for updating" );
		// }
		$result = $this->update;
		$result .= " set " . $this->fieldValues;
		// $result .= " where " . $this->condition;
		return $result;
	}
}