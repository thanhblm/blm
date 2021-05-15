<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductAttributeVo;
use core\database\SqlStatementInfo;

class ProductAttributeExtendMapping {
	public function deleteProductAttributeByAttributeId($arrayParams) {
		try {
			$query = "delete from `product_attribute` where product_id=$arrayParams[0] and attribute_id LIKE '%[".$arrayParams[1].",%' or attribute_id LIKE '%,".$arrayParams[1].",%' or attribute_id LIKE '%,".$arrayParams[1]."]%' or attribute_id LIKE '%[".$arrayParams[1]."]%' ";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductAttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}