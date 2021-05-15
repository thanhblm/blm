<?php

namespace frontend\service;

use common\config\OrderStatusEnum;
use common\config\PaymentMethodEnum;
use common\config\ShippingStatusEnum;
use common\helper\DatoImageHelper;
use common\helper\SettingHelper;
use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\dao\OrderChargeInfoBaseDao;
use common\persistence\base\dao\OrderHistoryBaseDao;
use common\persistence\base\dao\OrderProductBaseDao;
use common\persistence\base\dao\OrderShipingInfoBaseDao;
use common\persistence\base\dao\OrderStatusBaseDao;
use common\persistence\base\dao\OrderTotalBaseDao;
use common\persistence\base\dao\PaymentMethodBaseDao;
use common\persistence\base\dao\ProductBaseDao;
use common\persistence\base\dao\ShippingMethodBaseDao;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderShipingInfoVo;
use common\persistence\base\vo\OrderStatusVo;
use common\persistence\base\vo\OrderTotalVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\base\vo\ShippingMethodVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use common\rule\url\friendly\ProductUrlFriendly;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\services\customer\CustomerService;
use common\services\email_template\EmailTemplateService;
use common\services\order\OrderStatusService;
use common\services\payment\PaymentMethodService;
use common\services\shipping\ShippingMethodService;
use common\utils\ObjectUtil;
use common\utils\StringUtil;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use common\persistence\base\dao\OrderRefundBaseDao;
use common\persistence\base\vo\OrderRefundVo;
use common\config\RegionEnum;
use common\model\OrderHistoryDetailMo;
use common\persistence\base\vo\AddressVo;
use core\utils\DateTimeUtil;

