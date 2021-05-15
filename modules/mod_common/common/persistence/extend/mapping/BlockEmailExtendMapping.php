<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BlockEmailVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class BlockEmailExtendMapping  {
	public function getByFilter(BlockEmailVo $blockEmailVo) {
		try {
			$query = "select * from block_email be";
			$queryBuilder = new QueryBuilder($blockEmailVo, $query );
			$queryBuilder
				->appendCondition ( "be.`id`", "id")
				->appendCondition ( "be.`email`", "email", "like", false,":PARAM_BOTH_LIKE")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(BlockEmailVo $blockEmailVo) {
		try {
			$query = "select count(*) from block_email be";
			$queryBuilder = new QueryBuilder($blockEmailVo, $query );
			$queryBuilder
				->appendCondition ( "be.`id`", "id")
				->appendCondition ( "be.`email`", "email", "like", false,":PARAM_BOTH_LIKE");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getBlockEmailByEmail(BlockEmailVo $blockEmailVo) {
		try {
			$query = "select * from block_email be";
			$queryBuilder = new QueryBuilder($blockEmailVo, $query );
			$queryBuilder->appendCondition ( "be.`email`", "email");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BlockEmailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}