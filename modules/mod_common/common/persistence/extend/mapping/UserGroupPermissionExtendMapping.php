<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\UserGroupPermissionVo;
use core\database\SqlStatementInfo;

class UserGroupPermissionExtendMapping {
	public function delByUserGroup(UserGroupPermissionVo $userGroupPermissionVo) {
		try {
			$query = "delete from user_group_permission where user_group_id = #{userGroupId:PARAM_INT} ";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, UserGroupPermissionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}