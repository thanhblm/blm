<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\AreaCategoryBaseDao;
use common\persistence\base\vo\AreaCategoryVo;
use common\persistence\extend\mapping\AreaCategoryExtendMapping;
use core\database\SqlMapClient;

class AreaCategoryExtendDao extends AreaCategoryBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function deleteAreaCategoryByCatId(AreaCategoryVo $filter){
		$result = $this->executeDelete(AreaCategoryExtendMapping::class, 'deleteAreaCategoryByCatId', $filter);
		return $result;
	}
}

