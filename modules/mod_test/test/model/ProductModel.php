<?php

namespace test\model;

use common\persistence\base\vo\ProductVo;
use core\BaseArray;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductLangVo;

class ProductModel extends ProductVo {
	public $prices;
	public $descriptions;
	public function __construct() {
		parent::__construct ();
		$this->prices = new BaseArray ( ProductPriceVo::class );
		$this->descriptions = new BaseArray ( ProductLangVo::class );
	}
}