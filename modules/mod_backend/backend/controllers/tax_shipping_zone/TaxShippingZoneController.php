<?php

namespace backend\controllers\tax_shipping_zone;

use common\persistence\base\dao\CountryBaseDao;
use common\persistence\base\vo\StateVo;
use common\persistence\base\vo\TaxShippingZoneVo;
use common\persistence\extend\vo\TaxShippingZoneExtendVo;
use common\persistence\extend\vo\TaxShippingZoneInfoExtendVo;
use common\services\tax_shipping_zone\TaxShippingZoneService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\RequestUtil;

class TaxShippingZoneController extends PagingController {
	public $taxShippingZones;
	public $taxShippingZone;
	public $taxShippingZoneInfo;
	public $taxShippingZoneInfoList;
	public $id;
	public $countryList;
	public $stateListArray;
	public $stateList;
	private $taxShippingZoneService;
	public function __construct() {
		parent::__construct ();
		$this->taxShippingZoneInfo = new TaxShippingZoneInfoExtendVo ();
		$this->filter = new TaxShippingZoneExtendVo ();
		$this->taxShippingZone = new TaxShippingZoneVo ();
		$this->taxShippingZones = new Paging ();
		$this->taxShippingZoneService = new TaxShippingZoneService ();
		$this->taxShippingZoneInfoList = new BaseArray ( TaxShippingZoneInfoExtendVo::class );
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Tax Shipping Zone Management";
	}
	public function listView() {
		$this->getTaxShippingZones ();
		return "success";
	}
	public function search() {
		$this->getTaxShippingZones ();
		return "success";
	}
	public function addView() {
		$this->taxShippingZone->exclusive='no';
		return "success";
	}
	public function add() {
		$this->getCountryList ();
		$this->prepareStateList ();
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->taxShippingZone->crDate = date ( 'Y-m-d H:i:s' );
		$this->taxShippingZone->crBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->taxShippingZoneService->createTaxShippingZone ( $this->taxShippingZone, $this->taxShippingZoneInfoList );
		$this->addActionMessage ( "The tax shipping zone added successfully" );
		return "success";
	}
	public function editView() {
		$this->getCountryList ();
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		// Load system setting group.
		$filter = new TaxShippingZoneVo ();
		$filter->id = $this->id;
		$this->taxShippingZone = $this->taxShippingZoneService->getTaxShippingZoneByKey ( $filter );
		$this->getTaxShippingZoneInfos ();
		$this->prepareStateList ();
		return "success";
	}
	public function edit() {
		$this->getCountryList ();
		$this->prepareStateList ();
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->taxShippingZone->mdDate = date ( 'Y-m-d H:i:s' );
		$this->taxShippingZone->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->taxShippingZoneService->updateTaxShippingZone ( $this->taxShippingZone, $this->taxShippingZoneInfoList );
		$this->addActionMessage ( "The tax shipping zone updated successfully" );
		return "success";
	}
	public function copyView() {
		$this->getCountryList ();
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		// Load system setting group.
		$filter = new TaxShippingZoneVo ();
		$filter->id = $this->id;
		$this->taxShippingZone = $this->taxShippingZoneService->getTaxShippingZoneByKey ( $filter );
		$this->getTaxShippingZoneInfos ();
		$this->prepareStateList ();
		return "success";
	}
	public function copy() {
		$this->getCountryList ();
		$this->prepareStateList ();
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->taxShippingZone->mdDate = date ( 'Y-m-d H:i:s' );
		$this->taxShippingZone->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->taxShippingZoneService->createTaxShippingZone ( $this->taxShippingZone, $this->taxShippingZoneInfoList );
		$this->addActionMessage ( "The tax shipping zone clone successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Load system setting group.
		$filter = new TaxShippingZoneVo ();
		$filter->id = $this->id;
		$this->taxShippingZone = $this->taxShippingZoneService->getTaxShippingZoneByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Delete the system setting group.
		$filter = new TaxShippingZoneVo ();
		$filter->id = $this->id;
		$this->taxShippingZoneService->deleteTaxShippingZone ( $filter );
		$this->addActionMessage ( "The tax shipping zone deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->taxShippingZone->name )) {
			$this->addFieldError ( "taxShippingZone[name]", "Name is required" );
		} else {
			if ($isAdding) {
				$filter = new TaxShippingZoneVo ();
				$filter->name = $this->taxShippingZone->name;
				$vos = $this->taxShippingZoneService->selectByName ( $filter );
				if (! is_null ( $vos ) && count ( $vos ) > 0) {
					$this->addFieldError ( "taxShippingZone[name]", "The name was existed" );
				}
			} else {
				// Get old status info.
				$filter = new TaxShippingZoneVo ();
				$filter->id = $this->taxShippingZone->id;
				$vo = $this->taxShippingZoneService->getTaxShippingZoneByKey ( $filter );
				// Check new status name.
				if ($vo->name !== $this->taxShippingZone->name) {
					$filter = new TaxShippingZoneVo ();
					$filter->name = $this->taxShippingZone->name;
					$vos = $this->taxShippingZoneService->selectByName ( $filter );
					if (! is_null ( $vos ) && count ( $vos ) > 0) {
						$this->addFieldError ( "taxShippingZone[name]", "The name was existed" );
					}
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->taxShippingZone->exclusive )) {
			$this->addFieldError ( "taxShippingZone[exclusive]", "Exclusive is required" );
		}
		$index = 0;
		foreach ( $this->taxShippingZoneInfoList->getArray () as $taxShippingZoneInfo ) {
			if (AppUtil::isEmptyString ( $taxShippingZoneInfo->countryId )) {
				$this->addFieldError ( "taxShippingZoneInfoList[$index][countryId]", "Country is required" );
			}
			$index ++;
		}
	}
	protected function getTaxShippingZones() {
		$filter = $this->buildFilter ();
		// Get total records of taxShippingZones.
		$count = $this->taxShippingZoneService->countTaxShippingZoneByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get taxShippingZones.
		$taxShippingZoneVos = $this->taxShippingZoneService->getTaxShippingZoneByFilter ( $filter );
		foreach ( $taxShippingZoneVos as $taxShippingZoneVo ) {
			$taxShippingZoneVo->exclusive = AppUtil::arrayValue ( ApplicationConfig::get ( "tax.shipping.zone.excluse.list" ), $taxShippingZoneVo->exclusive );
		}
		$paging->records = $taxShippingZoneVos;
		$this->taxShippingZones = $paging;
	}
	protected function buildFilter() {
		return $this->buildBaseFilter ( "id asc" );
	}
	protected function getCountryList() {
		$countryDao = new CountryBaseDao ();
		$this->countryList = $countryDao->selectAll ();
	}
	public function getState() {
		$stateVo = new StateVo ();
		$stateVo->country = RequestUtil::get ( "country_id" );
		$stateVo->order_by='name asc';
		$this->stateList = $this->taxShippingZoneService->getStateByFilter ( $stateVo );
		return "success";
	}
	protected function getTaxShippingZoneInfos() {
		// Get all product categories.
		$filter = new TaxShippingZoneInfoExtendVo ();
		$filter->taxShippingZoneId = $this->id;
		$result = $this->taxShippingZoneService->getTaxShippingZoneInfoById ( $filter );
		foreach ( $result as $taxShippingZoneInfoExtendVo ) {
			$this->taxShippingZoneInfoList->add ( $taxShippingZoneInfoExtendVo );
		}
	}
	public function addTaxShippingZoneInfoView() {
		$this->getCountryList ();
		return "success";
	}
	protected function prepareStateList() {
		$countryArray = array ();
		foreach ( $this->taxShippingZoneInfoList->getArray () as $taxShippingZoneInfo ) {
			$countryId = $taxShippingZoneInfo->countryId;
			if (! in_array ( $countryId, $countryArray )) {
				$countryArray [] = $countryId;
			}
		}
		$taxShippingZoneService = new TaxShippingZoneService ();
		$this->stateListArray = $taxShippingZoneService->getStateListByCountryList ( $countryArray );
	}
}