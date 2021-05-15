<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\mapping\ProductSeoExtendMapping;
use core\database\SqlMapClient;

class ProductSeoExtendDao extends SeoInfoLangBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectByProductId(ProductVo $productVo){
		return $this->executeSelectList(ProductSeoExtendMapping::class, 'selectByProductId',$productVo);
	}
	
	public function deleteProductSeoByProduct(ProductVo $product){
		$result = $this->executeDelete ( ProductSeoExtendMapping::class, 'deleteProductSeoByProduct', $product );
		return $result;
	}
}