class OrderHelper {
	public static function getOrderStatusById($orderStatusId) {
		$orderStatusDao = new OrderStatusBaseDao ();
		$orderStatusVo = new OrderStatusVo ();
		$orderStatusVo->id = $orderStatusId;
		$orderStatusVo = $orderStatusDao->selectByKey ( $orderStatusVo );
		return $orderStatusVo->name;
	}
	public static function getOrderVoById($orderId) {
		$orderDao = new OrderBaseDao ();
		$orderVo = new OrderVo ();
		$orderVo->id = $orderId;
		$orderVo = $orderDao->selectByKey ( $orderVo );
		return $orderVo;
	}
	public static function getOrderProductVoListByOrderId($orderId) {
		$orderProductDao = new OrderProductBaseDao ();
		$orderProductVo = new OrderProductVo ();
		$orderProductVo->orderId = $orderId;
		$orderProductVoList = $orderProductDao->selectByFilter ( $orderProductVo );
		return $orderProductVoList;
	}
	public static function getOrderChargeInfoVoByOrderId($orderId) {
		$orderChargeInfoDao = new OrderChargeInfoBaseDao ();
		$orderChargeInfoVo = new OrderChargeInfoVo ();
		$orderChargeInfoVo->orderId = $orderId;
		$orderChargeInfoVo = $orderChargeInfoDao->selectByKey ( $orderChargeInfoVo );
		return $orderChargeInfoVo;
	}
	public static function getOrderShippingInfoVoByOrderId($orderId) {
		$orderShippingInfoDao = new OrderShipingInfoBaseDao ();
		$orderShippingInfoVo = new OrderShipingInfoVo ();
		$orderShippingInfoVo->orderId = $orderId;
		$orderShippingInfoVo = $orderShippingInfoDao->selectByKey ( $orderShippingInfoVo );
		return $orderShippingInfoVo;
	}
	public static function getProductVoByProductId($productId) {
		$productDao = new ProductBaseDao ();
		$productVo = new ProductVo ();
		$productVo->id = $productId;
		$productVo = $productDao->selectByKey ( $productVo );
		return $productVo;
	}
	public static function updateOrderShippingStatus($orderId, $shippingStatusId) {
		$orderDao = new OrderBaseDao ();
		$orderVo = self::getOrderVoById ( $orderId );
		$orderVo->shippingStatusId = $shippingStatusId;
		$orderVo->paymentMethod = OrderHelper::getPaymentMethodNameById ( $orderVo->paymentMethod );
		$orderVo->shippingMethod = OrderHelper::getShippingMethodNameById ( $orderVo->shippingMethod );
		$orderVo->shippingMethodItem = OrderHelper::getShippingMethodItemNameByBase64 ( $orderVo->shippingMethodItem, $orderVo->shippingMethod );
		ObjectUtil::setCrMd ( $orderVo );
		$orderDao->updateDynamicByKey ( $orderVo );
	}
	public static function insertUpdateOrderShippingInfo(OrderShipingInfoVo $orderShippingInfoVo, $isInsert = false) {
		$orderShippingInfoDao = new OrderShipingInfoBaseDao ();
		ObjectUtil::setCrMd ( $orderShippingInfoVo );
		if ($isInsert) {
			$orderShippingInfoDao->insertDynamicWithId ( $orderShippingInfoVo );
		} else {
			$orderShippingInfoDao->updateDynamicByKey ( $orderShippingInfoVo );
		}
	}
	public static function insertShippingOrderHistory(OrderHistoryVo $orderHistoryVo) {
		$orderHistoryDao = new OrderHistoryBaseDao ();
		switch ($orderHistoryVo->status) {
			case ShippingStatusEnum::FINISHED :
				$orderHistoryVo->status = OrderStatusEnum::PAID;
				break;
			default :
				$orderHistoryVo->status = OrderStatusEnum::PENDING;
				break;
		}
		ObjectUtil::setCrMd ( $orderHistoryVo );
		$orderHistoryDao->insertDynamic ( $orderHistoryVo );
	}
	public static function getPaymentMethodNameById($paymentMethodId) {
		$name = $paymentMethodId;
		if (! empty ( $paymentMethodId )) {
			$paymentMethodDao = new PaymentMethodBaseDao ();
			$paymentMethodVo = new PaymentMethodVo ();
			$paymentMethodVo->id = $paymentMethodId;
			$paymentMethodVo = $paymentMethodDao->selectByKey ( $paymentMethodVo );
			$name = $paymentMethodVo->name;
		}
		return $name;
	}
	public static function getShippingMethodNameById($shippingMethodId) {
		$name = $shippingMethodId;
		if (! empty ( $shippingMethodId )) {
			$shippingMethodDao = new ShippingMethodBaseDao ();
			$shippingMethodVo = new ShippingMethodVo ();
			$shippingMethodVo->id = $shippingMethodId;
			$shippingMethodVo = $shippingMethodDao->selectByKey ( $shippingMethodVo );
			$name = $shippingMethodVo->name;
		}
		return $name;
	}
	public static function getShippingMethodItemNameByBase64($base64Str, $shippingMethodId) {
		$name = $base64Str;
		// if (! empty ( $base64Str ) && JsonUtil::isBase64 ( $base64Str )) {
		$shippingMethodInfo = JsonUtil::base64Decode ( $base64Str );
		$name = StringUtil::loadShippingMethodName ( $shippingMethodInfo, $shippingMethodId );
		// }
		return $name;
	}
	public static function getTotalRefundAmtByOrderId($orderId) {
		$refundAmt = 0;
		$orderRefundDao = new OrderRefundBaseDao ();
		$orderRefundVo = new OrderRefundVo ();
		$orderRefundVo->orderId = $orderId;
		
		$orderRefundVoList = $orderRefundDao->selectByFilter ( $orderRefundVo );
		foreach ( $orderRefundVoList as $orderRefundVo ) {
			$refundAmt += $orderRefundVo->amount;
		}
		return $refundAmt;
	}
	public static function setOrderHistoryDetailMo($action, $paymentMethodId, $txnId, $accNumber) {
		$detailMo = new OrderHistoryDetailMo ();
		$detailMo->action = $action;
		$detailMo->paymentMethodId = $paymentMethodId;
		$detailMo->transactionId = $txnId;
		$detailMo->accountNumber = $accNumber;
		return $detailMo;
	}
	public static function setOrderHistoryDetailMoByArr($arr) {
		return self::setOrderHistoryDetailArr ( $arr ['action'], $arr ['paymentMethodId'], $arr ['transactionId'], $arr ['accountNumber'] );
	}
	// public static function getOrderHistoryVoByOrderId($orderId, $orderStatusId) {
	// $orderHistoryVo = new OrderHistoryVo ();
	// $orderHistDao = new OrderHistoryBaseDao ();
	// $orderHistoryVo->orderId = $orderId;
	// $orderHistoryVo->status = $orderStatusId;
	// $orderHistoryVoList = $orderHistDao->selectByFilter ( $orderHistoryVo );
	// foreach ( $orderHistoryVoList as $orderHistoryVo ) {
	// continue;
	// }
	// return $orderHistoryVo;
	// }
	public static function sendEmailOrderConfirm(CartInfoVo $cartInfoVo) {
		\DatoLogUtil::debug('+ sendEmailOrderConfirm +');
		$disclaimer = Lang::get ( "Payments are processed by Connor-Nolan, Inc., a third party processor. Your credit card statement will reflect Connor-Nolan, Inc as well." );
		$regionVo = ControllerHelper::getRegion ();
		$orderVo = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
		$orderChargeInfo = CartHelper::getOrderChargeInfoVoByInfo ( $cartInfoVo->info );
		$listOrderProduct = CartHelper::getListOrderProductByInfo ( $cartInfoVo->info );
		\DatoLogUtil::debug ( $cartInfoVo );
		\DatoLogUtil::debug ( $orderVo );
		$emailTemplate = new EmailTemplateExtendVo ();
		$emailTemplate->id = "4477";
		$emailTemplate->sendTo = "customer";
		$emailTemplateSv = new EmailTemplateService ();
		$emailTemplates = $emailTemplateSv->getEmailTemplateByFilter ( $emailTemplate );
		
		$emailTemplate = new EmailTemplateExtendVo ();
		$emailTemplate->id = "4476";
		$emailTemplate->sendTo = "admin";
		$adminEmailTemplates = $emailTemplateSv->getEmailTemplateByFilter ( $emailTemplate );
		
		// Get Shipping Name
		$shippingMethodName = "";
		$shippingMethodId = "";
		$shippingMethodInfo = "";
		$shippingMethodVo = new ShippingMethodVo ();
		$shippingMethodSv = new ShippingMethodService ();
		if (isset ( $orderVo->shippingMethod )) {
			$shippingMethodId = $orderVo->shippingMethod;
		}
		$shippingMethodVo->id = $shippingMethodId;
		$shippingMethodVo = $shippingMethodSv->selectBykey ( $shippingMethodVo );
		if (isset ( $shippingMethodVo )) {
			if (isset ( $shippingMethodVo->name )) {
				$shippingMethodName = $shippingMethodVo->name;
			}
		}
		if (isset ( $orderVo->shippingMethodItem )) {
			$shippingMethodInfo = $orderVo->shippingMethodItem;
		}
		
		$orderTotalVo = new OrderTotalVo ();
		$orderTotalVo->orderId = $orderVo->id;
		$orderTotalSv = new OrderTotalBaseDao ();
		$orderTotalVos = $orderTotalSv->selectByFilter ( $orderTotalVo );
		$shippingMethodName = $shippingMethodName . " " . StringUtil::loadShippingMethodName ( $shippingMethodInfo, $shippingMethodId );
		$orderTotal = null;
		if (! is_null ( $orderTotalVos )) {
			foreach ( $orderTotalVos as $orderTotalResult ) {
				if ("shipping" == $orderTotalResult->type) {
					$orderTotal = $orderTotalResult;
				}
			}
		}
		
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
//		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		
		if (! is_null ( $orderTotal )) {
			if (CartHelper::isFreeShipping($orderSurcharges, $listOrderProduct, $orderVo) && "Free Shipping" == $orderTotal->subtitle) {
				$shippingMethodName = "Free Shipping ";
			}
			$shippingMethodName .= '[' . $orderTotal->subtitle . ']';
		}
		// Get Shipping Name
		$paymentMethodName = "";
		$paymentMethodId = "";
		$paymentMethodVo = new PaymentMethodVo ();
		$paymentMethodSv = new PaymentMethodService ();
		if (isset ( $orderVo->paymentMethod )) {
			$paymentMethodId = $orderVo->paymentMethod;
		}
		$paymentMethodVo->id = $paymentMethodId;
		$paymentMethodVo = $paymentMethodSv->selectBykey ( $paymentMethodVo );
		if (isset ( $paymentMethodVo )) {
			if (isset ( $paymentMethodVo->name )) {
				$paymentMethodName = $paymentMethodVo->name;
			}
		}
		
		// Get Shipping Address
		$shippingAddress = "";
		if (isset ( $orderVo->shipAddress )) {
			$shippingAddress = $shippingAddress . $orderVo->shipAddress . "<br/>";
		}
		
		if (isset ( $orderVo->shipZipcode )) {
			$shippingAddress = $shippingAddress . $orderVo->shipZipcode . " ";
		}
		if (isset ( $orderVo->shipStateCode )) {
			$stateSv = new StateService ();
			$stateVo = new StateVo ();
			$stateVo->iso2 = $orderVo->shipStateCode;
			$stateVo->iso2 = AppUtil::isEmptyString ( $stateVo->iso2 ) ? "not avail" : $stateVo->iso2;
			$stateVo->countryIso = $orderVo->shipCountryCode;
			$stateVos = $stateSv->selectByFilter ( $stateVo );
			if (isset ( $stateVos [0] ) && isset ( $stateVos [0]->name )) {
				$shippingAddress = $shippingAddress . $stateVos [0]->name . ", ";
			}
		}
		if (isset ( $orderVo->shipCity )) {
			$shippingAddress = $shippingAddress . $orderVo->shipCity . ", ";
		}
		
		if (isset ( $orderVo->shipCountryCode )) {
			$countrySv = new CountryService ();
			$countryVo = new CountryVo ();
			$countryVo->iso2 = $orderVo->shipCountryCode;
			$countryVos = $countrySv->selectByFilter ( $countryVo );
			if (isset ( $countryVos [0] ) && isset ( $countryVos [0]->name )) {
				$shippingAddress = $shippingAddress . $countryVos [0]->name . ". ";
			}
		}
		
		// Get Payment Address
		$paymentAddress = "";
		if (isset ( $orderVo->shipAddress )) {
			$paymentAddress = $paymentAddress . $orderVo->billAddress . "<br/>";
		}
		
		if (isset ( $orderVo->shipZipcode )) {
			$paymentAddress = $paymentAddress . $orderVo->billZipcode . " ";
		}
		if (isset ( $orderVo->billStateCode )) {
			$stateSv = new StateService ();
			$stateVo = new StateVo ();
			$stateVo->iso2 = $orderVo->billStateCode;
			$stateVo->iso2 = AppUtil::isEmptyString ( $stateVo->iso2 ) ? "not avail" : $stateVo->iso2;
			$stateVo->countryIso = $orderVo->billCountryCode;
			$stateVos = $stateSv->selectByFilter ( $stateVo );
			if (isset ( $stateVos [0] ) && isset ( $stateVos [0]->name )) {
				$paymentAddress = $paymentAddress . $stateVos [0]->name . ", ";
			}
		}
		if (isset ( $orderVo->billCity )) {
			$paymentAddress = $paymentAddress . $orderVo->billCity . ", ";
		}
		
		if (isset ( $orderVo->billCountryCode )) {
			$countrySv = new CountryService ();
			$countryVo = new CountryVo ();
			$countryVo->iso2 = $orderVo->billCountryCode;
			$countryVos = $countrySv->selectByFilter ( $countryVo );
			if (isset ( $countryVos [0] ) && isset ( $countryVos [0]->name )) {
				$paymentAddress = $paymentAddress . $countryVos [0]->name . ".";
			}
		}
		
		// Get Order Product
		$orderProductsHeader = '
			<table border="0" cellspacing="2" cellpadding="2" width="100%">
			   <tbody>
			      <tr>
			         <th style="border-bottom:1px solid #000;" colspan="2" align="left">Product</th>
			         <th style="border-bottom:1px solid #000;" align="left">Quantity</th>
			         <th style="border-bottom:1px solid #000;" align="left">Line Total</th>
			      </tr>';
		$orderProductsContent = '';
		$orderProductsTotal = '
			      <tr>
			         <td colspan="4" style="border-bottom:1px solid #000;">&nbsp;</td>
			      </tr>
			      <tr>
			         <th colspan="3" align="right">Subtotal</th>
			         <td>' . ControllerHelper::showProductPrice ( $orderChargeInfo->subTotalAmount ) . '</td>
			      </tr>';
		if ($orderChargeInfo->discountAmount > 0) {
			$orderProductsTotal = $orderProductsTotal . '
					<tr>
			         <th colspan="3" align="right">Discount Coupon[' . $orderVo->couponCode . ']</th>
			         <td>-' . ControllerHelper::showProductPrice ( $orderChargeInfo->discountAmount ) . '</td>
			      </tr>
				';
		}
		
		if ($orderChargeInfo->shippingAmount > 0) {
			$orderProductsTotal = $orderProductsTotal . '
					<tr>
			         <th colspan="3" align="right">' . $shippingMethodName . '</th>
			         <td>' . ControllerHelper::showProductPrice ( $orderChargeInfo->shippingAmount ) . '</td>
			      </tr>
				';
		}
		if ($orderChargeInfo->taxAmount > 0) {
			$orderProductsTotal = $orderProductsTotal . '
					<tr>
			         <th colspan="3" align="right">VAT</th>
			         <td>' . ControllerHelper::showProductPrice ( $orderChargeInfo->taxAmount ) . '</td>
			      </tr>
				';
		}
		$orderProductsTotal = $orderProductsTotal . '<tr>
			         <th colspan="3" align="right">Grand Total</th>
			         <td>' . ControllerHelper::showProductPrice ( $orderChargeInfo->grandTotalAmount ) . '</td>
			      </tr>';
		$orderProductsFooter = '
			   </tbody>
			</table>
			';
		if (! empty ( $listOrderProduct->getArray () )) {
			foreach ( $listOrderProduct->getArray () as $orderProduct ) {
				$imageMo = DatoImageHelper::getImageInfoById ( json_decode ( $orderProduct->productImage ) [0] );
				$seoUrl = ActionUtil::getFullPathAlias ( "product/detail?id=$orderProduct->productId", new ProductUrlFriendly ( $orderProduct->languageCode, $orderProduct->productId, $orderProduct->seoUrl, $orderProduct->name ) );
				$orderProductsContent = $orderProductsContent . '
				 <tr>
			         <td valign="middle"><a href="' . $seoUrl . '" ><img title="' . $orderProduct->name . '" src="' . DatoImageHelper::getUrl ( $imageMo ) . '" alt="" style="width:auto;height:140px;" /></a></td>
			         <td valign="middle">' . $orderProduct->name . '</td>
			         <td valign="middle">' . $orderProduct->quantity . '</td>
			         <td valign="middle">' . ControllerHelper::showProductPrice ( $orderProduct->price ) . '</td>
			      </tr>
				';
			}
		}
		
		$customerVo = new CustomerVo ();
		$customerSv = new CustomerService ();
		$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$customerVo = $customerSv->selectByKey ( $customerVo );
		
		switch ($paymentMethodVo->id) {
			case PaymentMethodEnum::BANK_TRANSTER :
				break;
			default :
				$paymentMethodName = Lang::get ( "Credit Card" );
				break;
		}
		
		if (isset ( $emailTemplates [0] )) {
			$subject = AppUtil::defaultIfEmpty ( $emailTemplates [0]->subject, Lang::get ( "Endoca: Order Confirmation" ) );
			$subject = Lang::get ( $subject );
			$body = Lang::get ( AppUtil::defaultIfEmpty ( $emailTemplates [0]->body ) );
			$body = str_replace ( '$(firstname)', AppUtil::defaultIfEmpty ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->firstName ), $body );
			$body = str_replace ( '$(order_id)', $cartInfoVo->orderId, $body );
			if (PaymentMethodEnum::BANK_TRANSTER == $paymentMethodId) {
				$body = str_replace ( '$(payment_info)', Lang::get ( SettingHelper::getSettingValue ( "Bank transfer notice" ) ) . "<br/>" . Lang::get ( SettingHelper::getSettingValue ( "Bank transfer info" ) ), $body );
			} else {
				$body = str_replace ( '$(payment_info)', "", $body );
			}
			$body = str_replace ( '$(order_date)', AppUtil::defaultIfEmpty (DateTimeUtil::mySqlStringDate2String($cartInfoVo->crDate, DateTimeUtil::getDateTimeFormat())  ), $body );
			$body = str_replace ( '$(order_subtotal)', AppUtil::defaultIfEmpty ( ControllerHelper::showProductPrice ( $orderChargeInfo->subTotalAmount ) ), $body );
			$body = str_replace ( '$(order_total)', AppUtil::defaultIfEmpty ( ControllerHelper::showProductPrice ( $orderChargeInfo->grandTotalAmount ) ), $body );
			$body = str_replace ( '$(ship_method)', $shippingMethodName, $body );
			$body = str_replace ( '$(ship_address)', $shippingAddress, $body );
			$body = str_replace ( '$(payment_method)', $paymentMethodName, $body );
			$body = str_replace ( '$(bill_address)', $paymentAddress, $body );
			if (ControllerHelper::getRegionId () == RegionEnum::USA) {
				$body = str_replace ( '$(disclaimer)', $disclaimer, $body );
			} else {
				$body = str_replace ( '$(disclaimer)', "", $body );
			}
			
			// Get sending email from billing email address
			$customerEmail = $orderVo->billEmail;
			$body = str_replace ( '$(order_products)', $orderProductsHeader . $orderProductsContent . $orderProductsTotal . $orderProductsFooter, $body );
			EmailUtil::sendMail ( $subject, $body, array (
					$customerEmail 
			), array (), array (), array (), $regionVo->contactEmail );
		}
		
