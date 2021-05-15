<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductRelateVo extends BaseVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'product_id' => 'productId',
			'relate_product_id' => 'relateProductId'
		);
	}
	public $productId;
	public $relateProductId;
}