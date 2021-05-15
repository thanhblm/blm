<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\UrlRedirectVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class UrlRedirectMapping {
	final public function selectByKey(UrlRedirectVo $urlRedirectVo) {
		try {
			$query = "select * from `url_redirect` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UrlRedirectVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(UrlRedirectVo $urlRedirectVo = null) {
		try {
			$query = "select * from `url_redirect`";
			$queryBuilder = new QueryBuilder ( $urlRedirectVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UrlRedirectVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(UrlRedirectVo $urlRedirectVo) {
		try {
			$query = "select * from `url_redirect`";
			$queryBuilder = new QueryBuilder ( $urlRedirectVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`old_url`", "oldUrl")
				->appendCondition ( "`new_url`", "newUrl")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UrlRedirectVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(UrlRedirectVo $urlRedirectVo = null) {
		try {
			$query = "select count(*) from `url_redirect`";
			$queryBuilder = new QueryBuilder ( $urlRedirectVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`old_url`", "oldUrl")
				->appendCondition ( "`new_url`", "newUrl")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UrlRedirectVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(UrlRedirectVo $urlRedirectVo) {
		try {
			$query = "insert into `url_redirect`";
			$queryBuilder = new InsertBuilder ( $urlRedirectVo, $query );
			$queryBuilder
				->appendField("`old_url`", "oldUrl")
				->appendField("`new_url`", "newUrl")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`url_redirect`", $queryBuilder->getSql (), UrlRedirectVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(UrlRedirectVo $urlRedirectVo) {
		try {
			$query = "insert into `url_redirect`";
			$queryBuilder = new InsertBuilder ( $urlRedirectVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`old_url`", "oldUrl")
				->appendField("`new_url`", "newUrl")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`url_redirect`", $queryBuilder->getSql (), UrlRedirectVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(UrlRedirectVo $urlRedirectVo) {
		try {
			$query = "update `url_redirect`";
			$queryBuilder = new UpdateBuilder ( $urlRedirectVo, $query );
			$queryBuilder
				->appendField("`old_url`", "oldUrl")
				->appendField("`new_url`", "newUrl")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`url_redirect`", $queryBuilder->getSql (), UrlRedirectVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(UrlRedirectVo $urlRedirectVo) {
		try {
			$query = "delete from `url_redirect`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`url_redirect`", $query, UrlRedirectVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}