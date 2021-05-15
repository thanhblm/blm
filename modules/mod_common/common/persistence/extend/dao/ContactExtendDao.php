<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\ContactBaseDao;
use common\persistence\extend\mapping\ContactExtendMapping;
use common\persistence\extend\vo\ContactExtendVo;
use core\database\SqlMapClient;
use common\persistence\base\vo\ContactVo;

class ContactExtendDao extends ContactBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getByFilter(ContactExtendVo $contactVo = null) {
		$result = $this->executeSelectList ( ContactExtendMapping::class, 'getByFilter', $contactVo );
		return $result;
	}
	final public function getCountByFilter(ContactExtendVo $contactVo = null) {
		$result = $this->executeCount ( ContactExtendMapping::class, 'getCountByFilter', $contactVo );
		return $result;
	}
	final public function getById(ContactVo $contactVo) {
		return $this->executeSelectOne ( ContactExtendMapping::class, "getById", $contactVo );
	}
}