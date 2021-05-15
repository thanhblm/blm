<?php

namespace common\persistence\extend\dao;

use common\filter\user\UserFilter;
use common\persistence\base\dao\UserBaseDao;
use common\persistence\extend\mapping\UserExtendMapping;
use core\database\SqlMapClient;

class UserExtendDao extends UserBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(UserFilter $filter) {
		$result = $this->executeSelectList ( UserExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(UserFilter $filter) {
		$result = $this->executeCount( UserExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
}