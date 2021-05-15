<?php
namespace common\helper;
use common\persistence\base\dao\GridBaseDao;
use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\GridVo;
use common\persistence\base\vo\PageVo;
use common\persistence\extend\dao\ContainerExtendDao;
use common\persistence\extend\dao\GridExtendDao;
use common\persistence\extend\dao\PageExtendDao;
use common\persistence\extend\vo\WidgetContentLangExtendVo;
use common\services\layout\WidgetContentService;
use common\utils\ArrayUtil;
use core\utils\AppUtil;
use common\services\layout\PageService;
use core\config\ApplicationConfig;
use common\utils\RenderUtil;
use core\config\ModuleConfig;
use core\utils\RouteUtil;
use common\persistence\base\vo\PageCacheVo;

class LayoutHelper{
	public static function getWidgetListOfPage($pageId, $softById = false){
		if (AppUtil::isEmptyString($pageId)){
			return null;
		}

		$pageExtendDao = new PageExtendDao();
		$pageVo = new PageVo();
		$pageVo->id = $pageId;
		$gridList = $pageExtendDao->getWidgetListOfPage($pageVo);

		return ($softById) ? ArrayUtil::sortById($gridList) : $gridList;
	}

	public static function getWidgetContentListOfGrid($gridId, $softById = false){
		if (AppUtil::isEmptyString($gridId)){
			return null;
		}
		$gridExtendDao = new GridExtendDao();
		$gridVo = new GridVo();
		$gridVo->id = $gridId;
		$widgetContentList = $gridExtendDao->getWidgetContentListOfGrid($gridVo);
		return ($softById) ? ArrayUtil::sortById($widgetContentList) : $widgetContentList;
	}

	/***************************************
	 * LAYOUT FUNCTION GROUP
	 ***************************************/
	public static function getLayoutDataByContainerId($containerId, $getWidgetContentLanguages = false){
		//get $gridList
		$gridList = array();
		$gridList[$containerId] = self::getGridListOfContainer($containerId, true, $getWidgetContentLanguages);

		//return
		return array(
			'gridList' => $gridList,
		);
	}

	/***************************************
	 * GRID FUNCTION GROUP
	 ***************************************/
    /**
     * get all child's of
     *
     * @param int $gridId
     * @param array $gridChildList
     * @return return by rel $gridChildList
     * @internal param rel $array $gridChildList default empty (include return data)
     */
	public static function getGridChildList($gridId, &$gridChildList=array()){
		if (AppUtil::isEmptyString($gridId)){
			return null;
		}

		//get $gridList
		$gridBasaDao = new GridBaseDao();
		$gridList = $gridBasaDao->selectAll();

		foreach ($gridList as $gridInfo){
			if($gridInfo->parentId == $gridId){
				$gridChildList[] = $gridInfo;
				self::getGridChildList($gridInfo->id, $gridChildList);
			}
		}
	}

	public static function getGridRoot($gridId){
		if (AppUtil::isEmptyString($gridId)){
			return null;
		}

		//get $gridInfo
		$gridBasaDao = new GridBaseDao();
		$gridVo = new GridVo();
		$gridVo->id = $gridId;
		$gridInfo = $gridBasaDao->selectByKey($gridVo);

		if(!$gridInfo->parentId){	//root
			return $gridInfo;
		}
		else{
			return self::getGridRoot($gridInfo->parentId);
		}
	}

	public static function getGridParentList($gridId, &$gridParentList=array()){
		if (AppUtil::isEmptyString($gridId)){
			return null;
		}

		//get $gridInfo
		$gridBasaDao = new GridBaseDao();
		$gridVo = new GridVo();
		$gridVo->id = $gridId;
		$gridInfo = $gridBasaDao->selectByKey($gridVo);

		if(!$gridInfo->parentId){	//root
			$gridParentList[] = $gridInfo;
			return $gridParentList;
		}
		else{
			$gridParentList[] = $gridInfo;
			return self::getGridParentList($gridInfo->parentId, $gridParentList);
		}
	}

	/**
	 * getGridStatusParent
	 * return active if all status of grid parents list is active alse return deactive
	 *
	 * @param int $gridId
	 * @return string
	 */
	public static function getGridStatusParent($gridId){
		if (AppUtil::isEmptyString($gridId)){
			return null;
		}

		$gridParentList = self::getGridParentList($gridId);

		$status = 'active';
		foreach ($gridParentList as $v){
			if($v->status == 'deactive' & $v->id != $gridId){
				return $v->status;
			}
		}

		return $status;
	}

	public static function getGridListOfPage($pageId, $softById = false){
		if (AppUtil::isEmptyString($pageId)){
			return null;
		}

		$pageExtendDao = new PageExtendDao();
		$pageVo = new PageVo();
		$pageVo->id = $pageId;
		$gridList = $pageExtendDao->getGridListOfPage($pageVo);

		return ($softById) ? ArrayUtil::sortById($gridList) : $gridList;
	}

