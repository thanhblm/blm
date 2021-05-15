<?php

namespace common\services\product;

use common\helper\SettingHelper;
use common\model\ProductCategoryHomeMo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\extend\dao\PriceLevelExtendDao;
use common\persistence\extend\dao\ProductHomeExtendDao;
use common\persistence\extend\vo\BulkDiscountExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;

class ProductHomeService extends BaseService{
	private $productExtendDao;
	public function __construct(){
		$this->productExtendDao = new ProductHomeExtendDao ();
	}

	public function getProductHomeById(ProductHomeExtendVo $productExtendVo){
		$product = $this->productExtendDao->getProductHomeById($productExtendVo);
		$priceLevel = $this->priceLevelCustomer();
		$product->basePrice = $product->price;
		if (!is_null($priceLevel)) {
			$product->price = $product->basePrice - $product->basePrice * $priceLevel->value / 100;
		}
		return $product;
	}

	public function getProductHomeByFilter(ProductHomeExtendVo $productExtendVo){
		$products = $this->productExtendDao->getProductHomeByFilter($productExtendVo);
		return $products;
	}
	public function getCountProductHomeByFilter(ProductHomeExtendVo $productExtendVo){
		return $this->productExtendDao->getCountProductHomeByFilter($productExtendVo);
	}

	public function getProductHomeByRandom(ProductHomeExtendVo $productExtendVo){
		$products = $this->productExtendDao->getProductHomeByRandom($productExtendVo);
		return $products;
	}

	public function getCategoryHomeByFilter(CategoryHomeExtendVo $categoryExtendVo){
		$categories = $this->productExtendDao->getCategoryHomeByFilter($categoryExtendVo);
		return $categories;
	}

	public function getCategoryHomeById(CategoryHomeExtendVo $categoryExtendVo){
		return $this->productExtendDao->getCategoryHomeById($categoryExtendVo);
	}

	public function getProductCategoryByCategory(CategoryHomeExtendVo $categoryExtendVo, ProductHomeExtendVo $productExtendVo){
		$productCategoryHomeMo = new ProductCategoryHomeMo ();
		$category = $this->productExtendDao->getCategoryHomeById($categoryExtendVo);
		$products = $this->productExtendDao->getProductHomeByFilter($productExtendVo);
		$productCategoryHomeMo->categoryHomeExtendVo = $category;
		$priceLevel = $this->priceLevelCustomer();
		foreach ($products as $product) {
			$product->basePrice = $product->price;
			if (!is_null($priceLevel)) {
				$product->price = $product->basePrice - $product->basePrice * $priceLevel->value / 100;
			}
			$productCategoryHomeMo->productHomeExtendArray->add($product);
		}
		return $productCategoryHomeMo;
	}

	public function getProductCategoryHomeByFilter(CategoryHomeExtendVo $categoryExtendVo, ProductHomeExtendVo $productExtendVo){
		$productCategoryHomeArray = new BaseArray (ProductCategoryHomeMo::class);
		$categories = $this->getCategoryHomeByFilter($categoryExtendVo);

		foreach ($categories as $category){
			$productHomeMo = new ProductCategoryHomeMo();
			$productHomeMo->categoryHomeExtendVo = $category;

			if(!AppUtil::isEmptyString($category->id)){
				$productExtendVo->categoryId = $category->id;
			}
			$products = $this->getProductHomeByFilter($productExtendVo);
			foreach ($products as $product){
				$productHomeMo->productHomeExtendArray->add($product);
			}
		}

		$numberProduct = SettingHelper::getSettingValue("Max products per category");
		if (AppUtil::isEmptyString($numberProduct)) {
			$numberProduct = ApplicationConfig::get("category.max.product.list");
		}
		if (AppUtil::isEmptyString($numberProduct)) {
			$numberProduct = 4;
		}
		$priceLevel = $this->priceLevelCustomer();
		foreach ($categories as $category) {
			$productCategoryHomeMo = new ProductCategoryHomeMo ();
			$productCategoryHomeMo->categoryHomeExtendVo = $category;
			$productHomeArray = new BaseArray (ProductHomeExtendVo::class);
			$i = 0;
			foreach ($products as $product) {
				if ($i >= $numberProduct) {
					break;
				}
				if ($product->categoryId == $category->id) {
					$product->basePrice = $product->price;
					if (!is_null($priceLevel)) {
						$product->price = $product->basePrice - $product->basePrice * $priceLevel->value / 100;
					}
					$productHomeArray->add($product);
					$i++;
				}
			}
			$productCategoryHomeMo->productHomeExtendArray = $productHomeArray;
			$productCategoryHomeArray->add($productCategoryHomeMo);
		}
		return $productCategoryHomeArray;
	}

	private function countProductByCategory($products, $category){
		$count = 0;
		foreach ($products as $product) {
			if ($product->categoryId == $category->id) {
				$count++;
			}
		}
		return $count;
	}

	public function getRelatedProducts(ProductHomeExtendVo $productHomeVo){
		$productRelations = $this->productExtendDao->getRelationProducts($productHomeVo);

		if (count($productRelations) == 0) {
			$filter = new ProductHomeExtendVo ();
			$filter->id = $productHomeVo->id;
			$filter->categoryId = $productHomeVo->categoryId;
			$filter->status = $productHomeVo->status;
			$filter->regionId = $productHomeVo->regionId;
			$filter->languageCode = $productHomeVo->languageCode;
			$filter->currencyCode = $productHomeVo->currencyCode;
			$filter->start_record = 0;
			$filter->end_record = 2;

			$productRelations = $this->productExtendDao->getProductHomeRelateCategories($filter);
		}
		return $productRelations;
	}

	public function getBulDiscountByProduct(BulkDiscountExtendVo $bulkDiscountVo){
		$bulkDiscounts = $this->productExtendDao->getBulDiscountByProduct($bulkDiscountVo);
		return $bulkDiscounts;
	}

	private function priceLevelCustomer(){
		if (!is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))) {
			$customerVo = new CustomerVo();
			$customerVo->id = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId;
			$priceLevelDao = new PriceLevelExtendDao();
			$priceLevel = $priceLevelDao->getPriceLevelByCustomerId($customerVo);

			if (!is_null($priceLevel)) {
				return $priceLevel;
			}
		}
		return null;
	}

	public function getBestSellers(ProductHomeExtendVo $productExtendVo = null){
		return $this->productExtendDao->getBestSellers($productExtendVo);
	}
}