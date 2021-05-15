<?php
namespace common\services\layout;
use common\persistence\base\vo\WidgetCatVo;
use common\persistence\base\dao\WidgetCatBaseDao;

class WidgetCatService{
	private $widgetCatBaseDao;
	
	public function __construct() {
		$this->widgetCatBaseDao = new WidgetCatBaseDao();
	}
	
	public function selectByKey(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->selectByKey ($widgetCatVo);
	}
	
	public function selectAll(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->selectAll ($widgetCatVo);
	}
	
	public function selectByFilter(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->selectByFilter ($widgetCatVo);
	}
	
	public function countByFilter(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->countByFilter ($widgetCatVo);
	}
	
	public function insertDynamic(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->insertDynamic ($widgetCatVo);
	}
	
	public function updateDynamicByKey(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->updateDynamicByKey ($widgetCatVo);
	}
	
	public function deleteByKey(WidgetCatVo $widgetCatVo = null) {
		return $this->widgetCatBaseDao->deleteByKey ($widgetCatVo);
	}
}