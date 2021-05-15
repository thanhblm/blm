<?php
namespace common\persistence\extend\mapping;

use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\utils\SqlMappingUtil;
use common\persistence\extend\vo\TaxShippingZoneInfoExtendVo;

class TaxShippingZoneInfoExtendMapping  {
	public function getByFilter(TaxShippingZoneInfoExtendVo $taxShippingZoneInfoExtendVo) {
		try {
			$query = "select info.id,info.state_id,info.country_id,s.name as state_name,c.name as country_name 
					from tax_shipping_zone_info info 
					left join state s on s.id= info.state_id
					left join country c on c.id= info.country_id
					";
			// Set dynamic condition.
			$condition = SqlMappingUtil::buildCondition ( $taxShippingZoneInfoExtendVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set dynamic condition.
			
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, TaxShippingZoneInfoExtendVo::class );
		} catch ( \Exception $e ) {
		}
	}
	
}