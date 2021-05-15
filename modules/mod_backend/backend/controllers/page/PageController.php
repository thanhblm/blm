<?php

namespace backend\controllers\page;

use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\PageCacheVo;
use common\persistence\base\vo\PageVo;
use common\persistence\base\vo\TemplateVo;
use common\persistence\extend\vo\PageExtendVo;
use common\persistence\extend\vo\PageLangExtendVo;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use common\persistence\extend\vo\WidgetContentLangExtendVo;
use common\services\layout\PageService;
use common\services\layout\TemplateService;
use common\services\seo\SeoInfoLangService;
use common\utils\FileUtil;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\Lang;
use core\PagingController;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RouteUtil;

class PageController extends PagingController
{
    public $pageId;
    public $pageList;
    public $pageVo;
    public $pageService;
    public $pageLanguages;
    public $seoInfoLanguages;
    public $seoInfoLangService;
    public $containerId;
    public $containerVo;
    public $viewPath;
    public $cacheEnable;

    public $templateService;
    public $templateList;

    public function __construct()
    {
        parent::__construct();
        $this->pageVo = new PageVo ();
        $this->pageList = new Paging ();
        $this->pageService = new PageService ();
        $this->pageTitle = ApplicationConfig::get("site.name") . " - Page Management";
        $this->pageLanguages = new BaseArray (PageLangExtendVo::class);
        $this->seoInfoLanguages = new BaseArray (SeoInfoLangExtendVo::class);
        $this->seoInfoLangService = new SeoInfoLangService ();
        $this->filter = new PageExtendVo ();
        $this->containerVo = new ContainerVo ();
        $this->widgetContentLanguages = new BaseArray (WidgetContentLangExtendVo::class);
        $this->viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule()) ['VIEW_PATH'];

