<?php
namespace common\services\layout;

use common\persistence\base\dao\ContainerBaseDao;
use common\persistence\base\dao\GridBaseDao;
use common\persistence\base\dao\GridWidgetBaseDao;
use common\persistence\base\dao\PageBaseDao;
use common\persistence\base\dao\PageLangBaseDao;
use common\persistence\base\dao\WidgetBaseDao;
use common\persistence\base\dao\WidgetCatBaseDao;
use common\persistence\base\dao\WidgetContentBaseDao;
use common\persistence\base\dao\WidgetContentLangBaseDao;
use common\persistence\base\vo\PageVo;

class LayoutService{
	private $pageBaseDao;
	private $pageLangBaseDao;
	private $containerBaseDao;
	private $gridBaseDao;
	private $gridWidgetBaseDao;
	private $widgetBaseDao;
	private $widgetContentBaseDao;
	private $widgetContentLangBaseDao;
	private $widgetCatBaseDao;
	
	public function __construct() {
		$this->pageBaseDao = new PageBaseDao();
		$this->pageLangBaseDao = new PageLangBaseDao();
		$this->containerBaseDao = new ContainerBaseDao();
		$this->gridBaseDao = new GridBaseDao();
		$this->gridWidgetBaseDao = new GridWidgetBaseDao();
		$this->widgetBaseDao = new WidgetBaseDao();
		$this->widgetContentBaseDao = new WidgetContentBaseDao();
		$this->widgetContentLangBaseDao = new WidgetContentLangBaseDao();
		$this->widgetCatBaseDao = new WidgetCatBaseDao();
	}
	
	public function getContainerOfPage($pageId) {
		return $this->pageBaseDao->selectByKey ($pageVo);
	}
	
	public function selectAll(PageVo $pageVo = null) {
		return $this->pageBaseDao->selectAll ($pageVo);
	}
	
	public function selectByFilter(PageVo $pageVo = null) {
		return $this->pageBaseDao->selectByFilter ($pageVo);
	}
	
	public function countByFilter(PageVo $pageVo = null) {
		return $this->pageBaseDao->countByFilter ($pageVo);
	}
	
	public function insertDynamic(PageVo $pageVo = null) {
		return $this->pageBaseDao->insertDynamic ($pageVo);
	}
	
	public function updateDynamicByKey(PageVo $pageVo = null) {
		return $this->pageBaseDao->updateDynamicByKey ($pageVo);
	}
	
	public function deleteByKey(PageVo $pageVo = null) {
		return $this->pageBaseDao->deleteByKey ($pageVo);
	}
}