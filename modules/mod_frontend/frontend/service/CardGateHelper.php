<?php

namespace frontend\service;

use common\config\LogTypeEnum;
use common\config\OrderStatusEnum;
use common\helper\LogHelper;
use common\helper\NetworkHelper;
use common\model\PaymentDetailsMo;
use common\model\ResponseMo;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\OrderVo;
use common\rule\url\friendly\AliasUrlFriendly;
use common\services\order\OrderService;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use common\helper\SettingHelper;
use common\config\PaymentMethodEnum;
use common\config\OrderHistoryActionEnum;

// This is the primary credit card merchant for Outside USA.

// Merchant Dashboard: https://my.cardgate.com
// UN: js@endoca.com
// PW: CG4end!

// Information for the integration

// API documentation - http://www.curopayments.com/docs/api/
// Site ID: 14743
// Control URL: Set it here https://my.cardgate.com/#Sites
// API UN: endocaaps
// API PW: $1e^0lbbX0JJLhxTgTBPyzd4Wviex~tFpdcUAHUeM!UHU49^EhnI92aREKSxHXXQ

// demo
// Recurring option must be enabled for this site by CURO!
// $iSiteID = 1014;
// Hash-check value for this site
// $sAPIKey = 'DEMO';

// Note: As long as your webshop / website is not yet approved, only test transactions can take place. You can find your test transactions in the Staging environment after login in to My CardGate.

// (Reference: https://www.wrike.com/open.htm?id=111317791 )
class CardGateHelper {
	// live
	/*
	 * private static $siteId = 14743;
	 * private static $siteHash = 'zWLkyQK3';
	 * private static $gatewayURL = 'https://secure.curopayments.net/rest/v1/curo/';
	 */
	// dev

	// private static $siteId = 16211;
	// private static $siteHash = 'b_42wcrf';
	// private static $gatewayURL = 'https://secure-staging.curopayments.net/rest/v1/curo/';

	// private static $apiUser = 'endocaaps';
	// private static $apiPass = '$1e^0lbbX0JJLhxTgTBPyzd4Wviex~tFpdcUAHUeM!UHU49^EhnI92aREKSxHXXQ';
	private static $siteId = null;
	private static $siteHash = null;
	private static $gatewayURL = null;
	private static $apiUser = null;
	private static $apiPass = null;
	private static $isDebug = null;
	private static $isInit = null;
	private static function init() {
		if (! self::$isInit) {
			if (SettingHelper::getSettingValue ( 'CardGate Enviroment' ) == 'live') {
				self::$siteId = SettingHelper::getSettingValue ( "CardGate Site ID (live)" );
				self::$siteHash = SettingHelper::getSettingValue ( "CardGate Site Hash (live)" );
				self::$gatewayURL = SettingHelper::getSettingValue ( "CardGate Site URL (live)" );
			} else {
				self::$siteId = SettingHelper::getSettingValue ( "CardGate Site ID (sandbox)" );
				self::$siteHash = SettingHelper::getSettingValue ( "CardGate Site Hash (sandbox)" );
				self::$gatewayURL = SettingHelper::getSettingValue ( "CardGate Site URL (sandbox)" );
			}
			
			self::$apiUser = SettingHelper::getSettingValue ( "CardGate API user" );
			self::$apiPass = SettingHelper::getSettingValue ( "CardGate API pass" );
			self::$isDebug = SettingHelper::getSettingValue ( "CardGate Debug" ) == 'yes' ? true : false;
			self::$isInit = true;
		}
	}
	public static function isValid(PaymentDetailsMo $mo) {
		
		// $billCcName = RequestUtil::get ( 'cardgate_cc_name' );
		// $billCcType = RequestUtil::get ( 'cardgate_cc_type' );
		// $billCcNumber = RequestUtil::get ( 'cardgate_cc_number' );
		// $billCcYear = RequestUtil::get ( 'cardgate_cc_year' );
		// $billCcMonth = RequestUtil::get ( 'cardgate_cc_month' );
		// $billCcCvv = RequestUtil::get ( 'cardgate_cc_cvv' );
		$billCcName = $mo->ccName;
		$billCcType = $mo->ccType;
		$billCcNumber = $mo->ccNumber;
		$billCcYear = $mo->ccYear;
		$billCcMonth = $mo->ccMonth;
		$billCcCvv = $mo->ccCvv;
		$errArr = null;
		if (empty ( $billCcName )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Full Name on Credit Card' );
			$errArr ['cardgate_cc_name'] = $errMsg;
		}
		if (empty ( $billCcType )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Type' );
			$errArr ['cardgate_cc_type'] = $errMsg;
		}
		if (empty ( $billCcNumber )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Number' );
			$errArr ['cardgate_cc_number'] = $errMsg;
		}
		if (empty ( $billCcYear )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Expiry Year' );
			$errArr ['cardgate_cc_year'] = $errMsg;
		}
		if (empty ( $billCcMonth )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Expiry Month' );
			$errArr ['cardgate_cc_month'] = $errMsg;
		}
		if (empty ( $billCcCvv )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Security Code (CVV)' );
			$errArr ['cardgate_cc_cvv'] = $errMsg;
		}
		return $errArr;
	}
	// ResponseMo Object
	// (
	// [status] => SUCCESS
	// [msg] => Init transaction successful.
	// [data] => stdClass Object
	// (
	// [success] => 1
	// [payment] => stdClass Object
	// (
	// [action] => redirect
	// [transaction] => T17407095668
	// [testmode] => 1
	// [url] => https://secure-staging.curopayments.net/v1/simulator/?transaction=T17407095668
	// [transaction_id] => T17407095668
	// )
	