        $this->templateService = new TemplateService();
    }

    /**
     * ****************************************************************
     * PAGE ACTION
     * ****************************************************************
     */
    public function listView()
    {
    	$this->pageService->deletePageTemp();
        $this->getPageList();
        return "success";
    }
    public function search()
    {
        $this->getPageList();
        return "success";
    }

    public function addView()
    {
        if (!$this->pageId) {
            $this->pageId = $this->pageService->addPageTemp();
        }
        $this->getPageVo();
        $this->getPageLanguages();
        $this->getSeoLangInfos();
        $this->getContainerVo();
        $this->getTemplateList();
        return "success";
    }
    public function add()
    {
        $this->validate(true);
        if ($this->hasErrors()) {
            return "success";
        }
        // Set some initial values.
        $this->pageVo->crDate = date('Y-m-d H:i:s');
        $this->pageVo->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->pageVo->mdDate = date('Y-m-d H:i:s');
        $this->pageVo->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        // set isTemp
        $this->pageVo->isTemp = 0;
        // Save to the database.
        $this->pageService->updatePage($this->pageVo, $this->pageLanguages, $this->seoInfoLanguages);
        $this->addActionMessage("The page updated successfully");
        $this->addExtraData("pageId", $this->pageId);

        return "success";
    }

    public function editView()
    {
        // check pageId
        if (AppUtil::isEmptyString($this->pageId)) {
            \DatoLogUtil::error("No pageId for editing");
            return 'error';
        }
        $this->getPageVo();
        if (!$this->pageVo) {
            \DatoLogUtil::error("No found page with pageId = {$this->pageId}");
            return 'error';
        }

        $this->getPageLanguages();
        $this->getSeoLangInfos();
        $this->getContainerVo();
        $this->getTemplateList();
        return "success";
    }
    public function edit()
    {
        $this->validate(false);
        if ($this->hasErrors()) {
            return "success";
        }
        // Save to the database.
        $this->pageVo->mdDate = date('Y-m-d H:i:s');
        $this->pageVo->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->pageVo->isTemp = 0;
        $this->pageService->updatePage($this->pageVo, $this->pageLanguages, $this->seoInfoLanguages);
        $this->addActionMessage("The page updated successfully");
        return "success";
    }

    public function copy()
    {
        // check pageId
        if (AppUtil::isEmptyString($this->pageId)) {
            \DatoLogUtil::error("No pageId for editing");
            return 'error';
        }
        $this->getPageVo();
        if (!$this->pageVo) {
            \DatoLogUtil::error("No found page with pageId = {$this->pageId}");
            return 'error';
        }

        // copy page
        $pageIdCopy = $this->pageService->copyPage($this->pageVo);
        $urlRedirect = ActionUtil::getFullPathAlias("admin/page/edit/view?pageId=$pageIdCopy");
        header("location: $urlRedirect");
        return "success";
    }

    public function delView()
    {
        if (AppUtil::isEmptyString($this->pageId)) {
            throw new \Exception ("No id for deleting");
        }
        $this->getPageVo();
        return "success";
    }
    public function del()
    {
        if (AppUtil::isEmptyString($this->pageId)) {
            throw new \Exception ("No id for deleting");
        }
        $filter = new PageVo ();
        $filter->id = $this->pageId;
        $this->pageVo = $this->pageService->selectByKey($filter);

        $validate = true;
        if ($this->pageVo->isSystem) {
            $validate = false;
            $this->addFieldError('errorMessage', Lang::get('You not delete system page'));
        }

        if($validate) {
            $this->pageService->deletePage($this->pageVo);
        }
        return "success";
    }

    protected function validate($isAdd = true)
    {
        $errorMessage = array();
        // check required
        if (AppUtil::isEmptyString($this->pageVo->name)) {
            $errorMessage ["pageVo[name]"] = "Name is required";
        }
        else{
	        // check exist
	        if ($isAdd) {
	            $pageVo = new PageVo ();
	            $pageVo->isTemp = 0;
	            $pageVos = $this->pageService->selectByFilter($pageVo);
	            foreach ($pageVos as $pageInfo) {
	            	if ($pageInfo->name !== '' & $pageInfo->name == $this->pageVo->name) {
	            		$errorMessage ["pageVo[name]"] = "Name is exist";
	            		break;
	            	}
	            }
	        } else { // edit case
	            $filter = new PageVo ();
	            $filter->id = $this->pageVo->id;
	            $pageOld = $this->pageService->selectByKey($filter);
	
	            $filter = new PageVo ();
	            $filter->name = $this->pageVo->name;
	            $filter->isTemp = 0;
	            $pageList = $this->pageService->selectByFilter($filter);
	            if (count($pageList) > 0 & $pageOld->name != $this->pageVo->name) {
	                $errorMessage ["pageVo[name]"] = "Name is exist";
	            }
	        }
        }

        if (!empty ($errorMessage)) {
            $this->addFieldError('errorMessage', json_encode($errorMessage));
        }
    }

    protected function getPageList()
    {
        $filter = $this->buildFilter();
        // check isTemp
        $filter->isTemp = 0;
        // Get total records of pageList.
        $count = $this->pageService->getCountByFilter($filter);
        // Create new paging object.
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $filter->start_record = $paging->startRecord - 1;
        $filter->end_record = $paging->pageSize;
        // Get pageList.
        $pageVos = $this->pageService->getPageByFilter($filter);
        $paging->records = $pageVos;
        $this->pageList = $paging;
    }

    protected function getPageVo()
    {
        $pageVo = new PageVo ();
        $pageVo->id = $this->pageId;
        $this->pageVo = $this->pageService->selectByKey($pageVo);
    }

    protected function getContainerVo()
    {
        $this->containerVo = $this->pageService->getContainerOfPage($this->pageId);
    }

    protected function getPageLanguages()
    {
        $filter = new PageLangExtendVo ();
        if (AppUtil::isEmptyString($this->pageId)) {
            $this->pageId = -1;
        }
        $filter->pageId = $this->pageId;
        $pageLangVos = $this->pageService->getLangsByPageId($filter);
        $result = new BaseArray (PageLangExtendVo::class);
        foreach ($pageLangVos as $pageLangVo) {
            $pageLangVo->pageId = $this->pageId;
            $result->add($pageLangVo);
        }
        $this->pageLanguages = $result;
    }

    protected function getSeoLangInfos()
    {
        $filter = new SeoInfoLangExtendVo ();
        $filter->itemId = $this->pageId;
        $filter->type = 'page';
        $seoInfoLangVos = $this->pageService->getSeoInfosByPageId($filter);
        $result = new BaseArray (SeoInfoLangExtendVo::class);
        foreach ($seoInfoLangVos as $seoInfoLangVo) {
            $seoInfoLangVo->itemId = $this->pageId;
            $seoInfoLangVo->type = 'page';
            $result->add($seoInfoLangVo);
        }
        $this->seoInfoLanguages = $result;
    }

    protected function buildFilter()
    {
        return $this->buildBaseFilter("id asc");
    }

    protected function getTemplateList(){
        $filter = new TemplateVo();
        $filter->isTemp = 0;
        $this->templateList = $this->templateService->getTemplateByFilter($filter);
    }

    /**
     * ****************************************************************
     * PAGE CACHE ACTION
     * ****************************************************************
     */

    public function recachePageView()
    {
        if (AppUtil::isEmptyString($this->pageId)) {
            throw new \Exception ("No id for recachePageView");
        }
        $this->getPageVo();
        return "success";
    }
    public function recachePage()
    {
        if (AppUtil::isEmptyString($this->pageId)) {
            throw new \Exception ("No id for recachePage");
        }
        $this->pageService->recachePage($this->pageId);
        return "success";
    }

    public function recachePageAllView()
    {
        return "success";
    }
    public function recachePageAll()
    {
        $this->pageService->recachePageAll();
        return "success";
    }

    public function pageCacheEnableView()
    {
        if (AppUtil::isEmptyString($this->pageId)) {
            throw new \Exception ("No id for pageCacheEnableView");
        }
        $this->getPageVo();
        return "success";
    }
    public function pageCacheEnable()
    {
        if (AppUtil::isEmptyString($this->pageId)) {
            throw new \Exception ("No id for pageCacheEnable");
        }
        $this->getPageVo();

        $filter = new PageVo();
        $filter->id = $this->pageId;
        if($this->pageVo->cacheEnable == 'yes'){
            $filter->cacheEnable = 'no';
        }
        else{
            $filter->cacheEnable = 'yes';
        }
        $this->pageService->updateDynamicByKey($filter);
        return "success";
    }
}