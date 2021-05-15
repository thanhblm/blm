<?php
namespace common\persistence\extend\vo;

use common\persistence\base\vo\ProductVo;

class ProductHomeExtendVo extends ProductVo{
	public $categoryName;
	public $categorySeoUrl;
	public $categorySeoTitle;
	public $categorySeoKeywords;
	public $categorySeoDescription;
	public $languageCode;
	public $currencyCode;
	public $seoUrl;
	public $seoTitle;
	public $seoKeywords;
	public $seoDescription;
	public $price;
	public $symbol;
	public $regionId;
	public $basePrice;
	
	public function __construct(){
		parent::__construct();
		$this->resultMap["category_name"] = "categoryName";
		$this->resultMap["category_seo_url"] = "categorySeoUrl";
		$this->resultMap["category_seo_title"] = "categorySeoTitle";
		$this->resultMap["category_seo_keywords"] = "categorySeoKeywords";
		$this->resultMap["category_seo_description"] = "categorySeoDescription";
		$this->resultMap["language_code"] = "languageCode";
		$this->resultMap["seo_url"] = "seoUrl";
		$this->resultMap["seo_title"] = "seoTitle";
		$this->resultMap["seo_keywords"] = "seoKeywords";
		$this->resultMap["seo_description"] = "seoDescription";
		$this->resultMap["price"] = "price";
		$this->resultMap["basePrice"] = "base_price";
		$this->resultMap["symbol"] = "symbol";
		$this->resultMap["region_id"] = "regionId";
	}
}