		if (isset ( $adminEmailTemplates [0] )) {
			$orderStatusVo = new OrderStatusVo ();
			$orderStatusSv = new OrderStatusService ();
			$orderStatusVo->id = $orderVo->orderStatusId;
			$orderStatusVo = $orderStatusSv->getOrderStatusByKey ( $orderStatusVo );
			$statusName = "";
			if (isset ( $orderStatusVo )) {
				$statusName = AppUtil::defaultIfEmpty ( $orderStatusVo->name );
			}
			
			$subject = AppUtil::defaultIfEmpty ( $adminEmailTemplates [0]->subject, Lang::get ( "Endoca: New Order #$(order_id) Confirmation" ) );
			$subject = Lang::get ( $subject );
			$subject = str_replace ( '$(order_id)', $cartInfoVo->orderId, $subject );
			$body = Lang::get ( AppUtil::defaultIfEmpty ( $adminEmailTemplates [0]->body ) );
			$body = str_replace ( '$(order_status)', $statusName, $body );
			$body = str_replace ( '$(firstname)', $orderVo->customerFirstname, $body );
			$body = str_replace ( '$(lastname)', $orderVo->customerLastname, $body );
			$body = str_replace ( '$(company)', $orderVo->customerCompany, $body );
			$body = str_replace ( '$(email)', $orderVo->customerEmail, $body );
			$body = str_replace ( '$(phone)', $orderVo->customerPhone, $body );
			$body = str_replace ( '$(order_id)', $cartInfoVo->orderId, $body );
			$body = str_replace ( '$(user_id)', AppUtil::defaultIfEmpty ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->firstName ), $body );
			$body = str_replace ( '$(order_date)', AppUtil::defaultIfEmpty ( $cartInfoVo->crDate ), $body );
			$body = str_replace ( '$(order_subtotal)', AppUtil::defaultIfEmpty ( ControllerHelper::showProductPrice ( $orderChargeInfo->subTotalAmount ) ), $body );
			$body = str_replace ( '$(order_total)', AppUtil::defaultIfEmpty ( ControllerHelper::showProductPrice ( $orderChargeInfo->grandTotalAmount ) ), $body );
			$body = str_replace ( '$(ship_method)', $shippingMethodName, $body );
			$body = str_replace ( '$(ship_address)', $shippingAddress, $body );
			$body = str_replace ( '$(payment_method)', $paymentMethodName, $body );
			$body = str_replace ( '$(bill_address)', $paymentAddress, $body );
			$body = str_replace ( '$(order_products)', $orderProductsHeader . $orderProductsContent . $orderProductsTotal . $orderProductsFooter, $body );
			EmailUtil::sendMail ( $subject, $body, array (
					$regionVo->contactEmail 
			), array (), array (), array (), $regionVo->contactEmail );
		}
		\DatoLogUtil::debug('- sendEmailOrderConfirm -');
	}
	
	public static function buildOrderShippingAddress(AddressVo $shippingAddress) {
		$orderSessionVo = SessionUtil::get ( "order" );
		
		$orderSessionVo->shipFirstName = $shippingAddress->firstName;
		$orderSessionVo->shipLastName = $shippingAddress->lastName;
		$orderSessionVo->shipEmail = $shippingAddress->email;
		$orderSessionVo->shipPhone = $shippingAddress->phone;
		$orderSessionVo->shipAddress = $shippingAddress->address;
		$orderSessionVo->shipCity = $shippingAddress->city;
		$orderSessionVo->shipZipcode = $shippingAddress->postalCode;
		
		$countrySv = new CountryService ();
		$countryVo = new CountryVo ();
		$countryVo->id = $shippingAddress->country;
		$countryVo = $countrySv->selectByKey ( $countryVo );
		
		$stateSv = new StateService ();
		$stateVo = new StateVo ();
		$stateVo->id = $shippingAddress->state;
		$stateVo = $stateSv->selectByKey ( $stateVo );
		$stateCode = "";
		if (! is_null ( $stateVo )) {
			$stateCode = $stateVo->iso2;
		}
		
		$countryCode = "";
		if (! is_null ( $countryVo )) {
			$countryCode = $countryVo->iso2;
		} else {
			return "Please update your country!";
		}
		
		$orderSessionVo->shipStateCode = $stateCode;
		$orderSessionVo->shipCountryCode = $countryCode;
		SessionUtil::set ( "order", $orderSessionVo );
		return "";
	}
	
	public static function buildOrderPaymentAddress(AddressVo $paymentAddress) {
		$orderSessionVo = SessionUtil::get ( "order" );
		
		$orderSessionVo->billFirstName = $paymentAddress->firstName;
		$orderSessionVo->billLastName = $paymentAddress->lastName;
		$orderSessionVo->billEmail = $paymentAddress->email;
		$orderSessionVo->billPhone = $paymentAddress->phone;
		$orderSessionVo->billAddress = $paymentAddress->address;
		$orderSessionVo->billCity = $paymentAddress->city;
		$orderSessionVo->billZipcode = $paymentAddress->postalCode;
		
		$countrySv = new CountryService ();
		$countryVo = new CountryVo ();
		$countryVo->id = $paymentAddress->country;
		$countryVo = $countrySv->selectByKey ( $countryVo );
		
		$stateSv = new StateService ();
		$stateVo = new StateVo ();
		$stateVo->id = $paymentAddress->state;
		$stateVo = $stateSv->selectByKey ( $stateVo );
		$stateCode = "";
		if (! is_null ( $stateVo )) {
			$stateCode = $stateVo->iso2;
		}
		
		$countryCode = "";
		if (! is_null ( $countryVo )) {
			$countryCode = $countryVo->iso2;
		} else {
			return "Please update your country!";
		}
		
		$orderSessionVo->billStateCode = $stateCode;
		$orderSessionVo->billCountryCode = $countryCode;
		SessionUtil::set ( "order", $orderSessionVo );
		return "";
	}
	
	public static function buildShippingAddressFromOrder() {
		$order = SessionUtil::get ( "order" );
		$addressShippingVo = new AddressVo();
		if(ControllerHelper::isGuestLogin() && !AppUtil::isEmptyString($order->shipAddress)){
			$addressShippingVo->firstName = $order->shipFirstName;
			$addressShippingVo->lastName= $order->shipLastName;
			$addressShippingVo->email = $order->shipEmail;
			$addressShippingVo->phone = $order->shipPhone;
			$addressShippingVo->address = $order->shipAddress;
			$addressShippingVo->city = $order->shipCity;
			$addressShippingVo->postalCode = $order->shipZipcode;
			
			$countrySv = new CountryService();
			$countryVo = new CountryVo();
			$countryVo->iso2 = $order->shipCountryCode;
			$countryVos = $countrySv->selectByFilter( $countryVo );
			if(count($countryVos) == 1){
				$countryVo = $countryVos[0];
			}
			$stateSv = new StateService();
			$stateVo = new StateVo();
			$stateVo->iso2 = $order->shipStateCode;
			$stateVos = $stateSv->selectByFilter( $stateVo );
			if (count($stateVos) == 1) {
				$stateVo = $stateVos[0];
			}
			
			$addressShippingVo->state = $stateVo->id;
			$addressShippingVo->country = $countryVo->id;
		}else{
			$addressShippingVo = null;
		}
		return $addressShippingVo;
	}
	
	public static function buildBillingAddressFromOrder() {
		$order = SessionUtil::get ( "order" );
		$addressBillingVo = new AddressVo();
		if(ControllerHelper::isGuestLogin() && !AppUtil::isEmptyString($order->billAddress)){
			$addressBillingVo->firstName = $order->billFirstName;
			$addressBillingVo->lastName= $order->billLastName;
			$addressBillingVo->email = $order->billEmail;
			$addressBillingVo->phone = $order->billPhone;
			$addressBillingVo->address = $order->billAddress;
			$addressBillingVo->city = $order->billCity;
			$addressBillingVo->postalCode = $order->billZipcode;
			
			$countrySv = new CountryService();
			$countryVo = new CountryVo();
			$countryVo->iso2 = $order->billCountryCode;
			$countryVos = $countrySv->selectByFilter( $countryVo );
			if(count($countryVos) == 1){
				$countryVo = $countryVos[0];
			}
			$stateSv = new StateService();
			$stateVo = new StateVo();
			$stateVo->iso2 = $order->billStateCode;
			$stateVos = $stateSv->selectByFilter( $stateVo );
			if (count($stateVos) == 1) {
				$stateVo = $stateVos[0];
			}
			
			$addressBillingVo->state = $stateVo->id;
			$addressBillingVo->country = $countryVo->id;
		}else{
			$addressBillingVo= null;
		}
		return $addressBillingVo;
	}
}