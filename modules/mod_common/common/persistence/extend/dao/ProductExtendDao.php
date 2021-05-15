<?php
namespace common\persistence\extend\dao;

use common\persistence\base\dao\ProductBaseDao;
use common\persistence\base\vo\ProductVo;
use core\database\SqlMapClient;
use common\persistence\extend\mapping\ProductExtendMapping;

class ProductExtendDao extends ProductBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function getProductByFilter(ProductVo $productVo) {
		$result = $this->executeSelectList ( ProductExtendMapping::class, 'getProductByFilter', $productVo );
		return $result;
	}
	public function countProductByFilter(ProductVo $productVo= null) {
		$result = $this->executeCount ( ProductExtendMapping::class, 'countProductByFilter', $productVo );
		return $result;
	}
}