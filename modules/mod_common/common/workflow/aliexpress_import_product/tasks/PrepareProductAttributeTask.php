<?php

namespace common\workflow\aliexpress_import_product\tasks;

use api\common\AliexpressConstants;
use api\service\AliexpressHelper;
use common\persistence\base\vo\ProductAttributeVo;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\vo\ProductVo;
use core\workflow\ContextBase;
use core\workflow\Task;

class PrepareProductAttributeTask implements Task{
	public function execute(ContextBase &$context){
		$html = $context->get(AliexpressConstants::ALIEXPRESS_PRODUCT_DETAIL_HTML);
		$attrGroupExtendVos = AliexpressHelper::loadAttributes($html);
		$productAttributeJson = AliexpressHelper::getProductAttributes($html);
		$context->set(AliexpressConstants::ALIEXPRESS_LIST_ATTRIBUTE_GROUP_EXT_VO, $attrGroupExtendVos);
		$context->set(AliexpressConstants::ALIEXPRESS_PRODUCT_ATTR, $productAttributeJson);
	}
	
}