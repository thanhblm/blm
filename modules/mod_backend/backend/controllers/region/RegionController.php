<?php

namespace backend\controllers\region;

use common\persistence\base\vo\RegionCountryVo;
use common\persistence\base\vo\RegionPaymentMethodVo;
use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\vo\RegionExtendVo;
use common\persistence\extend\vo\RegionPaymentMethodExtendVo;
use common\persistence\extend\vo\RegionShippingMethodExtendVo;
use common\services\country\CountryService;
use common\services\currency\CurrencyService;
use common\services\region\RegionService;
use common\utils\StringUtil;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\ValidateUtil;

class RegionController extends PagingController {
	public $regions;
	public $region;
	public $currencyList;
	public $countryList;
	public $stateList;
	public $regionPaymentMethods;
	public $regionShippingMethods;
	public $regionCountries;
	public $id;
	public $indexRegionCountry;
	public $indexRegionPaymentMethod;
	public $indexRegionShippingMethod;
	private $regionService;
	public $countryId;
	public $stateId;
	public function __construct() {
		parent::__construct ();
		$this->filter = new RegionExtendVo ();
		$this->region = new RegionVo ();
		$this->regions = new Paging ();
		$this->regionCountries = new BaseArray ( RegionCountryVo::class );
		$this->regionPaymentMethods = new BaseArray ( RegionPaymentMethodExtendVo::class );
		$this->regionShippingMethods = new BaseArray ( RegionShippingMethodExtendVo::class );
		$this->regionService = new RegionService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Regions";
	}
	public function listView() {
		$this->getCurrencyList ();
		$this->getRegions ();
		return "success";
	}
	public function search() {
		$this->getCurrencyList ();
		$this->getRegions ();
		return "success";
	}
	public function addView() {
		// Set default status for the region.
		$this->region->status = "active";
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getRegionShippingMethods ();
		$this->getRegionPaymentMethods ();
		return "success";
	}
	public function addRegionCountry() {
		$this->getCountryList ();
		return "success";
	}
	public function addRegionShippingMethod() {
		$this->getShippingMethod ();
		return "success";
	}
	public function addRegionPaymentMethod() {
		$this->getPaymentMethod ();
		return "success";
	}
	public function add() {
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getRegionShippingMethods ();
		$this->getRegionPaymentMethods ();
		$this->validate ();
		$this->prepareStates ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->region->crDate = date ( 'Y-m-d H:i:s' );
		$this->region->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->region->mdDate = date ( 'Y-m-d H:i:s' );
		$this->region->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->regionService->addRegion ( $this->region, $this->regionCountries, $this->regionShippingMethods, $this->regionPaymentMethods );
		$this->addActionMessage ( "The region added successfully" );
		return "success";
	}
	public function addToEdit() {
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getShippingMethod ();
		$this->getPaymentMethod ();
		$this->validate ();
		$this->prepareStates ();
		if ($this->hasErrors ()) {
			return "success";
		}
		if (! empty ( $this->region->id ) || $this->region->id > 0) {
			$this->region->mdDate = date ( 'Y-m-d H:i:s' );
			$this->region->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
			$this->regionService->updateRegion ( $this->region, $this->regionCountries, $this->regionShippingMethods, $this->regionPaymentMethods );
			$regionId = $this->region->id;
		} else {
			$this->region->crDate = date ( 'Y-m-d H:i:s' );
			$this->region->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
			$this->region->mdDate = date ( 'Y-m-d H:i:s' );
			$this->region->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
			$regionId = $this->regionService->addRegion ( $this->region, $this->regionCountries, $this->regionShippingMethods, $this->regionPaymentMethods );
			$this->region->id = $regionId;
		}
		$this->addExtraData ( "regionId", $regionId );
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No region for editing" );
		}
		// Load data
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getShippingMethod ();
		$this->getPaymentMethod ();
		
		$filter = new RegionVo ();
		$filter->id = $this->id;
		$this->region = $this->regionService->getById ( $filter );
		
