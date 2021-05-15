<?php

namespace frontend\controllers\home;

use \common\services\layout\PageService;
use common\helper\LayoutHelper;
use common\helper\SettingHelper;
use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\PageCacheVo;
use common\persistence\base\vo\PageVo;
use common\services\layout\ContainerService;
use common\services\layout\WidgetContentService;
use core\config\ModuleConfig;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RouteUtil;
use frontend\controllers\FrontendController;
use common\helper\LocalizationHelper;

class PageController extends FrontendController {
	public $pageId;
	public $pageAction;
	public $containerId;
	public $pageVo;
	public $containerVo;
	public $containerPosition;
	public $layoutData;
	public $gridList;
	public $myLanguageCode;
	private $pageService;
	private $containerService;
	private $widgetContentService;
	public $layoutPath;
	public $languageCode;

	public function __construct() {
// 		parent::__construct ();
		$this->pageVo = new PageVo ();
		$this->containerVo = new ContainerVo ();
		$this->pageService = new PageService ();
		$this->containerService = new ContainerService ();

		$this->widgetContentService = new WidgetContentService ();
		$this->layoutPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['LAYOUT_PATH'];
		$this->languageCode = LocalizationHelper::getLangCode ();
		$this->setAttribute ( "languageCode", $this->languageCode );
	}

	protected function getContainerVo() {
		$this->containerVo = $this->pageService->getContainerOfPage ( $this->pageId );
	}

	public function index() {
		$systemPageCacheEnable = SettingHelper::getSettingValue ( "Page Cache Enable" );
		$systemPageCacheEnable = AppUtil::isEmptyString ( $systemPageCacheEnable ) ? "yes" : $systemPageCacheEnable;
		// Get page info for detect cache enable.
		$pageVo = $this->getPageInfo($this->pageId);
		$pageCacheEnable = $pageVo->cacheEnable;
		$pageCacheEnable = "yes" === $systemPageCacheEnable && "yes" === $pageCacheEnable;
		if ($pageCacheEnable) {
			$content = "";
			$pageCacheVo = new PageCacheVo ();
			$pageCacheVo->pageId = $this->pageId;
			$pageCacheVo->languageCode = $this->languageCode;
			$pageCacheVoResult = $this->pageService->getPageCacheByKey($pageCacheVo);
			if (is_null ( $pageCacheVoResult )) {
				$content = LayoutHelper::getPageContent($this->pageId, $this->languageCode);
				$pageCacheVo->data = $content;
				$pageCacheVo->mdDate = date ( 'Y-m-d H:i:s' );
				$this->pageService->insertPageCache( $pageCacheVo );
			} else {
				$content = $pageCacheVoResult->data;
			}
		} else {
			$content = LayoutHelper::getPageContent($this->pageId, $this->languageCode);
		}
		echo $content;
	}

	// 	@Deplicated: please use LayoutHelper::getPageContent
	public function prepareContent() {
		// check data
		if (! AppUtil::isEmptyString ( $this->myLanguageCode )) {
			$this->languageCode = $this->myLanguageCode;
		}
		$this->setAttribute ( "languageCode", $this->languageCode );
		if (! $this->pageId) {
			\DatoLogUtil::error ( "Not found id param" );
			return "error";
		}
		// get $pageInfo
		$this->pageVo = $this->getPageInfo($this->pageId);
		// check page exist
		if (is_null( $this->pageVo)) {
			\DatoLogUtil::error ( "Not found pageInfo from id = $this->pageId" );
			return "error";
		}
		$this->getContainerVo ();
		$this->gridList = LayoutHelper::getGridListOfContainer ( $this->containerVo->id, true, true );
		return "success";
	}

	private function getPageInfo($pageId){
		$filter = new PageVo ();
		$filter->id = $pageId;
		return $this->pageService->selectByKey ( $filter );
	}
}