<?php

namespace common\persistence\extend\dao;

use common\filter\attribute_group\AttributeFilter;
use common\persistence\base\dao\AttributeBaseDao;
use common\persistence\extend\mapping\AttributeExtendMapping;
use core\database\SqlMapClient;

class AttributeExtendDao extends AttributeBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(AttributeFilter $filter) {
		$result = $this->executeSelectList ( AttributeExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(AttributeFilter $filter) {
		$result = $this->executeCount( AttributeExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	
	public function searchByKey(AttributeFilter $filter) {
		$result = $this->executeSelectOne( AttributeExtendMapping::class, 'searchByKey', $filter );
		return $result;
	}

	//$listId is array
	public function getByIds($listId) {
		$result = $this->executeSelectList( AttributeExtendMapping::class, 'searchByIds', $listId );
		return $result;
	}
}
