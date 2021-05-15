<?php

namespace common\persistence\extend\dao;

use common\filter\permission\PermissionFilter;
use common\persistence\base\dao\PermissionBaseDao;
use common\persistence\extend\mapping\PermissionExtendMapping;
use core\database\SqlMapClient;

class PermissionExtendDao extends PermissionBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(PermissionFilter $filter) {
		$result = $this->executeSelectList ( PermissionExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(PermissionFilter $filter) {
		$result = $this->executeCount( PermissionExtendMapping::class, 'searchCount', $filter );
		return $result;
	}

	public function getListPermission() {
		$result = $this->executeSelectList( PermissionExtendMapping::class, 'getListPermission' );
		return $result;
	}
}