<?php

namespace frontend\controllers\blog;

use common\persistence\base\vo\BlogVo;
use common\persistence\base\vo\CategoryBlogVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\CategoryBlogExtendVo;
use common\services\blog\BlogService;
use common\services\category\CategoryBlogService;
use common\services\seo\SeoInfoLangService;
use common\utils\StringUtil;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class BlogController extends FrontendController
{
    public $blog;
    public $blogList;
    public $blogRelated;
    public $categoryParent;
    public $categoryBlog;
    public $id;
    public $name;
    public $blogFearured;
    public $seoInfoLanguages;
    protected $blogSv;
    protected $seoInfoLangService;
    protected $categoryBlogSv;

    public function __construct()
    {
        parent::__construct();
        $this->filter = new BlogVo();
        $this->blog = new BlogVo ();
        $this->blogList = new Paging();
        $this->blogFearured = new Paging();
        $this->blogSv = new BlogService();
        $this->seoInfoLangService = new SeoInfoLangService();
        $this->categoryBlogSv = new CategoryBlogService();
        $this->pageTitle = ApplicationConfig::get("site.name") . "- Blog list";
    }

    public function listView()
    {
        $this->getCategoryBlog();
        $this->getBloglist();
        $this->getBlogFearured();
        $this->getBlogRelated();
        return "success";
    }

    public function search()
    {
        $this->getCategoryBlog();
        $this->getBloglist();
        $this->getBlogFearured();
        $this->getBlogRelated();
        return "success";
    }

    public function detail()
    {
        if (AppUtil::isEmptyString($this->id)) {
            throw new \Exception ("No id to view");
        }
        // Load blog.
        $this->getBlog();
        $this->getBlogRelated();
        $this->getBlogFearured();
        return "success";
    }

    protected function getCategoryBlog()
    {
        $filter = new CategoryBlogVo();
        $filter->id = $this->id;
        $this->categoryBlog = $this->categoryBlogSv->selectByKey($filter);
    }

    protected function getMultiCategoryBlog()
    {
        $categoryParent = new CategoryBlogExtendVo();
        $categoryParent->parentId = $this->id;
        $categoryParent->order_by = "orderNo asc";
        $this->categoryParent = $this->categoryBlogSv->getByFilter($categoryParent);
        $this->buildFilter();
        foreach ($this->categoryParent as $item) {
            // Get total records of blog list.
            $count = $this->blogSv->countBlogByFilter($this->filter);
            // Create new paging object.
            $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
            $this->filter->start_record = $paging->startRecord - 1;
            $this->filter->end_record = $paging->pageSize;
            $this->filter->categoryBlogId = $item->id;
            $this->filter->order_by = "featured";
            $this->filter->limit = 6;
            // Get blog list.
            $blogVos = $this->blogSv->getBlogByFilter($this->filter);
            $item->lstBlog = $blogVos;
        }
    }

    protected function getBloglist()
    {
        $this->buildFilter();
        // Get total records of blog list.'
        $this->filter->status = 'active';
        $this->filter->categoryBlogId = $this->id;
        $count = $this->blogSv->countBlogByParentCatId($this->id, $this->filter);
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $this->filter->start_record = $paging->startRecord - 1;
        $this->filter->end_record = $paging->pageSize;
        $this->filter->order_by = "md_date desc";
        // Get blog list.
        $blogVos = $this->blogSv->getBlogByParentCatId($this->id, $this->filter);
        $paging->records = $blogVos;
        $this->blogList = $paging;
    }

    protected function getBlogFearured()
    {
        $this->pageSize = "8";
        $this->buildFilter();
        // Get total records of blog list.
        $this->filter->featured = "yes";
        $count = $this->blogSv->countBlogByParentCatId($this->id, $this->filter);
        //var_dump($count);die();
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $this->filter->start_record = $paging->startRecord - 1;
        $this->filter->end_record = $paging->pageSize;
        $this->filter->limit = 6;
        // Get blog list.
        $blogVos = $this->blogSv->getBlogByParentCatId($this->id, $this->filter);
        $paging->records = $blogVos;
        $this->blogFearured = $paging;
    }

    protected function buildFilter()
    {
        $filter = $this->buildBaseFilter("id asc");
        if (!AppUtil::isEmptyString($this->name)) {
            $filter->name = $this->name;
        }
        $this->filter = $filter;
    }

    protected function getBlogRelated()
    {
        $blogService = new BlogService();
        $this->blogRelated = $blogService->getBlogNew();
    }

    protected function getBlog()
    {
        $filter = new BlogVo();
        $filter->id = $this->id;
        $this->blog = $this->blogSv->getBlogByKey($filter);
        $categoryParent = new CategoryBlogExtendVo();
        $categoryParent->id = $this->blog->categoryBlogId;
        $this->categoryParent = $this->categoryBlogSv->getByFilter($categoryParent)[0];
        $related = new BlogVo();
        $related->categoryBlogId = $this->blog->categoryBlogId;
        $related->start_record = 0;
        $related->end_record = 3;
        $related->order_by = "cr_date desc";
        $this->blogRelated = $this->blogSv->getBlogByFilter($related);
    }
}