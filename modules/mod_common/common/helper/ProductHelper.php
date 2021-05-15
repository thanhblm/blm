<?php


namespace common\helper;


use common\filter\attribute_group\AttributeGroupFilter;
use common\persistence\base\vo\ProductAttributeVo;
use common\services\attribute\AttributeGroupService;
use common\services\attribute\AttributeService;
use common\services\attribute\ProductAttributeService;
use core\config\ApplicationConfig;
use core\utils\AppUtil;

class ProductHelper {
	public static function checkProductShowForCountry($productId){
		$excludeProduct = !is_null(ApplicationConfig::get("exclude.products.id")) ? ApplicationConfig::get("exclude.products.id") : array();
		if (in_array($productId, $excludeProduct)) {
			return true;
		}
		return false;
	}
	public static function getAttributeProduct($productId){
		$attributeSv = new AttributeService();
		$productAttributeSv = new ProductAttributeService();
		$productAttributeVo = new ProductAttributeVo();
		$productAttributeVo->productId = $productId;
		$productAttributeVos = $productAttributeSv->getByFilter($productAttributeVo);

		$attrGroupSv = new AttributeGroupService();
		$attrExtGroupVos = $attrGroupSv->search(new AttributeGroupFilter());

		$listAttrValid = array();
		foreach ($productAttributeVos as $productAttrVo) {
			$groupAttrs = $productAttrVo->attributeId;
			if (!AppUtil::isEmptyString($groupAttrs)) {
				$groupAttrs = json_decode($groupAttrs);
				foreach ($groupAttrs as $groupAttr) {
					array_push($listAttrValid, "" . $groupAttr);
				}
			}
		}

		$listAttrValid = array_unique($listAttrValid);
		$listAttrValidVos  = $attributeSv->getByIds($listAttrValid);
		foreach ($attrExtGroupVos as $attrExtGroupVo){
			foreach ($listAttrValidVos as $listAttrValidVo){
				if($attrExtGroupVo->id === $listAttrValidVo->attrGroupId){
					$attrExtGroupVo->listAttr->add($listAttrValidVo);
				}
			}
		}
		return $attrExtGroupVos;
	}
}