	/*
	 * *** main
	 */
	public static function getGridListOfContainer($containerId, $isRecursive = false, $getWidgetContentLanguages = false){
		if (AppUtil::isEmptyString($containerId)){
			return null;
		}

		$containerExtendDao = new ContainerExtendDao();
		$containerVo = new ContainerVo();
		$containerVo->id = $containerId;
		$gridList = $containerExtendDao->getGridListOfContainer($containerVo);

		if($isRecursive){
			//convert list object to list array
			$gridList = ArrayUtil::objectToArray($gridList);

			//add info
			foreach($gridList as $k => $v){
				//set widgetContentList
				$widgetContentList = ArrayUtil::objectToArray(LayoutHelper::getWidgetContentListOfGrid($v['id']));
				//add widgetContentLanguages
				if($getWidgetContentLanguages){
					foreach ($widgetContentList as $widgetContentKey => $widgetContentInfo){
						$widgetContentId = $widgetContentInfo['id'];
						$widgetContentLanguages = self::getWidgetContentLanguages($widgetContentId);
						$widgetContentList[$widgetContentKey]['widgetContentLanguages'] = $widgetContentLanguages;
					}
				}
				$gridList[$k]['widgetContentList'] = $widgetContentList;

				//set statusParent
				$gridList[$k]['statusParent'] = self::getGridStatusParent($v['id']);

				//set haveChild
				$gridList[$k]['haveChild'] = false;
				foreach($gridList as $gridInfo){
					if($gridInfo['parentId'] == $v['id']){
						$gridList[$k]['haveChild'] = true;
 						break;
					}
				}
			}

			$ret = array();
			return ArrayUtil::recursive($gridList, 0, $ret);
		}
		else{
			return $gridList;
		}
	}

	public static function getWidgetContentLanguages($widgetContentId = -1) {
		$widgetContentService = new WidgetContentService();
		$filter = new WidgetContentLangExtendVo();
		$filter->widgetContentId = $widgetContentId;
		$widgetContentLangVos = $widgetContentService->getLangsByWidgetContentId( $filter );
		//$result = new BaseArray( WidgetContentLangExtendVo::class );
		$result = array();
		foreach ( $widgetContentLangVos as $widgetContentLangVo ) {
			$widgetContentLangVo->widgetContentId = $widgetContentId;
			$widgetContentLangVo->languageCode = $widgetContentLangVo->code;
			$widgetContentLangVo->setting = json_decode($widgetContentLangVo->setting, true);
			//$result->add ( $widgetContentLangVo );
			$result[$widgetContentLangVo->code] = $widgetContentLangVo;
		}
		return $result;
	}

	public static function getPageContent($pageId, $languageCode){
		$systemPageCacheEnable = SettingHelper::getSettingValue ( "Page Cache Enable" );
		$systemPageCacheEnable = AppUtil::isEmptyString ( $systemPageCacheEnable ) ? "yes" : $systemPageCacheEnable;
		// Get page info for detect cache enable.
		$pageService = new PageService();
		$filter = new PageVo();
		$filter->id = $pageId;
		$pageVo = $pageService->selectByKey ( $filter );
		$pageCacheEnable = $pageVo->cacheEnable;
		$pageCacheEnable = "yes" === $systemPageCacheEnable && "yes" === $pageCacheEnable;
		if ($pageCacheEnable) {
			$content = "";
			$pageCacheVo = new PageCacheVo();
			$pageCacheVo->pageId = $pageId;
			$pageCacheVo->languageCode = $languageCode;
			$pageCacheVoResult = $pageService->getPageCacheByKey($pageCacheVo);
			if (is_null ( $pageCacheVoResult )) {
				$content = self::generatePageContent($pageId, $languageCode);
				$pageCacheVo->data = $content;
				$pageCacheVo->mdDate = date ( 'Y-m-d H:i:s' );
				$pageService->insertPageCache( $pageCacheVo );
			} else {
				$content = $pageCacheVoResult->data;
			}
		} else {
			$content = self::generatePageContent($pageId, $languageCode);;
		}
		return $content;
	}
	
	public static function generatePageNoCacheContent($pageId, $languageCode) {
		return self::generatePageContent($pageId, $languageCode);
	}
	private static function generatePageContent($pageId, $languageCode) {
		$pageService = new PageService();
		$containerVo = $pageService->getContainerOfPage ( $pageId);
		$gridList = LayoutHelper::getGridListOfContainer ($containerVo->id, true, true );
		$layoutPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['LAYOUT_PATH'];
		ob_start ();
		echo "<div class='layout-container ".$containerVo->class ."'>";
		if(!empty($gridList)){
			$layoutName = ApplicationConfig::get('layout.name');
			$template = $layoutPath ."/$layoutName/item.layout.php";
			$params = array(
					'container' => 'div',
					'class' => array("layout_grid"),
					'containerVo' => $containerVo,
					'languageCode' => $languageCode,
			);
			RenderUtil::renderLayout($gridList, 0, 0, 0, true, $template, $params);
		}
		echo "
		</div>
		<div class='clear'></div>
		";
		$viewContent = ob_get_contents();
		ob_end_clean ();
		//\DatoLogUtil::devInfo("url code:".$viewContent);
		return $viewContent;
	}
}