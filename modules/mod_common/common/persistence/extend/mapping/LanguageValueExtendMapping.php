<?php

namespace common\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use common\persistence\extend\vo\LanguageValueExtendVo;
use core\database\QueryBuilder;

class LanguageValueExtendMapping {
	public function getByFilter(LanguageValueExtendVo $languageValueExtendVo) {
		try {
			$query = "select 
						lv.*, 
					    cu.user_name as cr_by_name,
					    mu.user_name as md_by_name
					from `language_value` lv
					left join `user` cu on cu.id = lv.cr_by
					left join `user` mu on mu.id = lv.md_by";
			$queryBuilder = new QueryBuilder( $languageValueExtendVo, $query );
			$queryBuilder
				->appendCondition ( "lv.`language_code`", "languageCode")
				->appendCondition ( "lv.`original`", "original", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "lv.`destination`", "destination", "like", false, ":PARAM_BOTH_LIKE")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), LanguageValueExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(LanguageValueExtendVo $languageValueExtendVo = null) {
		try {
			$query = "select 
						count(*)
					from `language_value` lv
					left join `user` cu on cu.id = lv.cr_by
					left join `user` mu on mu.id = lv.md_by";
			$queryBuilder = new QueryBuilder( $languageValueExtendVo, $query );
			$queryBuilder
				->appendCondition ( "lv.`language_code`", "languageCode")
				->appendCondition ( "lv.`original`", "original", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "lv.`destination`", "destination", "like", false, ":PARAM_BOTH_LIKE");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), LanguageValueExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function copyLanguageValueByCode(LanguageValueExtendVo $filter){
		try {
			$query = "insert into language_value (`key`,original, destination, language_code, cr_date, cr_by, md_date, md_by)
					select `key`, original, destination, #{newLanguageCode}, #{crDate}, #{crBy}, #{mdDate}, #{mdBy}
					from language_value
					where language_code = #{languageCode} 
						and `key` not in (select `key` from language_value where language_code = #{newLanguageCode})";
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, null, $query, LanguageValueExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteLanguageValueByCode(LanguageValueExtendVo $filter){
		try {
			$query = "delete from language_value
					where language_code = #{languageCode}";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, LanguageValueExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}