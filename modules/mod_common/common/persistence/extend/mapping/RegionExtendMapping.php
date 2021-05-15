<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\RegionVo;
use common\persistence\extend\vo\RegionExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class RegionExtendMapping {
	public function getByFilter(RegionExtendVo $regionVo) {
		try {
			$query = "
				select 
					r.*, 
					cu.user_name as cr_by_name,
					mu.user_name as md_by_name
				from `region` r
				left join `user` cu on cu.id = r.cr_by
				left join `user` mu on mu.id = r.md_by";
			$queryBuilder = new QueryBuilder( $regionVo, $query );
			$queryBuilder
				->appendCondition ( "r.id", "id")
				->appendCondition ( "r.name", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "r.status", "status")
				->appendCondition ( "r.currency_code", "currencyCode", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "r.fallback_region", "fallbackRegion")
				->appendCondition ( "r.cr_date", "crDateFrom", ">=")
				->appendCondition ( "r.cr_date", "crDateTo", "<=")
				->appendCondition ( "r.md_date", "mdDateFrom", ">=")
				->appendCondition ( "r.md_date", "mdDateTo", "<=")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), RegionExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(RegionExtendVo $regionVo = null) {
		try {
			$query = "
				select 
					count(*)
				from `region` r
				left join `user` cu on cu.id = r.cr_by
				left join `user` mu on mu.id = r.md_by";
			$queryBuilder = new QueryBuilder( $regionVo, $query );
			$queryBuilder
				->appendCondition ( "r.id", "id")
				->appendCondition ( "r.name", "name", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "r.status", "status")
				->appendCondition ( "r.currency_code", "currencyCode", "like", false, ":PARAM_BOTH_LIKE")
				->appendCondition ( "r.fallback_region", "fallbackRegion")
				->appendCondition ( "r.cr_date", "crDateFrom", ">=")
				->appendCondition ( "r.cr_date", "crDateTo", "<=")
				->appendCondition ( "r.md_date", "mdDateFrom", ">=")
				->appendCondition ( "r.md_date", "mdDateTo", "<=");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function updateAll(RegionVo $regionVo){
		try {
			$query = "update `region`";
			$queryBuilder = new UpdateBuilder( $regionVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`contact_email`", "contactEmail")
				->appendField("`invoice_logo`", "invoiceLogo")
				->appendField("`invoice_header`", "invoiceHeader")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`status`", "status")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`fallback_region`", "fallbackRegion")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`region`", $queryBuilder->getSql (), RegionVo::class, null );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}