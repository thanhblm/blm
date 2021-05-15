<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\GridVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class GridMapping {
	final public function selectByKey(GridVo $gridVo) {
		try {
			$query = "select * from `grid` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(GridVo $gridVo = null) {
		try {
			$query = "select * from `grid`";
			$queryBuilder = new QueryBuilder ( $gridVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(GridVo $gridVo) {
		try {
			$query = "select * from `grid`";
			$queryBuilder = new QueryBuilder ( $gridVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`container_id`", "containerId")
				->appendCondition ( "`parent_id`", "parentId")
				->appendCondition ( "`width`", "width")
				->appendCondition ( "`align`", "align")
				->appendCondition ( "`fluid_container`", "fluidContainer")
				->appendCondition ( "`class`", "class")
				->appendCondition ( "`style`", "style")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`order`", "order")
				->appendCondition ( "`bg_image`", "bgImage")
				->appendCondition ( "`bg_color`", "bgColor")
				->appendCondition ( "`bg_size`", "bgSize")
				->appendCondition ( "`bg_repeat`", "bgRepeat")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(GridVo $gridVo = null) {
		try {
			$query = "select count(*) from `grid`";
			$queryBuilder = new QueryBuilder ( $gridVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`container_id`", "containerId")
				->appendCondition ( "`parent_id`", "parentId")
				->appendCondition ( "`width`", "width")
				->appendCondition ( "`align`", "align")
				->appendCondition ( "`fluid_container`", "fluidContainer")
				->appendCondition ( "`class`", "class")
				->appendCondition ( "`style`", "style")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`order`", "order")
				->appendCondition ( "`bg_image`", "bgImage")
				->appendCondition ( "`bg_color`", "bgColor")
				->appendCondition ( "`bg_size`", "bgSize")
				->appendCondition ( "`bg_repeat`", "bgRepeat");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(GridVo $gridVo) {
		try {
			$query = "insert into `grid`";
			$queryBuilder = new InsertBuilder ( $gridVo, $query );
			$queryBuilder
				->appendField("`container_id`", "containerId")
				->appendField("`parent_id`", "parentId")
				->appendField("`width`", "width")
				->appendField("`align`", "align")
				->appendField("`fluid_container`", "fluidContainer")
				->appendField("`class`", "class")
				->appendField("`style`", "style")
				->appendField("`status`", "status")
				->appendField("`order`", "order")
				->appendField("`bg_image`", "bgImage")
				->appendField("`bg_color`", "bgColor")
				->appendField("`bg_size`", "bgSize")
				->appendField("`bg_repeat`", "bgRepeat");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`grid`", $queryBuilder->getSql (), GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(GridVo $gridVo) {
		try {
			$query = "insert into `grid`";
			$queryBuilder = new InsertBuilder ( $gridVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`container_id`", "containerId")
				->appendField("`parent_id`", "parentId")
				->appendField("`width`", "width")
				->appendField("`align`", "align")
				->appendField("`fluid_container`", "fluidContainer")
				->appendField("`class`", "class")
				->appendField("`style`", "style")
				->appendField("`status`", "status")
				->appendField("`order`", "order")
				->appendField("`bg_image`", "bgImage")
				->appendField("`bg_color`", "bgColor")
				->appendField("`bg_size`", "bgSize")
				->appendField("`bg_repeat`", "bgRepeat");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`grid`", $queryBuilder->getSql (), GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(GridVo $gridVo) {
		try {
			$query = "update `grid`";
			$queryBuilder = new UpdateBuilder ( $gridVo, $query );
			$queryBuilder
				->appendField("`container_id`", "containerId")
				->appendField("`parent_id`", "parentId")
				->appendField("`width`", "width")
				->appendField("`align`", "align")
				->appendField("`fluid_container`", "fluidContainer")
				->appendField("`class`", "class")
				->appendField("`style`", "style")
				->appendField("`status`", "status")
				->appendField("`order`", "order")
				->appendField("`bg_image`", "bgImage")
				->appendField("`bg_color`", "bgColor")
				->appendField("`bg_size`", "bgSize")
				->appendField("`bg_repeat`", "bgRepeat");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`grid`", $queryBuilder->getSql (), GridVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(GridVo $gridVo) {
		try {
			$query = "delete from `grid`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`grid`", $query, GridVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}