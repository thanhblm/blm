<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\BackendMenuVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class BackendMenuMapping {
	final public function selectByKey(BackendMenuVo $backendMenuVo) {
		try {
			$query = "select * from `backend_menu` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, BackendMenuVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(BackendMenuVo $backendMenuVo = null) {
		try {
			$query = "select * from `backend_menu`";
			$queryBuilder = new QueryBuilder ( $backendMenuVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BackendMenuVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(BackendMenuVo $backendMenuVo) {
		try {
			$query = "select * from `backend_menu`";
			$queryBuilder = new QueryBuilder ( $backendMenuVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`parent_id`", "parentId")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`link`", "link")
				->appendCondition ( "`icon`", "icon")
				->appendCondition ( "`order`", "order")
				->appendCondition ( "`mod`", "mod")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BackendMenuVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(BackendMenuVo $backendMenuVo = null) {
		try {
			$query = "select count(*) from `backend_menu`";
			$queryBuilder = new QueryBuilder ( $backendMenuVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`parent_id`", "parentId")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`link`", "link")
				->appendCondition ( "`icon`", "icon")
				->appendCondition ( "`order`", "order")
				->appendCondition ( "`mod`", "mod")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), BackendMenuVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(BackendMenuVo $backendMenuVo) {
		try {
			$query = "insert into `backend_menu`";
			$queryBuilder = new InsertBuilder ( $backendMenuVo, $query );
			$queryBuilder
				->appendField("`parent_id`", "parentId")
				->appendField("`title`", "title")
				->appendField("`link`", "link")
				->appendField("`icon`", "icon")
				->appendField("`order`", "order")
				->appendField("`mod`", "mod")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`backend_menu`", $queryBuilder->getSql (), BackendMenuVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(BackendMenuVo $backendMenuVo) {
		try {
			$query = "update `backend_menu`";
			$queryBuilder = new UpdateBuilder ( $backendMenuVo, $query );
			$queryBuilder
				->appendField("`parent_id`", "parentId")
				->appendField("`title`", "title")
				->appendField("`link`", "link")
				->appendField("`icon`", "icon")
				->appendField("`order`", "order")
				->appendField("`mod`", "mod")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`backend_menu`", $queryBuilder->getSql (), BackendMenuVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(BackendMenuVo $backendMenuVo) {
		try {
			$query = "delete from `backend_menu`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`backend_menu`", $query, BackendMenuVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}