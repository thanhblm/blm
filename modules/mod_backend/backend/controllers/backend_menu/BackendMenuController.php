<?php

namespace backend\controllers\backend_menu;

use common\persistence\base\vo\BackendMenuVo;
use common\services\backend_menu\BackendMenuService;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\Controller;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;

class BackendMenuController extends Controller {
	public $backendMenuList;
	public $backendMenuVo;
	public $id;
	public $backendMenuParentList;
	public $showInfoStatus;

	private $backendMenuService;
	public $viewPath;
	public function __construct() {
		parent::__construct ();
		$this->backendMenuVo = new BackendMenuVo ();
		$this->backendMenuService = new BackendMenuService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Backend Menu Management";
		$this->viewPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['VIEW_PATH'];
	}
	public function listView() {
	    $this->showInfoStatus = 0;
		$this->getBackendMenuList ();
		return "success";
	}
	public function addView() {
		// get default value
		$this->backendMenuVo->icon = 'fa fa-bars';
//		$this->backendMenuVo->mod = 'mod_backend';
		$this->backendMenuVo->order = 0;
		// getBackendMenuParentList
		$this->getBackendMenuParentList ();
		return "success";
	}
	public function add() {
		// getBackendMenuParentList
		$this->getBackendMenuParentList ();
		
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$backendMenuId = $this->backendMenuService->insertDynamic ( $this->backendMenuVo );
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		$this->getBackendMenuVo ();
		// getBackendMenuParentList
		$this->getBackendMenuParentList ();
		
		return "success";
	}
	public function edit() {
		// getBackendMenuParentList
		$this->getBackendMenuParentList ();
		
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->backendMenuVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->backendMenuVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// update
		$this->backendMenuService->updateDynamicByKey ( $this->backendMenuVo );
		$this->addActionMessage ( "The backend menu updated successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Load system setting group.
		$filter = new BackendMenuVo ();
		$filter->id = $this->id;
		$this->backendMenuVo = $this->backendMenuService->selectByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		
		$this->backendMenuService->deleteBackendMenu ( $this->id );
		$this->addActionMessage ( "The backend menu deleted successfully" );
		return "success";
	}
	public function sortable() {
		// get data
		$backendMenuList = RequestUtil::get ( 'backendMenuList' );
		// update gridId and order
		if (! empty ( $backendMenuList )) {
			foreach ( $backendMenuList as $backendMenuData ) {
				$filter = new BackendMenuVo ();
				$filter->id = $backendMenuData ['id'];
				$filter->parentId = $backendMenuData ['parentId'];
				$filter->order = $backendMenuData ['order'];
				$this->backendMenuService->updateDynamicByKey ( $filter );
			}
		}
		$this->getBackendMenuList ();
		return 'success';
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->backendMenuVo->title )) {
			$this->addFieldError ( "backendMenuVo[title]", "Title is required" );
		}
		if (AppUtil::isEmptyString ( $this->backendMenuVo->parentId )) {
			$this->addFieldError ( "backendMenuVo[parentId]", "Parent is required" );
		}
//		if (AppUtil::isEmptyString ( $this->backendMenuVo->mod )) {
//			$this->addFieldError ( "backendMenuVo[mod]", "Module is required" );
//		}
		
		if ($isAdding) {
			// title is unique
//			$filter = new BackendMenuVo ();
//			$filter->title = $this->backendMenuVo->title;
//			$backendMenuList = $this->backendMenuService->selectByFilter ( $filter );
//			if (! empty ( $backendMenuList )) {
//				$this->addFieldError ( "backendMenuVo[title]", "Title is exist" );
//			}
		} else {
			// check title exist
			$filter = new BackendMenuVo ();
			$filter->id = $this->backendMenuVo->id;
			$backendMenuOld = $this->backendMenuService->selectByKey ( $filter );
			
//			$filter = new BackendMenuVo ();
//			$filter->title = $this->backendMenuVo->title;
//			$backendMenuList = $this->backendMenuService->selectByFilter ( $filter );
//			if (count ( $backendMenuList ) > 0 & $backendMenuOld->title != $this->backendMenuVo->title) {
//				$this->addFieldError ( "backendMenuVo[title]", "Title is exist" );
//			}
			
			// check parentId cannot choose itself as its parent
			$backendMenuChildList = array (
					$backendMenuOld 
			);
			$this->backendMenuService->getBackendMenuChildList ( $this->backendMenuVo->id, $backendMenuChildList );
			foreach ( $backendMenuChildList as $backendMenuChild ) {
				if ($backendMenuChild->id == $this->backendMenuVo->parentId) {
					$this->addFieldError ( "backendMenuVo[parentId]", "Cannot choose itself as its parent" );
					break;
				}
			}
		}
	}
	private function getBackendMenuVo() {
		$filter = new BackendMenuVo ();
		$filter->id = $this->id;
		$this->backendMenuVo = $this->backendMenuService->selectByKey ( $filter );
	}
	private function getBackendMenuList() {
		$this->backendMenuList = $this->backendMenuService->getBackendMenuList ();
	}
	private function getBackendMenuParentList() {
		$this->getBackendMenuList ();
		$this->backendMenuParentList = array (
				0 => Lang::get ( '---Root---' ) 
		);
		foreach ( $this->backendMenuList as $backendMenuInfo ) {
			$level = $backendMenuInfo ['level'];
			$space = "";
			for($i = 0; $i < $level; $i ++) {
				$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $space;
			}
			$this->backendMenuParentList [$backendMenuInfo ['id']] = $space . $backendMenuInfo ['title'];
		}
	}
	public function refreshBackendMenu() {
		$this->getBackendMenuList ();
		return "success";
	}
}