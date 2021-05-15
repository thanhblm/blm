<?php

namespace common\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\utils\SqlMappingUtil;
use common\persistence\extend\vo\DiscountCouponExtendVo;
use common\persistence\base\vo\DiscountCouponVo;

class DiscountCouponExtendMapping {
	private function getCondition(DiscountCouponExtendVo $discountCouponExtendVo) {
		$condition = SqlMappingUtil::buildCondition ( $discountCouponExtendVo );
		$condition = str_replace ( " = #{name}", " like #{name:PARAM_BOTH_LIKE}", $condition );
		//$condition = str_replace ( " = #{code}", " = BINARY #{code}", $condition );
		$condition = str_replace ( " = #{userPerProduct}", " like #{userPerProduct:PARAM_BOTH_LIKE}", $condition );
		
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "discount", "discountFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "discount", "discountTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "min_order_total", "minOrderTotalFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "min_order_total", "minOrderTotalTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "max_use", "maxUseFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "max_use", "maxUseTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "use_per_customer", "usePerCustomerFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "use_per_customer", "usePerCustomerTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "valid_from", "validFromFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "valid_from", "validFromTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "valid_to", "validToFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "valid_to", "validToTo", "<=", $condition );
		
		return $condition;
	}
	
	private function getConditionProduct(DiscountCouponExtendVo $discountCouponExtendVo) {
		$condition = SqlMappingUtil::buildCondition ( $discountCouponExtendVo );
		$condition = str_replace ( " = #{name}", " like #{name:PARAM_BOTH_LIKE}", $condition );
		//$condition = str_replace ( " = #{code}", " = BINARY #{code}", $condition );
		$condition = str_replace ( " = #{userPerProduct}", " like #{userPerProduct:PARAM_BOTH_LIKE}", $condition );
		
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "discount", "discountFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "discount", "discountTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "min_order_total", "minOrderTotalFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "min_order_total", "minOrderTotalTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "max_use", "maxUseFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "max_use", "maxUseTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "use_per_customer", "usePerCustomerFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $discountCouponExtendVo, "use_per_customer", "usePerCustomerTo", "<=", $condition );
		
		return $condition;
	}
	public function getByFilter(DiscountCouponExtendVo $discountCouponExtendVo) {
		try {
			$query = "select *  from `discount_coupon` ";
			// Set dynamic condition.
			$condition = $this->getCondition ( $discountCouponExtendVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $discountCouponExtendVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $discountCouponExtendVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $discountCouponExtendVo->start_record ) && isset ( $discountCouponExtendVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			} // echo $query;die;
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(DiscountCouponExtendVo $discountCouponExtendVo = null) {
		try {
			$query = "select count(*) from `discount_coupon` ";
			if (isset ( $discountCouponExtendVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $discountCouponExtendVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getByCode(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "select * from `discount_coupon` where `code` = #{code} limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getDiscountCouponByProduct(DiscountCouponExtendVo $discountCouponExtendVo) {
		try {
			$query = "select *  from `discount_coupon` ";
			// Set dynamic condition.
			$condition = $this->getConditionProduct( $discountCouponExtendVo );
			$query .= " where 1=1 ";
			$query .= " and " . $condition;
			$query = $query.$this->buildConditionDiscount($discountCouponExtendVo);
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $discountCouponExtendVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $discountCouponExtendVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $discountCouponExtendVo->start_record ) && isset ( $discountCouponExtendVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			} // echo $query;die;
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildConditionDiscount($filter) {
		$condition = " and 1=1 ";
		$objInfo = get_object_vars ( $filter );
		if (! AppUtil::isEmptyString ( $objInfo ['validFromTo'] )) {
			$condition .= " AND
				CASE
					WHEN valid_from > 0 THEN valid_from <= '".$filter->validFromTo."'
				  ELSE 1 = 1
				END ";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['validToFrom'] )) {
			$condition .= " AND
				CASE
					WHEN valid_to > 0 THEN valid_to >= '".$filter->validToFrom."'
				  ELSE 1 = 1
				END ";
		}
		return $condition;
	}
}