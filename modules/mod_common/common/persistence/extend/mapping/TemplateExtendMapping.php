<?php

namespace common\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use core\database\QueryBuilder;
use common\persistence\base\vo\TemplateVo;

class TemplateExtendMapping {
	public function getTemplateByFilter(TemplateVo $templateVo) {
		try {
            $query = "select * from `template`";
			$queryBuilder = new QueryBuilder ( $templateVo, $query );
			$queryBuilder
                ->appendCondition ( "id", "id" )
                ->appendCondition ( "name", "name", "like", false,":PARAM_BOTH_LIKE")
				->appendOrder ()
				->appendLimit ();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(TemplateVo $templateVo = null) {
		try {
			$query = "select count(*) from `template`";
			$queryBuilder = new QueryBuilder ( $templateVo, $query );
			$queryBuilder
                ->appendCondition ( "id", "id" )
                ->appendCondition ( "name", "name", "like", false,":PARAM_BOTH_LIKE");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), TemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}