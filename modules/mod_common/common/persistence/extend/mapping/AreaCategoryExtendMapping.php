<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\AreaCategoryMapping;
use common\persistence\base\vo\AreaCategoryVo;
use core\database\SqlStatementInfo;

class AreaCategoryExtendMapping extends AreaCategoryMapping{

	public function deleteAreaCategoryByCatId(AreaCategoryVo $filter){
		try {
			$query = "
				delete from area_category";
			return new SqlStatementInfo (SqlStatementInfo::DELETE, null, $query, AreaCategoryVo::class, "where (`category_id` = #{categoryId})");
		} catch (\Exception $e) {
			throw $e;
		}
	}
}