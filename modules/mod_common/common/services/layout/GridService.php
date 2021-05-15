<?php
namespace common\services\layout;
use common\persistence\base\vo\GridVo;
use common\persistence\base\dao\GridBaseDao;
use core\database\SqlMapClient;
use common\persistence\base\dao\GridWidgetBaseDao;
use common\persistence\base\vo\GridWidgetVo;
use common\persistence\extend\dao\GridWidgetExtendDao;
use common\helper\LayoutHelper;
use common\services\base\BaseService;

class GridService extends BaseService{
	private $gridBaseDao;
	
	public function __construct() {
		$this->gridBaseDao = new GridBaseDao();
	}
	
	public function selectByKey(GridVo $gridVo = null) {
		return $this->gridBaseDao->selectByKey ($gridVo);
	}
	
	public function selectAll(GridVo $gridVo = null) {
		return $this->gridBaseDao->selectAll ($gridVo);
	}
	
	public function selectByFilter(GridVo $gridVo = null) {
		return $this->gridBaseDao->selectByFilter ($gridVo);
	}
	
	public function countByFilter(GridVo $gridVo = null) {
		return $this->gridBaseDao->countByFilter ($gridVo);
	}
	
	public function insertDynamic(GridVo $gridVo = null) {
		return $this->gridBaseDao->insertDynamic ($gridVo);
	}
	
	public function updateDynamicByKey(GridVo $gridVo = null) {
		return $this->gridBaseDao->updateDynamicByKey ($gridVo);
	}
	
	public function deleteByKey(GridVo $gridVo = null) {
		return $this->gridBaseDao->deleteByKey ($gridVo);
	}
	
	/**
	 * ***************************
	 * ADVANCE
	 * ***************************
	 */
	public function gridDelete($gridVo){
		$sqlClient = new SqlMapClient ( $this->context );
		$gridDao = new GridBaseDao($this->context, $sqlClient);
		$gridWidgetExtendDao = new GridWidgetExtendDao($this->context, $sqlClient);
		$sqlClient->startTransaction ();
		try {
			// 1 get gridChildList
			$gridChildList = array ();
			LayoutHelper::getGridChildList ($gridVo->id, $gridChildList );
			// 2 delete grid_widget (link) of gridChildList
			foreach ( $gridChildList as $gridInfo ) {
				$filter = new GridWidgetVo ();
				$filter->gridId = $gridInfo->id;
				$gridWidgetExtendDao->deleteByFilter ( $filter );
			}
			// 3 delete gridChildList
			foreach ( $gridChildList as $gridInfo ) {
				$gridDao->deleteByKey ( $gridInfo );
			}
			// 4 delete grid_widget (link) of grid
			$filter = new GridWidgetVo ();
			$filter->gridId =$gridVo->id;
			$gridWidgetExtendDao->deleteByFilter ( $filter );
			// 5 delete grid
			$gridDao->deleteByKey ($gridVo );
	
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	
	public function gridSortable($gridList){
		$sqlClient = new SqlMapClient ( $this->context );
		$gridDao = new GridBaseDao($this->context, $sqlClient);
		$sqlClient->startTransaction ();
		try {
			if (! empty ( $gridList )) {
				foreach ( $gridList as $gridData ) {
					$filter = new GridVo ();
					$filter->id = $gridData ['gridId'];
					$filter->parentId = $gridData ['parentId'];
					$filter->order = $gridData ['order'];
					$gridDao->updateDynamicByKey ( $filter );
				}
			}
	
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	
	public function gridWidgetSortable($gridIdTarget, $gridWidgetListTarget){
		$sqlClient = new SqlMapClient( $this->context );
		$gridWidgetDao = new GridWidgetBaseDao($this->context, $sqlClient);
		$sqlClient->startTransaction ();
		try {
			foreach ( $gridWidgetListTarget as $gridWidget ) {
				$filter = new GridWidgetVo();
				$filter->id = $gridWidget ['gridWidgetId'];
				$filter->gridId = $gridIdTarget;
				$filter->order = $gridWidget ['order'];
				$gridWidgetDao->updateDynamicByKey ( $filter );
			}
				
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
}