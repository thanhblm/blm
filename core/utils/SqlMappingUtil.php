<?php

namespace core\utils;

use core\database\BaseVo;

class SqlMappingUtil {
	public static function buildCondition($baseVo) {
		if (! $baseVo instanceof BaseVo) {
			throw new \Exception ( "The object isn't an instance of BaseVo." );
		}
		$resultMap = $baseVo->getResultMap ();
		if (! isset ( $resultMap ) || count ( $resultMap ) == 0) {
			return null;
		}
		$condition = "";
		$isFirst = true;
		foreach ( $resultMap as $column => $field ) {
			if (! AppUtil::isEmptyString ( $baseVo->$field )) {
				if ($isFirst) {
					$condition .= "(`" . $column . "` = #{" . $field . "})";
					$isFirst = false;
				} else {
					$condition .= " and (`" . $column . "` = #{" . $field . "})";
				}
			}
		}
		return $condition;
	}
	public static function buildInsertMap($baseVo, $autoIncreaseColumns) {
		if (! $baseVo instanceof BaseVo) {
			throw new \Exception ( "The object isn't an instance of BaseVo." );
		}
		$resultMap = $baseVo->getResultMap ();
		if (! isset ( $resultMap ) || count ( $resultMap ) == 0) {
			return null;
		}
		$insertMap = array ();
		foreach ( $resultMap as $column => $field ) {
			if (! is_null ( $baseVo->$field ) && ! in_array ( $column, $autoIncreaseColumns )) {
				$insertMap [$column] = $field;
			}
		}
		return $insertMap;
	}
	public static function buildUpdateFields($baseVo, $keyColumns) {
		if (! $baseVo instanceof BaseVo) {
			throw new \Exception ( "The object isn't an instance of BaseVo." );
		}
		$resultMap = $baseVo->getResultMap ();
		if (! isset ( $resultMap ) || count ( $resultMap ) == 0) {
			return null;
		}
		$updateFields = "";
		foreach ( $resultMap as $column => $field ) {
			if (! is_null ( $baseVo->$field ) && ! in_array ( $column, $keyColumns )) {
				$updateFields .= "`" . $column . "` = #{" . $field . "},";
			}
		}
		if (! AppUtil::isEmptyString ( $updateFields )) {
			$updateFields = substr ( $updateFields, 0, strlen ( $updateFields ) - 1 );
		}
		return $updateFields;
	}
	public static function buildOrderByClause($baseVo) {
		if (! $baseVo instanceof BaseVo) {
			throw new \Exception ( "The object isn't an instance of BaseVo." );
		}
		$resultMap = $baseVo->getResultMap ();
		if (! isset ( $resultMap ) || count ( $resultMap ) == 0) {
			return $baseVo->order_by;
		}
		$result = $baseVo->order_by;
		$checkArr = explode ( " ", $result );
		foreach ( $resultMap as $column => $field ) {
			if (strpos ( $result, $field ) !== false && in_array ( $field, $checkArr )) {
				$result = str_ireplace ( $field, "`" . $column . "`", $result );
			}
		}
		return $result;
	}
	/**
	 * Check value of the field of the object.
	 * If the value is not null then append filter to the condition.
	 *
	 * @param object $object
	 *        	The object to check.
	 * @param string $column
	 *        	The column in the query.
	 * @param string $field
	 *        	The field to check.
	 * @param string $operator
	 *        	The operator apply to the column.
	 * @param string $condition
	 *        	The current condition.
	 */
	public static function appendFilterIfNotNull($object, $column, $field, $operator, &$condition, $likeType = null) {
		$col = $column;
		if (false === strpos ( $col, "." )) {
			$col = "`" . $col . "`";
		}
		if (! AppUtil::isEmptyString ( $object->$field )) {
			$fieldWithLike = empty ( $likeType ) ? $field : $field . $likeType;
			if (! AppUtil::isEmptyString ( $condition )) {
				$condition .= " and " . $col . " " . $operator . " #{" . $fieldWithLike . "}";
			} else {
				$condition .= $col . " " . $operator . " #{" . $fieldWithLike . "}";
			}
		}
	}
	public static function appendCondition($object, $column, $field, $operator, &$condition, $likeType = null, $allowEmpty = false) {
		$col = $column;
		if (false === strpos ( $col, "." )) {
			$col = "`" . $col . "`";
		}
		$checkField = $allowEmpty ? is_null ( $object->$field ) : AppUtil::isEmptyString ( $object->$field );
		if (! $checkField) {
			$fieldWithLike = empty ( $likeType ) ? $field : $field . $likeType;
			if (! AppUtil::isEmptyString ( $condition )) {
				$condition .= " and " . $col . " " . $operator . " #{" . $fieldWithLike . "}";
			} else {
				$condition .= $col . " " . $operator . " #{" . $fieldWithLike . "}";
			}
		}
	}
} 