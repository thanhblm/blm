<?php
namespace common\persistence\extend\mapping;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;
use common\persistence\extend\vo\OrderHistoryExtendVo;

class OrderHistoryExtendMapping  {
	public function getByFilter(OrderHistoryExtendVo $orderHistoryExtendVo) {
		try {
			$query = "select oh.*,os.name as order_status_name
				from order_history as oh
				left join order_status as os on os.id =oh.status";
			$queryBuilder = new QueryBuilder( $orderHistoryExtendVo, $query );
			$queryBuilder->appendCondition ( "oh.order_id", "orderId" );
			$queryBuilder->appendOrder();
			$queryBuilder->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderHistoryExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}