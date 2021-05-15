<?php

namespace common\persistence\base\vo;

use core\database\BaseVo;

class ProductPhotoVo extends BaseVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			'product_id' => 'productId',
			'image' => 'image'
		);
	}
	public $productId;
	public $image;
}