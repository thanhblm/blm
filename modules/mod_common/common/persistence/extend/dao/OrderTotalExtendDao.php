<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\OrderTotalBaseDao;
use core\database\SqlMapClient;

class OrderTotalExtendDao extends OrderTotalBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	
	
}