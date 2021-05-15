<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AttributeVo;
use common\persistence\base\mapping\AttributeMapping;

class AttributeBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AttributeVo $attributeVo = null) {
		$result = $this->executeSelectOne ( AttributeMapping::class, 'selectByKey', $attributeVo );
		return $result;
	}
	final public function selectAll(AttributeVo $attributeVo = null) {
		$result = $this->executeSelectList ( AttributeMapping::class, 'selectAll', $attributeVo );
		return $result;
	}
	final public function selectByFilter(AttributeVo $attributeVo = null) {
		$result = $this->executeSelectList ( AttributeMapping::class, 'selectByFilter', $attributeVo );
		return $result;
	}
	final public function countByFilter(AttributeVo $attributeVo = null) {
		$result = $this->executeCount ( AttributeMapping::class, 'countByFilter', $attributeVo );
		return $result;
	}
	final public function insertDynamic(AttributeVo $attributeVo = null) {
		$result = $this->executeInsert ( AttributeMapping::class, 'insertDynamic', $attributeVo );
		return $result;
	}
	final public function insertDynamicWithId(AttributeVo $attributeVo = null) {
		$result = $this->executeInsert ( AttributeMapping::class, 'insertDynamicWithId', $attributeVo );
		return $result;
	}
	final public function updateDynamicByKey(AttributeVo $attributeVo = null) {
		$result = $this->executeUpdate ( AttributeMapping::class, 'updateDynamicByKey', $attributeVo );
		return $result;
	}
	final public function deleteByKey(AttributeVo $attributeVo = null) {
		$result = $this->executeDelete ( AttributeMapping::class, 'deleteByKey', $attributeVo );
		return $result;
	}
}

