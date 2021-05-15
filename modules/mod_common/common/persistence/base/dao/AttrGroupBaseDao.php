<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AttrGroupVo;
use common\persistence\base\mapping\AttrGroupMapping;

class AttrGroupBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeSelectOne ( AttrGroupMapping::class, 'selectByKey', $attrGroupVo );
		return $result;
	}
	final public function selectAll(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeSelectList ( AttrGroupMapping::class, 'selectAll', $attrGroupVo );
		return $result;
	}
	final public function selectByFilter(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeSelectList ( AttrGroupMapping::class, 'selectByFilter', $attrGroupVo );
		return $result;
	}
	final public function countByFilter(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeCount ( AttrGroupMapping::class, 'countByFilter', $attrGroupVo );
		return $result;
	}
	final public function insertDynamic(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeInsert ( AttrGroupMapping::class, 'insertDynamic', $attrGroupVo );
		return $result;
	}
	final public function insertDynamicWithId(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeInsert ( AttrGroupMapping::class, 'insertDynamicWithId', $attrGroupVo );
		return $result;
	}
	final public function updateDynamicByKey(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeUpdate ( AttrGroupMapping::class, 'updateDynamicByKey', $attrGroupVo );
		return $result;
	}
	final public function deleteByKey(AttrGroupVo $attrGroupVo = null) {
		$result = $this->executeDelete ( AttrGroupMapping::class, 'deleteByKey', $attrGroupVo );
		return $result;
	}
}

