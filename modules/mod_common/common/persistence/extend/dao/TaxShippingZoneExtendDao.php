<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\TaxShippingZoneBaseDao;
use common\persistence\extend\mapping\TaxShippingZoneExtendMapping;
use common\persistence\extend\vo\TaxShippingZoneExtendVo;
use core\database\SqlMapClient;

class TaxShippingZoneExtendDao extends TaxShippingZoneBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(TaxShippingZoneExtendVo $filter = null) {
		$result = $this->executeSelectList ( TaxShippingZoneExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(TaxShippingZoneExtendVo $filter = null) {
		$result = $this->executeCount ( TaxShippingZoneExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
}

