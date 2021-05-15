<?php

namespace frontend\controllers\cart;

use common\config\OrderStatusEnum;
use common\config\PaymentMethodEnum;
use common\helper\LocalizationHelper;
use common\model\PaymentDetailsMo;
use common\model\ResponseMo;
use common\persistence\base\dao\CartInfoBaseDao;
use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\dao\OrderChargeInfoBaseDao;
use common\persistence\base\dao\OrderProductBaseDao;
use common\persistence\base\dao\OrderSurchargeBaseDao;
use common\persistence\base\dao\RegionShippingMethodBaseDao;
use common\persistence\base\dao\TaxShippingZoneBaseDao;
use common\persistence\base\dao\TaxShippingZoneInfoBaseDao;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\CurrencyVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderSurchargeVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\vo\PaymentTxnVo;
use common\persistence\base\vo\PriceLevelVo;
use common\persistence\base\vo\RegionPaymentMethodVo;
use common\persistence\base\vo\RegionShippingMethodVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\ShippingMethodVo;
use common\persistence\base\vo\StateVo;
use common\persistence\base\vo\TaxShippingZoneInfoVo;
use common\persistence\base\vo\TaxShippingZoneVo;
use common\persistence\extend\vo\AddressExtendVo;
use common\persistence\extend\vo\CurrencyExtendVo;
use common\services\address\AddressService;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\services\currency\CurrencyService;
use common\services\customer\CustomerService;
use common\services\order\CartInfoService;
use common\services\order\OrderService;
use common\services\payment\PaymentMethodService;
use common\services\price_level\PriceLevelService;
use common\services\region\RegionService;
use common\services\shipping\ShippingMethodService;
use common\vo\region\shipping_method\zone_table\ZoneTableShippingCostVo;
use core\BaseArray;
use core\Controller;
use core\Lang;
use core\utils\AppUtil;
use core\utils\JsonUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\service\AuthorizeNetHelper;
use frontend\service\CardGateHelper;
use frontend\service\CartHelper;
use frontend\service\EpayHelper;
use frontend\service\OrderHelper;
use frontend\service\PaymentHelper;
use frontend\service\ResponseHelper;
use common\config\RegionEnum;
use common\vo\region\shipping_method\zone_table\ZoneTableSettingVo;
use common\helper\SettingHelper;
use common\persistence\extend\vo\SubscriberExtendVo;
use common\services\subscriber\SubscriberService;
use common\services\email_template\EmailTemplateService;
use common\persistence\base\vo\SubscriberVo;
use core\utils\EmailUtil;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use core\utils\ActionUtil;
use frontend\service\BlockEmailHelper;
use common\persistence\base\vo\EmailTemplateVo;
use common\helper\NetworkHelper;

class CheckoutController extends CartController {
	public $termAndCondition;
	public $subscribe;
	public $subscriber;
	public $listAddress;
	public $address;
	public $listCountry;
	public $listState;
	public $shippingMethods;
	public $order;
	public $orderHistory;
	public $paymentTxn;
	public $shippingAddress;
	public $paymentAddress;
	public $shippingCost;
	public $paymentMethods;
	public $paymentDetails;
	public $addressType;
	public $listAddressSuggest;
	public $symbol;
	public $response;
	public $customerId;

