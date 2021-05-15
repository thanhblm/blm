<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\CustomerMapping;
use common\persistence\extend\vo\CustomerExtendVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\database\QueryBuilder;
use common\persistence\base\vo\CustomerChangePasswordVo;

class CustomerExtendMapping extends CustomerMapping{
	private $asCustomer = "c";
	private $asPriceLevel = "pl";
	private $asAccountType = "act";
	public function search(CustomerExtendVo $customerExtendVo) {
		try {
			$query = "SELECT ".$this->asCustomer.".*, " 
					. $this->asAccountType . ".`name` account_type_name, " 
					. $this->asPriceLevel . ".`name` price_level_name, " 
					. "ct.name as customer_type_name "		
					. " FROM customer ".$this->asCustomer
					. " LEFT JOIN account_type ".$this->asAccountType ." ON ".$this->asAccountType . ".`id` = " . $this->asCustomer . ".account_type_id " 
					. " LEFT JOIN price_level ".$this->asPriceLevel ." ON ".$this->asPriceLevel . ".`id` = " . $this->asCustomer . ".price_level_id "
					. " LEFT JOIN customer_type ct ON ct.id = c.customer_type_id"
					. $this->buildCondition($customerExtendVo) 
					. $this->buildPaging($customerExtendVo);
					return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(CustomerExtendVo $customerExtendVo) {
		try {
			$query = "SELECT count(".$this->asCustomer.".`id`) from customer ".$this->asCustomer
			. $this->buildCondition($customerExtendVo);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($customerExtendVo){
		$endQuery = "";
		$objInfo = get_object_vars($customerExtendVo);
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asCustomer.".".$objInfo['order_by'];
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
	
	private function buildCondition($customerExtendVo){
		$queryBuilder = new QueryBuilder( $customerExtendVo, "" );
		$queryBuilder
			->appendCondition ( "`id`", "id")
			->appendCondition ( "`first_name`", "firstName", "like", false,":PARAM_BOTH_LIKE")
			->appendCondition ( "`last_name`", "lastName", "like", false, ":PARAM_BOTH_LIKE")
			->appendCondition ( "`email`", "email", "like", false, ":PARAM_BOTH_LIKE")
			->appendCondition ( "`price_level_id`", "priceLevelId")
			->appendCondition ( "`account_type_id`", "accountTypeId");
		$where = $queryBuilder->getSql();
		
		$condition = " where 1=1 ";
		$objInfo = get_object_vars($customerExtendVo);
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .= " AND ".$this->asCustomer.".`id` = #{id}";
		}
		if(!AppUtil::isEmptyString($objInfo['firstName'])){
			$condition .= " AND ".$this->asCustomer.".`first_name` LIKE #{firstName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['lastName'])){
			$condition .= " AND ".$this->asCustomer.".`last_name` LIKE #{lastName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['email'])){
			$condition .= " AND ".$this->asCustomer.".`email` LIKE #{email:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['companyName'])){
			$condition .= " AND ".$this->asCustomer.".`company_name` LIKE #{companyName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['registrationNo'])){
			$condition .= " AND ".$this->asCustomer.".`registration_no` LIKE #{registrationNo:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['priceLevelId'])){
			$condition .= " AND ".$this->asCustomer.".`price_level_id` = #{priceLevelId}";
		}
		if(!AppUtil::isEmptyString($objInfo['accountTypeId'])){
			$condition .= " AND ".$this->asCustomer.".`account_type_id` = #{accountTypeId}";
		}
		return $condition;
	}
	
	public function deleteChangePass(CustomerChangePasswordVo $customerChangePassVo) {
		try {
			$query = "delete from `customer_change_password`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`customer_change_password`", $query, BatchVo::class, "where customer_id = #{customerId}");
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
}