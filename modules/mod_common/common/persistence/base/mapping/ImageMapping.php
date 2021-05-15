<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\ImageVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class ImageMapping {
	final public function selectByKey(ImageVo $imageVo) {
		try {
			$query = "select * from `image` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, ImageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(ImageVo $imageVo = null) {
		try {
			$query = "select * from `image`";
			$queryBuilder = new QueryBuilder ( $imageVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ImageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(ImageVo $imageVo) {
		try {
			$query = "select * from `image`";
			$queryBuilder = new QueryBuilder ( $imageVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`profile`", "profile")
				->appendCondition ( "`file_name`", "fileName")
				->appendCondition ( "`mine_type`", "mineType")
				->appendCondition ( "`relative_path`", "relativePath")
				->appendCondition ( "`relative_small_path`", "relativeSmallPath")
				->appendCondition ( "`relative_large_path`", "relativeLargePath")
				->appendCondition ( "`relative_medium_path`", "relativeMediumPath")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ImageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(ImageVo $imageVo = null) {
		try {
			$query = "select count(*) from `image`";
			$queryBuilder = new QueryBuilder ( $imageVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`profile`", "profile")
				->appendCondition ( "`file_name`", "fileName")
				->appendCondition ( "`mine_type`", "mineType")
				->appendCondition ( "`relative_path`", "relativePath")
				->appendCondition ( "`relative_small_path`", "relativeSmallPath")
				->appendCondition ( "`relative_large_path`", "relativeLargePath")
				->appendCondition ( "`relative_medium_path`", "relativeMediumPath")
				->appendCondition ( "`status`", "status")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), ImageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(ImageVo $imageVo) {
		try {
			$query = "insert into `image`";
			$queryBuilder = new InsertBuilder ( $imageVo, $query );
			$queryBuilder
				->appendField("`profile`", "profile")
				->appendField("`file_name`", "fileName")
				->appendField("`mine_type`", "mineType")
				->appendField("`relative_path`", "relativePath")
				->appendField("`relative_small_path`", "relativeSmallPath")
				->appendField("`relative_large_path`", "relativeLargePath")
				->appendField("`relative_medium_path`", "relativeMediumPath")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`image`", $queryBuilder->getSql (), ImageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(ImageVo $imageVo) {
		try {
			$query = "insert into `image`";
			$queryBuilder = new InsertBuilder ( $imageVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`profile`", "profile")
				->appendField("`file_name`", "fileName")
				->appendField("`mine_type`", "mineType")
				->appendField("`relative_path`", "relativePath")
				->appendField("`relative_small_path`", "relativeSmallPath")
				->appendField("`relative_large_path`", "relativeLargePath")
				->appendField("`relative_medium_path`", "relativeMediumPath")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`image`", $queryBuilder->getSql (), ImageVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(ImageVo $imageVo) {
		try {
			$query = "update `image`";
			$queryBuilder = new UpdateBuilder ( $imageVo, $query );
			$queryBuilder
				->appendField("`profile`", "profile")
				->appendField("`file_name`", "fileName")
				->appendField("`mine_type`", "mineType")
				->appendField("`relative_path`", "relativePath")
				->appendField("`relative_small_path`", "relativeSmallPath")
				->appendField("`relative_large_path`", "relativeLargePath")
				->appendField("`relative_medium_path`", "relativeMediumPath")
				->appendField("`status`", "status")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`image`", $queryBuilder->getSql (), ImageVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(ImageVo $imageVo) {
		try {
			$query = "delete from `image`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`image`", $query, ImageVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}