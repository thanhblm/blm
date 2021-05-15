<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AuctionDetailVo;
use common\persistence\base\mapping\AuctionDetailMapping;

class AuctionDetailBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeSelectOne ( AuctionDetailMapping::class, 'selectByKey', $auctionDetailVo );
		return $result;
	}
	final public function selectAll(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeSelectList ( AuctionDetailMapping::class, 'selectAll', $auctionDetailVo );
		return $result;
	}
	final public function selectByFilter(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeSelectList ( AuctionDetailMapping::class, 'selectByFilter', $auctionDetailVo );
		return $result;
	}
	final public function countByFilter(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeCount ( AuctionDetailMapping::class, 'countByFilter', $auctionDetailVo );
		return $result;
	}
	final public function insertDynamic(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeInsert ( AuctionDetailMapping::class, 'insertDynamic', $auctionDetailVo );
		return $result;
	}
	final public function insertDynamicWithId(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeInsert ( AuctionDetailMapping::class, 'insertDynamicWithId', $auctionDetailVo );
		return $result;
	}
	final public function updateDynamicByKey(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeUpdate ( AuctionDetailMapping::class, 'updateDynamicByKey', $auctionDetailVo );
		return $result;
	}
	final public function deleteByKey(AuctionDetailVo $auctionDetailVo = null) {
		$result = $this->executeDelete ( AuctionDetailMapping::class, 'deleteByKey', $auctionDetailVo );
		return $result;
	}
}

