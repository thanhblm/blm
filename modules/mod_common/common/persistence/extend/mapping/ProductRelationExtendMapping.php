<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductRelateVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\vo\ProductRelationExtendVo;
use core\database\SqlStatementInfo;

class ProductRelationExtendMapping {
	public function selectProductRelationByProductId(ProductVo $product) {
		try {
			$query = "select pr.*, p.name from product_relation as pr 
				inner join product as p on pr.relate_product_id = p.id 
				where product_id = #{id}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductRelationExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteProductRelationByProduct(ProductVo $product) {
		try {
			$query = "delete from `product_relation`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_relate`", $query, ProductRelateVo::class, "where (`product_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}