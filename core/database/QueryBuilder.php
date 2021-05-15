<?php

namespace core\database;

use core\utils\AppUtil;

class QueryBuilder {
	private $query = "";
	private $condition = "";
	private $orderBy = "";
	private $object = null;
	private $limit = "";
	private $startRecord;
	private $endRecord;
	public function __construct($object, $query) {
		$this->object = $object;
		$this->query = $query;
	}
	public function appendCondition($column, $field, $operator = "=", $allowEmpty = false, $likeType = null) {
		if (is_null ( $this->object )) {
			return $this;
		}
		$col = $column;
		$checkField = $allowEmpty ? is_null ( $this->object->$field ) : AppUtil::isEmptyString ( $this->object->$field );
		if (! $checkField) {
			$fieldWithLike = empty ( $likeType ) ? $field : $field . $likeType;
			if (! AppUtil::isEmptyString ( $this->condition )) {
				$this->condition .= " and " . $col . " " . $operator . " #{" . $fieldWithLike . "}";
			} else {
				$this->condition .= $col . " " . $operator . " #{" . $fieldWithLike . "}";
			}
		}
		return $this;
	}
	public function appendOrder() {
		if (is_null ( $this->object )) {
			return $this;
		}
		$this->orderBy = $this->getOrderBy ();
		return $this;
	}
	public function appendLimit() {
		if (is_null ( $this->object )) {
			return $this;
		}
		if (isset ( $this->object ) && isset ( $this->object->start_record ) && isset ( $this->object->end_record )) {
			$this->limit = "#{start_record:PARAM_INT},#{end_record:PARAM_INT}";
		}
		return $this;
	}
	private function getOrderBy() {
		// Order by: shippingName asc => shipping_name asc.
		// Split to get field name and order direction.
		if (AppUtil::isEmptyString ( $this->object->order_by )) {
			return "";
		}
		$checkArr = explode ( " ", $this->object->order_by );
		if (empty ( $checkArr ) || count ( $checkArr ) != 2) {
			return "";
		}
		$fieldName = $checkArr [0];
		$direction = $checkArr [1];
		// Get column name mapped with the field name.
		$columnName = "";
		$resultMap = $this->object->getResultMap ();
		foreach ( $resultMap as $column => $field ) {
			if ($field == $fieldName) {
				$columnName = "`" . $column . "`";
			}
		}
		if (! AppUtil::isEmptyString ( $columnName ) && ("asc" === strtolower ( $direction ) || "desc" === strtolower ( $direction ))) {
			return $columnName . " " . $direction;
		}
		return "";
	}
	public function getSql() {
		if (! isset ( $this->object )) {
			return $this->query;
		}
		$result = $this->query;
		if (! AppUtil::isEmptyString ( $this->condition )) {
			$result .= " where " . $this->condition;
		}
		if (! AppUtil::isEmptyString ( $this->orderBy )) {
			$result .= " order by " . $this->orderBy;
		}
		if (! AppUtil::isEmptyString ( $this->limit )) {
			$result .= " limit " . $this->limit;
		}
		return $result;
	}
}