<?php

namespace backend\controllers\blog;

use common\persistence\base\vo\BlogVo;
use common\persistence\base\vo\PageVo;
use common\persistence\extend\vo\BlogExtendVo;
use common\persistence\extend\vo\BlogLangExtendVo;
use common\persistence\extend\vo\BlogRegionExtendVo;
use common\persistence\extend\vo\BlogRelationExtendVo;
use common\persistence\extend\vo\BlogSeoExtendVo;
use common\services\blog\BlogService;
use common\services\currency\CurrencyService;
use common\services\language\LanguageService;
use common\services\layout\PageService;
use common\services\region\RegionService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

class BlogController extends PagingController{
	private $blogService;
	private $languageService;
	private $currencyService;
	private $regionService;
	private $pageService;
	public $languages;
	public $categories;
	public $currencies;
	public $blog;
	public $blogs;
	public $id;
	public $blogLangs;
	public $blogRelations;
	public $allBlogs;
	public $blogRegions;
	public $regions;
	public $blogImages;
	public $blogSeos;
	public $blogExtendList;

	public $index;
	public $pages;

	function __construct(){
		parent::__construct();
		$this->filter = new BlogVo ();
		$this->regionService = new RegionService ();
		$this->currencyService = new CurrencyService ();
		$this->languageService = new LanguageService ();
		$this->blogService = new BlogService ();
		$this->pageService = new PageService();
		$this->blog = new BlogVo ();
		$this->blogs = new Paging ();

		$this->blogLangs = new BaseArray (BlogLangExtendVo::class);
		$this->blogRelations = new BaseArray (BlogRelationExtendVo::class);
		$this->blogRegions = new BaseArray (BlogRegionExtendVo::class);
		$this->blogImages = array();
		$this->blogSeos = new BaseArray (BlogSeoExtendVo::class);
		$this->blogExtendList = new BaseArray (BlogExtendVo::class);

		$filter = new PageVo();
		$filter->isSystem = 0;
		$this->pages = $this->pageService->selectByFilter($filter);
	}

	public function listView(){
		$this->getBlogList();
		return "success";
	}

	public function search(){
		$this->getBlogList();
		return "success";
	}

	public function addView(){
		if (AppUtil::isEmptyString($this->blog->featured)) {
			$this->blog->featured = "no";
		}
		$this->initCatalogyAdd();
		$this->allBlogs = $this->blogService->getAllBlogs();
		// $this->regions = $this->regionService->getAll();
		$blogVo = new BlogVo ();
		$blogVo->id = -1;
		$this->getDataBlogExtend($blogVo);
		foreach ($this->blogRegions->getArray() as $region) {
			$region->select = 1;
		}
		return "success";
	}

