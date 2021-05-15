<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\mapping\CartInfoMapping;

class CartInfoBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeSelectOne ( CartInfoMapping::class, 'selectByKey', $cartInfoVo );
		return $result;
	}
	final public function selectAll(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeSelectList ( CartInfoMapping::class, 'selectAll', $cartInfoVo );
		return $result;
	}
	final public function selectByFilter(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeSelectList ( CartInfoMapping::class, 'selectByFilter', $cartInfoVo );
		return $result;
	}
	final public function countByFilter(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeCount ( CartInfoMapping::class, 'countByFilter', $cartInfoVo );
		return $result;
	}
	final public function insertDynamic(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeInsert ( CartInfoMapping::class, 'insertDynamic', $cartInfoVo );
		return $result;
	}
	final public function insertDynamicWithId(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeInsert ( CartInfoMapping::class, 'insertDynamicWithId', $cartInfoVo );
		return $result;
	}
	final public function updateDynamicByKey(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeUpdate ( CartInfoMapping::class, 'updateDynamicByKey', $cartInfoVo );
		return $result;
	}
	final public function deleteByKey(CartInfoVo $cartInfoVo = null) {
		$result = $this->executeDelete ( CartInfoMapping::class, 'deleteByKey', $cartInfoVo );
		return $result;
	}
}