	// )
	
	// )
	public static function initPayment(OrderVo $order, PaymentDetailsMo $paymentDetails) {
		self::init ();
		$response = new ResponseMo ();
		// process authorize payment
		$response = self::initTransaction ( $order, $paymentDetails );
		// // process payment result
		if (ResponseHelper::isError ( $response )) {
			$order->orderStatusId = OrderStatusEnum::UNSUCESSFUL;
		} else {
			$order->orderStatusId = OrderStatusEnum::PENDING;
			// OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
		}
		// if ($paymentDetails->ccCvv == 'success') {
		// $order->orderStatusId = OrderStatusEnum::PAID;
		// ResponseHelper::setSuccess ( $response, 'Payment Success.' );
		// } else {
		// $order->orderStatusId = OrderStatusEnum::UNSUCESSFUL;
		// ResponseHelper::setError ( $response, 'Payment Error.' );
		// }
		// $response->data['txnId'] = RequestUtil::get('transaction');
		\DatoLogUtil::trace ( $response );
		return $response;
	}
	// transaction = T17507169827
	// pt = creditcard
	// amount = 4600
	// currency = EUR
	// code = 200
	// testmode = 1
	// site = 16211
	// status = success
	// reference = 231
	// ip = 101.100.161.6
	// account_name =
	// account_number = ******
	// firstname = test
	// country_id = US
	// email = test@test.com
	// hash = 9668c984968a1cf706a5fdd7fdd7b1e7
	public static function processCallback() {
		self::init ();
		// $_REQUEST['transaction'] = 'T17507236809';
		// $_REQUEST['code'] = '200';
		// $_REQUEST['reference'] = '10';
		
		$responseVo = new ResponseMo ();
		$cartId = RequestUtil::get ( 'reference' );
		$testmode = RequestUtil::get ( 'testmode' ) ? 'TEST' : '';
		$transaction = RequestUtil::get ( 'transaction' );
		$currency = RequestUtil::get ( 'currency' );
		$amount = RequestUtil::get ( 'amount' );
		$reference = RequestUtil::get ( 'reference' );
		$code = RequestUtil::get ( 'code' );
		$siteHash = self::$siteHash;
		$cartInfoVo = CartHelper::getCartInfoVoById ( $cartId );
		$info = $cartInfoVo->info;
		$orderVo = CartHelper::getOrderVoByInfo ( $info );
		$orderChargeVo = CartHelper::getOrderChargeInfoVoByInfo ( $info );
		$orderSvc = new OrderService ();
		\DatoLogUtil::trace ( $cartInfoVo );
		\DatoLogUtil::trace ( $orderVo );
		if (self::$isDebug)
			LogHelper::logRequest ( LogTypeEnum::CARDGATE, NetworkHelper::getCurrentURL (), null, $_GET );
		try {
			if (self::isValidHash ( $_REQUEST )) {
				$responseVo = self::setTransactionStatusByCode ( $responseVo, $code );
				$msg = $responseVo->msg;
				if (ResponseHelper::isError ( $responseVo )) {
					$orderVo->orderStatusId = OrderStatusEnum::UNSUCESSFUL;
				} else {
					$orderVo->orderStatusId = OrderStatusEnum::PAID;
				}
				\DatoLogUtil::trace ( $responseVo );
				$responseVo->data = ( object ) $responseVo->data;
				$responseVo->data->txnId = $transaction;
				$responseVo->data->remark = $testmode . '|' . $transaction . '|' . $currency . '|' . $amount . '|' . $reference . '|' . $code . '|' . $siteHash;
				$responseVo->data->description = $msg;
				$responseVo->data->authCode = 'N/A';
				$responseVo->data->code = $code;
				$responseVo->data->orderInfo = 'N/A';
				$responseVo->data->detailMo = OrderHelper::setOrderHistoryDetailMo ( OrderHistoryActionEnum::PAYMENT, PaymentMethodEnum::CARDGATE, $transaction, null );
				$paymentTxnVo = PaymentHelper::setPaymentTxn ( $orderVo, $responseVo );
				$orderHistoryVo = PaymentHelper::setOrderHistory ( $orderVo, $responseVo );
				
				$sesOrderVo = CartHelper::updateOrderVo ( $orderVo );
				$orderSvc->updateOrderStatusByTransaction ( $orderVo, $orderHistoryVo, $paymentTxnVo );
				$cartInfoVo = CartHelper::updateCartInfoVoByOrderVo ( $cartInfoVo, $orderVo );
				if (! ResponseHelper::isError ( $responseVo )) {
					if ($orderVo->orderStatusId == OrderStatusEnum::PAID) {
						//\DatoLogUtil::debug('sendEmailOrderConfirm');
						//OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
					}
				}
			} else {
				$msg = 'invalid cardgate hash.';
				ResponseHelper::setError ( $responseVo, $msg, $_REQUEST );
				\DatoLogUtil::error ( $msg );
				// email error to admin.
			}
		} catch ( Exception $e ) {
			\DatoLogUtil::error ( $e->getMessage () );
			\DatoLogUtil::trace ( $e );
			// email error to admin.
		}
		return $responseVo;
	}
	private static function initTransaction(OrderVo $order, PaymentDetailsMo $paymentDetails) {
		self::init ();
		$successURL = ActionUtil::getFullPathAlias ( "home/cart/checkout/payment/cardgate/return" );
		// ActionUtil::getFullPathAlias("home/cart/checkout/view", new AliasUrlFriendly("shopping-cart"))
		$failuerURL = ActionUtil::getFullPathAlias ( "home/cart/checkout/payment/cardgate/return" );
		$callbackURL = ActionUtil::getFullPathAlias ( "home/cart/checkout/payment/cardgate/callback" );
		$response = new ResponseMo ();
		// $chargeInfoVo = new OrderChargeInfoVo();
		$sessionId = SessionUtil::get ( "sessionId" );
		$cartInfoVo = CartHelper::getCartInfoVoBySessionId ( $sessionId, $order->id );
		$cartId = $cartInfoVo->id;
		$orderId = $order->id;
		$chargeInfoVo = SessionUtil::get ( "orderChargeInfo" );
		\DatoLogUtil::trace ( $cartInfoVo );
		$data = [ 
				'site_id' => self::$siteId,
				'url_success' => $successURL,
				'url_failure' => $failuerURL,
				'url_callback' => $callbackURL,
				'reference' => $cartId,
				'amount' => self::amt2cgAmt ( $chargeInfoVo->grandTotalAmount ),
				'currency_id' => $order->currencyCode,
				'description' => 'Transaction OID:' . $orderId . ' CID:' . $cartId,
				'ip' => NetworkHelper::getClientIp (),
				'country_id' => $order->billCountryCode,
				'language_id' => 'en',
				'consumer' => [ 
						'firstname' => $order->billFirstName,
						'lastname' => $order->billLastName,
						'email' => $order->billEmail 
				],
				'format' => 'json' 
		];
		try {
			// $testMode = 1;
			// $siteId = self::$siteId;
			// $reference = $order->id;
			// $amt = $chargeInfoVo->grandTotalAmount;
			// $apiKey = self::$apiPass;
			$ch = curl_init ();
			// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			// curl_setopt($ch, CURLOPT_PROXY, MODULE_PAYMENT_PAYPAL_DP_PROXY);
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			
			$url = self::$gatewayURL . 'payment/creditcard';
			
			\DatoLogUtil::trace ( $url );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			
			curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt ( $ch, CURLOPT_USERPWD, self::$apiUser . ':' . self::$apiPass );
			
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data, '', '&' ) );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt ( $ch, CURLOPT_MAXREDIRS, 5 );
			\DatoLogUtil::trace ( json_encode ( $ch ) );
			$res = curl_exec ( $ch );
			if (self::$isDebug)
				LogHelper::logRequest ( LogTypeEnum::CARDGATE, $url, $data, $res );
			if (curl_errno ( $ch ) != 0)
				\DatoLogUtil::trace ( sprintf ( 'HTTP Request Failed: %d - %s', curl_errno ( $ch ), curl_error ( $ch ) ) );
			
