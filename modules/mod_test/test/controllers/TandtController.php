<?php

namespace test\controllers;

use api\service\AliexpressHelper;
use common\filter\attribute_group\AttributeGroupFilter;
use common\helper\ProductHelper;
use common\persistence\base\vo\ProductAttributeVo;
use common\services\attribute\AttributeGroupService;
use common\services\attribute\AttributeService;
use common\services\attribute\ProductAttributeService;
use common\utils\StringUtil;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\Controller;
use core\utils\AppUtil;
use core\utils\RouteUtil;

class TandtController extends Controller{
	public $result;

	public function __construct(){
		parent::__construct();
	}

	public function test(){
		var_dump(StringUtil::slugify("Trà Thái Nguyên"));die();


		die();
		//var_dump(StringUtil::slugify("20 style 2017 fashion new women pattern dress casual summer dresses S M L XL XXL-in Dresses from Women"));die();

		$url = "https://www.aliexpress.com/item/2016-New-Autumn-Winter-Warm-Thick-Solid-Hoodies-Mens-Sweatshirt-Casual-Brand-Tracksuit-Sweatshirts-Men-Designer/32737875779.html?spm=2114.search0103.3.11.8sUQtC&ws_ab_test=searchweb0_0,searchweb201602_5_10152_10065_10151_10068_10084_10083_10080_10082_10081_10110_10137_10175_10111_10060_10112_10113_10155_10114_10154_438_10056_10055_10054_10182_10059_9871_100031_10099_10078_10079_9875_10103_10073_10102_5360020_10189_10052_10053_10142_10107_10050_10051-9871_9875,searchweb201603_16,ppcSwitch_5&btsid=9f726987-fe87-4134-aa1d-0f3ab47097bb&algo_expid=472f46ab-6f36-4d83-90b2-2d3c705433cb-1&algo_pvid=472f46ab-6f36-4d83-90b2-2d3c705433cb";
		$html = file_get_contents($url);
		//$json = '[{"skuAttr":"14:173#Dark Blue;5:361385","skuPropIds":"173,361385","skuVal":{"availQuantity":0,"inventory":0,"isActivity":false,"skuCalPrice":"21.49","skuMultiCurrencyCalPrice":"21.49","skuMultiCurrencyDisplayPrice":"21.49"}},{"skuAttr":"14:173#Dark Blue;5:100014065","skuPropIds":"173,100014065","skuVal":{"availQuantity":2,"inventory":9,"isActivity":false,"skuCalPrice":"21.49","skuMultiCurrencyCalPrice":"21.49","skuMultiCurrencyDisplayPrice":"21.49"}},{"skuAttr":"14:173#Dark Blue;5:4182","skuPropIds":"173,4182","skuVal":{"availQuantity":6,"inventory":9,"isActivity":false,"skuCalPrice":"22.49","skuMultiCurrencyCalPrice":"22.49","skuMultiCurrencyDisplayPrice":"22.49"}},{"skuAttr":"14:173#Dark Blue;5:4183","skuPropIds":"173,4183","skuVal":{"availQuantity":1,"inventory":5,"isActivity":false,"skuCalPrice":"22.49","skuMultiCurrencyCalPrice":"22.49","skuMultiCurrencyDisplayPrice":"22.49"}},{"skuAttr":"14:173#Dark Blue;5:200000990","skuPropIds":"173,200000990","skuVal":{"availQuantity":1,"inventory":5,"isActivity":false,"skuCalPrice":"23.49","skuMultiCurrencyCalPrice":"23.49","skuMultiCurrencyDisplayPrice":"23.49"}},{"skuAttr":"14:173#Dark Blue;5:200000991","skuPropIds":"173,200000991","skuVal":{"availQuantity":1,"inventory":5,"isActivity":false,"skuCalPrice":"23.49","skuMultiCurrencyCalPrice":"23.49","skuMultiCurrencyDisplayPrice":"23.49"}},{"skuAttr":"14:173#Dark Blue;5:361386","skuPropIds":"173,361386","skuVal":{"availQuantity":0,"inventory":0,"isActivity":false,"skuCalPrice":"20.49","skuMultiCurrencyCalPrice":"20.49","skuMultiCurrencyDisplayPrice":"20.49"}},{"skuAttr":"14:173#Dark Blue;5:100014064","skuPropIds":"173,100014064","skuVal":{"availQuantity":4,"inventory":9,"isActivity":false,"skuCalPrice":"20.49","skuMultiCurrencyCalPrice":"20.49","skuMultiCurrencyDisplayPrice":"20.49"}},{"skuAttr":"14:175#Green;5:361385","skuPropIds":"175,361385","skuVal":{"availQuantity":5,"inventory":7,"isActivity":false,"skuCalPrice":"20.49","skuMultiCurrencyCalPrice":"20.49","skuMultiCurrencyDisplayPrice":"20.49"}},{"skuAttr":"14:175#Green;5:100014065","skuPropIds":"175,100014065","skuVal":{"availQuantity":6,"inventory":7,"isActivity":false,"skuCalPrice":"20.49","skuMultiCurrencyCalPrice":"20.49","skuMultiCurrencyDisplayPrice":"20.49"}},{"skuAttr":"14:175#Green;5:4182","skuPropIds":"175,4182","skuVal":{"availQuantity":4,"inventory":5,"isActivity":false,"skuCalPrice":"21.49","skuMultiCurrencyCalPrice":"21.49","skuMultiCurrencyDisplayPrice":"21.49"}},{"skuAttr":"14:175#Green;5:4183","skuPropIds":"175,4183","skuVal":{"availQuantity":1,"inventory":3,"isActivity":false,"skuCalPrice":"21.49","skuMultiCurrencyCalPrice":"21.49","skuMultiCurrencyDisplayPrice":"21.49"}},{"skuAttr":"14:175#Green;5:200000990","skuPropIds":"175,200000990","skuVal":{"availQuantity":3,"inventory":3,"isActivity":false,"skuCalPrice":"22.49","skuMultiCurrencyCalPrice":"22.49","skuMultiCurrencyDisplayPrice":"22.49"}},{"skuAttr":"14:175#Green;5:200000991","skuPropIds":"175,200000991","skuVal":{"availQuantity":3,"inventory":3,"isActivity":false,"skuCalPrice":"22.49","skuMultiCurrencyCalPrice":"22.49","skuMultiCurrencyDisplayPrice":"22.49"}},{"skuAttr":"14:175#Green;5:361386","skuPropIds":"175,361386","skuVal":{"availQuantity":4,"inventory":7,"isActivity":false,"skuCalPrice":"19.49","skuMultiCurrencyCalPrice":"19.49","skuMultiCurrencyDisplayPrice":"19.49"}},{"skuAttr":"14:175#Green;5:100014064","skuPropIds":"175,100014064","skuVal":{"availQuantity":4,"inventory":7,"isActivity":false,"skuCalPrice":"19.49","skuMultiCurrencyCalPrice":"19.49","skuMultiCurrencyDisplayPrice":"19.49"}}]';
		//$viewPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['VIEW_PATH'] . DS . "admin" . DS;


		var_dump(AliexpressHelper::loadAttributes($html)->getArray()[0]->listAttr);
	}

}