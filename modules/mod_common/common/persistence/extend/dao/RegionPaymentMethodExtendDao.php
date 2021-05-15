<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\RegionPaymentMethodBaseDao;
use common\persistence\base\vo\RegionPaymentMethodVo;
use common\persistence\extend\mapping\RegionPaymentMethodExtendMapping;
use core\database\SqlMapClient;
use common\persistence\base\vo\RegionVo;

class RegionPaymentMethodExtendDao extends RegionPaymentMethodBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function deleteRegionPaymentMethodByFilter(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		$result = $this->executeDelete ( RegionPaymentMethodExtendMapping::class, 'deleteRegionPaymentMethodByFilter', $regionPaymentMethodVo );
	}
	final public function getPaymentMethodByRegion(RegionVo $regionVo) {
		return $this->executeSelectList ( RegionPaymentMethodExtendMapping::class, "getPaymentMethodByRegion", $regionVo );
	}
}