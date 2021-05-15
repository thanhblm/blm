<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\TaxRateVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class TaxRateMapping {
	final public function selectByKey(TaxRateVo $taxRateVo) {
		try {
			$query = "select * from `tax_rate` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(TaxRateVo $taxRateVo = null) {
		try {
			$query = "select * from `tax_rate`";
			$queryBuilder = new QueryBuilder ( $taxRateVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxRateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(TaxRateVo $taxRateVo) {
		try {
			$query = "select * from `tax_rate`";
			$queryBuilder = new QueryBuilder ( $taxRateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxRateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(TaxRateVo $taxRateVo = null) {
		try {
			$query = "select count(*) from `tax_rate`";
			$queryBuilder = new QueryBuilder ( $taxRateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TaxRateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(TaxRateVo $taxRateVo) {
		try {
			$query = "insert into `tax_rate`";
			$queryBuilder = new InsertBuilder ( $taxRateVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_rate`", $queryBuilder->getSql (), TaxRateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(TaxRateVo $taxRateVo) {
		try {
			$query = "insert into `tax_rate`";
			$queryBuilder = new InsertBuilder ( $taxRateVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`tax_rate`", $queryBuilder->getSql (), TaxRateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(TaxRateVo $taxRateVo) {
		try {
			$query = "update `tax_rate`";
			$queryBuilder = new UpdateBuilder ( $taxRateVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`tax_rate`", $queryBuilder->getSql (), TaxRateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(TaxRateVo $taxRateVo) {
		try {
			$query = "delete from `tax_rate`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`tax_rate`", $query, TaxRateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}