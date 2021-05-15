<?php

namespace backend\controllers\region;

use common\persistence\extend\vo\CurrencyExtendVo;
use common\services\currency\CurrencyService;
use common\services\tax\TaxRateService;
use common\services\tax_shipping_zone\TaxShippingZoneService;
use common\vo\region\shipping_method\flat_rate\FlatRateSettingVo;
use common\vo\region\shipping_method\flat_rate\FlatRateShippingMethodVo;
use core\config\ApplicationConfig;
use core\Controller;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\utils\ValidateUtil;

class FlatRateSettingController extends Controller {
	public $index;
	public $setting;
	public $regionShippingMethodSetting;
	public $currencies;
	public $taxClasses;
	public $shippingZones;
	private $currencyService;
	private $taxRateService;
	private $taxShippingZoneService;
	public function __construct() {
		parent::__construct ();
		$this->currencyService = new CurrencyService ();
		$this->taxRateService = new TaxRateService ();
		$this->taxShippingZoneService = new TaxShippingZoneService ();
		$this->regionShippingMethodSetting = new FlatRateSettingVo ();
		$this->regionShippingMethodSetting->status = "inactive";
		$this->regionShippingMethodSetting->handlingFee = 0;
	}
	public function editView() {
		// Prepare all data for all drop down list.
		$this->prepareCurrencies ();
		$this->prepareTaxClasses ();
		$this->prepareShippingZones ();
		// Convert json to object.
		if (! AppUtil::isEmptyString ( $this->setting )) {
			// $this->setting = base64_decode ( $this->setting );
			// $this->regionShippingMethodSetting = unserialize ( $this->setting );
			$this->regionShippingMethodSetting = JsonUtil::base64Decode ( $this->setting );
		}
		return "success";
	}
	public function edit() {
		$this->prepareCurrencies ();
		$this->prepareTaxClasses ();
		$this->prepareShippingZones ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// $this->setting = serialize ( $this->regionShippingMethodSetting );
		// $this->setting = base64_encode ( $this->setting );
		$this->setting = JsonUtil::base64Encode ( $this->regionShippingMethodSetting );
		$this->addExtraData ( "setting", $this->setting );
		$this->addExtraData ( "statusId", $this->regionShippingMethodSetting->status );
		$this->addExtraData ( "statusName", AppUtil::arrayValue ( ApplicationConfig::get ( "common.status.list" ), $this->regionShippingMethodSetting->status ) );
		return "success";
	}
	public function addShippingMethodRow() {
		// Prepare all data for all drop down list.
		$this->prepareCurrencies ();
		$this->prepareTaxClasses ();
		$this->prepareShippingZones ();
		// Add new shipping method.
		$shippingMethod = new FlatRateShippingMethodVo ();
		$shippingMethod->cost = 0;
		$this->regionShippingMethodSetting->shippingMethods->add ( $shippingMethod );
		return "success";
	}
	public function removeShippingMethodRow() {
		// Prepare all data for all drop down list.
		$this->prepareCurrencies ();
		$this->prepareTaxClasses ();
		$this->prepareShippingZones ();
		// Remove shipping method.
		$count = count ( $this->regionShippingMethodSetting->shippingMethods->getArray () );
		if ($this->index < 0 || $count - 1 < $this->index) {
			$this->addActionError ( "Invalid index for removing" );
			return "success";
		}
		$this->regionShippingMethodSetting->shippingMethods->removeAt ( $this->index );
		return "success";
	}
	private function validate() {
		// Validate handling fee.
		if (! ValidateUtil::isFloat ( $this->regionShippingMethodSetting->handlingFee )) {
			$this->addFieldError ( "regionShippingMethodSetting[handlingFee]", "Invalid handling fee" );
		}
		$inputName = "regionShippingMethodSetting[shippingMethods]";
		$fieldName = "";
		$shippingMethods = $this->regionShippingMethodSetting->shippingMethods->getArray ();
		if (! empty ( $shippingMethods )) {
			$index = 0;
			foreach ( $shippingMethods as $shippingMethod ) {
				// Validate method name.
				$fieldName = $inputName . "[" . $index . "][name]";
				if (AppUtil::isEmptyString ( $shippingMethod->name )) {
					$this->addFieldError ( $fieldName, "Method name is required" );
				}
				// Validate cost.
				$fieldName = $inputName . "[" . $index . "][cost]";
				if (! ValidateUtil::isFloat ( $shippingMethod->cost )) {
					$this->addFieldError ( $fieldName, "Invalid cost" );
				}
			}
		}
	}
	private function prepareCurrencies() {
		$filter = new CurrencyExtendVo ();
		$filter->status = "active";
		$this->currencies = $this->currencyService->getByFilter ( $filter );
	}
	private function prepareTaxClasses() {
		$this->taxClasses = $this->taxRateService->selectAll ();
	}
	private function prepareShippingZones() {
		$this->shippingZones = $this->taxShippingZoneService->selectAll ();
	}
}