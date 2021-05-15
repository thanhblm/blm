<?php

namespace frontend\controllers\shipping;

use common\model\ResponseMo;
use common\persistence\base\vo\OrderVo;
use core\utils\JsonUtil;
use core\utils\RequestUtil;
use frontend\controllers\FrontendController;
use frontend\service\ResponseHelper;
use frontend\service\ShipRushHelper;

class ShippingController extends FrontendController {
	public $order;
	function __construct() {
		parent::__construct ();
		$this->order = new OrderVo ();
	}
	public function shiprushTest() {
		$responseVo = new ResponseMo ();
		$orderId = 731161;
		$responseVo = ShipRushHelper::sendShiprushOrder ( $orderId );
		// $responseText = JsonUtil::encode ( $orderVo );
		RequestUtil::set ( 'responseText', ResponseHelper::getResponseJson ( $responseVo ) );
		return 'success';
	}
	public function shiprushCallback() {
		$responseVo = new ResponseMo ();
		$responseVo = ShipRushHelper::callback ();
		RequestUtil::set ( 'responseText', ResponseHelper::getResponseJson ( $responseVo ) );
		return 'success';
	}
}