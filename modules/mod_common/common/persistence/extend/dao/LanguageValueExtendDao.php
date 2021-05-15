<?php

namespace common\persistence\extend\dao;

use common\persistence\extend\mapping\LanguageValueExtendMapping;
use common\persistence\base\dao\LanguageValueBaseDao;
use core\database\SqlMapClient;
use common\persistence\extend\vo\LanguageValueExtendVo;

class LanguageValueExtendDao extends LanguageValueBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(LanguageValueExtendVo $languageValueExtendVo = null) {
		$result = $this->executeSelectList ( LanguageValueExtendMapping::class, 'getByFilter', $languageValueExtendVo );
		return $result;
	}
	public function getCountByFilter(LanguageValueExtendVo $languageValueExtendVo = null) {
		$result = $this->executeCount ( LanguageValueExtendMapping::class, 'getCountByFilter', $languageValueExtendVo );
		return $result;
	}
	public function copyLanguageValueByCode(LanguageValueExtendVo $filter) {
		$result = $this->executeInsert ( LanguageValueExtendMapping::class, 'copyLanguageValueByCode', $filter );
		return $result;
	}
	public function deleteLanguageValueByCode(LanguageValueExtendVo $filter){
		$result = $this->executeDelete ( LanguageValueExtendMapping::class, 'deleteLanguageValueByCode', $filter );
		return $result;
	}
}