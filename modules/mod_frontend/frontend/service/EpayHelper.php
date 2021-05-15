<?php

namespace frontend\service;

use common\config\OrderStatusEnum;
use common\model\PaymentDetailsMo;
use common\model\ResponseMo;
use common\persistence\base\vo\OrderVo;
use core\Lang;
use core\utils\RequestUtil;

class EpayHelper {
// 	Site URL: https://www.endobotanical.com/
	
// 	This is a shadow site. So we only use this to process the credit card payments outside USA if the main merchant is down / unavailable.
	
// 	This needs to be brought over to the new server. It does not need to be using DatoEC, just need to live on the new server for now.
	
// 	Merchant dashboard: https://admin.ditonlinebetalingssystem.dk/admin/login.asp
// 	API / Webservice - https://admin.ditonlinebetalingssystem.dk/admin/remote_access.asp
// 	Test Info -https://admin.ditonlinebetalingssystem.dk/admin/support_testinfo.asp
// 	UN: endobotanical01
// 	PW: Chailing:1

	//live merchant number 1025712
	//biz code 4514
	//PBS INTERNET	
	
	
	//test merchant number 8025712
	//biz code 4514
	//TEST-MERCHANT
	
	public static function isValid(PaymentDetailsMo $mo) {
		// $billCcName = RequestUtil::get ( 'epay_cc_name' );
		// $billCcType = RequestUtil::get ( 'epay_cc_type' );
		// $billCcNumber = RequestUtil::get ( 'epay_cc_number' );
		// $billCcYear = RequestUtil::get ( 'epay_cc_year' );
		// $billCcMonth = RequestUtil::get ( 'epay_cc_month' );
		// $billCcCvv = RequestUtil::get ( 'epay_cc_cvv' );
		$billCcName = $mo->ccName;
		$billCcType = $mo->ccType;
		$billCcNumber = $mo->ccNumber;
		$billCcYear = $mo->ccYear;
		$billCcMonth = $mo->ccMonth;
		$billCcCvv = $mo->ccCvv;
		$errArr = null;
		if (empty ( $billCcName )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Full Name on Credit Card' );
			$errArr ['epay_cc_name'] = $errMsg;
		}
		if (empty ( $billCcType )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Type' );
			$errArr ['epay_cc_type'] = $errMsg;
		}
		if (empty ( $billCcNumber )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Number' );
			$errArr ['epay_cc_number'] = $errMsg;
		}
		if (empty ( $billCcYear )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Expiry Year' );
			$errArr ['epay_cc_year'] = $errMsg;
		}
		if (empty ( $billCcMonth )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Expiry Month' );
			$errArr ['epay_cc_month'] = $errMsg;
		}
		if (empty ( $billCcCvv )) {
			$errMsg = Lang::getWithFormat ( "{0} is require", 'Credit Card Security Code (CVV)' );
			$errArr ['epay_cc_cvv'] = $errMsg;
		}
		return $errArr;
	}
	public static function processPayment(OrderVo $order, PaymentDetailsMo $paymentDetails) {
		$response = new ResponseMo ();
		// process authorize payment
		// process payment result
		if ($paymentDetails->ccCvv == 'success') {
			$order->orderStatusId = OrderStatusEnum::PAID;
			ResponseHelper::setSuccess ( $response, 'Payment Success.' );
		} else {
			$order->orderStatusId = OrderStatusEnum::UNSUCESSFUL;
			ResponseHelper::setError ( $response, 'Payment Error.' );
		}
		\DatoLogUtil::trace( $response );
		return $response;
	}
}