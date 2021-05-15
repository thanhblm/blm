<?php

namespace common\persistence\extend\dao;

use core\database\SqlMapClient;
use common\persistence\base\dao\PermissionActionBaseDao;
use common\persistence\extend\mapping\PermissionActionExtendMapping;
use common\persistence\extend\vo\PermissionActionExtendVo;

class PermissionActionExtendDao extends PermissionActionBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getListPermissionActionForAuthodrization(PermissionActionExtendVo $vo) {
		$result = $this->executeSelectList ( PermissionActionExtendMapping::class, 'getListPermissionActionForAuthodrization', $vo );
		return $result;
	}
}