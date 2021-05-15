<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\SubscriberBaseDao;
use common\persistence\extend\mapping\SubscriberExtendMapping;
use common\persistence\extend\vo\SubscriberExtendVo;
use core\database\SqlMapClient;
use common\persistence\base\vo\SubscriberVo;

class SubscriberExtendDao extends SubscriberBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function getByFilter(SubscriberExtendVo $subscriberVo = null) {
		$result = $this->executeSelectList ( SubscriberExtendMapping::class, 'getByFilter', $subscriberVo );
		return $result;
	}
	final public function getCountByFilter(SubscriberExtendVo $subscriberVo = null) {
		$result = $this->executeCount ( SubscriberExtendMapping::class, 'getCountByFilter', $subscriberVo );
		return $result;
	}
	final public function unsubscribe($key) {
		$result = $this->executeUpdate ( SubscriberExtendMapping::class, 'unsubscribe', $key );
		return $result;
	}
	final public function getByKey(SubscriberVo $subscriberVo) {
		$result = $this->executeSelectOne( SubscriberExtendMapping::class, 'getByKey', $subscriberVo );
		return $result;
	}
}

