<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\PermissionActionMapping;
use common\persistence\extend\vo\PermissionActionExtendVo;
use core\database\SqlStatementInfo;

class PermissionActionExtendMapping extends PermissionActionMapping {
	public function getListPermissionActionForAuthodrization() {
		try {
			$query = "
				select 
					pa.* 
				from user u
				inner join `user_group` ug on u.user_group_id = ug.id and u.id = #{id}
				inner join `user_group_permission` ugp on ugp.user_group_id = ug.id and ugp.permission_type in ('view','full')
				inner join `permission_action` pa on ugp.permission_action_code = pa.code and (
				(ugp.permission_type = 'view' and pa.action_type= 'view') or ugp.permission_type = 'full')
				and `action` = #{action}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PermissionActionExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}