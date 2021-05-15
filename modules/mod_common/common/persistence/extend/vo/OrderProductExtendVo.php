<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\OrderProductVo;

class OrderProductExtendVo extends OrderProductVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["product_code"] = "productCode";
		$this->resultMap["language_code"] = "languageCode";
		$this->resultMap["seo_url"] = "seoUrl";
		$this->resultMap["seo_title"] = "seoTitle";
		$this->resultMap["seo_keywords"] = "seoKeywords";
		$this->resultMap["seo_description"] = "seoDescription";
	}
	public $productCode;
	public $languageCode;
	public $seoUrl;
	public $seoTitle;
	public $seoKeywords;
	public $seoDescription;
	public $symbol;
	public $productImage;
}