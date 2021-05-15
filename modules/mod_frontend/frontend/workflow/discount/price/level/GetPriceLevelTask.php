<?php

namespace frontend\workflow\discount\price\level;

use common\config\Attributes;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\PriceLevelVo;
use common\services\price_level\PriceLevelService;
use core\utils\AppUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetPriceLevelTask implements Task {
	public function execute(ContextBase &$context) {
		$customerId = $context->get ( Attributes::CUSTOMER_ID );
		// Ignore get price level if the customer is guest.
		if (AppUtil::isEmptyString ( $customerId )) {
			$context->set ( Attributes::PRICE_LEVEL_INFO, null );
			return true;
		}
		// Get price level info of the customer.
		$filter = new CustomerVo ();
		$filter->id = $customerId;
		$priceLevelService = new PriceLevelService ();
		$priceLevelVo = $priceLevelService->getPriceLevelByCustomerId ( $filter );
		$context->set ( Attributes::PRICE_LEVEL_INFO, $priceLevelVo );
	}
}