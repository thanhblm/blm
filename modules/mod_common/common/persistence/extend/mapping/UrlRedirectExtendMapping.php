<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\UrlRedirectExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class UrlRedirectExtendMapping {
	public function getByFilter(UrlRedirectExtendVo $urlRedirectExtendVo) {
		try {
			$query = "select 
						ur.*, 
						cu.user_name as cr_by_name,
						mu.user_name as md_by_name
					from `url_redirect` ur
					left join `user` cu on cu.id = ur.cr_by
					left join `user` mu on mu.id = ur.md_by";
			$queryBuilder = new QueryBuilder ( $urlRedirectExtendVo, $query );
			$queryBuilder
					->appendCondition ( "ur.`id`", "id" )
					->appendCondition ( "ur.`old_url`", "oldUrl", "like", false, ":PARAM_BOTH_LIKE" )
					->appendCondition ( "ur.`new_url`", "newUrl", "like", false, ":PARAM_BOTH_LIKE" )
					->appendOrder ()
					->appendLimit ();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UrlRedirectExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(UrlRedirectExtendVo $urlRedirectExtendVo = null) {
		try {
			$query = "select 
						count(*)
					from `url_redirect` ur
					left join `user` cu on cu.id = ur.cr_by
					left join `user` mu on mu.id = ur.md_by";
			$queryBuilder = new QueryBuilder ( $urlRedirectExtendVo, $query );
			$queryBuilder
					->appendCondition ( "ur.`id`", "id" )
					->appendCondition ( "ur.`old_url`", "oldUrl", "like", false, ":PARAM_BOTH_LIKE" )
					->appendCondition ( "ur.`new_url`", "newUrl", "like", false, ":PARAM_BOTH_LIKE" );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UrlRedirectExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}