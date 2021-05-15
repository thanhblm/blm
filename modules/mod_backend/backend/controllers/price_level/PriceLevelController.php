<?php

namespace backend\controllers\price_level;

use common\persistence\base\vo\PriceLevelVo;
use common\persistence\extend\vo\PriceLevelExtendVo;
use common\services\price_level\PriceLevelService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use core\Lang;

class PriceLevelController extends PagingController {
	public $priceLevels;
	public $priceLevel;
	public $id;
	private $priceLevelService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new PriceLevelExtendVo ();
		$this->priceLevel = new PriceLevelVo ();
		$this->priceLevels = new Paging ();
		$this->priceLevelService = new PriceLevelService ();
		$this->pageTitle .= ApplicationConfig::get ( "site.name" ) . " - Price Level Management";
	}
	public function listView() {
		$this->getPriceLevels ();
		return "success";
	}
	public function search() {
		$this->getPriceLevels ();
		return "success";
	}
	public function addView() {
		return "success";
	}
	public function add() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Set some initial values.
		$this->priceLevel->crDate = date ( 'Y-m-d H:i:s' );
		$this->priceLevel->crBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->priceLevel->mdDate = date ( 'Y-m-d H:i:s' );
		$this->priceLevel->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		// Add to the database.
		$this->priceLevelService->createPriceLevel ( $this->priceLevel );
		$this->addActionMessage ( "The price level added successfully" );
		
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		// Load system setting group.
		$filter = new PriceLevelVo ();
		$filter->id = $this->id;
		$this->priceLevel = $this->priceLevelService->getPriceLevelByKey ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->priceLevel->mdDate = date ( 'Y-m-d H:i:s' );
		$this->priceLevel->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->priceLevelService->updatePriceLevel ( $this->priceLevel );
		$this->addActionMessage ( "The price level updated successfully" );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for cloning" );
		}
		// Load system setting group.
		$filter = new PriceLevelVo ();
		$filter->id = $this->id;
		$this->priceLevel = $this->priceLevelService->getPriceLevelByKey ( $filter );
		$this->priceLevel->id = null;
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->priceLevel->crDate = date ( 'Y-m-d H:i:s' );
		$this->priceLevel->crBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		$this->priceLevel->mdDate = date ( 'Y-m-d H:i:s' );
		$this->priceLevel->mdBy = null == $this->getUserInfo () ? "0" : $this->getUserInfo ()->userId;
		// Save to the database.
		$this->priceLevelService->createPriceLevel ( $this->priceLevel );
		$this->addActionMessage ( "The price level cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Load system setting group.
		$filter = new PriceLevelVo ();
		$filter->id = $this->id;
		$this->priceLevel = $this->priceLevelService->getPriceLevelByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Delete the system setting group.
		$filter = new PriceLevelVo ();
		$filter->id = $this->id;
		$this->priceLevelService->deletePriceLevel ( $filter );
		$this->addActionMessage ( "The price level deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->priceLevel->name )) {
			$this->addFieldError ( "priceLevel[name]", "Name is required" );
		}else {
			if ($isAdding) {
				$filter = new PriceLevelExtendVo();
				$filter->name = $this->priceLevel->name;
				\DatoLogUtil::devInfo($this->priceLevel);
				$voResult = $this->priceLevelService->getPriceLevelByFilter( $filter );
				if(count ( $voResult ) > 0) {
					$this->addFieldError ( "priceLevel[name]", Lang::getWithFormat ( "{0} has already existed", $this->priceLevel->name ) );
				}
			} else {
				$filter = new PriceLevelExtendVo();
				$filter->id = $this->priceLevel->id;
				$priceLevelOld = $this->priceLevelService->getPriceLevelByKey( $filter );
				if ($priceLevelOld->name != $this->priceLevel->name) {
					$filter = new PriceLevelExtendVo();
					$filter->name = $this->priceLevel->name;
					$voResult = $this->priceLevelService->getPriceLevelByFilter( $filter );
					if (count ( $voResult ) > 0) {
						$this->addFieldError ( "priceLevel[name]", Lang::getWithFormat ( "{0} has already existed", $this->priceLevel->name ) );
					}
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->priceLevel->value )) {
			$this->addFieldError ( "priceLevel[value]", "Discount value is required" );
		} elseif (! is_numeric ( $this->priceLevel->value )) {
			$this->addFieldError ( "priceLevel[value]", "Discount value is integer" );
		}
		if( $this->priceLevel->value > 99 || $this->priceLevel->value< 1 ){
			$this->addFieldError ( "priceLevel[value]", "Discount value must between 1 and 99" );
		}
	}
	protected function getPriceLevels() {
		$filter = $this->buildFilter ();
		// Get total records of priceLevels.
		$count = $this->priceLevelService->countPriceLevelByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get priceLevels.
		$priceLevelVos = $this->priceLevelService->getPriceLevelByFilter ( $filter );
		$paging->records = $priceLevelVos;
		$this->priceLevels = $paging;
	}
	protected function buildFilter() {
		return $this->buildBaseFilter ( "id asc" );
	}
}