<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ProductVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\ProductSeoExtendVo;
use core\database\SqlStatementInfo;

class ProductSeoExtendMapping {
	public function selectByProductId(ProductVo $product) {
		try {
			$query = "select sl.item_id, l.code as language_code, l.name as language_name, l.flag, sl.url, sl.title, sl.keywords, sl.description from `language` as l 
			left join
				(select * from seo_info_lang where type = 'product' and item_id = #{id}
				) as sl on l.code = sl.language_code 
			order by l.name";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ProductSeoExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteProductSeoByProduct(ProductVo $product) {
		try {
			$query = "delete from `seo_info_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`product_lang`", $query, SeoInfoLangVo::class, "where type='product' and (`item_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}