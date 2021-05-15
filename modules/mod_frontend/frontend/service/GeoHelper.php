<?php

namespace frontend\service;

use common\persistence\base\dao\StateBaseDao;
use common\persistence\base\vo\StateVo;
use common\persistence\base\dao\CountryBaseDao;
use common\persistence\base\vo\CountryVo;

class GeoHelper {
	public static function getStateNameByStateCode($stateIso2, $countryIso2) {
		$stateDao = new StateBaseDao ();
		$stateVo = new StateVo ();
		$name = null;
		$stateVo->countryIso = $countryIso2;
		$stateVo->iso2 = $stateIso2;
		
		$stateVoList = $stateDao->selectByFilter ( $stateVo );
		foreach ( $stateVoList as $stateVo ) {
			$name = $stateVo->name;
			break;
		}
		return $name;
	}
	public static function getCountryNameByCountryCode($countryIso2) {
		$countryDao = new CountryBaseDao ();
		$countryVo = new CountryVo ();
		$countryVo->iso2 = $countryIso2;
		$countryVoList = $countryDao->selectByFilter ( $countryVo );
		$name = null;
		foreach ( $countryVoList as $countryVo ) {
			$name = $countryVo->name;
			break;
		}
		return $name;
	}
}