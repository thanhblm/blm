<?php

namespace common\persistence\extend\dao;
use common\filter\user_group\UserGroupFilter;
use common\persistence\base\dao\UserGroupBaseDao;
use common\persistence\extend\mapping\UserGroupExtendMapping;
use core\database\SqlMapClient;

class UserGroupExtendDao extends UserGroupBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(UserGroupFilter $filter) {
		$result = $this->executeSelectList ( UserGroupExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(UserGroupFilter $filter) {
		$result = $this->executeCount( UserGroupExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
}