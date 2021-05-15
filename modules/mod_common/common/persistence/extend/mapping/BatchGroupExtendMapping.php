<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\BatchGroupMapping;
use core\database\SqlStatementInfo;
use common\model\BatchGroupMo;
use common\filter\batch_group\SlideGroupFilter;
use core\database\QueryBuilder;

class BatchGroupExtendMapping extends BatchGroupMapping{
	public function search(SlideGroupFilter $filter) {
		try {
			$query = "select * from batch_group";
			$queryBuilder = new QueryBuilder($filter, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BatchGroupMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(SlideGroupFilter $filter) {
		try {
			$query = "select count(*) from batch_group";
			$queryBuilder = new QueryBuilder($filter, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), BatchGroupMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}