<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\extend\vo\RegionShippingMethodExtendVo;
use core\database\SqlStatementInfo;

class RegionShippingMethodExtendMapping {
	public function deleteRegionShippingMethodByFilter(RegionShippingMethodVo $regionShippingMethodVo = null) {
		try {
			$query = "delete from `region_shipping_method`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, RegionShippingMethodVo::class, "where region_id = #{regionId}" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getShippingMethodByRegion(RegionVo $regionVo) {
		try {
			$query = "
				select 
					rsm.id,
					ifnull(rsm.shipping_method_id,sm.id) as shipping_method_id,
					sm.name as shipping_method_name,
				    rsm.region_id,
				    ifnull(rsm.status,'inactive') as status,
				    rsm.setting_info
				from shipping_method sm
				left join region_shipping_method rsm on rsm.shipping_method_id = sm.id and rsm.region_id = #{id}
				where sm.status = 'active'";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, RegionShippingMethodExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}