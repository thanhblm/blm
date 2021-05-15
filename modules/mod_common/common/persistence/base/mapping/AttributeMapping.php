<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AttributeVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AttributeMapping {
	final public function selectByKey(AttributeVo $attributeVo) {
		try {
			$query = "select * from `attribute` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AttributeVo $attributeVo = null) {
		try {
			$query = "select * from `attribute`";
			$queryBuilder = new QueryBuilder ( $attributeVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AttributeVo $attributeVo) {
		try {
			$query = "select * from `attribute`";
			$queryBuilder = new QueryBuilder ( $attributeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`attr_group_id`", "attrGroupId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`order`", "order")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AttributeVo $attributeVo = null) {
		try {
			$query = "select count(*) from `attribute`";
			$queryBuilder = new QueryBuilder ( $attributeVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`code`", "code")
				->appendCondition ( "`category_id`", "categoryId")
				->appendCondition ( "`attr_group_id`", "attrGroupId")
				->appendCondition ( "`name`", "name")
				->appendCondition ( "`type`", "type")
				->appendCondition ( "`image`", "image")
				->appendCondition ( "`description`", "description")
				->appendCondition ( "`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AttributeVo $attributeVo) {
		try {
			$query = "insert into `attribute`";
			$queryBuilder = new InsertBuilder ( $attributeVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`category_id`", "categoryId")
				->appendField("`attr_group_id`", "attrGroupId")
				->appendField("`name`", "name")
				->appendField("`type`", "type")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`attribute`", $queryBuilder->getSql (), AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AttributeVo $attributeVo) {
		try {
			$query = "insert into `attribute`";
			$queryBuilder = new InsertBuilder ( $attributeVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`code`", "code")
				->appendField("`category_id`", "categoryId")
				->appendField("`attr_group_id`", "attrGroupId")
				->appendField("`name`", "name")
				->appendField("`type`", "type")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`attribute`", $queryBuilder->getSql (), AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AttributeVo $attributeVo) {
		try {
			$query = "update `attribute`";
			$queryBuilder = new UpdateBuilder ( $attributeVo, $query );
			$queryBuilder
				->appendField("`code`", "code")
				->appendField("`category_id`", "categoryId")
				->appendField("`attr_group_id`", "attrGroupId")
				->appendField("`name`", "name")
				->appendField("`type`", "type")
				->appendField("`image`", "image")
				->appendField("`description`", "description")
				->appendField("`order`", "order");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`attribute`", $queryBuilder->getSql (), AttributeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AttributeVo $attributeVo) {
		try {
			$query = "delete from `attribute`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`attribute`", $query, AttributeVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}