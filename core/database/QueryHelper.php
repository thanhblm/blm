<?php

namespace core\database;

use core\utils\AppUtil;

class QueryHelper {
	public static function condition($column, $object, $field, $operator = "=", $allowEmpty = false, $likeType = null) {
		$result = "";
		if (is_null ( $object )) {
			return $result;
		}
		$col = $column;
		$checkField = $allowEmpty ? is_null ( $object->$field ) : AppUtil::isEmptyString ( $object->$field );
		if (! $checkField) {
			$fieldWithLike = empty ( $likeType ) ? $field : $field . $likeType;
			if (! AppUtil::isEmptyString ( $result )) {
				$result .= " and " . $col . " " . $operator . " #{" . $fieldWithLike . "}";
			} else {
				$result .= $col . " " . $operator . " #{" . $fieldWithLike . "}";
			}
		}
		return $result;
	}
	
	public static function order($object) {
		$result = "";
		if (is_null ( $object )) {
			return $result;
		}
		
		$checkArr = explode ( " ", $object->order_by );
		if (empty ( $checkArr ) || count ( $checkArr ) != 2) {
			return "";
		}
		$fieldName = $checkArr [0];
		$direction = $checkArr [1];
		// Get column name mapped with the field name.
		$columnName = "";
		$resultMap = $object->getResultMap ();
		foreach ( $resultMap as $column => $field ) {
			if ($field == $fieldName) {
				$columnName = "`" . $column . "`";
			}
		}
		if (! AppUtil::isEmptyString ( $columnName ) && ("asc" === strtolower ( $direction ) || "desc" === strtolower ( $direction ))) {
			$result = " order by " . $columnName . " " . $direction;
		}
		return $result;
	}

	public static function limit($object) {
		$result = "";
		if (isset ( $object ) && isset ( $object->start_record ) && isset ( $object->end_record )) {
			$result = " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
		}
		return $result;
	}
}