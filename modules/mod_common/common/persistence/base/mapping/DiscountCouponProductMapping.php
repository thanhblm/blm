<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\DiscountCouponProductVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class DiscountCouponProductMapping {
	final public function selectByKey(DiscountCouponProductVo $discountCouponProductVo) {
		try {
			$query = "select * from `discount_coupon_product` where (`discount_coupon_id` = #{discountCouponId}) and (`item_id` = #{itemId}) and (`item_type` = #{itemType}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(DiscountCouponProductVo $discountCouponProductVo = null) {
		try {
			$query = "select * from `discount_coupon_product`";
			$queryBuilder = new QueryBuilder ( $discountCouponProductVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), DiscountCouponProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(DiscountCouponProductVo $discountCouponProductVo) {
		try {
			$query = "select * from `discount_coupon_product`";
			$queryBuilder = new QueryBuilder ( $discountCouponProductVo, $query );
			$queryBuilder
				->appendCondition ( "`discount_coupon_id`", "discountCouponId")
				->appendCondition ( "`item_id`", "itemId")
				->appendCondition ( "`item_type`", "itemType")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), DiscountCouponProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(DiscountCouponProductVo $discountCouponProductVo = null) {
		try {
			$query = "select count(*) from `discount_coupon_product`";
			$queryBuilder = new QueryBuilder ( $discountCouponProductVo, $query );
			$queryBuilder
				->appendCondition ( "`discount_coupon_id`", "discountCouponId")
				->appendCondition ( "`item_id`", "itemId")
				->appendCondition ( "`item_type`", "itemType");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), DiscountCouponProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(DiscountCouponProductVo $discountCouponProductVo) {
		try {
			$query = "insert into `discount_coupon_product`";
			$queryBuilder = new InsertBuilder ( $discountCouponProductVo, $query );
			$queryBuilder
				->appendField("`discount_coupon_id`", "discountCouponId")
				->appendField("`item_id`", "itemId")
				->appendField("`item_type`", "itemType");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`discount_coupon_product`", $queryBuilder->getSql (), DiscountCouponProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(DiscountCouponProductVo $discountCouponProductVo) {
		try {
			$query = "insert into `discount_coupon_product`";
			$queryBuilder = new InsertBuilder ( $discountCouponProductVo, $query );
			$queryBuilder
				->appendField("`discount_coupon_id`", "discountCouponId")
				->appendField("`item_id`", "itemId")
				->appendField("`item_type`", "itemType");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`discount_coupon_product`", $queryBuilder->getSql (), DiscountCouponProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(DiscountCouponProductVo $discountCouponProductVo) {
		try {
			$query = "update `discount_coupon_product`";
			$queryBuilder = new UpdateBuilder ( $discountCouponProductVo, $query );
			$queryBuilder;
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`discount_coupon_product`", $queryBuilder->getSql (), DiscountCouponProductVo::class, "where (`discount_coupon_id` = #{discountCouponId}) and (`item_id` = #{itemId}) and (`item_type` = #{itemType})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(DiscountCouponProductVo $discountCouponProductVo) {
		try {
			$query = "delete from `discount_coupon_product`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`discount_coupon_product`", $query, DiscountCouponProductVo::class, "where (`discount_coupon_id` = #{discountCouponId}) and (`item_id` = #{itemId}) and (`item_type` = #{itemType})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}