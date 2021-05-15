<?php

namespace common\persistence\extend\mapping;

use common\filter\permission\PermissionFilter;
use common\model\PermissionMo;
use common\persistence\base\mapping\PermissionMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class PermissionExtendMapping extends PermissionMapping{
	private $asPermission = "p";
	
	public function getListPermission() {
		try {
			$query = "SELECT * FROM permission GROUP BY permission_action_code";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PermissionMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function search(PermissionFilter $filter) {
		try {
			$query = "SELECT ".$this->asPermission.".*, "
						." from permission ".$this->asPermission
						. $this->buildCondition($filter) 
						. $this->buildPaging($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PermissionMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(PermissionFilter $filter) {
		try {
			$query = "SELECT count(".$this->asPermission.".id) from permission ".$this->asPermission 
						. $this->buildCondition($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PermissionMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);
	
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asPermission.".".$objInfo['order_by'];
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
		if(!AppUtil::isEmptyString($objInfo['permissionActionCode'])){
			$condition .= " AND ".$this->asPermission.".permission_action_code LIKE #{permissionActionCode:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['description'])){
			$condition .= " AND ".$this->asPermission.".description LIKE #{description:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['name'])){
			$condition .= " AND ".$this->asPermission.".name LIKE #{name:PARAM_BOTH_LIKE}";
		}
		
		return $condition;
	}
}