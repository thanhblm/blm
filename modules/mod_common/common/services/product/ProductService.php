<?php

namespace common\services\product;

use api\service\AliexpressHelper;
use common\persistence\base\dao\AttrGroupBaseDao;
use common\persistence\base\dao\AttributeBaseDao;
use common\persistence\base\dao\BulkDiscountBaseDao;
use common\persistence\base\dao\BulkDiscountProductBaseDao;
use common\persistence\base\dao\ProductAttributeBaseDao;
use common\persistence\base\dao\ProductBaseDao;
use common\persistence\base\dao\ProductLangBaseDao;
use common\persistence\base\dao\ProductPriceBaseDao;
use common\persistence\base\dao\ProductRegionBaseDao;
use common\persistence\base\dao\ProductRelationBaseDao;
use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\AttrGroupVo;
use common\persistence\base\vo\AttributeVo;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\base\vo\CategoryLangVo;
use common\persistence\base\vo\CategoryVo;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\base\vo\ProductLangVo;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductRegionVo;
use common\persistence\base\vo\ProductRelationVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\dao\CategoryExtendDao;
use common\persistence\extend\dao\CategoryLangExtendDao;
use common\persistence\extend\dao\ProductExtendDao;
use common\persistence\extend\dao\ProductLangExtendDao;
use common\persistence\extend\dao\ProductPriceExtendDao;
use common\persistence\extend\dao\ProductRegionExtendDao;
use common\persistence\extend\dao\ProductRelationExtendDao;
use common\persistence\extend\dao\ProductSeoExtendDao;
use common\persistence\extend\dao\SeoInfoLangExtendDao;
use common\persistence\extend\vo\CategoryLangExtendVo;
use common\persistence\extend\vo\ProductBulkDiscountVo;
use common\persistence\extend\vo\ProductLangExtendVo;
use common\persistence\extend\vo\ProductRegionExtendVo;
use common\persistence\extend\vo\ProductRelationExtendVo;
use common\persistence\extend\vo\ProductSeoExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class ProductService extends BaseService{
	private $productDao;
	private $categoryDao;

	public function __construct($context = array()){
		parent::__construct($context);
		$this->productDao = new ProductExtendDao();
		$this->categoryDao = new CategoryExtendDao ();
	}

	public function getAllCategories(){
		return $this->categoryDao->selectAll();
	}

	public function getAllProducts(){
		return $this->productDao->selectAll();
	}

	public function getProductsByCatId($catId){
		$filter = new ProductVo ();
		$filter->categoryId = $catId;
		return $this->productDao->selectByFilter($filter);
	}

	public function getProductByFilter(ProductVo $productVo = null){
		return $this->productDao->getProductByFilter($productVo);
	}

	public function getProductByKey(ProductVo $productVo = null){
		return $this->productDao->selectByKey($productVo);
	}

	public function countProductByFilter(ProductVo $productVo){
		return $this->productDao->countProductByFilter($productVo);
	}

	public function insertAll(ProductVo $product,
	                          BaseArray $productLangs,
	                          BaseArray $productPrices,
	                          BaseArray $productRelations,
	                          BaseArray $productRegions,
	                          BaseArray $productSeos){
		$sqlClient = new SqlMapClient ($this->context);
		$productBaseDao = new ProductBaseDao ($this->context, $sqlClient);
		$productPriceDao = new ProductPriceBaseDao ($this->context, $sqlClient);
		$productLangDao = new ProductLangBaseDao ($this->context, $sqlClient);
		$productRelationDao = new ProductRelationBaseDao ($this->context, $sqlClient);
		$productRegionDao = new ProductRegionBaseDao ($this->context, $sqlClient);
		$seoInfoLangDao = new SeoInfoLangBaseDao ($this->context, $sqlClient);
		$bulkDiscountDao = new BulkDiscountBaseDao($this->context, $sqlClient);
		$productBulkDiscountDao = new BulkDiscountProductBaseDao($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			$product->crDate = date("Y-m-d");
			$product->mdDate = date("Y-m-d");
			if (is_null($product->featured)) {
				$product->featured = 'no';
			}
			$productId = $productBaseDao->insertDynamic($product);

			// Insert Product Lang
			foreach ($productLangs->getArray() as $productLangVo) {
				$productLangVo->productId = $productId;
				$productLangDao->insertDynamic($productLangVo);
			}
			// Insert product Price
			foreach ($productPrices->getArray() as $productPriceVo) {
				$productPriceVo->productId = $productId;
				$productPriceDao->insertDynamic($productPriceVo);
			}
			// Insert Product Relation
			if (count($productRelations->getArray()) > 0) {
				foreach ($productRelations->getArray() as $productRelationVo) {
					$productRelationVo->productId = $productId;
					$productRelationDao->insertDynamic($productRelationVo);
				}
			}
			// Insert Product Region
			if (count($productRegions->getArray()) > 0) {
				foreach ($productRegions->getArray() as $productRegionVo) {
					if ($productRegionVo->select == 1) {
						$productRegionVo->productId = $productId;
						$productRegionDao->insertDynamic($productRegionVo);
					}
				}
			}
			// Insert seo
			foreach ($productSeos->getArray() as $seoVo) {
				$seoVo->itemId = $productId;
				$seoVo->type = "product";
				$seoInfoLangDao->insertDynamic($seoVo);
			}
			// Commit transaction.
			$sqlClient->endTransaction();
			return $productId;
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	public function updateAll(ProductVo $product, BaseArray $productLangs, BaseArray $productPrices, BaseArray $productRelations, BaseArray $productRegions, BaseArray $productSeos){
		$sqlClient = new SqlMapClient ($this->context);
		$productBaseDao = new ProductBaseDao ($this->context, $sqlClient);
		$productPriceDao = new ProductPriceBaseDao ($this->context, $sqlClient);
		$productLangDao = new ProductLangBaseDao ($this->context, $sqlClient);
		$productRelationDao = new ProductRelationBaseDao ($this->context, $sqlClient);
		$productRelationExtendDao = new ProductRelationExtendDao ($this->context, $sqlClient);
		$productRegionExtendDao = new ProductRegionExtendDao ($this->context, $sqlClient);
		$productSeoExtendDao = new ProductSeoExtendDao ($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			if (is_null($product->featured)) {
				$product->featured = 'no';
			}
			$product->mdDate = date("Y-m-d");
			$productBaseDao->updateDynamicByKey($product);
			// ---Manage product price---
			foreach ($productPrices->getArray() as $productPriceVo) {
				//$productPriceVo->productId = $product->id;
				//\DatoLogUtil::debug($productPriceVo->price);
				if (!AppUtil::isEmptyString($productPriceVo->productId)) {
					$productPriceDao->updateDynamicByKey($productPriceVo);
				} else {
					$productPriceVo->productId = $product->id;
					$productPriceDao->insertDynamic($productPriceVo);
				}
			}
			// ---Product Lang ---
			foreach ($productLangs->getArray() as $productLangVo) {
				//$productLangVo->productId = $product->id;
				if (AppUtil::isEmptyString($productLangVo->productId)) {
					$productLangVo->productId = $product->id;
					$productLangDao->insertDynamic($productLangVo);
				} else {
					$productLangDao->updateDynamicByKey($productLangVo);
				}
			}
			// ---Product Relate
			$filterDelete = new ProductVo ();
			$filterDelete->id = $product->id;
			$productRelationExtendDao->deleteProductRelationByProduct($filterDelete);
			foreach ($productRelations->getArray() as $relationVo) {
				$relationVo->productId = $product->id;
				$productRelationDao->insertDynamic($relationVo);
			}
			$productRegionExtendDao->deleteProductRegionByProduct($filterDelete);
			foreach ($productRegions->getArray() as $regionVo) {
				if ($regionVo->select == 1) {
					$regionVo->productId = $product->id;
					$productRegionExtendDao->insertDynamic($regionVo);
				}
			}
			// ---Product Seo ---
			foreach ($productSeos->getArray() as $seoVo) {
				//$seoVo->itemId = $product->id;
				$seoVo->type = "product";
				if (AppUtil::isEmptyString($seoVo->itemId)) {
					$seoVo->itemId = $product->id;
					$productSeoExtendDao->insertDynamic($seoVo);
				} else {
					$productSeoExtendDao->updateDynamicByKey($seoVo);
				}
			}
			// Commit transaction.
			$sqlClient->endTransaction();
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	public function deleteProduct(ProductVo $productVo){
		$sqlClient = new SqlMapClient ($this->context);
		$productBaseDao = new ProductBaseDao ($this->context, $sqlClient);
		$productPriceExtendDao = new ProductPriceExtendDao ($this->context, $sqlClient);
		$productLangExtendDao = new ProductLangExtendDao ($this->context, $sqlClient);
		$productRelationExtendDao = new ProductRelationExtendDao ($this->context, $sqlClient);
		$productRegionExtendDao = new ProductRegionExtendDao ($this->context, $sqlClient);
		$productSeoExtendDao = new ProductSeoExtendDao ($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			$productBaseDao->deleteByKey($productVo);
			$productLangExtendDao->deleteProductLangByProduct($productVo);
			$productPriceExtendDao->deleteProductPriceByProduct($productVo);
			$productRelationExtendDao->deleteProductRelationByProduct($productVo);
			$productRegionExtendDao->deleteProductRegionByProduct($productVo);
			$productSeoExtendDao->deleteProductSeoByProduct($productVo);
			// Commit transaction.
			$sqlClient->endTransaction();
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	// Product Extend
	public function getProductLangsByProductId(ProductVo $productVo){
		$productLangs = new BaseArray (ProductLangExtendVo::class);
		$productLangExtendDao = new ProductLangExtendDao ();
		$list = $productLangExtendDao->selectByProductId($productVo);
		foreach ($list as $productLang) {
			$productLangs->add($productLang);
		}
		return $productLangs;
	}

	public function getProductPricesByProductId(ProductVo $productVo){
		$productPrices = new BaseArray (ProductPriceVo::class);
		$productPriceExtendDao = new ProductPriceExtendDao ();
		$list = $productPriceExtendDao->selectByProductId($productVo);
		foreach ($list as $productPrice) {
			$productPrices->add($productPrice);
		}
		return $productPrices;
	}

	public function getProductRelationsByProductId(ProductVo $productVo){
		$productRelations = new BaseArray (ProductRelationExtendVo::class);
		$productRelationExtendDao = new ProductRelationExtendDao ();
		$list = $productRelationExtendDao->selectProductRelationByProductId($productVo);
		foreach ($list as $relate) {
			$productRelations->add($relate);
		}
		return $productRelations;
	}

	public function getProductRegionsByProductId(ProductVo $productVo){
		$productRegions = new BaseArray (ProductRegionExtendVo::class);
		$productRegionExtendDao = new ProductRegionExtendDao ();
		$list = $productRegionExtendDao->selectProductRegionByProductId($productVo);
		foreach ($list as $region) {
			$region->select = $region->productId != null ? 1 : 0;
			$productRegions->add($region);
		}
		return $productRegions;
	}

	public function getProductSeoByProductId(ProductVo $productVo){
		$productSeos = new BaseArray (ProductSeoExtendVo::class);
		$productSeoExtendDao = new ProductSeoExtendDao ();
		$list = $productSeoExtendDao->selectByProductId($productVo);
		foreach ($list as $seo) {
			$productSeos->add($seo);
		}
		return $productSeos;
	}
	// End product extend


	// Category manager
	public function getCategoryByFilter(CategoryVo $categoryVo = null){
		return $this->categoryDao->getByFilter($categoryVo);
	}

	public function getCategoryByKey(CategoryVo $categoryVo = null){
		return $this->categoryDao->selectByKey($categoryVo);
	}

	public function countCategoryByFilter(CategoryVo $categoryVo = null){
		return $this->categoryDao->getCountByFilter($categoryVo);
	}

	public function createCategory(CategoryVo $categoryVo, BaseArray $categoryLangs, BaseArray $seoInfoLangs){
		$sqlClient = new SqlMapClient ($this->context);
		$categoryDao = new CategoryExtendDao ($this->context, $sqlClient);
		$categoryLangDao = new CategoryLangExtendDao ($this->context, $sqlClient);
		$seoInfoLangDao = new SeoInfoLangExtendDao ($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			// Add to category lang table.
			$categoryId = $categoryDao->insertDynamic($categoryVo);
			// Add category lang langs.
			foreach ($categoryLangs->getArray() as $lang) {
				$lang->categoryId = $categoryId;
				$categoryLangDao->insertDynamic($lang);
			}
			foreach ($seoInfoLangs->getArray() as $seoInfoVo) {
				// Add new category seo info lang .
				$seoInfoVo->itemId = $categoryId;
				$seoInfoVo->type = "category";
				$seoInfoLangDao->insertDynamic($seoInfoVo);
			}
			// Commit transaction.
			$sqlClient->endTransaction();
			return $categoryId;
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	public function updateCategory(CategoryVo $categoryVo, BaseArray $categoryLangs, BaseArray $seoInfoLangs){
		$sqlClient = new SqlMapClient ($this->context);
		$categoryDao = new CategoryExtendDao ($this->context, $sqlClient);
		$categoryLangDao = new CategoryLangExtendDao ($this->context, $sqlClient);
		$seoInfoLangDao = new SeoInfoLangExtendDao ($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			// Update to category table.
			$categoryDao->updateDynamicByKey($categoryVo);
			// Remove all category lang of this category
			// and insert new category lang.
			foreach ($categoryLangs->getArray() as $lang) {
				// Delete category lang.
				$categoryLangDao->deleteByKey($lang);
				// Add new category lang.
				$categoryLangDao->insertDynamic($lang);
			}
			foreach ($seoInfoLangs->getArray() as $seoInfoVo) {
				// Delete category lang.
				$seoInfoLangDao->deleteByKey($seoInfoVo);
				// Add new category lang.
				$seoInfoLangDao->insertDynamic($seoInfoVo);
			}
			// Commit transaction.
			$sqlClient->endTransaction();
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	public function deleteCategory(CategoryVo $categoryVo = null){
		$sqlClient = new SqlMapClient ($this->context);
		$categoryDao = new CategoryExtendDao ($this->context, $sqlClient);
		$categoryLangDao = new CategoryLangExtendDao ($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			$filter = new CategoryLangVo ();
			$filter->categoryId = $categoryVo->id;
			$categoryLangs = $categoryLangDao->selectByFilter($filter);
			// Delete category lang.
			foreach ($categoryLangs as $lang) {
				$categoryLangDao->deleteByKey($lang);
			}
			$categoryDao->deleteByKey($categoryVo);
			// Commit transaction.
			$sqlClient->endTransaction();
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	public function getLangsByCategoryId(CategoryLangExtendVo $filter){
		$categoryLangDao = new CategoryLangExtendDao ();
		return $categoryLangDao->getLangsByCategoryId($filter);
	}

	public function getSeoInfosByCategoryId(SeoInfoLangExtendVo $filter){
		$seoInfoDao = new SeoInfoLangExtendDao ();
		return $seoInfoDao->getLangsByKey($filter);
	}

	public function updateProductPrice($productPriceVo){
		$productPriceDao = new ProductPriceBaseDao();
		$productPriceDao->deleteByKey($productPriceVo);
		$productPriceDao->insertDynamic($productPriceVo);
	}

	// End Category manager

	public function insertAllAliexpress(ProductVo $product,
	                                    BaseArray $productLangs,
	                                    BaseArray $productPrices,
	                                    BaseArray $productRelations,
	                                    BaseArray $productRegions,
	                                    BaseArray $productSeos,
	                                    BulkDiscountVo $bulkDiscountVo = null,
	                                    BaseArray $attrGroupExtendVos = null,
	                                    $productAttributeJson = null){
		$sqlClient = new SqlMapClient ($this->context);
		$productBaseDao = new ProductBaseDao ($this->context, $sqlClient);
		$productPriceDao = new ProductPriceBaseDao ($this->context, $sqlClient);
		$productLangDao = new ProductLangBaseDao ($this->context, $sqlClient);
		$productRelationDao = new ProductRelationBaseDao ($this->context, $sqlClient);
		$productRegionDao = new ProductRegionBaseDao ($this->context, $sqlClient);
		$seoInfoLangDao = new SeoInfoLangBaseDao ($this->context, $sqlClient);
		$bulkDiscountDao = new BulkDiscountBaseDao($this->context, $sqlClient);
		$productBulkDiscountDao = new BulkDiscountProductBaseDao($this->context, $sqlClient);
		$attrGroupDao = new AttrGroupBaseDao($this->context, $sqlClient);
		$attributeDao = new AttributeBaseDao($this->context, $sqlClient);
		$productAttributeDao = new ProductAttributeBaseDao($this->context, $sqlClient);
		// Begin transaction.
		$sqlClient->startTransaction();
		try {
			$product->crDate = date("Y-m-d");
			$product->mdDate = date("Y-m-d");
			if (is_null($product->featured)) {
				$product->featured = 'no';
			}
			$productId = $productBaseDao->insertDynamic($product);

			if (isset($bulkDiscountVo)) {
				if ($bulkDiscountVo->discount > 0) {
					$bulkDiscountId = $bulkDiscountDao->insertDynamic($bulkDiscountVo);
					$productBulkDiscount = new ProductBulkDiscountVo();
					$productBulkDiscount->quantity = 1;
					$productBulkDiscount->productId = $productId;
					$productBulkDiscount->bulkDiscountId = $bulkDiscountId;
					$productBulkDiscountDao->insertDynamic($productBulkDiscount);
				}
			}

			$listAttributeMap = array();

			if (isset($attrGroupExtendVos) && !empty($attrGroupExtendVos->getArray()) && count($attrGroupExtendVos->getArray()) > 0) {
				foreach ($attrGroupExtendVos->getArray() as $attrGroupExtendVo) { // AttrGroupExtendVo
					$attrGroupVo = new AttrGroupVo();
					AppUtil::copyProperties($attrGroupExtendVo, $attrGroupVo);
					$attrGroupFilter = new AttrGroupVo();
					$attrGroupFilter->name = $attrGroupVo->name;
					$attrGroupFilters = $attrGroupDao->selectByFilter($attrGroupFilter);
					$attrGroupId = "";
					if (!AppUtil::isEmptyString($attrGroupVo->name)) {
						if (count($attrGroupFilters) > 0) {
							$attrGroupId = $attrGroupFilters[0]->id;
						} else {
							$attrGroupId = $attrGroupDao->insertDynamic($attrGroupVo);
						}
					}
					if (isset($attrGroupExtendVo->listAttr) && !empty($attrGroupExtendVo->listAttr->getArray())) {
						foreach ($attrGroupExtendVo->listAttr->getArray() as $key => $attributeVo) {
							$attributeVo->attrGroupId = $attrGroupId;
							$attributeVo->categoryId = $product->categoryId;

							if (isset($attributeVo->code) && $attributeDao->countByFilter($attributeVo) === 0) {
								if ($attributeVo->type == "image") {
									$attributeVo->image = AliexpressHelper::importImageFromUrl($attributeVo->image, "attribute", $key);
								}
								$attributeId = $attributeDao->insertDynamic($attributeVo);
								$listAttributeMap[$attributeId] = $attributeVo->code;
							} elseif (isset($attributeVo->code) && $attributeDao->countByFilter($attributeVo) > 0) {
								$listAttributeVos = $attributeDao->selectByFilter($attributeVo);
								if (isset($listAttributeVos[0])) {
									$listAttributeMap[$listAttributeVos[0]->id] = $listAttributeVos[0]->code;
								}
							}
						}
					}
				}

				\DatoLogUtil::devInfo($listAttributeMap);
				if (isset($productAttributeJson)) {
					$listProductAttribute = json_decode($productAttributeJson);
					\DatoLogUtil::devInfo($listProductAttribute);
					if (count($listProductAttribute) > 0) {
						foreach ($listProductAttribute as $productAttr) {
							$productAttributeVo = new ProductAttributeVo();
							$productAttributeVo->productId = $productId;
							$productAttributeVo->quantity = $productAttr->skuVal->availQuantity;
							$skuPropIds = "";
							$listAttributeResultJson = explode(",", $productAttr->skuPropIds);
							$listAttributeResults = array();
							foreach($listAttributeResultJson as $listAttributeResult){
								foreach ($listAttributeMap as $attributeId => $attributeCode) {
									if ($listAttributeResult === $attributeCode) {
										$listAttributeResult = $attributeId;
									}
								}
								array_push($listAttributeResults, $listAttributeResult);
							}

							$productAttributeVo->attributeId = json_encode($listAttributeResults);
							$productAttributeVo->price = $productAttr->skuVal->skuMultiCurrencyDisplayPrice;
							$productAttributeDao->insertDynamic($productAttributeVo);
						}
					}
				}
			}

			// Insert Product Lang
			foreach ($productLangs->getArray() as $productLangVo) {
				$productLangVo->productId = $productId;
				$productLangDao->insertDynamic($productLangVo);
			}
			// Insert product Price
			foreach ($productPrices->getArray() as $productPriceVo) {
				$productPriceVo->productId = $productId;
				$productPriceDao->insertDynamic($productPriceVo);
			}
			// Insert Product Relation
			if (count($productRelations->getArray()) > 0) {
				foreach ($productRelations->getArray() as $productRelationVo) {
					$productRelationVo->productId = $productId;
					$productRelationDao->insertDynamic($productRelationVo);
				}
			}
			// Insert Product Region
			if (count($productRegions->getArray()) > 0) {
				foreach ($productRegions->getArray() as $productRegionVo) {
					$productRegionVo->productId = $productId;
					$productRegionDao->insertDynamic($productRegionVo);
				}
			}
			// Insert seo
			foreach ($productSeos->getArray() as $seoVo) {
				$seoVo->itemId = $productId;
				$seoVo->type = "product";
				$seoInfoLangDao->insertDynamic($seoVo);
			}
			// Commit transaction.
			$sqlClient->endTransaction();
			return $productId;
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}
}