<?php

namespace frontend\service;

use common\config\LogTypeEnum;
use common\config\OrderStatusEnum;
use common\helper\LogHelper;
use common\model\PaymentDetailsMo;
use common\model\ResponseMo;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderVo;
use common\services\customer\CustomerService;
use core\Lang;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerDataType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\controller\CreateTransactionController;
use common\config\PaymentMethodEnum;
use common\persistence\base\vo\PaymentTxnVo;
use common\services\order\OrderService;
use common\persistence\base\vo\OrderRefundVo;
use common\persistence\base\dao\OrderRefundBaseDao;
use common\helper\SettingHelper;
use common\config\OrderHistoryActionEnum;
use common\model\OrderHistoryDetailMo;

class AuthorizeNetHelper {
	// merchant credentials
	// http://developer.authorize.net/hello_world/testing_guide/
	
	// production key:
	// private static $apiLoginId = '5U9kuWV5kt5';
	// private static $apiTransactionKey = '2cP8WY7x6kWz7E7F';
	// private static $anetURL = 'https://secure.authorize.net/gateway/transact.dll';
	// private static $proxyURL = 'https://bellerus.com/authnet/en/?action=purlAuthorizeNet%3Arelay_res';
	// private static $isSandbox = false;
	
	// development key:
	// private static $apiLoginId = "3Md76URKFgC";
	// private static $apiTransactionKey = "9Y9mLb955Gmm9TT7";
	// private static $anetURL = 'https://test.authorize.net/gateway/transact.dll';
	// private static $proxyURL = 'https://dev.endoca.com/en/?action=purlAuthorizeNet%3Arelay_res';
	// private static $isSandbox = true;
	
	// to enable or disable payment gateway sandbox mode.
	// private static $isAuthCapture = true;
	// private static $isRelayResponse = true;
	private static $apiLoginId = null;
	private static $apiTransactionKey = null;
	private static $anetURL = null;
	private static $proxyURL = null;
	private static $isSandbox = null;
	private static $isAuthCapture = null;
	private static $isRelayResponse = null;
	private static $isDebug = null;
	private static $isInit = null;
	private static function init() {
		if (! self::$isInit) {
			if (SettingHelper::getSettingValue ( "ANET Enviroment" ) == 'live') {
				self::$apiLoginId = SettingHelper::getSettingValue ( "ANET API login ID (live)" );
				self::$apiTransactionKey = SettingHelper::getSettingValue ( "ANET API Transaction Key (live)" );
				self::$anetURL = SettingHelper::getSettingValue ( "ANET URL (live)" );
				self::$proxyURL = SettingHelper::getSettingValue ( "ANET PROXY URL (live)" );
			} else {
				self::$apiLoginId = SettingHelper::getSettingValue ( "ANET API login ID (sandbox)" );
				self::$apiTransactionKey = SettingHelper::getSettingValue ( "ANET API Transaction Key (sandbox)" );
				self::$anetURL = SettingHelper::getSettingValue ( "ANET URL (sandbox)" );
				self::$proxyURL = SettingHelper::getSettingValue ( "ANET PROXY URL (sandbox)" );
				self::$isSandbox = true;
			}
			self::$isAuthCapture = true;
			self::$isRelayResponse = true;
			self::$isDebug = SettingHelper::getSettingValue ( "ANET Debug" ) == 'yes' ? true : false;
			self::$isInit = true;
		}
	}
	public static function isValid(PaymentDetailsMo $mo) {
		// $billCcName = RequestUtil::get ( 'authorizenet_cc_name' );
		// $billCcType = RequestUtil::get ( 'authorizenet_cc_type' );
		// $billCcNumber = RequestUtil::get ( 'authorizenet_cc_number' );
		// $billCcYear = RequestUtil::get ( 'authorizenet_cc_year' );
		// $billCcMonth = RequestUtil::get ( 'authorizenet_cc_month' );
		// $billCcCvv = RequestUtil::get ( 'authorizenet_cc_cvv' );
		$billCcName = $mo->ccName;
		$billCcType = $mo->ccType;
		$billCcNumber = $mo->ccNumber;
		$billCcYear = $mo->ccYear;
		$billCcMonth = $mo->ccMonth;
		$billCcCvv = $mo->ccCvv;
		$errArr = null;
		if (empty ( $billCcName )) {
			$errMsg = Lang::getWithFormat ( "{0} cannot be empty", 'Full Name on Credit Card' );
			$errArr ['authorizenet_cc_name'] = $errMsg;
		}
		if (empty ( $billCcType )) {
			$errMsg = Lang::getWithFormat ( "{0} cannot be empty", 'Credit Card Type' );
			$errArr ['authorizenet_cc_type'] = $errMsg;
		}
		if (empty ( $billCcNumber )) {
			$errMsg = Lang::getWithFormat ( "{0} cannot be empty", 'Credit Card Number' );
			$errArr ['authorizenet_cc_number'] = $errMsg;
		}
		if (empty ( $billCcYear )) {
			$errMsg = Lang::getWithFormat ( "{0} cannot be empty", 'Credit Card Expiry Year' );
			$errArr ['authorizenet_cc_year'] = $errMsg;
		}
		if (empty ( $billCcMonth )) {
			$errMsg = Lang::getWithFormat ( "{0} cannot be empty", 'Credit Card Expiry Month' );
			$errArr ['authorizenet_cc_month'] = $errMsg;
		}
		if (empty ( $billCcCvv )) {
			$errMsg = Lang::getWithFormat ( "{0} cannot be empty", 'Credit Card Security Code (CVV)' );
			$errArr ['authorizenet_cc_cvv'] = $errMsg;
		}
		return $errArr;
	}
	// This is a shadow account. Be very careful when you do testing. We do not want to lose this merchant account.
	
	// Merchant dashboard: https://account.authorize.net
	// UN: endoca1
	// PW: Pwd4aut!
	
