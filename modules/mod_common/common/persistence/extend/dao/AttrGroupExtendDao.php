<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\AttrGroupBaseDao;
use common\persistence\extend\mapping\AttrGroupExtendMapping;
use core\database\SqlMapClient;
use common\filter\attribute_group\AttributeGroupFilter;

class AttrGroupExtendDao extends AttrGroupBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(AttributeGroupFilter $filter) {
		$result = $this->executeSelectList ( AttrGroupExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(AttributeGroupFilter $filter) {
		$result = $this->executeCount( AttrGroupExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
}