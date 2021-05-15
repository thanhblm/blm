<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\RegionShippingMethodBaseDao;
use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\extend\mapping\RegionShippingMethodExtendMapping;
use core\database\SqlMapClient;

class RegionShippingMethodExtendDao extends RegionShippingMethodBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function deleteRegionShippingMethodByFilter(RegionShippingMethodVo $regionShippingMethodVo = null) {
		$result = $this->executeDelete ( RegionShippingMethodExtendMapping::class, 'deleteRegionShippingMethodByFilter', $regionShippingMethodVo );
	}
	final public function getShippingMethodByRegion(RegionVo $regionVo) {
		return $this->executeSelectList ( RegionShippingMethodExtendMapping::class, "getShippingMethodByRegion", $regionVo );
	}
}

