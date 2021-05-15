<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AuctionVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AuctionMapping {
	final public function selectByKey(AuctionVo $auctionVo) {
		try {
			$query = "select * from `auction` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AuctionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AuctionVo $auctionVo = null) {
		try {
			$query = "select * from `auction`";
			$queryBuilder = new QueryBuilder ( $auctionVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AuctionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AuctionVo $auctionVo) {
		try {
			$query = "select * from `auction`";
			$queryBuilder = new QueryBuilder ( $auctionVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`campaign_days`", "campaignDays")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AuctionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AuctionVo $auctionVo = null) {
		try {
			$query = "select count(*) from `auction`";
			$queryBuilder = new QueryBuilder ( $auctionVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`product_id`", "productId")
				->appendCondition ( "`campaign_days`", "campaignDays")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AuctionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AuctionVo $auctionVo) {
		try {
			$query = "insert into `auction`";
			$queryBuilder = new InsertBuilder ( $auctionVo, $query );
			$queryBuilder
				->appendField("`user_id`", "userId")
				->appendField("`product_id`", "productId")
				->appendField("`campaign_days`", "campaignDays")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`auction`", $queryBuilder->getSql (), AuctionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AuctionVo $auctionVo) {
		try {
			$query = "insert into `auction`";
			$queryBuilder = new InsertBuilder ( $auctionVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`user_id`", "userId")
				->appendField("`product_id`", "productId")
				->appendField("`campaign_days`", "campaignDays")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`auction`", $queryBuilder->getSql (), AuctionVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AuctionVo $auctionVo) {
		try {
			$query = "update `auction`";
			$queryBuilder = new UpdateBuilder ( $auctionVo, $query );
			$queryBuilder
				->appendField("`user_id`", "userId")
				->appendField("`product_id`", "productId")
				->appendField("`campaign_days`", "campaignDays")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`auction`", $queryBuilder->getSql (), AuctionVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AuctionVo $auctionVo) {
		try {
			$query = "delete from `auction`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`auction`", $query, AuctionVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}