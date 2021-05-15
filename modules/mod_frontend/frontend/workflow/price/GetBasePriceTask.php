<?php

namespace frontend\workflow\price;

use common\config\Attributes;
use common\config\ErrorCodes;
use common\persistence\base\dao\ProductPriceBaseDao;
use common\persistence\base\vo\ProductPriceVo;
use core\workflow\Task;
use core\workflow\ContextBase;

class GetBasePriceTask implements Task {
	public function execute(ContextBase &$context) {
		$productId = $context->get ( Attributes::PRODUCT_ID );
		$currencyCode = $context->get ( Attributes::CURRENCE_CODE );
		$productPriceDao = new ProductPriceBaseDao ();
		$filter = new ProductPriceVo ();
		$filter->productId = $productId;
		$filter->currencyCode = $currencyCode;
		$productPriceVo = $productPriceDao->selectByKey ( $filter );
		if (is_null ( $productPriceVo )) {
			$context->set ( Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR );
			$context->set ( Attributes::ATTR_ERROR_MESSAGE, "No product to get sale price" );
			return false;
		}
		$context->set ( Attributes::PRODUCT_BASE_PRICE, $productPriceVo->price );
	}
}