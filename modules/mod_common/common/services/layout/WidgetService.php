<?php
namespace common\services\layout;
use common\persistence\base\vo\WidgetVo;
use common\persistence\base\dao\WidgetBaseDao;

class WidgetService{
	private $widgetBaseDao;
	
	public function __construct() {
		$this->widgetBaseDao = new WidgetBaseDao();
	}
	
	public function selectByKey(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->selectByKey ($widgetVo);
	}
	
	public function selectAll(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->selectAll ($widgetVo);
	}
	
	public function selectByFilter(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->selectByFilter ($widgetVo);
	}
	
	public function countByFilter(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->countByFilter ($widgetVo);
	}
	
	public function insertDynamic(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->insertDynamic ($widgetVo);
	}
	
	public function updateDynamicByKey(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->updateDynamicByKey ($widgetVo);
	}
	
	public function deleteByKey(WidgetVo $widgetVo = null) {
		return $this->widgetBaseDao->deleteByKey ($widgetVo);
	}
}