<?php

namespace frontend\controllers\product;

use common\helper\ProductHelper;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\attribute\ProductAttributeService;
use common\services\product\ProductHomeService;
use core\Lang;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class ProductController extends FrontendController{
	public $id;
	public $product;
	public $relatedProducts;
	public $bulkDiscounts;
	public $categories;
	public $attrExtGroupVos;
	private $productService;
	public $isEnableEditPrice;
	public $productAttribute;
	public $attrGroupListId;
	public $attributeSelect;
	public $category;

	public function __construct(){
		parent::__construct();
		$this->productService = new ProductHomeService ();
		$this->productAttribute = new ProductAttributeVo();
		$this->category = new CategoryHomeExtendVo();
	}

	public function index(){
		return "success";
	}

	public function search(){
		return "success";
	}

	public function selectAttribute(){
		$this->id = $this->productAttribute->productId;
		$this->getBulkDiscountProduct();
		$this->getProductDetail();
		$this->isEnableEditPrice = " disabled ";

		if (isset($this->attrGroupListId) && isset($this->attributeSelect) && count($this->attrGroupListId) === count($this->attributeSelect)) {
			$this->isEnableEditPrice = "";

			$this->productAttribute->attributeId = str_replace("\"", "", json_encode($this->attributeSelect));
			$productAttributeSv = new ProductAttributeService();
			$productAttributeVo = new ProductAttributeVo();
			$productAttributeVo->productId = $this->productAttribute->productId;
			$productAttributeVo->attributeId = $this->productAttribute->attributeId;
			if (count($productAttributeSv->countByFilter($productAttributeVo)) >= 0) {
				$productAttributeVo = $productAttributeSv->getByFilter($productAttributeVo)[0];
				$this->productAttribute->price = $productAttributeVo->price;
				$this->productAttribute->quantity = $productAttributeVo->quantity;
				$this->productAttribute->id = $productAttributeVo->id;
			}
			//$this->addActionMessage(Lang::get("Wow, you can set price and quantity for this case."));
		} else {
			$this->addActionError(Lang::get("Please select attribute product to buy."));
		}

		return "success";
	}

	public function detail(){
		$productService = new ProductHomeService();
		$categoryVo = new CategoryHomeExtendVo();
		$categoryVo->id = $this->product->categoryId;
		$this->category = $productService->getCategoryHomeById($categoryVo);
		$productVo = $this->buildProductFilter();
		$this->product = $this->productService->getProductHomeById($productVo);
		$this->attrExtGroupVos = ProductHelper::getAttributeProduct($this->product->id);
		$this->getSeoInfo();
		if ($this->product != null) {
			$productFilter = new ProductHomeExtendVo();
			$productFilter->id = $this->product->id;
			$productFilter->languageCode = $this->languageCode;
			$productFilter->currencyCode = $this->currencyCode;
			$productFilter->regionId = $this->regionId;
			$productFilter->status = 'active';
			$productFilter->categoryId = $this->product->categoryId;
			$productRelates = $this->productService->getRelatedProducts($productFilter);
			if (count($productRelates) < 3) {
				$productRelates = $this->productService->getProductHomeByRandom($productFilter);
			}
			$this->relatedProducts = $productRelates;
			$bulkDiscountVo = $this->builBulDiscountFilter();
			$this->bulkDiscounts = $this->productService->getBulDiscountByProduct($bulkDiscountVo);
			return "success";
		} else {
			return "categorylist";
		}
	}

	private function buildProductFilter(){
		$productHomeVo = new ProductHomeExtendVo ();
		$productHomeVo->id = $this->id;
		$productHomeVo->regionId = $this->regionId;
		$productHomeVo->languageCode = $this->languageCode;
		$productHomeVo->currencyCode = $this->currencyCode;
		$productHomeVo->featured = "yes";
		$productHomeVo->status = "active";
		return $productHomeVo;
	}

	private function builBulDiscountFilter(){
		$bulkDiscountVo = new BulkDiscountExtendVo ();
		$bulkDiscountVo->productId = $this->id;
		$bulkDiscountVo->status = "active";
		//$bulkDiscountVo->dateNow = date ( "Y-m-d" );
		return $bulkDiscountVo;
	}

	private function getSeoInfo(){
		$this->seoInfoVo = new SeoInfoLangVo();
		$this->seoInfoVo->title = $this->product->seoTitle;
		if (AppUtil::isEmptyString($this->product->seoTitle)) {
			$this->seoInfoVo->title = $this->product->name;
		}
		$this->seoInfoVo->keywords = $this->product->seoKeywords;
		$this->seoInfoVo->description = $this->product->seoDescription;
	}

	private function getProductDetail(){
		$productVo = $this->buildProductFilter();
		$this->product = $this->productService->getProductHomeById($productVo);
	}

	private function getBulkDiscountProduct(){
		$bulkDiscountVo = $this->builBulDiscountFilter();
		$this->bulkDiscounts = $this->productService->getBulDiscountByProduct($bulkDiscountVo);

	}
}