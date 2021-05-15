<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\vo\OrderVo;

use common\persistence\extend\mapping\OrderExtendMapping;
use common\persistence\extend\vo\OrderExtendVo;
use common\persistence\base\vo\CustomerVo;

class OrderExtendDao extends OrderBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getByFilter(OrderExtendVo $orderVo = null){
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getByFilter', $orderVo);
		return $result;
	}

	public function getCountByFilter(OrderExtendVo $orderVo = null){
		$result = $this->executeCount(OrderExtendMapping::class, 'getCountByFilter', $orderVo);
		return $result;
	}

	public function getOrderByKey(OrderExtendVo $orderVo = null){
		$result = $this->executeSelectOne(OrderExtendMapping::class, 'getOrderByKey', $orderVo);
		return $result;
	}

	public function getOrdersByCustomerSalesRep(CustomerVo $customerVo = null){
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getOrdersByCustomerSalesRep', $customerVo);
		return $result;
	}

	public function getCountOrdersByCustomerSalesRep(CustomerVo $customerVo){
		$result = $this->executeCount(OrderExtendMapping::class, 'getCountOrdersByCustomerSalesRep', $customerVo);
		return $result;
	}

	public function getOrdersByCustomer(OrderVo $orderVo= null){
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getOrdersByCustomer', $orderVo);
		return $result;
	}

	public function getCountOrdersByCustomer(OrderVo $orderVo){
		$result = $this->executeCount(OrderExtendMapping::class, 'getCountOrdersByCustomer', $orderVo);
		return $result;
	}
	
	public function getCountOrdersByCustomerAndCouponCode(OrderVo $orderVo){
		$result = $this->executeCount(OrderExtendMapping::class, 'getCountOrdersByCustomerAndCouponCode', $orderVo);
		return $result;
	}
	
	public function getErdtNonShippedOrders(OrderExtendVo $orderExtendVo){
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getErdtNonShippedOrders', $orderExtendVo);
		return $result;
	}

	public function getCountErdtNonShippedOrders(){
		$result = $this->executeCount(OrderExtendMapping::class, 'getCountErdtNonShippedOrders');
		return $result;
	}

	public function getReservedShippedOrders(OrderExtendVo $orderExtendVo){
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getReservedShippedOrders', $orderExtendVo);
		return $result;
	}

	public function getCountReservedShippedOrders(){
		$result = $this->executeCount(OrderExtendMapping::class, 'getCountReservedShippedOrders');
		return $result;
	}

	public function getPendingOrders(OrderExtendVo $orderExtendVo){
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getPendingOrders', $orderExtendVo);
		return $result;
	}
	
	public function getPaidOrdersTwoWeeksAgo() {
		$result = $this->executeSelectList(OrderExtendMapping::class, 'getPaidOrdersTwoWeeksAgo');
		return $result;
	}
}