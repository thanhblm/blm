<?php

namespace common\services\home;

use common\persistence\base\dao\AddressBaseDao;
use common\persistence\base\dao\SubscriberBaseDao;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\SubscriberVo;
use common\persistence\extend\dao\CustomerExtendDao;
use common\services\base\BaseService;
use core\database\SqlMapClient;

class HomeService extends BaseService {
	public function __construct($context = array()) {
		parent::__construct ( $context );
	}
	public function register(CustomerVo $customerVo, AddressVo $addressVo, SubscriberVo $subscribe = null) {
		$sqlMapClient = new SqlMapClient ( $this->context );
		$addressDao = new AddressBaseDao ( $this->context, $sqlMapClient );
		$subscribeDao = new SubscriberBaseDao ( $this->context, $sqlMapClient );
		$customerDao = new CustomerExtendDao ( $this->context, $sqlMapClient );
		$sqlMapClient->startTransaction ();
		try {
			$customerVo->id = $customerDao->insertDynamic ( $customerVo );
			$addressVo->groupId = $customerVo->id;
			$addressId = $addressDao->insertDynamic ( $addressVo );
			$customerVo->defaultBillingAddressId = $addressId;
			$customerVo->defaultShippingAddressId = $addressId;
			$customerDao->updateDynamicByKey($customerVo);
			if (! is_null ( $subscribe )) {
				$subscribeDao->insertDynamic ( $subscribe );
			}
			$sqlMapClient->endTransaction ();
			return $customerVo->id;
		} catch ( \Exception $e ) {
			$sqlMapClient->rollback ();
			throw $e;
		}
	}
}