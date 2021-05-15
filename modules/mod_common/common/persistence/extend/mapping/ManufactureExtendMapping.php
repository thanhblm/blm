<?php

namespace common\persistence\extend\mapping;

use common\filter\manufacture\ManufactureFilter;
use common\model\ManufactureMo;
use common\persistence\base\mapping\ManufactureMapping;
use common\persistence\extend\vo\ManufactureExtendVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class ManufactureExtendMapping extends ManufactureMapping {
	public function search(ManufactureFilter $filter) {
		try {
			$query = "SELECT * "
						. " FROM manufacture "
				. $this->buildCondition($filter)
				. $this->buildPaging($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ManufactureMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(ManufactureFilter $filter) {
		try {
			$query = "SELECT count(id) from manufacture "
				. $this->buildCondition($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ManufactureMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$objInfo['order_by'];
		}
		if(!AppUtil::isEmptyString($objInfo['start_record'])){
			if(!AppUtil::isEmptyString($objInfo['end_record'])){
				$endQuery = $endQuery . " LIMIT  #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}else{
				$endQuery = $endQuery . " LIMIT #{start_record:PARAM_INT}";
			}
		}
		return  $endQuery;
	}

	private function buildCondition($filter){
		$condition = " where 1=1 ";
		$objInfo = get_object_vars($filter);
		if(!AppUtil::isEmptyString($objInfo['title'])){
			$condition .=  " AND title LIKE #{title:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .=  " AND id = #{id}";
		}
		if(!AppUtil::isEmptyString($objInfo['status'])){
			$condition .=  " AND ".$this->asUser.".status = #{status}";
		}
		return $condition;
	}
}