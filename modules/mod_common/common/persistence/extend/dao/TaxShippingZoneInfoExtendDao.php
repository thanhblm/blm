<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\TaxShippingZoneInfoBaseDao;
use common\persistence\extend\mapping\TaxShippingZoneInfoExtendMapping;
use common\persistence\extend\vo\TaxShippingZoneInfoExtendVo;
use core\database\SqlMapClient;

class TaxShippingZoneInfoExtendDao extends TaxShippingZoneInfoBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(TaxShippingZoneInfoExtendVo $filter = null) {
		$result = $this->executeSelectList ( TaxShippingZoneInfoExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
}

