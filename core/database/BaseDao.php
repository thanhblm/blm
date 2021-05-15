<?php

namespace core\database;

class BaseDao {
	protected $sqlMapClient;
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		if (! isset ( $sqlMapClient ) || is_null ( $sqlMapClient )) {
			$this->sqlMapClient = new SqlMapClient ( $addInfo );
		} else {
			$this->sqlMapClient = $sqlMapClient;
		}
	}
	protected function executeSelectOne($clazz, $method, $paramObj = null) {
		try {
			$startTime = round ( microtime ( true ) * 1000 );
			$result = $this->sqlMapClient->executeSelectOne ( $clazz, $method, $paramObj );
			\DatoLogUtil::logElapedTime( "SQL: " . $clazz . "\\" . $method ,(round ( microtime ( true ) * 1000 ) - $startTime) );
			return $result;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	protected function executeSelectList($clazz, $method, $paramObj = null) {
		try {
			$startTime = round ( microtime ( true ) * 1000 );
			$result = $this->sqlMapClient->executeSelectList ( $clazz, $method, $paramObj );
			\DatoLogUtil::logElapedTime( "SQL: " . $clazz . "\\" . $method ,(round ( microtime ( true ) * 1000 ) - $startTime) );
			return $result;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	protected function executeDelete($clazz, $method, $paramObj = null) {
		try {
			$startTime = round ( microtime ( true ) * 1000 );
			$result = $this->sqlMapClient->executeDelete ( $clazz, $method, $paramObj );
			\DatoLogUtil::logElapedTime( "SQL: " . $clazz . "\\" . $method ,(round ( microtime ( true ) * 1000 ) - $startTime) );
			return $result;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	protected function executeUpdate($clazz, $method, $paramObj = null) {
		try {
			$startTime = round ( microtime ( true ) * 1000 );
			$result = $this->sqlMapClient->executeUpdate ( $clazz, $method, $paramObj );
			\DatoLogUtil::logElapedTime( "SQL: " . $clazz . "\\" . $method ,(round ( microtime ( true ) * 1000 ) - $startTime) );
			return $result;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	protected function executeInsert($clazz, $method, $paramObj = null) {
		try {
			$startTime = round ( microtime ( true ) * 1000 );
			$result = $this->sqlMapClient->executeInsert ( $clazz, $method, $paramObj );
			\DatoLogUtil::logElapedTime( "SQL: " . $clazz . "\\" . $method ,(round ( microtime ( true ) * 1000 ) - $startTime) );
			return $result;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	protected function executeCount($clazz, $method, $paramObj = null) {
		try {
			$startTime = round ( microtime ( true ) * 1000 );
			$result = $this->sqlMapClient->executeCount ( $clazz, $method, $paramObj );
			\DatoLogUtil::logElapedTime( "SQL: " . $clazz . "\\" . $method ,(round ( microtime ( true ) * 1000 ) - $startTime) );
			return $result;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}
