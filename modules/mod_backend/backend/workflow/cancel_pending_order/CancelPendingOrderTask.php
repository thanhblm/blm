<?php


namespace backend\workflow\cancel_pending_order;


use common\config\Attributes;
use common\config\PaymentMethodEnum;
use common\persistence\base\dao\RegionBaseDao;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use common\persistence\extend\vo\OrderExtendVo;
use common\services\email_template\EmailTemplateService;
use common\services\order\OrderService;
use core\Lang;
use core\utils\EmailUtil;
use core\workflow\ContextBase;
use core\workflow\Task;

class CancelPendingOrderTask implements Task {

	public function execute(ContextBase &$context){
		$pendingOrders = $context->get(Attributes::PENDING_ORDER_LIST);
		$orderSv = new OrderService();
		foreach ($pendingOrders as $order) {
			$emailTemplateId = 7808;
			if ($order->paymentMethodId != PaymentMethodEnum::BANK_TRANSTER){
				$emailTemplateId = 8373;
			}
			$orderVo = new OrderVo();
			$orderVo->id = $order->id;
			$orderVo->orderStatusId = 3;
			$orderSv->updateOrder($orderVo);

			//insert to Order History
			$orderHistory = new OrderHistoryVo();
			$orderHistory->orderId = $order->id;
			$orderHistory->status = 3;
			$orderHistory->crDate = date("Y-m-d h:i:s");
			$orderHistory->crBy = 0;
			$orderHistory->cusNotified = 'yes';
			$orderHistory->description = Lang::get('Status Update');
			$orderSv->insertOrderHistory($orderHistory);

			// Send email
			$orderExtendVo = new OrderExtendVo();
			$orderExtendVo->id = $order->id;
			$orderVo = $orderSv->getOrderByKey($orderExtendVo);
			$regionFilter = new RegionVo();
			$regionFilter->id = $orderVo->regionId;
			$regionDao = new RegionBaseDao();
			$regionVo = $regionDao->selectByKey($regionFilter);
			$email = array(
				$orderVo->customerEmail
			);


			$emailTemplateSv = new EmailTemplateService();
			$emailTemplateLangVo = new EmailTemplateLangExtendVo();
			$emailTemplateLangVo->emailTemplateId = $emailTemplateId;
			$emailTemplateLangVo->languageCode = $orderVo->languageCode;
			$emailTemplate = $emailTemplateSv->getEmailTemplate2Send($emailTemplateLangVo);
			$subject = $emailTemplate->subject;
			$body = $emailTemplate->body;
			$body = str_replace('$(firstname)', $orderVo->customerFirstname, $body);
			$body = str_replace('$(order_id)', $orderVo->id, $body);
			try {
				$sendResult = EmailUtil::sendMail($subject, $body, $email, array(), array(), array(), $regionVo->contactEmail);
				if ($sendResult) {
					\DatoLogUtil::info("Sent cancel email successfully to $orderVo->customerEmail. Order ID: $orderVo->id");
				} else {
					\DatoLogUtil::info("Sent cancel email failed to $orderVo->customerEmail. Order ID: $orderVo->id");
				}
			} catch (Exception $e) {
				\DatoLogUtil::error($e->getMessage());
			}
		}
	}
}