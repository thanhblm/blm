<?php

namespace frontend\workflow\discount\bulk;

use common\config\Attributes;
use common\persistence\extend\vo\ProductBulkDiscountVo;
use common\services\bulk_discount\BulkDiscountService;
use core\workflow\ContextBase;
use core\workflow\Task;

class GetBulkDiscountTask implements Task {
	public function execute(ContextBase &$context) {
		$productId = $context->get ( Attributes::PRODUCT_ID );
		$quantity = $context->get ( Attributes::PRODUCT_QUANTITY );
		// Get bulk discount info.
		$filter = new ProductBulkDiscountVo ();
		$filter->productId = $productId;
		$filter->quantity = $quantity;
		$filter->date = date ( 'Y-m-d' ); // date ( 'Y-m-d H:i:s' );
		$bulkDiscountService = new BulkDiscountService ();
		$bulkDiscountVo = $bulkDiscountService->getApplyBulkDiscountForProduct ( $filter );
		$context->set ( Attributes::BULK_DISCOUNT_INFO, $bulkDiscountVo );
	}
}