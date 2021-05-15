<?php

namespace common\persistence\extend\dao;
use common\filter\slide_group\SlideGroupFilter;
use common\persistence\base\dao\SlideGroupBaseDao;
use common\persistence\extend\mapping\SlideGroupExtendMapping;
use core\database\SqlMapClient;

class SlideGroupExtendDao extends SlideGroupBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(SlideGroupFilter $filter) {
		$result = $this->executeSelectList ( SlideGroupExtendMapping::class, 'search', $filter );
		return $result;
	}
	public function searchCount(SlideGroupFilter $filter) {
		$result = $this->executeCount( SlideGroupExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
}