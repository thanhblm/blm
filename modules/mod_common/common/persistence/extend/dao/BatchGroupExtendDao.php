<?php

namespace common\persistence\extend\dao;
use common\persistence\base\dao\BatchGroupBaseDao;
use common\persistence\extend\mapping\BatchGroupExtendMapping;
use core\database\SqlMapClient;
use common\filter\batch_group\SlideGroupFilter;

class BatchGroupExtendDao extends BatchGroupBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(SlideGroupFilter $filter) {
		$result = $this->executeSelectList ( BatchGroupExtendMapping::class, 'search', $filter );
		return $result;
	}
	public function searchCount(SlideGroupFilter $filter) {
		$result = $this->executeCount( BatchGroupExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
}