<?php

namespace common\workflow\aliexpress_import_product\tasks;

use api\common\AliexpressConstants;
use api\service\AliexpressHelper;
use common\persistence\base\vo\ProductRegionVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\ProductLangExtendVo;
use common\persistence\extend\vo\ProductSeoExtendVo;
use common\utils\StringUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class PrepareProductDetailTask implements Task{
	public function execute(ContextBase &$context){
		$html = $context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_DETAIL_HTML);

		$product = new ProductVo();
		$product->status = "inactive";
		$product->type = "normal";
		$product->categoryId = "668808"; // ProductImport
		$product->name = AliexpressHelper::getProductTitle($html);
		$product->taxRateId = 2;
		$product->code = AliexpressHelper::getProductId($html);
		$product->itemCode = $product->code;
		$product->composition = AliexpressHelper::getProductShortDescript($html);
		$product->description = AliexpressHelper::getProductDescription($html);
		$product->crBy = "1";
		$product->crDate = date ( 'Y-m-d H:i:s' );
		$product->cbdAmount = AliexpressHelper::getProductTag($html);
		$product->mdBy = "1";
		$product->mdDate = date ( 'Y-m-d H:i:s' );
		$product->weight = 0;
		$product->weightUnit = 'lb';
		$product->images = AliexpressHelper::getProductImages($html);

		$seoInfoLang = new ProductSeoExtendVo();
		$seoInfoLang->type = "product";
		$seoInfoLang->title = $product->name;
		$seoInfoLang->languageCode = "en";
		$seoInfoLang->url = StringUtil::slugify($product->name);
		$seoInfoLang->description = $product->composition;
		$seoInfoLang->keywords = AliexpressHelper::getProductTag($html);

		$productLangVo = new ProductLangExtendVo();
		$productLangVo->description = $product->description;
		$productLangVo->languageCode = "en";
		$productLangVo->composition = $product->description;
		$productLangVo->name = $product->name;

		$context->set(AliexpressConstants::ALIEXPRESS_PRODUCT_VO, $product);
		$context->set(AliexpressConstants::ALIEXPRESS_PRODUCT_SEO_INFO_VO, $seoInfoLang);
		$context->set(AliexpressConstants::ALIEXPRESS_PRODUCT_LANG_VO, $productLangVo);
	}
	
}