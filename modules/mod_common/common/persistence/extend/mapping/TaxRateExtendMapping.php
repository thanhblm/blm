<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\TaxRateMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use common\persistence\extend\vo\TaxRateExtendVo;
use common\persistence\base\vo\TaxRateVo;
use common\persistence\extend\vo\ShippingZoneTaxInfoVo;

class TaxRateExtendMapping extends TaxRateMapping {
	private $asTaxRate = "t";
	private $asTaxRateInfo = "tf";
	public function search(TaxRateExtendVo $taxRateExendVo) {
		try {
			$query = " select *, " . $this->asTaxRateInfo . ".records as count_tax_info from tax_rate " . $this->asTaxRate . " left join
						(select tax_rate_id, count(tax_rate_id) as records from tax_rate_info
						group by tax_rate_id
						) as " . $this->asTaxRateInfo . " " . " ON " . $this->asTaxRateInfo . ".tax_rate_id = " . $this->asTaxRate . ".id " . $this->buildCondition ( $taxRateExendVo ) . $this->buildPaging ( $taxRateExendVo );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(TaxRateExtendVo $taxRateExendVo) {
		try {
			$query = "SELECT count(" . $this->asTaxRate . ".`id`) from tax_rate " . $this->asTaxRate . $this->buildCondition ( $taxRateExendVo );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxRateExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	private function buildPaging($taxRateExendVo) {
		$endQuery = "";
		$objInfo = get_object_vars ( $taxRateExendVo );
		if (! AppUtil::isEmptyString ( $objInfo ['order_by'] )) {
			$endQuery = $endQuery . " order by " . $objInfo ['order_by'];
		}
		if (! AppUtil::isEmptyString ( $objInfo ['start_record'] )) {
			if (! AppUtil::isEmptyString ( $objInfo ['end_record'] )) {
				$endQuery = $endQuery . " LIMIT  #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			} else {
				$endQuery = $endQuery . " LIMIT #{start_record:PARAM_INT}";
			}
		}
		return $endQuery;
	}
	private function buildCondition($taxRateExendVo) {
		$condition = " where 1=1 ";
		$objInfo = get_object_vars ( $taxRateExendVo );
		if (! AppUtil::isEmptyString ( $objInfo ['crDateFrom'] )) {
			$condition .= " AND " . $this->asTaxRate . ".cr_date >= #{crDateFrom}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['crDateTo'] )) {
			$condition .= " AND " . $this->asTaxRate . ".cr_date <= #{crDateTo}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['mdDateFrom'] )) {
			$condition .= " AND " . $this->asTaxRate . ".md_date >= #{mdDateFrom}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['mdDateTo'] )) {
			$condition .= " AND " . $this->asTaxRate . ".md_date <= #{mdDateTo}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['id'] )) {
			$condition .= " AND " . $this->asTaxRate . ".`id` = #{id}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['name'] )) {
			$condition .= " AND " . $this->asTaxRate . ".`name` LIKE #{name:PARAM_BOTH_LIKE}";
		}
		return $condition;
	}
	public function getTaxRateByClass(TaxRateVo $taxRateVo) {
		try {
			$query = "
				select 
					ti.*,
					sz.name as tax_shipping_zone_name,
				    sz.exclusive,
				    zi.country_id,
				    zi.state_id
				from tax_rate_info ti
				inner join 
					(select tax_shipping_zone_id, zone_match, min(priority) as priority from tax_rate_info
					where tax_rate_id = #{id}
				    group by tax_shipping_zone_id, zone_match
				    ) m on m.priority = ti.priority
						and m.tax_shipping_zone_id = ti.tax_shipping_zone_id
				        and m.zone_match = ti.zone_match
				inner join tax_shipping_zone sz on sz.id = ti.tax_shipping_zone_id
				inner join tax_shipping_zone_info zi on zi.tax_shipping_zone_id = sz.id
				where ti.tax_rate_id = #{id}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ShippingZoneTaxInfoVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}