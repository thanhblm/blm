<?php

namespace backend\controllers\product;

use common\filter\attribute_group\AttributeFilter;
use common\persistence\base\vo\AttrGroupVo;
use common\persistence\base\vo\PageVo;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\vo\AttributeExtendVo;
use common\persistence\extend\vo\CurrencyExtendVo;
use common\persistence\extend\vo\ProductExtendVo;
use common\persistence\extend\vo\ProductLangExtendVo;
use common\persistence\extend\vo\ProductRegionExtendVo;
use common\persistence\extend\vo\ProductRelationExtendVo;
use common\persistence\extend\vo\ProductSeoExtendVo;
use common\services\attribute\AttributeGroupService;
use common\services\attribute\AttributeService;
use common\services\attribute\ProductAttributeService;
use common\services\attribute\ProductProductAttributeService;
use common\services\currency\CurrencyService;
use common\services\language\LanguageService;
use common\services\layout\PageService;
use common\services\product\ProductService;
use common\services\region\RegionService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

class ProductController extends PagingController {
	private $productService;
	private $languageService;
	private $currencyService;
	private $regionService;
	private $pageService;
	public $languages;
	public $categories;
	public $currencies;
	public $product;
	public $products;
	public $id;
	public $productLangs;
	public $productPrices;
	public $productPrice;
	public $productRelations;
	public $allProducts;
	public $productRegions;
	public $regions;
	public $productImages;
	public $productSeos;
	public $productExtendList;
	public $productAttributes;
	public $attributes;
	public $attributeGroup;
	public $attrGroupId;

