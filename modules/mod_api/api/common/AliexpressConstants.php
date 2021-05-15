<?php

namespace api\common;

final class AliexpressConstants {
	const ALIEXPRESS_PRODUCT_MIN_PRICE = "window.runParams.minPrice";
	const ALIEXPRESS_PRODUCT_MAX_PRICE = "window.runParams.maxPrice";
	const ALIEXPRESS_BASE_CURRENCE_CODE = "window.runParams.baseCurrencyCode";
	const ALIEXPRESS_BASE_CURRENCE_SYMBOL = "window.runParams.baseCurrencySymbol";
	const ALIEXPRESS_PRODUCT_ID = "window.runParams.productId";
	const ALIEXPRESS_PRODUCT_SIZE_PARAMS = "window.runParams.title";
	const ALIEXPRESS_PRODUCT_DISCOUNT_VALUE = "window.runParams.discount";
	const ALIEXPRESS_PRODUCT_ATTR = "var skuProducts";
	const ALIEXPRESS_PRODUCT_CATEGORY = "window.runParams.categoryId";
	const ALIEXPRESS_PRODUCT_TOTAL_ORDER = "window.runParams.productTradeCount";
	const ALIEXPRESS_PRODUCT_DESCRIPTION = "window.runParams.detailDesc";
	const ALIEXPRESS_PRODUCT_IMAGES = "window.runParams.imageBigViewURL";
	const ALIEXPRESS_PRODUCT_URL = "product.url";
	const ALIEXPRESS_PRODUCT_DETAIL_HTML = "product.detail.html";
	const ALIEXPRESS_PRODUCT_IMPORT_WFL = "aliexpress_import_product";
	const ALIEXPRESS_PRODUCT_VO = "productVo";
	const ALIEXPRESS_PRODUCT_PRICE_VO = "productPriceVo";
	const ALIEXPRESS_BULK_DISCOUNT_VO = "bulkDiscountVo";
	const ALIEXPRESS_PRODUCT_BULK_DISCOUNT_VO = "productBulkDiscountVo";
	const ALIEXPRESS_PRODUCT_ATTRIBUTE_VO = "productAttributeVo";
	const ALIEXPRESS_ATTRIBUTE_VO = "attributeVo";
	const ALIEXPRESS_ATTRIBUTE_GROUP_VO = "attributeGroupVo";
	const ALIEXPRESS_LIST_ATTRIBUTE_GROUP_EXT_VO = "attrGroupExtendVo";
	const ALIEXPRESS_PRODUCT_SEO_INFO_VO = "seoInfoLangVo";
	const ALIEXPRESS_PRODUCT_LANG_VO = "productLangVo";

}