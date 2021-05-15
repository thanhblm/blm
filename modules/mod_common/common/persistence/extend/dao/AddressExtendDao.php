<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\AddressBaseDao;
use common\persistence\extend\mapping\AddressExtendMapping;
use common\persistence\extend\vo\AddressExtendVo;
use core\database\SqlMapClient;

class AddressExtendDao extends AddressBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(AddressExtendVo $addressExtendVo) {
		$result = $this->executeSelectList ( AddressExtendMapping::class, 'search', $addressExtendVo);
		return $result;
	}
	
	public function searchCount(AddressExtendVo $addressExtendVo) {
		$result = $this->executeCount( AddressExtendMapping::class, 'searchCount', $addressExtendVo);
		return $result;
	}
	
}