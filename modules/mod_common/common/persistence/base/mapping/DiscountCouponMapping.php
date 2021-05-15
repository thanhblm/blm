<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\DiscountCouponVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class DiscountCouponMapping {
	final public function selectByKey(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "select * from `discount_coupon` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(DiscountCouponVo $discountCouponVo = null) {
		try {
			$query = "select * from `discount_coupon`";
			$queryBuilder = new QueryBuilder ( $discountCouponVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "select * from `discount_coupon`";
			$queryBuilder = new QueryBuilder ( $discountCouponVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`discount`", "discount")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`min_order_total`", "minOrderTotal")
				->appendCondition ( "`valid_from`", "validFrom")
				->appendCondition ( "`valid_to`", "validTo")
				->appendCondition ( "`max_use`", "maxUse")
				->appendCondition ( "`use_per_customer`", "usePerCustomer")
				->appendCondition ( "`user_per_product`", "userPerProduct")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(DiscountCouponVo $discountCouponVo = null) {
		try {
			$query = "select count(*) from `discount_coupon`";
			$queryBuilder = new QueryBuilder ( $discountCouponVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`discount`", "discount")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`min_order_total`", "minOrderTotal")
				->appendCondition ( "`valid_from`", "validFrom")
				->appendCondition ( "`valid_to`", "validTo")
				->appendCondition ( "`max_use`", "maxUse")
				->appendCondition ( "`use_per_customer`", "usePerCustomer")
				->appendCondition ( "`user_per_product`", "userPerProduct")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "insert into `discount_coupon`";
			$queryBuilder = new InsertBuilder ( $discountCouponVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`discount`", "discount")
				->appendField("`status`", "status")
				->appendField("`min_order_total`", "minOrderTotal")
				->appendField("`valid_from`", "validFrom")
				->appendField("`valid_to`", "validTo")
				->appendField("`max_use`", "maxUse")
				->appendField("`use_per_customer`", "usePerCustomer")
				->appendField("`user_per_product`", "userPerProduct")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`discount_coupon`", $queryBuilder->getSql (), DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "insert into `discount_coupon`";
			$queryBuilder = new InsertBuilder ( $discountCouponVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`discount`", "discount")
				->appendField("`status`", "status")
				->appendField("`min_order_total`", "minOrderTotal")
				->appendField("`valid_from`", "validFrom")
				->appendField("`valid_to`", "validTo")
				->appendField("`max_use`", "maxUse")
				->appendField("`use_per_customer`", "usePerCustomer")
				->appendField("`user_per_product`", "userPerProduct")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`discount_coupon`", $queryBuilder->getSql (), DiscountCouponVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "update `discount_coupon`";
			$queryBuilder = new UpdateBuilder ( $discountCouponVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`name`", "name")
				->appendField("`discount`", "discount")
				->appendField("`status`", "status")
				->appendField("`min_order_total`", "minOrderTotal")
				->appendField("`valid_from`", "validFrom")
				->appendField("`valid_to`", "validTo")
				->appendField("`max_use`", "maxUse")
				->appendField("`use_per_customer`", "usePerCustomer")
				->appendField("`user_per_product`", "userPerProduct")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`discount_coupon`", $queryBuilder->getSql (), DiscountCouponVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(DiscountCouponVo $discountCouponVo) {
		try {
			$query = "delete from `discount_coupon`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`discount_coupon`", $query, DiscountCouponVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}