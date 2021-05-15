<?php

namespace backend\controllers\order;

use common\persistence\base\vo\OrderStatusVo;
use common\services\order\OrderStatusService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

class OrderStatusController extends PagingController {
	public $orderStatus;
	public $orderStatuses;
	public $id;
	private $orderStatusService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new OrderStatusVo ();
		$this->orderStatus = new OrderStatusVo ();
		$this->orderStatuses = new Paging ();
		
		$this->orderStatusService = new OrderStatusService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Order Statuses Management";
	}
	public function listView() {
		$this->getOrderStatuses ();
		return "success";
	}
	public function search() {
		$this->getOrderStatuses ();
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
		$this->orderStatusService->addOrderStatus ( $this->orderStatus );
		$this->addActionMessage ( Lang::get ( "The Order Status added successfully" ) );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Order status for cloning" ) );
		}
		// Load language.
		$filter = new OrderStatusVo ();
		$filter->id = $this->id;
		$this->orderStatus = $this->orderStatusService->getorderStatusByKey ( $filter );
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Copy to the database.
		$this->orderStatusService->addOrderStatus ( $this->orderStatus );
		$this->addActionMessage ( Lang::get ( "The Order status cloned successfully" ) );
		return "success";
	}
	public function editView() {
		$filter = new OrderStatusVo ();
		$filter->id = $this->id;
		$this->orderStatus = $this->orderStatusService->getorderStatusByKey ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->orderStatusService->updateOrderStatus ( $this->orderStatus );
		$this->addActionMessage ( Lang::get ( "The Order Status updated successfully" ) );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Order status for deleting" ) );
		}
		// Load system setting group.
		$filter = new OrderStatusVo ();
		$filter->id = $this->id;
		$this->orderStatus = $this->orderStatusService->getorderStatusByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Order status for deleting" ) );
		}
		// Delete the system setting group.
		$orderStatus = new OrderStatusVo ();
		$orderStatus->id = $this->id;
		$this->orderStatusService->deleteorderStatus ( $orderStatus );
		$this->addActionMessage ( Lang::get ( "The Order status deleted successfully" ) );
		return "success";
	}
	private function getOrderStatuses() {
		$filter = $this->buildFilter ();
		// Get total records of languages.
		$count = $this->orderStatusService->countOrderStatusByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get languages.
		$orderStatusVos = $this->orderStatusService->getorderStatusByFilter ( $filter );
		$paging->records = $this->formatList2Show ( $orderStatusVos );
		$this->orderStatuses = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	protected function validate() {
		if (AppUtil::isEmptyString ( $this->orderStatus->name )) {
			$this->addFieldError ( "orderStatus[name]", Lang::get ( "Order Status is required" ) );
		}
		if (AppUtil::isEmptyString ( $this->orderStatus->status )) {
			$this->addFieldError ( "orderStatus[status]", Lang::get ( "Status is required" ) );
		} else {
			if (! in_array ( $this->orderStatus->status, array_keys ( ApplicationConfig::get ( "common.status.list" ) ) )) {
				$this->addFieldError ( "orderStatus[status]", Lang::get ( "Status is invalid" ) );
			}
		}
	}
	protected function format2Show(OrderStatusVo $vo) {
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
}