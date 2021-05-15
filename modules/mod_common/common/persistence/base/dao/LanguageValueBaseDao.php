<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\LanguageValueVo;
use common\persistence\base\mapping\LanguageValueMapping;

class LanguageValueBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeSelectOne ( LanguageValueMapping::class, 'selectByKey', $languageValueVo );
		return $result;
	}
	final public function selectAll(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeSelectList ( LanguageValueMapping::class, 'selectAll', $languageValueVo );
		return $result;
	}
	final public function selectByFilter(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeSelectList ( LanguageValueMapping::class, 'selectByFilter', $languageValueVo );
		return $result;
	}
	final public function countByFilter(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeCount ( LanguageValueMapping::class, 'countByFilter', $languageValueVo );
		return $result;
	}
	final public function insertDynamic(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeInsert ( LanguageValueMapping::class, 'insertDynamic', $languageValueVo );
		return $result;
	}
	final public function insertDynamicWithId(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeInsert ( LanguageValueMapping::class, 'insertDynamicWithId', $languageValueVo );
		return $result;
	}
	final public function updateDynamicByKey(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeUpdate ( LanguageValueMapping::class, 'updateDynamicByKey', $languageValueVo );
		return $result;
	}
	final public function deleteByKey(LanguageValueVo $languageValueVo = null) {
		$result = $this->executeDelete ( LanguageValueMapping::class, 'deleteByKey', $languageValueVo );
		return $result;
	}
}

