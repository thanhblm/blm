<?php
namespace common\persistence\extend\dao;

use core\database\SqlMapClient;
use common\persistence\base\vo\ProductVo;
use common\persistence\base\dao\ProductLangBaseDao;
use common\persistence\extend\mapping\ProductLangExtendMapping;

class ProductLangExtendDao extends ProductLangBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function selectByProductId(ProductVo $productVo){
		return $this->executeSelectList(ProductLangExtendMapping::class, 'selectByProductId',$productVo);
	}
	
	public function deleteProductLangByProduct(ProductVo $product){
		$result = $this->executeDelete ( ProductLangExtendMapping::class, 'deleteProductLangByProduct', $product );
		return $result;
	}
}