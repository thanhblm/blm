<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\StateBaseDao;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\mapping\StateExtendMapping;
use core\database\SqlMapClient;

class StateExtendDao extends StateBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getStateByCountryId(StateVo $stateVo = null) {
		return $this->executeSelectList ( StateExtendMapping::class, 'getStateByCountryId', $stateVo );
	}
	public function getStateListByCountryList($countryListString) {
		return $this->executeSelectList ( StateExtendMapping::class, 'getStateListByCountryList', $countryListString );
	}
}

