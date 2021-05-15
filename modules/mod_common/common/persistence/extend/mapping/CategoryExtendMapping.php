<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\CategoryExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class CategoryExtendMapping {
	public function getByFilter(CategoryExtendVo $categoryExtendVo) {
		try {
			$query = "
				select 
					c.*, 
				    cu.user_name as cr_by_name,
				    mu.user_name as md_by_name
				from `category` c
				left join `user` cu on cu.id = c.cr_by
				left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder( $categoryExtendVo, $query );
			$queryBuilder
			->appendCondition ( "c.id", "id")
			->appendCondition ( "c.code", "code")
			->appendCondition ( "c.name", "name", "like", false, ":PARAM_BOTH_LIKE")
			->appendCondition ( "c.status", "status")
			->appendCondition ( "c.featured", "featured")
			->appendCondition ( "c.cr_date", "crDateFrom", ">=")
			->appendCondition ( "c.cr_date", "crDateTo", "<=")
			->appendCondition ( "c.md_date", "mdDateFrom", ">=")
			->appendCondition ( "c.md_date", "mdDateTo", "<=")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(CategoryExtendVo $categoryExtendVo = null) {
		try {
			$query = "
				select 
					count(*)
				from `category` c
				left join `user` cu on cu.id = c.cr_by
				left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder( $categoryExtendVo, $query );
				$queryBuilder
				->appendCondition ( "c.id", "id")
				->appendCondition ( "c.code", "code")
				->appendCondition ( "c.name", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.status", "status")
				->appendCondition ( "c.featured", "featured")
				->appendCondition ( "c.cr_date", "crDateFrom", ">=")
				->appendCondition ( "c.cr_date", "crDateTo", "<=")
				->appendCondition ( "c.md_date", "mdDateFrom", ">=")
				->appendCondition ( "c.md_date", "mdDateTo", "<=");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CategoryExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}