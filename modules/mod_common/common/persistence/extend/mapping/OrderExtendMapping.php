<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\ErdtExportVo;
use common\persistence\extend\vo\OrderExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;
use common\persistence\base\vo\CustomerVo;
use core\database\QueryHelper;
use common\persistence\base\vo\OrderVo;

class OrderExtendMapping {
	public function getByFilter(OrderExtendVo $orderExtendVo){ // echo "<pre>";print_r($orderExtendVo);echo "</pre>";
		try {
			$query = " SELECT
						o.*,
						ot.value AS grand_total_amount
				FROM `order` o
				LEFT JOIN `order_shiping_info` osi on osi.order_id = o.id
				LEFT JOIN `order_total` ot ON o.id = ot.order_id AND ot.title = 'Total'";
			$queryBuilder = new QueryBuilder ($orderExtendVo, $query);
			$queryBuilder->appendCondition("o.id", "id", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.bill_country_code", "billCountryCode");
			$queryBuilder->appendCondition("o.ship_country_code", "shipCountryCode");
			$queryBuilder->appendCondition("o.order_status_id", "orderStatusId");
			$queryBuilder->appendCondition("o.shipping_status_id", "shippingStatusId");
			$queryBuilder->appendCondition("o.payment_method", "paymentMethod", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.date", "dateFrom", ">=");
			$queryBuilder->appendCondition("o.date", "dateTo", "<=");
			$queryBuilder->appendCondition("o.admin_comment", "adminComment", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_comment", "customerComment", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.invoice_comment", "invoiceComment", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.mega_id", "megaId", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_firstname", "customerFirstname", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_lastname", "customerLastname", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_email", "customerEmail", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.price_level", "priceLevel", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.coupon_code", "couponCode", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("ot.`value`", "grandTotalFrom", ">=");
			$queryBuilder->appendCondition("ot.`value`", "grandTotalTo", "<=");
			$queryBuilder->appendCondition ( "osi.ship_by", "shipBy" );
			if ($orderExtendVo->isUSA == 1) {
				$queryBuilder->appendCondition("o.ship_country_code", "usaFilter");
			} elseif ($orderExtendVo->isUSA == 2) {
				$queryBuilder->appendCondition("o.ship_country_code", "usaFilter", "<>");
			}
			$queryBuilder->appendOrder();
			$queryBuilder->appendLimit();
			$query = $queryBuilder->getSql();
			$sql = "select
			o.*,
			sc.name as ship_country,
			bc.name as bill_country,
			osi.ship_by,
			osi.ship_date,
			osi.tracking_code,
			IFNULL(orf.refund_amount,0) as refund_amount
			from ($query) o
			left join `country` sc on sc.iso2 = o.ship_country_code
			left join `country` bc on bc.iso2 = o.bill_country_code
			left join `order_shiping_info` osi on osi.order_id = o.id
			left join (select order_id,sum(amount) as refund_amount from `order_refund` group by order_id) as orf on orf.order_id = o.id
			" . QueryHelper::order($orderExtendVo);

			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $sql, OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCountByFilter(OrderExtendVo $orderExtendVo = null){
		try {
			$query = "SELECT count(*)
						FROM `order` o
						LEFT JOIN `order_shiping_info` osi on osi.order_id = o.id
						LEFT JOIN `order_total` ot ON o.id = ot.order_id AND ot.title = 'Total'";
			$queryBuilder = new QueryBuilder ($orderExtendVo, $query);
			$queryBuilder->appendCondition("o.id", "id", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.bill_country_code", "billCountryCode");
			$queryBuilder->appendCondition("o.ship_country_code", "shipCountryCode");
			$queryBuilder->appendCondition("o.order_status_id", "orderStatusId");
			$queryBuilder->appendCondition("o.shipping_status_id", "shippingStatusId");
			$queryBuilder->appendCondition("o.payment_method", "paymentMethod", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.date", "dateFrom", ">=");
			$queryBuilder->appendCondition("o.date", "dateTo", "<=");
			$queryBuilder->appendCondition("o.admin_comment", "adminComment", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_comment", "customerComment", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.invoice_comment", "invoiceComment", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.mega_id", "megaId", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_firstname", "customerFirstname", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_lastname", "customerLastname", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.customer_email", "customerEmail", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.price_level", "priceLevel", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("o.coupon_code", "couponCode", "like", false, ":PARAM_BOTH_LIKE");
			$queryBuilder->appendCondition("ot.`value`", "grandTotalFrom", ">=");
			$queryBuilder->appendCondition("ot.`value`", "grandTotalTo", "<=");
			$queryBuilder->appendCondition ( "osi.ship_by", "shipBy" );
			if ($orderExtendVo->isUSA == 1) {
				$queryBuilder->appendCondition("o.ship_country_code", "usaFilter");
			} elseif ($orderExtendVo->isUSA == 2) {
				$queryBuilder->appendCondition("o.ship_country_code", "usaFilter", "<>");
			}
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getOrderByKey(OrderExtendVo $orderExtendVo = null){
		try {
			$query = " SELECT
						o.*,
						ot.value AS grand_total_amount
				FROM `order` o
				LEFT JOIN `order_total` ot ON o.id = ot.order_id AND ot.title = 'Total'";
			$queryBuilder = new QueryBuilder ($orderExtendVo, $query);
			$queryBuilder->appendCondition("o.id", "id");
			$query = $queryBuilder->getSql();
			$sql = "select
			o.*,
			sc.name as ship_country,
			bc.name as bill_country,
			ss.name as ship_state,
			bs.name as bill_state,
			osi.ship_by,
			osi.ship_date,
			os.name as order_status_name,
			sst.name as shipping_status_name,
			r.name as region_name,
			cur.symbol as currency_symbol,
			osi.tracking_code,l.name as language_name,
			pm.id as payment_method_id
			from ($query) o
			left join `country` sc on sc.iso2 = o.ship_country_code
			left join `country` bc on bc.iso2 = o.bill_country_code
			left join `order_shiping_info` osi on osi.order_id = o.id
			left join `region` r on r.id = o.region_id
			left join `currency` cur on cur.code = r.currency_code
			left join `state` ss on sc.iso2 = ss.country_iso and ss.iso2 = o.ship_state_code
			left join `state` bs on bc.iso2 = bs.country_iso and bs.iso2 = o.bill_state_code
			left join `order_status` os on os.id = o.order_status_id
			left join `shipping_status` sst on sst.id = o.shipping_status_id
			left join `language` l on l.code = o.language_code
			left join `payment_method` pm on pm.name = o.payment_method
			";
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $sql, OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getOrdersByCustomerSalesRep(CustomerVo $customerVo){
		try {
			$sql = "SELECT o.*,
				os.name AS order_status_name,
				cur.symbol AS currency_symbol,
				sc.name AS ship_country,
				bc.name AS bill_country,
				st.name AS shipState,
				ot.value AS grand_total_amount
			 FROM
			(SELECT * FROM `order` o
				WHERE o.customer_id IN (SELECT id FROM customer WHERE sale_rep_id = #{id}) ) o
			    INNER JOIN `order_status` os ON os.id = o.order_status_id
				INNER JOIN `order_total` ot ON o.id = ot.order_id AND ot.title = 'Total'
				LEFT JOIN country sc ON sc.iso2 = o.ship_country_code
				LEFT JOIN `state` st ON sc.iso2 = st.country_iso AND st.iso2 = o.ship_state_code
				LEFT JOIN country bc ON bc.iso2 = o.bill_country_code
				LEFT JOIN region r ON r.id = o.region_id
				LEFT JOIN `currency` cur ON cur.code = r.currency_code ORDER BY `id` DESC";

			$queryBuilder = new QueryBuilder ($customerVo, $sql);
			$queryBuilder->appendLimit();
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCountOrdersByCustomerSalesRep(CustomerVo $customerVo){
		try {
			$query = "SELECT count(o.id)
			FROM `order` o WHERE o.customer_id IN (SELECT id FROM customer WHERE sale_rep_id = #{id})";
			$queryBuilder = new QueryBuilder ($customerVo, $query);
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getOrdersByCustomer(OrderVo $orderVo){
		try {

			$sql = "SELECT o.*,
				os.name AS order_status_name,
				cur.symbol AS currency_symbol,
				sc.name AS ship_country,
				bc.name AS bill_country,
				st.name AS shipState,
				ot.value AS grand_total_amount
			 FROM
			(SELECT * FROM `order` o
			WHERE customer_id = #{customerId} ) o
			    INNER JOIN `order_status` os ON os.id = o.order_status_id
				INNER JOIN `order_total` ot ON o.id = ot.order_id AND ot.title = 'Total'
				LEFT JOIN country sc ON sc.iso2 = o.ship_country_code
				LEFT JOIN `state` st ON sc.iso2 = st.country_iso AND st.iso2 = o.ship_state_code
				LEFT JOIN country bc ON bc.iso2 = o.bill_country_code
				LEFT JOIN region r ON r.id = o.region_id
				LEFT JOIN `currency` cur ON cur.code = r.currency_code";

			$queryBuilder = new QueryBuilder ($orderVo, $sql);
			$queryBuilder->appendOrder();
			$queryBuilder->appendLimit();
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCountOrdersByCustomer(OrderVo $orderVo){
		try {
			$query = "SELECT count(o.id)
			FROM `order` o WHERE o.customer_id = #{customerId}" ;
			$queryBuilder = new QueryBuilder ($orderVo, $query);
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
	
	public function getCountOrdersByCustomerAndCouponCode(OrderVo $orderVo){
		try {
			$query = "SELECT count(o.id)
			FROM `order` o WHERE o.customer_id = #{customerId} AND coupon_code = #{couponCode} AND (order_status_id = 1 or order_status_id = 2)";
			$queryBuilder = new QueryBuilder ($orderVo, $query);
			return new SqlStatementInfo (SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), OrderExtendVo::class);
		} catch (\Exception $e) { 
			throw $e;
		}
	}

	public function getErdtNonShippedOrders(OrderExtendVo $orderExtendVo){
		try {
			$query = "SELECT 
			    o.*,
			    op.product_id,
			    op.quantity AS product_quantity,
			    op.base_price,
			    CONCAT(ship_first_name, ' ', ship_last_name) AS ship_name,
			    CONCAT(bill_first_name, ' ', bill_last_name) AS bill_name,
			    DATE_FORMAT(cr_date, '%d.%m.%Y') AS order_date,
			    cs.name AS ship_country_name,
			    cb.name AS bill_country_name
			FROM
			    `order` o
			        INNER JOIN
			    `order_shiping_info` os ON os.order_id = o.id
			        INNER JOIN
			    `order_product` op ON op.order_id = o.id
			        LEFT JOIN
			    `country` AS cs ON cs.iso2 = o.ship_country_code
			        LEFT JOIN
			    `country` AS cb ON cb.iso2 = o.bill_country_code
			WHERE
			    os.ship_by = 'erdt'
			        AND (ISNULL(ship_date) OR ship_date = '')";
			$queryBuilder = new QueryBuilder($orderExtendVo, $query);
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ErdtExportVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCountErdtNonShippedOrders(){
		try {
			$query = "SELECT 
					    count(*)
					FROM
					    `order` o
					        INNER JOIN
					    `order_shiping_info` os ON os.order_id = o.id
					        INNER JOIN
					    `order_product` op ON op.order_id = o.id
					        LEFT JOIN
					    `country` AS cs ON cs.iso2 = o.ship_country_code
					        LEFT JOIN
					    `country` AS cb ON cb.iso2 = o.bill_country_code
					WHERE
					    os.ship_by = 'erdt'
					        AND (ISNULL(ship_date) OR ship_date = '')";
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $query, ErdtExportVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getReservedShippedOrders(OrderExtendVo $orderExtendVo){
		try {
			$query = "SELECT 
			    o.*,
			    CONCAT(ship_first_name, ' ', ship_last_name) AS ship_name,
			    CONCAT(bill_first_name, ' ', bill_last_name) AS bill_name,
			    DATE_FORMAT(cr_date, '%d.%m.%Y') AS order_date,
			    cs.name AS ship_country_name,
			    cb.name AS bill_country_name
			FROM
			    `order` o
			        LEFT JOIN
			    `country` AS cs ON cs.iso2 = o.ship_country_code
			        LEFT JOIN
			    `country` AS cb ON cb.iso2 = o.bill_country_code
			WHERE
			    o.shipping_status_id = 3
			    AND ship_country_code != 'US'";
			$queryBuilder = new QueryBuilder($orderExtendVo, $query);
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ErdtExportVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCountReservedShippedOrders(){
		try {
			$query = "SELECT 
					    count(*)
					FROM
			    `order` o
			        LEFT JOIN
			    `country` AS cs ON cs.iso2 = o.ship_country_code
			        LEFT JOIN
			    `country` AS cb ON cb.iso2 = o.bill_country_code
                    WHERE
                        o.shipping_status_id = 3
                        AND ship_country_code != 'US'";
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $query, ErdtExportVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function getPendingOrders(OrderExtendVo $orderExtendVo){
		try {
			$query = "SELECT 
					    o.id,
						p.id as payment_method_id,
					    payment_method,
					    cr_date,
					    TIMESTAMPDIFF(HOUR, cr_date, NOW()) AS pending_hour
					FROM
					    `order` as o
					    inner join payment_method as p on p.name = o.payment_method
					WHERE
					    o.cr_date >= #{startDate}
					    and o.order_status_id = 1
					ORDER BY id";
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $query, OrderExtendVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
	
	public function getPaidOrdersTwoWeeksAgo() {
		try {
			$query = "SELECT 
					    *
					FROM
					    `order`
					WHERE
						order_status_id = 2
						and trustpilot_sent = 'no'
					    and now() < DATE_ADD(md_date,interval 14 day)
					ORDER BY md_date DESC";
			return new SqlStatementInfo(SqlStatementInfo::SELECT, null, $query, OrderVo::class);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}