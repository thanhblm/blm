<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\TemplateVo;
use common\persistence\base\mapping\TemplateMapping;

class TemplateBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(TemplateVo $templateVo = null) {
		$result = $this->executeSelectOne ( TemplateMapping::class, 'selectByKey', $templateVo );
		return $result;
	}
	final public function selectAll(TemplateVo $templateVo = null) {
		$result = $this->executeSelectList ( TemplateMapping::class, 'selectAll', $templateVo );
		return $result;
	}
	final public function selectByFilter(TemplateVo $templateVo = null) {
		$result = $this->executeSelectList ( TemplateMapping::class, 'selectByFilter', $templateVo );
		return $result;
	}
	final public function countByFilter(TemplateVo $templateVo = null) {
		$result = $this->executeCount ( TemplateMapping::class, 'countByFilter', $templateVo );
		return $result;
	}
	final public function insertDynamic(TemplateVo $templateVo = null) {
		$result = $this->executeInsert ( TemplateMapping::class, 'insertDynamic', $templateVo );
		return $result;
	}
	final public function insertDynamicWithId(TemplateVo $templateVo = null) {
		$result = $this->executeInsert ( TemplateMapping::class, 'insertDynamicWithId', $templateVo );
		return $result;
	}
	final public function updateDynamicByKey(TemplateVo $templateVo = null) {
		$result = $this->executeUpdate ( TemplateMapping::class, 'updateDynamicByKey', $templateVo );
		return $result;
	}
	final public function deleteByKey(TemplateVo $templateVo = null) {
		$result = $this->executeDelete ( TemplateMapping::class, 'deleteByKey', $templateVo );
		return $result;
	}
}

