<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\DiscountCouponProductBaseDao;
use common\persistence\extend\mapping\DiscountCouponProductExtendMapping;
use common\persistence\extend\vo\DiscountCouponProductExtendVo;
use core\database\SqlMapClient;

class DiscountCouponProductExtendDao extends DiscountCouponProductBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(DiscountCouponProductExtendVo $filter = null) {
		$result = $this->executeSelectList ( DiscountCouponProductExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
}

