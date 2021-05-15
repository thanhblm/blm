<?php
namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class ProductExtendMapping{
	public function getProductByFilter(ProductVo $productVo) {
		try {
			$query = "select * from product";
			$queryBuilder = new QueryBuilder( $productVo, $query );
			$queryBuilder
			->appendCondition ( "`id`", "id")
			->appendCondition ( "`item_code`", "itemCode")
			->appendCondition ( "`code`", "code")
			->appendCondition ( "`name`", "name", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "`featured`", "featured")
			->appendCondition ( "`status`", "status")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function countProductByFilter(ProductVo $productVo= null) {
		try {
			$query = "select count(*) from product";
			$queryBuilder = new QueryBuilder( $productVo, $query );
			$queryBuilder
			->appendCondition ( "`id`", "id")
			->appendCondition ( "`item_code`", "itemCode")
			->appendCondition ( "`code`", "code")
			->appendCondition ( "`name`", "name", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "`featured`", "featured")
			->appendCondition ( "`status`", "status");
			return new SqlStatementInfo( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}