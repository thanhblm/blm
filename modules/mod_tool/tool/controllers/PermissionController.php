<?php

namespace tool\controllers;

use common\persistence\base\vo\PermissionActionVo;
use core\config\ActionConfig;
use core\Controller;
use tool\services\permission\SystemPermissionService;

class PermissionController extends Controller {
	public $actionNoGroups = array ();
	public function __construct() {
	}
	public function updatePemission() {
		$actionCfgs = ActionConfig::getSettings ();
		$systemPermissionService = new SystemPermissionService ();
		$systemPermissionService->deleteAllPermissionAction ();
		$this->actionNoGroups = array ();
		foreach ( $actionCfgs as $actionPath => $actionInfos ) {
			if (isset ( $actionInfos ['group'] ) && is_array ( $actionInfos ['group'] )) {
				$groups = $actionInfos ['group'];
				foreach ( $groups as $group ) {
					$permissionActVo = new PermissionActionVo ();
					$permissionActVo->action = $actionPath;
					$arr = explode ( ":", $group );
					$permissionActVo->code = $arr [0];
					$permissionActVo->actionType = $arr [1];
					$permissionActVo->name = "";
					$systemPermissionService->insertPermissionAction ( $permissionActVo );
				}
			} else {
				$this->actionNoGroups [] = $actionPath;
			}
		}
		$systemPermissionService->deleteAllPermission ();
		$permissionVos = $systemPermissionService->preparePermissionFromAction ();
		foreach ( $permissionVos as $permissionVo ) {
			$systemPermissionService->insertPermissionDynamic ( $permissionVo );
		}
		return "success";
	}
}