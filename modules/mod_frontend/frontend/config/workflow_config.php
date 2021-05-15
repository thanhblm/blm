<?php
return array (
		'shopping_cart_update' => array (
				'task' => array (
					'common\workflow\shopping_cart_update\tasks\PrepareSessionCartTask',
					'common\workflow\shopping_cart_update\tasks\ShoppingCartValid',
					'common\workflow\shopping_cart_update\tasks\ShoppingCartUpdate',
					'common\workflow\shopping_cart_update\tasks\TaxRateValid',
					'common\workflow\shopping_cart_update\tasks\TaxRateApply',
					'common\workflow\shopping_cart_update\tasks\CouponCodeValid',
					'common\workflow\shopping_cart_update\tasks\CouponCodeApplyTask'
				),
				'handle' => array (
					'common\workflow\shopping_cart_update\ShoppingCartHandler'
				),
				'exit_point' => array (
					'common\workflow\shopping_cart_update\ShoppingCartExitFlow'
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: CUSTOMER_ID
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: PRICE_LEVEL_INFO
		// -------------------------------------------------------------------------------------------------
		'wfp_get_price_level' => array (
				'task' => array (
						'frontend\workflow\discount\price\level\GetPriceLevelTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: PRODUCT_ID, PRODUCT_QUANTITY
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: BULK_DISCOUNT_INFO
		// -------------------------------------------------------------------------------------------------
		'wfp_get_bulk_discount' => array (
				'task' => array (
						'frontend\workflow\discount\bulk\GetBulkDiscountTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: CUSTOMER_ID, PRODUCT_ID, PRODUCT_QUANTITY, CURRENCY_CODE
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: PRODUCT_BASE_PRICE, DISCOUNT_AMOUNT, DISCOUNT_PERCENT, PRICE_LEVEL_INFO,
		// BULK_DISCOUNT_INFO, SALE_PRICE
		// -------------------------------------------------------------------------------------------------
		'wfp_get_sale_price' => array (
				'task' => array (
						'frontend\workflow\price\GetBasePriceTask',
						'frontend\workflow\discount\bulk\GetBulkDiscountTask',
						'frontend\workflow\discount\price\level\GetPriceLevelTask',
						'frontend\workflow\price\GetDiscountInfoTask',
						'frontend\workflow\price\GetSalePriceTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: SHOPPING_CART
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: DISCOUNT_COUPON_INFO, DISCOUNT_COUPON_AMOUNT
		// -------------------------------------------------------------------------------------------------
		'wfp_get_discount_coupon' => array (
				'task' => array (
						'frontend\workflow\discount\coupon\GetDiscountCouponTask',
						'frontend\workflow\discount\coupon\CheckValidFromTask',
						'frontend\workflow\discount\coupon\CheckValidToTask',
						'frontend\workflow\discount\coupon\CheckMinOrderTotalTask',
						'frontend\workflow\discount\coupon\CheckMaxUseTask',
						'frontend\workflow\discount\coupon\CheckUsePerCustomerTask',
						'frontend\workflow\discount\coupon\GetApplicableItemsTask',
						'frontend\workflow\discount\coupon\CheckPriceLevelTask',
						'frontend\workflow\discount\coupon\GetDiscountCouponAmountTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: SHIPPING_ADDRESS, BILLING_ADDRESS
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: PRODUCT_TAX_LIST, PRODUCT_TAX_PERCENT
		// -------------------------------------------------------------------------------------------------
		'wfp_get_product_tax' => array (
				'task' => array (
						'frontend\workflow\tax\rate\GetProductTaxRatesTask',
						'frontend\workflow\tax\rate\GetProductTaxPercentTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: SHIPPING_ADDRESS, BILLING_ADDRESS
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: SHIPPING_TAX_LIST, SHIPPING_TAX_PERCENT
		// -------------------------------------------------------------------------------------------------
		'wfp_get_shipping_tax' => array (
				'task' => array (
						'frontend\workflow\tax\shipping\GetShippingTaxRatesTask',
						'frontend\workflow\tax\shipping\GetShippingTaxPercentTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: SHIPPING_ADDRESS, SHIPPING_METHOD_ID, SHIPPING_METHOD_INFO
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: SHIPPING_COST
		// -------------------------------------------------------------------------------------------------
		'wfp_get_shipping_cost' => array (
				'task' => array (
						'frontend\workflow\shipping\GetShippingCostTask' 
				) 
		),
		// -------------------------------------------------------------------------------------------------
		// INPUT: SHOPPING_CART
		// -------------------------------------------------------------------------------------------------
		// OUTPUT: SHOPPING_CART
		// -------------------------------------------------------------------------------------------------
		'wfp_update_shopping_cart' => array (
				'task' => array (
						'frontend\workflow\cart\CheckEmptyShoppingCart',
						'frontend\workflow\cart\UpdateCustomerInfoTask',
						'frontend\workflow\cart\PrepareShippingAndBillingAddress',
						'frontend\workflow\cart\UpdateOrderValuesTask',
						'frontend\workflow\cart\UpdateShippingTaxTask',
						'frontend\workflow\cart\UpdateDiscountCouponTask',
						'frontend\workflow\cart\UpdateGrandTotalTask',
						'frontend\workflow\cart\UpdateOrderTotalsTask'
				) 
		) 
);