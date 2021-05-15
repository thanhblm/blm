<?php

namespace common\persistence\extend\mapping;

use common\filter\user\UserFilter;
use common\model\UserMo;
use common\persistence\base\mapping\UserMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class UserExtendMapping extends UserMapping{
	private $asUser = "p";
	private $asUserGroup = "u_g";
	public function search(UserFilter $filter) {
		try {
			$query = "SELECT ".$this->asUser.".*, ".$this->asUserGroup.".name ug_name 
						FROM user ".$this->asUser." 
						LEFT JOIN `user_group` ".$this->asUserGroup." ON ".$this->asUser.".user_group_id = ".$this->asUserGroup.".id " 
						. $this->buildCondition($filter) 
						. $this->buildPaging($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(UserFilter $filter) {
		try {
			$query = "SELECT count(".$this->asUser.".id) from user ".$this->asUser." 
						LEFT JOIN `user_group` ".$this->asUserGroup." ON ".$this->asUser.".user_group_id = ".$this->asUserGroup.".id "
						. $this->buildCondition($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asUser.".".$objInfo['order_by'];
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
		if(!AppUtil::isEmptyString($objInfo['email'])){
			$condition .=  " AND ".$this->asUser.".email LIKE #{email:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['phone'])){
			$condition .=  " AND ".$this->asUser.".phone LIKE #{phone:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['fullName'])){
			$condition .=  " AND ".$this->asUser.".full_name LIKE #{fullName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['userName'])){
			$condition .=  " AND ".$this->asUser.".user_name LIKE #{userName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['ugName'])){
			$condition .=  " AND ".$this->asUserGroup.".name LIKE #{ugName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['status'])){
			$condition .=  " AND ".$this->asUser.".status = #{status}";
		}
		return $condition;
	}
}