<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BatchGroupVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BatchGroupMapping {
	final public function selectByKey(BatchGroupVo $batchGroupVo) {
		try {
			$query = "select * from `batch_group` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BatchGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BatchGroupVo $batchGroupVo = null) {
		try {
			$query = "select * from `batch_group`";
			$queryBuilder = new QueryBuilder ( $batchGroupVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BatchGroupVo $batchGroupVo) {
		try {
			$query = "select * from `batch_group`";
			$queryBuilder = new QueryBuilder ( $batchGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BatchGroupVo $batchGroupVo = null) {
		try {
			$query = "select count(*) from `batch_group`";
			$queryBuilder = new QueryBuilder ( $batchGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BatchGroupVo $batchGroupVo) {
		try {
			$query = "insert into `batch_group`";
			$queryBuilder = new InsertBuilder ( $batchGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`batch_group`", $queryBuilder->getSql (), BatchGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BatchGroupVo $batchGroupVo) {
		try {
			$query = "insert into `batch_group`";
			$queryBuilder = new InsertBuilder ( $batchGroupVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`batch_group`", $queryBuilder->getSql (), BatchGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BatchGroupVo $batchGroupVo) {
		try {
			$query = "update `batch_group`";
			$queryBuilder = new UpdateBuilder ( $batchGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`batch_group`", $queryBuilder->getSql (), BatchGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BatchGroupVo $batchGroupVo) {
		try {
			$query = "delete from `batch_group`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`batch_group`", $query, BatchGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}