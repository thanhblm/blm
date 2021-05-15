<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\ProductBaseDao;
use common\persistence\extend\mapping\ProductHomeExtendMapping;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use core\database\SqlMapClient;

class ProductHomeExtendDao extends ProductBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getProductHomeById(ProductHomeExtendVo $productExtendVo){
		$result = $this->executeSelectOne(ProductHomeExtendMapping::class, 'getProductHomeById', $productExtendVo);
		return $result;
	}

	public function getProductHomeByFilter(ProductHomeExtendVo $productExtendVo = null){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getProductHomeByFilter', $productExtendVo);
		return $result;
	}

	public function getCountProductHomeByFilter(ProductHomeExtendVo $productExtendVo = null){
		$result = $this->executeCount(ProductHomeExtendMapping::class, 'getCountProductHomeByFilter', $productExtendVo);
		return $result;
	}

	public function getProductHomeRelateCategories(ProductHomeExtendVo $productExtendVo = null){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getProductHomeRelateCategories', $productExtendVo);
		return $result;
	}

	public function getProductHomeByRandom(ProductHomeExtendVo $productExtendVo = null){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getProductHomeByRandom', $productExtendVo);
		return $result;
	}

	public function getCategoryHomeById(CategoryHomeExtendVo $categoryExtendVo){
		$result = $this->executeSelectOne(ProductHomeExtendMapping::class, 'getCategoryHomeById', $categoryExtendVo);
		return $result;
	}

	public function getCategoryHomeByFilter(CategoryHomeExtendVo $categoryExtendVo){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getCategoryHomeByFilter', $categoryExtendVo);
		return $result;
	}

	public function getRelationProducts(ProductHomeExtendVo $productHomeVo){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getRelationProducts', $productHomeVo);
		return $result;
	}

	public function getBulDiscountByProduct(BulkDiscountExtendVo $bulkDiscountVo){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getBulDiscountByProduct', $bulkDiscountVo);
		return $result;
	}

	public function getBestSellers(ProductHomeExtendVo $productExtendVo = null){
		$result = $this->executeSelectList(ProductHomeExtendMapping::class, 'getBestSellers', $productExtendVo);
		return $result;
	}
}