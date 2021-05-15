<?php

namespace frontend\controllers\customer;

use common\helper\EmailHelper;
use common\model\ProductCartContentMo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\PriceLevelVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\OrderExtendVo;
use common\persistence\extend\vo\ProductHomeExtendVo;
use common\services\customer\CustomerService;
use common\services\order\OrderService;
use common\services\price_level\PriceLevelService;
use common\services\product\ProductHomeService;
use common\services\region\RegionService;
use common\utils\DateUtil;
use common\utils\StringUtil;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;
use frontend\common\Constants;
use frontend\controllers\FrontendController;


class CustomerSalesRepController extends FrontendController {
	private $orderService;
	private $productService;

	public $ordersCustomer;
	public $customerService;
	public $order;
	public $orderId;
	public $regionId;
	public $salesRepList;
	public $saleRepId;
	public $saleRep;
	public $cPassword;
	public $priceLevels;
	public $fromEmail;
	public $fromCustomerName;
	public $subject;
	public $message;
	public $orderHistories;
	public $productName;
	public $products;
	public $customers;
	
	public $productId;
	public $productPrice;
	public $productQuantity;
	public $customerId;
	public $cartContents;
	public $index;
	
	public function __construct() {
		parent::__construct ();
		$this->filter = new CustomerVo ();
		$this->orderService = new OrderService ();
		$this->productService = new ProductHomeService ();
		$this->customerService = new CustomerService ();
		$this->saleRep = new CustomerVo ();

		$this->cartContents = new BaseArray(ProductCartContentMo::class);
	}
	
