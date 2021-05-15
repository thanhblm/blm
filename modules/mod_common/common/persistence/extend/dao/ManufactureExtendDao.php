<?php

namespace common\persistence\extend\dao;

use common\filter\manufacture\ManufactureFilter;
use common\persistence\base\dao\ManufactureBaseDao;
use common\persistence\extend\mapping\ManufactureExtendMapping;
use core\database\SqlMapClient;

class ManufactureExtendDao extends ManufactureBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(ManufactureFilter $filter) {
		$result = $this->executeSelectList ( ManufactureExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(ManufactureFilter $filter) {
		$result = $this->executeCount( ManufactureExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
}