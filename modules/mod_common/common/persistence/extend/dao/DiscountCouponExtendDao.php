<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\DiscountCouponBaseDao;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\extend\mapping\DiscountCouponExtendMapping;
use common\persistence\extend\vo\DiscountCouponExtendVo;
use core\database\SqlMapClient;

class DiscountCouponExtendDao extends DiscountCouponBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(DiscountCouponExtendVo $filter = null) {
		$result = $this->executeSelectList ( DiscountCouponExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
	
	public function getDiscountCouponByProduct(DiscountCouponExtendVo $filter = null) {
		$result = $this->executeSelectList ( DiscountCouponExtendMapping::class, 'getDiscountCouponByProduct', $filter );
		return $result;
	}
	public function getCountByFilter(DiscountCouponExtendVo $filter = null) {
		$result = $this->executeCount ( DiscountCouponExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
	public function getByCode(DiscountCouponVo $discountCouponVo) {
		return $this->executeSelectOne ( DiscountCouponExtendMapping::class, "getByCode", $discountCouponVo );
	}
}