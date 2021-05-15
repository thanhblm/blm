<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SlideGroupVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SlideGroupMapping {
	final public function selectByKey(SlideGroupVo $slideGroupVo) {
		try {
			$query = "select * from `slide_group` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SlideGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SlideGroupVo $slideGroupVo = null) {
		try {
			$query = "select * from `slide_group`";
			$queryBuilder = new QueryBuilder ( $slideGroupVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SlideGroupVo $slideGroupVo) {
		try {
			$query = "select * from `slide_group`";
			$queryBuilder = new QueryBuilder ( $slideGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SlideGroupVo $slideGroupVo = null) {
		try {
			$query = "select count(*) from `slide_group`";
			$queryBuilder = new QueryBuilder ( $slideGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SlideGroupVo $slideGroupVo) {
		try {
			$query = "insert into `slide_group`";
			$queryBuilder = new InsertBuilder ( $slideGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`code`", "code")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`slide_group`", $queryBuilder->getSql (), SlideGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SlideGroupVo $slideGroupVo) {
		try {
			$query = "insert into `slide_group`";
			$queryBuilder = new InsertBuilder ( $slideGroupVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`code`", "code")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`slide_group`", $queryBuilder->getSql (), SlideGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SlideGroupVo $slideGroupVo) {
		try {
			$query = "update `slide_group`";
			$queryBuilder = new UpdateBuilder ( $slideGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`code`", "code")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`slide_group`", $queryBuilder->getSql (), SlideGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SlideGroupVo $slideGroupVo) {
		try {
			$query = "delete from `slide_group`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`slide_group`", $query, SlideGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}