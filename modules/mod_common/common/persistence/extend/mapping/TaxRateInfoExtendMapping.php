<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\TaxRateInfoMapping;
use common\persistence\extend\vo\TaxRateInfoExtendVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use common\persistence\base\vo\TaxRateInfoVo;

class TaxRateInfoExtendMapping extends TaxRateInfoMapping{
	private $asTaxRateInfo = "tri";
	private $asTaxShippingZone = "tsz";
	
	public function selectByFilterWithPriority(TaxRateInfoExtendVo $taxRateInfoExtendVo){
		try{
			
		$query = "
					SELECT tri.* FROM tax_rate_info as  tri
					JOIN (
					select MIN(priority) as priority, `type`, zone_match, tax_shipping_zone_id, tax_rate_id, id, `name` from tax_rate_info
					group by `type`,zone_match,tax_shipping_zone_id
					) as tmp ON tri.tax_shipping_zone_id = tmp.tax_shipping_zone_id
									AND tri.zone_match = tmp.zone_match
									AND tri.type = tmp.type
									AND tri.priority = tmp.priority
				" . $this->buildCondition($taxRateInfoExtendVo);
				return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	public function search(TaxRateInfoExtendVo $taxRateInfoExtendVo) {
		try {
			$query = "SELECT ".$this->asTaxRateInfo.".*, "
						. $this->asTaxShippingZone .".`name` shipping_zone_name "
						. " FROM tax_rate_info " . $this->asTaxRateInfo
						. " LEFT JOIN tax_shipping_zone ". $this->asTaxShippingZone
						. " ON " .$this->asTaxRateInfo. ".tax_shipping_zone_id = ". $this->asTaxShippingZone.".id "
						. $this->buildCondition($taxRateInfoExtendVo) 
						. $this->buildPaging($taxRateInfoExtendVo);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateInfoExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function deleteWithTaxRateId(TaxRateInfoVo $taxRateInfoExtendVo) {
		try {
			$query = "delete from tax_rate_info where tax_rate_id = #{taxRateId:PARAM_INT} ";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, TaxRateInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(TaxRateInfoExtendVo $taxRateInfoExtendVo) {
		try {
			$query = "SELECT count(".$this->asTaxRateInfo.".`id`) from tax_rate_info ".$this->asTaxRateInfo
						. $this->buildCondition($taxRateInfoExtendVo);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateInfoExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	
	private function buildPaging($taxRateInfoExtendVo){
		$endQuery = "";
		$objInfo = get_object_vars($taxRateInfoExtendVo);
		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by ".$this->asTaxRateInfo.".".$objInfo['order_by'];
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
	
	private function buildCondition($taxRateInfoExtendVo){
		$condition = " where 1=1 ";
		$objInfo = get_object_vars($taxRateInfoExtendVo);
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .= " AND ".$this->asTaxRateInfo.".`id` = #{id}";
		}
		if(!AppUtil::isEmptyString($objInfo['name'])){
			$condition .= " AND ".$this->asTaxRateInfo.".`name` LIKE #{name:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['taxRateId'])){
			$condition .= " AND ".$this->asTaxRateInfo.".`tax_rate_id` = #{taxRateId}";
		}else {
			$condition .= " AND ".$this->asTaxRateInfo.".`tax_rate_id` = null";
		}
		return $condition;
	}
	
}