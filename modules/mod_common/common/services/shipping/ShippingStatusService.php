<?php
namespace common\services\shipping;

use common\persistence\base\dao\ShippingStatusBaseDao;
use common\persistence\base\vo\ShippingStatusVo;

class ShippingStatusService {
	private $shippingStatusDao;
	
	public function __construct() {
		$this->shippingStatusDao = new ShippingStatusBaseDao();
	}
	
	public function getShippingStatusByKey(ShippingStatusVo $filter){
		return $this->shippingStatusDao->selectByKey($filter);
	}
	
	public function getShippingStatusByFilter(ShippingStatusVo $filter) {
		return $this->shippingStatusDao->selectByFilter( $filter );
	}
	public function countShippigStatusByFilter(ShippingStatusVo $filter) {
		return $this->shippingStatusDao->countByFilter($filter);
	}
	public function addShippingStatus(ShippingStatusVo $shippingStatusVo) {
		return $this->shippingStatusDao->insertDynamic($shippingStatusVo);
	}
	public function updateShippingStatus(ShippingStatusVo $shippingStatusVo) {
		return $this->shippingStatusDao->updateDynamicByKey($shippingStatusVo);
	}
	public function deleteShippingStatus(ShippingStatusVo $shippingStatusVo) {
		return $this->shippingStatusDao->deleteByKey($shippingStatusVo);
	}
}