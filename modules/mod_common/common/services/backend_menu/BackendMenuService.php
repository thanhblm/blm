<?php

namespace common\services\backend_menu;

use common\helper\PermissionHelper;
use common\persistence\base\dao\BackendMenuBaseDao;
use common\persistence\base\vo\BackendMenuVo;
use common\services\base\BaseService;
use common\utils\ArrayUtil;
use common\utils\FileUtil;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class BackendMenuService extends BaseService {
	private $backendMenuBaseDao;
	public function __construct() {
		$this->backendMenuBaseDao = new BackendMenuBaseDao ();
	}
	public function selectByKey(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->selectByKey ( $backendMenuVo );
	}
	public function selectAll(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->selectAll ( $backendMenuVo );
	}
	public function selectByFilter(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->selectByFilter ( $backendMenuVo );
	}
	public function countByFilter(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->countByFilter ( $backendMenuVo );
	}
	public function insertDynamic(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->insertDynamic ( $backendMenuVo );
	}
	public function updateDynamicByKey(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->updateDynamicByKey ( $backendMenuVo );
	}
	public function deleteByKey(BackendMenuVo $backendMenuVo = null) {
		return $this->backendMenuBaseDao->deleteByKey ( $backendMenuVo );
	}
	
	/**
	 * **********************************************
	 * ADVANCE FUNCTION
	 * *********************************************
	 */
	public function getBackendMenuList() {
		$filter = new BackendMenuVo ();
		$filter->order_by = "order asc";
		$backendMenuList = $this->backendMenuBaseDao->selectByFilter ( $filter );
		$backendMenuListTmp = array ();
		foreach ( $backendMenuList as $backendMenuVo ) {
			if (PermissionHelper::hasAdminPermission ( $backendMenuVo->link ) || AppUtil::isEmptyString ( $backendMenuVo->link )) {
				$backendMenuListTmp [] = $backendMenuVo;
			}
		}
		$backendMenuList = $backendMenuListTmp;
		
		// convert list object to list array
		$backendMenuList = ArrayUtil::objectToArray ( $backendMenuList );
		
		// add info
		$backendMenuListTmp = array ();
		foreach ( $backendMenuList as $k => $v ) {
			// set haveChild
			$backendMenuList [$k] ['haveChild'] = false;
			foreach ( $backendMenuList as $backendMenuInfo ) {
				if ($backendMenuInfo ['parentId'] == $v ['id']) {
					$backendMenuList [$k] ['haveChild'] = true;
					break;
				}
			}
			if ($backendMenuList [$k] ['haveChild'] == false && AppUtil::isEmptyString ( $v ['link'] )) {
				continue;
			}
			$backendMenuListTmp [$k] = $backendMenuList [$k];
		}
		$backendMenuList = $backendMenuListTmp;
		
		$ret = array ();
		return ArrayUtil::recursive ( $backendMenuList, 0, $ret );
	}
	
	/**
	 * get all childs of
	 *
	 * @param int $backendMenuId        	
	 * @param
	 *        	array rel $backendMenuChildList default empty (include return data)
	 * @return return by rel $backendMenuChildList
	 */
	public function getBackendMenuChildList($backendMenuId, &$backendMenuChildList = array()) {
		if (AppUtil::isEmptyString ( $backendMenuId )) {
			return null;
		}
		
		// get $backendMenuList
		$backendMenuBasaDao = new BackendMenuBaseDao ();
		$backendMenuList = $backendMenuBasaDao->selectAll ();
		
		foreach ( $backendMenuList as $backendMenuInfo ) {
			if ($backendMenuInfo->parentId == $backendMenuId) {
				$backendMenuChildList [] = $backendMenuInfo;
				self::getBackendMenuChildList ( $backendMenuInfo->id, $backendMenuChildList );
			}
		}
	}
	public function deleteBackendMenu($backendMenId) {
		$sqlClient = new SqlMapClient ( $this->context );
		$backendMenuBaseDao = new BackendMenuBaseDao ( $this->context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			// Delete the $backendMenu
			$filter = new BackendMenuVo ();
			$filter->id = $backendMenId;
			$backendMenuBaseDao->deleteByKey ( $filter );

			// delete $backendMenuChildList
			$backendMenuChildList = array ();
			self::getBackendMenuChildList ( $backendMenId, $backendMenuChildList );
			foreach ( $backendMenuChildList as $backendMenuInfo ) {
				$filter = new BackendMenuVo ();
				$filter->id = $backendMenuInfo->id;
				$backendMenuBaseDao->deleteByKey ( $filter );
			}
			
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
}