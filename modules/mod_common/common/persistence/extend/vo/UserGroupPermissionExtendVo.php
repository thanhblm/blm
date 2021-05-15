<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\UserGroupPermissionVo;

class UserGroupPermissionExtendVo extends UserGroupPermissionVo {
	public function __construct() {
		parent::__construct ();
		array_push ( $this->resultMap, "permission_name", "permissionName" );
	}
	public $permissionName;
}