	private $addressSv;
	private $countrySv;
	private $orderSv;
	private $stateSv;
	private $shippingMethodSv;
	private $paymentMethodSv;
	private $subscriberService;
	private $emailTemplateService;
	function __construct() {
		parent::__construct ();
		$this->order = new OrderVo ();
		$this->orderHistory = new OrderHistoryVo ();
		$this->paymentTxn = new PaymentTxnVo ();
		$this->shippingAddress = new AddressVo ();
		$this->paymentAddress = new AddressVo ();
		$this->addressSv = new AddressService ();
		$this->address = new AddressVo ();
		$this->subscriber = new SubscriberVo ();
		$this->response = new ResponseMo ();
		$this->stateSv = new StateService ();
		$this->countrySv = new CountryService ();
		$this->orderSv = new OrderService ();
		$this->shippingMethodSv = new ShippingMethodService ();
		$this->shippingMethods = array ();
		$this->paymentMethodSv = new PaymentMethodService ();
		$this->paymentMethods = array ();
		$this->paymentDetails = new PaymentDetailsMo ();
		$this->subscriberService = new SubscriberService ();
		$this->emailTemplateService = new EmailTemplateService ();
	}
	public function shippingView() {
		$session = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		if (is_null ( $session )) {
			return "redirect";
		}
		if (is_null ( SessionUtil::get ( "order" ) ) || is_null ( SessionUtil::get ( "listOrderProduct" ) ) || count ( SessionUtil::get ( "listOrderProduct" )->getArray () ) == 0) {
			return "redirect";
		}

		if(!$this->isFreeShipping()){
			$orderSessionCheckFree = SessionUtil::get("order");
			$shippingMethodItemFree = JsonUtil::base64Decode($orderSessionCheckFree->shippingMethodItem);
			if(!AppUtil::isEmptyString($shippingMethodItemFree->methodTitle) && "Free Shipping" == $shippingMethodItemFree->methodTitle){
				$orderSessionCheckFree->shippingMethod = "";
				$orderSessionCheckFree->shippingMethodItem = "";
			}
		}

		$this->prepareOrderSession ();
		$this->prepareDataView ();

		if (!ControllerHelper::isGuestLogin()) {
			$this->loadAddressCustomer ();
		} else {
			$this->loadShipAddressGuest ();
		}
		$this->addressType = "shipping";
		$this->loadShippingMethods ();
		$this->setAttribute ( "isFreeShipping", $this->isFreeShipping () );
		$context = new ContextBase ();
		WorkflowManager::Instance ()->execute ( "shopping_cart_update", $context );
		return "success";
	}
	public function shippingAddressView() {
		if (! is_null ( $this->address ) && ! AppUtil::isEmptyString ( $this->address->id )) {
			$customerVo = new CustomerVo ();
			$customerSv = new CustomerService ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			if (! is_null ( $this->addressType ) && "shipping" == $this->addressType) {
				$customerVo->defaultShippingAddressId = $this->address->id;
				$customerSv->updateCustomer ( $customerVo );
			}
		}

		$order = SessionUtil::get ( "order" );
		$order->shippingMethod = null;
		$order->shippingMethodItem = null;
		SessionUtil::set ( "order", $order );
		$this->prepareDataView ();

		if (!ControllerHelper::isGuestLogin()) {
			$this->loadAddressCustomer ();
		} else {
			$this->loadShipAddressGuest ();
		}

		$context = new ContextBase ();
		WorkflowManager::Instance ()->execute ( "shopping_cart_update", $context );
		return "success";
	}
	public function shippingValid() {

		$session = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		if (is_null ( $session )) {
			return "redirect";
		}
		if (is_null ( SessionUtil::get ( "listOrderProduct" ) ) || count ( SessionUtil::get ( "listOrderProduct" )->getArray () ) == 0) {
			return "redirect";
		}
		$this->prepareDataView ();

		if (!ControllerHelper::isGuestLogin()) {
			$this->loadAddressCustomer ();
		} else {
			$this->loadShipAddressGuest ();
		}

		$this->loadShippingMethods ();
		$this->validShippingProceed ();

		$resultValidUS = $this->addressSv->upsAddressValidation ( $this->shippingAddress );
		if (! $resultValidUS ["status"]) {
			$this->addActionError ( $resultValidUS ["errorMessage"] );
			if ("AmbiguousAddressIndicator" === $resultValidUS ["errorCode"]) {
				$this->listAddressSuggest = $resultValidUS ["candidateAddress"];
				$this->address = $this->shippingAddress;
				$this->prepareDataView ();
			}
		}

		if (!AppUtil::isEmptyString($this->address->email) && BlockEmailHelper::checkIsBlockEmail ( $this->shippingAddress->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Your email account has been blocked in our system. Please contact our customer support." ) );
		}

		if ($this->hasErrors ()) {
			return "success";
		}

		if (!ControllerHelper::isGuestLogin()) {
			$errorMessageShip = OrderHelper::buildOrderShippingAddress ( $this->shippingAddress );
		}

		if (! AppUtil::isEmptyString ( $errorMessageShip )) {
			$this->addFieldError ( "shippingAddress[id]", Lang::get ( $errorMessageShip ) );
			$this->addActionError ( Lang::get ( $errorMessageShip ) );
		}

		if (!ControllerHelper::isGuestLogin()) {
			$customerVo = new CustomerVo ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$customerVo->defaultShippingAddressId = $this->shippingAddress->id;
			$customerSv = new CustomerService ();
			$customerSv->updateCustomer ( $customerVo );
		}

		$this->updateCartInfo ();

		return "success";
	}
	public function paymentValid() {
		// prepare data
		$this->prepareDataView ();
		$this->prepareOrder ();
		$this->preparePaymentDetails ();

		if (!ControllerHelper::isGuestLogin()) {
			$this->loadAddressCustomer ();
		} else {
			$this->loadBillAddressGuest ();
		}
		$this->loadPaymentMethods ();
		$resultValidUS = $this->addressSv->upsAddressValidation ( $this->paymentAddress );
		if (! $resultValidUS ["status"]) {
			$this->addActionError ( $resultValidUS ["errorMessage"] );
			if ("AmbiguousAddressIndicator" === $resultValidUS ["errorCode"]) {
				$this->listAddressSuggest = $resultValidUS ["candidateAddress"];
				$this->address = $this->paymentAddress;
				$this->prepareDataView ();
			}
		}
		if (!AppUtil::isEmptyString($this->paymentAddress->email) && BlockEmailHelper::checkIsBlockEmail ( $this->paymentAddress->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Your email account has been blocked in our system. Please contact our customer support." ) );
		}

		if (AppUtil::isEmptyString(SessionUtil::get("order")->shippingMethod) || AppUtil::isEmptyString(SessionUtil::get("order")->shippingMethodItem)) {
			$this->addActionError(Lang::get("Please choose a shipping method to proceed!"));
		}

		if (AppUtil::isEmptyString(SessionUtil::get("order")->shipAddress)) {
			$this->addActionError(Lang::get("Please update shipping address!"));
		}

		if ($this->hasErrors ()) {
			\DatoLogUtil::trace ( '- paymentValid -' );
			return "success";
		}
		if (!ControllerHelper::isGuestLogin()) {

			$this->order->billFirstName = $this->paymentAddress->firstName;
			$this->order->billLastName = $this->paymentAddress->lastName;
			$this->order->billEmail = $this->paymentAddress->email;
			$this->order->billPhone = $this->paymentAddress->phone;
			$this->order->billAddress = $this->paymentAddress->address;
			$this->order->billCity = $this->paymentAddress->city;
			$this->order->billZipcode = $this->paymentAddress->postalCode;
			$countrySv = new CountryService ();
			$countryVo = new CountryVo ();
			$countryVo->id = $this->paymentAddress->country;
			$countryVo = $countrySv->selectByKey ( $countryVo );
			$stateSv = new StateService ();
			$stateVo = new StateVo ();
			$stateVo->id = $this->paymentAddress->state;
			$stateVo = $stateSv->selectByKey ( $stateVo );
			$stateCode = "";
			if (! is_null ( $stateVo )) {
				$stateCode = $stateVo->iso2;
			}

			$countryCode = "";
			if (! is_null ( $countryVo )) {
				$countryCode = $countryVo->iso2;
			} else {
				$this->addFieldError ( "paymentAddress[id]", Lang::get ( "Please update your country!" ) );
				$this->addActionError ( Lang::get ( "Please update your country!" ) );
				\DatoLogUtil::trace ( '- paymentValid -' );
				return "success";
			}

			$this->order->billStateCode = $stateCode;
			$this->order->billCountryCode = $countryCode;
		}
		$this->validPaymentProceed ();
		if ($this->hasErrors ()) {
			\DatoLogUtil::trace ( '- paymentValid -' );
			return "success";
		}
		$this->order->paymentMethodInfo = JsonUtil::encode ( JsonUtil::base64Decode ( $this->order->paymentMethodInfo ) );
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId != 0) {
			$customerVo = new CustomerVo ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$customerVo->defaultBillingAddressId = $this->paymentAddress->id;
			$customerSv = new CustomerService ();
			$customerSv->updateCustomer ( $customerVo );
		}
		$this->updateCartInfo ();
		if (! AppUtil::isEmptyString ( $this->order->id )) {
			$this->order->id = null;
			$this->order->orderStatusId = 1;
		}


		//Insert Order
		$cartInfoVo = $this->cartSv->insertOrder ( $this->order);

		$this->order = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
		$this->response = $this->processPayment ();

		$orderHistoryVo = PaymentHelper::setOrderHistory ( $this->order, $this->response );
		$paymentTxnVo = PaymentHelper::setPaymentTxn ( $this->order, $this->response );
		SessionUtil::set ( 'order', $this->order );
		$this->orderSv->updateOrderStatusByTransaction ( $this->order, $orderHistoryVo, $paymentTxnVo );
		SessionUtil::set ( 'order', $this->order );
		$this->updateCartInfo ();
		// SessionUtil::set ( "cartInfo", $cartInfoVo );
		// $this->order = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
		if (ResponseHelper::isError ( $this->response )) {
			$message = $this->response->status . ': ' . $this->response->msg;
			$this->addActionError ( $message );
			$cartInfoVo = CartHelper::createCartInfoVoFromPrevCart ( $cartInfoVo->sessionId, $this->order->id );
			\DatoLogUtil::trace ( '- paymentValid -' );
			return "success";
		} else {
			SessionUtil::set ( 'responseVo', $this->response );
		}
		if (! ResponseHelper::isError ( $this->response )) {
			switch ($this->order->paymentMethod) {
				case PaymentMethodEnum::CARDGATE :
					$url = $this->response->data->payment->url;
					SessionUtil::set ( 'payment_redirect_url', $url );
					// \DatoLogUtil::trace ( '$url:' . $url );
					// return 'redirect';
					break;
			}
		}
		// Subscriber
		if (! AppUtil::isEmptyString ( $this->subscribe ) && $this->subscribe == "checked"  )  {

			// Check subscriber
			$filter = new SubscriberExtendVo ();
			$filter->email = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userName;
			$result = $this->subscriberService->getByFilter ( $filter );

			if (empty ( $result ) || count ( $result ) == 0 || (count ( $result ) > 0 && $result [0]->status == "inactive")) {
				// Set some initial values.
				if (count ( $result ) > 0 && $result [0]->status == "inactive") { // exist subscriber that inactive
					$this->subscriber = $result [0];
					$this->subscriber->status = "active";
					$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
					$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
					$this->subscriberService->update ( $this->subscriber );
					$this->sendEmailToSubscriber ();
				} else { // new subscriber
					$this->subscriber->firstName = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->firstName;
					$this->subscriber->lastName = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->lastName;
					$this->subscriber->email = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userName;
					$this->subscriber->status = "active";
					$this->subscriber->crDate = date ( 'Y-m-d H:i:s' );
					$this->subscriber->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
					$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
					$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
					// Add to the database.
					$this->subscriberService->add ( $this->subscriber );
					$this->sendEmailToSubscriber ();
				}
			}
		}
		\DatoLogUtil::trace ( '- paymentValid -' );
		return "success";
	}
	public function paymentView() {
		$this->addressType = "payment";
		$session = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		if (is_null ( $session )) {
			return "redirect";
		}
		if (is_null ( SessionUtil::get ( "order" ) ) || is_null ( SessionUtil::get ( "listOrderProduct" ) ) || count ( SessionUtil::get ( "listOrderProduct" )->getArray () ) == 0) {
			return "redirect";
		}

		if(!$this->isFreeShipping()){
			$orderSessionCheckFree = SessionUtil::get("order");
			$shippingMethodItemFree = JsonUtil::base64Decode($orderSessionCheckFree->shippingMethodItem);
			if(!AppUtil::isEmptyString($shippingMethodItemFree->methodTitle) && "Free Shipping" == $shippingMethodItemFree->methodTitle){
				$orderSessionCheckFree->shippingMethod = "";
				$orderSessionCheckFree->shippingMethodItem = "";
				return "back";
			}
		}else{

			$orderSessionCheckFree = SessionUtil::get("order");
			$methodIsShowFree = JsonUtil::base64Decode($orderSessionCheckFree->shippingMethodItem);
			if(!AppUtil::isEmptyString($methodIsShowFree) && $methodIsShowFree->showInFreeShipping == 1 ){
			}else{
				// If has FreeShipping set default Shipping method
				$orderSessionCheckFree->shippingMethod = 1;
				//Base64 FreeShipping Method
				$freeShippingVo = new ZoneTableShippingCostVo ();
				$freeShippingVo->id = 0;
				$freeShippingVo->methodTitle = Lang::get ( "Free Shipping" );
				$freeShippingVo->cost = 0;
				$orderSessionCheckFree->shippingMethodItem = JsonUtil::base64Encode($freeShippingVo);
				SessionUtil::set("order", $orderSessionCheckFree);
			}
		}

		$this->prepareDataView ();
		if ($session->userId != 0) {
			$this->loadAddressCustomer ();
		} else {
			$this->loadBillAddressGuest ();
		}
		$context = new ContextBase ();
		WorkflowManager::Instance ()->execute ( "shopping_cart_update", $context );
		$this->loadTotalPrice ();

		$this->prepareDataView ();
		if ($session->userId != 0) {
			$this->loadAddressCustomer ();
		} else {
			$this->loadBillAddressGuest ();
		}
		$this->loadPaymentMethods ();
		return "success";
	}
	public function paymentAddressView() {
		if (! is_null ( $this->address ) && ! AppUtil::isEmptyString ( $this->address->id )) {
			$customerVo = new CustomerVo ();
			$customerSv = new CustomerService ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			if (! is_null ( $this->addressType ) && "billing" == $this->addressType) {
				$customerVo->defaultBillingAddressId = $this->address->id;
				$customerSv->updateCustomer ( $customerVo );
			}
		}

		$order = SessionUtil::get ( "order" );
		$order->paymentMethod = null;
		SessionUtil::set ( "order", $order );

		$this->prepareDataView ();
		$this->loadAddressCustomer ();
		return "success";
	}
	public function discountCouponAdd() {
		$context = new ContextBase ();
		$context->set ( "discountCode", $this->discountCode );
		$context->set ( "isValidDiscount", true );
		$context->set ( "quantity", $this->productQuantity );
		$context->set ( "product", $this->product );
		$context->set ( "fieldErrors", array () );
		WorkflowManager::Instance ()->execute ( "shopping_cart_update", $context );
		$actionErrors = $context->get ( "actionErrors" );
		$fieldErrors = $context->get ( "fieldErrors" );
		foreach ( $actionErrors as $actionError ) {
			$this->addActionError ( $actionError );
		}
		foreach ( $fieldErrors as $field => $errorMessage ) {
			$this->addFieldError ( $field, $errorMessage [0] );
		}
		return "success";
	}
	public function loadTotalPrice() {
		return "success";
	}
	public function checkoutSuccess() {
		$cartInfoVo = SessionUtil::get ( "cartInfo" );
		if (is_null ( $cartInfoVo )) {
			return "redirect";
		}
		$trxId = RequestUtil::get ( 'transaction' );
		$orderVo = CartHelper::getOrderVoByInfo ( $cartInfoVo->info );
		\DatoLogUtil::trace ( $orderVo );
		$redirectURL = SessionUtil::get ( 'payment_redirect_url' );
		if (is_null ( $orderVo )) {
			return "redirect";
		}
		// Toantq check for order id
		if (AppUtil::isEmptyString ( $orderVo->id )) {
			return "redirect";
		}

		$responseVo = SessionUtil::get ( 'responseVo' );
		$this->order = $orderVo;

		$this->customerId = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId;

		switch ($orderVo->paymentMethod) {
			case PaymentMethodEnum::BANK_TRANSTER :
				if (isset ( $cartInfoVo )) {
					$this->sendEmailOrderConfirm ( $cartInfoVo );
				}
				\DatoLogUtil::trace ( '> BANK_TRANSTER:' );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				CartHelper::clearCartSession ();
				break;
			case PaymentMethodEnum::AUTHORIZE_NET :
				\DatoLogUtil::trace ( '> AUTHORIZE_NET:' );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			case PaymentMethodEnum::CARDGATE :
				\DatoLogUtil::trace ( '> CARDGATE:' );
				if (! empty ( $redirectURL )) {
					$_REQUEST ["payment_process_file"] = "checkout_payment" . DS . "methods" . DS . "cardgate" . DS . "cardgate_payment_redirect.php";
				} else {
					$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				}
				break;
			case PaymentMethodEnum::EPAY :
				\DatoLogUtil::trace ( '> EPAY:' );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			case PaymentMethodEnum::NETWORK_MERCHANTS :
				\DatoLogUtil::trace ( '> NETWORK_MERCHANTS:' );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			default :
				\DatoLogUtil::trace ( '> paymentMethodId:' . $orderVo->paymentMethod );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "not_found_view_response_data.php";
				break;
		}
		if (empty ( $redirectURL )) {
			\DatoLogUtil::trace ( '+ processPaymentComplete ' . $this->order->id . ' responseVo:' . JsonUtil::encode ( $responseVo ) . ' +' );
			PaymentHelper::processPaymentComplete ( $this->order->id, $responseVo );
		}
		return "success";
	}
	public function checkoutTest() {
		$orderDao = new OrderBaseDao ();
		$orderVo = new OrderVo ();
		$orderChargeInfoDao = new OrderChargeInfoBaseDao ();
		$orderChargeInfoVo = new OrderChargeInfoVo ();
		$orderProductDao = new OrderProductBaseDao ();
		$orderProductVo = new OrderProductVo ();
		$cartInfoDao = new CartInfoBaseDao ();
		$cartInfoVo = new CartInfoVo ();
		$orderSurcharge = new OrderSurchargeVo ();
		$orderSurchargeDao = new OrderSurchargeBaseDao ();
		// $orderVo = SessionUtil::get ( "order" );
		$orderId = 7;
		$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $orderId );
		$orderVo = OrderHelper::getOrderVoById ( $orderId );
		OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );

