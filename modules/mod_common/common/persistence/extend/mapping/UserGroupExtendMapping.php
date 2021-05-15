<?php

namespace common\persistence\extend\mapping;

use common\filter\user_group\UserGroupFilter;
use common\model\UserGroupMo;
use common\persistence\base\mapping\UserGroupMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class UserGroupExtendMapping extends UserGroupMapping{
	private $asUserGroup = "u";
	
	public function search(UserGroupFilter $filter) {
		try {
			$query = "SELECT ".$this->asUserGroup.".* from user_group ".$this->asUserGroup 
						. $this->buildCondition($filter) 
						. $this->buildPaging($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserGroupMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(UserGroupFilter $filter) {
		try {
			$query = "SELECT count(".$this->asUserGroup.".id) from user_group ".$this->asUserGroup 
						. $this->buildCondition($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserGroupMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);
		
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asUserGroup.".".$objInfo['order_by'];
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
		if(!AppUtil::isEmptyString($objInfo['name'])){
			$condition .= " AND ".$this->asUserGroup.".name LIKE #{name:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['description'])){
			$condition .= " AND ".$this->asUserGroup.".description LIKE #{description:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['status'])){
			$condition .= " AND ".$this->asUserGroup.".status = #{status}";
		}
		return $condition;
	}
}