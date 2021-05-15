<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AddressVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AddressMapping {
	final public function selectByKey(AddressVo $addressVo) {
		try {
			$query = "select * from `address` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AddressVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AddressVo $addressVo = null) {
		try {
			$query = "select * from `address`";
			$queryBuilder = new QueryBuilder ( $addressVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AddressVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AddressVo $addressVo) {
		try {
			$query = "select * from `address`";
			$queryBuilder = new QueryBuilder ( $addressVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`first_name`", "firstName")
				->appendCondition ( "`last_name`", "lastName")
				->appendCondition ( "`address`", "address")
				->appendCondition ( "`country`", "country")
				->appendCondition ( "`city`", "city")
				->appendCondition ( "`state`", "state")
				->appendCondition ( "`postal_code`", "postalCode")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`fax`", "fax")
				->appendCondition ( "`latitude`", "latitude")
				->appendCondition ( "`longitude`", "longitude")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`group_id`", "groupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AddressVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AddressVo $addressVo = null) {
		try {
			$query = "select count(*) from `address`";
			$queryBuilder = new QueryBuilder ( $addressVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`first_name`", "firstName")
				->appendCondition ( "`last_name`", "lastName")
				->appendCondition ( "`address`", "address")
				->appendCondition ( "`country`", "country")
				->appendCondition ( "`city`", "city")
				->appendCondition ( "`state`", "state")
				->appendCondition ( "`postal_code`", "postalCode")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`fax`", "fax")
				->appendCondition ( "`latitude`", "latitude")
				->appendCondition ( "`longitude`", "longitude")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`group_id`", "groupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AddressVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AddressVo $addressVo) {
		try {
			$query = "insert into `address`";
			$queryBuilder = new InsertBuilder ( $addressVo, $query );
			$queryBuilder
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`address`", "address")
				->appendField("`country`", "country")
				->appendField("`city`", "city")
				->appendField("`state`", "state")
				->appendField("`postal_code`", "postalCode")
				->appendField("`phone`", "phone")
				->appendField("`fax`", "fax")
				->appendField("`latitude`", "latitude")
				->appendField("`longitude`", "longitude")
				->appendField("`email`", "email")
				->appendField("`type`", "type")
				->appendField("`group_id`", "groupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`address`", $queryBuilder->getSql (), AddressVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AddressVo $addressVo) {
		try {
			$query = "insert into `address`";
			$queryBuilder = new InsertBuilder ( $addressVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`address`", "address")
				->appendField("`country`", "country")
				->appendField("`city`", "city")
				->appendField("`state`", "state")
				->appendField("`postal_code`", "postalCode")
				->appendField("`phone`", "phone")
				->appendField("`fax`", "fax")
				->appendField("`latitude`", "latitude")
				->appendField("`longitude`", "longitude")
				->appendField("`email`", "email")
				->appendField("`type`", "type")
				->appendField("`group_id`", "groupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`address`", $queryBuilder->getSql (), AddressVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AddressVo $addressVo) {
		try {
			$query = "update `address`";
			$queryBuilder = new UpdateBuilder ( $addressVo, $query );
			$queryBuilder
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`address`", "address")
				->appendField("`country`", "country")
				->appendField("`city`", "city")
				->appendField("`state`", "state")
				->appendField("`postal_code`", "postalCode")
				->appendField("`phone`", "phone")
				->appendField("`fax`", "fax")
				->appendField("`latitude`", "latitude")
				->appendField("`longitude`", "longitude")
				->appendField("`email`", "email")
				->appendField("`type`", "type")
				->appendField("`group_id`", "groupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`address`", $queryBuilder->getSql (), AddressVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AddressVo $addressVo) {
		try {
			$query = "delete from `address`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`address`", $query, AddressVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}