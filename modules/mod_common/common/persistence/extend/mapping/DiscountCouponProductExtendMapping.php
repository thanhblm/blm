<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\DiscountCouponProductExtendVo;
use core\database\SqlStatementInfo;

class DiscountCouponProductExtendMapping {
	public function getByFilter(DiscountCouponProductExtendVo $discountCouponExtendVo) {
		try {
			$query = "select 
						dcp.*,
					    pc.name
					from discount_coupon_product dcp
					inner join 
						(select id as item_id, name, 0 as item_type from category
							union
						select id as item_id, name, 1 as item_type from product
					    ) pc on pc.item_type = dcp.item_type and pc.item_id = dcp.item_id
					where dcp.discount_coupon_id = #{discountCouponId}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, DiscountCouponProductExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}