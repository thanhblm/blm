<?php

namespace backend\controllers\order;

use common\persistence\base\dao\RegionBaseDao;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderShipingInfoVo;
use common\persistence\base\vo\OrderStatusVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\ShippingStatusVo;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use common\persistence\extend\vo\OrderExtendVo;
use common\persistence\extend\vo\PriceLevelExtendVo;
use common\services\country\CountryService;
use common\services\email_template\EmailTemplateService;
use common\services\order\OrderService;
use common\services\order\OrderStatusService;
use common\services\payment\PaymentMethodService;
use common\services\price_level\PriceLevelService;
use common\services\shipping\ShippingStatusService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\EmailUtil;
use frontend\service\AuthorizeNetHelper;
use common\model\ResponseMo;
use frontend\service\ResponseHelper;
use core\utils\RequestUtil;
use common\services\address\StateService;
use common\persistence\base\vo\StateVo;
use common\utils\StringUtil;
use common\helper\EmailHelper;
use common\services\address\AddressService;
use common\persistence\base\vo\AddressVo;

class OrderController extends PagingController {
	private $orderService;
	public $orders;
	public $id;
	public $orderStatusId;
	public $shippingStatusId;
	public $order;
	public $shippingStatusList;
	public $paymentMethodList;
	public $orderStatusList;
	public $countryList;
	public $stateList;
	public $categoryState;
	public $shipStateList;
	public $priceLevelList;
	public $countryIso;
	
