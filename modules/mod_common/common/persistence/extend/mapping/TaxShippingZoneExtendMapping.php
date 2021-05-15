<?php
namespace common\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\utils\SqlMappingUtil;
use common\persistence\extend\vo\TaxShippingZoneExtendVo;

class TaxShippingZoneExtendMapping  {
	private function getCondition(TaxShippingZoneExtendVo $taxShippingZoneExtendVo) {
		$condition = SqlMappingUtil::buildCondition ( $taxShippingZoneExtendVo );
		$condition = str_replace ( " = #{name}", " like #{name:PARAM_BOTH_LIKE}", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $taxShippingZoneExtendVo, "os.cr_date", "crDateFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $taxShippingZoneExtendVo, "os.cr_date", "crDateTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $taxShippingZoneExtendVo, "os.md_date", "mdDateFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $taxShippingZoneExtendVo, "os.md_date", "mdDateTo", "<=", $condition );
		return $condition;
	}
	public function getByFilter(TaxShippingZoneExtendVo $taxShippingZoneExtendVo) {
		try {
			$query = "select os.*, 
					    cu.user_name as cr_by_name,
					    mu.user_name as md_by_name
					from `tax_shipping_zone` os
					left join `user` cu on cu.id = os.cr_by
					left join `user` mu on mu.id = os.md_by";
			// Set dynamic condition.
			$condition = $this->getCondition ( $taxShippingZoneExtendVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $taxShippingZoneExtendVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $taxShippingZoneExtendVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $taxShippingZoneExtendVo->start_record ) && isset ( $taxShippingZoneExtendVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxShippingZoneExtendVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getCountByFilter(TaxShippingZoneExtendVo $taxShippingZoneExtendVo = null) {
		try {
			$query = "select 
						count(*)
					from `tax_shipping_zone` os
					left join `user` cu on cu.id = os.cr_by
					left join `user` mu on mu.id = os.md_by";
			if (isset ( $taxShippingZoneExtendVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $taxShippingZoneExtendVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxShippingZoneExtendVo::class );
		} catch ( \Exception $e ) {
		}
	}
}