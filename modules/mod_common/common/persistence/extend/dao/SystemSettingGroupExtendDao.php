<?php

namespace common\persistence\extend\dao;

use common\persistence\base\vo\SystemSettingGroupVo;
use common\persistence\extend\mapping\SystemSettingGroupExtendMapping;
use core\database\SqlMapClient;
use common\persistence\base\dao\SystemSettingGroupBaseDao;

class SystemSettingGroupExtendDao extends SystemSettingGroupBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(SystemSettingGroupVo $filter = null) {
		$result = $this->executeSelectList ( SystemSettingGroupExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(SystemSettingGroupVo $filter = null) {
		$result = $this->executeCount ( SystemSettingGroupExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
}

