<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\PriceLevelVo;
use common\persistence\extend\vo\PriceLevelExtendVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\utils\SqlMappingUtil;

class PriceLevelExtendMapping {
	private function getCondition(PriceLevelExtendVo $priceLevelExtendVo) {
		$condition = SqlMappingUtil::buildCondition ( $priceLevelExtendVo );
		$condition = str_replace ( " = #{name}", " like #{name:PARAM_BOTH_LIKE}", $condition );
		return $condition;
	}
	public function getByFilter(PriceLevelExtendVo $priceLevelExtendVo) {
		try {
			$query = "select * from `price_level` ";
			// Set dynamic condition.
			$condition = $this->getCondition ( $priceLevelExtendVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $priceLevelExtendVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $priceLevelExtendVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $priceLevelExtendVo->start_record ) && isset ( $priceLevelExtendVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PriceLevelExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getCountByFilter(PriceLevelExtendVo $priceLevelExtendVo = null) {
		try {
			$query = "select count(*) from `price_level`";
			if (isset ( $priceLevelExtendVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $priceLevelExtendVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PriceLevelExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getPriceLevelByCustomerId(CustomerVo $customerVo) {
		try {
			$query = "
				select pl.* from `price_level` pl
				inner join `customer` c on c.price_level_id = pl.id
				where c.id = #{id}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, PriceLevelVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}