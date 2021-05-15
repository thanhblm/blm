<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\OrderProductVo;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\base\mapping\OrderProductMapping;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class OrderProductExtendMapping extends OrderProductMapping {
	
	public function selectOrderProductByKey(OrderProductVo $orderProductVo) {
		try {
			$query = "select op.*, p.description as description,p.item_code as product_code 
				from order_product op
				left join product p on p.id =op.product_id ";
			$queryBuilder = new QueryBuilder ( $orderProductVo, $query );
			$queryBuilder->appendCondition ( "op.order_id", "orderId" );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderProductExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function selectOrderProductCustomerByKey(OrderProductExtendVo $orderProductVo) {
		try {
			$query = "select op.*, p.description as description,p.code as product_code,
					si.url as seo_url,
				    si.title as seo_title,
				    si.keywords as seo_keywords,
				    si.description as seo_description
				from order_product as op
				left join product as p on p.id =op.product_id
				left join seo_info_lang as si on si.type = 'product' and si.item_id = p.id and si.language_code = #{languageCode}";
			$queryBuilder = new QueryBuilder( $orderProductVo, $query );
			$queryBuilder->appendCondition ( "op.order_id", "orderId" );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderProductExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}