<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\CustomerBaseDao;
use common\persistence\extend\mapping\CustomerExtendMapping;
use common\persistence\extend\vo\CustomerExtendVo;
use core\database\SqlMapClient;
use common\persistence\base\vo\CustomerChangePasswordVo;

class CustomerExtendDao extends CustomerBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(CustomerExtendVo $customerExtendVo) {
		$result = $this->executeSelectList ( CustomerExtendMapping::class, 'search', $customerExtendVo);
		return $result;
	}
	
	public function searchCount(CustomerExtendVo $customerExtendVo) {
		$result = $this->executeCount( CustomerExtendMapping::class, 'searchCount', $customerExtendVo);
		return $result;
	}
	
	public function deleteChangePass(CustomerChangePasswordVo $vo){
		return $this->executeDelete( CustomerExtendMapping::class, 'deleteChangePass', $vo);
	}
}