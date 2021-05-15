<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\BulkDiscountProductMapping;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\BulkDiscountProductExtendVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class BulkDiscountProductExtendMapping extends BulkDiscountProductMapping{
	public function selectByBulkDiscount(BulkDiscountVo $bulkDiscount) {
		try {
			$query = "select bdp.*, p.name as product_name from bulk_discount_product as bdp 
				inner join product as p on bdp.product_id = p.id 
				where bdp.bulk_discount_id = #{id}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BulkDiscountProductExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteByBulkDiscount(BulkDiscountVo $bulkDiscount) {
		try {
			$query = "delete from `bulk_discount_product`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`bulk_discount_product`", $query, BulkDiscountProductExtendVo::class, "where (`bulk_discount_id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function getBulkDiscountByProduct(BulkDiscountExtendVo $vo){
		try {
			$query = "SELECT bd.`name`, bd.discount, bd.id from bulk_discount_product bdp
						INNER JOIN bulk_discount bd on bd.id = bdp.bulk_discount_id ";
			$query = $query.$this->buildCondition($vo);
			$query = $query.$this->buildPaging($vo);
			return new SqlStatementInfo( SqlStatementInfo::SELECT, null, $query, BulkDiscountVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	private function buildPaging($filter) {
		$endQuery = "";
		$objInfo = get_object_vars ( $filter );
		
		if (! AppUtil::isEmptyString ( $objInfo ['order_by'] )) {
			$endQuery = $endQuery . " order by " . $objInfo ['order_by'];
		}
		if (! AppUtil::isEmptyString ( $objInfo ['start_record'] )) {
			if (! AppUtil::isEmptyString ( $objInfo ['end_record'] )) {
				$endQuery = $endQuery . " LIMIT  #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			} else {
				$endQuery = $endQuery . " LIMIT #{start_record:PARAM_INT}";
			}
		}
		return $endQuery;
	}
	private function buildCondition($filter) {
		$condition = " where 1=1 ";
		$objInfo = get_object_vars ( $filter );
		if (! AppUtil::isEmptyString ( $objInfo ['status'] )) {
			$condition .= " AND bd.`status` = '".$filter->status."'";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['productId'] )) {
			$condition .= " AND bdp.product_id = ". $filter->productId;
		}
		if (! AppUtil::isEmptyString ( $objInfo ['productQuantity'] )) {
			$condition .= " AND bdp.quantity <= " . $filter->productQuantity;
		}
		if (! AppUtil::isEmptyString ( $objInfo ['dateNow'] )) {
			$condition .= " AND  
				CASE  
					WHEN bd.valid_from > 0 THEN bd.valid_from <= '".$filter->dateNow."' 
				  ELSE 1 = 1 
				END ";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['dateNow'] )) {
			$condition .= " AND 
				CASE 
					WHEN bd.valid_to > 0 THEN bd.valid_to >= '".$filter->dateNow."' 
				  ELSE 1 = 1 
				END ";
		}
		return $condition;
	}
}