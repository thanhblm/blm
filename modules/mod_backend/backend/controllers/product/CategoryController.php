<?php

namespace backend\controllers\product;

use common\persistence\base\vo\AreaCategoryVo;
use common\persistence\base\vo\CategoryVo;
use common\persistence\extend\vo\AreaExtendVo;
use common\persistence\extend\vo\CategoryExtendVo;
use common\persistence\extend\vo\CategoryLangExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\services\area\AreaCategoryService;
use common\services\area\AreaService;
use common\services\category\CategoryService;
use common\services\language\LanguageService;
use common\services\product\ProductService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;

class CategoryController extends PagingController{
	public $categories;
	public $category;
	public $categoryList;
	public $listArea;
	public $listAreaApply;
	public $id;
	public $seoInfoLanguages;
	public $categoryLanguages;
	public $areaCats;

	private $productService;
	private $languageService;
	private $areaSv;
	private $categorySv;
	private $areaCategorySv;

	public function __construct(){
		parent::__construct();
		$this->filter = new CategoryExtendVo ();
		$this->category = new CategoryVo ();
		$this->categories = new Paging ();
		$this->categorySv = new CategoryService();
		$this->productService = new ProductService ();
		$this->areaSv = new AreaService();
		$this->areaCategorySv = new AreaCategoryService();
		$this->languageService = new LanguageService ();
		$this->categoryLanguages = new BaseArray (CategoryLangExtendVo::class);
		$this->seoInfoLanguages = new BaseArray (SeoInfoLangExtendVo::class);
		$this->pageTitle = ApplicationConfig::get("site.name") . "- Category Management";
		$this->areaCats = new BaseArray(AreaExtendVo::class);
	}

	public function listView(){
		$this->getCategories();
		return "success";
	}

	public function search(){
		$this->getCategories();
		return "success";
	}

	public function addView(){
		$this->getCategoryLanguages();
		$this->getSeoLangInfos();
		$this->category->featured = 'no';
		$this->category->status = 'active';
		$categorryVo = new CategoryExtendVo();
		$categorryVo->status = "active";
		$categorryVo->featured = 'no';
		$this->categoryList = $this->categorySv->selectByFilter($categorryVo);
		$this->getAllArea();
		return "success";
	}

	public function add(){
		$this->validate();
		if ($this->hasErrors()) {
			return "success";
		}
		// Set some initial values.
		$this->category->crDate = date('Y-m-d H:i:s');
		$this->category->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		$this->category->mdDate = date('Y-m-d H:i:s');
		$this->category->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		// Add to the database.
		$categoryId = $this->productService->createCategory($this->category, $this->categoryLanguages, $this->seoInfoLanguages);

		foreach ($this->listAreaApply as $areaId => $imageIds) {
			$areaCategoryVo = new AreaCategoryVo();
			$areaCategoryVo->categoryId = $this->category->id;
			$areaCategoryVo->areaId = $areaId;
			$areaCategoryVo->image = $imageIds[0];
			$this->areaCategorySv->insertDynamic($areaCategoryVo);
		}
		$this->addActionMessage("The category is added successfully");
		$this->addExtraData("categoryId", $categoryId);
		return "success";
	}

	public function editView(){
		if (AppUtil::isEmptyString($this->id)) {
			throw new \Exception ("No id for editing");
		}
		// Load category.
		$this->getCategory();
		$this->getCategoryLanguages();
		$this->getSeoLangInfos();
		$this->getAllArea();
		$this->category->featured = 'no';
		$this->category->status = 'active';
		$categorryVo = new CategoryExtendVo();
		$categorryVo->status = "active";
		$categorryVo->featured = 'no';
		$this->categoryList = $this->categorySv->selectByFilter($categorryVo);
		return "success";
	}

	public function edit(){
		$this->validate(false);
		if ($this->hasErrors()) {
			return "success";
		}
		// Save to the database.
		$this->category->mdDate = date('Y-m-d H:i:s');
		$this->category->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		$this->productService->updateCategory($this->category, $this->categoryLanguages, $this->seoInfoLanguages);
		foreach ($this->areaCats->getArray() as $areaExtendVo) {
			if(!AppUtil::isEmptyString($areaExtendVo->image)){
				$areaCategoryVo = new AreaCategoryVo();
				$areaCategoryVo->categoryId = $this->category->id;
				$areaCategoryVo->areaId = $areaExtendVo->areaId;
				$areaCategoryUpdateVo = $this->areaCategorySv->selectByKey($areaCategoryVo);
				if (!is_null($areaCategoryUpdateVo)) {
					$areaCategoryUpdateVo->image = $areaExtendVo->image;
					$areaCategoryUpdateVo->description = $areaExtendVo->description;
					$this->areaCategorySv->updateDynamicByKey($areaCategoryUpdateVo);
				} else {
					$areaCategoryVo->image = $areaExtendVo->image;
					$areaCategoryVo->description = $areaExtendVo->description;
					$this->areaCategorySv->insertDynamic($areaCategoryVo);
				}
			}

		}
		$this->getAllArea();
		$this->addActionMessage("The category is updated successfully");
		$this->addExtraData("categoryId", $this->category->id);
		return "success";
	}

