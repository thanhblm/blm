<?php

namespace common\services\subscriber;

use common\persistence\base\vo\SubscriberVo;
use common\persistence\extend\dao\SubscriberExtendDao;
use common\persistence\extend\vo\SubscriberExtendVo;

class SubscriberService {
	private $subscriberDao;
	public function __construct() {
		$this->subscriberDao = new SubscriberExtendDao ();
	}
	public function getAll() {
		return $this->subscriberDao->selectAll ();
	}
	public function getByFilter(SubscriberExtendVo $filter) {
		return $this->subscriberDao->getByFilter ( $filter );
	}
	public function getCountByFilter(SubscriberExtendVo $filter) {
		return $this->subscriberDao->getCountByFilter ( $filter );
	}
	public function getByKey(SubscriberVo $subscriberVo) {
		return $this->subscriberDao->getByKey ( $subscriberVo );
	}
	public function add(SubscriberVo $subscriberVo) {
		return $this->subscriberDao->insertDynamic ( $subscriberVo );
	}
	public function update(SubscriberVo $subscriberVo) {
		return $this->subscriberDao->updateDynamicByKey ( $subscriberVo );
	}
	public function delete(SubscriberVo $subscriberVo) {
		return $this->subscriberDao->deleteByKey ( $subscriberVo );
	}
	public function getById(SubscriberVo $subscriberVo) {
		return $this->subscriberDao->selectByKey ( $subscriberVo );
	}
}