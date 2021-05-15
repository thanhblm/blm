<?php

namespace common\model;

use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use core\BaseArray;

class BlogCategoryHomeMo{
	public $categoryHomeExtendVo;
	public $productHomeExtendArray;

	public function __construct(){
		$this->categoryHomeExtendVo = new CategoryHomeExtendVo();
		$this->productHomeExtendArray = new BaseArray(ProductHomeExtendVo::class);
	}
}