			curl_close ( $ch );
			
			$res = json_decode ( $res );
			
			\DatoLogUtil::trace ( $res );
			
			if (! empty ( $res ) && $res->success) {
				// get redirect url
				ResponseHelper::setSuccess ( $response, 'Init transaction successful.', $res );
				$response->data->txnId = $res->payment->transaction;
				\DatoLogUtil::trace ( $res->payment->transaction );
				\DatoLogUtil::trace ( $data );
				if (self::$isDebug)
					LogHelper::logRequest ( LogTypeEnum::CARDGATE, $url, $data, $res );
			} else {
				// create transaction failed
				ResponseHelper::setError ( $response, 'Init transaction failed.', $res );
			}
		} catch ( Exception $e ) {
			\DatoLogUtil::error ( $e->getMessage () );
			\DatoLogUtil::trace ( $e );
			ResponseHelper::setError ( $response, $e->getMessage () );
		}
		return $response;
	}
	// [status] => failure
	// [transaction] => T17407111455
	// [code] => 300
	// [reference] => 231
	public static function processTransaction() {
		self::init ();
		$_REQUEST ['languages'] = null;
		if (self::$isDebug)
			LogHelper::logRequest ( LogTypeEnum::CARDGATE, NetworkHelper::getCurrentURL (), null, $_GET );
		$orderSvc = new OrderService ();
		$responseVo = new ResponseMo ();
		$cartId = RequestUtil::get ( 'reference' );
		$code = RequestUtil::get ( 'code' );
		$cartInfoVo = CartHelper::getCartInfoVoById ( $cartId );
		$info = $cartInfoVo->info;
		$orderVo = CartHelper::getOrderVoByInfo ( $info );
		$responseVo = self::setTransactionStatusByCode ( $responseVo, $code );
		$responseVo->msg .= '. Transaction not varified.';
		// $orderHistoryVo = PaymentHelper::setOrderHistory ( $orderVo, $responseVo );
		// $paymentTxnVo = PaymentHelper::setPaymentTxn ( $orderVo, $responseVo );
		// $orderSvc->updateOrderStatusByTransaction ( $orderVo, $orderHistoryVo, $paymentTxnVo );
		return $responseVo;
	}
	public static function isValidHash($request) {
		$isValid = false;
		$str = ($request ['testmode'] ? 'TEST' : '') . $request ['transaction'] . $request ['currency'] . $request ['amount'] . $request ['reference'] . $request ['code'] . self::$siteHash;
		// \DatoLogUtil::trace ( $str );
		$md5Str = md5 ( $str );
		if ($request ['hash'] == $md5Str)
			$isValid = true;
		return $isValid;
	}
	public static function cgAmt2Amt($cgAmt) {
		$amt = null;
		if (is_int ( $cgAmt ) && $cgAmt != 0) {
			$amt = $cgAmt / 100;
		} else {
			$amt = $cgAmt;
		}
		return $amt;
	}
	public static function amt2cgAmt($amt) {
		$cgAmt = null;
		if (is_int ( $amt ) || is_double ( $amt )) {
			$cgAmt = round ( $amt * 100 );
		}
		return $cgAmt;
	}
	private static function setTransactionStatusByCode($responseVo, $code) {
		switch ($code) {
			case '200' : // Transaction successful
			case '210' : // Recurring transaction successful
				$msg = $code . ' Transaction successful.';
				
				ResponseHelper::setSuccess ( $responseVo, $msg, ( object ) $_REQUEST );
				break;
			case '309' : // Transaction was cancelled
				$msg = $code . ' Transaction cancelled by user.';
				ResponseHelper::setError ( $responseVo, $msg, ( object ) $_REQUEST );
				break;
			case '300' : // Transaction failed
			case '301' : // Transaction failed due to anti fraud system
			case '308' : // Transaction was expired
			case '310' : // Recurring transaction failed
			case '350' : // Transaction failed, time out for 3D secure authentication
			case '351' : // Transaction failed, non-3DS transactions are not allowed
			case '400' : // Refund to customer
			case '410' : // Chargeback by customer
			case '420' : // Chargeback (2nd attempt)
			case '450' : // Authorization cancelled
				$msg = $code . ' Transaction failed.';
				ResponseHelper::setError ( $responseVo, $msg, ( object ) $_REQUEST );
				break;
			default :
				$msg = $code . ' Transaction failed.';
				ResponseHelper::setError ( $responseVo, $msg, ( object ) $_REQUEST );
				break;
		}
		return $responseVo;
	}
	public static function isSuccess($code) {
		$isSuccess = false;
		switch ($code) {
			case '200' : // Transaction successful
			case '210' : // Recurring transaction successful
				$isSuccess = true;
				break;
		}
		return $isSuccess;
	}
}