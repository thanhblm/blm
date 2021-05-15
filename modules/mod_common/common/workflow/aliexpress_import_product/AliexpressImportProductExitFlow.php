<?php

namespace common\workflow\aliexpress_import_product;

use api\common\AliexpressConstants;
use api\service\AliexpressHelper;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductRegionVo;
use common\persistence\extend\vo\ProductLangExtendVo;
use common\persistence\extend\vo\ProductRelationExtendVo;
use common\persistence\extend\vo\ProductSeoExtendVo;
use common\services\product\ProductService;
use core\BaseArray;
use core\workflow\ContextBase;
use core\workflow\ExitFlow;

class AliexpressImportProductExitFlow extends ExitFlow {
	public function process(ContextBase &$context) {
		$productSv = new ProductService();
		$productVo = $context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_VO);
		$imageUrls = json_decode($productVo->images);
		$imageProduct = array();
		foreach ($imageUrls as $key => $imageUrl){
			$imageProduct[] = AliexpressHelper::importImageFromUrl($imageUrl, 'product', $key);
		}
		$productVo->images = json_encode($imageProduct);
		$productLangs = new BaseArray ( ProductLangExtendVo::class );
		$productLangs->add($context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_LANG_VO));
		$productPrices = new BaseArray ( ProductPriceVo::class );
		$productPrices->add($context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_PRICE_VO));
		$productRelations =  new BaseArray ( ProductRelationExtendVo::class );
		$productRegions = new BaseArray ( ProductRegionVo::class );
		$productRegionVo = new ProductRegionVo();
		$productRegionVo->regionId = 4426;
		$productRegions->add($productRegionVo);
		$productRegionVo2 = new ProductRegionVo();
		$productRegionVo2->regionId = 4429;
		$productRegions->add($productRegionVo2);

		$productSeos = new BaseArray ( ProductSeoExtendVo::class );
		$productSeos->add($context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_SEO_INFO_VO));

		$bulkDiscountVo = $context->get(AliexpressConstants::ALIEXPRESS_BULK_DISCOUNT_VO);
		$attrGroupVos = $context->get(AliexpressConstants::ALIEXPRESS_LIST_ATTRIBUTE_GROUP_EXT_VO);
		$productAttributeJson = $context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_ATTR);
		$productSv->insertAllAliexpress(
								$productVo,
								$productLangs,
								$productPrices,
								$productRelations,
								$productRegions,
								$productSeos,
								$bulkDiscountVo,
								$attrGroupVos,
								$productAttributeJson);



	}
}