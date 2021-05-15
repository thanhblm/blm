<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\StateVo;
use core\database\SqlStatementInfo;

class StateExtendMapping {
	public function getStateByCountryId(StateVo $stateVo = null) {
		try {
			$query = "select * from `state` 
				where `country` = #{country}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getStateListByCountryList($countryListString) {
		try {
			$query = "select * from `state`
				where `country` in (" . $countryListString . ")";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, StateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}