<?php

namespace frontend\controllers\address;

use common\helper\EmailHelper;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\vo\AddressExtendVo;
use common\services\address\AddressService;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\services\customer\CustomerService;
use common\utils\StringUtil;
use core\common\Paging;
use core\Lang;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\controllers\FrontendController;
use frontend\service\BlockEmailHelper;
use frontend\service\OrderHelper;

/**
 * *
 *
 * @author TANDT
 *        
 */
class AddressController extends FrontendController {
	public $address;
	public $addressList; // pagging
	public $listCountry;
	public $listState;
	public $listAddressSuggest;
	public $isCheckAddress;
	public $addressType;
	public $customer;
	public $order;
	public $actionErrorAddress;
	public $fieldErrorAddress;
	private $addressSv;
	private $countrySv;
	private $stateSv;
	public function __construct() {
		parent::__construct ();
		$this->address = new AddressExtendVo ();
		$this->addressSv = new AddressService ();
		$this->filter = new AddressExtendVo ();
		$this->stateSv = new StateService ();
		$this->countrySv = new CountryService ();
		$this->order = new OrderVo ();
	}
	public function listView() {
		if (is_null ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) )) {
			return "login";
		}
		$this->getAddresss ();
		if (! is_null ( $this->address->groupId )) {
			$customerSv = new CustomerService ();
			$customerVo = new CustomerVo ();
			$customerVo->id = $this->address->groupId;
			$this->customer = $customerSv->selectByKey ( $customerVo );
		}
		return "success";
	}
	public function search() {
		$this->getAddresss ();
		/*
		 * if(!is_null($this->address->groupId)){
		 * $customerSv = new CustomerService();
		 * $customerVo = new CustomerVo();
		 * $customerVo->id = $this->address->groupId;
		 * $this->customer = $customerSv->selectByKey($customerVo);
		 * }
		 */
		return "success";
	}
	public function addView() {
		$this->address = $this->address;
		$this->prepareDataView ();
		if ("payment" == $this->addressType && ! is_null ( SessionUtil::get ( "order" ) ) && SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId == 0) {
			$orderSessionVo = SessionUtil::get ( "order" );
			$paymentAddress = new AddressVo ();
			$paymentAddress->firstName = $orderSessionVo->billFirstName;
			$paymentAddress->lastName = $orderSessionVo->billLastName;
			$paymentAddress->email = $orderSessionVo->billEmail;
			$paymentAddress->phone = $orderSessionVo->billPhone;
			$paymentAddress->address = $orderSessionVo->billAddress;
			$paymentAddress->city = $orderSessionVo->billCity;
			$paymentAddress->postalCode = $orderSessionVo->billZipcode;
			
			$countrySv = new CountryService ();
			$countryVo = new CountryVo ();
			$countryVo->iso2 = $orderSessionVo->billCountryCode;
			$countryVos = $countrySv->selectByFilter ( $countryVo );
			$countryId = "";
			if (! is_null ( $countryVos ) && count ( $countryVos ) == 1) {
				$countryId = $countryVos [0]->id;
			}
			$paymentAddress->country = $countryId;
			
			$stateSv = new StateService ();
			$stateVo = new StateVo ();
			$stateVo->country = $countryId;
			$stateVo->iso2 = $orderSessionVo->billStateCode;
			$stateVos = $stateSv->selectByFilter ( $stateVo );
			$stateId = "";
			if (! is_null ( $stateVos ) && count ( $stateVos ) == 1) {
				$stateId = $stateVos [0]->id;
			}
			
			$paymentAddress->state = $stateId;
			$this->address = $paymentAddress;
		}
		if ("shipping" == $this->addressType && ! is_null ( SessionUtil::get ( "order" ) ) && SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId == 0) {
			$orderSessionVo = SessionUtil::get ( "order" );
			$shippingAddress = new AddressVo ();
			$shippingAddress->firstName = $orderSessionVo->shipFirstName;
			$shippingAddress->lastName = $orderSessionVo->shipLastName;
			$shippingAddress->email = $orderSessionVo->shipEmail;
			$shippingAddress->phone = $orderSessionVo->shipPhone;
			$shippingAddress->address = $orderSessionVo->shipAddress;
			$shippingAddress->city = $orderSessionVo->shipCity;
			$shippingAddress->postalCode = $orderSessionVo->shipZipcode;
			
			$countrySv = new CountryService ();
			$countryVo = new CountryVo ();
			$countryVo->iso2 = $orderSessionVo->shipCountryCode;
			$countryVos = $countrySv->selectByFilter ( $countryVo );
			$countryId = "";
			if (! is_null ( $countryVos ) && count ( $countryVos ) == 1) {
				$countryId = $countryVos [0]->id;
			}
			$shippingAddress->country = $countryId;
			
			$stateSv = new StateService ();
			$stateVo = new StateVo ();
			$stateVo->country = $countryId;
			$stateVo->iso2 = $orderSessionVo->shipStateCode;
			$stateVos = $stateSv->selectByFilter ( $stateVo );
			
			$stateId = "";
			
			if (! is_null ( $stateVos ) && count ( $stateVos ) == 1) {
				$stateId = $stateVos [0]->id;
			}
			$shippingAddress->state = $stateId;
			
			
			$this->address = $shippingAddress;
		}
		
		return "success";
	}
	public function add() {
		$this->validAddForm ();
		$this->prepareDataView ();
		if ($this->hasErrors ()) {
			return "error";
		}
		
		$addressVo = new AddressVo ();
		AppUtil::copyProperties ( $this->address, $addressVo );
		$resultValidUS = $this->addressSv->upsAddressValidation ( $addressVo );
		if (! $resultValidUS ["status"]) {
			$this->addActionError ( $resultValidUS ["errorMessage"] );
			if ("AmbiguousAddressIndicator" === $resultValidUS ["errorCode"]) {
				$this->listAddressSuggest = $resultValidUS ["candidateAddress"];
			}
		}
		if ($this->hasErrors ()) {
			return "error";
		}
		if (!ControllerHelper::isGuestLogin()) {
			$this->prepareData ();
			$this->address->id = $this->addressSv->createAddress ( $this->address );
			
			$this->prepareData ();
			$customerVo = new CustomerVo ();
			$customerSv = new CustomerService ();
			$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
			$customerVo = $customerSv->selectByKey ( $customerVo );
			$customerVo->defaultShippingAddressId = $this->address->id;
			$customerVo->defaultBillingAddressId = $this->address->id;
			$customerVo = $customerSv->updateCustomer ( $customerVo );
		}

		if (ControllerHelper::isGuestLogin() && ! is_null ( SessionUtil::get ( "order" ) )) {
			$order = SessionUtil::get ( "order" );
			if (! is_null ( $this->order->customerCompany )) {
				$order->customerCompany = $this->order->customerCompany;
			}
			if (! is_null ( $this->order->customerCompanyRegCode )) {
				$order->customerCompanyRegCode = $this->order->customerCompanyRegCode;
			}
			if (! is_null ( $this->order->customerCompanyVat )) {
				$order->customerCompanyVat = $this->order->customerCompanyVat;
			}
			
			if (! is_null ( $this->order->customerCompanyResellerCertNo )) {
				$order->customerCompanyResellerCertNo = $this->order->customerCompanyResellerCertNo;
			}
			
			$order->customerFirstname = $this->address->firstName;
			$order->customerEmail = $this->address->email;
			$order->customerLastname = $this->address->lastName;
			$order->customerPhone = $this->address->phone;
			SessionUtil::set ( "order", $order );
			if ("shipping" == $this->addressType) {
				$order->shipCompany = $this->order->customerCompany;
				$order->shipCompanyRegCode = $this->order->customerCompanyRegCode;
				$order->shipCompanyVat = $this->order->customerCompanyVat;
				$order->customerCompanyResellerCertNo = $this->order->customerCompanyResellerCertNo;
				$errorMessageShip = OrderHelper::buildOrderShippingAddress ( $this->address );
				if (! AppUtil::isEmptyString ( $errorMessageShip )) {
					$this->addFieldError ( "shippingAddress[id]", Lang::get ( $errorMessageShip ) );
					$this->addActionError ( Lang::get ( $errorMessageShip ) );
				}
			}
			
			if ("payment" == $this->addressType) {
				$order->billCompany = $this->order->customerCompany;
				$order->billCompanyRegCode = $this->order->customerCompanyRegCode;
				$order->billCompanyVat = $this->order->customerCompanyVat;
				$order->customerCompanyResellerCertNo = $this->order->customerCompanyResellerCertNo;
				
				$errorMessageBill = OrderHelper::buildOrderPaymentAddress ( $this->address );
				if (! AppUtil::isEmptyString ( $errorMessageBill )) {
					$this->addFieldError ( "paymentAddress[id]", Lang::get ( $errorMessageBill ) );
					$this->addActionError ( Lang::get ( $errorMessageBill ) );
				}
			}
		}
		\DatoLogUtil::devInfo(SessionUtil::get("order"));
		return "success";
	}
	public function editView() {
		$this->detail ();
		$this->prepareDataView ();

		if ($this->isCheckAddress) {
			$addressVo = new AddressVo ();
			AppUtil::copyProperties ( $this->address, $addressVo );
			$resultValidUS = $this->addressSv->upsAddressValidation ( $addressVo );
			if (! $resultValidUS ["status"]) {
				$this->addActionError ( $resultValidUS ["errorMessage"] );
				if ("AmbiguousAddressIndicator" === $resultValidUS ["errorCode"]) {
					$this->listAddressSuggest = $resultValidUS ["candidateAddress"];
				}
			}
		}
		return "success";
	}
	public function edit() {
		$this->validEditData ();
		$this->prepareDataView ();
		if ($this->hasErrors ()) {
			return "error";
		}
		$addressVo = new AddressVo ();
		AppUtil::copyProperties ( $this->address, $addressVo );
		
		$resultValidUS = $this->addressSv->upsAddressValidation ( $addressVo );
		if (! $resultValidUS ["status"]) {
			$this->addActionError ( $resultValidUS ["errorMessage"] );
			if ("AmbiguousAddressIndicator" === $resultValidUS ["errorCode"]) {
				$this->listAddressSuggest = $resultValidUS ["candidateAddress"];
			}
		}
		if ($this->hasErrors ()) {
			return "error";
		}
		$this->prepareData ();
		$customerVo = new CustomerVo ();
		$customerSv = new CustomerService ();
		$customerVo->id = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$customerVo = $customerSv->selectByKey ( $customerVo );
		if (! is_null ( $this->addressType ) && "shipping" == $this->addressType) {
			$addressNewId = $this->address->id ;
			$this->addressSv->updateAddress( $this->address );
			if (! AppUtil::isEmptyString ( $addressNewId )) {
				$customerVo->defaultShippingAddressId = $addressNewId;
				$customerVo = $customerSv->updateCustomer ( $customerVo );
			}
			return "success";
		}
		if (! is_null ( $this->addressType ) && "billing" == $this->addressType) {
			if($customerVo->defaultShippingAddressId == $this->address->id){
				$this->address->id = null;
				$addressNewId = $this->addressSv->createAddress ( $this->address );
			}else{
				$addressNewId = $this->address->id ;
				$this->addressSv->updateAddress( $this->address );
			}
			if (! AppUtil::isEmptyString ( $addressNewId )) {
				$customerVo->defaultBillingAddressId = $addressNewId;
				$customerVo = $customerSv->updateCustomer ( $customerVo );
			}
			return "success";
		}
		$this->address->crBy = null;
		$this->address->crDate = null;
		$this->addressSv->updateAddress ( $this->address );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->addressSv->deleteAddress ( $this->address );
		return "success";
	}
	public function changeCountry() {
		$state = new StateVo ();
		$state->country = AppUtil::defaultIfEmpty ( $this->address->country, 0 );
		$this->listState = $this->stateSv->selectByFilter ( $state );
		return "success";
	}
	private function prepareDataView() {
		$this->listCountry = $this->countrySv->getAll ();
		$state = new StateVo ();
		if("shipping" == $this->addressType && ! is_null ( SessionUtil::get ( "order" ) ) && SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId == 0){
			$countryCode = SessionUtil::get ( "order" )->shipCountryCode;
			$countryIdForGuest = 0;
			$countryVo = new CountryVo();
			$countryVo->iso2 = $countryCode;
			$countryVos = $this->countrySv->selectByFilter($countryVo);
			if(count($countryVos) == 1){
				$countryIdForGuest = $countryVos[0]->id;
			}
			$state->country = $countryIdForGuest;
		}elseif("payment" == $this->addressType && ! is_null ( SessionUtil::get ( "order" ) ) && SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId == 0){
			$countryCode = SessionUtil::get ( "order" )->billCountryCode;
			$countryIdForGuest = 0;
			$countryVo = new CountryVo();
			$countryVo->iso2 = $countryCode;
			$countryVos = $this->countrySv->selectByFilter($countryVo);
			if(count($countryVos) == 1){
				$countryIdForGuest = $countryVos[0]->id;
			}
			$state->country = $countryIdForGuest;
		}else{
			$state->country = AppUtil::defaultIfEmpty ( $this->address->country, 0 );
		}
		
		$this->listState = $this->stateSv->selectByFilter ( $state );
	}
	private function prepareData() {
		$this->address->type = 2;
		$this->address->crBy = empty ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) ) ? 0 : SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
		$this->address->crDate = date ( 'Y-m-d H:i:s' );
		$this->address->mdDate = date ( 'Y-m-d H:i:s' );
		$this->address->mdBy = empty ( SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME ) ) ? 0 : SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME )->userId;
	}
	private function validEditData() {
		$this->validEditForm ();
		if (! $this->hasErrors ()) {
			$filter = new AddressVo ();
			$filter->id = $this->address->id;
			$addressOld = $this->addressSv->selectByKey ( $filter );
			
			if (! isset ( $addressOld->id )) {
				$this->addFieldError ( "address[id]", Lang::getWithFormat ( "Not found with id {0} !", $this->address->id ) );
			}
		}
		if(!AppUtil::isEmptyString($this->address->email) && BlockEmailHelper::checkIsBlockEmail ( $this->address->email )){
			$this->addFieldError("address[email]", Lang::get("Your email account has been blocked in our system. Please contact our customer support."));
		}
	}
	private function validEditForm() {
		if (AppUtil::isEmptyString ( $this->address->id )) {
			$this->addFieldError ( "address[id]", Lang::get ( "ID address cannot be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->address )) {
			$this->addFieldError ( "address[address]", Lang::get ( "Address cannot be empty" ) );
		} /*
		   * else{
		   * $regex="/^[a-z0-9 .\-,]+$/i";
		   * if(preg_match($regex, $this->address->address)==false){
		   * $this->addFieldError ( "address[address]", "Please do not include special characters (e.g. #, /, ., @, &, and etc), multiple blanks, and punctuation in your Address." );
		   * }
		   * }
		   */
		if (AppUtil::isEmptyString ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Email cannot be empty" ) );
		} else if (filter_var ( $this->address->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		}else if (BlockEmailHelper::checkIsBlockEmail ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Your email account has been blocked in our system. Please contact our customer support." ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->country ) || "0" == $this->address->country) {
			$this->addFieldError ( "address[country]", Lang::get ( "Please select a country" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->postalCode )) {
			$this->addFieldError ( "address[postalCode]", Lang::get ( "Postal code cannot be empty" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->city )) {
			$this->addFieldError ( "address[city]", Lang::get ( "City cannot be empty" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->firstName )) {
			$this->addFieldError ( "address[firstName]", Lang::get ( "First name cannot be empty" ) );
			// } elseif (! StringUtil::validName ( $this->address->firstName )) {
			// $this->addFieldError ( "address[firstName]", Lang::get ( "First name cannot using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->lastName )) {
			$this->addFieldError ( "address[lastName]", Lang::get ( "Last name cannot be empty" ) );
			// } elseif (! StringUtil::validName ( $this->address->lastName )) {
			// $this->addFieldError ( "address[lastName]", Lang::get ( "Last name cannot using special characters" ) );
		}
		if (! AppUtil::isEmptyString ( $this->address->phone )) {
			if (! StringUtil::validPhone ( $this->address->phone )) {
				$this->addFieldError ( "address[phone]", Lang::getWithFormat ( "{0} is not a valid phone number", $this->address->phone ) );
			}
		} else {
			$this->addFieldError ( "address[phone]", Lang::get ( "Phone number cannot be empty" ) );
		}
		if ($this->address->country == 411 || $this->address->country == 384) {
			if (AppUtil::isEmptyString ( $this->address->state )) {
				$this->addFieldError ( "address[state]", Lang::get ( "Please select a state" ) );
			}
		}
	}
	private function validAddForm() {
		if (AppUtil::isEmptyString ( $this->address->address )) {
			$this->addFieldError ( "address[address]", Lang::get ( "Address cannot be empty" ) );
		} /*
		   * else{
		   * $regex="/^[a-z0-9 .\-,]+$/i";
		   * if(preg_match($regex, $this->address->address)==false){
		   * $this->addFieldError ( "address[address]", "Please do not include special characters (e.g. #, /, ., @, &, and etc), multiple blanks, and punctuation in your Address." );
		   * }
		   * }
		   */
		if (AppUtil::isEmptyString ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Email cannot be empty" ) );
		} else if (filter_var ( $this->address->email, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		} else if (! EmailHelper::isValidEmailMx ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->address->email ) );
		} else if (BlockEmailHelper::checkIsBlockEmail ( $this->address->email )) {
			$this->addFieldError ( "address[email]", Lang::get ( "Your email account has been blocked in our system. Please contact our customer support." ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->country ) || "0" == $this->address->country) {
			$this->addFieldError ( "address[country]", Lang::get ( "Please select a country" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->postalCode )) {
			$this->addFieldError ( "address[postalCode]", Lang::get ( "Postal code cannot be empty" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->city )) {
			$this->addFieldError ( "address[city]", Lang::get ( "City cannot be empty" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->address->firstName )) {
			$this->addFieldError ( "address[firstName]", Lang::get ( "First name cannot be empty" ) );
			// } elseif (! StringUtil::validName ( $this->address->firstName )) {
			// $this->addFieldError ( "address[firstName]", Lang::get ( "First name cannot using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->address->lastName )) {
			$this->addFieldError ( "address[lastName]", Lang::get ( "Last name cannot be empty" ) );
			// } elseif (! StringUtil::validName ( $this->address->lastName )) {
			// $this->addFieldError ( "address[lastName]", Lang::get ( "Last name cannot using special characters" ) );
		}
		if (! AppUtil::isEmptyString ( $this->address->phone )) {
			if (! StringUtil::validPhone ( $this->address->phone )) {
				$this->addFieldError ( "address[phone]", Lang::getWithFormat ( "{0} is not a valid phone number", $this->address->phone ) );
			}
		} else {
			$this->addFieldError ( "address[phone]", Lang::get ( "Phone number cannot be empty" ) );
		}
		if ($this->address->country == 411 || $this->address->country == 384) {
			if (AppUtil::isEmptyString ( $this->address->state )) {
				$this->addFieldError ( "address[state]", Lang::get ( "Please select a state" ) );
			}
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->address->id )) {
			$this->addActionError ( Lang::get ( "You can't view a address with empty id" ) );
		} elseif (! is_int ( intval ( $this->address->id ) )) {
			$this->addActionError ( Lang::get ( "Address id required integer" ) );
		} else {
			$addressDetail = $this->addressSv->selectBykey ( $this->address );
			if (! isset ( $addressDetail )) {
				$this->addActionError ( Lang::getWithFormat ( "Not found address with id {0}", $this->address->id ) );
			} else {
				$this->address = $addressDetail;
			}
		}
	}
	private function getAddresss() {
		$filter = $this->buildFilter ();
		$filter->groupId = $this->address->groupId;
		$count = $this->addressSv->searchCount ( $filter );
		$this->pageSize = 10;
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $this->pageSize;
		$paging->records = $this->addressSv->search ( $filter );
		$this->addressList = $paging;
	}
	private function buildFilter() {
		if(!is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)) && !AppUtil::isEmptyString(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId)){
			$this->address->groupId = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME)->userId;
		}
		$filter = $this->buildBaseFilter ( "id asc" );
		StringUtil::clearObject ( $filter );
		$filter->type = 2;
		return $filter;
	}
}