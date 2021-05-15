<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\Task;

class CheckEmptyShoppingCart implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		// Ignore update shopping cart if it's empty.
		if (is_null ( $shoppingCart )) {
			return false;
		}
	}
}