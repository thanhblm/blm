<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ContainerVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ContainerMapping {
	final public function selectByKey(ContainerVo $containerVo) {
		try {
			$query = "select * from `container` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ContainerVo $containerVo = null) {
		try {
			$query = "select * from `container`";
			$queryBuilder = new QueryBuilder ( $containerVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ContainerVo $containerVo) {
		try {
			$query = "select * from `container`";
			$queryBuilder = new QueryBuilder ( $containerVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`position`", "position")
				->appendCondition ( "`class`", "class")
				->appendCondition ( "`is_system`", "isSystem")
				->appendCondition ( "`is_temp`", "isTemp")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ContainerVo $containerVo = null) {
		try {
			$query = "select count(*) from `container`";
			$queryBuilder = new QueryBuilder ( $containerVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`page_id`", "pageId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`position`", "position")
				->appendCondition ( "`class`", "class")
				->appendCondition ( "`is_system`", "isSystem")
				->appendCondition ( "`is_temp`", "isTemp")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ContainerVo $containerVo) {
		try {
			$query = "insert into `container`";
			$queryBuilder = new InsertBuilder ( $containerVo, $query );
			$queryBuilder
				->appendField("`page_id`", "pageId")
				->appendField("`name`", "name")
				->appendField("`position`", "position")
				->appendField("`class`", "class")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`container`", $queryBuilder->getSql (), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ContainerVo $containerVo) {
		try {
			$query = "insert into `container`";
			$queryBuilder = new InsertBuilder ( $containerVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`page_id`", "pageId")
				->appendField("`name`", "name")
				->appendField("`position`", "position")
				->appendField("`class`", "class")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`container`", $queryBuilder->getSql (), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ContainerVo $containerVo) {
		try {
			$query = "update `container`";
			$queryBuilder = new UpdateBuilder ( $containerVo, $query );
			$queryBuilder
				->appendField("`page_id`", "pageId")
				->appendField("`name`", "name")
				->appendField("`position`", "position")
				->appendField("`class`", "class")
				->appendField("`is_system`", "isSystem")
				->appendField("`is_temp`", "isTemp")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`container`", $queryBuilder->getSql (), ContainerVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ContainerVo $containerVo) {
		try {
			$query = "delete from `container`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`container`", $query, ContainerVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}