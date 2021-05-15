<?php

namespace frontend\controllers\category;

use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\product\ProductHomeService;
use core\common\Paging;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class CategoryController extends FrontendController{
	public $o;
	public $categoryId;
	public $categories;
	public $productCategories;
	public $category;

	private $productService;

	public function __construct(){
		parent::__construct();
		$this->productService = new ProductHomeService ();
		$this->filter = new ProductHomeExtendVo();
		$this->category = new CategoryHomeExtendVo();
	}

	public function categoryList(){
		if(!AppUtil::isEmptyString($this->categoryId)){
			$this->loadCategoryDetail();
		}
		$this->loadProductCategories();
		$this->getSeoInfo();
		return "success";
	}

	public function searchProduct(){
		$this->loadProductCategories();
		return "success";
	}

	protected function loadCategoryDetail(){
		$productService = new ProductHomeService();
		$categoryVo = new CategoryHomeExtendVo();
		$categoryVo->id = $this->categoryId;
		$this->category = $productService->getCategoryHomeById($categoryVo);
	}

	private function loadProductCategories(){
		$this->buildProductHomeFilter();
		$count = $this->productService->getCountProductHomeByFilter($this->filter);
		$paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
		$this->filter->start_record = $paging->startRecord - 1;
		$this->filter->end_record = $paging->pageSize;
		$paging->records = $this->productService->getProductHomeByFilter($this->filter);
		$this->productCategories = $paging;
	}

	private function buildProductHomeFilter(){
		$filter = new ProductHomeExtendVo ();
		if (!AppUtil::isEmptyString($this->categoryId)) {
			$filter->categoryId = $this->categoryId;
		}
		$filter->languageCode = $this->languageCode;
		$filter->currencyCode = $this->currencyCode;
		$filter->regionId = $this->regionId;
		$filter->status = "active";
		switch ($this->o) {
			case "ca" :
				$filter->order_by = "orderNo asc";
				break;
			case "pa" :
				$filter->order_by = "price asc";
				break;
			case "pd" :
				$filter->order_by = "price desc";
				break;
			default :
				$filter->order_by = "cr_date desc";
				break;
		}
		$this->filter = $filter;
	}

	private function getSeoInfo(){
		$this->seoInfoVo = new SeoInfoLangVo();
		$this->seoInfoVo->title = $this->category->seoTitle;
		if (AppUtil::isEmptyString($this->category->seoTitle)) {
			$this->seoInfoVo->title = $this->category->name;
		}
		$this->seoInfoVo->keywords = $this->category->seoKeywords;
		$this->seoInfoVo->description = $this->category->seoDescription;
	}
}