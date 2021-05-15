<?php

namespace __MODULE_NAME__\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use __MODULE_NAME__\persistence\base\vo\__CLASS_NAME__Vo;
use __MODULE_NAME__\persistence\base\mapping\__CLASS_NAME__Mapping;

class __CLASS_NAME__BaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeSelectOne ( __CLASS_NAME__Mapping::class, 'selectByKey', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function selectAll(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeSelectList ( __CLASS_NAME__Mapping::class, 'selectAll', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function selectByFilter(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeSelectList ( __CLASS_NAME__Mapping::class, 'selectByFilter', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function countByFilter(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeCount ( __CLASS_NAME__Mapping::class, 'countByFilter', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function insertDynamic(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeInsert ( __CLASS_NAME__Mapping::class, 'insertDynamic', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function insertDynamicWithId(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeInsert ( __CLASS_NAME__Mapping::class, 'insertDynamicWithId', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function updateDynamicByKey(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeUpdate ( __CLASS_NAME__Mapping::class, 'updateDynamicByKey', $__PARAM_NAME__Vo );
		return $result;
	}
	final public function deleteByKey(__CLASS_NAME__Vo $__PARAM_NAME__Vo = null) {
		$result = $this->executeDelete ( __CLASS_NAME__Mapping::class, 'deleteByKey', $__PARAM_NAME__Vo );
		return $result;
	}
}

