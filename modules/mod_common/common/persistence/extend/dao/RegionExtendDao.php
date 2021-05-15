<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\RegionBaseDao;
use common\persistence\extend\mapping\RegionExtendMapping;
use common\persistence\extend\vo\RegionExtendVo;
use core\database\SqlMapClient;
use common\persistence\base\vo\RegionVo;

class RegionExtendDao extends RegionBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getByFilter(RegionExtendVo $regionVo = null) {
		$result = $this->executeSelectList ( RegionExtendMapping::class, 'getByFilter', $regionVo );
		return $result;
	}
	final public function getCountByFilter(RegionExtendVo $regionVo = null) {
		$result = $this->executeCount ( RegionExtendMapping::class, 'getCountByFilter', $regionVo );
		return $result;
	}
	final public function updateAll(RegionVo $regionVo) {
		return $this->executeUpdate ( RegionExtendMapping::class, "updateAll", $regionVo );
	}
}

