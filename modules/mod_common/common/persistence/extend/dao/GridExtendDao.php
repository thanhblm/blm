<?php

namespace common\persistence\extend\dao;

use common\persistence\base\vo\GridVo;
use common\persistence\extend\mapping\GridExtendMapping;
use core\database\BaseDao;
use core\database\SqlMapClient;

class GridExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getWidgetContentListOfGrid(GridVo $gridVo) {
		return $this->executeSelectList ( GridExtendMapping::class, 'getWidgetContentListOfGrid', $gridVo );
	}
	public function deleteByFilter(GridVo $filter = null) {
		$result = $this->executeDelete ( GridExtendMapping::class, 'deleteByFilter', $filter );
		return $result;
	}
}