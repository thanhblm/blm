<?php

namespace core\database;

use core\utils\AppUtil;

class DoMotUseSqlBuilder {
	private $query = "";
	private $object = null;
	private $currentAppend = "";
	public function __construct($object, $query) {
		$this->object = $object;
		$this->query = $query;
	}
	public function append($str) {
		$this->currentAppend ="";
		$this->currentAppend = " " . $str . " ";
		$this->query .= $this->currentAppend;
		return $this;
	}
	public function appendCondition($column, $field, $operator = "=", $allowEmpty = false, $likeType = null) {
		$this->currentAppend ="";
		if (is_null ( $this->object )) {
			return $this;
		}
		$col = $column;
		$checkField = $allowEmpty ? is_null ( $this->object->$field ) : AppUtil::isEmptyString ( $this->object->$field );
		if (! $checkField) {
			$fieldWithLike = empty ( $likeType ) ? $field : $field . $likeType;
			$this->currentAppend = " " . $col . " " . $operator . " #{" . $fieldWithLike . "}" . " ";
			$this->query .= $this->currentAppend;
		}
		return $this;
	}
	public function appendLimit($from = "start_record", $to = "end_record") {
		$this->currentAppend ="";
		$this->currentAppend = " " . "limit #{" . $from . ":PARAM_INT},#{" . $to . ":PARAM_INT}" . " ";
		$this->query .= $this->currentAppend;
		return $this;
	}
	public function build() {
		return $this->query;
	}
}