<?php

namespace backend\controllers\blog;

use common\persistence\base\vo\CategoryBlogVo;
use common\persistence\extend\vo\CategoryBlogExtendVo;
use common\persistence\extend\vo\CategoryBlogLangExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\services\blog\BlogService;
use common\services\category\CategoryBlogService;
use common\services\language\LanguageService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

class CategoryBlogController extends PagingController
{
    public $categoriesBlog;
    public $categoryBlog;
    public $categoryBlogList;
    public $id;
    public $seoInfoLanguages;
    public $categoryBlogLanguages;
    private $blogService;
    private $languageService;
    private $categoryBlogSv;

    public function __construct()
    {
        parent::__construct();
        $this->filter = new CategoryBlogExtendVo();
        $this->categoryBlog = new CategoryBlogVo();
        $this->categoriesBlog = new Paging ();
        $this->categoryBlogSv = new CategoryBlogService();
        $this->blogService = new BlogService();
        $this->languageService = new LanguageService ();
        $this->categoryBlogLanguages = new BaseArray (CategoryBlogLangExtendVo::class);
        $this->seoInfoLanguages = new BaseArray (SeoInfoLangExtendVo::class);
        $this->pageTitle = ApplicationConfig::get("site.name") . "- CategoryBlog Blog Management";
    }

    public function listView()
    {
        $this->getCategories();
        return "success";
    }

    public function search()
    {
        $this->getCategories();
        return "success";
    }

    public function addView()
    {
        $this->getCategoryBlogLanguages();
        $this->getCategories();
        $this->getSeoLangInfos();
        $this->categoryBlog->featured = 'no';
        $this->categoryBlog->status = 'active';
        $categoryVo = new CategoryBlogExtendVo();
        $categoryVo->status = "active";
        $categoryVo->featured = 'no';
        $this->categoryBlog = $this->categoryBlogSv->selectByFilter($categoryVo);
        return "success";
    }

    public function add()
    {
        $this->validate();
        if ($this->hasErrors()) {
            return "success";
        }
        // Set some initial values.
        $this->categoryBlog->crDate = date('Y-m-d H:i:s');
        $this->categoryBlog->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->categoryBlog->mdDate = date('Y-m-d H:i:s');
        $this->categoryBlog->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        // Add to the database.
        $categoryBlogId = $this->categoryBlogSv->createCategoryBlog($this->categoryBlog, $this->categoryBlogLanguages, $this->seoInfoLanguages);
        $this->addActionMessage("The categoryBlog is added successfully");
        $this->addExtraData("categoryBlogId", $categoryBlogId);
        return "success";
    }

    public function editView()
    {
        if (AppUtil::isEmptyString($this->id)) {
            throw new \Exception ("No id for editing");
        }
        // Load categoryBlog.
        $this->getCategoryBlog();
        $this->getCategories();
        $this->getCategoryBlogLanguages();
        $this->getSeoLangInfos();
        return "success";
    }

    public function edit()
    {
        $this->validate(false);
        if ($this->hasErrors()) {
            return "success";
        }
        $this->getSeoLangInfos();
        // Save to the database.
        $this->categoryBlog->mdDate = date('Y-m-d H:i:s');
        $this->categoryBlog->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->categoryBlogSv->updateCategoryBlog($this->categoryBlog, $this->categoryBlogLanguages, $this->seoInfoLanguages);
        $this->addActionMessage("The categoryBlog is updated successfully");
        $this->addExtraData("categoryBlogId", $this->categoryBlog->id);
        return "success";
    }

    public function copyView()
    {
        if (AppUtil::isEmptyString($this->id)) {
            throw new \Exception ("No id for cloning");
        }
        $this->getCategoryBlog();
        $this->categoryBlog->status = 'active';
        $this->getCategoryBlogLanguages();
        $this->getSeoLangInfos();
        return "success";
    }

