<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\RegionCountryBaseDao;
use common\persistence\base\vo\RegionCountryVo;
use common\persistence\extend\mapping\RegionCountryExtendMapping;
use core\database\SqlMapClient;

class RegionCountryExtendDao extends RegionCountryBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function deleteRegionCountryByFilter(RegionCountryVo $regionCountryVo = null) {
		$result = $this->executeDelete ( RegionCountryExtendMapping::class, 'deleteRegionCountryByFilter', $regionCountryVo );
	}
}

