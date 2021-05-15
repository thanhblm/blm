<?php

namespace tool\persistence\extend\dao;

use core\database\SqlMapClient;
use common\persistence\base\dao\PermissionActionBaseDao;
use tool\persistence\extend\mapping\PermissionActionExtendMapping;

class PermissionActionExtendDao extends PermissionActionBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function deleteAll() {
		$result = $this->executeDelete ( PermissionActionExtendMapping::class, 'deleteAll', null );
		return $result;
	}
	
}