	// API: http://developer.authorize.net/api/reference/index.html
	// API Login ID: 5U9kuWV5kt5
	// API Transaction Key: 2cP8WY7x6kWz7E7F
	public static function processPayment(OrderVo $order, PaymentDetailsMo $paymentDetails) {
		$response = new ResponseMo ();
		
		// process authorize payment
		$response = self::proxyAuthorizeCaptureCreditCard ( $order, $paymentDetails );
		// process payment result
		if (ResponseHelper::isError ( $response )) {
			$order->orderStatusId = OrderStatusEnum::UNSUCESSFUL;
		} else {
			$order->orderStatusId = OrderStatusEnum::PAID;
		}
		\DatoLogUtil::debug ( $response );
		return $response;
	}
	private static function authorizeCaptureCreditCard(OrderVo $order, PaymentDetailsMo $paymentDetails) {
		\DatoLogUtil::debug ( '+ authorizeCaptureCreditCard +' );
		$responseVo = new ResponseMo ();
		$sessionId = SessionUtil::get ( "sessionId" );
		$cartInfoVo = new CartInfoVo ();
		$cartInfoVo = CartHelper::getCartInfoVoBySessionId ( $sessionId, $order->id );
		
		$chargeInfoVo = SessionUtil::get ( "orderChargeInfo" );
		$customer = new CustomerVo ();
		$customerSv = new CustomerService ();
		$customer->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		// customer
		$custVo = $customerSv->selectByKey ( $customer );
		
		$expireDate = $paymentDetails->ccMonth . substr ( $paymentDetails->ccYear, - 2 );
		
		// Common setup for API credentials
		$merchantAuthentication = new MerchantAuthenticationType ();
		$merchantAuthentication->setName ( self::$apiLoginId );
		$merchantAuthentication->setTransactionKey ( self::$apiTransactionKey );
		$refId = 'ref' . time ();
		
		// Create the payment data for a credit card
		$creditCard = new CreditCardType ();
		$creditCard->setCardNumber ( $paymentDetails->ccNumber );
		$creditCard->setExpirationDate ( $expireDate );
		$creditCard->setCardCode ( $paymentDetails->ccCvv );
		$paymentOne = new PaymentType ();
		$paymentOne->setCreditCard ( $creditCard );
		
		$netOrder = new OrderType ();
		$desc = null;
		if (! empty ( $cartInfoVo->id ))
			$desc .= 'CID:' . $cartInfoVo->id;
		if (! empty ( $order->id ))
			$desc .= ' OID:' . $order->id;
		$netOrder->setDescription ( $desc );
		
		// Set the customer's Bill To address
		$customerAddress = new CustomerAddressType ();
		$customerAddress->setFirstName ( $order->billFirstName );
		$customerAddress->setLastName ( $order->billLastName );
		$customerAddress->setCompany ( $custVo->companyName );
		$customerAddress->setAddress ( $order->billAddress );
		$customerAddress->setCity ( $order->billCity );
		$customerAddress->setState ( $order->billStateCode );
		$customerAddress->setZip ( $order->billZipcode );
		$customerAddress->setCountry ( $order->billCountryCode );
		
		// Set the customer's identifying information
		$customerData = new CustomerDataType ();
		$customerData->setType ( 'individual' );
		$customerData->setId ( $order->customerId );
		$customerData->setEmail ( $order->billEmail );
		
		// Add values for transaction settings
		$duplicateWindowSetting = new SettingType ();
		$duplicateWindowSetting->setSettingName ( "duplicateWindow" );
		$duplicateWindowSetting->setSettingValue ( "600" );
		
		// Create a TransactionRequestType object
		$transactionRequestType = new TransactionRequestType ();
		$transactionRequestType->setTransactionType ( "authCaptureTransaction" );
		$transactionRequestType->setAmount ( $chargeInfoVo->grandTotalAmount );
		$transactionRequestType->setOrder ( $netOrder );
		$transactionRequestType->setPayment ( $paymentOne );
		$transactionRequestType->setBillTo ( $customerAddress );
		$transactionRequestType->setCustomer ( $customerData );
		$transactionRequestType->addToTransactionSettings ( $duplicateWindowSetting );
		
		$request = new CreateTransactionRequest ();
		$request->setMerchantAuthentication ( $merchantAuthentication );
		$request->setRefId ( $refId );
		$request->setTransactionRequest ( $transactionRequestType );
		
		$orderInfoStr = 'CartID: ' . $cartInfoVo->id . ' OrderID: ' . $order->id . ' GrandTotalAmount: ' . $chargeInfoVo->grandTotalAmount;
		
		$controller = new CreateTransactionController ( $request );
		if (self::$isSandbox) {
			$response = $controller->executeWithApiResponse ( ANetEnvironment::SANDBOX );
			$requestUrl = ANetEnvironment::SANDBOX;
		} else {
			$response = $controller->executeWithApiResponse ( ANetEnvironment::PRODUCTION );
			$requestUrl = ANetEnvironment::PRODUCTION;
		}
		if (self::$isDebug)
			LogHelper::logRequest ( LogTypeEnum::AUTHORIZENET, $requestUrl, $request, $response );
		$responseVo = self::processResponse ( $response, $orderInfoStr );
		\DatoLogUtil::debug ( '- authorizeCaptureCreditCard -' );
		return $responseVo;
	}
	private static function proxyAuthorizeCaptureCreditCard(OrderVo $order, PaymentDetailsMo $paymentDetails) {
		\DatoLogUtil::debug ( '+ proxyAuthorizeCaptureCreditCard +' );
		self::init ();
		$responseVo = new ResponseMo ();
		$sessionId = SessionUtil::get ( "sessionId" );
		// $cartInfoVo = new CartInfoVo ();
		$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $order->id );
		\DatoLogUtil::debug ( $order );
		$orderVo = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
		\DatoLogUtil::debug ( $orderVo );
		$orderChargeInfoVo = CartHelper::getOrderChargeInfoVoByInfo ( $cartInfoVo->info );
		$data = array (
				'x_Login' => self::$apiLoginId,
				'x_Tran_Key' => self::$apiTransactionKey,
				'x_Version' => '3.1',
				'x_Type' => self::$isAuthCapture ? 'AUTH_CAPTURE' : 'AUTH_ONLY',
				'x_Method' => 'CC',
				'x_Amount' => CurrencyHelper::getCurrencyFormat ( $orderChargeInfoVo->grandTotalAmount ),
				'x_Currency_Code' => 'USD',
				'x_Email_Customer' => 'FALSE',
				'x_Email_Merchant' => 'FALSE',
				'x_Cust_ID' => $orderVo->customerId,
				'x_Invoice_Num' => 0, // invoice_id
				'x_First_Name' => $orderVo->billFirstName,
				'x_Last_Name' => $orderVo->billLastName,
				'x_Company' => null,
				'x_Address' => $orderVo->billAddress,
				'x_City' => $orderVo->billCity,
				'x_State' => GeoHelper::getStateNameByStateCode ( $orderVo->billStateCode, $orderVo->billCountryCode ),
				'x_Zip' => $orderVo->billZipcode,
				'x_Country' => GeoHelper::getCountryNameByCountryCode ( $orderVo->billCountryCode ),
				'x_Phone' => $orderVo->billPhone,
				'x_Email' => $orderVo->billEmail,
				'x_Ship_To_First_Name' => $orderVo->shipFirstName,
				'x_Ship_To_Last_Name' => $orderVo->shipLastName,
				'x_Ship_To_Company' => null,
				'x_Ship_To_Address' => $orderVo->shipAddress,
				'x_Ship_To_City' => $orderVo->shipCity,
				'x_Ship_To_State' => GeoHelper::getStateNameByStateCode ( $orderVo->shipStateCode, $orderVo->shipCountryCode ),
				'x_Ship_To_Zip' => $orderVo->shipZipcode,
				'x_Ship_To_Country' => GeoHelper::getCountryNameByCountryCode ( $orderVo->shipCountryCode ),
				'x_Customer_IP' => $_SERVER ['REMOTE_ADDR'],
				'x_Description' => 'Order #' . $orderVo->id,
				'x_Card_Num' => $paymentDetails->ccNumber,
				'x_Exp_Date' => sprintf ( '%02d%02d', $paymentDetails->ccMonth, $paymentDetails->ccYear % 100 ),
				'x_Card_Code' => $paymentDetails->ccCvv,
				'x_FP_TimeStamp' => time (),
				'x_FP_Sequence' => mt_rand (),
				'x_PO_Number' => 'Order #' . $orderVo->id,
				'x_Delim_Data' => 'TRUE',
				'x_Relay_Response' => 'FALSE',
				'x_Duplicate_Window' => 5 
		);
		$data ['x_FP_Hash'] = self::hmac_md5 ( $data ['x_Login'] . '^' . $data ['x_FP_Sequence'] . '^' . $data ['x_FP_TimeStamp'] . '^' . $data ['x_Amount'] . '^' . $data ['x_Currency_Code'], self::$apiTransactionKey );
		unset ( $data ['x_Tran_Key'] ); // no need to send this with hash
		if (self::$isRelayResponse) {
			$data ['x_Relay_Response'] = 'TRUE';
			$data ['x_Delim_Data'] = 'FALSE';
			$data ['x_Relay_URL'] = self::$proxyURL;
		}
		$data = str_replace ( '|', '_', $data );
		$data ['x_Delim_Char'] = '|';
		$dataStr = json_encode ( $data );
		\DatoLogUtil::debug ( $dataStr );
		$ch = curl_init ();
		// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		// curl_setopt($ch, CURLOPT_PROXY, MODULE_PAYMENT_PAYPAL_DP_PROXY);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_URL, self::$anetURL );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data, '', '&' ) );
		
