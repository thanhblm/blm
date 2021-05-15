<?php

namespace common\helper;

use core\utils\AppUtil;
use core\utils\SessionUtil;

class LocalizationHelper {
	public static function getLangCode(){
		$langCode = null == SessionUtil::get("language.default.code") ? "en" : SessionUtil::get("language.default.code");
		return $langCode;
	}

	public static function getCurrencyCode(){
		$currencyCode = null == SessionUtil::get("currency.default.code") ? "USD" : SessionUtil::get("currency.default.code");
		return $currencyCode;
	}

	public static function getRegionId(){
		$regionId = null == SessionUtil::get("region.default.id") ? 1 : SessionUtil::get("region.default.id");
		return $regionId;
	}

	public static function getCurrentCountryCode(){
		$countryCode = AppUtil::isEmptyString(SessionUtil::get("current.country.code")) ? "" : SessionUtil::get("current.country.code");
		return $countryCode;
	}
}