<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\AreaExtendVo;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;

class AreaExtendMapping{
	public function getAreaFull(AreaExtendVo $filter){
		try {
			$query = "
				select 
					ac.*, 
				    a.`name`,
				     a.`description` as area_description
				from `area` a
				left join `area_category` ac on a.id = ac.area_id and ac.category_id = #{categoryId}";
			$queryBuilder = new QueryBuilder($filter, $query);
			$queryBuilder
				->appendCondition("a.status", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), AreaExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}