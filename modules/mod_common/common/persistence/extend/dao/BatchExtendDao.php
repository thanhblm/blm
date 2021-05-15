<?php

namespace common\persistence\extend\dao;

use common\filter\batch\BatchFilter;
use common\persistence\base\dao\BatchBaseDao;
use common\persistence\extend\mapping\BatchExtendMapping;
use core\database\SqlMapClient;
use common\persistence\base\vo\BatchVo;

class BatchExtendDao extends BatchBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(BatchFilter $filter) {
		$result = $this->executeSelectList ( BatchExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(BatchFilter $filter) {
		$result = $this->executeCount( BatchExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	public function delete(BatchVo $batchVo) {
		$result = $this->executeDelete( BatchExtendMapping::class, 'delete', $batchVo);
		return $result;
	}
	public function selectByFilterExtend(BatchVo $batchVo = null) {
		$result = $this->executeSelectList ( BatchExtendMapping::class, 'selectByFilterExtend', $batchVo );
		return $result;
	}
}