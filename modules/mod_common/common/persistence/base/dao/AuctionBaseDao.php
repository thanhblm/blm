<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\AuctionVo;
use common\persistence\base\mapping\AuctionMapping;

class AuctionBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(AuctionVo $auctionVo = null) {
		$result = $this->executeSelectOne ( AuctionMapping::class, 'selectByKey', $auctionVo );
		return $result;
	}
	final public function selectAll(AuctionVo $auctionVo = null) {
		$result = $this->executeSelectList ( AuctionMapping::class, 'selectAll', $auctionVo );
		return $result;
	}
	final public function selectByFilter(AuctionVo $auctionVo = null) {
		$result = $this->executeSelectList ( AuctionMapping::class, 'selectByFilter', $auctionVo );
		return $result;
	}
	final public function countByFilter(AuctionVo $auctionVo = null) {
		$result = $this->executeCount ( AuctionMapping::class, 'countByFilter', $auctionVo );
		return $result;
	}
	final public function insertDynamic(AuctionVo $auctionVo = null) {
		$result = $this->executeInsert ( AuctionMapping::class, 'insertDynamic', $auctionVo );
		return $result;
	}
	final public function insertDynamicWithId(AuctionVo $auctionVo = null) {
		$result = $this->executeInsert ( AuctionMapping::class, 'insertDynamicWithId', $auctionVo );
		return $result;
	}
	final public function updateDynamicByKey(AuctionVo $auctionVo = null) {
		$result = $this->executeUpdate ( AuctionMapping::class, 'updateDynamicByKey', $auctionVo );
		return $result;
	}
	final public function deleteByKey(AuctionVo $auctionVo = null) {
		$result = $this->executeDelete ( AuctionMapping::class, 'deleteByKey', $auctionVo );
		return $result;
	}
}

