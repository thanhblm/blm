<?php

namespace common\persistence\extend\dao;

use common\persistence\extend\mapping\LanguageExtendMapping;
use common\persistence\base\dao\LanguageBaseDao;
use core\database\SqlMapClient;
use common\persistence\extend\vo\LanguageExtendVo;

class LanguageExtendDao extends LanguageBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(LanguageExtendVo $languageVo = null) {
		$result = $this->executeSelectList ( LanguageExtendMapping::class, 'getByFilter', $languageVo );
		return $result;
	}
	public function getCountByFilter(LanguageExtendVo $languageVo = null) {
		$result = $this->executeCount ( LanguageExtendMapping::class, 'getCountByFilter', $languageVo );
		return $result;
	}
}