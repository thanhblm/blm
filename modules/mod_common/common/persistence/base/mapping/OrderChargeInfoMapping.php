<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderChargeInfoVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderChargeInfoMapping {
	final public function selectByKey(OrderChargeInfoVo $orderChargeInfoVo) {
		try {
			$query = "select * from `order_charge_info` where (`order_id` = #{orderId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderChargeInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderChargeInfoVo $orderChargeInfoVo = null) {
		try {
			$query = "select * from `order_charge_info`";
			$queryBuilder = new QueryBuilder ( $orderChargeInfoVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderChargeInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderChargeInfoVo $orderChargeInfoVo) {
		try {
			$query = "select * from `order_charge_info`";
			$queryBuilder = new QueryBuilder ( $orderChargeInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`old_mega_id`", "oldMegaId")
				->appendCondition ( "`sub_total_amount`", "subTotalAmount")
				->appendCondition ( "`tax_amount`", "taxAmount")
				->appendCondition ( "`discount_amount`", "discountAmount")
				->appendCondition ( "`shipping_amount`", "shippingAmount")
				->appendCondition ( "`grand_total_amount`", "grandTotalAmount")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderChargeInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderChargeInfoVo $orderChargeInfoVo = null) {
		try {
			$query = "select count(*) from `order_charge_info`";
			$queryBuilder = new QueryBuilder ( $orderChargeInfoVo, $query );
			$queryBuilder
				->appendCondition ( "`order_id`", "orderId")
				->appendCondition ( "`old_mega_id`", "oldMegaId")
				->appendCondition ( "`sub_total_amount`", "subTotalAmount")
				->appendCondition ( "`tax_amount`", "taxAmount")
				->appendCondition ( "`discount_amount`", "discountAmount")
				->appendCondition ( "`shipping_amount`", "shippingAmount")
				->appendCondition ( "`grand_total_amount`", "grandTotalAmount");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderChargeInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderChargeInfoVo $orderChargeInfoVo) {
		try {
			$query = "insert into `order_charge_info`";
			$queryBuilder = new InsertBuilder ( $orderChargeInfoVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`old_mega_id`", "oldMegaId")
				->appendField("`sub_total_amount`", "subTotalAmount")
				->appendField("`tax_amount`", "taxAmount")
				->appendField("`discount_amount`", "discountAmount")
				->appendField("`shipping_amount`", "shippingAmount")
				->appendField("`grand_total_amount`", "grandTotalAmount");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_charge_info`", $queryBuilder->getSql (), OrderChargeInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderChargeInfoVo $orderChargeInfoVo) {
		try {
			$query = "insert into `order_charge_info`";
			$queryBuilder = new InsertBuilder ( $orderChargeInfoVo, $query );
			$queryBuilder
				->appendField("`order_id`", "orderId")
				->appendField("`old_mega_id`", "oldMegaId")
				->appendField("`sub_total_amount`", "subTotalAmount")
				->appendField("`tax_amount`", "taxAmount")
				->appendField("`discount_amount`", "discountAmount")
				->appendField("`shipping_amount`", "shippingAmount")
				->appendField("`grand_total_amount`", "grandTotalAmount");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order_charge_info`", $queryBuilder->getSql (), OrderChargeInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderChargeInfoVo $orderChargeInfoVo) {
		try {
			$query = "update `order_charge_info`";
			$queryBuilder = new UpdateBuilder ( $orderChargeInfoVo, $query );
			$queryBuilder
				->appendField("`old_mega_id`", "oldMegaId")
				->appendField("`sub_total_amount`", "subTotalAmount")
				->appendField("`tax_amount`", "taxAmount")
				->appendField("`discount_amount`", "discountAmount")
				->appendField("`shipping_amount`", "shippingAmount")
				->appendField("`grand_total_amount`", "grandTotalAmount");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order_charge_info`", $queryBuilder->getSql (), OrderChargeInfoVo::class, "where (`order_id` = #{orderId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderChargeInfoVo $orderChargeInfoVo) {
		try {
			$query = "delete from `order_charge_info`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order_charge_info`", $query, OrderChargeInfoVo::class, "where (`order_id` = #{orderId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}