<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductVo;
use core\database\SqlStatementInfo;

class ProductPriceExtendMapping {
	public function selectByProductId(ProductVo $product) {
		try {
			$query = "select pp.product_id, c.code as currency_code, pp.price from currency as c 
				left join
					(select * from product_price where product_id = #{id}
					) as pp on c.code = pp.currency_code order by c.code";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductPriceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteProductPriceByProduct(ProductVo $product) {
		try {
			$query = "delete from `product_price`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_price`", $query, ProductPriceVo::class, "where (`product_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}