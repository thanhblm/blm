<?php

namespace common\helper;

use common\model\LoginUserInfoMo;
use common\persistence\base\vo\PermissionActionVo;
use common\persistence\extend\dao\PermissionActionExtendDao;
use common\persistence\extend\vo\PermissionActionExtendVo;
use common\services\backend_menu\BackendMenuService;
use common\services\permission\PermissionService;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class PermissionHelper {
	public static function checkAdminUserLogin() {
		$loginUserInfo = SessionUtil::get ( ApplicationConfig::get ( "session.user.login.name" ) );
		if (is_null ( $loginUserInfo )) {
			return false;
		}
		if (! isset ( $loginUserInfo->userType ) || ! isset ( $loginUserInfo->userGroupId )) {
			return false;
		}
		
		if ("ADMIN" != $loginUserInfo->userType) {
			return false;
		}
		
		return true;
	}
	public static function hasAdminPermission($actionPath) {
		$actionPath = AppUtil::isEmptyString ( $actionPath ) ? '' : $actionPath;
		$authenOpt = is_null ( ApplicationConfig::get ( "authentication.mode" ) ) ? true : ApplicationConfig::get ( "authentication.mode" );
		$authenOpt = is_bool ( $authenOpt ) ? $authenOpt : true;
		if (! $authenOpt && ! self::checkAdminUserLogin ()) {
			$loginUserInfo = new LoginUserInfoMo ();
			$loginUserInfo->userId = 0;
			$loginUserInfo->fullName = "admin";
			$loginUserInfo->userGroupId = 1;
			$loginUserInfo->userName = "admin";
			$loginUserInfo->userType = "ADMIN";
			SessionUtil::set ( ApplicationConfig::get ( "session.user.login.name" ), $loginUserInfo );
			$backendMenuService = new BackendMenuService ();
			$loginUserInfo->backendMenuList = $backendMenuService->getBackendMenuList ();
			SessionUtil::set ( ApplicationConfig::get ( "session.user.login.name" ), $loginUserInfo );
			return true;
		}
		$arrayNoCheck = is_null ( ApplicationConfig::get ( "authentication.allow.actions" ) ) ? array () : ApplicationConfig::get ( "authentication.allow.actions" );
		if (in_array ( $actionPath, $arrayNoCheck )) {
			return true;
		}
		
		if (! self::checkAdminUserLogin ()) {
			return false;
		}
		
		$loginUserInfo = SessionUtil::get ( ApplicationConfig::get ( "session.user.login.name" ) );
		
		if (ApplicationConfig::get ( "authentication.super.administrator.group.id" ) === $loginUserInfo->userGroupId) {
			return true;
		}
		// 2. check for action only required authenticated
		$permssionActionVo = new PermissionActionVo ();
		$permssionActionVo->action = $actionPath;
		$permssionActionVo->actionType = "authenticated";
		$permissionActionDao = new PermissionActionExtendDao();
		$permssionActionVos = $permissionActionDao->selectByFilter ( $permssionActionVo );
		foreach ( $permssionActionVos as $permssionActionVo ) {
			if ($actionPath == $permssionActionVo->action) {
				return true;
			}
		}
		// 3. check for action path required permission group
		$permissionService = new PermissionService ();
		$permissionActionExtendVo = new PermissionActionExtendVo ();
		$permissionActionExtendVo->id = $loginUserInfo->userId;
		$permissionActionExtendVo->action = $actionPath;
		$permissionActionVos = $permissionService->getListPermissionActionForAuthodrization ( $permissionActionExtendVo );
		foreach ( $permissionActionVos as $permssionActionVo ) {
			if ($actionPath == $permssionActionVo->action) {
				return true;
			}
		}
		
		// 1.Bypass if action Path is not a authentication required.
// 		$permissionActionDao = new PermissionActionBaseDao ();
// 		$permssionActionVo = new PermissionActionVo ();
// 		$permssionActionVo->action = $actionPath;
// 		$permssionActionVo->actionType = "*";
// 		$permssionActionVos = $permissionActionDao->selectByFilter ( $permssionActionVo );
		
// 		foreach ( $permssionActionVos as $permssionActionVo ) {
// 			if ($actionPath == $permssionActionVo->action) {
// 				return true;
// 			}
// 		}
		
		return false;
	}
}

