<?php

namespace frontend\controllers\customer;

use common\helper\EmailHelper;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CartInfoVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\UserGroupVo;
use common\persistence\extend\vo\OrderExtendVo;
use common\services\address\AddressService;
use common\services\customer\CustomerService;
use common\services\order\OrderService;
use common\services\user_group\UserGroupService;
use common\utils\DateUtil;
use common\utils\StringUtil;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\controllers\FrontendController;
use common\persistence\base\vo\OrderVo;

/**
 *
 * @author TANDT
 *        
 */
class CustomerController extends FrontendController {
	// Data request
	public $cPassword;
	public $subscribe;
	// Data response
	public $customers;
	public $customer;
	public $isGuest;
	public $customerList;
	public $orderHistories;
	public $listUserGroup;
	public $genderList;
	public $order;
	public $orderId;
	public $ordersCustomer;
	public $fromCustomerName;
	public $fromEmail;
	public $cartInfoVo;
	public $subject;
	public $message;
	public $taxName;
	private $orderService;
	private $customerSv;
	public function __construct() {
		parent::__construct ();
		$this->orderService = new OrderService ();
		$this->customerSv = new CustomerService ();
		$this->customer = new CustomerVo ();
		$this->filter = new CustomerVo ();
	}
	public function detail() {
		if(is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
			return "login";
		}
		$this->validDetail ();
		if ($this->hasErrors ()) {
			return "login";
		}
		$this->getDetail ();
		$this->buildGenderList ();
		$this->getAddressDetail ();
		return "success";
	}
	public function edit() {
		$this->validDataCustomer ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareDataCustomer();
		$this->customerSv->updateCustomer ( $this->customer );
		$sessionCustome = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		$sessionCustome->firstName = $this->customer->firstName;
		$sessionCustome->lastName = $this->customer->lastName;
		SessionUtil::set ( Constants::CUSTOMER_LOGIN_SESSION_NAME,  $sessionCustome);
		$this->addActionMessage ( Lang::getWithFormat ( "Account {0} info updated succesfully", $this->customer->firstName ) );
		return "success";
	}
	public function detailOrder() {
		if(is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
			return "login";
		}
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$this->order = $this->orderService->getOrderByKey($orderVo);
		$regionVo = ControllerHelper::getRegion();
		$this->taxName = "VAT";
		if("4426" == $regionVo->id){
			$this->taxName = "Sales Tax";
		}
		return "success";
	}
	public function listOrderHistory() {
		if(is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
			return "login";
		}
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$this->orderHistories = $this->orderService->getOrderHistorysByOrder ( $orderVo );
		return "success";
	}
	public function listOrders() {
		if(is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
			return "login";
		}
		if (SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME  ) != null) {
			$this->getOrdersCustomer ();
		}
		if(!is_null(SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME  )->userId)){
			
			$orderVo = new OrderVo();
			$filter = $this->buildBaseFilter ( 'o.id desc' );
			
			$loginCustomerInfo=SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
			$orderVo->customerId = $loginCustomerInfo->userId;
			
			$count = $this->orderService->getCountOrdersByCustomer( $orderVo);
			$paging = new Paging( $count, $this->pageSize, $this->getNLinks (), $this->page );
			$orderVo->start_record = $paging->startRecord - 1;
			$orderVo->end_record = $paging->pageSize;
			$orderVo->order_by = "date desc";
			$paging->records = $this->orderService->getOrdersByCustomer( $orderVo);
			$this->ordersCustomer = $paging;
			
			
			$customerSv = new CustomerService();
			$customerVo = new CustomerVo();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME  )->userId;
			$this->customer = $customerSv->selectByKey($customerVo);
		}
		
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
		$region  = ControllerHelper::getRegion();
		
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;

		$crDate = DateUtil::getCurrentDT();
		$orderHistory = new OrderHistoryVo ();
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
	
	public function pdfOrder() {
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->orderId;
		$order = $this->orderService->getOrderByKey( $orderVo );
		
		if($order->customerId == 0){
			// If is Guest order allow for all view
			$this->orderService->exportPdfOrder ( $order );
		}else{
			if(is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
				return "login";
			}
			// Khach hang ko dc xem order cua nhau
			if($order->customerId != SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId){
				return "login";
			}
			$this->orderService->exportPdfOrder ( $order );
		}
	}
	private function getOrdersCustomer() {
		$orderVo = new OrderVo();
		$filter = $this->buildBaseFilter ( 'id desc' );
		$loginCustomerInfo = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		$orderVo->customerId = $loginCustomerInfo->userId;
		$orderVo->order_by = "date desc";
		$count = $this->orderService->getCountOrdersByCustomer ( $orderVo);
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$orderVo->start_record = $paging->startRecord - 1;
		$orderVo->end_record = $paging->pageSize;
		$paging->records = $this->orderService->getOrdersByCustomer ( $orderVo);
		$this->ordersCustomer = $paging;
	}
	private function validSendMessage() {
		if (AppUtil::isEmptyString ( $this->subject )) {
			
			$this->addFieldError ( "message[Subject]", "Subject cannot be empty" );
		}
		if (AppUtil::isEmptyString ( $this->message )) {
			$this->addFieldError ( "message[Message]", "Message cannot be empty" );
		}
	}
	
	private function preapareDataCustomer() {
		if (! AppUtil::isEmptyString ( $this->customer->password )) {
			$encryptType = ApplicationConfig::get ( "encryption.type.default" );
			if (! AppUtil::isEmptyString ( $encryptType )) {
				$this->customer->password = "{" . $encryptType. "}" . $encryptType ( $this->customer->password );
			}
		} else {
			$this->customer->password = null;
		}
	}
	
	private function validDataCustomer() {
		$this->validFormCustomer ();
		if (! $this->hasErrors ()) {
			$filterOld = new CustomerVo ();
			$filterOld->id = $this->customer->id;
			$filterOld->status = 'active';
			$customerOldResult = $this->customerSv->selectByFilter ( $filterOld );
			if (! EmailHelper::isValidEmailMx ( $this->customer->email )) {
				$this->addFieldError ( "customer[email]", Lang::getWithFormat("{0} is not a valid email address",$this->customer->email));
			} else if (! empty ( $customerOldResult )) {
				if ($customerOldResult [0]->email != $this->customer->email) {
					$checkEmailVo = new CustomerVo ();
					$checkEmailVo->email = $this->customer->email;
					$checkEmailVo->status = 'active';
					$checkEmailVo = $this->customerSv->selectByFilter ( $checkEmailVo );
					if (! empty ( $checkEmailVo )) {
						$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} has already existed", $this->customer->email ) );
					}
				}
			}
		}
	}
	private function validFormCustomer() {
		if (AppUtil::isEmptyString ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::get ( "First name cannot be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::getWithFormat ( "First name {0} used special characters", $this->customer->firstName ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::get ( "Last name cannot be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::getWithFormat ( "Last name {0} used special characters", $this->customer->lastName ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->phone )) {
			$this->addFieldError ( "customer[phone]", Lang::get ( "Phone cannot be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::get ( "Email cannot be empty" ) );
		} else if (filter_var ( $this->customer->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} is invalid email address", $this->customer->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat("{0} is not a valid email address",$this->customer->email));
		}
		if (AppUtil::isEmptyString ( $this->customer->password )) {
		} else if (strlen ( $this->customer->password ) < 6) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Your password must contain at least 6 characters" ) );
		} else if ($this->customer->password !== $this->cPassword) {
			$this->addFieldError ( "cPassword", Lang::get ( "Confirm password doesn't match" ) );
		}
	}
	private function getAllUserGroup() {
		$ugSv = new UserGroupService ();
		$ugVo = new UserGroupVo ();
		$ugVo->status = "active";
		$this->listUserGroup = $ugSv->selectByFilter ( $ugVo );
	}
	private function validDetail() {
		if (isset ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId )) {
			$loginCustomerInfo = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
			$this->customer->id = $loginCustomerInfo->userId;
		} else {
			$this->addActionError ( Lang::get ( "Please login before access profile" ) );
		}
	}
	private function getDetail() {
		$this->customer = $this->customerSv->selectByKey ( $this->customer );
	}
	private function preapareDataRegister() {
		$this->customer->crBy = 0;
		$this->customer->groupId = 0;
		$this->customer->status = "active";
		$this->customer->crDate = date ( "Y-m-d H:i:s" );
		$this->customer->mdBy = 0;
		$this->customer->mdDate = date ( "Y-m-d H:i:s" );
		$this->customer->customerTypeId = 1;
		$this->customer->accountTypeId = 1;
		$this->customer->priceLevelId = 0;
		if (! AppUtil::isEmptyString ( $this->customer->password )) {
			$this->customer->password = sha1 ( $this->customer->password );
		} else {
			$this->customer->password = null;
		}
	}
	private function validRegisterData() {
		$this->validRegisterForm ();
		if (! $this->hasErrors ()) {
			$filter = new CustomerVo ();
			$filter->email = $this->customer->email;
			$customerResult = $this->customerSv->selectByFilter ( $filter );
			if (count ( $customerResult ) && $customerResult [0]->email == $this->customer->email) {
				$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} has already existed!", $this->customer->email ) );
			}
		}
	}
	private function validRegisterForm() {
		if (AppUtil::isEmptyString ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::get ( "Email cannot be empty" ) );
		} else if (filter_var ( $this->customer->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->customer->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::getWithFormat("{0} is not a valid email address",$this->customer->email));
		}
		if (! AppUtil::isEmptyString ( $this->customer->password ) && strlen ( $this->customer->password <= '6' )) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Your Password Must Contain At Least 6 Characters!" ) );
		}
		if (! AppUtil::isEmptyString ( $this->customer->password ) && $this->customer->password != $this->cPassword) {
			$this->addFieldError ( "cPassword", Lang::get ( "Please Check You've Entered Or Confirmed Your Password!" ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::get ( "First name cannot be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->firstName )) {
			$this->addFieldError ( "customer[firstName]", Lang::getWithFormat ( "{0} is First name cannot using speacial character !", $this->customer->firstName ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::get ( "Last name cannot be empty" ) );
		} elseif (! StringUtil::validName ( $this->customer->lastName )) {
			$this->addFieldError ( "customer[lastName]", Lang::getWithFormat ( "{0} is Last name cannot using speacial character !", $this->customer->lastName ) );
		}
		if (AppUtil::isEmptyString ( $this->customer->password )) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Password cannot be empty" ) );
		} else if (strlen ( $this->customer->password ) < 6) {
			$this->addFieldError ( "customer[password]", Lang::get ( "Your Password Must Contain At Least 6 Characters!" ) );
		} else if ($this->customer->password != $this->cPassword) {
			$this->addFieldError ( "cPassword", Lang::get ( "Please Check You've Entered Or Confirmed Your Password!" ) );
		}
	}
	private function getAddressDetail() {
		$loginCustomerInfo = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
		$this->customer->id = $loginCustomerInfo->userId;
		$addressSv = new AddressService ();
		$addressVo = new AddressVo ();
		$addressVo->groupId = $this->customer->id;
		$addressVo->type = 2;
		$addressVos = $addressSv->selectByFilter ( $addressVo );
		if (isset ( $addressVos [0] )) {
			$this->address = $addressVos [0];
		}
	}
	private function buildGenderList() {
		$this->genderList = array (
				"F" => Lang::get ( "Female" ),
				"M" => Lang::get ( "Male" ),
				"O" => Lang::get ( "Other" ) 
		);
	}
}