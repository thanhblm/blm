<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\mapping\AddressMapping;

class AddressBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AddressVo $addressVo = null) {
		$result = $this->executeSelectOne ( AddressMapping::class, 'selectByKey', $addressVo );
		return $result;
	}
	final public function selectAll(AddressVo $addressVo = null) {
		$result = $this->executeSelectList ( AddressMapping::class, 'selectAll', $addressVo );
		return $result;
	}
	final public function selectByFilter(AddressVo $addressVo = null) {
		$result = $this->executeSelectList ( AddressMapping::class, 'selectByFilter', $addressVo );
		return $result;
	}
	final public function countByFilter(AddressVo $addressVo = null) {
		$result = $this->executeCount ( AddressMapping::class, 'countByFilter', $addressVo );
		return $result;
	}
	final public function insertDynamic(AddressVo $addressVo = null) {
		$result = $this->executeInsert ( AddressMapping::class, 'insertDynamic', $addressVo );
		return $result;
	}
	final public function insertDynamicWithId(AddressVo $addressVo = null) {
		$result = $this->executeInsert ( AddressMapping::class, 'insertDynamicWithId', $addressVo );
		return $result;
	}
	final public function updateDynamicByKey(AddressVo $addressVo = null) {
		$result = $this->executeUpdate ( AddressMapping::class, 'updateDynamicByKey', $addressVo );
		return $result;
	}
	final public function deleteByKey(AddressVo $addressVo = null) {
		$result = $this->executeDelete ( AddressMapping::class, 'deleteByKey', $addressVo );
		return $result;
	}
}

