<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\AuctionDetailVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class AuctionDetailMapping {
	final public function selectByKey(AuctionDetailVo $auctionDetailVo) {
		try {
			$query = "select * from `auction_detail` where (`auction_id` = #{auctionId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AuctionDetailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(AuctionDetailVo $auctionDetailVo = null) {
		try {
			$query = "select * from `auction_detail`";
			$queryBuilder = new QueryBuilder ( $auctionDetailVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AuctionDetailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(AuctionDetailVo $auctionDetailVo) {
		try {
			$query = "select * from `auction_detail`";
			$queryBuilder = new QueryBuilder ( $auctionDetailVo, $query );
			$queryBuilder
				->appendCondition ( "`auction_id`", "auctionId")
				->appendCondition ( "`product_quantity`", "productQuantity")
				->appendCondition ( "`price_per_unit`", "pricePerUnit")
				->appendCondition ( "`max days`", "max days")
				->appendCondition ( "`approve`", "approve")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AuctionDetailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(AuctionDetailVo $auctionDetailVo = null) {
		try {
			$query = "select count(*) from `auction_detail`";
			$queryBuilder = new QueryBuilder ( $auctionDetailVo, $query );
			$queryBuilder
				->appendCondition ( "`auction_id`", "auctionId")
				->appendCondition ( "`product_quantity`", "productQuantity")
				->appendCondition ( "`price_per_unit`", "pricePerUnit")
				->appendCondition ( "`max days`", "max days")
				->appendCondition ( "`approve`", "approve");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), AuctionDetailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(AuctionDetailVo $auctionDetailVo) {
		try {
			$query = "insert into `auction_detail`";
			$queryBuilder = new InsertBuilder ( $auctionDetailVo, $query );
			$queryBuilder
				->appendField("`auction_id`", "auctionId")
				->appendField("`product_quantity`", "productQuantity")
				->appendField("`price_per_unit`", "pricePerUnit")
				->appendField("`max days`", "max days")
				->appendField("`approve`", "approve");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`auction_detail`", $queryBuilder->getSql (), AuctionDetailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(AuctionDetailVo $auctionDetailVo) {
		try {
			$query = "insert into `auction_detail`";
			$queryBuilder = new InsertBuilder ( $auctionDetailVo, $query );
			$queryBuilder
				->appendField("`auction_id`", "auctionId")
				->appendField("`product_quantity`", "productQuantity")
				->appendField("`price_per_unit`", "pricePerUnit")
				->appendField("`max days`", "max days")
				->appendField("`approve`", "approve");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`auction_detail`", $queryBuilder->getSql (), AuctionDetailVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(AuctionDetailVo $auctionDetailVo) {
		try {
			$query = "update `auction_detail`";
			$queryBuilder = new UpdateBuilder ( $auctionDetailVo, $query );
			$queryBuilder
				->appendField("`product_quantity`", "productQuantity")
				->appendField("`price_per_unit`", "pricePerUnit")
				->appendField("`max days`", "max days")
				->appendField("`approve`", "approve");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`auction_detail`", $queryBuilder->getSql (), AuctionDetailVo::class, "where (`auction_id` = #{auctionId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(AuctionDetailVo $auctionDetailVo) {
		try {
			$query = "delete from `auction_detail`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`auction_detail`", $query, AuctionDetailVo::class, "where (`auction_id` = #{auctionId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}