<?php

namespace tool\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use common\persistence\base\mapping\PermissionActionMapping;
use common\persistence\base\vo\PermissionActionVo;

class PermissionActionExtendMapping extends PermissionActionMapping {
	public function deleteAll() {
		try {
			$query = "delete from `permission_action`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`permission`", $query, PermissionActionVo::class, "" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}