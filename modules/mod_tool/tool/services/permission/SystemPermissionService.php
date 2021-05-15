<?php

namespace tool\services\permission;

use tool\persistence\extend\dao\PermissionExtendDao;
use common\persistence\base\vo\PermissionActionVo;
use common\persistence\base\dao\PermissionActionBaseDao;
use common\persistence\base\vo\PermissionVo;
use tool\persistence\extend\dao\PermissionActionExtendDao;

class SystemPermissionService {
	public function deleteAllPermission() {
		$permissionDao = new PermissionExtendDao ();
		$result = $permissionDao->deleteAll ();
		return $result;
	}
	
	public function deleteAllPermissionAction() {
		$permissionActionDao = new PermissionActionExtendDao();
		$result = $permissionActionDao->deleteAll ();
		return $result;
	}
	
	public function insertPermissionDynamic(PermissionVo $permissionVo) {
		$permissionDao = new PermissionExtendDao ();
		$result = $permissionDao->insertDynamic($permissionVo);
		return $result;
	}
	
	public function preparePermissionFromAction() {
		$permissionDao = new PermissionExtendDao ();
		$result = $permissionDao->preparePermissionFromAction();
		return $result;
	}
	
	public function insertPermissionAction(PermissionActionVo $vo) {
		$permissionActionDao = new PermissionActionBaseDao();
		$result = $permissionActionDao->insertDynamic($vo );
		return $result;
	}
}