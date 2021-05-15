<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\CustomerTypeMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use common\persistence\base\vo\CustomerTypeVo;

class CustomerTypeExtendMapping extends CustomerTypeMapping{
	private $asCustomerType = "at";
	public function search(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "SELECT ".$this->asCustomerType.".* from customer_type ".$this->asCustomerType
						. $this->buildCondition($customerTypeVo) 
						. $this->buildPaging($customerTypeVo);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(CustomerTypeVo $customerTypeVo) {
		try {
			$query = "SELECT count(".$this->asCustomerType.".`id`) from customer_type ".$this->asCustomerType
						. $this->buildCondition($customerTypeVo);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerTypeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($customerTypeVo){
		$endQuery = "";
		$objInfo = get_object_vars($customerTypeVo);
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asCustomerType.".".$objInfo['order_by'];
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
	
	private function buildCondition($customerTypeVo){
		$condition = " where 1=1 ";
		$objInfo = get_object_vars($customerTypeVo);
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .= " AND ".$this->asCustomerType.".`id` = #{id}";
		}
		if(!AppUtil::isEmptyString($objInfo['name'])){
			$condition .= " AND ".$this->asCustomerType.".`name` LIKE #{name:PARAM_BOTH_LIKE}";
		}
		return $condition;
	}
	
}