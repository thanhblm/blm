<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ContactVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ContactMapping {
	final public function selectByKey(ContactVo $contactVo) {
		try {
			$query = "select * from `contact` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ContactVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ContactVo $contactVo = null) {
		try {
			$query = "select * from `contact`";
			$queryBuilder = new QueryBuilder ( $contactVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContactVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ContactVo $contactVo) {
		try {
			$query = "select * from `contact`";
			$queryBuilder = new QueryBuilder ( $contactVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`full_name`", "fullName")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`country_code`", "countryCode")
				->appendCondition ( "`message`", "message")
				->appendCondition ( "`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContactVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ContactVo $contactVo = null) {
		try {
			$query = "select count(*) from `contact`";
			$queryBuilder = new QueryBuilder ( $contactVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`full_name`", "fullName")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`phone`", "phone")
				->appendCondition ( "`country_code`", "countryCode")
				->appendCondition ( "`message`", "message")
				->appendCondition ( "`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContactVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ContactVo $contactVo) {
		try {
			$query = "insert into `contact`";
			$queryBuilder = new InsertBuilder ( $contactVo, $query );
			$queryBuilder
				->appendField("`cr_date`", "crDate")
				->appendField("`full_name`", "fullName")
				->appendField("`email`", "email")
				->appendField("`phone`", "phone")
				->appendField("`country_code`", "countryCode")
				->appendField("`message`", "message")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`contact`", $queryBuilder->getSql (), ContactVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ContactVo $contactVo) {
		try {
			$query = "insert into `contact`";
			$queryBuilder = new InsertBuilder ( $contactVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`cr_date`", "crDate")
				->appendField("`full_name`", "fullName")
				->appendField("`email`", "email")
				->appendField("`phone`", "phone")
				->appendField("`country_code`", "countryCode")
				->appendField("`message`", "message")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`contact`", $queryBuilder->getSql (), ContactVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ContactVo $contactVo) {
		try {
			$query = "update `contact`";
			$queryBuilder = new UpdateBuilder ( $contactVo, $query );
			$queryBuilder
				->appendField("`cr_date`", "crDate")
				->appendField("`full_name`", "fullName")
				->appendField("`email`", "email")
				->appendField("`phone`", "phone")
				->appendField("`country_code`", "countryCode")
				->appendField("`message`", "message")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`contact`", $queryBuilder->getSql (), ContactVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ContactVo $contactVo) {
		try {
			$query = "delete from `contact`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`contact`", $query, ContactVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}