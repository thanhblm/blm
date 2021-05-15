<?php


namespace backend\workflow\cancel_pending_order;


use common\config\Attributes;
use common\config\PaymentMethodEnum;
use common\persistence\extend\vo\OrderExtendVo;
use common\services\order\OrderService;
use core\config\ApplicationConfig;
use core\workflow\ContextBase;
use core\workflow\Task;

class CollectPendingOrderTask implements Task {

	public function execute(ContextBase &$context){
		$orderSv = new OrderService();
		$orderExtendVo = new OrderExtendVo();
		$orderExtendVo->startDate = ApplicationConfig::get("pending.order.startdate");
		$orderVos = $orderSv->getPendingOrders($orderExtendVo);
		$pendingOrders = array();
		foreach ($orderVos as $orderVo){
			switch ($orderVo->paymentMethodId){
				case PaymentMethodEnum::BANK_TRANSTER:
					if ($orderVo->pendingHour >= ApplicationConfig::get("pending.order.banktransfer.time")){
						$pendingOrders[] = $orderVo;
					}
					break;
				default:
					if ($orderVo->pendingHour >= ApplicationConfig::get("pending.order.creditcard.time")){
						$pendingOrders[] = $orderVo;
					}
			}
		}
		if (count($pendingOrders) === 0){
			\DatoLogUtil::info("There's no pending orders to update.");
			return false;
		}
		$context->set(Attributes::PENDING_ORDER_LIST, $pendingOrders);
	}
}