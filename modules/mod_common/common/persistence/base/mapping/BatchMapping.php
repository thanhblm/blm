<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BatchVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BatchMapping {
	final public function selectByKey(BatchVo $batchVo) {
		try {
			$query = "select * from `batch` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BatchVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BatchVo $batchVo = null) {
		try {
			$query = "select * from `batch`";
			$queryBuilder = new QueryBuilder ( $batchVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BatchVo $batchVo) {
		try {
			$query = "select * from `batch`";
			$queryBuilder = new QueryBuilder ( $batchVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`file_name`", "fileName")
				->appendCondition ( "`batch_group_id`", "batchGroupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BatchVo $batchVo = null) {
		try {
			$query = "select count(*) from `batch`";
			$queryBuilder = new QueryBuilder ( $batchVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`file_name`", "fileName")
				->appendCondition ( "`batch_group_id`", "batchGroupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BatchVo $batchVo) {
		try {
			$query = "insert into `batch`";
			$queryBuilder = new InsertBuilder ( $batchVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`file_name`", "fileName")
				->appendField("`batch_group_id`", "batchGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`batch`", $queryBuilder->getSql (), BatchVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BatchVo $batchVo) {
		try {
			$query = "insert into `batch`";
			$queryBuilder = new InsertBuilder ( $batchVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`file_name`", "fileName")
				->appendField("`batch_group_id`", "batchGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`batch`", $queryBuilder->getSql (), BatchVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BatchVo $batchVo) {
		try {
			$query = "update `batch`";
			$queryBuilder = new UpdateBuilder ( $batchVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`file_name`", "fileName")
				->appendField("`batch_group_id`", "batchGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`batch`", $queryBuilder->getSql (), BatchVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BatchVo $batchVo) {
		try {
			$query = "delete from `batch`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`batch`", $query, BatchVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}