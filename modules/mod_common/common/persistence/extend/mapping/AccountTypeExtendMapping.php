<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\AccountTypeMapping;
use core\database\SqlStatementInfo;
use common\persistence\base\vo\AccountTypeVo;
use core\database\QueryBuilder;

class AccountTypeExtendMapping extends AccountTypeMapping{
	public function search(AccountTypeVo $accountTypeVo) {
		try {
			$query = "select * from account_type";
			$queryBuilder = new QueryBuilder( $accountTypeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name", "like", false,":PARAM_BOTH_LIKE")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(AccountTypeVo $accountTypeVo) {
		try {
			$query = "select count(*) from account_type";
			$queryBuilder = new QueryBuilder( $accountTypeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name", "like", false,":PARAM_BOTH_LIKE");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), AccountTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}