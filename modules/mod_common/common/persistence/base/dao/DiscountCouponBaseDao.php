<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\DiscountCouponVo;
use common\persistence\base\mapping\DiscountCouponMapping;

class DiscountCouponBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeSelectOne ( DiscountCouponMapping::class, 'selectByKey', $discountCouponVo );
		return $result;
	}
	final public function selectAll(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeSelectList ( DiscountCouponMapping::class, 'selectAll', $discountCouponVo );
		return $result;
	}
	final public function selectByFilter(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeSelectList ( DiscountCouponMapping::class, 'selectByFilter', $discountCouponVo );
		return $result;
	}
	final public function countByFilter(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeCount ( DiscountCouponMapping::class, 'countByFilter', $discountCouponVo );
		return $result;
	}
	final public function insertDynamic(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeInsert ( DiscountCouponMapping::class, 'insertDynamic', $discountCouponVo );
		return $result;
	}
	final public function insertDynamicWithId(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeInsert ( DiscountCouponMapping::class, 'insertDynamicWithId', $discountCouponVo );
		return $result;
	}
	final public function updateDynamicByKey(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeUpdate ( DiscountCouponMapping::class, 'updateDynamicByKey', $discountCouponVo );
		return $result;
	}
	final public function deleteByKey(DiscountCouponVo $discountCouponVo = null) {
		$result = $this->executeDelete ( DiscountCouponMapping::class, 'deleteByKey', $discountCouponVo );
		return $result;
	}
}

