<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\BulkDiscountProductBaseDao;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\extend\mapping\BulkDiscountProductExtendMapping;
use core\database\SqlMapClient;
use common\persistence\extend\vo\BulkDiscountExtendVo;

class BulkDiscountProductExtendDao extends BulkDiscountProductBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectByBulkDiscount(BulkDiscountVo $bulkDiscount) {
		return $this->executeSelectList(BulkDiscountProductExtendMapping::class, 'selectByBulkDiscount',$bulkDiscount);
	}
	
	public function deleteByBulkDiscount(BulkDiscountVo $bulkDiscount){
		$result = $this->executeDelete ( BulkDiscountProductExtendMapping::class, 'deleteByBulkDiscount', $bulkDiscount );
		return $result;
	}
	
	public function getBulkDiscountByProduct(BulkDiscountExtendVo $vo){
		$result = $this->executeSelectOne( BulkDiscountProductExtendMapping::class, 'getBulkDiscountByProduct', $vo);
		return $result;
	}
}