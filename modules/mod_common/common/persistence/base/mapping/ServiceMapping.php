<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ServiceVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ServiceMapping {
	final public function selectByKey(ServiceVo $serviceVo) {
		try {
			$query = "select * from `service` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ServiceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ServiceVo $serviceVo = null) {
		try {
			$query = "select * from `service`";
			$queryBuilder = new QueryBuilder ( $serviceVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ServiceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ServiceVo $serviceVo) {
		try {
			$query = "select * from `service`";
			$queryBuilder = new QueryBuilder ( $serviceVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`service_name`", "serviceName")
				->appendCondition ( "`service_id`", "serviceId")
				->appendCondition ( "`database_name`", "databaseName")
				->appendCondition ( "`database_password`", "databasePassword")
				->appendCondition ( "`services_status_id`", "servicesStatusId")
				->appendCondition ( "`service_email`", "serviceEmail")
				->appendCondition ( "`group_id`", "groupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendCondition ( "`due_date`", "dueDate")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ServiceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ServiceVo $serviceVo = null) {
		try {
			$query = "select count(*) from `service`";
			$queryBuilder = new QueryBuilder ( $serviceVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`service_name`", "serviceName")
				->appendCondition ( "`service_id`", "serviceId")
				->appendCondition ( "`database_name`", "databaseName")
				->appendCondition ( "`database_password`", "databasePassword")
				->appendCondition ( "`services_status_id`", "servicesStatusId")
				->appendCondition ( "`service_email`", "serviceEmail")
				->appendCondition ( "`group_id`", "groupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendCondition ( "`due_date`", "dueDate");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ServiceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ServiceVo $serviceVo) {
		try {
			$query = "insert into `service`";
			$queryBuilder = new InsertBuilder ( $serviceVo, $query );
			$queryBuilder
				->appendField("`service_name`", "serviceName")
				->appendField("`service_id`", "serviceId")
				->appendField("`database_name`", "databaseName")
				->appendField("`database_password`", "databasePassword")
				->appendField("`services_status_id`", "servicesStatusId")
				->appendField("`service_email`", "serviceEmail")
				->appendField("`group_id`", "groupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`due_date`", "dueDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`service`", $queryBuilder->getSql (), ServiceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ServiceVo $serviceVo) {
		try {
			$query = "insert into `service`";
			$queryBuilder = new InsertBuilder ( $serviceVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`service_name`", "serviceName")
				->appendField("`service_id`", "serviceId")
				->appendField("`database_name`", "databaseName")
				->appendField("`database_password`", "databasePassword")
				->appendField("`services_status_id`", "servicesStatusId")
				->appendField("`service_email`", "serviceEmail")
				->appendField("`group_id`", "groupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`due_date`", "dueDate");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`service`", $queryBuilder->getSql (), ServiceVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ServiceVo $serviceVo) {
		try {
			$query = "update `service`";
			$queryBuilder = new UpdateBuilder ( $serviceVo, $query );
			$queryBuilder
				->appendField("`service_name`", "serviceName")
				->appendField("`service_id`", "serviceId")
				->appendField("`database_name`", "databaseName")
				->appendField("`database_password`", "databasePassword")
				->appendField("`services_status_id`", "servicesStatusId")
				->appendField("`service_email`", "serviceEmail")
				->appendField("`group_id`", "groupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy")
				->appendField("`due_date`", "dueDate");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`service`", $queryBuilder->getSql (), ServiceVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ServiceVo $serviceVo) {
		try {
			$query = "delete from `service`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`service`", $query, ServiceVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}