<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\PriceLevelBaseDao;
use common\persistence\base\vo\CustomerVo;
use common\persistence\extend\mapping\PriceLevelExtendMapping;
use common\persistence\extend\vo\PriceLevelExtendVo;
use core\database\SqlMapClient;

class PriceLevelExtendDao extends PriceLevelBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(PriceLevelExtendVo $filter = null) {
		$result = $this->executeSelectList ( PriceLevelExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(PriceLevelExtendVo $filter = null) {
		$result = $this->executeCount ( PriceLevelExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
	public function getPriceLevelByCustomerId(CustomerVo $customerVo) {
		return $this->executeSelectOne ( PriceLevelExtendMapping::class, "getPriceLevelByCustomerId", $customerVo );
	}
}