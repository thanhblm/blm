<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SubscriberVo;
use common\persistence\base\mapping\SubscriberMapping;

class SubscriberBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SubscriberVo $subscriberVo = null) {
		$result = $this->executeSelectOne ( SubscriberMapping::class, 'selectByKey', $subscriberVo );
		return $result;
	}
	final public function selectAll(SubscriberVo $subscriberVo = null) {
		$result = $this->executeSelectList ( SubscriberMapping::class, 'selectAll', $subscriberVo );
		return $result;
	}
	final public function selectByFilter(SubscriberVo $subscriberVo = null) {
		$result = $this->executeSelectList ( SubscriberMapping::class, 'selectByFilter', $subscriberVo );
		return $result;
	}
	final public function countByFilter(SubscriberVo $subscriberVo = null) {
		$result = $this->executeCount ( SubscriberMapping::class, 'countByFilter', $subscriberVo );
		return $result;
	}
	final public function insertDynamic(SubscriberVo $subscriberVo = null) {
		$result = $this->executeInsert ( SubscriberMapping::class, 'insertDynamic', $subscriberVo );
		return $result;
	}
	final public function insertDynamicWithId(SubscriberVo $subscriberVo = null) {
		$result = $this->executeInsert ( SubscriberMapping::class, 'insertDynamicWithId', $subscriberVo );
		return $result;
	}
	final public function updateDynamicByKey(SubscriberVo $subscriberVo = null) {
		$result = $this->executeUpdate ( SubscriberMapping::class, 'updateDynamicByKey', $subscriberVo );
		return $result;
	}
	final public function deleteByKey(SubscriberVo $subscriberVo = null) {
		$result = $this->executeDelete ( SubscriberMapping::class, 'deleteByKey', $subscriberVo );
		return $result;
	}
}

