<?php

namespace core\database;

use core\utils\AppUtil;

class SqlStatementInfo {
	private $rawSql;
	private $sql;
	private $query;
	private $tableName;
	private $whereClause;
	private $resultClass;
	private $sqlType;
	private $queryForObject;
	const SELECT = "SELECT";
	const UPDATE = "UPDATE";
	const DELETE = "DELETE";
	const INSERT = "INSERT";
	public $bindParams = array ();
	public $whereBindParams = array ();
	private $PDO_TYPE = array (
			'PARAM_BOOL' => 5,
			'PARAM_NULL' => 0,
			'PARAM_INT' => 1,
			'PARAM_STR' => 2,
			'PARAM_LOB' => 3,
			'PARAM_LEFT_LIKE' => 10,
			'PARAM_RIGHT_LIKE' => 11,
			'PARAM_BOTH_LIKE' => 12 
	);
	public function __construct($sqlType, $tableName, $query, $resultClass = null, $whereClause = null) {
		$this->sqlType = $sqlType;
		$this->tableName = $tableName;
		$this->query = $query;
		$this->resultClass = $resultClass;
		$this->whereClause = $whereClause;
		if (isset ( $whereClause ) && (! empty ( $whereClause ))) {
			$this->rawSql = $query . " " . $whereClause;
		} else {
			$this->rawSql = $query;
		}
	}
	public function build($paraObject) {
		if (! isset ( $this->rawSql ) || empty ( $this->rawSql )) {
			$this->sql = null;
		}
		$matchs = $this->getInbetweenStrings ( "#{", "}", $this->rawSql );
		$this->bindParams = array ();
		if (count ( $matchs ) > 0) {
			$srArr = array ();
			$destArr = array ();
			for($i = 0; $i < count ( $matchs ); $i ++) {
				$params = explode ( ":", $matchs [$i] );
				$srArr [$i] = "#{" . $matchs [$i] . "}";
				$newParam = ":param" . $i;
				$destArr [$i] = $newParam;
				$popertyName = $params [0];
				$popertyType = null;
				
				if (count ( $params ) > 1) {
					$popertyType = $this->PDO_TYPE [$params [1]];
				} else {
					$popertyType = null;
				}
				
				if (! is_null ( $popertyType )) {
					switch ($popertyType) {
						case $this->PDO_TYPE ['PARAM_INT'] :
							$this->bindParams [] = array (
									$newParam,
									$paraObject->$popertyName,
									$popertyType 
							);
							break;
						case $this->PDO_TYPE ['PARAM_LEFT_LIKE'] :
							$var = $paraObject->$popertyName;
							$this->bindParams [] = array (
									$newParam,
									"%$var",
									\PDO::PARAM_STR 
							);
							break;
						case $this->PDO_TYPE ['PARAM_RIGHT_LIKE'] :
							$var = $paraObject->$popertyName;
							$this->bindParams [] = array (
									$newParam,
									"$var%",
									\PDO::PARAM_STR 
							);
							break;
						case $this->PDO_TYPE ['PARAM_BOTH_LIKE'] :
							$var = $paraObject->$popertyName;
							$this->bindParams [] = array (
									$newParam,
									"%$var%",
									\PDO::PARAM_STR 
							);
							break;
						default :
							$this->bindParams [] = array (
									$newParam,
									$paraObject->$popertyName 
							);
							break;
					}
				} else {
					$this->bindParams [] = array (
							$newParam,
							$paraObject->$popertyName 
					);
				}
			}
			$this->sql = $this->replaceSql ( $srArr, $destArr, $this->rawSql );
		} else {
			$this->sql = $this->rawSql;
		}
		$this->buildQuery4Object ( $paraObject );
	}
	private function strReplaceFirst($from, $to, $subject) {
		$from = '/' . preg_quote ( $from, '/' ) . '/';
		return preg_replace ( $from, $to, $subject, 1 );
	}
	private function replaceSql($srArr, $destArr, $sql) {
		$result = $sql;
		foreach ( $srArr as $key => $value ) {
			$result = $this->strReplaceFirst ( $value, $destArr [$key], $result );
		}
		return $result;
	}
	private function getInbetweenStrings($start, $end, $str) {
		$matches = array ();
		$regex = "/$start([a-zA-Z0-9_:]*)$end/";
		preg_match_all ( $regex, $str, $matches );
		return $matches [1];
	}
	public function mapResult($data) {
		if (! isset ( $this->resultClass ) || is_null ( $this->resultClass ))
			return null;
		
		$results = array ();
		$reflectClass = new \ReflectionClass ( $this->resultClass );
		$properties = $reflectClass->getProperties ( \ReflectionProperty::IS_PUBLIC );
		$props = array ();
		foreach ( $properties as $prop ) {
			$props [] = $prop->getName ();
		}
		if (isset ( $data )) {
			foreach ( $data as $row ) {
				$object = $reflectClass->newInstanceArgs ();
				foreach ( $row as $key => $value ) {
					$property = "";
					if (array_key_exists ( $key, $object->getResultMap () )) {
						if (in_array ( $object->getResultMap ()[$key], $props )) {
							$property = $object->getResultMap ()[$key];
						}
					} else if (in_array ( AppUtil::camelCase ( $key ), $props )) {
						$property = AppUtil::camelCase ( $key );
					}
					if (! empty ( $property )) {
						$object->$property = $value;
					}
				}
				$results [] = $object;
			}
		}
		return $results;
	}
	public function generateQueryString($paraObject) {
		try {
			if (! isset ( $this->rawSql ) || empty ( $this->rawSql )) {
				return null;
			}
			$matchs = $this->getInbetweenStrings ( "#{", "}", $this->rawSql );
			if (count ( $matchs ) > 0) {
				$srArr = array ();
				$destArr = array ();
				for($i = 0; $i < count ( $matchs ); $i ++) {
					$params = explode ( ":", $matchs [$i] );
					$srArr [] = "#{" . $matchs [$i] . "}";
					if (count ( $params ) > 1) {
						switch (($this->PDO_TYPE [$params [1]])) {
							case $this->PDO_TYPE ['PARAM_BOTH_LIKE'] :
								$destArr [] = "'%" . $paraObject->$params [0] . "%'";
								break;
							case $this->PDO_TYPE ['PARAM_RIGHT_LIKE'] :
								$destArr [] = "'" . $paraObject->$params [0] . "'%";
								break;
							case $this->PDO_TYPE ['PARAM_LEFT_LIKE'] :
								$destArr [] = "'%" . $paraObject->$params [0] . "'";
								break;
							case $this->PDO_TYPE ['PARAM_INT'] :
								$destArr [] = "" . $paraObject->$params [0] . "";
								break;
							default :
								$destArr [] = "'" . $paraObject->$params [0] . "'";
								break;
						}
					} else {
						$destArr [] = "'" . $paraObject->$params [0] . "'";
					}
				}
				return str_replace ( $srArr, $destArr, $this->rawSql );
			} else {
				return $this->rawSql;
			}
		} catch ( \Exception $e ) {
			\DatoLogUtil::error ( "Fail to generate query string for \"" . $this->rawSql . "\"", $e );
		}
	}
	private function buildQuery4Object($paraObject) {
		try {
			$rawQueryObject = "select * from " . $this->getTableName () . " " . $this->whereClause;
			$matchs = $this->getInbetweenStrings ( "#{", "}", $rawQueryObject );
			$this->whereBindParams = array ();
			$result = null;
			if (count ( $matchs ) > 0) {
				$srArr = array ();
				$destArr = array ();
				for($i = 0; $i < count ( $matchs ); $i ++) {
					$params = explode ( ":", $matchs [$i] );
					$srArr [] = "#{" . $matchs [$i] . "}";
					$destArr [] = ":" . $params [0];
					$popertyName = $params [0];
					$popertyType = null;
					
					if (count ( $params ) > 1) {
						$popertyType = $this->PDO_TYPE [$params [1]];
					} else {
						$popertyType = null;
					}
					
					if (! is_null ( $popertyType )) {
						switch ($popertyType) {
							case $this->PDO_TYPE ['PARAM_INT'] :
								$this->whereBindParams [] = array (
										":" . $popertyName,
										$paraObject->$popertyName,
										$popertyType 
								);
								break;
							case $this->PDO_TYPE ['PARAM_LEFT_LIKE'] :
								$var = $paraObject->$popertyName;
								$this->whereBindParams [] = array (
										":" . $popertyName,
										"%$var",
										\PDO::PARAM_STR 
								);
								break;
							case $this->PDO_TYPE ['PARAM_RIGHT_LIKE'] :
								$var = $paraObject->$popertyName;
								$this->whereBindParams [] = array (
										":" . $popertyName,
										"$var%",
										\PDO::PARAM_STR 
								);
								break;
							case $this->PDO_TYPE ['PARAM_BOTH_LIKE'] :
								$var = $paraObject->$popertyName;
								$this->whereBindParams [] = array (
										":" . $popertyName,
										"%$var%",
										\PDO::PARAM_STR 
								);
								break;
							default :
								$this->whereBindParams [] = array (
										":" . $popertyName,
										$paraObject->$popertyName 
								);
								break;
						}
					} else {
						$this->whereBindParams [] = array (
								":" . $popertyName,
								$paraObject->$popertyName 
						);
					}
				}
				$this->queryForObject = str_replace ( $srArr, $destArr, $rawQueryObject );
			} else {
				$this->queryForObject = $this->rawSql;
			}
		} catch ( \Exception $e ) {
		}
	}
	public function getSql() {
		return $this->sql;
	}
	public function getQuery() {
		return $this->query;
	}
	public function getTableName() {
		return $this->tableName;
	}
	public function getWhereClause() {
		return $this->whereClause;
	}
	public function getSqlType() {
		return $this->sqlType;
	}
}
