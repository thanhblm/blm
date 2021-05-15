<?php

namespace frontend\service;

use common\helper\AddressHelper;
use common\persistence\base\vo\AddressVo;

class DynamicTaxRateHelper {
	public static function getTaxRateByType($type, AddressVo $addressVo) {
		switch ($type) {
			case "us-wa" :
				$result = AddressHelper::getWashingtonTax ( $addressVo->address, $addressVo->city, $addressVo->postalCode );
				if ($result ["status"]) {
					return $result ["rate"];
				}
				break;
			default :
				break;
		}
		return 0;
	}
}