<?php

namespace common\services\bulk_discount;

use common\persistence\base\dao\BulkDiscountBaseDao;
use common\persistence\base\dao\BulkDiscountProductBaseDao;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\extend\dao\BulkDiscountExtendDao;
use common\persistence\extend\dao\BulkDiscountProductExtendDao;
use common\persistence\extend\vo\BulkDiscountProductExtendVo;
use common\persistence\extend\vo\ProductBulkDiscountVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;

class BulkDiscountService extends BaseService {
	private $bulkDiscountDao;
	private $bulkDiscountProductDao;
	private $bulkDiscountProductExtendDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->bulkDiscountDao = new BulkDiscountExtendDao ();
		$this->bulkDiscountProductDao = new BulkDiscountProductBaseDao ();
		$this->bulkDiscountProductExtendDao = new BulkDiscountProductExtendDao ();
	}
	public function getBulkDiscountByKey(BulkDiscountVo $bulkDiscountVo) {
		return $this->bulkDiscountDao->selectByKey ( $bulkDiscountVo );
	}
	public function getBulkDiscountByFilter(BulkDiscountVo $bulkDiscountVo) {
		return $this->bulkDiscountDao->selectByFilter ( $bulkDiscountVo );
	}
	public function countBulkDiscountByFilter(BulkDiscountVo $bulkDiscountVo) {
		return $this->bulkDiscountDao->countByFilter ( $bulkDiscountVo );
	}
	public function addBulkDiscount(BulkDiscountVo $bulkDiscountVo, BaseArray $discountProducts) {
		$sqlClient = new SqlMapClient ( $this->context );
		$bulkDiscountDao = new BulkDiscountBaseDao ( $this->context, $sqlClient );
		$bulkDiscountProductDao = new BulkDiscountProductBaseDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			$bulkDiscountId = $bulkDiscountDao->insertDynamic ( $bulkDiscountVo );
			foreach ( $discountProducts->getArray () as $discountProductVo ) {
				$discountProductVo->bulkDiscountId = $bulkDiscountId;
				$bulkDiscountProductDao->insertDynamic ( $discountProductVo );
			}
			$sqlClient->endTransaction ();
			return $bulkDiscountId;
		} catch ( \Exception $ex ) {
			$sqlClient->rollback ();
			throw $ex;
		}
	}
	public function updateBulkDiscount(BulkDiscountVo $bulkDiscountVo, BaseArray $discountProducts) {
		$sqlClient = new SqlMapClient ( $this->context );
		$bulkDiscountDao = new BulkDiscountBaseDao ( $this->context, $sqlClient );
		$bulkDiscountProductDao = new BulkDiscountProductBaseDao ( $this->context, $sqlClient );
		$bulkDiscountProductExtendDao = new BulkDiscountProductExtendDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			$bulkDiscountDao->updateDynamicByKey ( $bulkDiscountVo );
			$bulkDiscountProductExtendDao->deleteByBulkDiscount ( $bulkDiscountVo );
			foreach ( $discountProducts->getArray () as $discountProductVo ) {
				$discountProductVo->bulkDiscountId = $bulkDiscountVo->id;
				$bulkDiscountProductDao->insertDynamic ( $discountProductVo );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $ex ) {
			$sqlClient->rollback ();
			throw $ex;
		}
	}
	public function deleteBulkDiscount(BulkDiscountVo $bulkDiscountVo) {
		$sqlClient = new SqlMapClient ( $this->context );
		$bulkDiscountDao = new BulkDiscountBaseDao ( $this->context, $sqlClient );
		$bulkDiscountProductExtentDao = new BulkDiscountProductExtendDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			$bulkDiscountProductExtentDao->deleteByBulkDiscount ( $bulkDiscountVo );
			$bulkDiscountDao->deleteByKey ( $bulkDiscountVo );
			$sqlClient->endTransaction ();
		} catch ( \Exception $ex ) {
			$sqlClient->rollback ();
			throw $ex;
		}
	}
	// return BaseArray
	public function getBulkDiscountProductByBulkDiscount(BulkDiscountVo $bulkDiscount) {
		$list = $this->bulkDiscountProductExtendDao->selectByBulkDiscount ( $bulkDiscount );
		$bulkDiscountProducts = new BaseArray ( BulkDiscountProductExtendVo::class );
		foreach ( $list as $product ) {
			$bulkDiscountProducts->add ( $product );
		}
		return $bulkDiscountProducts;
	}
	public function getApplyBulkDiscountForProduct(ProductBulkDiscountVo $productBulkDiscountVo) {
		return $this->bulkDiscountDao->getApplyBulkDiscountForProduct ( $productBulkDiscountVo );
	}
}