		$res = curl_exec ( $ch );
		$resStr = json_encode ( $res );
		\DatoLogUtil::debug ( $resStr );
		if (curl_errno ( $ch ) != 0) {
			$errMsg = sprintf ( _pl ( 'HTTP Request Failed: %d - %s' ), curl_errno ( $ch ), curl_error ( $ch ) );
			DatoLogUtil::error ( $errMsg );
			ResponseHelper::setError ( $responseVo, $errMsg );
		}
		$orderInfoStr = 'CartID: ' . $cartInfoVo->id . ' OrderID: ' . $order->id . ' GrandTotalAmount: ' . $chargeInfoVo->grandTotalAmount;
		if (self::$isDebug)
			LogHelper::logRequest ( LogTypeEnum::AUTHORIZENET, self::$anetURL, $data, $res );
		if (! ResponseHelper::isError ( $responseVo ))
			$responseVo = self::proxyProcessResponse ( $responseVo, $res );
			// The reporting of this transaction to the Merchant has timed out.
			// This transaction has been approved.
			// send notification email to customer care and customer when merchant timeout.
		if (ResponseHelper::isError ( $responseVo )) {
			$str1 = 'timed out';
			$str2 = 'timeout';
			if (strpos ( $responseVo->msg, $str1 ) !== false || strpos ( $responseVo->msg, $str2 ) !== false) {
				//send email to region customer support
				//send email to customer
			}
		}
		\DatoLogUtil::debug ( $responseVo );
		\DatoLogUtil::debug ( '- proxyAuthorizeCaptureCreditCard -' );
		return $responseVo;
	}
	// getResponseCode : 1
	// getAuthCode : H05U7F
	// getTransId : 60022993353
	// getMessages () [0]->getCode () : 1
	// orderInfo: CartID: 2 OrderID: 1 GrandTotalAmount: 25
	// getMessages () [0]->getDescription () : This transaction has been approved.
	// orderinfo = CartID: xxx OrderID: xxx GrandTotalAmount: xxx
	private static function processResponse($response, $orderInfoStr) {
		$responseVo = new ResponseMo ();
		
		if ($response != null) {
			if ($response->getMessages ()->getResultCode () == 'Ok') {
				$tresponse = $response->getTransactionResponse ();
				
				if ($tresponse != null && $tresponse->getMessages () != null) {
					$msg = null;
					$msg .= " Transaction Response Code : " . $tresponse->getResponseCode () . "\n";
					$msg .= " Auth Code : " . $tresponse->getAuthCode () . "\n";
					$msg .= " Transaction ID : " . $tresponse->getTransId () . "\n";
					$msg .= " Code : " . $tresponse->getMessages () [0]->getCode () . "\n";
					$msg .= "orderInfo: $orderInfoStr \n";
					$msg .= " Description : " . $tresponse->getMessages () [0]->getDescription () . "\n";
					$response->txnId = $tresponse->getTransId ();
					$response->remark = $orderInfoStr;
					$response->description = $msg;
					\DatoLogUtil::trace ( $msg );
					$responseVo = ResponseHelper::setSuccess ( $responseVo, "Transaction successful. " . $msg, $response );
				} else {
					\DatoLogUtil::trace ( "Transaction Failed \n" );
					if ($tresponse->getErrors () != null) {
						\DatoLogUtil::trace ( " Error code  : " . $tresponse->getErrors () [0]->getErrorCode () . "\n" );
						\DatoLogUtil::trace ( " Error message : " . $tresponse->getErrors () [0]->getErrorText () . "\n" );
						$errCode = $tresponse->getErrors () [0]->getErrorCode ();
						$errMsg = $tresponse->getErrors () [0]->getErrorText ();
						$responseVo = ResponseHelper::setError ( $responseVo, 'Transaction Failed. [' . $errCode . '] ' . $errMsg . ' orderInfo: ' . $orderInfoStr . '.', $response );
					}
				}
			} else {
				\DatoLogUtil::trace ( "Transaction Failed \n" );
				$tresponse = $response->getTransactionResponse ();
				$errCode = null;
				$errMsg = null;
				if ($tresponse != null && $tresponse->getErrors () != null) {
					\DatoLogUtil::trace ( " Error code  : " . $tresponse->getErrors () [0]->getErrorCode () . "\n" );
					\DatoLogUtil::trace ( " Error message : " . $tresponse->getErrors () [0]->getErrorText () . "\n" );
					$errCode = $tresponse->getErrors () [0]->getErrorCode ();
					$errMsg = $tresponse->getErrors () [0]->getErrorText ();
				} else {
					\DatoLogUtil::trace ( " Error code  : " . $response->getMessages ()->getMessage () [0]->getCode () . "\n" );
					\DatoLogUtil::trace ( " Error message : " . $response->getMessages ()->getMessage () [0]->getText () . "\n" );
					$errCode = $response->getMessages ()->getMessage () [0]->getCode ();
					$errMsg = $response->getMessages ()->getMessage () [0]->getText ();
				}
				$responseVo = ResponseHelper::setError ( $responseVo, 'Transaction Failed. [' . $errCode . '] ' . $errMsg . ' orderInfo: ' . $orderInfoStr . '.', $response );
			}
		} else {
			\DatoLogUtil::trace ( "No response returned \n" );
			$responseVo = ResponseHelper::setError ( $responseVo, "Transaction Failed. No response returned. orderInfo: $orderInfoStr.", $response );
		}
		\DatoLogUtil::trace ( 'txnId:' . JsonUtil::encode ( $responseVo->data ) );
		return $responseVo;
	}
	private static function proxyProcessResponse(ResponseMo $responseVo, $res) {
		self::init ();
		if (self::$isRelayResponse && strncmp ( $res, 'PURL OK ', 8 ) == 0)
			$rd = self::formatResponse ( json_decode ( substr ( $res, 8 ), true ) );
		else
			$rd = self::formatResponse ( $res );
			// echo "<p><hr/></p>";
			// var_dump ( $rd );
		\DatoLogUtil::debug ( $rd );
		if ($rd ['response_code']->textvalue == 'Approved') {
			$msg = Lang::get ( 'Your Credit Card was Approved' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
			ResponseHelper::setSuccess ( $responseVo, $msg, $rd );
		} else {
			switch ($rd ['response_code']->textvalue) {
				case 'Declined' :
					$msg = Lang::get ( 'Your Credit Card was Declined' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					ResponseHelper::setError ( $responseVo, $msg, $rd );
					break;
				case 'Held for Review' :
					$msg = Lang::get ( 'Transaction was Held for Review' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					ResponseHelper::setError ( $responseVo, $msg, $rd );
					break;
				case 'Error' :
					$msg = Lang::get ( 'Authorize.net Error' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					ResponseHelper::setError ( $responseVo, $msg, $rd );
					break;
				default :
					$msg = Lang::get ( 'Authorize.net Connection Failed' );
					if ($rd ['response_reason_text']->textvalue != '')
						$msg = Lang::get ( 'Unknown Error' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					else if ($rd ['response_code']->textvalue != '')
						$msg = strip_tags ( $rd ['response_code']->textvalue );
					ResponseHelper::setError ( $responseVo, $msg, $rd );
					break;
			}
		}
		$responseVo->data = ( object ) $responseVo->data;
		$responseVo->data->txnId = $rd ['trans_id']->value;
		$responseVo->data->remark = json_encode ( $rd );
		$responseVo->data->description = $responseVo->msg;
		$responseVo->data->authCode = $rd ['auth_code']->value;
		$responseVo->data->code = $rd ['response_reason_code']->value;
		$responseVo->data->orderInfo = $rd ['description']->value . ' Amount:' . $rd ['amount']->value;
		$responseVo->data->detailMo = OrderHelper::setOrderHistoryDetailMo ( OrderHistoryActionEnum::PAYMENT, PaymentMethodEnum::AUTHORIZE_NET, $rd ['trans_id']->value, $rd ['account_number']->value );
		\DatoLogUtil::debug ( 'responseVo:' . JsonUtil::encode ( $responseVo ) );
		return $responseVo;
	}
	
	/**
	 * Make a full or partial refund of order
	 *
	 * @param int $orderId
	 *        	Order Id
	 * @param float $amount
	 *        	Amount to refund or null for a full refund
	 * @return bool true if refund was successful
	 */
	public static function refund($orderId, $refundAmt = null) {
		self::init ();
		$responseVo = new ResponseMo ();
		$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $orderId );
		$orderVo = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
		$responseVo = self::isValidRefund ( $orderId, $refundAmt );
		if (! ResponseHelper::isError ( $responseVo )) {
			// process refund
			// $paymentTxnVo = PaymentHelper::getPaymentTxnVoById ( $cartInfoVo->id );
			// $arr = explode ( ':', $paymentTxnVo->txnId );
			// $txnId = $arr [0];
			// $accNum = $arr [1];
			$orderHistoryVo = PaymentHelper::getOrderHistoryVoByOrderId ( $orderId );
			$orderHistoryDetailMo = new OrderHistoryDetailMo ();
			$orderHistoryDetailMo = $orderHistoryVo->detail;
			
			$txnId = $orderHistoryDetailMo->transactionId;
			$accNum = $orderHistoryDetailMo->accountNumber;
			
			\DatoLogUtil::debug ( JsonUtil::encode ( $orderHistoryVo ) );
			\DatoLogUtil::debug ( JsonUtil::encode ( $paymentTxnVo ) );
			$data = array (
					'x_Login' => self::$apiLoginId,
					'x_Tran_Key' => self::$apiTransactionKey,
					'x_Version' => '3.1',
					'x_Type' => 'CREDIT',
					'x_Trans_Id' => $txnId,
					'x_Card_Num' => substr ( $accNum, - 4 ),
					'x_Amount' => number_format ( $refundAmt, 2 ),
					'x_Currency_Code' => 'USD',
					'x_FP_TimeStamp' => time (),
					'x_FP_Sequence' => mt_rand (),
					'x_Delim_Data' => 'TRUE',
					'x_Relay_Response' => 'FALSE' 
			);
			$preRefundAmt = OrderHelper::getTotalRefundAmtByOrderId ( $orderId );
			$chargeInfoVo = CartHelper::getOrderChargeInfoVoByInfo ( $cartInfoVo->info );
			
			$data ['x_FP_Hash'] = self::hmac_md5 ( $data ['x_Login'] . '^' . $data ['x_FP_Sequence'] . '^' . $data ['x_FP_TimeStamp'] . '^' . $data ['x_Amount'] . '^' . $data ['x_Currency_Code'], self::$apiTransactionKey );
			// TODO: figure out why omitting tran_key doesn't work
			// unset($data['x_Tran_Key']); // no need to send this with hash
			
			$data = str_replace ( '|', '_', $data );
			$data ['x_Delim_Char'] = '|';
			
			$ch = curl_init ();
			// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			// curl_setopt($ch, CURLOPT_PROXY, MODULE_PAYMENT_PAYPAL_DP_PROXY);
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_URL, self::$anetURL );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data, '', '&' ) );
			
			$res = curl_exec ( $ch );
			if (self::$isDebug)
				LogHelper::logRequest ( LogTypeEnum::AUTHORIZENET, $anetURL, $data, $res );
			if (curl_errno ( $ch ) != 0) {
				$errMsg = sprintf ( _pl ( 'HTTP Request Failed: %d - %s' ), curl_errno ( $ch ), curl_error ( $ch ) );
				DatoLogUtil::error ( $errMsg );
				ResponseHelper::setError ( $responseVo, $errMsg );
			}
			curl_close ( $ch );
			
			$rd = self::formatResponse ( $res );
			
			if ($rd ['response_code']->textvalue != 'Approved' && $chargeInfoVo->grandTotalAmount + ($preRefundAmt - $refundAmt) == 0) {
				// if balance is 0, void payment.
				$data ['x_Type'] = 'VOID';
				
				$ch = curl_init ();
				// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				// curl_setopt($ch, CURLOPT_PROXY, MODULE_PAYMENT_PAYPAL_DP_PROXY);
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
				curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
				curl_setopt ( $ch, CURLOPT_POST, 1 );
				curl_setopt ( $ch, CURLOPT_URL, self::$anetURL );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data, '', '&' ) );
				
				$res = curl_exec ( $ch );
				if (self::$isDebug)
					LogHelper::logRequest ( LogTypeEnum::AUTHORIZENET, self::$anetURL, $data, $res );
				if (curl_errno ( $ch ) != 0) {
					$errMsg = sprintf ( _pl ( 'HTTP Request Failed: %d - %s' ), curl_errno ( $ch ), curl_error ( $ch ) );
					DatoLogUtil::error ( $errMsg );
					ResponseHelper::setError ( $responseVo, $errMsg );
				}
				curl_close ( $ch );
				
				$rd = self::formatResponse ( $res );
			}
			
			if (! ResponseHelper::isError ( $responseVo ))
				$responseVo = self::proxyProcessResponse ( $responseVo, $res );
			if (! ResponseHelper::isError ( $responseVo )) {
				$orderSvc = new OrderService ();
				
				// update order status
				// insert order history
				// update payment txn
				if ($data ['x_Type'] == 'VOID' || $chargeInfoVo->grandTotalAmount - ($preRefundAmt + $refundAmt) == 0)
					$orderVo->orderStatusId = OrderStatusEnum::REFUNDED;
				
				$orderHistoryVo = PaymentHelper::setOrderHistory ( $orderVo, $responseVo );
				$responseVo->data->txnId = null;
				$responseVo->data->remark = null;
				$responseVo->data->description = null;
				$paymentTxnVo = PaymentHelper::setPaymentTxn ( $orderVo, $responseVo );
				\DatoLogUtil::debug ( $orderHistoryVo );
				\DatoLogUtil::debug ( $paymentTxnVo );
				$resultArr = $orderSvc->updateOrderStatusByTransaction ( $orderVo, $orderHistoryVo, $paymentTxnVo );
				$orderHistoryId = $resultArr ['orderHistoryId'];
				
				// insert refund record
				if ($refundAmt > 0)
					$refundAmt *= - 1;
				$orderRefundVo = PaymentHelper::setOrderRefund ( $orderId, $orderHistoryId, $refundAmt );
				$orderRefundDao = new OrderRefundBaseDao ();
				\DatoLogUtil::debug ( $orderRefundVo );
				$orderRefundDao->insertDynamic ( $orderRefundVo );
				$msg = 'Refund successful.';
				ResponseHelper::setSuccess ( $responseVo, $msg );
			}
		}
		
		return $responseVo;
	}
	private static function isValidRefund($orderId, $refundAmt) {
		$responseVo = new ResponseMo ();
		if (! is_numeric ( $refundAmt )) {
			ResponseHelper::setError ( $responseVo, Lang::get ( 'Refund amount have to be number.' ) );
		} else if ($refundAmt <= 0) {
			ResponseHelper::setError ( $responseVo, Lang::get ( 'Refund amount must be more than 0.' ) );
		}
		$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $orderId );
		if (! ResponseHelper::isError ( $responseVo )) {
			$orderVo = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
			if (is_null ( $orderVo ) || is_null ( $orderVo->id )) {
				ResponseHelper::setError ( $responseVo, Lang::get ( 'Order for order id #' . $orderId . ' not found.' ) );
			} else if ($orderVo->paymentMethod != PaymentMethodEnum::AUTHORIZE_NET) {
				ResponseHelper::setError ( $responseVo, Lang::get ( 'Invalid payment method #' . $orderVo->paymentMethod . '.' ) );
			} else if ($orderVo->orderStatusId != OrderStatusEnum::PAID && $orderVo->orderStatusId != OrderStatusEnum::REFUNDED) {
				ResponseHelper::setError ( $responseVo, Lang::get ( 'Invalid order status #' . $orderVo->orderStatusId . '.' ) );
			}
		}
		if (! ResponseHelper::isError ( $responseVo )) {
			// $paymentTxnVo = PaymentHelper::getPaymentTxnVoById ( $cartInfoVo->id );
			// $arr = explode ( ':', $paymentTxnVo->txnId );
			// $txnId = $arr [0];
			// $accNum = $arr [1];
			$orderHistoryVo = PaymentHelper::getOrderHistoryVoByOrderId ( $orderId );
			$orderHistoryDetailMo = new OrderHistoryDetailMo ();
			$orderHistoryDetailMo = $orderHistoryVo->detail;
			\DatoLogUtil::debug ( $orderHistoryDetailMo );
			$txnId = $orderHistoryDetailMo->transactionId;
			$accNum = $orderHistoryDetailMo->accountNumber;
			if (empty ( $txnId )) {
				ResponseHelper::setError ( $responseVo, Lang::get ( 'Transaction ID is empty.' ) );
			} else if (empty ( $accNum )) {
				ResponseHelper::setError ( $responseVo, Lang::get ( 'Account number is empty.' ) );
			}
		}
		if (! ResponseHelper::isError ( $responseVo )) {
			
			$preRefundAmt = OrderHelper::getTotalRefundAmtByOrderId ( $orderId );
			$chargeInfoVo = CartHelper::getOrderChargeInfoVoByInfo ( $cartInfoVo->info );
			if ($chargeInfoVo->grandTotalAmount + ($preRefundAmt - $refundAmt) < 0) {
				\DatoLogUtil::info ( 'GrandTotalAmt:' . $chargeInfoVo->grandTotalAmount . ' prevRefundAmt:' . $preRefundAmt . ' refundAmt:' . $refundAmt );
				ResponseHelper::setError ( $responseVo, Lang::get ( 'Refund amt more than order amount.' ) );
			}
		}
		
		return $responseVo;
	}
	public static function proxyTest() {
		self::init ();
		$orderId = 7;
		// $orderVo = new OrderVo();
		$orderVo = OrderHelper::getOrderVoById ( $orderId );
		$paymentDetailsMo = new PaymentDetailsMo ();
		$paymentDetailsMo->ccName = 'test card';
		$paymentDetailsMo->ccNumber = '4111111111111111';
		$paymentDetailsMo->ccType = 'visa';
		$paymentDetailsMo->ccMonth = '12';
		$paymentDetailsMo->ccYear = '2026';
		$paymentDetailsMo->ccCvv = '123';
		$amt = '1';
		$data = array (
				'x_Login' => self::$apiLoginId,
				'x_Tran_Key' => self::$apiTransactionKey,
				'x_Version' => '3.1',
				'x_Type' => self::$isAuthCapture ? 'AUTH_CAPTURE' : 'AUTH_ONLY',
				'x_Method' => 'CC',
				'x_Amount' => CurrencyHelper::getCurrencyFormat ( $amt ),
				'x_Currency_Code' => 'USD',
				'x_Email_Customer' => 'FALSE',
				'x_Email_Merchant' => 'FALSE',
				'x_Cust_ID' => $orderVo->customerId,
				'x_Invoice_Num' => 0, // invoice_id
				'x_First_Name' => $orderVo->billFirstName,
				'x_Last_Name' => $orderVo->billLastName,
				'x_Company' => null,
				'x_Address' => $orderVo->billAddress,
				'x_City' => $orderVo->billCity,
				'x_State' => $orderVo->billStateCode,
				'x_Zip' => $orderVo->billZipcode,
				'x_Country' => $orderVo->billCountryCode,
				'x_Phone' => $orderVo->billPhone,
				'x_Email' => $orderVo->billEmail,
				'x_Ship_To_First_Name' => $orderVo->shipFirstName,
				'x_Ship_To_Last_Name' => $orderVo->shipLastName,
				'x_Ship_To_Company' => null,
				'x_Ship_To_Address' => $orderVo->shipAddress,
				'x_Ship_To_City' => $orderVo->shipCity,
				'x_Ship_To_State' => $orderVo->shipStateCode,
				'x_Ship_To_Zip' => $orderVo->shipZipcode,
				'x_Ship_To_Country' => $orderVo->shipCountryCode,
				'x_Customer_IP' => $_SERVER ['REMOTE_ADDR'],
				'x_Description' => 'Order #' . $orderVo->id,
				'x_Card_Num' => $paymentDetailsMo->ccNumber,
				'x_Exp_Date' => sprintf ( '%02d%02d', $paymentDetailsMo->ccMonth, $paymentDetailsMo->ccYear % 100 ),
				'x_Card_Code' => $paymentDetailsMo->ccCvv,
				'x_FP_TimeStamp' => time (),
				'x_FP_Sequence' => mt_rand (),
				'x_PO_Number' => 'Order #' . $orderVo->id,
				'x_Delim_Data' => 'TRUE',
				'x_Relay_Response' => 'FALSE',
				'x_Duplicate_Window' => 5 
		);
		$data ['x_FP_Hash'] = self::hmac_md5 ( $data ['x_Login'] . '^' . $data ['x_FP_Sequence'] . '^' . $data ['x_FP_TimeStamp'] . '^' . $data ['x_Amount'] . '^' . $data ['x_Currency_Code'], self::$apiTransactionKey );
		unset ( $data ['x_Tran_Key'] ); // no need to send this with hash
		if (self::$isRelayResponse) {
			$data ['x_Relay_Response'] = 'TRUE';
			$data ['x_Delim_Data'] = 'FALSE';
			$data ['x_Relay_URL'] = self::$proxyURL;
		}
		$data = str_replace ( '|', '_', $data );
		$data ['x_Delim_Char'] = '|';
		$dataStr = json_encode ( $data );
		\DatoLogUtil::debug ( $dataStr );
		$ch = curl_init ();
		// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		// curl_setopt($ch, CURLOPT_PROXY, MODULE_PAYMENT_PAYPAL_DP_PROXY);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_URL, self::$anetURL );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data, '', '&' ) );
		
		$res = curl_exec ( $ch );
		
		if (curl_errno ( $ch ) != 0)
			DatoLogUtil::error ( sprintf ( _pl ( 'HTTP Request Failed: %d - %s' ), curl_errno ( $ch ), curl_error ( $ch ) ) );
			// var_dump ( $res );
		\DatoLogUtil::debug ( $res );
		curl_close ( $ch );
		
		if (self::$isRelayResponse && strncmp ( $res, 'PURL OK ', 8 ) == 0)
			$rd = self::formatResponse ( json_decode ( substr ( $res, 8 ), true ) );
		else
			$rd = self::formatResponse ( $res );
		echo "<p><hr/></p>";
		var_dump ( $rd );
		if ($rd ['response_code']->textvalue != 'Approved') {
			switch ($rd ['response_code']->textvalue) {
				case 'Declined' :
					$error [] = _pl ( 'Your Credit Card was Declined' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					break;
				case 'Held for Review' :
					$error [] = _pl ( 'Transaction was Held for Review' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					break;
				case 'Error' :
					$error [] = _pl ( 'Authorize.net Error' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					break;
				default :
					if ($rd ['response_reason_text']->textvalue != '')
						$error [] = _pl ( 'Unknown Error' ) . ': ' . $rd ['response_reason_text']->textvalue . ' [' . $rd ['response_reason_code']->textvalue . ']';
					else if ($rd ['response_code']->textvalue != '')
						$error [] = strip_tags ( $rd ['response_code']->textvalue );
					else
						$error [] = _pl ( 'Authorize.net Connection Failed' );
					break;
			}
		}
		var_dump ( $error );
	}
	public static function formatResponse($res) {
		\DatoLogUtil::debug ( '+ formatResponse +' );
		static $res_data = array (
				array (
						'id' => 'x_response_code',
						'description' => 'Transaction Status',
						'report' => true,
						'values' => array (
								'1' => 'Approved',
								'2' => 'Declined',
								'3' => 'Error',
								'4' => 'Held for Review' 
						) 
				),
				array (
						'id' => 'x_response_code2',
						'description' => 'Transaction Status ?' 
				),
				array (
						'id' => 'x_response_reason_code',
						'description' => 'Reason Code',
						'report' => true 
				),
				array (
						'id' => 'x_response_reason_text',
						'description' => 'Reason Code Description',
						'report' => true 
				),
				array (
						'id' => 'x_auth_code',
						'description' => 'Authorization or Approval Code',
						'report' => true 
				),
				array (
						'id' => 'x_avs_code',
						'description' => 'The Address Verification Service (AVS) Response',
						'report' => true,
						'values' => array (
								'A' => 'Address (Street) matches, ZIP does not',
								'B' => 'Address information not provided for AVS check',
								'E' => 'AVS error',
								'G' => 'Non-U.S. Card Issuing Bank',
								'N' => 'No Match on Address (Street) or ZIP',
								'P' => 'AVS not applicable for this transaction',
								'R' => 'Retry – System unavailable or timed out',
								'S' => 'Service not supported by issuer',
								'U' => 'Address information is unavailable',
								'W' => 'Nine digit ZIP matches, Address (Street) does not',
								'X' => 'Address (Street) and nine digit ZIP match',
								'Y' => 'Address (Street) and five digit ZIP match',
								'Z' => 'Five digit ZIP matches, Address (Street) does not' 
						) 
				),
				array (
						'id' => 'x_trans_id',
						'description' => 'Payment Gateway Transaction ID Number',
						'report' => true 
				),
				array (
						'id' => 'x_invoice_num',
						'description' => 'Merchant Assigned Invoice Nr',
						'report' => false 
				),
				array (
						'id' => 'x_description',
						'description' => 'Transaction Description',
						'report' => true 
				),
				array (
						'id' => 'x_amount',
						'description' => 'Transaction Amount',
						'report' => true 
				),
				array (
						'id' => 'x_method',
						'description' => 'Payment Method',
						'report' => true,
						'values' => array (
								'CC' => 'Credit Card',
								'ECHECK' => 'E-Check' 
						) 
				),
				array (
						'id' => 'x_type',
						'description' => 'Transaction Type',
						'report' => true,
						'values' => array (
								'AUTH_CAPTURE' => 'Authorization and Capture',
								'AUTH_ONLY' => 'Authorization Only',
								'CREDIT' => 'Credit Refund',
								'PRIOR_AUTH_CAPTURE' => 'Prior Authorization Only Capture',
								'VOID' => 'Void Transaction' 
						) 
				),
				array (
						'id' => 'x_cust_id',
						'description' => 'Merchant Assigned Customer ID',
						'report' => false 
				),
				array (
						'id' => 'x_first_name',
						'description' => 'billing - first name',
						'report' => false 
				),
				array (
						'id' => 'x_last_name',
						'description' => 'billing - last name',
						'report' => false 
				),
				array (
						'id' => 'x_company',
						'description' => 'billing - company',
						'report' => false 
				),
				array (
						'id' => 'x_address',
						'description' => 'billing - address',
						'report' => false 
				),
				array (
						'id' => 'x_city',
						'description' => 'billing - city',
						'report' => false 
				),
				array (
						'id' => 'x_state',
						'description' => 'billing - state',
						'report' => false 
				),
				array (
						'id' => 'x_zip',
						'description' => 'billing - ZIP code',
						'report' => false 
				),
				array (
						'id' => 'x_country',
						'description' => 'billing - country',
						'report' => false 
				),
				array (
						'id' => 'x_phone',
						'description' => 'billing - phone number',
						'report' => false 
				),
				array (
						'id' => 'x_fax',
						'description' => 'billing - fax number',
						'report' => false 
				),
				array (
						'id' => 'x_email',
						'description' => 'customer’s email address',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_first_name',
						'description' => 'shipping - first name',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_last_name',
						'description' => 'shipping - last name',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_company',
						'description' => 'shipping - company',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_address',
						'description' => 'shipping - address',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_city',
						'description' => 'shipping - city',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_state',
						'description' => 'shipping - state',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_zip',
						'description' => 'shipping - ZIP code',
						'report' => false 
				),
				array (
						'id' => 'x_ship_to_country',
						'description' => 'shipping - country',
						'report' => false 
				),
				array (
						'id' => 'x_tax',
						'description' => 'The tax amount charged',
						'report' => false 
				),
				array (
						'id' => 'x_duty',
						'description' => 'The duty amount charged',
						'report' => false 
				),
				array (
						'id' => 'x_freight',
						'description' => 'The freight amount charged',
						'report' => false 
				),
				array (
						'id' => 'x_tax_exempt',
						'description' => 'The tax exempt status',
						'report' => false 
				),
				array (
						'id' => 'x_po_num',
						'description' => 'The merchant assigned purchase order number',
						'report' => false 
				),
				array (
						'id' => 'x_MD5_Hash',
						'description' => 'The payment gateway generated MD5 hash value that can be used to authenticate the transaction response.',
						'report' => false 
				),
				array (
						'id' => 'x_cvv2_resp_code',
						'description' => 'The card code verification (CCV) response code',
						'report' => true,
						'values' => array (
								'M' => 'Match',
								'N' => 'No Match',
								'P' => 'Not Processed',
								'S' => 'Should have been present',
								'U' => 'Issuer unable to process request' 
						) 
				),
				array (
						'id' => 'x_cavv_response',
						'description' => 'The cardholder authentication verification response code',
						'report' => true,
						'values' => array (
								'' => 'CAVV not validated',
								'0' => 'CAVV not validated because erroneous data was submitted',
								'1' => 'CAVV failed validation',
								'2' => 'CAVV passed validation',
								'3' => 'CAVV validation could not be performed; issuer attempt incomplete',
								'4' => 'CAVV validation could not be performed; issuer system error',
								'5' => 'Reserved for future use',
								'6' => 'Reserved for future use',
								'7' => 'CAVV attempt – failed validation – issuer available (U.S.-issued card/non-U.S acquirer)',
								'8' => 'CAVV attempt – passed validation – issuer available (U.S.-issued card/non-U.S. acquirer)',
								'9' => 'CAVV attempt – failed validation – issuer unavailable (U.S.-issued card/non-U.S. acquirer)',
								'A' => 'CAVV attempt – passed validation – issuer unavailable (U.S.-issued card/non-U.S. acquirer)',
								'B' => 'CAVV passed validation, information only, no liability shift	' 
						) 
				),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (
						'id' => 'x_account_number',
						'description' => 'Credit Card Last 4 Digits',
						'report' => true 
				),
				array (
						'id' => 'x_card_type',
						'description' => 'Credit Card Type',
						'report' => true 
				),
				array (
						'id' => 'x_split_tender_id',
						'description' => 'Value that links the current authorization request to the original authorization request.',
						'report' => false 
				),
				array (
						'id' => 'x_prepaid_requested_amount',
						'description' => 'Amount requested in the original authorization',
						'report' => true 
				),
				array (
						'id' => 'x_prepaid_balance_on_card',
						'description' => 'Balance on the debit card or prepaid card',
						'report' => true 
				),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (),
				array (
						'id' => 'x_po_number',
						'description' => 'Merchant assigned Purchase Order Number',
						'report' => true 
				) 
		);
		
		if (! is_array ( $res ))
			$res = explode ( '|', $res );
		
		$is_a = self::is_assoc ( $res );
		
		$data = array ();
		foreach ( $res_data as $i => $d ) {
			if (! isset ( $d ['id'] ))
				continue;
			$v = $is_a ? $res [$d ['id']] : $res [$i];
			$r = strtoupper ( $v );
			$data [substr ( $d ['id'], 2 )] = ( object ) array (
					'value' => $v,
					'info' => $d ['description'],
					'report' => $d ['report'],
					'textvalue' => is_array ( $d ['values'] ) && isset ( $d ['values'] [$r] ) ? $d ['values'] [$r] : $v 
			);
		}
		\DatoLogUtil::debug ( '- formatResponse -' );
		return $data;
	}
	protected static function relayResponse() {
		\DatoLogUtil::debug ( '+ relayResponse +' );
		echo 'PURL OK ' . json_encode ( $_POST );
		\DatoLogUtil::debug ( '- relayResponse -' );
		exit ();
	}
	public static function hmac_md5($data, $key) {
		if (function_exists ( 'hash_hmac' ))
			return hash_hmac ( 'md5', $data, $key );
		
		if (function_exists ( 'mhash' ))
			return bin2hex ( mhash ( MHASH_MD5, $data, $key ) );
		
		$b = 64; // byte length for md5
		if (strlen ( $key ) > $b)
			$key = pack ( "H*", md5 ( $key ) );
		$key = str_pad ( $key, $b, chr ( 0x00 ) );
		$ipad = str_pad ( '', $b, chr ( 0x36 ) );
		$opad = str_pad ( '', $b, chr ( 0x5c ) );
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;
		
		return md5 ( $k_opad . pack ( 'H*', md5 ( $k_ipad . $data ) ) );
	}
	private static function is_assoc($var) {
		return is_array ( $var ) && array_diff_key ( $var, array_keys ( array_keys ( $var ) ) );
	}
}