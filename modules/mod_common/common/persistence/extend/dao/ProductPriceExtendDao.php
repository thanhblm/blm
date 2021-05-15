<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\ProductPriceBaseDao;
use core\database\SqlMapClient;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\mapping\ProductPriceExtendMapping;

class ProductPriceExtendDao extends ProductPriceBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectByProductId(ProductVo $productVo){
		return $this->executeSelectList(ProductPriceExtendMapping::class, 'selectByProductId',$productVo);
	}
	public function deleteProductPriceByProduct(ProductVo $product){
		$result = $this->executeDelete ( ProductPriceExtendMapping::class, 'deleteProductPriceByProduct', $product );
		return $result;
	}
}