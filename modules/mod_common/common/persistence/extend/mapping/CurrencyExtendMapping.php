<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\CurrencyExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class CurrencyExtendMapping {
	public function getByFilter(CurrencyExtendVo $currencyVo) {
		try {
			$query = "select 
						c.*, 
						cu.user_name as cr_by_name,
						mu.user_name as md_by_name
					from `currency` c
					left join `user` cu on cu.id = c.cr_by
					left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder( $currencyVo, $query );
			$queryBuilder
				->appendCondition ( "c.`code`", "code", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.`symbol`", "symbol")
				->appendCondition ( "c.`placement`", "placement")
				->appendCondition ( "c.`decimal`", "decimal")
				->appendCondition ( "c.`status`", "status")
				->appendCondition ( "c.`cr_date`", "crDateFrom")
				->appendCondition ( "c.`cr_date`", "crDateTo")
				->appendCondition ( "c.`md_date`", "mdDateFrom")
				->appendCondition ( "c.`md_date`", "mdDateTo")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CurrencyExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(CurrencyExtendVo $currencyVo = null) {
		try {
			$query = "select 
						count(*)
					from `currency` c
					left join `user` cu on cu.id = c.cr_by
					left join `user` mu on mu.id = c.md_by";
			$queryBuilder = new QueryBuilder( $currencyVo, $query );
			$queryBuilder
				->appendCondition ( "c.`code`", "code", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "c.`symbol`", "symbol")
				->appendCondition ( "c.`placement`", "placement")
				->appendCondition ( "c.`decimal`", "decimal")
				->appendCondition ( "c.`status`", "status")
				->appendCondition ( "c.`cr_date`", "crDateFrom")
				->appendCondition ( "c.`cr_date`", "crDateTo")
				->appendCondition ( "c.`md_date`", "mdDateFrom")
				->appendCondition ( "c.`md_date`", "mdDateTo");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), CurrencyExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}