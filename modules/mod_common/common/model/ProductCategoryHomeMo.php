<?php
namespace common\model;

use common\persistence\extend\vo\CategoryHomeExtendVo;
use core\BaseArray;
use common\persistence\extend\vo\ProductHomeExtendVo;

class ProductCategoryHomeMo{
	public $categoryHomeExtendVo;
	public $productHomeExtendArray;
	
	public function __construct(){
		$this->categoryHomeExtendVo = new CategoryHomeExtendVo();
		$this->productHomeExtendArray = new BaseArray(ProductHomeExtendVo::class);
	}
}