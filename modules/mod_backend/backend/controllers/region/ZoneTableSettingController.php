<?php

namespace backend\controllers\region;

use common\persistence\extend\vo\CurrencyExtendVo;
use common\services\currency\CurrencyService;
use common\services\tax\TaxRateService;
use common\services\tax_shipping_zone\TaxShippingZoneService;
use common\vo\region\shipping_method\zone_table\ZoneTableSettingVo;
use common\vo\region\shipping_method\zone_table\ZoneTableShippingCostVo;
use core\config\ApplicationConfig;
use core\Controller;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\utils\ValidateUtil;

class ZoneTableSettingController extends Controller {
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
		$this->regionShippingMethodSetting = new ZoneTableSettingVo ();
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
			// $this->setting = base64_decode($this->setting);
			// $this->regionShippingMethodSetting = unserialize ( $this->setting );
			$this->regionShippingMethodSetting = JsonUtil::base64Decode ( $this->setting );
		}
		foreach ( $this->regionShippingMethodSetting->shippingCosts->getArray () as $shippingCost ) {
			if (AppUtil::isEmptyString ( $shippingCost->showInFreeShipping )) {
				$shippingCost->showInFreeShipping = 0;
			}
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
		foreach ( $this->regionShippingMethodSetting->shippingCosts->getArray () as $shippingCost ) {
			if (AppUtil::isEmptyString ( $shippingCost->showInFreeShipping )) {
				$shippingCost->showInFreeShipping = 0;
			}
		}
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
		// Add new shipping cost.
		$shippingCost = new ZoneTableShippingCostVo ();
		$shippingCost->maxTotalWeight = 0;
		$shippingCost->cost = 0;
		$this->regionShippingMethodSetting->shippingCosts->add ( $shippingCost );
		return "success";
	}
	public function removeShippingMethodRow() {
		// Prepare all data for all drop down list.
		$this->prepareCurrencies ();
		$this->prepareTaxClasses ();
		$this->prepareShippingZones ();
		// Remove shipping method.
		$count = count ( $this->regionShippingMethodSetting->shippingCosts->getArray () );
		if ($this->index < 0 || $count - 1 < $this->index) {
			$this->addActionError ( "Invalid index for removing" );
			return "success";
		}
		\DatoLogUtil::devInfo ( "REMOVE INDEX 1: " . $this->index );
		$this->regionShippingMethodSetting->shippingCosts->removeAt ( $this->index );
		return "success";
	}
	private function validate() {
		// Validate handling fee.
		if (! ValidateUtil::isFloat ( $this->regionShippingMethodSetting->handlingFee )) {
			$this->addFieldError ( "regionShippingMethodSetting[handlingFee]", "Invalid handling fee" );
		}
		$inputName = "regionShippingMethodSetting[shippingCosts]";
		$fieldName = "";
		$shippingCosts = $this->regionShippingMethodSetting->shippingCosts->getArray ();
		if (! empty ( $shippingCosts )) {
			$index = 0;
			foreach ( $shippingCosts as $shippingCost ) {
				// Validate max total weight.
				$fieldName = $inputName . "[" . $index . "][maxTotalWeight]";
				if (! ValidateUtil::isFloat ( $shippingCost->maxTotalWeight )) {
					$this->addFieldError ( $fieldName, "Invalid max total weight" );
				}
				// Validate method title.
				$fieldName = $inputName . "[" . $index . "][methodTitle]";
				if (AppUtil::isEmptyString ( $shippingCost->methodTitle )) {
					$this->addFieldError ( $fieldName, "Method title is required" );
				}
				// Validate cost.
				$fieldName = $inputName . "[" . $index . "][cost]";
				if (! ValidateUtil::isFloat ( $shippingCost->cost )) {
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