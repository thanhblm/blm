<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductLangVo;
use common\persistence\base\mapping\ProductLangMapping;

class ProductLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductLangVo $productLangVo = null) {
		$result = $this->executeSelectOne ( ProductLangMapping::class, 'selectByKey', $productLangVo );
		return $result;
	}
	final public function selectAll(ProductLangVo $productLangVo = null) {
		$result = $this->executeSelectList ( ProductLangMapping::class, 'selectAll', $productLangVo );
		return $result;
	}
	final public function selectByFilter(ProductLangVo $productLangVo = null) {
		$result = $this->executeSelectList ( ProductLangMapping::class, 'selectByFilter', $productLangVo );
		return $result;
	}
	final public function countByFilter(ProductLangVo $productLangVo = null) {
		$result = $this->executeCount ( ProductLangMapping::class, 'countByFilter', $productLangVo );
		return $result;
	}
	final public function insertDynamic(ProductLangVo $productLangVo = null) {
		$result = $this->executeInsert ( ProductLangMapping::class, 'insertDynamic', $productLangVo );
		return $result;
	}
	final public function insertDynamicWithId(ProductLangVo $productLangVo = null) {
		$result = $this->executeInsert ( ProductLangMapping::class, 'insertDynamicWithId', $productLangVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductLangVo $productLangVo = null) {
		$result = $this->executeUpdate ( ProductLangMapping::class, 'updateDynamicByKey', $productLangVo );
		return $result;
	}
	final public function deleteByKey(ProductLangVo $productLangVo = null) {
		$result = $this->executeDelete ( ProductLangMapping::class, 'deleteByKey', $productLangVo );
		return $result;
	}
}

