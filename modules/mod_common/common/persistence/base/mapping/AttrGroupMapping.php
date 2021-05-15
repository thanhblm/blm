<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AttrGroupVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AttrGroupMapping {
	final public function selectByKey(AttrGroupVo $attrGroupVo) {
		try {
			$query = "select * from `attr_group` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttrGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AttrGroupVo $attrGroupVo = null) {
		try {
			$query = "select * from `attr_group`";
			$queryBuilder = new QueryBuilder ( $attrGroupVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AttrGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AttrGroupVo $attrGroupVo) {
		try {
			$query = "select * from `attr_group`";
			$queryBuilder = new QueryBuilder ( $attrGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`order`", "order")
				->appendCondition ( "`is_choice`", "isChoice")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AttrGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AttrGroupVo $attrGroupVo = null) {
		try {
			$query = "select count(*) from `attr_group`";
			$queryBuilder = new QueryBuilder ( $attrGroupVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`order`", "order")
				->appendCondition ( "`is_choice`", "isChoice");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AttrGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AttrGroupVo $attrGroupVo) {
		try {
			$query = "insert into `attr_group`";
			$queryBuilder = new InsertBuilder ( $attrGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`order`", "order")
				->appendField("`is_choice`", "isChoice");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`attr_group`", $queryBuilder->getSql (), AttrGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AttrGroupVo $attrGroupVo) {
		try {
			$query = "insert into `attr_group`";
			$queryBuilder = new InsertBuilder ( $attrGroupVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`order`", "order")
				->appendField("`is_choice`", "isChoice");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`attr_group`", $queryBuilder->getSql (), AttrGroupVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AttrGroupVo $attrGroupVo) {
		try {
			$query = "update `attr_group`";
			$queryBuilder = new UpdateBuilder ( $attrGroupVo, $query );
			$queryBuilder
				->appendField("`name`", "name")
				->appendField("`description`", "description")
				->appendField("`order`", "order")
				->appendField("`is_choice`", "isChoice");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`attr_group`", $queryBuilder->getSql (), AttrGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AttrGroupVo $attrGroupVo) {
		try {
			$query = "delete from `attr_group`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`attr_group`", $query, AttrGroupVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}