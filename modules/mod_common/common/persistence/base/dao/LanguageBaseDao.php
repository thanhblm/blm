<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\LanguageVo;
use common\persistence\base\mapping\LanguageMapping;

class LanguageBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(LanguageVo $languageVo = null) {
		$result = $this->executeSelectOne ( LanguageMapping::class, 'selectByKey', $languageVo );
		return $result;
	}
	final public function selectAll(LanguageVo $languageVo = null) {
		$result = $this->executeSelectList ( LanguageMapping::class, 'selectAll', $languageVo );
		return $result;
	}
	final public function selectByFilter(LanguageVo $languageVo = null) {
		$result = $this->executeSelectList ( LanguageMapping::class, 'selectByFilter', $languageVo );
		return $result;
	}
	final public function countByFilter(LanguageVo $languageVo = null) {
		$result = $this->executeCount ( LanguageMapping::class, 'countByFilter', $languageVo );
		return $result;
	}
	final public function insertDynamic(LanguageVo $languageVo = null) {
		$result = $this->executeInsert ( LanguageMapping::class, 'insertDynamic', $languageVo );
		return $result;
	}
	final public function insertDynamicWithId(LanguageVo $languageVo = null) {
		$result = $this->executeInsert ( LanguageMapping::class, 'insertDynamicWithId', $languageVo );
		return $result;
	}
	final public function updateDynamicByKey(LanguageVo $languageVo = null) {
		$result = $this->executeUpdate ( LanguageMapping::class, 'updateDynamicByKey', $languageVo );
		return $result;
	}
	final public function deleteByKey(LanguageVo $languageVo = null) {
		$result = $this->executeDelete ( LanguageMapping::class, 'deleteByKey', $languageVo );
		return $result;
	}
}

