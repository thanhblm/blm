<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\OrderStatusVo;
use core\database\SqlStatementInfo;

class OrderStatusExtendMapping {
	final public function getSortedOrderStatuses() {
		try {
			$query = "
				select 
					os.*, 
				    case os.id 
						when 1 then 2
				        when 2 then 1
				        else os.id 
				    end as sorted_col
				from order_status os
				where os.status = 'active'
				order by sorted_col asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderStatusVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}