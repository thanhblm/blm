<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use frontend\common\Constants;

class UpdateCustomerInfoTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )) {
			$shoppingCart->order->customerId = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		}
	}
}