	public function listSalesReps() {
		$this->getSalesRepList ();
		return "success";
	}
	public function editView() {
		$this->getSalesRep ();
		$this->prepareDataView ();
		return "success";
	}
	public function edit() {
		$this->prepareDataView ();
		$this->validSaleRep ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		if (! AppUtil::isEmptyString ( $this->saleRep->password )) {
			$encryptType = ApplicationConfig::get ( "encryption.type.default" );
			if (! AppUtil::isEmptyString ( $encryptType )) {
				$this->saleRep->password = "{" . $encryptType . "}" . $encryptType ( $this->saleRep->password );
			}
		} else {
			$this->saleRep->password = null;
		}
		$this->customerService->updateCustomer ( $this->saleRep );
		return "success";
	}
	public function addView() {
		$this->prepareDataView ();
		return "success";
	}
	public function add() {
		$this->prepareDataView ();
		$this->validSaleRep ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->prepareData ();
		$this->customerService->createCustomer ( $this->saleRep );
		return "success";
	}
	public function salesRep() {
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) != null) {
			$this->getOrdersCustomer ();
			
			$customerVo = new CustomerVo();
			$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
			if($loginCustomerInfo->isSaleRepChild){
				$customerVo->saleRepId = $loginCustomerInfo->saleRepId;
			}else{
				$customerVo->saleRepId = $loginCustomerInfo->userId;
			}
			$this->customers = $this->customerService->selectByFilter($customerVo);
			
			$productExtendVo = new ProductHomeExtendVo();
			$productExtendVo->status = 'active';
			$productExtendVo->languageCode = $this->languageCode;
			$productExtendVo->regionId = $this->regionId;
			$productExtendVo->currencyCode= $this->currencyCode;
			$this->products = $this->productService->getProductHomeByFilter($productExtendVo);
		}else{
			return "login";
		}
		return "success";
	}
	public function listOrders() {
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME  ) != null) {
			$this->getOrdersCustomer ();
		}
		return "success";
	}
	public function detailOrder() {
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$this->order = $this->orderService->getOrdersCustomerByKeySalesRep ( $orderVo );
		return "success";
	}
	
	public function detailOrderSalesRep(){
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$this->order = $this->orderService->getOrderByKey($orderVo);
		return "success";
	}
	public function listOrderHistory() {
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$this->orderHistories = $this->orderService->getOrderHistorysByOrder ( $orderVo );
		return "success";
	}
	public function sendMessageOrderView(){
		return "success";
	}
	public function sendMessageOrder() {
		$this->validSendMessage ();
		if ($this->hasErrors ()) {
			return "error";
		}
		$region  = $this->getRegion();
		
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		
		$orderHistory = new OrderHistoryVo ();
		$crDate = DateUtil::getCurrentDT();
		$orderHistory->orderId = $this->orderId;
		$orderHistory->status = 1;
		$orderHistory->crDate = $crDate;//"Y-m-d h:i:s"
		$orderHistory->crBy = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$orderHistory->cusNotified = 'yes';
		$description = "Date: " . $crDate;
		$description .= "<br>From: " . $this->fromCustomerName . "&lt;" . $this->fromEmail . "&gt;";
		$description .= "<br>To: " . $region->contactEmail;
		$description .= "<br>Subject: " . $this->subject." - #".$this->orderId;
		$description .= "<br>Message: " . $this->message;
		$orderHistory->description = $description;
		
		$this->orderService->insertOrderHistory ( $orderHistory );
		EmailUtil::sendMail($this->subject." - #".$this->orderId, $this->message,array($region->contactEmail),null,null,null,$this->fromEmail,$this->fromCustomerName);
		
		$this->orderHistories = $this->orderService->getOrderHistorysByOrder ( $orderVo );
		return "success";
	}

	public function searchProduct(){
		$productExtendVo = new ProductHomeExtendVo();
		$productExtendVo->name = $this->productName;
		$productExtendVo->languageCode = $this->languageCode;
		$productExtendVo->regionId = $this->regionId;
		$productExtendVo->currencyCode = $this->currencyCode;
		$productExtendVo->status = "active";
		$this->products = $this->productService->getProductHomeByFilter($productExtendVo);
		return "success";
	}
	public function cartContentTr(){
		$this->getProducts();
		return "success";
	}
	public function cartContentTrNew(){
		$this->getProducts();
		return "success";
	}
	public function quickOrderView(){
		$this->getProducts();
		$this->getCustomers();
		return "success";
	}
	public function quickCheckOut(){
		$status = $this->invalidProductCheckout();
		if($status<1){
			$this->addActionError(Lang::get("Please choose product and enter the quantity"));
		}
		
		if(!AppUtil::isEmptyString($this->customerId)){
			$filter = new CustomerVo ();
			$filter->id = $this->customerId;
			$saleRepChildDetail = $this->customerService->selectByKey ( $filter );
			$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
			$loginCustomerInfo->saleRepChildName= $saleRepChildDetail->firstName;
			$loginCustomerInfo->saleRepId= $saleRepChildDetail->saleRepId;  //id of saleRep parent
			$loginCustomerInfo->userId= $this->customerId;					 //id of saleRep child
			$loginCustomerInfo->isSaleRepChild=true; //hien tai dang nhap bang customer con
			SessionUtil::set ( Constants::CUSTOMER_LOGIN_SESSION_NAME, $loginCustomerInfo );
		}
		$this->clearSessionCart();
		foreach ($this->cartContents->getArray() as $cart){
			if($cart->isDelete == 'no' && $cart->productQuantity >0){
				$context = new ContextBase();
				$product = new ProductHomeExtendVo();
				$product->id = $cart->productId;
				$context->set("quantity", $cart->productQuantity);
				$context->set("product", $product);
				//$context->set("fieldErrors", array());
				WorkflowManager::Instance()->execute("shopping_cart_update", $context);
			}
		}
		
		return null;
	}
	
	private function invalidProductCheckout(){
		$status = -1;
		
		$count = 0;
		foreach ($this->cartContents->getArray() as $cart){
			if($cart->isDelete == 'no'){
				$count++;
			}
		}
		if($count ==0){
			$status=0;
		}else{
			foreach ($this->cartContents->getArray() as $cart){
				if($cart->isDelete == 'no' && (!AppUtil::isEmptyString($cart->productQuantity) && $cart->productQuantity != 0)){
					$status=1;
					break;
				}
			}
		}
		
		return $status;
	}
	
	private function getProducts(){
		$productExtendVo = new ProductHomeExtendVo();
		$productExtendVo->status = 'active';
		$productExtendVo->languageCode = $this->languageCode;
		$productExtendVo->regionId = $this->regionId;
		$productExtendVo->currencyCode= $this->currencyCode;
		$this->products = $this->productService->getProductHomeByFilter($productExtendVo);
	}

	private function validSendMessage() {
		if (AppUtil::isEmptyString ( $this->subject )) {
			$this->addFieldError ( "message[Subject]", "Subject cannot be empty" );
		}
		if (AppUtil::isEmptyString ( $this->message )) {
			$this->addFieldError ( "message[Message]", "Message cannot be empty" );
		}
	}
	private function getOrdersCustomer() {
		$customerVo = new CustomerVo ();
		$filter = $this->buildBaseFilter ( 'o.id desc' );
		
		$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		if($loginCustomerInfo->isSaleRepChild){
			$customerVo->id = $loginCustomerInfo->saleRepId;
		}else{
			$customerVo->id = $loginCustomerInfo->userId;
		}

		$count = $this->orderService->getCountOrdersByCustomerSalesRep ( $customerVo );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$customerVo->start_record = $paging->startRecord - 1;
		$customerVo->end_record = $paging->pageSize;
		$customerVo->order_by = "o.id desc";
		$paging->records = $this->orderService->getOrdersByCustomerSalesRep ( $customerVo );
		$this->ordersCustomer = $paging;
	}

	

	public function loadCategories() {
		$categoryVo = new CategoryHomeExtendVo();
		$categoryVo->languageCode = $this->languageCode;
		$productService = new ProductHomeService ();
		$this->categories = $productService->getCategoryHomeByFilter ( $categoryVo );
	}

	private function getSalesRepList() {
		$this->buildBaseFilter ();
		$filter = new CustomerVo ();
		// $filter->accountTypeId = 2;
		// $filter->customerTypeId = 1;
		$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		if($loginCustomerInfo->isSaleRepChild){
			$filter->saleRepId = $loginCustomerInfo->saleRepId;
		}else{
			$filter->saleRepId = $loginCustomerInfo->userId;
		}
		$count = $this->customerService->countByFilter ( $filter );
		// echo $this->pageSize.'-'.$this->getNLinks ().'-'.$this->page ;
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page ); // die;
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$paging->records = $this->customerService->selectByFilter ( $filter );
		$this->salesRepList = $paging;
	}
	private function getSalesRep() {
		if (AppUtil::isEmptyString ( $this->saleRepId )) {
			$this->addActionError ( Lang::get ( "You can't view a customer with empty id" ) );
		} elseif (! is_int ( intval ( $this->saleRepId ) )) {
			$this->addActionError ( Lang::get ( "SaleRep id required integer" ) );
		} else {
			$filter = new CustomerVo ();
			$filter->id = $this->saleRepId;
			$saleRepDetail = $this->customerService->selectByKey ( $filter );
			if (! isset ( $saleRepDetail )) {
				$this->addActionError ( Lang::getWithFormat ( "Not found saleRep with id {0}", $this->saleRep->id ) );
			} else {
				$this->saleRep = $saleRepDetail;
			}
		}
	}
	private function prepareData() {
		$this->saleRep->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->saleRep->crDate = date ( 'Y-m-d H:i:s' );
		$this->saleRep->mdDate = date ( 'Y-m-d H:i:s' );
		$this->saleRep->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->saleRep->saleRepId = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$this->saleRep->customerTypeId = 1;
		$this->saleRep->accountTypeId = 1;
		if (AppUtil::isEmptyString ( $this->saleRep->priceLevelId )) {
			$this->saleRep->priceLevelId = 0;
		}
		if (! AppUtil::isEmptyString ( $this->saleRep->password )) {
			$encryptType = ApplicationConfig::get ( "encryption.type.default" );
			if (! AppUtil::isEmptyString ( $encryptType )) {
				$this->saleRep->password = "{" . $encryptType . "}" . $encryptType ( $this->saleRep->password );
			}
		} else {
			$this->saleRep->password = null;
		}
	}
	private function prepareDataView() {
		$priceLevelService = new PriceLevelService ();
		$listPriceLevel = $priceLevelService->selectAll ();
		$priceLevelRetail = new PriceLevelVo ();
		$priceLevelRetail->id = 0;
		$priceLevelRetail->name = "Retail";
		$this->priceLevels = array ();
		array_push ( $this->priceLevels, $priceLevelRetail );
		foreach ( $listPriceLevel as $priceLevel ) {
			array_push ( $this->priceLevels, $priceLevel );
		}
	}
	private function validSaleRep($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->saleRep->email )) {
			$this->addFieldError ( "saleRep[email]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->saleRep->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "saleRep[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->saleRep->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->saleRep->email )) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat("{0} is not a valid email address",$this->customer->email));
		} else {
			if ($isAdding) {
				$filter = new CustomerVo ();
				$filter->email = $this->saleRep->email;
				$voResult = $this->customerService->selectByFilter ( $filter );
				if (count ( $voResult ) > 0) {
					$this->addFieldError ( "saleRep[email]", Lang::getWithFormat ( "{0} has already existed", $this->saleRep->email ) );
				}
			} else {
				$filter = new CustomerVo ();
				$filter->id = $this->saleRep->id;
				$customerOld = $this->customerService->selectByKey ( $filter );
				if ($customerOld->email != $this->saleRep->email) {
					$filter = new CustomerVo ();
					$filter->email = $this->saleRep->email;
					$voResult = $this->customerService->selectByFilter ( $filter );
					if (count ( $voResult ) > 0) {
						$this->addFieldError ( "saleRep[email]", Lang::getWithFormat ( "{0} has already existed", $this->saleRep->email ) );
					}
				}
			}
		}
		/*
		 * if (! AppUtil::isEmptyString ( $this->saleRep->userName ) && strlen ( $this->customer->userName ) < 5) {
		 * $this->addFieldError ( "saleRep[userName]", Lang::getWithFormat ( "{0} is user name not valid. It's length must greater than 5 characters", $this->customer->userName ) );
		 * }
		 */
		
		if (AppUtil::isEmptyString ( $this->saleRep->firstName )) {
			$this->addFieldError ( "saleRep[firstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->saleRep->firstName )) {
			$this->addFieldError ( "saleRep[firstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->saleRep->lastName )) {
			$this->addFieldError ( "saleRep[lastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->saleRep->lastName )) {
			$this->addFieldError ( "saleRep[lastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->saleRep->phone )) {
			$this->addFieldError ( "saleRep[phone]", Lang::get ( "Phone can not be empty" ) );
		}
		if ($isAdding) {
			if (AppUtil::isEmptyString ( $this->saleRep->password )) {
				$this->addFieldError ( "saleRep[email]", Lang::get ( "Password can not be empty" ) );
			}
		}
		if (! AppUtil::isEmptyString ( $this->saleRep->password )) {
			if (strlen ( $this->saleRep->password ) < 6) {
				$this->addFieldError ( "saleRep[password]", Lang::get ( "Your password must contain at least 6 characters" ) );
			}
			if ($this->saleRep->password != $this->cPassword) {
				$this->addFieldError ( "cPassword", Lang::get ( "Invalid confirm password" ) );
			}
		}
	}
	public function pdfOrder() {
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$order = $this->orderService->getOrderByKey( $orderVo );
		$this->orderService->exportPdfOrder ( $order );
	}
	
	public function childLogin() {
		$filter = new CustomerVo ();
		$filter->id = $this->saleRepId;
		$saleRepChildDetail = $this->customerService->selectByKey ( $filter );
		$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		$loginCustomerInfo->saleRepChildName= $saleRepChildDetail->firstName;
		$loginCustomerInfo->saleRepId= $saleRepChildDetail->saleRepId;  //id of saleRep parent
		$loginCustomerInfo->userId= $this->saleRepId;					 //id of saleRep child
		$loginCustomerInfo->isSaleRepChild=true;
		SessionUtil::set ( Constants::CUSTOMER_LOGIN_SESSION_NAME, $loginCustomerInfo );
		return "success";
		//var_dump($loginCustomerInfo);die;
		//$loginCustomerInfo->
	}
	private function getRegion(){
		$regionService = new RegionService();
		$regionVo = new RegionVo();
		$regionVo->id = $this->regionId;
		$region = $regionService->getById($regionVo);
		return $region;
	}
	private function getCustomers(){
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) != null) {
			$customerVo = new CustomerVo();
			$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
			if($loginCustomerInfo->isSaleRepChild){
				$customerVo->saleRepId = $loginCustomerInfo->saleRepId;
			}else{
				$customerVo->saleRepId = $loginCustomerInfo->userId;
			}
			$this->customers = $this->customerService->selectByFilter($customerVo);
		}
	}
	private function clearSessionCart() {
		SessionUtil::remove ( "order" );
		SessionUtil::remove ( "orderChargeInfo" );
		SessionUtil::remove ( "orderSurcharge" );
		SessionUtil::remove ( "listOrderProduct" );
		SessionUtil::remove ( "sessionId" );
	}
}