	public $index;
	public $pages;
	private $attributeSv;
	private $productAttributeSv;
	private $attributeGroupSv;
	function __construct() {
		parent::__construct ();
		$this->filter = new ProductVo ();
		$this->regionService = new RegionService ();
		$this->currencyService = new CurrencyService ();
		$this->languageService = new LanguageService ();
		$this->productService = new ProductService ();
		$this->pageService = new PageService();
		$this->product = new ProductVo ();
		$this->products = new Paging ();
		$this->productPrice = new ProductPriceVo ();
		
		$this->productLangs = new BaseArray ( ProductLangExtendVo::class );
		$this->productPrices = new BaseArray ( ProductPriceVo::class );
		$this->productRelations = new BaseArray ( ProductRelationExtendVo::class );
		$this->productRegions = new BaseArray ( ProductRegionExtendVo::class );
		$this->productImages = array ();
		$this->productSeos = new BaseArray ( ProductSeoExtendVo::class );
		$this->productExtendList = new BaseArray ( ProductExtendVo::class );
		$this->productAttributeSv = new ProductAttributeService();
		$this->attributeSv = new AttributeService();
		$this->attributeGroupSv = new AttributeGroupService();

		$this->attributeGroup = new BaseArray(AttrGroupVo::class);
		$this->attributes = new BaseArray(AttributeExtendVo::class);

		$filter = new PageVo();
        $filter->isSystem = 0;
		$this->pages = $this->pageService->selectByFilter($filter);
	}
	public function listView() {
		$this->getProductList ();
		return "success";
	}
	public function search() {
		$this->getProductList ();
		return "success";
	}
	public function addView() {
		if (AppUtil::isEmptyString ( $this->product->featured )) {
			$this->product->featured = "no";
		}
		$this->initCatalogyAdd ();
		$this->getProductAttributes ();
		$this->getAttributeGroup();
		$this->getAttributes();
		$this->allProducts = $this->productService->getAllProducts ();
		// $this->regions = $this->regionService->getAll();
		$productVo = new ProductVo ();
		$productVo->id = - 1;
		$this->getDataProductExtend ( $productVo );
		foreach ( $this->productRegions->getArray () as $region ) {
			$region->select = 1;
		}
		return "success";
	}
	public function add() {
		$this->initCatalogyAdd ();
		$this->regions = $this->regionService->getAll ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		if (count ( $this->productImages ) > 0) {
			$this->product->images = json_encode ( $this->productImages );
		}
		if(AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))){
			$this->product->taxRateId = 2;
		}else{
			$this->product->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$productId = $this->productService->insertAll ( $this->product, $this->productLangs, $this->productPrices, $this->productRelations, $this->productRegions, $this->productSeos );
		$this->product->id = $productId;

		$this->addExtraData(
			'product', [
				'id' => $productId,
				'url_edit' => "https://localhost/sbirdsvn/admin/product/edit/view?id={$productId}", //todo update later
				'url_view' => "https://localhost/sbirdsvn/vi/p{$productId}-" //todo update later
			]
		);
		$this->addActionMessage ( Lang::get ( "Product is created success" ) );
		return "success";
	}
	public function addToEdit() {
		$this->initCatalogyAdd ();
		$this->regions = $this->regionService->getAll ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		if (count ( $this->productImages ) > 0) {
			$this->product->images = json_encode ( $this->productImages );
		}
		if(AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))){
			$this->product->taxRateId = 2;
		}else{
			$this->product->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$productId = $this->productService->insertAll ( $this->product, $this->productLangs, $this->productPrices, $this->productRelations, $this->productRegions, $this->productSeos );
		$this->product->id = $productId;
		
		$this->addExtraData(
			'product', [
				'id' => $productId,
				'url_edit' => "https://localhost/sbirdsvn/admin/product/edit/view?id={$productId}", //todo update later
				'url_view' => "https://localhost/sbirdsvn/vi/p{$productId}-" //todo update later
			]
		);
		return "success";
	}
	public function editView() {
		$this->initCatalogyEdit ();
		$this->getProductAttributes ();
		$this->getAttributeGroup();
		$this->getAttributes();
		$product = new ProductVo ();
		$product->id = $this->id;
		$this->product = $this->productService->getProductByKey ( $product );
		if (! AppUtil::isEmptyString ( $this->product->images )) {
			$this->productImages = json_decode ( $this->product->images );
		}
		$this->getDataProductExtend ( $this->product );
		return "success";
	}
	public function edit() {
		$this->initCatalogyEdit ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		if (count ( $this->productImages ) > 0) {
			$this->product->images = json_encode ( $this->productImages );
		}else{
			$this->product->images = "";
		}
		if(AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))){
			$this->product->taxRateId = 2;
		}else{
			$this->product->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$this->productService->updateAll ( $this->product, $this->productLangs, $this->productPrices, $this->productRelations, $this->productRegions, $this->productSeos );
		$this->getDataProductExtend ( $this->product );
		$this->addActionMessage ( Lang::get ( "Product is updated successfully" ) );

		$this->addExtraData(
			'product', [
				'id' => $this->product->id,
				'url_edit' => "https://localhost/sbirdsvn/admin/product/edit/view?id={$this->product->id}", //todo update later
				'url_view' => "https://localhost/sbirdsvn/vi/p{$this->product->id}-" //todo update later
			]
		);
		return "success";
	}
	public function editToClose(){
		$this->initCatalogyEdit ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		
		if (count ( $this->productImages ) > 0) {
			$this->product->images = json_encode ( $this->productImages );
		}else{
			$this->product->images = "";
		}
		if(AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))){
			$this->product->taxRateId = 2;
		}else{
			$this->product->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$this->productService->updateAll ( $this->product, $this->productLangs, $this->productPrices, $this->productRelations, $this->productRegions, $this->productSeos );
		$this->getDataProductExtend ( $this->product );

		$this->addExtraData(
			'product', [
				'id' => $this->product->id,
				'url_edit' => "https://localhost/sbirdsvn/admin/product/edit/view?id={$this->product->id}", //todo update later
				'url_view' => "https://localhost/sbirdsvn/vi/p{$this->product->id}-" //todo update later
			]
		);
		return "success";
	}
	public function copyView() {
		$this->initCatalogyEdit ();
		$product = new ProductVo ();
		$product->id = $this->id;
		$this->product = $this->productService->getProductByKey ( $product );
		if (! AppUtil::isEmptyString ( $this->product->images )) {
			$this->productImages = json_decode ( $this->product->images );
		}
		$this->getDataProductExtend ( $this->product );
		return "success";
	}
	public function copy() {
		$this->initCatalogyAdd ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		if (count ( $this->productImages ) > 0) {
			$this->product->images = json_encode ( $this->productImages );
		}
		if(AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))){
			$this->product->taxRateId = 2;
		}else{
			$this->product->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$productId = $this->productService->insertAll ( $this->product, $this->productLangs, $this->productPrices, $this->productRelations, $this->productRegions, $this->productSeos );
		$this->product->id = $productId;
		$this->addActionMessage ( Lang::get ( "Product is clone success" ) );
		
		return "success";
	}
	public function copyToClose(){
		$this->initCatalogyAdd ();
		$this->validInput ();
		if ($this->hasErrors () || $this->hasActionErrors ()) {
			return "success";
		}
		if (count ( $this->productImages ) > 0) {
			$this->product->images = json_encode ( $this->productImages );
		}
		if(AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))){
			$this->product->taxRateId = 2;
		}else{
			$this->product->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$productId = $this->productService->insertAll ( $this->product, $this->productLangs, $this->productPrices, $this->productRelations, $this->productRegions, $this->productSeos );
		$this->product->id = $productId;
		return "success";
	}
	public function delView() {
		$product = new ProductVo ();
		$product->id = $this->id;
		$this->product = $this->productService->getProductByKey ( $product );
		return "success";
	}
	public function del() {
		$this->product->id = $this->id;
		$this->productService->deleteProduct ( $this->product );
		$this->addActionMessage ( Lang::get ( "Product is deleted success" ) );
		return "success";
	}

	public function getAttributeByGroup(){
		$attributeExtendVo = new AttributeFilter();
		$attributeExtendVo->attrGroupId = $this->attrGroupId;
		$attributeExtendVos = $this->attributeSv->search($attributeExtendVo);
		foreach ($attributeExtendVos as $attributeExtendVo){
			$this->attributes->add($attributeExtendVo);
		}
		$this->addExtraData("attrGroupId", $this->attrGroupId);
		return "success";
	}
	private function getDataProductExtend(ProductVo $productVo) {
		$this->productLangs = $this->productService->getProductLangsByProductId ( $productVo );
		$this->productPrices = $this->productService->getProductPricesByProductId ( $productVo );
		$this->productRelations = $this->productService->getProductRelationsByProductId ( $productVo );
		$this->productRegions = $this->productService->getProductRegionsByProductId ( $productVo );
		$this->productSeos = $this->productService->getProductSeoByProductId ( $productVo );
	}
	private function initCatalogyEdit() {
		$this->categories = $this->productService->getAllCategories ();
		$this->allProducts = $this->productService->getAllProducts ();
	}
	private function getProductAttributes() {
		$this->productAttributes = $this->productAttributeSv->getAllProductAttribute ();
	}
	private function getAttributes() {
		$attributeExtendVo = new AttributeFilter();
		$this->attributes = $this->attributeSv->search($attributeExtendVo);
	}
	private function getAttributeGroup() {
		$attrGroupVo = new AttrGroupVo();
		$attributeGroups = $this->attributeGroupSv->getByFilter($attrGroupVo);
		foreach ($attributeGroups as $attributeGroupVo){
			$this->attributeGroup->add($attributeGroupVo);
		}
	}


	private function initCatalogyAdd() {
		$this->categories = $this->productService->getAllCategories ();
		$this->languages = $this->languageService->getAllLanguages ();
		$this->currencies = $this->currencyService->getAll ();
	}
	private function validInput() {
		if (AppUtil::isEmptyString ( $this->product->categoryId )) {
			$this->addFieldError ( "product[categoryId]", Lang::get ( "Product category is required." ) );
		}
		if (AppUtil::isEmptyString ( $this->product->name )) {
			$this->addFieldError ( "product[name]", Lang::get ( "Product name is required." ) );
		}
		if (AppUtil::isEmptyString ( $this->product->status )) {
			$this->addFieldError ( "product[status]", Lang::get ( "Product status is required." ) );
		}/*
		if (!AppUtil::isEmptyString ( $this->product->code )) {
			$regex="/^[a-z0-9 .\-]+$/i";
			if(preg_match($regex, $this->product->code)==false){
				$this->addFieldError ( "product[code]", Lang::get ( "Code cannot contain special characters" ));
			}
			if(strpos($this->product->code, " ") !== false){
				$this->addFieldError ( "product[code]", Lang::get ( "Code cannot contain spaces" ));
			}
		}*/
		foreach ( $this->productPrices->getArray () as $price ) {
			if (AppUtil::isEmptyString ( $price->price )) {
				$this->addActionError ( Lang::get ( "Product price is required." ) );
				break;
			}
		}
	}
	private function getProductList() {
		$filter = $this->buildProductFilter ();
		$count = $this->productService->countProductByFilter ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$productVoList = $this->productService->getProductByFilter ( $filter );
		foreach ( $productVoList as $productVo ) {
			$productVo->featured = AppUtil::arrayValue ( ApplicationConfig::get ( "product.featured.list" ), $productVo->featured );
			$productVo->status = AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ), $productVo->status );
		}
		$paging->records = $productVoList;
		$this->products = $paging;
	}
	protected function buildProductFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	public function productPriceList(){
		$this->getProductPriceList ();
		return "success";
	}
	public function productPriceSearch(){
		$this->getProductPriceList ();
		return "success";
	}
	private function getProductPriceList() {
		$currencyFilter= new CurrencyExtendVo();
		$currencyFilter->order_by='itemCode';
		$this->currencies = $this->currencyService->getByFilter($currencyFilter);
		
		$filter = $this->buildProductFilter ();
		$count = $this->productService->countProductByFilter ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$productVoList = $this->productService->getProductByFilter ( $filter );
		$productVoExtendList=array();
		foreach ( $productVoList as $productVo ) {
			$productExt= new ProductExtendVo();
			AppUtil::copyProperties($productVo, $productExt);
			$productExt->prices=$this->productService->getProductPricesByProductId( $productVo )->getArray();
			//var_dump($productExt->prices);
			$productVoExtendList[]=$productExt;
		}
		$paging->records = $productVoExtendList;
		//var_dump($productVoExtendList);
		$this->products = $paging;
	}
	
	public function changeProductPrice(){
		//var_dump($this->productPrice);die;
		$this->productService->updateProductPrice($this->productPrice);
		return  "success";
	}
}