	public function add(){
		$this->initCatalogyAdd();
		$this->regions = $this->regionService->getAll();
		$this->validInput();
		if ($this->hasErrors() || $this->hasActionErrors()) {
			return "success";
		}
		if (count($this->blogImages) > 0) {
			$this->blog->images = json_encode($this->blogImages);
		}
		if (AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))) {
			$this->blog->taxRateId = 2;
		} else {
			$this->blog->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$blogId = $this->blogService->insertAll($this->blog, $this->blogLangs, $this->blogRelations, $this->blogRegions, $this->blogSeos);
		$this->blog->id = $blogId;
		$this->addActionMessage(Lang::get("Blog is created success"));

		return "success";
	}

	public function addToEdit(){
		$this->initCatalogyAdd();
		$this->regions = $this->regionService->getAll();
		$this->validInput();
		if ($this->hasErrors() || $this->hasActionErrors()) {
			return "success";
		}
		if (count($this->blogImages) > 0) {
			$this->blog->images = json_encode($this->blogImages);
		}
		if (AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))) {
			$this->blog->taxRateId = 2;
		} else {
			$this->blog->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$blogId = $this->blogService->insertAll($this->blog, $this->blogLangs, $this->blogRelations, $this->blogRegions, $this->blogSeos);
		$this->blog->id = $blogId;

		$this->addExtraData("blogId", $blogId);
		return "success";
	}

	public function editView(){
		$this->initCatalogyEdit();
		$blog = new BlogVo ();
		$blog->id = $this->id;
		$this->blog = $this->blogService->getBlogByKey($blog);
		if (!AppUtil::isEmptyString($this->blog->images)) {
			$this->blogImages = json_decode($this->blog->images);
		}
		$this->getDataBlogExtend($this->blog);
		return "success";
	}

	public function edit(){
		$this->initCatalogyEdit();
		$this->validInput();
		if ($this->hasErrors() || $this->hasActionErrors()) {
			return "success";
		}
		if (count($this->blogImages) > 0) {
			$this->blog->images = json_encode($this->blogImages);
		} else {
			$this->blog->images = "";
		}
		if (AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))) {
			$this->blog->taxRateId = 2;
		} else {
			$this->blog->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$this->blogService->updateAll($this->blog, $this->blogLangs, $this->blogRelations, $this->blogRegions, $this->blogSeos);
		$this->getDataBlogExtend($this->blog);
		$this->addActionMessage(Lang::get("Blog is updated successfully"));
		return "success";
	}

	public function editToClose(){
		$this->initCatalogyEdit();
		$this->validInput();
		if ($this->hasErrors() || $this->hasActionErrors()) {
			return "success";
		}

		if (count($this->blogImages) > 0) {
			$this->blog->images = json_encode($this->blogImages);
		} else {
			$this->blog->images = "";
		}
		if (AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))) {
			$this->blog->taxRateId = 2;
		} else {
			$this->blog->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$this->blogService->updateAll($this->blog, $this->blogLangs, $this->blogRelations, $this->blogRegions, $this->blogSeos);
		$this->getDataBlogExtend($this->blog);
		return "success";
	}

	public function copyView(){
		$this->initCatalogyEdit();
		$blog = new BlogVo ();
		$blog->id = $this->id;
		$this->blog = $this->blogService->getBlogByKey($blog);
		if (!AppUtil::isEmptyString($this->blog->images)) {
			$this->blogImages = json_decode($this->blog->images);
		}
		$this->getDataBlogExtend($this->blog);
		return "success";
	}

	public function copy(){
		$this->initCatalogyAdd();
		$this->validInput();
		if ($this->hasErrors() || $this->hasActionErrors()) {
			return "success";
		}
		if (count($this->blogImages) > 0) {
			$this->blog->images = json_encode($this->blogImages);
		}
		if (AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))) {
			$this->blog->taxRateId = 2;
		} else {
			$this->blog->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$blogId = $this->blogService->insertAll($this->blog, $this->blogLangs, $this->blogRelations, $this->blogRegions, $this->blogSeos);
		$this->blog->id = $blogId;
		$this->addActionMessage(Lang::get("Blog is clone success"));

		return "success";
	}

	public function copyToClose(){
		$this->initCatalogyAdd();
		$this->validInput();
		if ($this->hasErrors() || $this->hasActionErrors()) {
			return "success";
		}
		if (count($this->blogImages) > 0) {
			$this->blog->images = json_encode($this->blogImages);
		}
		if (AppUtil::isEmptyString(ApplicationConfig::get('tax.rate.taxable.goods'))) {
			$this->blog->taxRateId = 2;
		} else {
			$this->blog->taxRateId = ApplicationConfig::get('tax.rate.taxable.goods');
		}
		$blogId = $this->blogService->insertAll($this->blog, $this->blogLangs, $this->blogRelations, $this->blogRegions, $this->blogSeos);
		$this->blog->id = $blogId;
		return "success";
	}

	public function delView(){
		$blog = new BlogVo ();
		$blog->id = $this->id;
		$this->blog = $this->blogService->getBlogByKey($blog);
		return "success";
	}

	public function del(){
		$this->blog->id = $this->id;
		$this->blogService->deleteBlog($this->blog);
		$this->addActionMessage(Lang::get("Blog is deleted success"));
		return "success";
	}

	private function getDataBlogExtend(BlogVo $blogVo){
		$this->blogLangs = $this->blogService->getBlogLangsByBlogId($blogVo);
		$this->blogRelations = $this->blogService->getBlogRelationsByBlogId($blogVo);
		$this->blogRegions = $this->blogService->getBlogRegionsByBlogId($blogVo);
		$this->blogSeos = $this->blogService->getBlogSeoByBlogId($blogVo);
	}

	private function initCatalogyEdit(){
		$this->categories = $this->blogService->getAllCategories();
		$this->allBlogs = $this->blogService->getAllBlogs();
	}

	private function initCatalogyAdd(){
		$this->categories = $this->blogService->getAllCategories();
		$this->languages = $this->languageService->getAllLanguages();
		$this->currencies = $this->currencyService->getAll();
	}

	private function validInput(){
		if (AppUtil::isEmptyString($this->blog->categoryBlogId)) {
			$this->addFieldError("blog[categoryBlogId]", Lang::get("Blog category is required."));
		}
		if (AppUtil::isEmptyString($this->blog->name)) {
			$this->addFieldError("blog[name]", Lang::get("Blog name is required."));
		}
		if (AppUtil::isEmptyString($this->blog->status)) {
			$this->addFieldError("blog[status]", Lang::get("Blog status is required."));
		}/*
		if (!AppUtil::isEmptyString ( $this->blog->code )) {
			$regex="/^[a-z0-9 .\-]+$/i";
			if(preg_match($regex, $this->blog->code)==false){
				$this->addFieldError ( "blog[code]", Lang::get ( "Code cannot contain special characters" ));
			}
			if(strpos($this->blog->code, " ") !== false){
				$this->addFieldError ( "blog[code]", Lang::get ( "Code cannot contain spaces" ));
			}
		}*/
	}

	private function getBlogList(){
		$filter = $this->buildBlogFilter();
		$count = $this->blogService->countBlogByFilter($filter);
		$paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$blogVoList = $this->blogService->getBlogByFilter($filter);
		foreach ($blogVoList as $blogVo) {
			$blogVo->featured = AppUtil::arrayValue(ApplicationConfig::get("blog.featured.list"), $blogVo->featured);
			$blogVo->status = AppUtil::arrayValue(ApplicationConfig::get("common.status.list"), $blogVo->status);
		}
		$paging->records = $blogVoList;
		$this->blogs = $paging;
	}

	protected function buildBlogFilter(){
		$filter = $this->buildBaseFilter("id asc");
		return $filter;
	}
}