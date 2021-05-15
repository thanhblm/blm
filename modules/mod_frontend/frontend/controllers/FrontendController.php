<?php

namespace frontend\controllers;

use common\config\CookieEnum;
use common\helper\CookieHelper;
use common\helper\LocalizationHelper;
use common\persistence\base\vo\CategoryBlogVo;
use common\persistence\base\vo\CategoryVo;
use common\persistence\base\vo\PageVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\TemplateVo;
use common\persistence\extend\vo\CategoryBlogExtendVo;
use common\persistence\extend\vo\CategoryBlogHomeExtendVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\LanguageExtendVo;
use common\persistence\extend\vo\RegionExtendVo;
use common\services\blog\BlogHomeService;
use common\services\category\CategoryBlogService;
use common\services\category\CategoryService;
use common\services\language\LanguageService;
use common\services\layout\ContainerService;
use common\services\layout\PageService;
use common\services\layout\TemplateService;
use common\services\product\ProductHomeService;
use common\services\region\RegionService;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;

class FrontendController extends PagingController
{
    protected $languages;
    protected $languageCode;
    protected $regionId;
    protected $region;
    protected $currencyCode;
    protected $language;
    protected $regions;
    public $seoInfoVo;
    public $pageVo;
    public $templateVo;
    public $template;
    public $discount;
    public $categories;
    public $categoryBlogMenu;
    protected $blogService;
    public $categoryDichVuMenu;

    public function __construct()
    {
        parent::__construct();
        $this->regionId = LocalizationHelper::getRegionId();
        $this->languageCode = LocalizationHelper::getLangCode();
        $this->currencyCode = LocalizationHelper::getCurrencyCode();
        $this->pageVo = new PageVo ();
        $this->templateVo = new TemplateVo ();
        $this->discount = RequestUtil::get("discount");
        $this->blogService = new BlogHomeService();

        $this->loadLanguages();
        $this->determineSelectedLanguage();
        $this->loadRegions();
        $this->getRegion();
        $this->getLayout();
        $this->loadCategories();
        $this->loadCategoryDichVu();
        $this->loadCategoryBlog();
        $this->setAttribute("languages", $this->languages);
        $this->setAttribute("languageCode", $this->languageCode);
        $this->setAttribute("regionId", $this->regionId);
        $this->setAttribute("region", $this->region);
        $this->setAttribute("currencyCode", $this->currencyCode);
        $this->setAttribute("language", $this->language);
        $this->setAttribute("regions", $this->regions);
    }

    private function loadCategoryBlog()
    {
        $categoryVo = new CategoryBlogHomeExtendVo();
        $categoryVo->languageCode = $this->languageCode;
        $categoryVo->status = 'active';
        $categoryVo->parentId = 0;
        $categoryVo->order_by = 'orderNo asc';
        $listCategory = $this->blogService->getCategoryHomeByFilter($categoryVo);
        foreach ($listCategory as $category) {
            $category->listChild = array();
            $categoryChildVo = new CategoryBlogHomeExtendVo();
            $categoryChildVo->languageCode = $this->languageCode;
            $categoryChildVo->status = 'active';
            $categoryChildVo->parentId = $category->id;
            $categoryChildVo->order_by = 'orderNo asc';

            $listChildCategory = $this->blogService->getCategoryHomeByFilter($categoryChildVo);
            foreach ($listChildCategory as $childCategory) {
                $category->listChild[] = $childCategory;
            }

        }
        $this->categoryBlogMenu = $listCategory;
    }

    private function loadCategoryDichVu()
    {
        $categoryBSv = new CategoryBlogService();
        $categoryBVo = new CategoryBlogExtendVo();
        $categoryBVo->name = "Dịch Vụ";
        $categoryBVo = $categoryBSv->selectByFilter($categoryBVo)[0];
        $categoryVo = new CategoryBlogHomeExtendVo();
        $categoryVo->languageCode = $this->languageCode;
        $categoryVo->status = 'active';
        $categoryVo->parentId = $categoryBVo->id;
        $categoryVo->order_by = 'orderNo asc';
        $listCategory = $this->blogService->getCategoryHomeByFilter($categoryVo);
        $this->categoryDichVuMenu = $listCategory;
    }

    private function loadLanguages()
    {
        $languageService = new LanguageService ();
        $filter = new LanguageExtendVo();
        $filter->status = "active";
        $this->languages = $languageService->getLanguageByFilter($filter);
    }

    private function determineSelectedLanguage()
    {
        if (empty ($this->languages)) {
            return;
        }
        foreach ($this->languages as $language) {
            if ($this->languageCode == $language->code) {
                $this->language = $language;
                break;
            }
        }
    }

    protected function getLoginCustomer()
    {
        return SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
    }

    private function loadRegions()
    {
        $regionService = new RegionService ();
        $filter = new RegionExtendVo();
        $filter->status = "active";
        $this->regions = $regionService->getByFilter($filter);
    }

    private function getRegion()
    {
        $regionService = new RegionService ();
        $regionFilter = new RegionVo ();
        $regionFilter->id = LocalizationHelper::getRegionId();
        $this->region = $regionService->getById($regionFilter);
    }

    private function getLayout()
    {
        // insert code render layout header (move code to FrontendController later)
        $pageService = new PageService ();
        $templateService = new TemplateService ();
        $containerService = new ContainerService ();
        // set $template
        $layoutPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule()) ['LAYOUT_PATH'];
        $layoutName = ApplicationConfig::get('layout.name');
        $this->template = $layoutPath . "/$layoutName/item.layout.php";

        // get $action
        $action = AppUtil::current_action();
        //var_dump($action);
        if ($action == 'home/page/view') {
            // get $pageVo $pageId
            $pageId = RequestUtil::get('pageId');
            $filter = new PageVo ();
            $filter->id = $pageId;
            $this->pageVo = $pageService->selectByKey($filter);
        } else {
            // get $pageVo by $action
            $filter = new PageVo ();
            $filter->action = $action;
            $pageVos = $pageService->selectByFilter($filter);
            if ($pageVos) {
                $this->pageVo = $pageVos [0];
            }
        }
        // get $templateVo
        $filter = new TemplateVo ();
        $filter->id = ($this->pageVo->templateId) ? $this->pageVo->templateId : 1;
        $this->templateVo = $templateService->selectByKey($filter);
    }

    public function loadCategories()
    {
        $productService = new ProductHomeService();
        $categoryVo = new CategoryHomeExtendVo();
        $categoryVo->languageCode = $this->languageCode;
        $categoryVo->status = 'active';
        $categoryVo->parentId = 0;
        $categoryVo->order_by = 'orderNo asc';
        $listCategory = $productService->getCategoryHomeByFilter($categoryVo);
        foreach ($listCategory as $category) {
            $categoryChildVo = new CategoryHomeExtendVo();
            $categoryChildVo->languageCode = $this->languageCode;
            $categoryChildVo->status = 'active';
            $categoryChildVo->parentId = $category->id;
            $categoryChildVo->order_by = 'orderNo asc';

            $listChildCategory = $productService->getCategoryHomeByFilter($categoryChildVo);
            $category->listChild = ($listChildCategory);
        }

        $this->categories = $listCategory;
    }


    protected function loadDiscountCode()
    {
        $discountCode = $this->discount;
        $cookieDiscountCode = CookieHelper::getCookie(CookieEnum::DISCOUNT_CODE);
        if (!AppUtil::isEmptyString($discountCode) && $discountCode !== $cookieDiscountCode) {
            CookieHelper::setCookie(CookieEnum::DISCOUNT_CODE, $discountCode);
        }
    }
}