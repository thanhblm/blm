<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\UserGroupPermissionBaseDao;
use common\persistence\base\vo\UserGroupPermissionVo;
use common\persistence\extend\mapping\UserGroupPermissionExtendMapping;
use core\database\SqlMapClient;

class UserGroupPermissionExtendDao extends UserGroupPermissionBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function delByUserGroup(UserGroupPermissionVo $userGroupPermissionVo) {
		$this->executeDelete ( UserGroupPermissionExtendMapping::class, 'delByUserGroup', $userGroupPermissionVo );
	}
}