<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\LanguageExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class LanguageExtendMapping {
	public function getByFilter(LanguageExtendVo $languageExtendVo) {
		try {
			$query = "select 
						l.*, 
					    cu.user_name as cr_by_name,
					    mu.user_name as md_by_name
					from `language` l
					left join `user` cu on cu.id = l.cr_by
					left join `user` mu on mu.id = l.md_by";
			$queryBuilder = new QueryBuilder( $languageExtendVo, $query );
			$queryBuilder
				->appendCondition ( "l.`code`", "code", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "l.`name`", "name", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "l.`locale_name`", "localeName", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "l.`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), LanguageExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(LanguageExtendVo $languageExtendVo = null) {
		try {
			$query = "select 
						count(*)
					from `language` l
					left join `user` cu on cu.id = l.cr_by
					left join `user` mu on mu.id = l.md_by";
			$queryBuilder = new QueryBuilder( $languageExtendVo, $query );
			$queryBuilder
				->appendCondition ( "l.`code`", "code", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "l.`name`", "name", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "l.`locale_name`", "localeName", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "l.`status`", "status");
			return new SqlStatementInfo( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), LanguageExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}