	public function copyView(){
		if (AppUtil::isEmptyString($this->id)) {
			throw new \Exception ("No id for cloning");
		}
		$this->getCategory();
		$this->category->status = 'active';
		$this->getCategoryLanguages();
		$this->getSeoLangInfos();
		$this->getAllArea();
		return "success";
	}

	public function copy(){
		$this->validate();
		if ($this->hasErrors()) {
			return "success";
		}
		// Save to the database.
		$this->category->crDate = date('Y-m-d H:i:s');
		$this->category->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		$this->category->mdDate = date('Y-m-d H:i:s');
		$this->category->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		$this->productService->createCategory($this->category, $this->categoryLanguages, $this->seoInfoLanguages);
		$this->addActionMessage("The category cloned successfully");
		$this->addExtraData("categoryId", $this->category->id);
		return "success";
	}

	public function delView(){
		if (AppUtil::isEmptyString($this->id)) {
			throw new \Exception ("No id for deleting");
		}
		// Load category.
		$this->getCategory();
		return "success";
	}

	public function del(){
		if (AppUtil::isEmptyString($this->id)) {
			throw new \Exception ("No id for deleting");
		}
		// Deletecategory.
		$filter = new CategoryVo ();
		$filter->id = $this->id;
		$this->productService->deleteCategory($filter);
		$this->addActionMessage("The category deleted successfully");
		return "success";
	}

	protected function validate($isAdding = true){
		if (AppUtil::isEmptyString($this->category->orderNo)) {
			$this->addFieldError("category[orderNo]", "Order number is required");
		}

		if (AppUtil::isEmptyString($this->category->name)) {
			$this->addFieldError("category[name]", "Name is required");
		}

		if (!AppUtil::isEmptyString($this->category->name)) {
			$regex = "/^[a-z0-9 .\-]+$/i";
			if (preg_match($regex, $this->category->name) == false) {
				//$this->addFieldError("category[name]", "Name cannot contain special characters");
			}
		}
		if (AppUtil::isEmptyString($this->category->status)) {
			$this->addFieldError("category[status]", "Status is required");
		}
	}

	protected function getCategories(){
		$filter = $this->buildFilter();
		// Get total records of categories.
		$count = $this->productService->countCategoryByFilter($filter);
		// Create new paging object.
		$paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get categories.
		$categoryVos = $this->productService->getCategoryByFilter($filter);
		foreach ($categoryVos as $categoryVo) {
			$categoryVo->status = AppUtil::arrayValue(ApplicationConfig::get("common.status.list"), $categoryVo->status);
			$categoryVo->featured = AppUtil::arrayValue(ApplicationConfig::get("category.featured.list"), $categoryVo->featured);
		}
		$paging->records = $categoryVos;
		$this->categories = $paging;
	}

	protected function getCategoryLanguages(){
		$filter = new CategoryLangExtendVo ();
		if (AppUtil::isEmptyString($this->id)) {
			$this->id = -1;
		}
		$filter->categoryId = $this->id;
		$categoryLangVos = $this->productService->getLangsByCategoryId($filter);
		$result = new BaseArray (CategoryLangExtendVo::class);
		foreach ($categoryLangVos as $categoryLangVo) {
			$categoryLangVo->categoryId = $this->id;
			$categoryLangVo->languageCode = $categoryLangVo->code;
			$result->add($categoryLangVo);
		}
		$this->categoryLanguages = $result;
	}

	protected function buildFilter(){
		return $this->buildBaseFilter("id asc");
	}

	protected function getCategory(){
		$filter = new CategoryVo ();
		$filter->id = $this->id;
		$this->category = $this->productService->getCategoryByKey($filter);
	}

	protected function getAllArea(){
		$filter = new AreaExtendVo();
		$filter->categoryId = $this->id;
		$areaExtendVos = $this->areaSv->getAreaFull($filter);
		if(count($areaExtendVos) > 0){
			$this->areaCats = new BaseArray(AreaExtendVo::class);
			foreach ($areaExtendVos as $areaExtendVo){
				$this->areaCats->add($areaExtendVo);
			}
		}
	}

	protected function getSeoLangInfos(){
		$filter = new SeoInfoLangExtendVo ();
		$filter->itemId = $this->id;
		$filter->type = 'category';
		$seoInfoLangVos = $this->productService->getSeoInfosByCategoryId($filter);
		$result = new BaseArray (SeoInfoLangExtendVo::class);
		foreach ($seoInfoLangVos as $seoInfoLangVo) {
			$seoInfoLangVo->itemId = $this->id;
			$seoInfoLangVo->languageCode = $seoInfoLangVo->code;
			$seoInfoLangVo->type = 'category';
			$result->add($seoInfoLangVo);
		}
		$this->seoInfoLanguages = $result;
	}
}