		if (is_null ( $cartInfoVo )) {
			// return "redirect";
		}
		// \DatoLogUtil::trace ( $cartInfoVo );
		$sessionId = $cartInfoVo->sessionId;
		// $decodeObj = JsonUtil::decode ( $cartInfoVo->info );
		// $orderVo = $decodeObj->order;
		$orderChargeInfo = CartHelper::getOrderChargeInfoVoByInfo ( $cartInfoVo->info );
		$tinyAmt = date ( 's' );
		\DatoLogUtil::trace ( 'grandTotalAmount:' . $orderChargeInfo->grandTotalAmount . ' $tinyAmt:' . $tinyAmt );
		$orderChargeInfo->grandTotalAmount = $orderChargeInfo->grandTotalAmount + $tinyAmt;
		$listOrderProduct = CartHelper::getListOrderProductByInfo ( $cartInfoVo->info );
		$this->order = $orderVo;
		$this->order->paymentMethod = PaymentMethodEnum::AUTHORIZE_NET;
		SessionUtil::set ( "order", $orderVo );
		SessionUtil::set ( "orderChargeInfo", $orderChargeInfo );
		SessionUtil::set ( "orderSurcharge", null );
		SessionUtil::set ( "listOrderProduct", $listOrderProduct );
		SessionUtil::set ( "sessionId", $sessionId );
		// CartHelper::clearCartSession ();
		switch ($orderVo->paymentMethod) {
			case PaymentMethodEnum::BANK_TRANSTER :
				\DatoLogUtil::trace ( '> BANK_TRANSTER:' );
				$this->paymentTxn = PaymentHelper::setPaymentTxn ( $this->order, $this->response );
				\DatoLogUtil::trace ( $this->paymentTxn );
				$this->response = ResponseHelper::setSuccess ( $this->response, $this->paymentTxn->remark . '|' . $this->paymentTxn->description );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			case PaymentMethodEnum::AUTHORIZE_NET :
				\DatoLogUtil::trace ( '> AUTHORIZE_NET:' );
				$this->paymentDetails->ccName = 'test card';
				$this->paymentDetails->ccNumber = '4111111111111111';
				$this->paymentDetails->ccType = 'visa';
				$this->paymentDetails->ccYear = '2026';
				$this->paymentDetails->ccMonth = '12';
				$this->paymentDetails->ccCvv = '123';
				$this->response = AuthorizeNetHelper::processPayment ( $this->order, $this->paymentDetails );
				\DatoLogUtil::trace ( $this->response );
				$this->paymentTxn = PaymentHelper::setPaymentTxn ( $this->order, $this->response );
				\DatoLogUtil::trace ( $this->paymentTxn );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			case PaymentMethodEnum::CARDGATE :
				\DatoLogUtil::trace ( '> CARDGATE:' );
				$this->response = CardGateHelper::processPayment ( $this->order, $this->paymentDetails );
				\DatoLogUtil::trace ( $this->response );
				$this->paymentTxn = PaymentHelper::setPaymentTxn ( $this->order, $this->response );
				if ($this->order->paymentMethod == PaymentMethodEnum::CARDGATE && ! ResponseHelper::isError ( $this->response )) {
					$_REQUEST ["payment_redirect_url"] = $response->data->payment->url;

					\DatoLogUtil::trace ( 'redirecting to payment_redirect_url:' . $_REQUEST ["payment_redirect_url"] );
				}
				$_REQUEST ["payment_process_file"] = 'checkout_payment/methods/cardgate/cardgate_payment_redirect.php';

				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			case PaymentMethodEnum::EPAY :
				\DatoLogUtil::trace ( '> EPAY:' );
				$this->response = EpayHelper::processPayment ( $this->order, $this->paymentDetails );
				\DatoLogUtil::trace ( $this->response );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			case PaymentMethodEnum::NETWORK_MERCHANTS :
				\DatoLogUtil::trace ( '> NETWORK_MERCHANTS:' );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "common" . DS . "common_response_data.php";
				break;
			default :
				\DatoLogUtil::trace ( '> paymentMethodId:' . $orderVo->paymentMethod );
				$_REQUEST ["payment_process_file"] = "checkout_response" . DS . "methods" . DS . "not_found_view_response_data.php";
				break;
		}
		if (empty ( $redirectURL )) {
			\DatoLogUtil::trace ( 'start processPaymentComplete ' . $this->order->id . ' respones:' . json_encode ( $this->response ) );
			$this->response = PaymentHelper::processPaymentComplete ( $this->order->id, $this->response );
		}
		if (ResponseHelper::isError ( $this->response )) {
			$this->addActionError ( $this->response->msg );
			return "redirect";
		} else {
			return "success";
		}
	}
	public function updateShippingCost() {
		$filter = new RegionShippingMethodVo ();
		$filter->shippingMethodId = $this->order->shippingMethod;
		$filter->regionId = ControllerHelper::getRegionId ();
		$regionShippingMethodDao = new RegionShippingMethodBaseDao ();
		$regionShippingMethodVos = $regionShippingMethodDao->selectByFilter ( $filter );
		$regionShippingMethodVo = empty ( $regionShippingMethodVos ) ? null : $regionShippingMethodVos [0];
		if (is_null ( $regionShippingMethodVo )) {
			return "success";
		}
		$regionShippingSettingVo = JsonUtil::decode ( $regionShippingMethodVo->settingInfo );
		if ($this->order->shippingMethod == 1) {
			// Is Zone Table
			$zoneTableSettingVo = $regionShippingSettingVo;
			// Lay thong tin thang con.
			$zoneTableShippingCostVo = JsonUtil::base64Decode ( $this->order->shippingMethodItem );

			// Xac dinh gia moi cua thang con.
			$newCost = null;
			$newChildMethod = null;
			foreach ( $zoneTableSettingVo->shippingCosts->getArray () as $shippingCost ) {
				if ($shippingCost->id === $zoneTableShippingCostVo->id) {
					$newCost = $shippingCost->cost;
					$newChildMethod = $shippingCost;
					break;
				}
			}
			if (is_null ( $newCost )) {
				$newCost = 0;
				$newChildMethod = $zoneTableShippingCostVo;
			}
		} else if ($this->order->shippingMethod == 2) {
			// Is Flat Rate
			$flatRateSettingVo = $regionShippingSettingVo;
			// Lay thong tin thang con.
			$flatRateShippingMethodVo = JsonUtil::base64Decode ( $this->order->shippingMethodItem );
			// Xac dinh gia moi cua thang con.
			$newCost = null;
			$newChildMethod = null;
			foreach ( $flatRateSettingVo->shippingMethods->getArray () as $shippingMethod ) {
				if ($shippingMethod->id === $flatRateShippingMethodVo->id) {
					$newCost = $shippingMethod->cost;
					$newChildMethod = $shippingMethod;
					break;
				}
			}
		}
		$order = SessionUtil::get ( "order" );
		$order->shippingMethodItem = JsonUtil::base64Encode ( $newChildMethod );
		$order->shippingMethod = $this->order->shippingMethod;
		$this->shippingCost = $newCost;
		SessionUtil::set ( "order", $order );
		if (! is_null ( JsonUtil::base64Decode ( $this->order->shippingMethodItem ) )) {
			if (! is_null ( JsonUtil::base64Decode ( $this->order->shippingMethodItem )->cost ) && ! AppUtil::isEmptyString ( JsonUtil::base64Decode ( $this->order->shippingMethodItem )->cost )) {
				$this->shippingCost = JsonUtil::base64Decode ( $this->order->shippingMethodItem )->cost;
			}
		}
		$context = new ContextBase ();
		$context->set ( "shippingCost", AppUtil::defaultIfEmpty ( $newCost, null ) );
		WorkflowManager::Instance ()->execute ( "shopping_cart_update", $context );
		$this->shippingView ();
		return "success";
	}
	public function updatePaymentMethod() {
		$order = SessionUtil::get ( "order" );
		$order->paymentMethod = $this->order->paymentMethod;
		SessionUtil::set ( "order", $order );
	}
	private function sendEmailOrderConfirm(CartInfoVo $cartInfoVo) {
		OrderHelper::sendEmailOrderConfirm ( $cartInfoVo );
	}
	private function validShippingProceed() {
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		$orderTotalVos = CartHelper::generateOrderTotalList ( $orderSurcharges, $listOrderProduct, $this->order );
		if (isset ( $orderTotalVos ["shipping"] ) && $orderTotalVos ["shipping"]->title == "Free Shipping") {
			//$this->order->shippingMethod = "Free Shipping";
			//$this->order->shippingMethodItem = "Free Shipping";
			// do nothing no validate for Free Shipping
		} else {

			if (AppUtil::isEmptyString ( $this->order->shippingMethod )) {
				$this->addFieldError ( "order[shippingMethod]", Lang::get ( "Please choose a shipping method to proceed!" ) );
				$this->addActionError ( Lang::get ( "Please choose a shipping method to proceed!" ) );
			} else {
				$shippingMethod = new ShippingMethodVo ();
				$shippingMethod->id = $this->order->shippingMethod;
				$shippingMethod->status = "active";
				$shippingMethodVo = $this->shippingMethodSv->selectBykey ( $shippingMethod );
				if (! isset ( $shippingMethodVo )) {
					$this->addFieldError ( "order[shippingMethod]", Lang::get ( "Shipping method not found or not avaiable!" ) );
					$this->addActionError ( Lang::get ( "Shipping method not found or not avaiable!" ) );
				}
			}
		}

		if (AppUtil::isEmptyString ( SessionUtil::get ( "order" )->shipAddress )) {
			if (is_null ( $this->shippingAddress ) || AppUtil::isEmptyString ( $this->shippingAddress->id )) {

				if(ControllerHelper::isGuestLogin()){
					$this->addFieldError ( "shippingAddress[id]", Lang::get ( "Please input a shipping address to proceed!" ) );
					$this->addActionError ( Lang::get ( "Please input a shipping address to proceed!" ) );
				}else{
					$this->addFieldError ( "shippingAddress[id]", Lang::get ( "Please choose a shipping address to proceed!" ) );
					$this->addActionError ( Lang::get ( "Please choose a shipping address to proceed!" ) );
				}


			} else {
				$address = new AddressVo ();
				$address->id = $this->shippingAddress->id;
				$addressVo = $this->addressSv->selectBykey ( $address );
				if (! isset ( $addressVo )) {
					$this->addFieldError ( "shippingAddress[id]", Lang::get ( "Address not found or not avaiable!" ) );
					$this->addActionError ( Lang::get ( "Address not found or not avaiable!" ) );
				} else {
					$this->shippingAddress = $addressVo;
				}
			}
		}
	}
	private function validPaymentProceed() {
		if (AppUtil::isEmptyString ( $this->order->paymentMethod )) {
			$this->addFieldError ( "order[paymentMethod]", Lang::get ( "Please choose a payment method to proceed!" ) );
			$this->addActionError ( Lang::get ( "Please choose a payment method to proceed!" ) );
		} else {
			$paymentMethod = new PaymentMethodVo ();
			$paymentMethod->id = $this->order->paymentMethod;
			$paymentMethod->status = "active";
			$paymentMethodVo = $this->paymentMethodSv->selectBykey ( $paymentMethod );
			if (! isset ( $paymentMethodVo )) {
				$this->addFieldError ( "order[paymentMethod]", Lang::get ( "Payment method not found or not avaiable!" ) );
				$this->addActionError ( Lang::get ( "Payment method not found or not avaiable!" ) );
			}
		}
		if (AppUtil::isEmptyString ( SessionUtil::get ( "order" )->billAddress )) {
			if (is_null ( $this->paymentAddress ) || AppUtil::isEmptyString ( $this->paymentAddress->id ) && !ControllerHelper::isGuestLogin()) {
				$this->addFieldError ( "paymentAddress[id]", Lang::get ( "Please choose a payment address to proceed!" ) );
				$this->addActionError ( Lang::get ( "Please choose a payment address to proceed!" ) );
			} else {
				$address = new AddressVo ();
				$address->id = $this->paymentAddress->id;
				$addressVo = $this->addressSv->selectBykey ( $address );
				if (! isset ( $addressVo ) ) {
					$this->addFieldError ( "paymentAddress[id]", Lang::get ( "Address not found or not avaiable!" ) );
					$this->addActionError ( Lang::get ( "Address not found or not avaiable!" ) );
				} else {
					$this->paymentAddress = $addressVo;
				}
			}
		}
		// payment validation
		if (! empty ( $this->order->paymentMethod )) {
			$errArr = array ();
			switch ($this->order->paymentMethod) {
				case PaymentMethodEnum::BANK_TRANSTER :
					break;
				case PaymentMethodEnum::AUTHORIZE_NET :
					$errArr = AuthorizeNetHelper::isValid ( $this->paymentDetails );
					break;
				case PaymentMethodEnum::CARDGATE :
					// note: redirect to cardgate page for validation
					// $errArr = CardGateHelper::isValid ( $this->paymentDetails );
					break;
				case PaymentMethodEnum::EPAY :
					$errArr = EpayHelper::isValid ( $this->paymentDetails );
					break;
				case PaymentMethodEnum::NETWORK_MERCHANTS :
					break;
				default :
					break;
			}
			if (! empty ( $errArr )) {
				foreach ( $errArr as $field => $errMsg ) {
					$this->addFieldError ( $field, $errMsg );
					// $this->addActionError ( $errMsg );
				}
			}
		}
		if (AppUtil::isEmptyString ( $this->termAndCondition )) {
			$this->addActionError ( Lang::get ( "Please check Terms and conditions </br>" ) );
		}
		if (isset ( $_REQUEST ["g-recaptcha-response"] ) && $_REQUEST ["g-recaptcha-response"]) {
			$secret = SettingHelper::getSettingValue ( "Secret key" );
			$ip = $_SERVER ["REMOTE_ADDR"];
			$captcha = $_REQUEST ["g-recaptcha-response"];
			$response = file_get_contents ( "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip" );
			$result = json_decode ( $response, TRUE );
		}
		if (empty ( $result ["success"] ) && ControllerHelper::getRegionId () === RegionEnum::USA && ! NetworkHelper::isLocalhost ()) {
			$this->addActionError ( Lang::get ( "Please verify captcha" ) );
		}
	}
	private function processPayment() {
		\DatoLogUtil::trace ( '+ processPayment +' );
		// recalculate for cart total amount before send to payment getway
		// \DatoLogUtil::trace ( $this->order );
		// $this->updateCartInfo ();
		\DatoLogUtil::trace ( $this->order );

		$tObj = new OrderVo ();
		AppUtil::perfectCopyProperties ( $this->order, $tObj );
		$this->order = $tObj;
		$response = new ResponseMo ();
		if (! empty ( $this->order->paymentMethod )) {
			$errArr = array ();
			switch ($this->order->paymentMethod) {
				case PaymentMethodEnum::BANK_TRANSTER :
					$response = ResponseHelper::setSuccess ( $response, 'pending for bank transfer payment.' );
					break;
				case PaymentMethodEnum::AUTHORIZE_NET :
					$response = AuthorizeNetHelper::processPayment ( $this->order, $this->paymentDetails );
					break;
				case PaymentMethodEnum::CARDGATE :
					$response = CardGateHelper::initPayment ( $this->order, $this->paymentDetails );
					break;
				case PaymentMethodEnum::EPAY :
					$response = EpayHelper::processPayment ( $this->order, $this->paymentDetails );
					break;
				case PaymentMethodEnum::NETWORK_MERCHANTS :
					break;
				default :
					break;
			}
		}
		\DatoLogUtil::trace ( '- processPayment -' );
		return $response;
	}
	private function prepareOrder() {
		$order = SessionUtil::get ( "order" );
		$order->paymentMethod = $this->order->paymentMethod;
		$order->customerComment = $this->order->customerComment;
		$this->order = $order;
		SessionUtil::set("order", $order);
	}
	private function preparePaymentDetails() {
		$paymentMethodId = $this->order->paymentMethod;
		if (! empty ( $paymentMethodId )) {
			switch ($paymentMethodId) {
				case PaymentMethodEnum::BANK_TRANSTER :
					break;
				case PaymentMethodEnum::AUTHORIZE_NET :
					$this->paymentDetails->ccName = RequestUtil::get ( 'authorizenet_cc_name' );
					$this->paymentDetails->ccType = RequestUtil::get ( 'authorizenet_cc_type' );
					$this->paymentDetails->ccNumber = RequestUtil::get ( 'authorizenet_cc_number' );
					$this->paymentDetails->ccYear = RequestUtil::get ( 'authorizenet_cc_year' );
					$this->paymentDetails->ccMonth = RequestUtil::get ( 'authorizenet_cc_month' );
					$this->paymentDetails->ccCvv = RequestUtil::get ( 'authorizenet_cc_cvv' );
					break;
				case PaymentMethodEnum::CARDGATE :
					$this->paymentDetails->ccName = RequestUtil::get ( 'cardgate_cc_name' );
					$this->paymentDetails->ccType = RequestUtil::get ( 'cardgate_cc_type' );
					$this->paymentDetails->ccNumber = RequestUtil::get ( 'cardgate_cc_number' );
					$this->paymentDetails->ccYear = RequestUtil::get ( 'cardgate_cc_year' );
					$this->paymentDetails->ccMonth = RequestUtil::get ( 'cardgate_cc_month' );
					$this->paymentDetails->ccCvv = RequestUtil::get ( 'cardgate_cc_cvv' );
					break;
				case PaymentMethodEnum::EPAY :
					$this->paymentDetails->ccName = RequestUtil::get ( 'epay_cc_name' );
					$this->paymentDetails->ccType = RequestUtil::get ( 'epay_cc_type' );
					$this->paymentDetails->ccNumber = RequestUtil::get ( 'epay_cc_number' );
					$this->paymentDetails->ccYear = RequestUtil::get ( 'epay_cc_year' );
					$this->paymentDetails->ccMonth = RequestUtil::get ( 'epay_cc_month' );
					$this->paymentDetails->ccCvv = RequestUtil::get ( 'epay_cc_cvv' );
					break;
				case PaymentMethodEnum::NETWORK_MERCHANTS :
					$this->paymentDetails->ccName = RequestUtil::get ( 'nm_cc_name' );
					$this->paymentDetails->ccType = RequestUtil::get ( 'nm_cc_type' );
					$this->paymentDetails->ccNumber = RequestUtil::get ( 'nm_cc_number' );
					$this->paymentDetails->ccYear = RequestUtil::get ( 'nm_cc_year' );
					$this->paymentDetails->ccMonth = RequestUtil::get ( 'nm_cc_month' );
					$this->paymentDetails->ccCvv = RequestUtil::get ( 'nm_cc_cvv' );
					break;
				default :
					break;
			}
		}
	}
	private function prepareOrderSession() {
		$order = new OrderVo ();
		if (! is_null ( SessionUtil::get ( "order" ) )) {
			$order = SessionUtil::get ( "order" );
		}

		$customerVo = new CustomerVo ();
		$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$customerSv = new CustomerService ();
		$customerVo = $customerSv->selectByKey ( $customerVo );
		if (is_null ( $customerVo )) {
			$customerVo = new CustomerVo ();
		}

		$priceLevelSv = new PriceLevelService ();
		$priceLevelVo = new PriceLevelVo ();
		$priceLevelVo->id = AppUtil::isEmptyString ( $customerVo->priceLevelId ) ? 0 : $customerVo->priceLevelId;
		$priceLevelVo = $priceLevelSv->selectByKey ( $priceLevelVo );

		if (is_null ( $priceLevelVo )) {
			$priceLevelVo = new PriceLevelVo ();
		}

		$order->customerId = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;

		$order->currencyCode = LocalizationHelper::getCurrencyCode ();
		$order->regionId = LocalizationHelper::getRegionId ();
		$order->languageCode = LocalizationHelper::getLangCode ();
		$order->date = date ( "Y-m-d H:i:s" );
		$order->crDate = date ( "Y-m-d H:i:s" );
		$order->crBy = $this->order->customerId;
		$order->mdDate = date ( "Y-m-d H:i:s" );
		$order->mdBy = $this->order->customerId;
		$order->shippingStatusId = 1;
		$order->orderStatusId = OrderStatusEnum::PENDING;

		if (AppUtil::isEmptyString ( $order->customerFirstname )) {
			$order->customerFirstname = $customerVo->firstName;
		}
		if (AppUtil::isEmptyString ( $order->customerLastname )) {
			$order->customerLastname = $customerVo->lastName;
		}
		if (AppUtil::isEmptyString ( $order->customerEmail )) {
			$order->customerEmail = $customerVo->email;
		}

		if (AppUtil::isEmptyString ( $order->customerCompany )) {
			$order->customerCompany = $customerVo->companyName;
		}
		if (AppUtil::isEmptyString ( $order->customerPhone )) {
			$order->customerPhone = $customerVo->phone;
		}

		$order->priceLevel = $priceLevelVo->name;

		$regionSv = new RegionService ();
		$regionVo = new RegionVo ();
		$regionVo = ControllerHelper::getRegion ();
		if (! is_null ( $regionVo )) {
			$order->invoiceComment = $regionVo->invoiceComment;
		}
		SessionUtil::set ( "order", $order );
	}
	private function loadShipAddressGuest() {
		$orderSessionVo = SessionUtil::get ( "order" );
		$this->listAddress = array ();
		$addresVo = new AddressVo ();
		$addresVo->type = 2; // customer
		$addresVo->firstName = 	$orderSessionVo->shipFirstName;
		$addresVo->lastName = 	$orderSessionVo->shipLastName;
		$addresVo->email = 		$orderSessionVo->shipEmail;
		$addresVo->phone = 		$orderSessionVo->shipPhone;
		$addresVo->address = 	$orderSessionVo->shipAddress;
		$addresVo->city = 		$orderSessionVo->shipCity;
		$addresVo->postalCode = $orderSessionVo->shipZipcode;
		$addresVo->state = 		$orderSessionVo->shipStateCode;

		$countryGuestVo = new CountryVo();
		$countryGuestVo->iso2 = $orderSessionVo->shipCountryCode;
		$countryGuestVos = $this->countrySv->selectByFilter($countryGuestVo);
		if(count($countryGuestVos) == 1){
			$countryGuestVo = $countryGuestVos[0];
		}

		$addresVo->country = 	$countryGuestVo->id;

		$addresVo->address = $addresVo->firstName . " " . $addresVo->lastName . " - " . $addresVo->address . " " . $addresVo->postalCode . " " . $addresVo->stateName . " " . $addresVo->city . " " . $countryGuestVo->name . " ";

		$this->shippingAddress = $addresVo;

		if (! AppUtil::isEmptyString ( $addresVo->firstName )) {
			array_push ( $this->listAddress, $addresVo );
		}
	}
	private function loadBillAddressGuest() {
		$orderSessionVo = SessionUtil::get ( "order" );
		$addresVo = new AddressVo ();
		$this->listAddress = array ();
		//Set default Payment address for guest from ship address
		if(AppUtil::isEmptyString($orderSessionVo->billFirstName)){
			$orderSessionVo->billFirstName    = $orderSessionVo->shipFirstName;
			$orderSessionVo->billLastName     = $orderSessionVo->shipLastName;
			$orderSessionVo->billEmail        = $orderSessionVo->shipEmail;
			$orderSessionVo->billPhone        = $orderSessionVo->shipPhone;
			$orderSessionVo->billAddress      = $orderSessionVo->shipAddress;
			$orderSessionVo->billCity         = $orderSessionVo->shipCity;
			$orderSessionVo->billZipcode      = $orderSessionVo->shipZipcode;
			$orderSessionVo->billStateCode    = $orderSessionVo->shipStateCode;
			$orderSessionVo->billCountryCode  = $orderSessionVo->shipCountryCode;
			$orderSessionVo->billCompany 	= $orderSessionVo->shipCompany;
			$orderSessionVo->billCompanyRegCode = $orderSessionVo->billCompanyRegCode;
			$orderSessionVo->billCompanyVat  = $orderSessionVo->billCompanyVat;
			$orderSessionVo->customerCompanyResellerCertNo  = $orderSessionVo->customerCompanyResellerCertNo;
		}
		$addresVo->type = 2; // customer
		$addresVo->firstName = $orderSessionVo->billFirstName;
		$addresVo->lastName = $orderSessionVo->billLastName;
		$addresVo->email = $orderSessionVo->billEmail;
		$addresVo->phone = $orderSessionVo->billPhone;
		$addresVo->address = $orderSessionVo->billAddress;
		$addresVo->city = $orderSessionVo->billCity;
		$addresVo->postalCode = $orderSessionVo->billZipcode;
		$addresVo->state = $orderSessionVo->billStateCode;


		$countryGuestVo = new CountryVo();
		$countryGuestVo->iso2 = $orderSessionVo->billCountryCode;
		$countryGuestVos = $this->countrySv->selectByFilter($countryGuestVo);
		if(count($countryGuestVos) == 1){
			$countryGuestVo = $countryGuestVos[0];
		}

		$addresVo->country = 	$countryGuestVo->id;

		if(AppUtil::isEmptyString($orderSessionVo->billFirstName)){
			$addresVo->address = $orderSessionVo->shipAddress;
		}else{
			$addresVo->address = $addresVo->firstName . " " . $addresVo->lastName . " - " . $addresVo->address . " " . $addresVo->postalCode . " " . $addresVo->stateName . " " . $addresVo->city . " " . $countryGuestVo->name . " ";
		}


		$this->paymentAddress = $addresVo;

		if (! AppUtil::isEmptyString ( $addresVo->firstName )) {
			array_push ( $this->listAddress, $addresVo );
		}

		// Set Info guest is info billing
		$guestInfo = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
		$guestInfo->userName = $addresVo->email;
		$guestInfo->firstName = $addresVo->firstName;
		$guestInfo->lastName = $addresVo->lastName;

		SessionUtil::set(Constants::CUSTOMER_LOGIN_SESSION_NAME, $guestInfo);

		$orderSessionVo->customerId = 0;
		$orderSessionVo->customerFirstname=$addresVo->firstName;
		$orderSessionVo->customerLastname=$addresVo->lastName;
		$orderSessionVo->customerPhone=$addresVo->phone;
		$orderSessionVo->customerEmail=$addresVo->email;

		SessionUtil::set("order", $orderSessionVo);

	}
	private function loadAddressCustomer() {
		$addresVo = new AddressExtendVo ();
		$addresVo->type = 2; // customer
		$addresVo->groupId = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$this->listAddress = $this->addressSv->search ( $addresVo );
		foreach ( $this->listAddress as $address ) {
			$address->address = $address->firstName . " " . $address->lastName . " - " . $address->address . " " . $address->postalCode . " " . $address->stateName . " " . $address->city . " " . $address->countryName . " ";
		}
		$customer = new CustomerVo ();
		$customerSv = new CustomerService ();
		$customer->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		// customer
		$customerVo = $customerSv->selectByKey ( $customer );
		$addressNewVo = new AddressVo ();
		if (AppUtil::isEmptyString ( $this->shippingAddress->id )) {
			$addressNewVo->id = $customerVo->defaultShippingAddressId;
		} else {
			$addressNewVo->id = $this->shippingAddress->id;
		}
		$this->shippingAddress = $this->addressSv->selectByKey ( $addressNewVo );

		if (is_null ( $this->shippingAddress ) && count ( $this->listAddress ) > 0) {
			$this->shippingAddress = $this->listAddress [0];
		}
		$addressNewVo = new AddressVo ();
		if (AppUtil::isEmptyString ( $this->paymentAddress->id )) {
			$addressNewVo->id = $customerVo->defaultBillingAddressId;
		} else {
			$addressNewVo->id = $this->paymentAddress->id;
		}
		$this->paymentAddress = $this->addressSv->selectByKey ( $addressNewVo );
		if (is_null ( $this->paymentAddress ) && count ( $this->listAddress ) > 0) {
			$this->paymentAddress = $this->listAddress [0];
		}

		$this->paymentAddress = is_null ( $this->paymentAddress ) ? new AddressVo () : $this->paymentAddress;
		$this->shippingAddress = is_null ( $this->shippingAddress ) ? new AddressVo () : $this->shippingAddress;

		OrderHelper::buildOrderShippingAddress($this->shippingAddress);
		OrderHelper::buildOrderPaymentAddress($this->paymentAddress);

	}
	private function prepareDataView() {
		$this->listCountry = $this->countrySv->getAll ();
		$state = new StateVo ();
		$state->country = AppUtil::defaultIfEmpty ( $this->address->country, 0 );
		$this->listState = $this->stateSv->selectByFilter ( $state );
	}
	private function loadShippingMethods() {
		$currencyVo = ControllerHelper::getCurrency ();
		$this->symbol = $currencyVo->symbol;

		$regionShippingMethod = new RegionShippingMethodVo ();
		$regionService = new RegionService ();
		$regionShippingMethod->regionId = LocalizationHelper::getRegionId ();
		$regionShippingMethod->status = 'active';
		$listRegionShippingMethod = $regionService->getRegionShippingMethodByFilter ( $regionShippingMethod );

		$listRegionShipping = array ();

		foreach ( $listRegionShippingMethod as $shippingMethod ) {
			$shippingMethodVo = new ShippingMethodVo ();
			$shippingInfo = JsonUtil::decode ( $shippingMethod->settingInfo );
			$shippingMethodVo->id = $shippingMethod->shippingMethodId;
			$shippingMethodVo = $this->shippingMethodSv->selectBykey ( $shippingMethodVo );
			if (false != $shippingInfo) {
				$shippingMethodVo->description = $shippingInfo;
			} else {
				$shippingMethodVo->description = null;
			}
			// fix detect for no shipping
			if ($this->isShowRegionShippingMethod ( $this->shippingAddress, $shippingMethodVo )) {
				if ($shippingMethodVo->id === 1 && count ( $shippingMethodVo->description->shippingCosts->getArray () ) > 0) {
					array_push ( $listRegionShipping, $shippingMethodVo );
				}
				if ($shippingMethodVo->id === 2 && count ( $shippingMethodVo->description->shippingMethods->getArray () ) > 0) {
					array_push ( $listRegionShipping, $shippingMethodVo );
				}
			}
		}

		if ($this->isFreeShipping () ) {
			foreach ( $listRegionShipping as $shippingMethodVo ) {
				if ($shippingMethodVo->id === 1 && count ( $shippingMethodVo->description->shippingCosts->getArray () ) > 0) {
					$newShippingCosts = new BaseArray ( ZoneTableShippingCostVo::class );

					foreach ( $shippingMethodVo->description->shippingCosts->getArray () as $shippingCostVo ) {
						if ($shippingCostVo->showInFreeShipping == 0 ) {
							$shippingMethodVo->description->shippingCosts->remove ( $shippingCostVo );
						}
					}

					// Create free shipping.
					$freeShippingVo = new ZoneTableShippingCostVo ();
					$freeShippingVo->id = 0;
					$freeShippingVo->methodTitle = Lang::get ( "Free Shipping" );
					$freeShippingVo->cost = 0;
					// $shippingMethodVo->description->shippingCosts->add($freeShippingVo);
					$newShippingCosts->add ( $freeShippingVo );
					foreach ( $shippingMethodVo->description->shippingCosts->getArray () as $shippingCostVo ) {
						$newShippingCosts->add ( $shippingCostVo );
					}
					$shippingMethodVo->description->shippingCosts = $newShippingCosts;
				}
			}
		}
		$this->shippingMethods = $listRegionShipping;
	}
	private function isFreeShipping() {
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		if (CartHelper::isFreeShipping ( $orderSurcharges, $listOrderProduct, $this->order )) {
			return true;
		}
		return false;
	}
	private function isShowRegionShippingMethod(AddressVo $shippingAddress = null, ShippingMethodVo &$regionShippingMethodVo = null) {
		if ($shippingAddress == null) {
			$shippingAddress = OrderHelper::buildShippingAddressFromOrder ();
		}
		if (is_null ( $regionShippingMethodVo )) {
			return false;
		}
		// Check type of region shipping method.
		if (1 !== $regionShippingMethodVo->id || "active" !== $regionShippingMethodVo->status) {
			return true;
		}
		$settingVo = $regionShippingMethodVo->description;
		if (is_null ( $settingVo )) {
			return false;
		}
		$shippingCosts = $settingVo->shippingCosts;
		if (is_null ( $shippingCosts ) || empty ( $shippingCosts->getArray () )) {
			return false;
		}
		$taxShippingZoneDao = new TaxShippingZoneBaseDao ();
		$taxShippingZoneInfoDao = new TaxShippingZoneInfoBaseDao ();
		$shippingCostArray = new BaseArray ( ZoneTableShippingCostVo::class );
		foreach ( $shippingCosts->getArray () as $shippingCost ) {
			// Get tax shipping zone.
			$filter = new TaxShippingZoneVo ();
			$filter->id = $shippingCost->zone;
			$taxShippingZoneVo = $taxShippingZoneDao->selectByKey ( $filter );
			if (is_null ( $taxShippingZoneVo )) {
				continue;
			}
			// Get tax shipping zone infos.
			$filter = new TaxShippingZoneInfoVo ();
			$filter->taxShippingZoneId = $taxShippingZoneVo->id;
			$taxShippingZoneInfos = $taxShippingZoneInfoDao->selectByFilter ( $filter );
			if (empty ( $taxShippingZoneInfos )) {
				$shippingCostArray->add ( $shippingCost );
				continue;
			}

			$hasMatch = false;
			foreach ( $taxShippingZoneInfos as $taxShippingZoneInfoVo ) {
				$match = $taxShippingZoneInfoVo->countryId === $shippingAddress->country;
				$match = empty ( $taxShippingZoneInfoVo->stateId ) ? $match : $match && $taxShippingZoneInfoVo->stateId === $shippingAddress->state;
				if ($match) {
					$hasMatch = true;
					break;
				}
			}
			if ($hasMatch && "no" === $taxShippingZoneVo->exclusive) {
				$shippingCostArray->add ( $shippingCost );
			}
			if (! $hasMatch && "yes" === $taxShippingZoneVo->exclusive) {
				$shippingCostArray->add ( $shippingCost );
			}
		}
		$settingVo->shippingCosts = $shippingCostArray;

		if(count ( $shippingCostArray->getArray() ) > 0){
			return true;
		}else{
			return false;
		}
	}
	private function loadPaymentMethods() {
		$regionPaymentMethod = new RegionPaymentMethodVo ();
		$regionService = new RegionService ();
		$regionPaymentMethod->regionId = LocalizationHelper::getRegionId ();
		$regionPaymentMethod->status = 'active';
		$listRegionPaymentMethod = $regionService->getRegionPaymentMethodByFilter ( $regionPaymentMethod );
		$listRegionPayment = array ();

		foreach ( $listRegionPaymentMethod as $paymentMethod ) {
			$paymentMethodVo = new PaymentMethodVo ();
			$paymentInfo = JsonUtil::decode ( $paymentMethod->settingInfo );
			$paymentMethodVo->id = $paymentMethod->paymentMethodId;
			$paymentMethodVo = $this->paymentMethodSv->selectBykey ( $paymentMethodVo );
			if (false != $paymentInfo) {
				$paymentMethodVo->description = $paymentInfo;
			} else {
				$paymentMethodVo->description = null;
			}
			switch ($paymentMethodVo->id) {
				case PaymentMethodEnum::BANK_TRANSTER :
					break;
				default :
					$paymentMethodVo->name = Lang::get ( "Credit Card" );
					break;
			}
			if ("active" == $paymentMethodVo->status) {
				array_push ( $listRegionPayment, $paymentMethodVo );
			}
		}
		$currencySv = new CurrencyService ();
		$currencyVo = new CurrencyExtendVo ();
		$currencyVo->code = LocalizationHelper::getCurrencyCode ();
		$currencyVos = $currencySv->getByFilter ( $currencyVo );
		if (! is_null ( $currencyVos ) && ! is_null ( $currencyVos [0] )) {
			$currencyVo = $currencyVos [0];
		} else {
			$this->symbol = "$";
		}
		$this->symbol = $currencyVo->symbol;
		$this->paymentMethods = $listRegionPayment;
	}
	private function updateCartInfo() {
		$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
		$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
		$orderVo = SessionUtil::get ( "order" );
		$orderTotalVos = CartHelper::generateOrderTotalList ( $orderSurcharges, $listOrderProduct, $orderVo );
		// recaculate for "orderChargeInfo" match order total

		$orderChargeInfo = new OrderChargeInfoVo ();
		$orderChargeInfo->orderId = $orderVo->id;
		$orderChargeInfo->subTotalAmount = $orderTotalVos ["subtotal"]->value;

		if (isset ( $orderTotalVos ["shipping"] )) {
			$orderChargeInfo->shippingAmount = $orderTotalVos ["shipping"]->value;
		} else {
			$orderChargeInfo->shippingAmount = 0;
		}

		if (isset ( $orderTotalVos ["taxtotal"] )) {
			$orderChargeInfo->taxAmount = $orderTotalVos ["taxtotal"]->value;
		} else {
			$orderChargeInfo->taxAmount = 0;
		}

		if (isset ( $orderTotalVos ["coupon"] )) {
			$orderChargeInfo->discountAmount = $orderTotalVos ["coupon"]->value;
		} else {
			$orderChargeInfo->discountAmount = 0;
		}

		$orderChargeInfo->grandTotalAmount = $orderTotalVos ["total"]->value;

		$infoArray = array (
			"orderChargeInfo" => $orderChargeInfo,
			"orderSurcharges" => $orderSurcharges,
			"listOrderProduct" => $listOrderProduct,
			"order" => $orderVo
		);
		// SessionUtil::set ( "order", $orderVo );
		SessionUtil::set ( "orderChargeInfo", $orderChargeInfo );
		$sessionId = SessionUtil::get ( "sessionId" );
		$cartInfoVo = CartHelper::getCartInfoVoBySessionId ( $sessionId, $orderVo->id );
		$cartInfoSv = new CartInfoService ();
		if (! empty ( $cartInfoVo ) && ! empty ( $cartInfoVo->id )) {
			$cartInfoVo->info = JsonUtil::encode ( $infoArray );
			\DatoLogUtil::trace ( $cartInfoVo );
			$cartInfoSv->updateCartInfo ( $cartInfoVo );
			SessionUtil::set ( 'cartInfo', $cartInfoVo );
		}
	}
	protected function sendEmailToSubscriber() {
		// get email template by language
		$emailTemplateLangVo = new EmailTemplateLangExtendVo ();
		$emailTemplateLangVo->emailTemplateId = 4551;
		$emailTemplateLangVo->languageCode = ControllerHelper::getLangCode ();
		$emailTemplate = $this->emailTemplateService->getEmailTemplateLangById ( $emailTemplateLangVo );
		if (count ( $emailTemplate ) == 0 || (count ( $emailTemplate ) > 0) && AppUtil::isEmptyString ( $emailTemplate->body )) {
			$emailTemplateVo = new EmailTemplateVo ();
			$emailTemplateVo->id = 4551;
			$emailTemplate = $this->emailTemplateService->getEmailTemplateByKey ( $emailTemplateVo );
		}
		// prepare data for template
		$fromName = "";
		$fromAddress = ControllerHelper::getRegion ()->contactEmail;
		if (! AppUtil::isEmptyString ( $emailTemplate->from )) {
			$fromAddress = $emailTemplate->from;
		}

		$toEmail = array ();
		if (! AppUtil::isEmptyString ( $this->subscriber->email )) {
			$toEmail = array (
				$this->subscriber->email
			);
		}

		$cc = array ();
		if (! AppUtil::isEmptyString ( $emailTemplate->cc )) {
			$cc = explode ( ",", $emailTemplate->cc );
		}

		$bcc = array ();
		if (! AppUtil::isEmptyString ( $emailTemplate->bcc )) {
			$bcc = explode ( ",", $emailTemplate->bcc );
		}

		$subject = $emailTemplate->subject;

		$bodyTemplate = $emailTemplate->body;

		$fullPath = ActionUtil::getFullPathAlias ( "home/subscriber/unsubscribe" );

		$body = str_replace ( [
			"$(firstname)",
			"$(fullPath)",
			"$(unsubscribe)"
		], [
			$this->subscriber->firstName,
			$fullPath,
			md5 ( $this->subscriber->email )
		], $bodyTemplate );

		$attachment = array ();
		// send email
		if (count ( $toEmail ) > 0) {
			EmailUtil::sendMail ( $subject, $body, $toEmail, $cc, $bcc, $attachment, $fromAddress, $fromName );
		}
	}
}