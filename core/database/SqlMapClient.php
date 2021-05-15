<?php

namespace core\database;

use core\config\ApplicationConfig;

class SqlMapClient {
	private $pdo;
	private $addInfo;
	public function __construct(array $addInfo = null) {
		try {
			$this->pdo = new \PDO ( 'mysql:host=' . ApplicationConfig::get ( "db.host" ) . ';dbname=' . ApplicationConfig::get ( "db.schema" ), ApplicationConfig::get ( "db.username" ), ApplicationConfig::get ( "db.password" ), array (
					// \PDO::ATTR_PERSISTENT => true,
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" 
			) );
			$this->pdo->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$this->pdo->setAttribute ( \PDO::ATTR_EMULATE_PREPARES, false );
			if (isset ( $addInfo ) && ! is_null ( $addInfo )) {
				$this->addInfo = $addInfo;
			}
		} catch ( \PDOException $e ) {
			throw $e;
		}
	}
	private function prepareSqlStatementInfo($clazz, $method, $paramObj = null) {
		$reflectClass = new \ReflectionClass ( $clazz );
		$instance = $reflectClass->newInstanceArgs ();
		$reflectionMethod = new \ReflectionMethod ( $clazz, $method );
		$sqlStatementInfo = $reflectionMethod->invoke ( $instance, $paramObj );
		$sqlStatementInfo->build ( $paramObj );
		return $sqlStatementInfo;
	}
	private function selectOne(SqlStatementInfo $sqlStatementInfo, $paramObj = null) {
		try {
			\DatoLogUtil::trace( $sqlStatementInfo->generateQueryString ( $paramObj ) );
			$stmt = $this->pdo->prepare ( $sqlStatementInfo->getSql () );
			foreach ( $sqlStatementInfo->bindParams as $paramInfo ) {
				$stmt->bindParam ( $paramInfo [0], $paramInfo [1] );
			}
			if ($stmt->execute ()) {
				$row = $stmt->fetchAll ( \PDO::FETCH_NAMED );
				$result = $sqlStatementInfo->mapResult ( $row );
				if (count ( $result ) == 1)
					return $result [0];
			}
		} catch ( \Exception $e ) {
			throw $e;
		}
		return null;
	}
	private function count(SqlStatementInfo $sqlStatementInfo, $paramObj = null) {
		try {
			\DatoLogUtil::trace( $sqlStatementInfo->generateQueryString ( $paramObj ) );
			$stmt = $this->pdo->prepare ( $sqlStatementInfo->getSql () );
			foreach ( $sqlStatementInfo->bindParams as $paramInfo ) {
				$stmt->bindParam ( $paramInfo [0], $paramInfo [1] );
			}
			if ($stmt->execute ()) {
				$row = $stmt->fetchAll ( \PDO::FETCH_NAMED );
				if (! isset ( $row )) {
					return 0;
				}
				$result = array_values ( $row [0] );
				if (! isset ( $result )) {
					return 0;
				}
				return isset ( $result [0] ) ? $result [0] : 0;
			}
		} catch ( \Exception $e ) {
			throw $e;
		}
		return 0;
	}
	private function selectList(SqlStatementInfo $sqlStatementInfo, $paramObj = null) {
		try {
			\DatoLogUtil::trace( $sqlStatementInfo->generateQueryString ( $paramObj ) );
			$stmt = $this->pdo->prepare ( $sqlStatementInfo->getSql () );
			foreach ( $sqlStatementInfo->bindParams as $paramInfo ) {
				$stmt->bindParam ( $paramInfo [0], $paramInfo [1] );
			}
			if ($stmt->execute ()) {
				$row = $stmt->fetchAll ( \PDO::FETCH_NAMED );
				return $sqlStatementInfo->mapResult ( $row );
			}
		} catch ( \Exception $e ) {
			throw $e;
		}
		return null;
	}
	private function delete(SqlStatementInfo $sqlStatementInfo, $paramObj = null) {
		try {
			\DatoLogUtil::trace( $sqlStatementInfo->generateQueryString ( $paramObj ) );
			$stmt = $this->pdo->prepare ( $sqlStatementInfo->getSql () );
			foreach ( $sqlStatementInfo->bindParams as $paramInfo ) {
				$stmt->bindParam ( $paramInfo [0], $paramInfo [1] );
			}
			return $stmt->execute ();
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	private function update(SqlStatementInfo $sqlStatementInfo, $paramObj = null) {
		try {
			\DatoLogUtil::trace( $sqlStatementInfo->generateQueryString ( $paramObj ) );
			$stmt = $this->pdo->prepare ( $sqlStatementInfo->getSql () );
			foreach ( $sqlStatementInfo->bindParams as $paramInfo ) {
				$stmt->bindParam ( $paramInfo [0], $paramInfo [1] );
			}
			return $stmt->execute ();
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	private function insert(SqlStatementInfo $sqlStatementInfo, $paramObj = null) {
		try {
			\DatoLogUtil::trace( $sqlStatementInfo->generateQueryString ( $paramObj ) );
			$stmt = $this->pdo->prepare ( $sqlStatementInfo->getSql () );
			foreach ( $sqlStatementInfo->bindParams as $paramInfo ) {
				$stmt->bindParam ( $paramInfo [0], $paramInfo [1] );
			}
			$stmt->execute ();
			return $this->pdo->lastInsertId ();
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function executeSelectOne($clazz, $method, $paramObj = null) {
		try {
			$sqlStatementInfo = $this->prepareSqlStatementInfo ( $clazz, $method, $paramObj );
			return $this->selectOne ( $sqlStatementInfo, $paramObj );
		} catch ( \Exception $e ) {
			throw $e;
		}
		return null;
	}
	public function executeCount($clazz, $method, $paramObj = null) {
		try {
			$sqlStatementInfo = $this->prepareSqlStatementInfo ( $clazz, $method, $paramObj );
			return $this->count ( $sqlStatementInfo, $paramObj );
		} catch ( \Exception $e ) {
			throw $e;
		}
		return 0;
	}
	public function executeSelectList($clazz, $method, $paramObj = null) {
		try {
			$sqlStatementInfo = $this->prepareSqlStatementInfo ( $clazz, $method, $paramObj );
			return $this->selectList ( $sqlStatementInfo, $paramObj );
		} catch ( \Exception $e ) {
			throw $e;
		}
		return null;
	}
	public function executeDelete($clazz, $method, $paramObj = null) {
		try {
			$sqlStatementInfo = $this->prepareSqlStatementInfo ( $clazz, $method, $paramObj );
			return $this->delete ( $sqlStatementInfo, $paramObj );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function executeUpdate($clazz, $method, $paramObj = null) {
		try {
			$sqlStatementInfo = $this->prepareSqlStatementInfo ( $clazz, $method, $paramObj );
			return $this->update ( $sqlStatementInfo, $paramObj );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function executeInsert($clazz, $method, $paramObj = null) {
		try {
			$sqlStatementInfo = $this->prepareSqlStatementInfo ( $clazz, $method, $paramObj );
			return $this->insert ( $sqlStatementInfo, $paramObj );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function startTransaction() {
		$this->pdo->beginTransaction ();
	}
	public function endTransaction() {
		$this->pdo->commit ();
	}
	public function rollback() {
		$this->pdo->rollBack ();
	}
	private function selectOldRecord(SqlStatementInfo $sqlStatementInfo, $paramObj) {
	}
}

