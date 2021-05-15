<?php

namespace common\workflow\aliexpress_import_product\tasks;

use api\common\AliexpressConstants;
use api\service\AliexpressHelper;
use common\persistence\base\vo\BulkDiscountVo;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\extend\vo\ProductBulkDiscountVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class PrepareProductPriceTask implements Task{
	public function execute(ContextBase &$context){
		$html = $context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_DETAIL_HTML);
		$productPrice = new ProductPriceVo();
		$productPrice->price =  AliexpressHelper::getProductMinPrice($html);
		$productPrice->maxPrice = AliexpressHelper::getProductMaxPrice($html);
		$productPrice->minPrice = AliexpressHelper::getProductMinPrice($html);
		$productPrice->currencyCode = "USD";

		$bulkDiscount = new BulkDiscountVo();
		$bulkDiscount->mdDate = date("Y-m-d h:i:s");
		$bulkDiscount->crDate = date("Y-m-d h:i:s");
		$bulkDiscount->crBy = 0;
		$bulkDiscount->mdBy = 0;
		$bulkDiscount->status = "active";
		$bulkDiscount->discount = AliexpressHelper::getProductDiscount($html);
		$bulkDiscount->validFrom = date("Y-m-d h:i:s");
		$bulkDiscount->validTo = date('Y-m-d h:i:s', strtotime(' +'.AliexpressHelper::getProductDiscountTimeLeft($html).' day'));
		$bulkDiscount->name = "Buy 1 pcs and get ".$bulkDiscount->discount."% off to " . $bulkDiscount->validTo;

		$context->set(AliexpressConstants::ALIEXPRESS_PRODUCT_PRICE_VO, $productPrice);
		$context->set(AliexpressConstants::ALIEXPRESS_BULK_DISCOUNT_VO, $bulkDiscount);
	}
	
}