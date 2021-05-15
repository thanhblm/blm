<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\ProductRegionBaseDao;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\mapping\ProductRegionExtendMapping;
use core\database\SqlMapClient;


class ProductRegionExtendDao extends ProductRegionBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectProductRegionByProductId(ProductVo $product){
		return $this->executeSelectList(ProductRegionExtendMapping::class, 'selectProductRegionByProductId',$product);
	}
	
	public function deleteProductRegionByProduct(ProductVo $product){
		$result = $this->executeDelete ( ProductRegionExtendMapping::class, 'deleteProductRegionByProduct', $product );
		return $result;
	}
}