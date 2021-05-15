<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\ContactExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;
use common\persistence\base\vo\ContactVo;

class ContactExtendMapping {
	public function getByFilter(ContactExtendVo $contactVo) {
		try {
			$query = "
				select c.*, ct.name as country_name from `contact` c
				left join country ct on ct.iso2 = c.country_code";
			$queryBuilder = new QueryBuilder ( $contactVo, $query );
			$queryBuilder->appendCondition ( "c.`id`", "id" )
				->appendCondition ( "c.`full_name`", "fullName", "like", false, ":PARAM_BOTH_LIKE" )
				->appendCondition ( "c.`email`", "email", "like", false, ":PARAM_BOTH_LIKE" )
				->appendCondition ( "c.`phone`", "phone", "like", false, ":PARAM_BOTH_LIKE" )
				->appendCondition ( "c.`country_code`", "countryCode" )
				->appendCondition ( "c.`status`", "status" )
				->appendCondition ( "c.`cr_date`", "crDateFrom", ">=" )
				->appendCondition ( "c.`cr_date`", "crDateTo", "<=" )
				->appendOrder ()
				->appendLimit ();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContactExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(ContactExtendVo $contactVo = null) {
		try {
			$query = "
				select count(*) from `contact` c
				left join country ct on ct.iso2 = c.country_code";
			$queryBuilder = new QueryBuilder ( $contactVo, $query );
			$queryBuilder->appendCondition ( "c.`id`", "id" )
				->appendCondition ( "c.`full_name`", "fullName", "like", false, ":PARAM_BOTH_LIKE" )
				->appendCondition ( "c.`email`", "email", "like", false, ":PARAM_BOTH_LIKE" )
				->appendCondition ( "c.`phone`", "phone", "like", false, ":PARAM_BOTH_LIKE" )
				->appendCondition ( "c.`country_code`", "countryCode" )
				->appendCondition ( "c.`status`", "status" )
				->appendCondition ( "c.`cr_date`", "crDateFrom", ">=" )
				->appendCondition ( "c.`cr_date`", "crDateTo", "<=" );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContactExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getById(ContactVo $contactVo) {
		try {
			$query = "
				select c.*, ct.name as country_name from `contact` c
				left join country ct on ct.iso2 = c.country_code
				where c.id = #{id}
				limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ContactExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}