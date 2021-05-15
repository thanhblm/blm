<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductLangVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\vo\ProductLangExtendVo;
use core\database\SqlStatementInfo;

class ProductLangExtendMapping {
	public function selectByProductId(ProductVo $product) {
		try {
			$query = "select pl.product_id, l.code as language_code, l.name as language_name, l.flag, pl.name, pl.description, pl.composition from `language` as l 
				left join
					(select * from product_lang 
					where product_id = #{id}
					) as pl on l.code = pl.language_code 
				order by l.name";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductLangExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteProductLangByProduct(ProductVo $product) {
		try {
			$query = "delete from `product_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_lang`", $query, ProductLangVo::class, "where (`product_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}