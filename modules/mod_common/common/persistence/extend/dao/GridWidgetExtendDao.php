<?php

namespace common\persistence\extend\dao;

use common\persistence\base\vo\GridWidgetVo;
use common\persistence\extend\mapping\GridWidgetExtendMapping;
use core\database\BaseDao;
use core\database\SqlMapClient;

class GridWidgetExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function deleteByFilter(GridWidgetVo $filter = null) {
		$result = $this->executeSelectList ( GridWidgetExtendMapping::class, 'deleteByFilter', $filter );
		return $result;
	}
}