<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SubscriberVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SubscriberMapping {
	final public function selectByKey(SubscriberVo $subscriberVo) {
		try {
			$query = "select * from `subscriber` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SubscriberVo $subscriberVo = null) {
		try {
			$query = "select * from `subscriber`";
			$queryBuilder = new QueryBuilder ( $subscriberVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SubscriberVo $subscriberVo) {
		try {
			$query = "select * from `subscriber`";
			$queryBuilder = new QueryBuilder ( $subscriberVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`first_name`", "firstName")
				->appendCondition ( "`last_name`", "lastName")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SubscriberVo $subscriberVo = null) {
		try {
			$query = "select count(*) from `subscriber`";
			$queryBuilder = new QueryBuilder ( $subscriberVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`email`", "email")
				->appendCondition ( "`first_name`", "firstName")
				->appendCondition ( "`last_name`", "lastName")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SubscriberVo $subscriberVo) {
		try {
			$query = "insert into `subscriber`";
			$queryBuilder = new InsertBuilder ( $subscriberVo, $query );
			$queryBuilder
				->appendField("`email`", "email")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`subscriber`", $queryBuilder->getSql (), SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SubscriberVo $subscriberVo) {
		try {
			$query = "insert into `subscriber`";
			$queryBuilder = new InsertBuilder ( $subscriberVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`email`", "email")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`subscriber`", $queryBuilder->getSql (), SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SubscriberVo $subscriberVo) {
		try {
			$query = "update `subscriber`";
			$queryBuilder = new UpdateBuilder ( $subscriberVo, $query );
			$queryBuilder
				->appendField("`email`", "email")
				->appendField("`first_name`", "firstName")
				->appendField("`last_name`", "lastName")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`subscriber`", $queryBuilder->getSql (), SubscriberVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SubscriberVo $subscriberVo) {
		try {
			$query = "delete from `subscriber`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`subscriber`", $query, SubscriberVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}