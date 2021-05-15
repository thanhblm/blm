<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\RegionPaymentMethodVo;
use core\database\SqlStatementInfo;
use common\persistence\base\vo\RegionVo;
use common\persistence\extend\vo\RegionPaymentMethodExtendVo;

class RegionPaymentMethodExtendMapping {
	public function deleteRegionPaymentMethodByFilter(RegionPaymentMethodVo $regionPaymentMethodVo = null) {
		try {
			$query = "delete from `region_payment_method`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, RegionPaymentMethodVo::class, "where region_id = #{regionId}" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getPaymentMethodByRegion(RegionVo $regionVo) {
		try {
			$query = "
				select
					rpm.id,
					ifnull(rpm.payment_method_id,pm.id) as payment_method_id,
					pm.name as payment_method_name,
					rpm.region_id,
					ifnull(rpm.status,'inactive') as status,
					rpm.setting_info
				from payment_method pm
				left join region_payment_method rpm on rpm.payment_method_id = pm.id and rpm.region_id = #{id}
				where pm.status = 'active'";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionPaymentMethodExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}