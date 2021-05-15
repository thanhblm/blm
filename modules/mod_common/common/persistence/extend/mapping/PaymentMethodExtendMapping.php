<?php

namespace common\persistence\extend\mapping;

use common\filter\payment\PaymentFilter;
use common\model\PaymentMethodMo;
use common\persistence\base\mapping\PaymentMethodMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class PaymentMethodExtendMapping extends PaymentMethodMapping{
	private $asPaymentMethod = "p";
	public function search(PaymentFilter $filter) {
		try {
			$query = "SELECT ".$this->asPaymentMethod.".* from payment_method ".$this->asPaymentMethod
						. $this->buildCondition($filter) 
						. $this->buildPaging($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PaymentMethodMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function searchCount(PaymentFilter $filter) {
		try {
			$query = "SELECT count(".$this->asPaymentMethod.".id) from payment_method ".$this->asPaymentMethod
						. $this->buildCondition($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PaymentMethodMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);
	
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asPaymentMethod.".".$objInfo['order_by'];
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
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .= " AND ".$this->asPaymentMethod.".id = #{id}";
		}
		if(!AppUtil::isEmptyString($objInfo['name'])){
			$condition .= " AND ".$this->asPaymentMethod.".name LIKE #{name:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['description'])){
			$condition .= " AND ".$this->asPaymentMethod.".description LIKE #{description:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['status'])){
			$condition .= " AND ".$this->asPaymentMethod.".status = #{status}";
		}
		return $condition;
	}
	
}