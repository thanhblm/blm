<?php

namespace common\services\bulk_discount;

use common\persistence\extend\dao\BulkDiscountProductExtendDao;
use common\services\base\BaseService;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\base\vo\BulkDiscountProductVo;

class BulkDiscountProductService extends BaseService {
	private $bulkDiscountProductDao;
	public function __construct() {
		$this->bulkDiscountProductDao = new BulkDiscountProductExtendDao();
	}
	public function selectByKey(BulkDiscountProductVo $vo) {
		return $this->bulkDiscountProductDao->selectByKey ( $vo );
	}
	public function selectByFilter(BulkDiscountProductVo $vo){
		return $this->bulkDiscountProductDao->selectByFilter( $vo );
	}
	public function countByFilter(BulkDiscountProductVo $vo){
		return $this->bulkDiscountProductDao->countByFilter( $vo );
	}
	public function getAll() {
		return $this->bulkDiscountProductDao->selectAll ();
	}
	public function getBulkDiscountByProduct(BulkDiscountExtendVo $vo){
		return $this->bulkDiscountProductDao->getBulkDiscountByProduct($vo);
	}
}