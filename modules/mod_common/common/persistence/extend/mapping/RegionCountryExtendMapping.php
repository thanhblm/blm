<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\RegionCountryVo;
use core\database\SqlStatementInfo;

class RegionCountryExtendMapping {
	public function deleteRegionCountryByFilter(RegionCountryVo $regionCountryVo = null) {
		try {
			$query = "delete from `region_country`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, RegionCountryVo::class, "where region_id = #{regionId}" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}