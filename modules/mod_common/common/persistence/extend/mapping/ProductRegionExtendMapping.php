<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductRegionVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\vo\ProductRegionExtendVo;
use core\database\SqlStatementInfo;

class ProductRegionExtendMapping {
	public function selectProductRegionByProductId(ProductVo $product) {
		try {
			$query = "select r.id as region_id, r.name, pr.product_id from region as r 
				left join
					(select * from product_region 
					where product_id = #{id}) as pr on r.id = pr.region_id";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductRegionExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteProductRegionByProduct(ProductVo $product) {
		try {
			$query = "delete from `product_region`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_region`", $query, ProductRegionVo::class, "where (`product_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}