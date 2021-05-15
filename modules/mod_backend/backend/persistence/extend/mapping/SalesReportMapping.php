<?php

namespace backend\persistence\extend\mapping;

use backend\persistence\extend\vo\CountryReportVo;
use backend\persistence\extend\vo\OrderReportVo;
use backend\persistence\extend\vo\OverviewReportVo;
use backend\persistence\extend\vo\SalesReportFilterVo;
use common\persistence\base\vo\OrderProductVo;
use core\database\SqlStatementInfo;

class SalesReportMapping {
	final public function getOverviewByFilter(SalesReportFilterVo $salesReportFilterVo) {
		try {
			$query = "
				select 
					o.region_id,
				    o.order_status_id,
					o.currency_code,
				    count(o.id) as order_count,
				    sum(ot.value) as order_total
				from `order` o
				inner join order_total as ot on ot.order_id = o.id and ot.type = 'total'
				where o.date >= #{startDate} and o.date <= #{endDate}";
			if (! is_null ( $salesReportFilterVo->regionId ) && $salesReportFilterVo->regionId != "0") {
				$query .= " and o.region_id = #{regionId}";
			}
			$query .= " 
				group by region_id, order_status_id, currency_code
				order by region_id, order_status_id, currency_code";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OverviewReportVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function getOrderByFilter(SalesReportFilterVo $salesReportFilterVo) {
		try {
			$query = "
				select 
					o.id,
				    o.mega_id,
				    os.name as order_status_name,
				    ss.name as shipping_status_name,
				    o.currency_code,
				    rg.name as region_name,
				    ifnull(c.first_name,o.bill_first_name) as first_name,
				    ifnull(c.last_name,o.bill_last_name) as last_name,
				    ifnull(c.email,o.bill_email) as email,
				    ifnull(ct.name,'Guest') as customer_type,
				    ifnull(act.name,'Guest') as account_type,
				    o.shipping_method,
				    o.shipping_method_item as shipping_title,
				    ifnull(sc.name,'Unknown') as shipping_country,
				    o.payment_method,
				    ifnull(bc.name,'Unknown') as billing_country,
				    o.coupon_code,
				    tax.title as tax_title,
				    tax.value as tax_amount,
				    pro.value as product_amount,
				    ifnull(dis.value,0) as discount_amount,
				    ifnull(co.value,0) as coupon_amount,
				    ifnull(sp.value,0) as shipping_amount,
				    ot.value as total_amount,
					if(o.order_status_id=2,ot.value,0) as paid_amount,
				    o.cr_date,
				    o.md_date
				from `order` o
				left join order_status os on os.id = o.order_status_id
				left join shipping_status ss on ss.id = o.shipping_status_id
				left join region rg on rg.id = o.region_id
				left join customer c on c.id = o.customer_id
				left join customer_type ct on ct.id = c.customer_type_id
				left join account_type act on act.id = c.account_type_id
				left join country sc on sc.iso2 = o.ship_country_code
				left join country bc on bc.iso2 = o.bill_country_code
				left join order_total tax on tax.order_id = o.id and tax.type = 'taxtotal'
				left join order_total pro on pro.order_id = o.id and pro.type = 'subtotal'
				left join order_total dis on dis.order_id = o.id and dis.type = 'discount'
				left join order_total co on co.order_id = o.id and co.type = 'coupon'
				left join order_total sp on sp.order_id = o.id and sp.type = 'shipping'
				left join order_total ot on ot.order_id = o.id and ot.type = 'total'
				where o.date >= #{startDate} and o.date <= #{endDate}";
			if (! is_null ( $salesReportFilterVo->regionId ) && $salesReportFilterVo->regionId != "0") {
				$query .= " and o.region_id = #{regionId}";
			}
			$query .= " order by o.id asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderReportVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function getTopProductByFilter(SalesReportFilterVo $salesReportFilterVo) {
		try {
			$query = "
				select 
					op.product_id,
				    op.name,
				    sum(op.quantity) as quantity
				from `order` o
				inner join order_product op on op.order_id = o.id
				where o.date >= #{startDate} and o.date <= #{endDate}";
			if (! is_null ( $salesReportFilterVo->regionId ) && $salesReportFilterVo->regionId != "0") {
				$query .= " and o.region_id = #{regionId}";
			}
			$query .= "
				group by op.product_id
				order by quantity desc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderProductVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function getTopCountryFilter(SalesReportFilterVo $salesReportFilterVo) {
		try {
			$query = "
				select
					ct.id,
				    ct.iso2 as code,
				    ct.name,
					r.currency_code,
				    r.order_count,
				    r.paid_amount
				from
					(select 
						o.bill_country_code,
						o.currency_code,
						count(o.id) as order_count,
						sum(if(o.order_status_id=2,ot.value,0)) as paid_amount
					from `order` o
					inner join order_total ot on ot.order_id = o.id and ot.type = 'total'
					where o.date >= #{startDate} and o.date <= #{endDate}";
			if (! is_null ( $salesReportFilterVo->regionId ) && $salesReportFilterVo->regionId != "0") {
				$query .= " and o.region_id = #{regionId}";
			}
			$query .= "
					group by o.bill_country_code, o.currency_code
					) as r
				inner join country ct on ct.iso2 = r.bill_country_code";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CountryReportVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function getDistinctTopCountryByFilter(SalesReportFilterVo $salesReportFilterVo) {
		try {
			$query = "
				select
					ct.id,
				    ct.iso2 as code,
				    ct.name,
				    r.order_count,
				    r.paid_amount
				from
					(select
						o.bill_country_code,
						count(o.id) as order_count,
						sum(if(o.order_status_id=2,ot.value,0)) as paid_amount
					from `order` o
					inner join order_total ot on ot.order_id = o.id and ot.type = 'total'
					where o.date >= #{startDate} and o.date <= #{endDate}";
			if (! is_null ( $salesReportFilterVo->regionId ) && $salesReportFilterVo->regionId != "0") {
				$query .= " and o.region_id = #{regionId}";
			}
			$query .= "
					group by o.bill_country_code
					) as r
				inner join country ct on ct.iso2 = r.bill_country_code
				order by r.paid_amount desc, ct.name";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CountryReportVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}