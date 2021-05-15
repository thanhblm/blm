<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SlideVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SlideMapping {
	final public function selectByKey(SlideVo $slideVo) {
		try {
			$query = "select * from `slide` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SlideVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SlideVo $slideVo = null) {
		try {
			$query = "select * from `slide`";
			$queryBuilder = new QueryBuilder ( $slideVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SlideVo $slideVo) {
		try {
			$query = "select * from `slide`";
			$queryBuilder = new QueryBuilder ( $slideVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`url`", "url")
				->appendCondition ( "`slide_group_id`", "slideGroupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SlideVo $slideVo = null) {
		try {
			$query = "select count(*) from `slide`";
			$queryBuilder = new QueryBuilder ( $slideVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`url`", "url")
				->appendCondition ( "`slide_group_id`", "slideGroupId")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SlideVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SlideVo $slideVo) {
		try {
			$query = "insert into `slide`";
			$queryBuilder = new InsertBuilder ( $slideVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`url`", "url")
				->appendField("`slide_group_id`", "slideGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`slide`", $queryBuilder->getSql (), SlideVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SlideVo $slideVo) {
		try {
			$query = "insert into `slide`";
			$queryBuilder = new InsertBuilder ( $slideVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`url`", "url")
				->appendField("`slide_group_id`", "slideGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`slide`", $queryBuilder->getSql (), SlideVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SlideVo $slideVo) {
		try {
			$query = "update `slide`";
			$queryBuilder = new UpdateBuilder ( $slideVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`status`", "status")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`url`", "url")
				->appendField("`slide_group_id`", "slideGroupId")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`slide`", $queryBuilder->getSql (), SlideVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SlideVo $slideVo) {
		try {
			$query = "delete from `slide`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`slide`", $query, SlideVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}