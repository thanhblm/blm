<?php

namespace frontend\controllers\payment;

use common\model\PaymentDetailsMo;
use common\model\ResponseMo;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderVo;
use common\services\address\AddressService;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\services\payment\PaymentMethodService;
use common\services\shipping\ShippingMethodService;
use core\Lang;
use core\utils\RequestUtil;
use frontend\controllers\FrontendController;
use frontend\service\CardGateHelper;
use frontend\service\CartHelper;
use frontend\service\OrderHelper;
use frontend\service\PaymentHelper;
use frontend\service\ResponseHelper;
use core\utils\JsonUtil;

class PaymentController extends FrontendController {
	public $listAddress;
	public $address;
	public $listCountry;
	public $listState;
	public $shippingMethods;
	public $order;
	public $orderHistory;
	public $shippingAddress;
	public $paymentAddress;
	public $shippingCost;
	public $paymentMethods;
	public $paymentDetails;
	public $addressType;
	public $listAddressSuggest;
	public $symbol;
	public $response;
	private $addressSv;
	private $countrySv;
	private $stateSv;
	private $shippingMethodSv;
	private $paymentMethodSv;
	function __construct() {
		parent::__construct ();
		$this->order = new OrderVo ();
		$this->orderHistory = new OrderHistoryVo ();
		$this->shippingAddress = new AddressVo ();
		$this->paymentAddress = new AddressVo ();
		$this->addressSv = new AddressService ();
		$this->address = new AddressVo ();
		$this->response = new ResponseMo ();
		$this->stateSv = new StateService ();
		$this->countrySv = new CountryService ();
		$this->shippingMethodSv = new ShippingMethodService ();
		$this->shippingMethods = array ();
		$this->paymentMethodSv = new PaymentMethodService ();
		$this->paymentMethods = array ();
		$this->paymentDetails = new PaymentDetailsMo ();
	}
	public function processCardgatePayment() {
		// redirect to cardgate payment
		// return 'cardgate_redirect';
		return 'success';
	}
	public function processCardgateReturn() {
		\DatoLogUtil::trace ( '+ processCardgateReturn +' );
		$return = 'redirect';
		// process cardgate payment success
		$cartId = RequestUtil::get ( 'reference' );
		$code = RequestUtil::get ( 'code' );
		$responseVo = CardGateHelper::processTransaction ();
		$cartInfoVo = CartHelper::getCartInfoVoById ( $cartId );
		$info = $cartInfoVo->info;
		$orderVo = CartHelper::getOrderVoByInfo ( $info );
		// if (empty ( $orderVo->id ))
		// $orderVo = OrderHelper::getOrderVoByid ( $cartInfoVo->orderId );
		\DatoLogUtil::trace ( $cartInfoVo );
		\DatoLogUtil::trace ( $orderVo );
		$this->order = $orderVo;
		// RequestUtil::set ( "order", $orderVo );
		RequestUtil::set ( "orderStatus", OrderHelper::getOrderStatusById ( $orderVo->orderStatusId ) );
		RequestUtil::set ( 'payment_process_file', "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php" );
		
		if (CardGateHelper::isSuccess ( $code )) {
			\DatoLogUtil::trace ( '+ processPaymentComplete ' . $orderVo->id . " responseVo:" . JsonUtil::encode ( $responseVo ) . ' +' );
			PaymentHelper::processPaymentComplete ( $orderVo->id, $responseVo );
			$return = 'success';
		} else {
			if ($code == '309') {
				$errMsg = Lang::get ( "Payment transaction Cancelled. Please contact customer support for assistance." );
				$this->addRedirectParams ( 'errMessage', base64_encode ( $errMsg ) );
				$this->addActionError ( $errMsg );
			} else {
				$errMsg = Lang::get ( "Payment transaction failed. Please contact customer support if problem persists." );
				$this->addRedirectParams ( 'errMessage', base64_encode ( $errMsg ) );
				$this->addActionError ( $errMsg );
			}
		}
		return $return;
		\DatoLogUtil::trace ( '- processCardgateReturn -' );
	}
	public function processCardgateCallback() {
		// process cardgate payment callback
		$responseVo = CardGateHelper::processCallback ();
		if (! ResponseHelper::isError ( $responseVo )) {
			RequestUtil::set ( 'responseText', RequestUtil::get ( 'transaction' ) . '.' . RequestUtil::get ( 'code' ) );
		} else {
			RequestUtil::set ( 'responseText', RequestUtil::get ( 'transaction' ) . '.' . RequestUtil::get ( 'code' ) );
		}
		return 'success';
	}
}