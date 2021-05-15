<?php

namespace backend\controllers\user_group;

use common\filter\user_group\UserGroupFilter;
use common\model\UserGroupMo;
use common\persistence\base\vo\PermissionVo;
use common\persistence\base\vo\UserGroupPermissionVo;
use common\persistence\base\vo\UserGroupVo;
use common\persistence\extend\vo\UserGroupPermissionExtendVo;
use common\services\permission\PermissionService;
use common\services\user_group\UserGroupService;
use common\utils\StringUtil;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

/**
 * *
 *
 * @author TANDT
 *        
 */
class UserGroupController extends PagingController {
	// Data request
	public $userGroupMo;
	public $permissionMos;
	// Data response
	public $userGroupVo;
	public $userGroupVos;
	private $userGroupSv;
	private $permissionService;
	public function __construct() {
		parent::__construct ();
		$this->userGroupVo = new UserGroupVo ();
		$this->userGroupSv = new UserGroupService ();
		$this->permissionService = new PermissionService ();
		$this->userGroupMo = new UserGroupMo ();
		$this->filter = new UserGroupFilter ();
		$this->permissionMos = new BaseArray ( UserGroupPermissionExtendVo::class );
	}
	public function listView() {
		$this->getList ();
		return "success";
	}
	public function search() {
		$this->getList ();
		return "success";
	}
	public function addView() {
		$this->preparePermission4Add ();
		return "success";
	}
	public function add() {
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->userGroupSv->add ( $this->userGroupVo, $this->permissionMos );
		return "success";
	}
	public function editView() {
		$this->preparePermission4Edit ();
		$this->detail ();
		return "success";
	}
	public function edit() {
		$this->denyModifySuperAdministrator ();
		$this->validEditData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->userGroupSv->edit ( $this->userGroupVo, $this->permissionMos );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->denyModifySuperAdministrator ();
		if ($this->hasErrors()){
			return "success";
		}
		$this->userGroupSv->deleteUserGroup ( $this->userGroupMo );
		return "success";
	}
	public function copyView() {
		$this->preparePermission4Edit ();
		$this->detail ();
		return "success";
	}
	public function copy() {
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->userGroupVo->id = null;
		$this->userGroupSv->add ( $this->userGroupVo, $this->permissionMos );
		return "success";
	}
	protected function preparePermission4Add() {
		$permissionVos = $this->permissionService->getListPermission ();
		$result = new BaseArray ( UserGroupPermissionExtendVo::class );
		foreach ( $permissionVos as $permissionVo ) {
			$userPermissionGroupVo = new UserGroupPermissionExtendVo ();
			$userPermissionGroupVo->permissionActionCode = $permissionVo->permissionActionCode;
			$userPermissionGroupVo->permissionType = AppUtil::arrayValue ( ApplicationConfig::get ( "permission.type.list" ), "none" );
			$userPermissionGroupVo->permissionName = $permissionVo->name;
			$result->add ( $userPermissionGroupVo );
		}
		$this->permissionMos = $result;
	}
	protected function preparePermission4Edit() {
		// Get all permission of user group.
		$pgVo = new UserGroupPermissionVo ();
		$pgVo->userGroupId = $this->userGroupMo->id;
		$userGroupPermissionList = $this->userGroupSv->getUserGroupPermissions ( $pgVo );
		// Permssion group map.
		$permissionTypeMap = array ();
		foreach ( $userGroupPermissionList as $permission ) {
			$permissionTypeMap [$permission->permissionActionCode] = $permission->permissionType;
		}
		// Get all permission from the system.
		$permissionVos = $this->permissionService->getListPermission ();
		$result = new BaseArray ( UserGroupPermissionExtendVo::class );
		foreach ( $permissionVos as $permissionVo ) {
			$userPermissionGroupVo = new UserGroupPermissionExtendVo ();
			$userPermissionGroupVo->permissionActionCode = $permissionVo->permissionActionCode;
			$userPermissionGroupVo->permissionType = isset ( $permissionTypeMap [$permissionVo->permissionActionCode] ) ? $permissionTypeMap [$permissionVo->permissionActionCode] : AppUtil::arrayValue ( ApplicationConfig::get ( "permission.type.list" ), "none" );
			$userPermissionGroupVo->permissionName = $permissionVo->name;
			$result->add ( $userPermissionGroupVo );
		}
		$this->permissionMos = $result;
	}
	private function getAllPermission() {
		$permissionSv = new PermissionService ();
		$this->listPermission = $permissionSv->getListPermission ();
	}
	private function getAllPermissionType() {
		$permissionSv = new PermissionService ();
		$permissionVo = new PermissionVo ();
		$this->listPermissionType = $permissionSv->selectByFilter ( $permissionVo );
	}
	private function preapareData() {
		AppUtil::copyProperties ( $this->userGroupMo, $this->userGroupVo );
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new UserGroupVo ();
			$filter->name = $this->userGroupMo->name;
			$voResult = $this->userGroupSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && $voResult [0]->name == $this->userGroupMo->name) {
				$this->addFieldError ( "userGroupMo[name]", Lang::getWithFormat ( "{0} has already existed!", $this->userGroupMo->name ) );
			}
		}
	}
	private function validEditData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new UserGroupVo ();
			$filter->name = $this->userGroupMo->name;
			$voResult = $this->userGroupSv->selectByFilter ( $filter );
			
			$filterOld = new UserGroupVo ();
			$filterOld->id = $this->userGroupMo->id;
			$voOldResult = $this->userGroupSv->selectByFilter ( $filterOld );
			
			if ($voOldResult [0]->name != $this->userGroupMo->name) {
				if (count ( $voResult ) > 0 && $voResult [0]->name == $this->userGroupMo->name) {
					$this->addFieldError ( "userGroupMo[name]", Lang::getWithFormat ( "{0} has already existed!", $this->userGroupMo->name ) );
				}
			}
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->userGroupMo->name )) {
			$this->addFieldError ( "userGroupMo[name]", Lang::get ( "Name can not be empty" ) );
		} else if (! StringUtil::validName ( $this->filter->name )) {
			$this->addFieldError ( 'userGroupMo[name]', Lang::getWithFormat ( "{0} is Name exist special character.", $this->filter->name ) );
		}
		if (count ( $this->permissionMos->getArray () ) == 0) {
			$this->addFieldError ( "permissions", Lang::get ( "Please choice permission for Administrator Groups" ) );
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->userGroupMo->id )) {
			$this->addFieldError ( "userGroupMo[id]", Lang::get ( "Invalid not valid." ) );
		} else {
			$this->userGroupMo = $this->userGroupSv->selectBykey ( $this->userGroupMo );
		}
	}
	private function getList() {
		$filter = $this->buildFilter ();
		$count = $this->userGroupSv->searchCount ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$filter->order_by = $this->orderBy;
		// Get lang list by filter.
		$this->userGroupVos = $this->userGroupSv->search ( $filter );
		$paging->records = $this->userGroupVos;
		$this->userGroupList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	private function denyModifySuperAdministrator() {
		if (1 == $this->userGroupMo->id) {
			$this->addActionError ( "You cannot modify Super Administrator" );
		}
	}
}