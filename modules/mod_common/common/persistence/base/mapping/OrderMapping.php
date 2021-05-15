<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\OrderVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class OrderMapping {
	final public function selectByKey(OrderVo $orderVo) {
		try {
			$query = "select * from `order` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, OrderVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(OrderVo $orderVo = null) {
		try {
			$query = "select * from `order`";
			$queryBuilder = new QueryBuilder ( $orderVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(OrderVo $orderVo) {
		try {
			$query = "select * from `order`";
			$queryBuilder = new QueryBuilder ( $orderVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`mega_id`", "megaId")
				->appendCondition ( "`order_status_id`", "orderStatusId")
				->appendCondition ( "`shipping_status_id`", "shippingStatusId")
				->appendCondition ( "`currency_code`", "currencyCode")
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`payment_method`", "paymentMethod")
				->appendCondition ( "`shipping_method`", "shippingMethod")
				->appendCondition ( "`shipping_method_item`", "shippingMethodItem")
				->appendCondition ( "`date`", "date")
				->appendCondition ( "`coupon_code`", "couponCode")
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`customer_id`", "customerId")
				->appendCondition ( "`price_level`", "priceLevel")
				->appendCondition ( "`customer_firstname`", "customerFirstname")
				->appendCondition ( "`customer_lastname`", "customerLastname")
				->appendCondition ( "`customer_company`", "customerCompany")
				->appendCondition ( "`customer_company_reg_code`", "customerCompanyRegCode")
				->appendCondition ( "`customer_company_vat`", "customerCompanyVat")
				->appendCondition ( "`customer_phone`", "customerPhone")
				->appendCondition ( "`customer_email`", "customerEmail")
				->appendCondition ( "`ship_first_name`", "shipFirstName")
				->appendCondition ( "`ship_last_name`", "shipLastName")
				->appendCondition ( "`ship_email`", "shipEmail")
				->appendCondition ( "`ship_phone`", "shipPhone")
				->appendCondition ( "`ship_address`", "shipAddress")
				->appendCondition ( "`ship_city`", "shipCity")
				->appendCondition ( "`ship_zipcode`", "shipZipcode")
				->appendCondition ( "`ship_state_code`", "shipStateCode")
				->appendCondition ( "`ship_country_code`", "shipCountryCode")
				->appendCondition ( "`ship_company`", "shipCompany")
				->appendCondition ( "`ship_company_reg_code`", "shipCompanyRegCode")
				->appendCondition ( "`ship_company_vat`", "shipCompanyVat")
				->appendCondition ( "`bill_first_name`", "billFirstName")
				->appendCondition ( "`bill_last_name`", "billLastName")
				->appendCondition ( "`bill_email`", "billEmail")
				->appendCondition ( "`bill_phone`", "billPhone")
				->appendCondition ( "`bill_address`", "billAddress")
				->appendCondition ( "`bill_city`", "billCity")
				->appendCondition ( "`bill_zipcode`", "billZipcode")
				->appendCondition ( "`bill_state_code`", "billStateCode")
				->appendCondition ( "`bill_country_code`", "billCountryCode")
				->appendCondition ( "`bill_company`", "billCompany")
				->appendCondition ( "`bill_company_reg_code`", "billCompanyRegCode")
				->appendCondition ( "`bill_company_vat`", "billCompanyVat")
				->appendCondition ( "`admin_comment`", "adminComment")
				->appendCondition ( "`customer_comment`", "customerComment")
				->appendCondition ( "`invoice_comment`", "invoiceComment")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendCondition ( "`trustpilot_sent`", "trustpilotSent")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(OrderVo $orderVo = null) {
		try {
			$query = "select count(*) from `order`";
			$queryBuilder = new QueryBuilder ( $orderVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`mega_id`", "megaId")
				->appendCondition ( "`order_status_id`", "orderStatusId")
				->appendCondition ( "`shipping_status_id`", "shippingStatusId")
				->appendCondition ( "`currency_code`", "currencyCode")
				->appendCondition ( "`region_id`", "regionId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`payment_method`", "paymentMethod")
				->appendCondition ( "`shipping_method`", "shippingMethod")
				->appendCondition ( "`shipping_method_item`", "shippingMethodItem")
				->appendCondition ( "`date`", "date")
				->appendCondition ( "`coupon_code`", "couponCode")
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`customer_id`", "customerId")
				->appendCondition ( "`price_level`", "priceLevel")
				->appendCondition ( "`customer_firstname`", "customerFirstname")
				->appendCondition ( "`customer_lastname`", "customerLastname")
				->appendCondition ( "`customer_company`", "customerCompany")
				->appendCondition ( "`customer_company_reg_code`", "customerCompanyRegCode")
				->appendCondition ( "`customer_company_vat`", "customerCompanyVat")
				->appendCondition ( "`customer_phone`", "customerPhone")
				->appendCondition ( "`customer_email`", "customerEmail")
				->appendCondition ( "`ship_first_name`", "shipFirstName")
				->appendCondition ( "`ship_last_name`", "shipLastName")
				->appendCondition ( "`ship_email`", "shipEmail")
				->appendCondition ( "`ship_phone`", "shipPhone")
				->appendCondition ( "`ship_address`", "shipAddress")
				->appendCondition ( "`ship_city`", "shipCity")
				->appendCondition ( "`ship_zipcode`", "shipZipcode")
				->appendCondition ( "`ship_state_code`", "shipStateCode")
				->appendCondition ( "`ship_country_code`", "shipCountryCode")
				->appendCondition ( "`ship_company`", "shipCompany")
				->appendCondition ( "`ship_company_reg_code`", "shipCompanyRegCode")
				->appendCondition ( "`ship_company_vat`", "shipCompanyVat")
				->appendCondition ( "`bill_first_name`", "billFirstName")
				->appendCondition ( "`bill_last_name`", "billLastName")
				->appendCondition ( "`bill_email`", "billEmail")
				->appendCondition ( "`bill_phone`", "billPhone")
				->appendCondition ( "`bill_address`", "billAddress")
				->appendCondition ( "`bill_city`", "billCity")
				->appendCondition ( "`bill_zipcode`", "billZipcode")
				->appendCondition ( "`bill_state_code`", "billStateCode")
				->appendCondition ( "`bill_country_code`", "billCountryCode")
				->appendCondition ( "`bill_company`", "billCompany")
				->appendCondition ( "`bill_company_reg_code`", "billCompanyRegCode")
				->appendCondition ( "`bill_company_vat`", "billCompanyVat")
				->appendCondition ( "`admin_comment`", "adminComment")
				->appendCondition ( "`customer_comment`", "customerComment")
				->appendCondition ( "`invoice_comment`", "invoiceComment")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendCondition ( "`trustpilot_sent`", "trustpilotSent");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), OrderVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(OrderVo $orderVo) {
		try {
			$query = "insert into `order`";
			$queryBuilder = new InsertBuilder ( $orderVo, $query );
			$queryBuilder
				->appendField("`mega_id`", "megaId")
				->appendField("`order_status_id`", "orderStatusId")
				->appendField("`shipping_status_id`", "shippingStatusId")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`region_id`", "regionId")
				->appendField("`language_code`", "languageCode")
				->appendField("`payment_method`", "paymentMethod")
				->appendField("`shipping_method`", "shippingMethod")
				->appendField("`shipping_method_item`", "shippingMethodItem")
				->appendField("`date`", "date")
				->appendField("`coupon_code`", "couponCode")
				->appendField("`user_id`", "userId")
				->appendField("`customer_id`", "customerId")
				->appendField("`price_level`", "priceLevel")
				->appendField("`customer_firstname`", "customerFirstname")
				->appendField("`customer_lastname`", "customerLastname")
				->appendField("`customer_company`", "customerCompany")
				->appendField("`customer_company_reg_code`", "customerCompanyRegCode")
				->appendField("`customer_company_vat`", "customerCompanyVat")
				->appendField("`customer_phone`", "customerPhone")
				->appendField("`customer_email`", "customerEmail")
				->appendField("`ship_first_name`", "shipFirstName")
				->appendField("`ship_last_name`", "shipLastName")
				->appendField("`ship_email`", "shipEmail")
				->appendField("`ship_phone`", "shipPhone")
				->appendField("`ship_address`", "shipAddress")
				->appendField("`ship_city`", "shipCity")
				->appendField("`ship_zipcode`", "shipZipcode")
				->appendField("`ship_state_code`", "shipStateCode")
				->appendField("`ship_country_code`", "shipCountryCode")
				->appendField("`ship_company`", "shipCompany")
				->appendField("`ship_company_reg_code`", "shipCompanyRegCode")
				->appendField("`ship_company_vat`", "shipCompanyVat")
				->appendField("`bill_first_name`", "billFirstName")
				->appendField("`bill_last_name`", "billLastName")
				->appendField("`bill_email`", "billEmail")
				->appendField("`bill_phone`", "billPhone")
				->appendField("`bill_address`", "billAddress")
				->appendField("`bill_city`", "billCity")
				->appendField("`bill_zipcode`", "billZipcode")
				->appendField("`bill_state_code`", "billStateCode")
				->appendField("`bill_country_code`", "billCountryCode")
				->appendField("`bill_company`", "billCompany")
				->appendField("`bill_company_reg_code`", "billCompanyRegCode")
				->appendField("`bill_company_vat`", "billCompanyVat")
				->appendField("`admin_comment`", "adminComment")
				->appendField("`customer_comment`", "customerComment")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`trustpilot_sent`", "trustpilotSent");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order`", $queryBuilder->getSql (), OrderVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(OrderVo $orderVo) {
		try {
			$query = "insert into `order`";
			$queryBuilder = new InsertBuilder ( $orderVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`mega_id`", "megaId")
				->appendField("`order_status_id`", "orderStatusId")
				->appendField("`shipping_status_id`", "shippingStatusId")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`region_id`", "regionId")
				->appendField("`language_code`", "languageCode")
				->appendField("`payment_method`", "paymentMethod")
				->appendField("`shipping_method`", "shippingMethod")
				->appendField("`shipping_method_item`", "shippingMethodItem")
				->appendField("`date`", "date")
				->appendField("`coupon_code`", "couponCode")
				->appendField("`user_id`", "userId")
				->appendField("`customer_id`", "customerId")
				->appendField("`price_level`", "priceLevel")
				->appendField("`customer_firstname`", "customerFirstname")
				->appendField("`customer_lastname`", "customerLastname")
				->appendField("`customer_company`", "customerCompany")
				->appendField("`customer_company_reg_code`", "customerCompanyRegCode")
				->appendField("`customer_company_vat`", "customerCompanyVat")
				->appendField("`customer_phone`", "customerPhone")
				->appendField("`customer_email`", "customerEmail")
				->appendField("`ship_first_name`", "shipFirstName")
				->appendField("`ship_last_name`", "shipLastName")
				->appendField("`ship_email`", "shipEmail")
				->appendField("`ship_phone`", "shipPhone")
				->appendField("`ship_address`", "shipAddress")
				->appendField("`ship_city`", "shipCity")
				->appendField("`ship_zipcode`", "shipZipcode")
				->appendField("`ship_state_code`", "shipStateCode")
				->appendField("`ship_country_code`", "shipCountryCode")
				->appendField("`ship_company`", "shipCompany")
				->appendField("`ship_company_reg_code`", "shipCompanyRegCode")
				->appendField("`ship_company_vat`", "shipCompanyVat")
				->appendField("`bill_first_name`", "billFirstName")
				->appendField("`bill_last_name`", "billLastName")
				->appendField("`bill_email`", "billEmail")
				->appendField("`bill_phone`", "billPhone")
				->appendField("`bill_address`", "billAddress")
				->appendField("`bill_city`", "billCity")
				->appendField("`bill_zipcode`", "billZipcode")
				->appendField("`bill_state_code`", "billStateCode")
				->appendField("`bill_country_code`", "billCountryCode")
				->appendField("`bill_company`", "billCompany")
				->appendField("`bill_company_reg_code`", "billCompanyRegCode")
				->appendField("`bill_company_vat`", "billCompanyVat")
				->appendField("`admin_comment`", "adminComment")
				->appendField("`customer_comment`", "customerComment")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`trustpilot_sent`", "trustpilotSent");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`order`", $queryBuilder->getSql (), OrderVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(OrderVo $orderVo) {
		try {
			$query = "update `order`";
			$queryBuilder = new UpdateBuilder ( $orderVo, $query );
			$queryBuilder
				->appendField("`mega_id`", "megaId")
				->appendField("`order_status_id`", "orderStatusId")
				->appendField("`shipping_status_id`", "shippingStatusId")
				->appendField("`currency_code`", "currencyCode")
				->appendField("`region_id`", "regionId")
				->appendField("`language_code`", "languageCode")
				->appendField("`payment_method`", "paymentMethod")
				->appendField("`shipping_method`", "shippingMethod")
				->appendField("`shipping_method_item`", "shippingMethodItem")
				->appendField("`date`", "date")
				->appendField("`coupon_code`", "couponCode")
				->appendField("`user_id`", "userId")
				->appendField("`customer_id`", "customerId")
				->appendField("`price_level`", "priceLevel")
				->appendField("`customer_firstname`", "customerFirstname")
				->appendField("`customer_lastname`", "customerLastname")
				->appendField("`customer_company`", "customerCompany")
				->appendField("`customer_company_reg_code`", "customerCompanyRegCode")
				->appendField("`customer_company_vat`", "customerCompanyVat")
				->appendField("`customer_phone`", "customerPhone")
				->appendField("`customer_email`", "customerEmail")
				->appendField("`ship_first_name`", "shipFirstName")
				->appendField("`ship_last_name`", "shipLastName")
				->appendField("`ship_email`", "shipEmail")
				->appendField("`ship_phone`", "shipPhone")
				->appendField("`ship_address`", "shipAddress")
				->appendField("`ship_city`", "shipCity")
				->appendField("`ship_zipcode`", "shipZipcode")
				->appendField("`ship_state_code`", "shipStateCode")
				->appendField("`ship_country_code`", "shipCountryCode")
				->appendField("`ship_company`", "shipCompany")
				->appendField("`ship_company_reg_code`", "shipCompanyRegCode")
				->appendField("`ship_company_vat`", "shipCompanyVat")
				->appendField("`bill_first_name`", "billFirstName")
				->appendField("`bill_last_name`", "billLastName")
				->appendField("`bill_email`", "billEmail")
				->appendField("`bill_phone`", "billPhone")
				->appendField("`bill_address`", "billAddress")
				->appendField("`bill_city`", "billCity")
				->appendField("`bill_zipcode`", "billZipcode")
				->appendField("`bill_state_code`", "billStateCode")
				->appendField("`bill_country_code`", "billCountryCode")
				->appendField("`bill_company`", "billCompany")
				->appendField("`bill_company_reg_code`", "billCompanyRegCode")
				->appendField("`bill_company_vat`", "billCompanyVat")
				->appendField("`admin_comment`", "adminComment")
				->appendField("`customer_comment`", "customerComment")
				->appendField("`invoice_comment`", "invoiceComment")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`trustpilot_sent`", "trustpilotSent");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`order`", $queryBuilder->getSql (), OrderVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(OrderVo $orderVo) {
		try {
			$query = "delete from `order`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`order`", $query, OrderVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}