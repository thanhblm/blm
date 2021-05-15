<?php

namespace common\persistence\extend\mapping;

use common\filter\batch\BatchFilter;
use common\model\BatchMo;
use common\persistence\base\mapping\BatchMapping;
use core\database\SqlStatementInfo;
use common\persistence\base\vo\BatchVo;
use core\database\QueryBuilder;
use common\persistence\extend\vo\BatchExtendVo;

class BatchExtendMapping extends BatchMapping {
	public function search(BatchFilter $filter) {
		try {
			$queryResult = "select * from ( ";
			$query = "
				select b.*, CONVERT(SUBSTRING_INDEX(b.title , ' ', -1), UNSIGNED INTEGER) reports_range, bg.name batch_group_name, cu.user_name cr_name, mu.user_name md_name from `batch` b
				left join `user` cu on b.cr_by = cu.id
				left join `user` mu on b.cr_by = mu.id
				left join `batch_group` bg on bg.id = b.batch_group_id";
			$queryBuilder = new QueryBuilder($filter, $query );
			$queryBuilder
			->appendCondition ( "b.`id`", "id")
			->appendCondition ( "b.`title`", "title", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "b.`file_name`", "fileName", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "b.`status`", "status")
			->appendCondition ( "b.`batch_group_id`", "batchGroupId")
			->appendCondition ( "b.`cr_date`", "crDateFrom", ">=")
			->appendCondition ( "b.`cr_date`", "crDateTo", "<=")
			->appendCondition ( "b.`md_date`", "mdDateFrom", ">=")
			->appendCondition ( "b.`md_date`", "mdDateTo", "<=")
			->appendCondition ( "bg.`name`", "batchGroupName", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "cu.`user_name`", "crBy", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "mu.`user_name`", "mdBy", "like", false,":PARAM_BOTH_LIKE");
			$queryResult = $queryResult. $queryBuilder->getSql(). ") as tmp ";
			$queryBuilder2 = new QueryBuilder($filter, $queryResult);
			$queryBuilder2
			->appendCondition ( "tmp.`reports_range`", "reportsRangeFrom", ">=", false, ":PARAM_INT")
			->appendCondition ( "tmp.`reports_range`", "reportsRangeTo", "<=" , false, ":PARAM_INT")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder2->getSql(), BatchMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(BatchFilter $filter) {
		try {
			$queryResult = "select count(*) from ( ";
			$query = "
				select CONVERT(SUBSTRING_INDEX(b.title , ' ', -1), UNSIGNED INTEGER) reports_range from `batch` b
				left join `user` cu on b.cr_by = cu.id 
				left join `user` mu on b.cr_by = mu.id 
				left join `batch_group` bg on bg.id = b.batch_group_id";
			$queryBuilder = new QueryBuilder($filter, $query );
			$queryBuilder
				->appendCondition ( "b.`id`", "id")
				->appendCondition ( "b.`title`", "title", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "b.`file_name`", "fileName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "b.`status`", "status")
				->appendCondition ( "b.`batch_group_id`", "batchGroupId")
				->appendCondition ( "b.`cr_date`", "crDateFrom", ">=")
				->appendCondition ( "b.`cr_date`", "crDateTo", "<=")
				->appendCondition ( "b.`md_date`", "mdDateFrom", ">=")
				->appendCondition ( "b.`md_date`", "mdDateTo", "<=")
				->appendCondition ( "bg.`name`", "batchGroupName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "cu.`user_name`", "crBy", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "mu.`user_name`", "mdBy", "like", false,":PARAM_BOTH_LIKE");
			$queryResult = $queryResult. $queryBuilder->getSql(). ") as tmp ";
			$queryBuilder2 = new QueryBuilder($filter, $queryResult);
			$queryBuilder2
				->appendCondition ( "tmp.`reports_range`", "reportsRangeFrom", ">=", false, ":PARAM_INT")
				->appendCondition ( "tmp.`reports_range`", "reportsRangeTo", "<=" , false, ":PARAM_INT");
				return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder2->getSql(), BatchMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function delete(BatchVo $batchVo) {
		try {
			$query = "delete from `batch`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`batch`", $query, BatchVo::class, "where batch_group_id = #{batchGroupId} and file_name = #{fileName}");
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function selectByFilterExtend(BatchExtendVo $batchVo) {
		try {
			$query = "select *, CONVERT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(`title`,'Batch',-1),'batch', -1),'-',1),UNSIGNED INTEGER) as  batch_id from `batch`";
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
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BatchExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	
	
	
	
	
}