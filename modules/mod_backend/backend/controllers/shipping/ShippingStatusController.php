<?php

namespace backend\controllers\shipping;

use common\persistence\base\vo\ShippingStatusVo;
use common\services\shipping\ShippingStatusService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

class ShippingStatusController extends PagingController {
	public $shippingStatus;
	public $shippingStatuses;
	public $id;
	private $shippingStatusService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new ShippingStatusVo ();
		$this->shippingStatus = new ShippingStatusVo ();
		$this->shippingStatuses = new Paging ();
		
		$this->shippingStatusService = new ShippingStatusService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Shipping Statuses Management";
	}
	public function listView() {
		$this->getShippingStatuses ();
		return "success";
	}
	public function search() {
		$this->getShippingStatuses ();
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
		// Add to the database.
		$this->shippingStatusService->addShippingStatus ( $this->shippingStatus );
		$this->addActionMessage ( "The Shipping Status added successfully" );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No shipping status for cloning" );
		}
		// Load language.
		$filter = new ShippingStatusVo ();
		$filter->id = $this->id;
		$this->shippingStatus = $this->shippingStatusService->getShippingStatusByKey ( $filter );
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Copy to the database.
		$this->shippingStatusService->addShippingStatus ( $this->shippingStatus );
		$this->addActionMessage ( "The shipping status cloned successfully" );
		return "success";
	}
	public function editView() {
		$filter = new ShippingStatusVo ();
		$filter->id = $this->id;
		$this->shippingStatus = $this->shippingStatusService->getShippingStatusByKey ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->shippingStatusService->updateShippingStatus ( $this->shippingStatus );
		$this->addActionMessage ( "The Shipping Status updated successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No shipping status for deleting" );
		}
		// Load system setting group.
		$filter = new ShippingStatusVo ();
		$filter->id = $this->id;
		$this->shippingStatus = $this->shippingStatusService->getShippingStatusByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No shipping status for deleting" ) );
		}
		// Delete the system setting group.
		$shippingStatus = new ShippingStatusVo ();
		$shippingStatus->id = $this->id;
		$this->shippingStatusService->deleteShippingStatus ( $shippingStatus );
		$this->addActionMessage ( Lang::get ( "The shipping status deleted successfully" ) );
		return "success";
	}
	private function getShippingStatuses() {
		$filter = $this->buildFilter ();
		// Get total records of languages.
		$count = $this->shippingStatusService->countShippigStatusByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get languages.
		$shippingStatusVos = $this->shippingStatusService->getShippingStatusByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $shippingStatusVos );
		$this->shippingStatuses = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	protected function format2Show(ShippingStatusVo $vo) {
		$mo = AppUtil::cloneObj ( $vo );
		$statuses = ApplicationConfig::get ( "common.status.list" );
		$mo->status = AppUtil::arrayValue ( $statuses, $mo->status );
		return $mo;
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
	protected function validate() {
		if (AppUtil::isEmptyString ( $this->shippingStatus->name )) {
			$this->addFieldError ( "shippingStatus[name]", "Shipping Status is required" );
		}
		if (AppUtil::isEmptyString ( $this->shippingStatus->status )) {
			$this->addFieldError ( "shippingStatus[status]", "Status is required" );
		} else {
			if (! in_array ( $this->shippingStatus->status, array_keys ( ApplicationConfig::get ( "common.status.list" ) ) )) {
				$this->addFieldError ( "shippingStatus[status]", "Status is invalid" );
			}
		}
	}
}