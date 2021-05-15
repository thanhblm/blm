<?php

namespace tool\persistence\extend\dao;

use common\persistence\base\dao\PermissionBaseDao;
use core\database\SqlMapClient;
use tool\persistence\extend\mapping\PermissionExtendMapping;

class PermissionExtendDao extends PermissionBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function deleteAll() {
		$result = $this->executeDelete ( PermissionExtendMapping::class, 'deleteAll', null );
		return $result;
	}
	public function preparePermissionFromAction() {
		$result = $this->executeSelectList ( PermissionExtendMapping::class, 'preparePermissionFromAction', null );
		return $result;
	}
}