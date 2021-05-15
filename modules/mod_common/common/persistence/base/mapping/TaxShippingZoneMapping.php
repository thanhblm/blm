<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\TaxShippingZoneVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class TaxShippingZoneMapping {
	final public function selectByKey(TaxShippingZoneVo $taxShippingZoneVo) {
		try {
			$query = "select * from `tax_shipping_zone` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxShippingZoneVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(TaxShippingZoneVo $taxShippingZoneVo = null) {
		try {
			$query = "select * from `tax_shipping_zone`";
			$queryBuilder = new QueryBuilder ( $taxShippingZoneVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxShippingZoneVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(TaxShippingZoneVo $taxShippingZoneVo) {
		try {
			$query = "select * from `tax_shipping_zone`";
			$queryBuilder = new QueryBuilder ( $taxShippingZoneVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`exclusive`", "exclusive")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxShippingZoneVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(TaxShippingZoneVo $taxShippingZoneVo = null) {
		try {
			$query = "select count(*) from `tax_shipping_zone`";
			$queryBuilder = new QueryBuilder ( $taxShippingZoneVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`exclusive`", "exclusive")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxShippingZoneVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(TaxShippingZoneVo $taxShippingZoneVo) {
		try {
			$query = "insert into `tax_shipping_zone`";
			$queryBuilder = new InsertBuilder ( $taxShippingZoneVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`exclusive`", "exclusive")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_shipping_zone`", $queryBuilder->getSql (), TaxShippingZoneVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(TaxShippingZoneVo $taxShippingZoneVo) {
		try {
			$query = "insert into `tax_shipping_zone`";
			$queryBuilder = new InsertBuilder ( $taxShippingZoneVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`exclusive`", "exclusive")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_shipping_zone`", $queryBuilder->getSql (), TaxShippingZoneVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(TaxShippingZoneVo $taxShippingZoneVo) {
		try {
			$query = "update `tax_shipping_zone`";
			$queryBuilder = new UpdateBuilder ( $taxShippingZoneVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`exclusive`", "exclusive")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`tax_shipping_zone`", $queryBuilder->getSql (), TaxShippingZoneVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(TaxShippingZoneVo $taxShippingZoneVo) {
		try {
			$query = "delete from `tax_shipping_zone`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`tax_shipping_zone`", $query, TaxShippingZoneVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}