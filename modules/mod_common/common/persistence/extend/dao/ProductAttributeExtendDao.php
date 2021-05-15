<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\ProductAttributeBaseDao;
use common\persistence\extend\mapping\ProductAttributeExtendMapping;
use core\database\SqlMapClient;

class ProductAttributeExtendDao extends ProductAttributeBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function deleteProductAttributeByAttributeId($productId,$attributeId) {
		$arrayParams = array();
		array_push($arrayParams, $productId);
		array_push($arrayParams, $attributeId);
		$result = $this->executeDelete( ProductAttributeExtendMapping::class, 'deleteProductAttributeByAttributeId', $arrayParams);
		return $result;
	}
	
}