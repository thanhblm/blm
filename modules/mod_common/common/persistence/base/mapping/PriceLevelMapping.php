<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\PriceLevelVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class PriceLevelMapping {
	final public function selectByKey(PriceLevelVo $priceLevelVo) {
		try {
			$query = "select * from `price_level` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(PriceLevelVo $priceLevelVo = null) {
		try {
			$query = "select * from `price_level`";
			$queryBuilder = new QueryBuilder ( $priceLevelVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(PriceLevelVo $priceLevelVo) {
		try {
			$query = "select * from `price_level`";
			$queryBuilder = new QueryBuilder ( $priceLevelVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`value`", "value")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(PriceLevelVo $priceLevelVo = null) {
		try {
			$query = "select count(*) from `price_level`";
			$queryBuilder = new QueryBuilder ( $priceLevelVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`value`", "value")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(PriceLevelVo $priceLevelVo) {
		try {
			$query = "insert into `price_level`";
			$queryBuilder = new InsertBuilder ( $priceLevelVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`value`", "value")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`price_level`", $queryBuilder->getSql (), PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(PriceLevelVo $priceLevelVo) {
		try {
			$query = "insert into `price_level`";
			$queryBuilder = new InsertBuilder ( $priceLevelVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`value`", "value")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`price_level`", $queryBuilder->getSql (), PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(PriceLevelVo $priceLevelVo) {
		try {
			$query = "update `price_level`";
			$queryBuilder = new UpdateBuilder ( $priceLevelVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`value`", "value")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`price_level`", $queryBuilder->getSql (), PriceLevelVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(PriceLevelVo $priceLevelVo) {
		try {
			$query = "delete from `price_level`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`price_level`", $query, PriceLevelVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}