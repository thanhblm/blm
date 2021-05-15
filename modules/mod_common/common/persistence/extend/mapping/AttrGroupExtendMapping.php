<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\AttrGroupMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use common\filter\attribute_group\AttributeGroupFilter;
use common\persistence\extend\vo\AttrGroupExtendVo;

class AttrGroupExtendMapping extends AttrGroupMapping{
	
	public function search(AttributeGroupFilter $filter) {
		try {
			$query = "SELECT atg.* from attr_group atg"
						. $this->buildCondition($filter) 
						. $this->buildPaging($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttrGroupExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(AttributeGroupFilter $filter) {
		try {
			$query = "SELECT count(atg.id) from attr_group atg "
						. $this->buildCondition($filter);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttrGroupExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);
		
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by atg.".$objInfo['order_by']; 
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
			$condition .= " AND atg.name LIKE #{name:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['description'])){
			$condition .= " AND atg.description LIKE #{description:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['order'])){
			$condition .= " AND atg.order = #{order}";
		}
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .= " AND atg.id = #{id}";
		}
		return $condition;
	}
}