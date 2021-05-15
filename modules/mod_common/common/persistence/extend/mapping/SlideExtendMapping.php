<?php

namespace common\persistence\extend\mapping;

use common\filter\slide\SlideFilter;
use common\model\SlideMo;
use common\persistence\base\mapping\SlideMapping;
use core\database\SqlStatementInfo;
use common\persistence\base\vo\SlideVo;
use core\database\QueryBuilder;
use common\persistence\extend\vo\SlideExtendVo;

class SlideExtendMapping extends SlideMapping {
	public function search(SlideFilter $filter) {
		try {
			$queryResult = "select * from ( ";
			$query = "
				select b.*, CONVERT(SUBSTRING_INDEX(b.title , ' ', -1), UNSIGNED INTEGER) reports_range, bg.name slide_group_name, cu.user_name cr_name, mu.user_name md_name from `slide` b
				left join `user` cu on b.cr_by = cu.id
				left join `user` mu on b.cr_by = mu.id
				left join `slide_group` bg on bg.id = b.slide_group_id";
			$queryBuilder = new QueryBuilder($filter, $query );
			$queryBuilder
			->appendCondition ( "b.`id`", "id")
			->appendCondition ( "b.`title`", "title", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "b.`file_name`", "fileName", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "b.`status`", "status")
			->appendCondition ( "b.`slide_group_id`", "slideGroupId")
			->appendCondition ( "b.`cr_date`", "crDateFrom", ">=")
			->appendCondition ( "b.`cr_date`", "crDateTo", "<=")
			->appendCondition ( "b.`md_date`", "mdDateFrom", ">=")
			->appendCondition ( "b.`md_date`", "mdDateTo", "<=")
			->appendCondition ( "bg.`name`", "slideGroupName", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "cu.`user_name`", "crBy", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "mu.`user_name`", "mdBy", "like", false,":PARAM_BOTH_LIKE");
			$queryResult = $queryResult. $queryBuilder->getSql(). ") as tmp ";
			$queryBuilder2 = new QueryBuilder($filter, $queryResult);
			$queryBuilder2
			->appendCondition ( "tmp.`reports_range`", "reportsRangeFrom", ">=", false, ":PARAM_INT")
			->appendCondition ( "tmp.`reports_range`", "reportsRangeTo", "<=" , false, ":PARAM_INT")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder2->getSql(), SlideMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}


    public function getSlideByGroupCode(SlideExtendVo $filter) {
        try {
            $queryResult = "select * from ( ";
            $query = "
				select b.*, CONVERT(SUBSTRING_INDEX(b.title , ' ', -1), UNSIGNED INTEGER) reports_range, bg.name slide_group_name, cu.user_name cr_name, mu.user_name md_name from `slide` b
				left join `user` cu on b.cr_by = cu.id
				left join `user` mu on b.cr_by = mu.id
				inner join `slide_group` bg on bg.id = b.slide_group_id";
            $queryBuilder = new QueryBuilder($filter, $query );
            $queryBuilder
                ->appendCondition ( "b.`id`", "id")
                ->appendCondition ( "b.`title`", "title", "like", false,":PARAM_BOTH_LIKE")
                ->appendCondition ( "b.`file_name`", "fileName", "like", false,":PARAM_BOTH_LIKE")
                ->appendCondition ( "b.`status`", "status")
                ->appendCondition ( "b.`slide_group_id`", "slideGroupId")
                ->appendCondition ( "b.`cr_date`", "crDateFrom", ">=")
                ->appendCondition ( "b.`cr_date`", "crDateTo", "<=")
                ->appendCondition ( "b.`md_date`", "mdDateFrom", ">=")
                ->appendCondition ( "b.`md_date`", "mdDateTo", "<=")
                ->appendCondition ( "bg.`name`", "slideGroupName", "like", false,":PARAM_BOTH_LIKE")
                ->appendCondition ( "bg.`code`", "slideGroupCode")
                ->appendCondition ( "cu.`user_name`", "crBy", "like", false,":PARAM_BOTH_LIKE")
                ->appendCondition ( "mu.`user_name`", "mdBy", "like", false,":PARAM_BOTH_LIKE");
            $queryResult = $queryResult. $queryBuilder->getSql(). ") as tmp ";
            $queryBuilder2 = new QueryBuilder($filter, $queryResult);
            $queryBuilder2
                ->appendCondition ( "tmp.`reports_range`", "reportsRangeFrom", ">=", false, ":PARAM_INT")
                ->appendCondition ( "tmp.`reports_range`", "reportsRangeTo", "<=" , false, ":PARAM_INT")
                ->appendOrder()
                ->appendLimit();
            return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder2->getSql(), SlideMo::class );
        } catch ( \Exception $e ) {
            throw $e;
        }
    }


	public function searchCount(SlideFilter $filter) {
		try {
			$queryResult = "select count(*) from ( ";
			$query = "
				select CONVERT(SUBSTRING_INDEX(b.title , ' ', -1), UNSIGNED INTEGER) reports_range from `slide` b
				left join `user` cu on b.cr_by = cu.id 
				left join `user` mu on b.cr_by = mu.id 
				left join `slide_group` bg on bg.id = b.slide_group_id";
			$queryBuilder = new QueryBuilder($filter, $query );
			$queryBuilder
				->appendCondition ( "b.`id`", "id")
				->appendCondition ( "b.`title`", "title", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "b.`file_name`", "fileName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "b.`status`", "status")
				->appendCondition ( "b.`slide_group_id`", "slideGroupId")
				->appendCondition ( "b.`cr_date`", "crDateFrom", ">=")
				->appendCondition ( "b.`cr_date`", "crDateTo", "<=")
				->appendCondition ( "b.`md_date`", "mdDateFrom", ">=")
				->appendCondition ( "b.`md_date`", "mdDateTo", "<=")
				->appendCondition ( "bg.`name`", "slideGroupName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "cu.`user_name`", "crBy", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "mu.`user_name`", "mdBy", "like", false,":PARAM_BOTH_LIKE");
			$queryResult = $queryResult. $queryBuilder->getSql(). ") as tmp ";
			$queryBuilder2 = new QueryBuilder($filter, $queryResult);
			$queryBuilder2
				->appendCondition ( "tmp.`reports_range`", "reportsRangeFrom", ">=", false, ":PARAM_INT")
				->appendCondition ( "tmp.`reports_range`", "reportsRangeTo", "<=" , false, ":PARAM_INT");
				return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder2->getSql(), SlideMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function delete(SlideVo $slideVo) {
		try {
			$query = "delete from `slide`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`slide`", $query, SlideVo::class, "where slide_group_id = #{slideGroupId} and file_name = #{fileName}");
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function selectByFilterExtend(SlideExtendVo $slideVo) {
		try {
			$query = "select *, CONVERT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(`title`,'Slide',-1),'slide', -1),'-',1),UNSIGNED INTEGER) as  slide_id from `slide`";
			$queryBuilder = new QueryBuilder ( $slideVo, $query );
			$queryBuilder
			->appendCondition ( "`id`", "id")
			->appendCondition ( "`title`", "title")
			->appendCondition ( "`status`", "status")
			->appendCondition ( "`file_name`", "fileName")
			->appendCondition ( "`slide_group_id`", "slideGroupId")
			->appendCondition ( "`cr_date`", "crDate")
			->appendCondition ( "`cr_by`", "crBy")
			->appendCondition ( "`md_date`", "mdDate")
			->appendCondition ( "`md_by`", "mdBy")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	
	
	
	
	
}