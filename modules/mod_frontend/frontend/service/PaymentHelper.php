<?php

namespace frontend\service;

use common\config\OrderHistoryActionEnum;
use common\config\OrderStatusEnum;
use common\config\PaymentMethodEnum;
use common\model\ResponseMo;
use common\persistence\base\dao\OrderHistoryBaseDao;
use common\persistence\base\dao\PaymentTxnBaseDao;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderRefundVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentTxnVo;
use common\utils\DateUtil;
use common\utils\ObjectUtil;
use core\utils\JsonUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;

class PaymentHelper {
	public static function setOrderHistory(OrderVo $order, ResponseMo $response) {
		$cartInfoVo = new CartInfoVo ();
		$sessionId = SessionUtil::get ( "sessionId" );
		$cartInfoVo = CartHelper::getCartInfoVoBySessionId ( $sessionId, $order->id );
		
		$orderHistoryVo = new OrderHistoryVo ();
		// $orderHistoryVo->$id;
		$orderHistoryVo->orderId = $order->id;
		$orderHistoryVo->status = $order->orderStatusId;
		$orderHistoryVo->cusNotified = 'no';
		if (! is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) )) {
			$orderHistoryVo->crBy = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		} else {
			$orderHistoryVo->crBy = 0;
		}
		$orderHistoryVo->crDate = DateUtil::getCurrentDT ();
		// $arr = array (
		// // 'sessionId' => SessionUtil::get ( "sessionId" ),
		// 'cartInfoId' => $cartInfoVo->id,
		// 'orderId' => $order->id,
		// 'orderStatusId' => $order->orderStatusId,
		// 'orderStatus' => OrderHelper::getOrderStatusById ( $order->orderStatusId ),
		// 'responseStatus' => $response->status,
		// 'responseMsg' => $response->msg,
		// 'responseData' => $response->data
		// );
		
		// $orderHistoryVo->description = json_encode ( $arr );
		$description = "";
		$description = 'cartInfoId :' . $cartInfoVo->id . "\n";
		$description .= 'orderId:' . $order->id . "\n";
		$description .= 'orderStatusId:' . $order->orderStatusId . "\n";
		$description .= 'orderStatus:' . OrderHelper::getOrderStatusById ( $order->orderStatusId ) . "\n";
		$description .= 'responseStatus:' . $response->status . "\n";
		$description .= 'responseMsg:' . $response->msg . "\n";
		// $description .= 'responseData:' . JsonUtil::encode ( $response->data );
		$description .= 'ResponseCode:' . $response->data->code . "\n";
		$description .= 'Transaction ID:' . $response->data->txnId . "\n";
		$description .= 'Auth Code:' . $response->data->authCode . "\n";
		$description .= 'orderInfo:' . $response->data->orderInfo . "\n";
		$orderHistoryVo->description = $description;
		if (! empty ( $response->data->detailMo ))
			$orderHistoryVo->detail = JsonUtil::encode ( $response->data->detailMo );
		else
			$orderHistoryVo->detail = JsonUtil::encode ( $response );
		return $orderHistoryVo;
	}
	public static function setPaymentTxn(OrderVo $order, ResponseMo $response) {
		$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $order->id );
		$paymentTxnVo = self::getPaymentTxnVoById ( $cartInfoVo->id );
		if (empty ( $paymentTxnVo ))
			$paymentTxnVo = new PaymentTxnVo ();
		$orderChargeInfoVo = CartHelper::getOrderChargeInfoVoByInfo ( $cartInfoVo->info );
		\DatoLogUtil::trace ( $orderChargeInfoVo );
		switch ($order->paymentMethod) {
			case PaymentMethodEnum::BANK_TRANSTER :
				$paymentTxnVo->cartInfoId = $cartInfoVo->id;
				$paymentTxnVo->orderId = $order->id;
				$paymentTxnVo->status = $order->orderStatusId;
				$paymentTxnVo->paymentMethodId = $order->paymentMethod;
				$paymentTxnVo->amount = $orderChargeInfoVo->grandTotalAmount;
				if (! empty ( $response->data )) {
					if (isset ( $response->data->txnId ))
						$paymentTxnVo->txnId .= $response->data->txnId;
					if (isset ( $response->data->remark ))
						$paymentTxnVo->remark .= $response->data->remark;
					if (isset ( $response->data->description ))
						$paymentTxnVo->description .= $response->data->description;
				}
				ObjectUtil::setCrMd ( $paymentTxnVo );
				break;
			case PaymentMethodEnum::AUTHORIZE_NET :
				\DatoLogUtil::trace ( $response );
				$paymentTxnVo->cartInfoId = $cartInfoVo->id;
				$paymentTxnVo->orderId = $order->id;
				$paymentTxnVo->status = $order->orderStatusId;
				$paymentTxnVo->paymentMethodId = $order->paymentMethod;
				$paymentTxnVo->amount = $orderChargeInfoVo->grandTotalAmount;
				if (! empty ( $response->data )) {
					if (isset ( $response->data->txnId ))
						$paymentTxnVo->txnId = $response->data->txnId;
					if (isset ( $response->data->remark ))
						$paymentTxnVo->remark = $response->data->remark;
					if (isset ( $response->data->description ))
						$paymentTxnVo->description = $response->data->description;
				}
				ObjectUtil::setCrMd ( $paymentTxnVo );
				break;
			case PaymentMethodEnum::CARDGATE :
				\DatoLogUtil::trace ( $response );
				$paymentTxnVo->cartInfoId = $cartInfoVo->id;
				$paymentTxnVo->orderId = $order->id;
				$paymentTxnVo->status = $order->orderStatusId;
				$paymentTxnVo->paymentMethodId = $order->paymentMethod;
				$paymentTxnVo->amount = $orderChargeInfoVo->grandTotalAmount;
				if (! empty ( $response->data )) {
					if (isset ( $response->data->txnId ))
						$paymentTxnVo->txnId = $response->data->txnId;
					if (isset ( $response->data->remark ))
						$paymentTxnVo->remark = $response->data->remark;
					if (isset ( $response->data->description ))
						$paymentTxnVo->description = $response->data->description;
				}
				ObjectUtil::setCrMd ( $paymentTxnVo );
				break;
			case PaymentMethodEnum::EPAY :
				if (! empty ( $response->data )) {
					if (isset ( $response->data->txnId ))
						$paymentTxnVo->txnId = $response->data->txnId;
					if (isset ( $response->data->remark ))
						$paymentTxnVo->remark = $response->data->remark;
					if (isset ( $response->data->description ))
						$paymentTxnVo->description = $response->data->description;
				}
				break;
			default :
				break;
		}
		return $paymentTxnVo;
	}
	public static function getOrderHistoryVoByOrderId($orderId) {
		if (empty ( $orderId ))
			\DatoLogUtil::warn ( 'order id is empty' );
		$orderHistoryVo = new OrderHistoryVo ();
		$orderHistoryDao = new OrderHistoryBaseDao ();
		$orderHistoryVo->orderId = $orderId;
		$orderHistoryVo->status = OrderStatusEnum::PAID;
		$orderHistoryVoList = $orderHistoryDao->selectByFilter ( $orderHistoryVo );
		$ohVo = null;
		\DatoLogUtil::debug ( $orderHistoryVo );
		foreach ( $orderHistoryVoList as $orderHistoryVo ) {
			$orderHistoryVo->detail = JsonUtil::decode ( $orderHistoryVo->detail );
			\DatoLogUtil::debug ( $orderHistoryVo->detail );
			if ($orderHistoryVo->detail->action == OrderHistoryActionEnum::PAYMENT) {
				$ohVo = $orderHistoryVo;
				break;
			}
		}
		return $ohVo;
	}
	public static function getPaymentTxnVoById($cartId) {
		$paymentTxnVo = new PaymentTxnVo ();
		$paymentTxnDao = new PaymentTxnBaseDao ();
		$paymentTxnVo->cartInfoId = $cartId;
		$paymentTxnVo = $paymentTxnDao->selectByKey ( $paymentTxnVo );
		return $paymentTxnVo;
	}
	public static function setOrderRefund($orderId, $orderHistoryId, $refundAmt) {
		$orderRefundVo = new OrderRefundVo ();
		$orderRefundVo->orderId = $orderId;
		$orderRefundVo->orderHistoryId = $orderHistoryId;
		$orderRefundVo->amount = $refundAmt;
		if (! is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) )) {
			$orderRefundVo->crBy = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		} else {
			$orderRefundVo->crBy = 0;
		}
		$orderRefundVo->crDate = DateUtil::getCurrentDT ();
		return $orderRefundVo;
	}
	public static function processPaymentComplete($orderId, ResponseMo $responseVo) {
		\DatoLogUtil::debug ( '+ processPaymentComplete +' );
		$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $orderId );
		$info = $cartInfoVo->info;
		$orderVo = CartHelper::getOrderVoByInfo ( $info );
		\DatoLogUtil::debug ( '$responseVo:' . JsonUtil::encode ( $responseVo ) . ' orderId:' . $orderId . ' shipCountryCode:' . $orderVo->shipCountryCode );
		\DatoLogUtil::debug ( '-1-' );
		\DatoLogUtil::debug ( $orderVo );
		if (! ResponseHelper::isError ( $responseVo )) {
			CartHelper::clearCartSession ();
			switch ($orderVo->paymentMethod) {
				case PaymentMethodEnum::BANK_TRANSTER :
					\DatoLogUtil::debug ( '> BANK_TRANSTER' );
					break;
				case PaymentMethodEnum::AUTHORIZE_NET :
					\DatoLogUtil::debug ( '> AUTHORIZE_NET' );
					if (! ResponseHelper::isError ( $responseVo )) {
						if ($orderVo->orderStatusId == OrderStatusEnum::PAID) {
							OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
						}
					}
					break;
				case PaymentMethodEnum::NETWORK_MERCHANTS :
					\DatoLogUtil::debug ( '> NETWORK_MERCHANTS' );
					if (! ResponseHelper::isError ( $responseVo )) {
						if ($orderVo->orderStatusId == OrderStatusEnum::PAID) {
							OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
						}
					}
					break;
				case PaymentMethodEnum::CARDGATE :
					\DatoLogUtil::debug ( '> CARDGATE' );
					if (! ResponseHelper::isError ( $responseVo )) {
						if ($orderVo->orderStatusId == OrderStatusEnum::PAID) {
							OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
						}
					}
					break;
				case PaymentMethodEnum::EPAY :
					\DatoLogUtil::debug ( '> EPAY' );
					if (! ResponseHelper::isError ( $responseVo )) {
						if ($orderVo->orderStatusId == OrderStatusEnum::PAID) {
							OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
						}
					}
					break;
				default :
					\DatoLogUtil::debug ( '> default:' . $orderVo->paymentMethod );
					break;
			}
			\DatoLogUtil::debug ( 'orderId:' . $orderVo->id . ' statusId:' . $orderVo->orderStatusId . ' shipCountryCode:' . $orderVo->shipCountryCode );
			if (! ResponseHelper::isError ( $responseVo ) && $orderVo->shipCountryCode == 'US') {
				if (! empty ( $orderVo )) {
					if ($orderVo->orderStatusId == OrderStatusEnum::PAID) {
						ShipRushHelper::sendShiprushOrder ( $orderVo->id );
					}
				} else {
					$errMsg = 'OrderId is empty';
					\DatoLogUtil::error ();
					$responseVo = ResponseHelper::setError ( $responseVo, $errMsg );
				}
			}
		}
		
		\DatoLogUtil::debug ( '- processPaymentComplete -' );
		return $responseVo;
	}
}