    public function copy()
    {
        $this->validate();
        if ($this->hasErrors()) {
            return "success";
        }
        // Save to the database.
        $this->categoryBlog->crDate = date('Y-m-d H:i:s');
        $this->categoryBlog->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->categoryBlog->mdDate = date('Y-m-d H:i:s');
        $this->categoryBlog->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->categoryBlogSv->createCategoryBlog($this->categoryBlog, $this->categoryBlogLanguages, $this->seoInfoLanguages);
        $this->addActionMessage("The categoryBlog cloned successfully");
        $this->addExtraData("categoryBlogId", $this->categoryBlog->id);
        return "success";
    }

    public function delView()
    {
        if (AppUtil::isEmptyString($this->id)) {
            $this->addActionMessage(Lang::get("Please choice a Category to delete."));
        }
        // Load categoryBlog.
        $this->getCategoryBlog();
        return "success";
    }

    public function del()
    {
        if (AppUtil::isEmptyString($this->id)) {
            $this->addActionMessage(Lang::get("Please choice a Category to delete."));
        }
        // DeletecategoryBlog.
        $filter = new CategoryBlogVo ();
        $filter->id = $this->id;
        $this->categoryBlogSv->deleteCategoryBlog($filter);
        $this->addActionMessage("The category Blog deleted successfully");
        return "success";
    }

    protected function validate($isAdding = true)
    {
        if (AppUtil::isEmptyString($this->categoryBlog->name)) {
            $this->addFieldError("categoryBlog[name]", "Name is required");
        }
    }

    protected function getCategories()
    {
        $filter = $this->buildFilter();
        // Get total records of categoriesBlog.

        $count = $this->categoryBlogSv->countCategoryBlogByFilter($filter);
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $filter->start_record = $paging->startRecord - 1;
        $filter->end_record = $paging->pageSize;
        // Get categoriesBlog.
        $categoryBlogVos = $this->categoryBlogSv->getCategoryBlogByFilter($filter);
        foreach ($categoryBlogVos as $categoryBlogVo) {
            $categoryBlogVo->status = AppUtil::arrayValue(ApplicationConfig::get("common.status.list"), $categoryBlogVo->status);
            $categoryBlogVo->featured = AppUtil::arrayValue(ApplicationConfig::get("categoryBlog.featured.list"), $categoryBlogVo->featured);
        }
        $paging->records = $categoryBlogVos;
        $this->categoriesBlog = $paging;
    }

    protected function getCategoryBlogLanguages()
    {
        $filter = new CategoryBlogLangExtendVo ();
        if (AppUtil::isEmptyString($this->id)) {
            $this->id = -1;
        }
        $filter->categoryBlogId = $this->id;
        $categoryBlogLangVos = $this->categoryBlogSv->getLangsByCategoryBlogId($filter);
        $result = new BaseArray (CategoryBlogLangExtendVo::class);
        foreach ($categoryBlogLangVos as $categoryBlogLangVo) {
            $categoryBlogLangVo->languageCode = $categoryBlogLangVo->code;
            $result->add($categoryBlogLangVo);
        }
        $this->categoryBlogLanguages = $result;
    }

    protected function buildFilter()
    {
        return $this->buildBaseFilter("id asc");
    }

    protected function getCategoryBlog()
    {
        $filter = new CategoryBlogVo ();
        $filter->id = $this->id;
        $this->categoryBlog = $this->categoryBlogSv->getCategoryBlogByKey($filter);
    }

    protected function getSeoLangInfos()
    {
        $filter = new SeoInfoLangExtendVo ();
        $filter->itemId = $this->id;
        $filter->type = 'category_blog';
        $seoInfoLangVos = $this->categoryBlogSv->getSeoInfosByCategoryBlogId($filter);
        $result = new BaseArray (SeoInfoLangExtendVo::class);
        foreach ($seoInfoLangVos as $seoInfoLangVo) {
            $seoInfoLangVo->itemId = $this->id;
            $seoInfoLangVo->languageCode = $seoInfoLangVo->code;
            $seoInfoLangVo->type = 'category_blog';
            $result->add($seoInfoLangVo);
        }
        $this->seoInfoLanguages = $result;
    }
}
