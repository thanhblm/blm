<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\CustomerVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class CustomerMapping {
	final public function selectByKey(CustomerVo $customerVo) {
		try {
			$query = "select * from `customer` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, CustomerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(CustomerVo $customerVo = null) {
		try {
			$query = "select * from `customer`";
			$queryBuilder = new QueryBuilder ( $customerVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(CustomerVo $customerVo) {
		try {
			$query = "select * from `customer`";
			$queryBuilder = new QueryBuilder ( $customerVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`user_name`", "userName")
				->appendCondition ( "`password`", "password")
				->appendCondition ( "`first_name`", "firstName")
				->appendCondition ( "`last_name`", "lastName")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`price_level_id`", "priceLevelId")
				->appendCondition ( "`account_type_id`", "accountTypeId")
				->appendCondition ( "`customer_type_id`", "customerTypeId")
				->appendCondition ( "`company_name`", "companyName")
				->appendCondition ( "`registration_no`", "registrationNo")
				->appendCondition ( "`reseller_cert_no`", "resellerCertNo")
				->appendCondition ( "`vat_no`", "vatNo")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`fax`", "fax")
				->appendCondition ( "`sale_rep_id`", "saleRepId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`default_shipping_address_id`", "defaultShippingAddressId")
				->appendCondition ( "`default_billing_address_id`", "defaultBillingAddressId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(CustomerVo $customerVo = null) {
		try {
			$query = "select count(*) from `customer`";
			$queryBuilder = new QueryBuilder ( $customerVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`user_name`", "userName")
				->appendCondition ( "`password`", "password")
				->appendCondition ( "`first_name`", "firstName")
				->appendCondition ( "`last_name`", "lastName")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`price_level_id`", "priceLevelId")
				->appendCondition ( "`account_type_id`", "accountTypeId")
				->appendCondition ( "`customer_type_id`", "customerTypeId")
				->appendCondition ( "`company_name`", "companyName")
				->appendCondition ( "`registration_no`", "registrationNo")
				->appendCondition ( "`reseller_cert_no`", "resellerCertNo")
				->appendCondition ( "`vat_no`", "vatNo")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`fax`", "fax")
				->appendCondition ( "`sale_rep_id`", "saleRepId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`default_shipping_address_id`", "defaultShippingAddressId")
				->appendCondition ( "`default_billing_address_id`", "defaultBillingAddressId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), CustomerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(CustomerVo $customerVo) {
		try {
			$query = "insert into `customer`";
			$queryBuilder = new InsertBuilder ( $customerVo, $query );
			$queryBuilder
				->appendField("`user_name`", "userName")
				->appendField("`password`", "password")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`email`", "email")
				->appendField("`price_level_id`", "priceLevelId")
				->appendField("`account_type_id`", "accountTypeId")
				->appendField("`customer_type_id`", "customerTypeId")
				->appendField("`company_name`", "companyName")
				->appendField("`registration_no`", "registrationNo")
				->appendField("`reseller_cert_no`", "resellerCertNo")
				->appendField("`vat_no`", "vatNo")
				->appendField("`phone`", "phone")
				->appendField("`fax`", "fax")
				->appendField("`sale_rep_id`", "saleRepId")
				->appendField("`language_code`", "languageCode")
				->appendField("`default_shipping_address_id`", "defaultShippingAddressId")
				->appendField("`default_billing_address_id`", "defaultBillingAddressId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`customer`", $queryBuilder->getSql (), CustomerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(CustomerVo $customerVo) {
		try {
			$query = "insert into `customer`";
			$queryBuilder = new InsertBuilder ( $customerVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`user_name`", "userName")
				->appendField("`password`", "password")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`email`", "email")
				->appendField("`price_level_id`", "priceLevelId")
				->appendField("`account_type_id`", "accountTypeId")
				->appendField("`customer_type_id`", "customerTypeId")
				->appendField("`company_name`", "companyName")
				->appendField("`registration_no`", "registrationNo")
				->appendField("`reseller_cert_no`", "resellerCertNo")
				->appendField("`vat_no`", "vatNo")
				->appendField("`phone`", "phone")
				->appendField("`fax`", "fax")
				->appendField("`sale_rep_id`", "saleRepId")
				->appendField("`language_code`", "languageCode")
				->appendField("`default_shipping_address_id`", "defaultShippingAddressId")
				->appendField("`default_billing_address_id`", "defaultBillingAddressId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`customer`", $queryBuilder->getSql (), CustomerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(CustomerVo $customerVo) {
		try {
			$query = "update `customer`";
			$queryBuilder = new UpdateBuilder ( $customerVo, $query );
			$queryBuilder
				->appendField("`user_name`", "userName")
				->appendField("`password`", "password")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`email`", "email")
				->appendField("`price_level_id`", "priceLevelId")
				->appendField("`account_type_id`", "accountTypeId")
				->appendField("`customer_type_id`", "customerTypeId")
				->appendField("`company_name`", "companyName")
				->appendField("`registration_no`", "registrationNo")
				->appendField("`reseller_cert_no`", "resellerCertNo")
				->appendField("`vat_no`", "vatNo")
				->appendField("`phone`", "phone")
				->appendField("`fax`", "fax")
				->appendField("`sale_rep_id`", "saleRepId")
				->appendField("`language_code`", "languageCode")
				->appendField("`default_shipping_address_id`", "defaultShippingAddressId")
				->appendField("`default_billing_address_id`", "defaultBillingAddressId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`customer`", $queryBuilder->getSql (), CustomerVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(CustomerVo $customerVo) {
		try {
			$query = "delete from `customer`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`customer`", $query, CustomerVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}