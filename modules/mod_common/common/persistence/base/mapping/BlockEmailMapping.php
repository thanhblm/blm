<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BlockEmailVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BlockEmailMapping {
	final public function selectByKey(BlockEmailVo $blockEmailVo) {
		try {
			$query = "select * from `block_email` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BlockEmailVo $blockEmailVo = null) {
		try {
			$query = "select * from `block_email`";
			$queryBuilder = new QueryBuilder ( $blockEmailVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BlockEmailVo $blockEmailVo) {
		try {
			$query = "select * from `block_email`";
			$queryBuilder = new QueryBuilder ( $blockEmailVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`email`", "email")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BlockEmailVo $blockEmailVo = null) {
		try {
			$query = "select count(*) from `block_email`";
			$queryBuilder = new QueryBuilder ( $blockEmailVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`email`", "email");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BlockEmailVo $blockEmailVo) {
		try {
			$query = "insert into `block_email`";
			$queryBuilder = new InsertBuilder ( $blockEmailVo, $query );
			$queryBuilder
				->appendField("`email`", "email");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`block_email`", $queryBuilder->getSql (), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(BlockEmailVo $blockEmailVo) {
		try {
			$query = "insert into `block_email`";
			$queryBuilder = new InsertBuilder ( $blockEmailVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`email`", "email");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`block_email`", $queryBuilder->getSql (), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BlockEmailVo $blockEmailVo) {
		try {
			$query = "update `block_email`";
			$queryBuilder = new UpdateBuilder ( $blockEmailVo, $query );
			$queryBuilder
				->appendField("`email`", "email");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`block_email`", $queryBuilder->getSql (), BlockEmailVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BlockEmailVo $blockEmailVo) {
		try {
			$query = "delete from `block_email`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`block_email`", $query, BlockEmailVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}