<?php

namespace common\persistence\extend\mapping;

use common\filter\shipping\ShippingFilter;
use common\model\ShippingMethodMo;
use common\persistence\base\mapping\ShippingMethodMapping;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class ShippingMethodExtendMapping extends ShippingMethodMapping {
	private $asShippingMethod = "s";
	public function search(ShippingFilter $filter) {
		try {
			$query = "SELECT " . $this->asShippingMethod . ".* " . "FROM shipping_method " . $this->asShippingMethod . $this->buildCondition ( $filter ) . $this->buildPaging ( $filter );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ShippingMethodMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(ShippingFilter $filter) {
		try {
			$query = "SELECT count(" . $this->asShippingMethod . ".id) from shipping_method " . $this->asShippingMethod . $this->buildCondition ( $filter );
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ShippingMethodMo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	private function buildPaging($filter) {
		$endQuery = "";
		$objInfo = get_object_vars ( $filter );
		
		if (! AppUtil::isEmptyString ( $objInfo ['order_by'] )) {
			$endQuery = $endQuery . " order by " . $this->asShippingMethod . "." . $objInfo ['order_by'];
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
	private function buildCondition($filter) {
		$condition = " where 1=1 ";
		$objInfo = get_object_vars ( $filter );
		if (! AppUtil::isEmptyString ( $objInfo ['id'] )) {
			$condition .= " AND " . $this->asShippingMethod . ".id = #{id}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['name'] )) {
			$condition .= " AND " . $this->asShippingMethod . ".name LIKE #{name:PARAM_BOTH_LIKE}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['description'] )) {
			$condition .= " AND " . $this->asShippingMethod . ".description LIKE #{description:PARAM_BOTH_LIKE}";
		}
		if (! AppUtil::isEmptyString ( $objInfo ['status'] )) {
			$condition .= " AND " . $this->asShippingMethod . ".status = #{status}";
		}
		return $condition;
	}
}