	public function __construct() {
		parent::__construct ();
		$this->filter = new OrderExtendVo ();
		$this->orderService = new OrderService ();
		$this->orders = new Paging ();
		$this->order = new OrderExtendVo ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Order Management";
	}
	public function listView() {
		$this->prepareShippingStatusList ();
		$this->preparePaymentMethodList ();
		$this->prepareOrderStatusList ();
		$this->prepareCountryList ();
		$this->preparePriceLevelList ();
		$this->getOrders ();
		return "success";
	}
	public function search() {
		$this->prepareShippingStatusList ();
		$this->preparePaymentMethodList ();
		$this->prepareOrderStatusList ();
		$this->prepareCountryList ();
		$this->preparePriceLevelList ();
		$this->getOrders ();
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No order id for deleting" );
		}
		// Load order.
		$filter = new OrderExtendVo ();
		$filter->id = $this->id;
		$this->order = new OrderExtendVo ();
		$this->order->id = $this->id;
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No order id for deleting" );
		}
		// Delete order.
		$filter = new OrderExtendVo ();
		$filter->id = $this->id;
		$this->orderService->deleteOrder ( $filter );
		$this->addActionMessage ( "The order deleted successfully" );
		return "success";
	}
	protected function getOrders() {
		$filter = $this->buildFilter ();
		$filter->usaFilter = 'US';
		if ($filter->erdt == true) {
			// $filter->isUSA=2;
			$filter->shipBy = 'erdt';
		} else {
			$filter->shipBy = null;
		}
		// Get total records of orders.
		$count = $this->orderService->countOrders ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get orders.
		$orderVos = $this->orderService->getOrders ( $filter );
		foreach ( $orderVos as $orderVo ) {
			$orderVo->date = DateTimeUtil::mySqlStringDate2String ( $orderVo->date, DateTimeUtil::getDateTimeFormat () );
		}
		$paging->records = $orderVos;
		$this->orders = $paging;
	}
	protected function buildFilter() {
		$filter = $this->buildBaseFilter ( "crDate desc" );
		$filter->dateFrom = DateTimeUtil::string2MySqlDate ( DateTimeUtil::appendTime ( $filter->dateFrom ), DateTimeUtil::getDateTimeFormat () );
		$filter->dateTo = DateTimeUtil::string2MySqlDate ( DateTimeUtil::appendTime ( $filter->dateTo, false ), DateTimeUtil::getDateTimeFormat () );
		return $filter;
	}
	public function detailView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No order id for view" );
		}
		$this->prepareCountryList();
		// Load order.
		$filter = new OrderExtendVo ();
		$filter->id = $this->id;
		$this->order = $this->orderService->getOrderByKey ( $filter );
		$this->stateList = $this->prepareStateList($this->order->billCountryCode);
		$this->shipStateList = $this->prepareStateList($this->order->shipCountryCode);
		return "success";
	}
	public function edit() {
		$this->validateEdit();
		$this->prepareCountryList();
		$this->stateList = $this->prepareStateList($this->order->billCountryCode);
		$this->shipStateList = $this->prepareStateList($this->order->shipCountryCode);
		if ($this->hasErrors ()) {
			return "error";
		}
		
		$this->orderService->updateOrder ( $this->order );
		$this->addActionMessage ( "Order updated successfully" );
		$this->order = $this->orderService->getOrderByKey ( $this->order );
		
		return "success";
	}
	public function refund() {
		// $this->orderService->updateOrder ( $this->order );
		$responseVo = new ResponseMo ();
		\DatoLogUtil::debug ( $_REQUEST );
		$orderId = RequestUtil::get ( 'orderId' );
		$refundAmt = RequestUtil::get ( 'refundAmt' );
		$responseVo = AuthorizeNetHelper::refund ( $orderId, $refundAmt );
		if (ResponseHelper::isError ( $responseVo )) {
			$this->addActionError ( $responseVo->msg );
		} else {
			$this->addActionMessage ( $responseVo->msg );
		}
		//$this->order = $this->orderService->getOrderByKey ( $this->order );
		return "success";
	}
	public function getStateByCountry(){
		$this->stateList = $this->prepareStateList($this->countryIso);
		return "success";
	}
	private function validateEdit(){
		if (AppUtil::isEmptyString ( $this->order->billFirstName )) {
			$this->addFieldError ( "order[billFirstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->order->billFirstName )) {
			$this->addFieldError ( "order[billFirstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->billLastName )) {
			$this->addFieldError ( "order[billLastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->order->billLastName )) {
			$this->addFieldError ( "order[billLastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->billAddress )) {
			$this->addFieldError ( "order[billAddress]", Lang::get ( "Address can not be empty" ) );
		}
		
		
		if (AppUtil::isEmptyString ( $this->order->billCity )) {
			$this->addFieldError ( "order[billCity]", Lang::get ( "City can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->billEmail )) {
			$this->addFieldError ( "order[billEmail]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->order->billEmail, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "order[billEmail]", Lang::getWithFormat ( "{0} is not a valid email address", $this->order->billEmail ) );
		} else if(! EmailHelper::isValidEmailMx($this->order->billEmail)){
			$this->addFieldError ( "order[billEmail]", Lang::getWithFormat ( "{0} is not a valid mx email address", $this->order->billEmail ) );
		}
		if (AppUtil::isEmptyString ( $this->order->billZipcode )) {
			$this->addFieldError ( "order[billZipcode]", Lang::get ( "Zipcode can not be empty" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->order->billCountryCode ) ||  "0" == $this->order->billCountryCode) {
			$this->addFieldError ( "order[billCountryCode]", Lang::get ( "Please select a country" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->billPhone )) {
			$this->addFieldError ( "order[billPhone]", Lang::get ( "Phone can not be empty" ) );
		} elseif (! StringUtil::validPhone( $this->order->billPhone)) {
			$this->addFieldError ( "order[billPhone]", Lang::get ( "Phone is not valid" ) );
		}
		if( $this->order->billCountryCode=='US' || $this->order->billCountryCode=='ES'){
			if (AppUtil::isEmptyString ( $this->order->billStateCode )) {
				$this->addFieldError ( "order[billStateCode]", Lang::get ( "State can not be empty" ) );
			}
		}
		
		
		if (AppUtil::isEmptyString ( $this->order->shipFirstName )) {
			$this->addFieldError ( "order[shipFirstName]", Lang::get ( "First name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->order->shipFirstName )) {
			$this->addFieldError ( "order[shipFirstName]", Lang::get ( "First name can not using speacial character" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipLastName )) {
			$this->addFieldError ( "order[shipLastName]", Lang::get ( "Last name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->order->shipLastName )) {
			$this->addFieldError ( "order[shipLastName]", Lang::get ( "Last name can not using special characters" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipAddress )) {
			$this->addFieldError ( "order[shipAddress]", Lang::get ( "Address can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipCity )) {
			$this->addFieldError ( "order[shipCity]", Lang::get ( "City can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipEmail )) {
			$this->addFieldError ( "order[shipEmail]", Lang::get ( "Email can not be empty" ) );
		} else if (filter_var ( $this->order->shipEmail, FILTER_VALIDATE_EMAIL ) === false) {
			$this->addFieldError ( "order[shipEmail]", Lang::getWithFormat ( "{0} is not a valid email address", $this->order->shipEmail ) );
		} else if(! EmailHelper::isValidEmailMx($this->order->shipEmail)){
			$this->addFieldError ( "order[shipEmail]", Lang::getWithFormat ( "{0} is not a valid mx email address", $this->order->shipEmail ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipZipcode )) {
			$this->addFieldError ( "order[shipZipcode]", Lang::get ( "Zipcode can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipCountryCode ) ||  "0" == $this->order->shipCountryCode) {
			$this->addFieldError ( "order[shipCountryCode]", Lang::get ( "Please select a country" ) );
		}
		if (AppUtil::isEmptyString ( $this->order->shipPhone )) {
			$this->addFieldError ( "order[shipPhone]", Lang::get ( "Phone can not be empty" ) );
		} elseif (! StringUtil::validPhone( $this->order->shipPhone)) {
			$this->addFieldError ( "order[shipPhone]", Lang::get ( "Phone is not valid" ) );
		}
		if( $this->order->shipCountryCode=='US' || $this->order->shipCountryCode=='ES'){
			if (AppUtil::isEmptyString ( $this->order->shipStateCode )) {
				$this->addFieldError ( "order[shipStateCode]", Lang::get ( "State can not be empty" ) );
			}
		}
		$addressService = new AddressService();
		$addressVo = $this->billAddress();
		$resultValidUS = $addressService->upsAddressValidation ( $addressVo );
		
		$addressVo = $this->shipAddress();
		$resultValidUSShip = $addressService->upsAddressValidation ( $addressVo );
		
		if (! $resultValidUS ["status"]) {
			$this->addActionError ( $resultValidUS ["errorMessage"] );
		}else{
			if (! $resultValidUSShip ["status"]) {
				$this->addActionError ( $resultValidUSShip ["errorMessage"] );
			}
		}
	}
	private function billAddress(){
		$addressVo = new AddressVo();
		$addressVo->address = $this->order->billAddress;
		$addressVo->city = $this->order->billCity;
		$addressVo->postalCode = $this->order->billZipcode;
		
		$countryService = new CountryService();
		$countryVo = new CountryVo();
		$countryVo->iso2 = $this->order->billCountryCode;
		$country = $countryService->selectByFilter($countryVo);
		$addressVo->country = $country[0]->id;
		$stateService = new StateService();
		$stateFilter = new StateVo();
		$stateFilter->iso2 = $this->order->billStateCode;
		$stateVo = $stateService->selectByFilter($stateFilter);
		$addressVo->state = $stateVo[0]->id;
		
		return $addressVo;
	}
	private function shipAddress(){
		$addressVo = new AddressVo();
		$addressVo->address = $this->order->shipAddress;
		$addressVo->city = $this->order->shipCity;
		$addressVo->postalCode = $this->order->shipZipcode;
	
		$countryService = new CountryService();
		$countryVo = new CountryVo();
		$countryVo->iso2 = $this->order->shipCountryCode;
		$country = $countryService->selectByFilter($countryVo);
		$addressVo->country = $country[0]->id;
		$stateService = new StateService();
		$stateFilter = new StateVo();
		$stateFilter->iso2 = $this->order->shipStateCode;
		$stateVo = $stateService->selectByFilter($stateFilter);
		$addressVo->state = $stateVo[0]->id;
	
		return $addressVo;
	}
	
	private function preparePaymentMethodList() {
		$paymentMethodService = new PaymentMethodService ();
		$paymentMethodVo = new PaymentMethodVo ();
		// $paymentMethodVo->status = 1;
		$this->paymentMethodList = $paymentMethodService->selectByFilter ( $paymentMethodVo );
	}
	private function prepareOrderStatusList() {
		$orderStatusService = new OrderStatusService ();
		$orderStatusVo = new OrderStatusVo ();
		$this->orderStatusList = $orderStatusService->getOrderStatusByFilter ( $orderStatusVo );
	}
	private function prepareShippingStatusList() {
		$shippingStatusService = new ShippingStatusService ();
		$shippingStatusVo = new ShippingStatusVo ();
		$this->shippingStatusList = $shippingStatusService->getShippingStatusByFilter ( $shippingStatusVo );
	}
	private function prepareCountryList() {
		$countryService = new CountryService ();
		$countryVo = new CountryVo ();
		$countryVo->status = 'active';
		$this->countryList = $countryService->selectByFilter ( $countryVo );
	}
	private function prepareStateList($countryCode){
		$stateService = new StateService();
		$stateVo = new StateVo();
		$stateVo->countryIso = $countryCode;
		return $stateService->selectByFilter($stateVo);
	}
	private function preparePriceLevelList() {
		$priceLevelService = new PriceLevelService ();
		$priceLevelVo = new PriceLevelExtendVo ();
		$this->priceLevelList = $priceLevelService->getPriceLevelByFilter ( $priceLevelVo );
	}
	public function changeOrderStatus() {
		$orderVo = new OrderVo ();
		$orderVo->id = $this->id;
		$orderVo->orderStatusId = $this->orderStatusId;
		$this->orderService->updateOrder ( $orderVo );
		
		// insert to Order History
		$orderHistory = new OrderHistoryVo ();
		$orderHistory->orderId = $this->id;
		$orderHistory->status = $this->orderStatusId;
		$orderHistory->crDate = date ( "Y-m-d h:i:s" );
		$orderHistory->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$orderHistory->cusNotified = 'no';
		if ($this->orderStatusId == 3) {
			$orderHistory->cusNotified = 'yes';
		}
		$orderHistory->description = Lang::get ( 'Status Update' );
		$this->orderService->insertOrderHistory ( $orderHistory );
		
		if ($this->orderStatusId == 3) { // Canceled
			$this->sendEmail ( $this->id );
		}
		return "success";
	}
	public function changeShippingStatus() {
		$orderVo = new OrderVo ();
		$orderVo->id = $this->id;
		$orderVo->shippingStatusId = $this->shippingStatusId;
		$this->orderService->updateOrder ( $orderVo );
		return "success";
	}
	public function checkERDT() {
		$orderFilter = new OrderExtendVo ();
		$orderFilter->id = $this->id;
		$orderVo = $this->orderService->getOrderVoByKey ( $orderFilter );
		if (isset ( $orderVo )) {
			if ($orderVo->shipCountryCode == 'US') {
				$this->addFieldError ( "order[shipCountryCode]", "Shipping country is USA" );
			}
			$this->order = $orderVo;
		} else {
			$this->addFieldError ( "order[id]", "Order is not exist" );
		}
		
		if ($orderVo->shippingStatusId !== 1) {
			$this->addFieldError ( "orderShippingInfoVo[shipDate]", "Invalided ship status" );
		}
		
		if ($this->hasErrors ()) {
			return "success";
		}
		$orderVo = new OrderVo ();
		$orderVo->id = $this->id;
		$orderVo->shippingStatusId = 2; // 2 is id of 'ordered' shipping status
		$this->orderService->updateOrder ( $orderVo );
		$orderShippingInfoVo = new OrderShipingInfoVo ();
		$orderShippingInfoVo->orderId = $this->id;
		$orderShippingInfoVo->shipBy = 'erdt';
		$this->orderService->insertOrderShippingInfo ( $orderShippingInfoVo );
		return "success";
	}
	public function uncheckERDT() {
		$orderFilter = new OrderExtendVo ();
		$orderFilter->id = $this->id;
		$orderVo = $this->orderService->getOrderVoByKey ( $orderFilter );
		if (isset ( $orderVo )) {
			if ($orderVo->shipCountryCode == 'US') {
				$this->addFieldError ( "order[shipCountryCode]", "Shipping country is USA" );
			}
			$this->order = $orderVo;
		} else {
			$this->addFieldError ( "order[id]", "Order is not exist" );
		}
		
		if ($orderVo->shippingStatusId !== 2) {
			$this->addFieldError ( "orderShippingInfoVo[shipDate]", "Invalided ship status" );
		}
		
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->order->shippingStatusId = 1;
		$this->orderService->updateOrder ( $this->order );
		$orderShippingInfoVo = new OrderShipingInfoVo ();
		$orderShippingInfoVo->orderId = $this->id;
		$this->orderService->deleteOrderShippingInfo ( $orderShippingInfoVo );
		return "success";
	}
	private function validateERDT() {
	}
	public function pdfOrder() {
		$orderVo = new OrderExtendVo ();
		$orderVo->id = $this->id;
		$order = $this->orderService->getOrderByKey ( $orderVo );
		$this->orderService->exportPdfOrder ( $order );
	}
	public function updateOrdePending() {
	}
	private function sendEmail($orderId) {
		$orderExtendVo = new OrderExtendVo ();
		$orderExtendVo->id = $orderId;
		$order = $this->orderService->getOrderByKey ( $orderExtendVo );
		if (is_null ( $order->paymentMethodId ))
			return 0;
		$regionFilter = new RegionVo ();
		$regionFilter->id = $order->regionId;
		$regionDao = new RegionBaseDao ();
		$regionVo = $regionDao->selectByKey ( $regionFilter );
		$subject = Lang::get ( "Endoca: Order Canceled" );
		$email = array (
				$order->customerEmail 
		);
		$body = "";
		$emailTemplateSv = new EmailTemplateService ();
		$emailTemplateLangVo = new EmailTemplateLangExtendVo ();
		if ($order->paymentMethodId == 1) {
			$emailTemplateLangVo->emailTemplateId = 7808;
		} else {
			$emailTemplateLangVo->emailTemplateId = 8373;
		}
		$emailTemplateLangVo->languageCode = $order->languageCode;
		$emailTemplate = $emailTemplateSv->getEmailTemplate2Send ( $emailTemplateLangVo );
		$subject = $emailTemplate->subject;
		$body = $emailTemplate->body;
		$body = str_replace ( '$(firstname)', $order->customerFirstname, $body );
		$body = str_replace ( '$(order_id)', $orderId, $body );
		return EmailUtil::sendMail ( $subject, $body, $email, array (), array (), array (), $regionVo->contactEmail );
	}
}