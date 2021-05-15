<?php

namespace api\controllers;

use common\persistence\base\vo\CurrencyVo;
use common\persistence\base\vo\LanguageVo;
use common\persistence\base\vo\RegionVo;
use common\rule\url\UrlBuilder;
use common\rule\url\UrlParser;
use common\services\currency\CurrencyService;
use common\services\language\LanguageService;
use common\services\region\RegionService;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use api\common\Constants;

class ControllerHelper {
	public static function getLangCode() {
		$langCode = SessionUtil::get ( "language.default.code" );
		if (AppUtil::isEmptyString ( $langCode )) {
			$langCode = ApplicationConfig::get ( "language.default.code" );
		}
		return $langCode;
	}
	public static function getCurrencyCode() {
		$currencyCode = SessionUtil::get ( "currency.default.code" );
		if (AppUtil::isEmptyString ( $currencyCode )) {
			$currencyCode = ApplicationConfig::get ( "currency.default.code" );
		}
		return $currencyCode;
	}
	public static function getRegionId() {
		$regionId = SessionUtil::get ( "region.default.id" );
		if (AppUtil::isEmptyString ( $regionId )) {
			$regionId = ApplicationConfig::get ( "region.default.id" );
		}
		return $regionId;
	}
	public static function getLang() {
		$filter = new LanguageVo ();
		$filter->code = self::getLangCode ();
		$languageService = new LanguageService ();
		$languageVo = $languageService->getLanguageByCode ( $filter );
		return $languageVo;
	}
	public static function getRegion() {
		return self::getRegionById ( self::getRegionId () );
	}
	public static function getCurrency() {
		return self::getCurrencyByCode ( self::getCurrencyCode () );
	}
	public static function showProductPrice($price, $regionId = null) {
		if (! is_null ( $regionId )) {
			$regionVo = self::getRegionById ( $regionId );
			if (is_null ( $regionVo )) {
				return $price;
			}
			$currencyVo = self::getCurrencyByCode ( $regionVo->currencyCode );
		} else {
			$currencyVo = self::getCurrency ();
		}
		if (is_null ( $currencyVo ) || "active" !== $currencyVo->status) {
			return $price;
		}
		$showPrice = number_format ( $price, $currencyVo->decimal);
		if ("before" === $currencyVo->placement) {
			$showPrice = $currencyVo->symbol . $showPrice;
		} else if ("after" === $currencyVo->placement) {
			$showPrice = $showPrice . $currencyVo->symbol;
		}
		return $showPrice;
	}
	public static function getFriendlyUrl($url) {
		// Parse the input url.
		$urlParser = new UrlParser ( $url );
		// Build URL with no language.
		$urlBuilder = new UrlBuilder ();
		$urlBuilder->protocol ( $urlParser->getProtocol () )->host ( $urlParser->getHost () )->context ( $urlParser->getContext () )->path ( $urlParser->getPath () )->query ( $urlParser->getQueryString () );
		$oldUrl = $urlBuilder->getUrl ();
		// Rebuild url.
		foreach ( ApplicationConfig::get ( "url.friendly.list" ) as $urlFriendly ) {
			$urlBuilder->lang ( self::getLangCode () );
			$newUrl = $urlBuilder->getUrl ();
			$urlFriendlyObject = new $urlFriendly ( $newUrl );
			$url = $urlFriendlyObject->getUrl ();
			if (! is_null ( $url )) {
				$newUrl = $urlFriendlyObject->rebuild ();
				return $newUrl;
			}
		}
		return $oldUrl;
	}
	private static function getRegionById($regionId) {
		$filter = new RegionVo ();
		$filter->id = $regionId;
		$regionService = new RegionService ();
		$regionVo = $regionService->getById ( $filter );
		return $regionVo;
	}
	private static function getCurrencyByCode($currencyCode) {
		$filter = new CurrencyVo ();
		$filter->code = $currencyCode;
		$currencyService = new CurrencyService ();
		$currencyVo = $currencyService->getById ( $filter );
		return $currencyVo;
	}
	public static function getRequestActionPath() {
		$urlParser = new UrlParser ( AppUtil::getFullUrl () );
		return $urlParser->getPath ();
	}

	public static function isGuestLogin() {
		if(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId == 0){
			return true;
		}else{
			return false;
		}
	}
}