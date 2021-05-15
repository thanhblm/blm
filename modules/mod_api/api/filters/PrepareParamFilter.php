<?php

namespace api\filters;

use common\persistence\base\dao\CountryBaseDao;
use common\persistence\base\dao\RegionCountryBaseDao;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\RegionCountryVo;
use common\persistence\base\vo\RegionVo;
use common\services\region\RegionService;
use common\utils\IpUtils;
use core\config\ApplicationConfig;
use core\filters\Filter;
use core\utils\SessionUtil;
use common\persistence\base\dao\RegionBaseDao;

class PrepareParamFilter implements Filter {
	public function init($filterConfig){
	}

	public function doFilter($filterChain){
		//recache system setting cache
		//$settingCache = SessionUtil::remove(ApplicationConfig::get("cache.settings.name"));
		$this->prepareRegionId();
		$this->prepareCurrencyCode();
		$this->prepareLanguageCode();
		$filterChain->doFilter();
	}

	private function prepareRegionId(){
		if (is_null(SessionUtil::get("region.default.id")) || is_null(SessionUtil::get(ApplicationConfig::get("session.user.login.name")))) {
			$countryCode = null;
			try {
				// Get current IP.
				$ip = IpUtils::getClientIp();
				// Get country code of the IP.
				$countryCode = IpUtils::getCountryByIP($ip);
				if (empty ($countryCode)) {
					$countryCode = IpUtils::getCountryByIPviaAPI($ip);
				}
				$countryCode = "-" === $countryCode ? "" : $countryCode;
				SessionUtil::set('current.country.code', $countryCode);
			} catch (\Exception $e) {
				\DatoLogUtil::warn("Cannot detect the region of the client IP address", $e);
			}
			// If IP was detected.
			if (!empty ($countryCode)) {
				// Get country id by country code.
				$countryVo = new CountryVo ();
				$countryVo->iso2 = $countryCode;
				$countryBaseDao = new CountryBaseDao ();
				$countries = $countryBaseDao->selectByFilter($countryVo);
				$countryId = empty ($countries) ? 0 : $countries [0]->id;
				// Get region id by country id.
				$regionCountryDao = new RegionCountryBaseDao ();
				$regionCountryVo = new RegionCountryVo ();
				$regionCountryVo->countryId = $countryId;
				$regionCountries = $regionCountryDao->selectByFilter($regionCountryVo);
				if (empty ($regionCountries)) {
					SessionUtil::set("region.default.id", ApplicationConfig::get("region.default.id"));
				} else {
					// Get region information.
					$regionFilter = new RegionVo();
					$regionFilter->id = $regionCountries [0]->regionId;
					$regionDao = new RegionBaseDao();
					$regionVo = $regionDao->selectByKey($regionFilter);
					// Check if the region is active or not?
					if ($regionVo!=null && "active"===$regionVo->status){
						SessionUtil::set("region.default.id", $regionVo->id);
					} else {
						// Get fallback region.
						$fallbackRegionFilter = new RegionVo();
						$fallbackRegionFilter->fallbackRegion = "yes";
						$fallbackRegionFilter->start_record = 0;
						$fallbackRegionFilter->end_record = 1;
						$fallbackRegionVos = $regionDao->selectByFilter($fallbackRegionFilter);
						if (is_null($fallbackRegionVos) || count($fallbackRegionVos)<=0){
							SessionUtil::set("region.default.id", ApplicationConfig::get("region.default.id"));
						} else {
							SessionUtil::set("region.default.id", $fallbackRegionVos[0]->id);
						}
					}
				}
			} else {
				SessionUtil::set("region.default.id", ApplicationConfig::get("region.default.id"));
			}
		}
	}

	private function prepareCurrencyCode(){
		if (is_null(SessionUtil::get("currency.default.code"))) {
			$regionService = new RegionService ();
			$filter = new RegionVo ();
			$filter->id = SessionUtil::get("region.default.id");
			$regionVo = $regionService->getById($filter);
			if (!is_null($regionVo)) {
				SessionUtil::set("currency.default.code", $regionVo->currencyCode);
			}
		}
	}

	private function prepareLanguageCode(){
		if (is_null(SessionUtil::get("language.default.code"))) {
			SessionUtil::set("language.default.code", ApplicationConfig::get("language.default.code"));
		}
	}
}