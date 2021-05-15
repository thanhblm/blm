<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\AreaBaseDao;
use common\persistence\extend\mapping\AreaExtendMapping;
use common\persistence\extend\vo\AreaExtendVo;
use core\database\SqlMapClient;

class AreaExtendDao extends AreaBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getAreaFull(AreaExtendVo $filter = null){
		$result = $this->executeSelectList(AreaExtendMapping::class, 'getAreaFull', $filter);
		return $result;
	}

}

