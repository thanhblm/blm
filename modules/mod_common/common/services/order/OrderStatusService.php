<?php

namespace common\services\order;

use common\persistence\base\vo\OrderStatusVo;
use common\persistence\extend\dao\OrderStatusExtendDao;

class OrderStatusService {
	private $orderStatusDao;
	public function __construct() {
		$this->orderStatusDao = new OrderStatusExtendDao ();
	}
	public function getOrderStatusByKey(OrderStatusVo $filter) {
		return $this->orderStatusDao->selectByKey ( $filter );
	}
	public function getOrderStatusByFilter(OrderStatusVo $filter) {
		return $this->orderStatusDao->selectByFilter ( $filter );
	}
	public function countOrderStatusByFilter(OrderStatusVo $filter) {
		return $this->orderStatusDao->countByFilter ( $filter );
	}
	public function addOrderStatus(OrderStatusVo $filter) {
		return $this->orderStatusDao->insertDynamic ( $filter );
	}
	public function updateOrderStatus(OrderStatusVo $filter) {
		return $this->orderStatusDao->updateDynamicByKey ( $filter );
	}
	public function deleteOrderStatus(OrderStatusVo $filter) {
		return $this->orderStatusDao->deleteByKey ( $filter );
	}
	public function getAll() {
		return $this->orderStatusDao->selectAll ();
	}
	public function getSortedOrderStatuses() {
		return $this->orderStatusDao->getSortedOrderStatuses ();
	}
}