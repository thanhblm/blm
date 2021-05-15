<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\extend\vo\ProductBulkDiscountVo;
use core\database\SqlStatementInfo;

class BulkDiscountExtendMapping {
	public function getApplyBulkDiscountForProduct(ProductBulkDiscountVo $productBulkDiscountVo) {
		try {
			$query = "
				select bd.* from `bulk_discount` bd
				inner join `bulk_discount_product` bdp on bdp.bulk_discount_id = bd.id
				where bdp.product_id = #{productId} and bdp.quantity <= #{quantity} and bd.status = 'active' and (bd.valid_from is null or #{date} >= bd.valid_from) and (bd.valid_to is null or #{date} <= bd.valid_to)
				order by bdp.quantity desc
				limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}