		$regionCountryVo = new RegionCountryVo ();
		$regionCountryVo->regionId = $this->id;
		$this->getRegionCountries ( $regionCountryVo );
		$this->prepareStates ();
		$regionShippingMethodVo = new RegionShippingMethodVo ();
		$regionShippingMethodVo->regionId = $this->id;
		$this->getRegionShippingMethods ( $regionShippingMethodVo );
		
		$regionPaymentMethodVo = new RegionPaymentMethodVo ();
		$regionPaymentMethodVo->regionId = $this->id;
		$this->getRegionPaymentMethods ( $regionPaymentMethodVo );
		
		return "success";
	}
	public function edit() {
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getShippingMethod ();
		$this->getPaymentMethod ();
		$this->validate ();
		$this->prepareStates ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->region->mdDate = date ( 'Y-m-d H:i:s' );
		$this->region->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->regionService->updateRegion ( $this->region, $this->regionCountries, $this->regionShippingMethods, $this->regionPaymentMethods );
		$this->addActionMessage ( "The region updated successfully" );
		return "success";
	}
	public function copyView() {
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getShippingMethod ();
		$this->getPaymentMethod ();
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No region for cloning" );
		}
		// Load region.
		$filter = new RegionVo ();
		$filter->id = $this->id;
		$this->region = $this->regionService->getById ( $filter );
		
		$regionCountryVo = new RegionCountryVo ();
		$regionCountryVo->regionId = $this->id;
		$this->getRegionCountries ( $regionCountryVo );
		$this->prepareStates ();
		$regionShippingMethodVo = new RegionShippingMethodVo ();
		$regionShippingMethodVo->regionId = $this->id;
		$this->getRegionShippingMethods ( $regionShippingMethodVo );
		
		$regionPaymentMethodVo = new RegionPaymentMethodVo ();
		$regionPaymentMethodVo->regionId = $this->id;
		$this->getRegionPaymentMethods ( $regionPaymentMethodVo );
		
		// Set empty auto increase column.
		$this->region->id = null;
		return "success";
	}
	public function copy() {
		$this->getCountryList ();
		$this->getCurrencyList ();
		$this->getShippingMethod ();
		$this->getPaymentMethod ();
		$this->validate ();
		$this->prepareStates ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->region->crDate = date ( 'Y-m-d H:i:s' );
		$this->region->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->region->mdDate = date ( 'Y-m-d H:i:s' );
		$this->region->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->regionService->addRegion ( $this->region, $this->regionCountries, $this->regionShippingMethods, $this->regionPaymentMethods );
		$this->addActionMessage ( "The subscriber cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No region for deleting" );
		}
		// Load system setting group.
		$filter = new RegionVo ();
		$filter->id = $this->id;
		$this->region = $this->regionService->getById ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No region for deleting" );
		}
		// Delete Region
		$filter = new RegionVo ();
		$filter->id = $this->id;
		$this->regionService->deleteRegion ( $filter );
		$this->addActionMessage ( "The region deleted successfully" );
		return "success";
	}
	public function getStates() {
		if (empty ( $this->countryId )) {
			$this->countryId = - 1;
		}
		$stateVo = new StateVo ();
		$stateVo->country = $this->countryId;
		$stateVo->order_by = "name asc";
		$states = $this->regionService->getStateByFilter ( $stateVo );
		$this->stateList = $states;
		return "success";
	}
	public function getRegionState() {
		$regionCountryVo = new RegionCountryVo ();
		$regionCountryVo->regionId = $this->id;
		$regionCountryVo->countryId = $this->countryId;
		$regionStates = $this->regionService->getRegionCountryByFilter ( $regionCountryVo );
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->region->name )) {
			$this->addFieldError ( "region[name]", "Name is required" );
		}
		if (AppUtil::isEmptyString ( $this->region->freeShippingAmount )) {
			$this->addFieldError ( "region[freeShippingAmount]", "Free shipping amount is required" );
		} else if (! ValidateUtil::isFloat ( $this->region->freeShippingAmount )) {
			$this->addFieldError ( "region[freeShippingAmount]", "Free shipping amount must be a number" );
		}
		if (! AppUtil::isEmptyString ( $this->region->contactEmail ) & ! ValidateUtil::isEmail ( $this->region->contactEmail )) {
			$this->addFieldError ( "region[contactEmail]", "Email is not valid" );
		}
		if (AppUtil::isEmptyString ( $this->region->currencyCode )) {
			$this->addFieldError ( "region[currencyCode]", "Currency is required" );
		}
		if (AppUtil::isEmptyString ( $this->region->fallbackRegion )) {
			$this->addFieldError ( "region[fallbackRegion]", "Fallback Region is required" );
		} else {
			if (! in_array ( $this->region->fallbackRegion, array_keys ( ApplicationConfig::get ( "region.fallback.list" ) ) )) {
				$this->addFieldError ( "region[fallbackRegion]", "Fallback Region is invalid" );
			}
		}
		if (AppUtil::isEmptyString ( $this->region->status )) {
			$this->addFieldError ( "region[status]", "Status is required" );
		} else {
			if (! in_array ( $this->region->status, array_keys ( ApplicationConfig::get ( "common.status.list" ) ) )) {
				$this->addFieldError ( "region[status]", "Status is invalid" );
			}
		}
		// Validate locations.
		if (! is_null ( $this->regionCountries ) && ! empty ( $this->regionCountries->getArray () )) {
			$index = 0;
			foreach ( $this->regionCountries->getArray () as $regionCountryVo ) {
				if (AppUtil::isEmptyString ( $regionCountryVo->countryId )) {
					$fieldName = "regionCountries[" . $index . "][countryId]";
					$this->addFieldError ( $fieldName, "Country is required" );
				}
				$index ++;
			}
		}
		
		if (! is_null ( $this->regionShippingMethods ) && ! empty ( $this->regionShippingMethods->getArray () )) {
			$index = 0;
			foreach ( $this->regionShippingMethods->getArray () as $regionShippingMethodVo ) {
				if (AppUtil::isEmptyString ( $regionShippingMethodVo->shippingMethodId )) {
					$fieldName = "regionShippingMethods[" . $index . "][shippingMethodId]";
					$this->addFieldError ( $fieldName, "Shipping Method is required" );
				}
				$index ++;
			}
		}
		
		if (! is_null ( $this->regionPaymentMethods ) && ! empty ( $this->regionPaymentMethods->getArray () )) {
			$index = 0;
			foreach ( $this->regionPaymentMethods->getArray () as $regionPaymentMethodVo ) {
				if (AppUtil::isEmptyString ( $regionPaymentMethodVo->paymentMethodId )) {
					$fieldName = "regionPaymentMethods[" . $index . "][paymentMethodId]";
					$this->addFieldError ( $fieldName, "Payment Method is required" );
				}
				$index ++;
			}
		}
	}
	protected function getRegions() {
		$filter = $this->buildFilter ();
		// Get total records of regions.
		$count = $this->regionService->getCountByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get regions.
		$regions = $this->regionService->getByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $regions );
		$this->regions = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		StringUtil::clearObject ( $filter );
		return $this->format2Query ( $filter );
	}
	protected function format2Show(RegionExtendVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$mo->crDate = DateTimeUtil::mySqlStringDate2String ( $mo->crDate, DateTimeUtil::getDateTimeFormat () );
		$mo->mdDate = DateTimeUtil::mySqlStringDate2String ( $mo->mdDate, DateTimeUtil::getDateTimeFormat () );
		$statuses = ApplicationConfig::get ( "common.status.list" );
		$mo->status = AppUtil::arrayValue ( $statuses, $mo->status );
		$fallBackRegions = ApplicationConfig::get ( "region.fallback.list" );
		$mo->fallbackRegion = AppUtil::arrayValue ( $fallBackRegions, $mo->fallbackRegion );
		return $mo;
	}
	protected function format2Query(RegionExtendVo $mo) {
		$vo = AppUtil::cloneObj ( $mo );
		$vo->crDateFrom = DateTimeUtil::appendTime ( $vo->crDateFrom );
		$vo->crDateTo = DateTimeUtil::appendTime ( $vo->crDateTo, false );
		$vo->mdDateFrom = DateTimeUtil::appendTime ( $vo->mdDateFrom );
		$vo->mdDateTo = DateTimeUtil::appendTime ( $vo->mdDateTo, false );
		$vo->crDateFrom = DateTimeUtil::string2MySqlDate ( $vo->crDateFrom, DateTimeUtil::getDateTimeFormat () );
		$vo->crDateTo = DateTimeUtil::string2MySqlDate ( $vo->crDateTo, DateTimeUtil::getDateTimeFormat () );
		$vo->mdDateFrom = DateTimeUtil::string2MySqlDate ( $vo->mdDateFrom, DateTimeUtil::getDateTimeFormat () );
		$vo->mdDateTo = DateTimeUtil::string2MySqlDate ( $vo->mdDateTo, DateTimeUtil::getDateTimeFormat () );
		return $vo;
	}
	protected function formatList2Show($vos) {
		if (is_null ( $vos ) || count ( $vos ) == 0) {
			return array ();
		}
		$arr = array ();
		foreach ( $vos as $vo ) {
			$arr [] = $this->format2Show ( $vo );
		}
		return $arr;
	}
	protected function getCurrencyList() {
		$currency = new CurrencyService ();
		$this->currencyList = $currency->getAll ();
	}
	protected function getCountryList() {
		$country = new CountryService ();
		$this->countryList = $country->getAll ();
	}
	protected function getShippingMethod() {
		$this->shippingMethodList = $this->regionService->getAllShippingMethod ();
	}
	protected function getPaymentMethod() {
		$this->paymentMethodList = $this->regionService->getAllPaymentMethod ();
	}
	protected function getRegionCountries(RegionCountryVo $regionCountryVo) {
		$regionCountries = $this->regionService->getRegionCountryByFilter ( $regionCountryVo );
		foreach ( $regionCountries as $regionCountry ) {
			$this->regionCountries->add ( $regionCountry );
		}
	}
	private function prepareStates() {
		// Get states list foreach country.
		$this->stateList = array ();
		foreach ( $this->regionCountries->getArray () as $regionCountry ) {
			$stateVo = new StateVo ();
			$stateVo->country = empty ( $regionCountry->countryId ) ? - 1 : $regionCountry->countryId;
			$stateVo->order_by = "name asc";
			$this->stateList [$regionCountry->countryId] = $this->regionService->getStateByFilter ( $stateVo );
		}
	}
	protected function getRegionShippingMethods() {
		$regionVo = new RegionVo ();
		$regionVo->id = AppUtil::isEmptyString ( $this->id ) ? - 1 : $this->id;
		$regionShippingMethods = $this->regionService->getShippingMethodByRegion ( $regionVo );
		$regionShippingMethodArray = new BaseArray ( RegionShippingMethodExtendVo::class );
		if (! empty ( $regionShippingMethods )) {
			foreach ( $regionShippingMethods as $regionShippingMethod ) {
				$regionShippingMethod->settingInfo = base64_encode ( $regionShippingMethod->settingInfo );
				$regionShippingMethodArray->add ( $regionShippingMethod );
			}
		}
		$this->regionShippingMethods = $regionShippingMethodArray;
	}
	protected function getRegionPaymentMethods() {
		$regionVo = new RegionVo ();
		$regionVo->id = AppUtil::isEmptyString ( $this->id ) ? - 1 : $this->id;
		$regionPaymentMethods = $this->regionService->getPaymentMethodByRegion ( $regionVo );
		$regionPaymentMethodArray = new BaseArray ( RegionPaymentMethodExtendVo::class );
		if (! empty ( $regionPaymentMethods )) {
			foreach ( $regionPaymentMethods as $regionPaymentMethod ) {
				$regionPaymentMethod->settingInfo = base64_encode ( $regionPaymentMethod->settingInfo );
				$regionPaymentMethodArray->add ( $regionPaymentMethod );
			}
		}
		$this->regionPaymentMethods = $regionPaymentMethodArray;
	}
}