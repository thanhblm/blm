<?php
namespace common\services\layout;
use common\persistence\base\vo\GridWidgetVo;
use common\persistence\base\dao\GridWidgetBaseDao;

class GridWidgetService{
	private $gridWidgetBaseDao;
	
	public function __construct() {
		$this->gridWidgetBaseDao = new GridWidgetBaseDao();
	}
	
	public function selectByKey(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->selectByKey ($gridWidgetVo);
	}
	
	public function selectAll(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->selectAll ($gridWidgetVo);
	}
	
	public function selectByFilter(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->selectByFilter ($gridWidgetVo);
	}
	
	public function countByFilter(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->countByFilter ($gridWidgetVo);
	}
	
	public function insertDynamic(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->insertDynamic ($gridWidgetVo);
	}
	
	public function updateDynamicByKey(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->updateDynamicByKey ($gridWidgetVo);
	}
	
	public function deleteByKey(GridWidgetVo $gridWidgetVo = null) {
		return $this->gridWidgetBaseDao->deleteByKey ($gridWidgetVo);
	}
}