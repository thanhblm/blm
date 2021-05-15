<?php

namespace frontend\controllers\home;

use common\persistence\base\vo\BlogVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\base\vo\SlideVo;
use common\persistence\extend\vo\BlogHomeExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\persistence\extend\vo\SlideExtendVo;
use common\services\blog\BlogHomeService;
use common\services\blog\BlogService;
use common\services\category\CategoryService;
use common\services\product\ProductHomeService;
use common\services\slide\SlideService;
use core\common\Paging;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;
use mysql_xdevapi\Exception;

/**
 *
 * @author TANDT
 *
 */
class HomeController extends FrontendController
{
    public $productFeatureds;
    public $productsNew;
    protected $productService;
    public $categories;
    private $categoryService;
    public $slides;
    public $slideImage;
    public $slideDoiDac;
    public $slideTaiXe;
    public $slideSummerCollection;
    public $slideQuyTrinh;
    protected $blogSv;
    public $blogFearured;
    public $id;
    public $name;
    public $gioiThieuVo;


    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductHomeService ();
        $this->categoryService = new CategoryService();
        $this->blogSv = new BlogService();
        $this->filter = new BlogVo();
        $this->blogFearured = new Paging();
        $this->gioiThieuVo = new BlogVo ();
    }

    public function index()
    {
        $this->loadProductsF();
        $this->loadCategories();
        $this->loadSlides();
        $this->loadDoiTac();
        $this->loadTaiXe();
        $this->loadImages();
        $this->loadBlogFutured();
        $this->getBlog();
        return "success";
    }

    public function price()
    {
        return "success";
    }

    protected function getBlog()
    {
        try {
            $blogService = new BlogHomeService();
            $filter = new BlogHomeExtendVo();
            $filter->tag = 'gioi thieu';
            $filter->languageCode = $this->languageCode;
            $filter->regionId = $this->regionId;
            $blogVos = $blogService->getBlogHomeByFilter($filter);
            $this->gioiThieuVo = $blogVos[0];
        } catch (Exception $exception) {
            \DatoLogUtil::error($exception->getMessage(), $exception);
        }

    }

    protected function loadBlogFutured()
    {
        $this->pageSize = "5";
        $this->buildBlogFilter();
        // Get total records of blog list.
        $this->filter->featured = "yes";
        $this->filter->status = "active";
        $count = $this->blogSv->countBlogByParentCatId($this->id, $this->filter);
        //var_dump($count);die();
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $this->filter->start_record = $paging->startRecord - 1;
        $this->filter->end_record = $paging->pageSize;
        $this->filter->order_by = 'cr_date desc';
        // Get blog list.
        $blogVos = $this->blogSv->getBlogByParentCatId($this->id, $this->filter);
        $paging->records = $blogVos;
        $this->blogFearured = $paging;
    }

    protected function loadSummerCollections()
    {
        $filterVo = new SlideVo();
        $filterVo->slideGroupId = 4;
        $filterVo->status = "active";
        $slideSv = new SlideService();
        $this->slideSummerCollection = $slideSv->selectByFilter($filterVo);
    }

    protected function loadQuyTrinh()
    {
        $filterVo = new SlideVo();
        $filterVo->slideGroupId = 5;
        $filterVo->status = "active";
        $slideSv = new SlideService();
        $this->slideQuyTrinh = $slideSv->selectByFilter($filterVo);
    }

    protected function loadDoiTac()
    {
        $filterVo = new SlideExtendVo();
        $filterVo->slideGroupCode = 'DOI_TAC';
        $filterVo->status = "active";
        $slideSv = new SlideService();
        $this->slideDoiDac = $slideSv->getSlideByGroupCode($filterVo);
    }

    protected function loadTaiXe()
    {
        $filterVo = new SlideExtendVo();
        $filterVo->slideGroupCode = 'TAI_XE';
        $filterVo->status = "active";
        $slideSv = new SlideService();
        $this->slideTaiXe = $slideSv->getSlideByGroupCode($filterVo);
    }

    protected function loadImages()
    {
        $filterVo = new SlideExtendVo();
        $filterVo->slideGroupId = 2;
        $filterVo->status = "active";
        $slideSv = new SlideService();
        $this->slideImage = $slideSv->selectByFilter($filterVo);
    }

    private function loadSlides()
    {
        $filterVo = new SlideExtendVo();
        $filterVo->slideGroupCode = 'HOME';
        $filterVo->status = "active";
        $slideSv = new SlideService();
        $this->slides = $slideSv->getSlideByGroupCode($filterVo);
    }

    private function loadProductsNew()
    {
        $categoryVo = new CategoryHomeExtendVo();
        $categoryVo->languageCode = $this->languageCode;
        $categoryVo->status = 'active';
        $categoryVo->order_by = 'orderNo asc';
        $categories = $this->productService->getCategoryHomeByFilter($categoryVo);

        $productHomeVo = new ProductHomeExtendVo ();
        $productHomeVo->regionId = $this->regionId;
        $productHomeVo->languageCode = $this->languageCode;
        $productHomeVo->currencyCode = $this->currencyCode;
        $productHomeVo->status = "active";
        $productHomeVo->categoryId = $categories[0]->id;
        $productHomeVo->start_record = 0;
        $productHomeVo->end_record = 10;
        $productHomeVo->order_by = "cr_date desc";
        $this->productsNew = $this->productService->getProductHomeByFilter($productHomeVo);

    }

    private function loadProductsF()
    {
        $categoryVo = new CategoryHomeExtendVo();
        $categoryVo->languageCode = $this->languageCode;
        $categoryVo->status = 'active';
        $categoryVo->order_by = 'orderNo asc';
        $categories = $this->productService->getCategoryHomeByFilter($categoryVo);

        $productHomeVo = new ProductHomeExtendVo ();
        $productHomeVo->regionId = $this->regionId;
        $productHomeVo->languageCode = $this->languageCode;
        $productHomeVo->currencyCode = $this->currencyCode;
        $productHomeVo->status = "active";
        $productHomeVo->featured = "yes";
        $productHomeVo->categoryId = $categories[0]->id;
        $productHomeVo->start_record = 0;
        $productHomeVo->end_record = 10;
        $this->productFeatureds = $this->productService->getProductHomeByFilter($productHomeVo);

    }

    protected function buildBlogFilter()
    {
        $filter = $this->buildBaseFilter("id asc");
        if (!AppUtil::isEmptyString($this->name)) {
            $filter->name = $this->name;
        }
        $this->filter = $filter;
    }
}