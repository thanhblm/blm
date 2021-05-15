<?php

namespace frontend\workflow\cart;

use common\config\Attributes;
use core\workflow\ContextBase;
use core\workflow\Task;

class UpdateGrandTotalTask implements Task {
	public function execute(ContextBase &$context) {
		$shoppingCart = $context->get ( Attributes::SHOPPING_CART );
		$total = $shoppingCart->subTotal + $shoppingCart->taxTotal + $shoppingCart->shipping - $shoppingCart->discount - $shoppingCart->coupon;
		$shoppingCart->total = $total;
	}
}