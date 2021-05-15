<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ManufactureVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ManufactureMapping {
	final public function selectByKey(ManufactureVo $manufactureVo) {
		try {
			$query = "select * from `manufacture` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ManufactureVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ManufactureVo $manufactureVo = null) {
		try {
			$query = "select * from `manufacture`";
			$queryBuilder = new QueryBuilder ( $manufactureVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ManufactureVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ManufactureVo $manufactureVo) {
		try {
			$query = "select * from `manufacture`";
			$queryBuilder = new QueryBuilder ( $manufactureVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ManufactureVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ManufactureVo $manufactureVo = null) {
		try {
			$query = "select count(*) from `manufacture`";
			$queryBuilder = new QueryBuilder ( $manufactureVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ManufactureVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ManufactureVo $manufactureVo) {
		try {
			$query = "insert into `manufacture`";
			$queryBuilder = new InsertBuilder ( $manufactureVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`manufacture`", $queryBuilder->getSql (), ManufactureVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ManufactureVo $manufactureVo) {
		try {
			$query = "insert into `manufacture`";
			$queryBuilder = new InsertBuilder ( $manufactureVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`manufacture`", $queryBuilder->getSql (), ManufactureVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ManufactureVo $manufactureVo) {
		try {
			$query = "update `manufacture`";
			$queryBuilder = new UpdateBuilder ( $manufactureVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`manufacture`", $queryBuilder->getSql (), ManufactureVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ManufactureVo $manufactureVo) {
		try {
			$query = "delete from `manufacture`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`manufacture`", $query, ManufactureVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}