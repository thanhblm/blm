<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\DiscountCouponProductVo;
use common\persistence\base\mapping\DiscountCouponProductMapping;

class DiscountCouponProductBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeSelectOne ( DiscountCouponProductMapping::class, 'selectByKey', $discountCouponProductVo );
		return $result;
	}
	final public function selectAll(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeSelectList ( DiscountCouponProductMapping::class, 'selectAll', $discountCouponProductVo );
		return $result;
	}
	final public function selectByFilter(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeSelectList ( DiscountCouponProductMapping::class, 'selectByFilter', $discountCouponProductVo );
		return $result;
	}
	final public function countByFilter(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeCount ( DiscountCouponProductMapping::class, 'countByFilter', $discountCouponProductVo );
		return $result;
	}
	final public function insertDynamic(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeInsert ( DiscountCouponProductMapping::class, 'insertDynamic', $discountCouponProductVo );
		return $result;
	}
	final public function insertDynamicWithId(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeInsert ( DiscountCouponProductMapping::class, 'insertDynamicWithId', $discountCouponProductVo );
		return $result;
	}
	final public function updateDynamicByKey(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeUpdate ( DiscountCouponProductMapping::class, 'updateDynamicByKey', $discountCouponProductVo );
		return $result;
	}
	final public function deleteByKey(DiscountCouponProductVo $discountCouponProductVo = null) {
		$result = $this->executeDelete ( DiscountCouponProductMapping::class, 'deleteByKey', $discountCouponProductVo );
		return $result;
	}
}

