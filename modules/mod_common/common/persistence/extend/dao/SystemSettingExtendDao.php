<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\SystemSettingBaseDao;
use common\persistence\base\vo\SystemSettingVo;
use common\persistence\extend\mapping\SystemSettingExtendMapping;
use core\database\SqlMapClient;

class SystemSettingExtendDao extends SystemSettingBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByName(SystemSettingVo $systemSettingVo) {
		$filter = new SystemSettingVo ();
		$filter->name = $systemSettingVo->name;
		$result = $this->executeSelectOne ( SystemSettingExtendMapping::class, 'getByName', $filter );
		return $result;
	}
	public function getByFilter(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeSelectList ( SystemSettingExtendMapping::class, 'getByFilter', $systemSettingVo );
		return $result;
	}
	public function getCountByFilter(SystemSettingVo $systemSettingVo = null) {
		$result = $this->executeCount ( SystemSettingExtendMapping::class, 'getCountByFilter', $systemSettingVo );
		return $result;
	}
}