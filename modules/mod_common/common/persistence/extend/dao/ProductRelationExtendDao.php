<?php
namespace common\persistence\extend\dao;

use core\database\SqlMapClient;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\mapping\ProductRelationExtendMapping;
use common\persistence\base\dao\ProductRelationBaseDao;


class ProductRelationExtendDao extends ProductRelationBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectProductRelationByProductId(ProductVo $product){
		return $this->executeSelectList(ProductRelationExtendMapping::class, 'selectProductRelationByProductId',$product);
	}
	
	public function deleteProductRelationByProduct(ProductVo $product){
		$result = $this->executeDelete ( ProductRelationExtendMapping::class, 'deleteProductRelationByProduct', $product );
		return $result;
	}
}