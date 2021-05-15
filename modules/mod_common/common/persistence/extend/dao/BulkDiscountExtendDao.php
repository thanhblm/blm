<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\BulkDiscountBaseDao;
use common\persistence\extend\mapping\BulkDiscountExtendMapping;
use common\persistence\extend\vo\ProductBulkDiscountVo;
use core\database\SqlMapClient;

class BulkDiscountExtendDao extends BulkDiscountBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getApplyBulkDiscountForProduct(ProductBulkDiscountVo $productBulkDiscountVo) {
		$result = $this->executeSelectOne ( BulkDiscountExtendMapping::class, 'getApplyBulkDiscountForProduct', $productBulkDiscountVo );
		return $result;
	}
}