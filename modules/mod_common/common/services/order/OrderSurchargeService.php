<?php
namespace common\services\order;

use common\persistence\base\dao\OrderSurchargeBaseDao;
use common\persistence\base\vo\OrderSurchargeVo;
use common\services\base\BaseService;

class OrderSurchargeService extends BaseService{
	private $orderSurchargeDao;
	
	public function __construct() {
		$this->orderSurchargeDao= new OrderSurchargeBaseDao();
	}
	
	public function selectByFilter(OrderSurchargeVo $orderSurchargeVo){
		return $this->orderSurchargeDao->selectByFilter($orderSurchargeVo);
	}
	public function countByFilter(OrderSurchargeVo $orderSurchargeVo){
		return $this->orderSurchargeDao->countByFilter($orderSurchargeVo);
	}
}