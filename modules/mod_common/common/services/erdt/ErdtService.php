<?php
/**
 * Created by PhpStorm.
 * User: hungnt
 * Date: 5/4/2017
 * Time: 4:20 PM
 */

namespace common\services\erdt;


use common\persistence\extend\dao\OrderExtendDao;
use common\persistence\extend\vo\OrderExtendVo;
use common\services\base\BaseService;

class ErdtService extends BaseService {
	private $orderExtendDao;

	public function __construct(array $context = array()){
		parent::__construct($context);
		$this->orderExtendDao = new OrderExtendDao();
	}

	public function getNonShippedOrders(OrderExtendVo $orderExtendVo){
		return $this->orderExtendDao->getErdtNonShippedOrders($orderExtendVo);
	}

	public function getCountNonShippedOrders(){
		return $this->orderExtendDao->getCountErdtNonShippedOrders();
	}

	public function getReservedShippedOrders(OrderExtendVo $orderExtendVo){
		return $this->orderExtendDao->getReservedShippedOrders($orderExtendVo);
	}

	public function getCountReservedShippedOrders(){
		return $this->orderExtendDao->getCountReservedShippedOrders();
	}
}