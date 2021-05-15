<?php


namespace backend\workflow\erdt;


use common\config\Attributes;
use common\persistence\base\dao\OrderShipingInfoBaseDao;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderShipingInfoVo;
use common\persistence\extend\dao\OrderHistoryExtendDao;
use common\persistence\extend\vo\OrderExtendVo;
use common\services\order\OrderService;
use common\utils\DateUtil;
use core\utils\DateTimeUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class UpdateErdtOrderHistoryTask implements Task {

	public function execute(ContextBase &$context){
		$fileName = $context->get(Attributes::FILE_NAME);
		$orderIds = $context->get(Attributes::LIST_ORDER_IDS);
		$orderSv = new OrderService();
		$orderHistoryDao = new OrderHistoryExtendDao();
		$orderShippingInfoDao = new OrderShipingInfoBaseDao();
		$shipDate = DateUtil::getCurrentDT();

		foreach ($orderIds as $orderId) {
			// Insert an order history record
			$orderExtendVo = new OrderExtendVo();
			$orderExtendVo->id = $orderId;
			$orderExtendVo = $orderSv->getOrderByKey($orderExtendVo);
			$orderHistory = new OrderHistoryVo();
			$orderHistory->orderId = $orderId;
			$orderHistory->status = $orderExtendVo->orderStatusId;
			$orderHistory->description = "Order successfully submitted to ERDT.\nERDT.ftp_filename: $fileName";
			$orderHistory->cusNotified = "no";
			$orderHistory->crBy = "0";
			$orderHistory->crDate = DateUtil::getCurrentDT();
			$orderHistoryDao->insertDynamic($orderHistory);

			// Update shipping info
			$orderShippingInfo = new OrderShipingInfoVo();
			$orderShippingInfo->orderId = $orderId;
			$orderShippingInfo->shipDate = $shipDate;
			$orderShippingInfoDao->updateDynamicByKey($orderShippingInfo);
		}
	}
}