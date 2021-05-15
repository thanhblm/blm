<?php

namespace tool\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use common\persistence\base\mapping\PermissionMapping;
use common\persistence\base\vo\PermissionVo;

class PermissionExtendMapping extends PermissionMapping {
	public function deleteAll() {
		try {
			$query = "delete from `permission`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`permission`", $query, PermissionVo::class, "" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function preparePermissionFromAction() {
		try {
			$query = "
						select tmp.`code` as permission_action_code, tmp.`view` as type, tmp.`code` as name from (
						select `code`,'view' from permission_action where action_type = 'view' group by code
						union
						select `code`, 'full' from permission_action where !(action_type = '*' or action_type ='authenticated') group by code
						union
						select `code`, 'none' from permission_action where !(action_type = '*' or action_type ='authenticated') group by code
						) as tmp order by tmp.code
					";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, "`permission`", $query, PermissionVo::class, "" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}