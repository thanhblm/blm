<?php

namespace frontend\controllers\home;

use common\helper\EmailHelper;
use common\model\LoginUserInfoMo;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CustomerTypeVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\StateVo;
use common\persistence\base\vo\SubscriberVo;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use common\services\address\AddressService;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\services\customer\CustomerService;
use common\services\customer\CustomerTypeService;
use common\services\email_template\EmailTemplateService;
use common\services\home\HomeService;
use common\services\product\ProductHomeService;
use common\utils\StringUtil;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\SessionUtil;
use core\utils\ValidateUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\controllers\FrontendController;
use frontend\service\BlockEmailHelper;

/**
 *
 * @author TANDT
 *
 */
class RegisterController extends FrontendController {
	public $loginCustomerInfo;
	public $cPassword;
	public $subscribe;
	public $customer;
	public $address;
	public $countryList;
	public $listState;
	public $listAddressSuggest;
	protected $customerSv;
	protected $productService;

	public function __construct(){
		parent::__construct();
		$this->loginCustomerInfo = new LoginUserInfoMo ();
		$this->productService = new ProductHomeService ();
		$this->customerSv = new CustomerService ();
		$this->customer = new CustomerVo ();
		$this->address = new AddressVo ();
	}

	public function register(){
		$this->buildCountryList();
		$this->buildlistState();
		$this->validCustomerData();
		$this->validAddressForm();
		if ($this->hasErrors()) {
			$this->buildCountryList();
			$this->buildlistState();
			return "success";
		}
		$this->prepareCustomerData();
		$this->prepareAddressData();
		$homeSv = new HomeService ();
		$customerVo = AppUtil::cloneObj($this->customer);
		if (!AppUtil::isEmptyString($customerVo->password)) {
			$encryptedType = ApplicationConfig::get("encryption.type.default");
			if (!AppUtil::isEmptyString($encryptedType)) {
				$customerVo->password = "{" . $encryptedType . "}" . ($encryptedType ($customerVo->password));
			} else {
				$customerVo->password = $customerVo->password;
			}
		}
		$this->customer->id = $homeSv->register($customerVo, $this->address, $this->prepareSubcriber());

		$this->prepareSessionCustomerFrontend();
		if (is_null($this->prepareSubcriber())) {
			$this->sendEmailNonSubcribe();
		} else {
			$this->sendEmail();
		}
		return "success";
	}

	private function sendEmail(){
		$regionVo = ControllerHelper::getRegion();
		$unsSubcribe = "<a href='" . ActionUtil::getFullPathAlias("home/subscriber/unsubscribe") . "?key=" . md5($this->customer->email) . "' title='unsubcribe'>unsubscribe</a>";

		$emailTemplateSv = new EmailTemplateService ();

		$emailTemplate = new EmailTemplateExtendVo ();
		$emailTemplate->id = "7046";
		$emailTemplate->sendTo = "customer";
		$emailTemplates = $emailTemplateSv->getEmailTemplateByFilter($emailTemplate);


		$customerTypeVo = new CustomerTypeVo ();
		$customerTypeSv = new CustomerTypeService ();
		$emailTemplate->id = "8368";
		$emailTemplate->sendTo = "admin";
		$adminEmailTemplates = $emailTemplateSv->getEmailTemplateByFilter($emailTemplate);
		if (isset ($emailTemplates [0])) {
			$subject = Lang::get($emailTemplates [0]->subject);
			$body = Lang::get($emailTemplates [0]->body);
			$body = str_replace('$(firstname)', $this->customer->firstName, $body);
			$body = str_replace('$(unsubscribe)', $unsSubcribe, $body);
			EmailUtil::sendMail($subject, $body, array($this->customer->email), array(), array(), array(), $regionVo->contactEmail);
		}

		if (isset ($adminEmailTemplates [0])) {
			$customerTypeVo->id = $this->customer->customerTypeId;
			$customerTypeVo = $customerTypeSv->selectByKey($customerTypeVo);
			$customerTypeName = "Retail (US)";
			if (isset ($customerTypeVo) && !AppUtil::isEmptyString($customerTypeVo->name)) {
				$customerTypeName = $customerTypeVo->name;
			}
			$subject = Lang::get($adminEmailTemplates [0]->subject);
			$body = Lang::get($adminEmailTemplates [0]->body);
			$body = str_replace('$(user_id)', $this->customer->id, $body);
			$body = str_replace('$(firstname)', $this->customer->firstName, $body);
			$body = str_replace('$(lastname)', $this->customer->lastName, $body);
			$body = str_replace('$(company)', $this->customer->companyName, $body);
			$body = str_replace('$(email)', $this->customer->email, $body);
			$body = str_replace('$(cust_type)', $customerTypeName, $body);
			EmailUtil::sendMail($subject, $body, array($regionVo->contactEmail), array(), array(), array(), $regionVo->contactEmail);
		}
	}

	private function sendEmailNonSubcribe(){
		$regionVo = ControllerHelper::getRegion();

		$emailTemplateSv = new EmailTemplateService ();

		$emailTemplate = new EmailTemplateExtendVo ();
		$emailTemplate->id = "8372";
		$emailTemplate->sendTo = "customer";
		$emailTemplates = $emailTemplateSv->getEmailTemplateByFilter($emailTemplate);


		$customerTypeVo = new CustomerTypeVo ();
		$customerTypeSv = new CustomerTypeService ();
		$emailTemplate->id = "8368";
		$emailTemplate->sendTo = "admin";
		$adminEmailTemplates = $emailTemplateSv->getEmailTemplateByFilter($emailTemplate);
		if (isset ($emailTemplates [0])) {
			$subject = Lang::get($emailTemplates [0]->subject);
			$body = Lang::get($emailTemplates [0]->body);
			$body = str_replace('$(firstname)', $this->customer->firstName, $body);
			EmailUtil::sendMail($subject, $body, array($this->customer->email), array(), array(), array(), $regionVo->contactEmail);
		}

		if (isset ($adminEmailTemplates [0])) {
			$customerTypeVo->id = $this->customer->customerTypeId;
			$customerTypeVo = $customerTypeSv->selectByKey($customerTypeVo);
			$customerTypeName = "Retail (US)";
			if (isset ($customerTypeVo) && !AppUtil::isEmptyString($customerTypeVo->name)) {
				$customerTypeName = $customerTypeVo->name;
			}
			$subject = Lang::get($adminEmailTemplates [0]->subject);
			$body = Lang::get($adminEmailTemplates [0]->body);
			$body = str_replace('$(user_id)', $this->customer->id, $body);
			$body = str_replace('$(firstname)', $this->customer->firstName, $body);
			$body = str_replace('$(lastname)', $this->customer->lastName, $body);
			$body = str_replace('$(company)', $this->customer->companyName, $body);
			$body = str_replace('$(email)', $this->customer->email, $body);
			$body = str_replace('$(cust_type)', $customerTypeName, $body);
			EmailUtil::sendMail($subject, $body, array($regionVo->contactEmail), array(), array(), array(), $regionVo->contactEmail);
		}
	}

	private function prepareSessionCustomerFrontend(){
		$loginCustomerInfo = new LoginUserInfoMo ();
		$loginCustomerInfo->userGroupId = 0;
		$loginCustomerInfo->userId = $this->customer->id;
		$loginCustomerInfo->userName = $this->customer->email;
		$loginCustomerInfo->firstName = $this->customer->firstName;
		$loginCustomerInfo->lastName = $this->customer->lastName;
		$loginCustomerInfo->userType = "FRONTEND";
		SessionUtil::set(Constants::CUSTOMER_LOGIN_SESSION_NAME, $loginCustomerInfo);
	}

	private function buildCountryList(){
		$countrySv = new CountryService ();
		$this->countryList = $countrySv->getAll();
	}

	private function buildlistState(){
		$stateSv = new StateService ();
		$filterVo = new StateVo ();
		$filterVo->country = AppUtil::defaultIfEmpty($this->address->country, 0);
		$this->listState = $stateSv->selectByFilter($filterVo);
	}

	private function prepareSubcriber(){
		if (1 != $this->subscribe) {
			return null;
		}
		$subscriberVo = new SubscriberVo ();
		$subscriberVo->email = $this->customer->email;
		$subscriberVo->firstName = $this->customer->firstName;
		$subscriberVo->lastName = $this->customer->lastName;
		$subscriberVo->subscribeDate = date("Y-m-d H:i:s");
		return $subscriberVo;
	}

	private function validAddressForm(){
		if (AppUtil::isEmptyString($this->address->address)) {
			$this->addFieldError("address[address]", Lang::get("Address cannot be empty"));
		}/*else{
			$regex="/^[a-z0-9 .\-,]+$/i";
			//$regex="/^\\d+ [a-zA-Z ]+, \\d+ [a-zA-Z ]+, [a-zA-Z ]+$/";
			if(preg_match($regex, $this->address->address)==false){
				$this->addFieldError ( "address[address]", "Please do not include special characters (e.g. #, /, ., @, &, and etc), multiple blanks, and punctuation in your Address." );
			}
		}*/
		if (AppUtil::isEmptyString($this->address->postalCode)) {
			$this->addFieldError("address[postalCode]", Lang::get("Zip code cannot be empty"));
		}
		if (AppUtil::isEmptyString($this->address->city)) {
			$this->addFieldError("address[city]", Lang::get("City cannot be empty"));
		}
		
		if (AppUtil::isEmptyString($this->address->country)) {
			$this->addFieldError("address[country]", Lang::get("Please select a country"));
		}
		
		if (!AppUtil::isEmptyString($this->address->phone)) {
			if (!StringUtil::validPhone($this->address->phone)) {
				$this->addFieldError("address[phone]", Lang::getWithFormat("{0} is not a valid phone number", $this->address->phone));
			}else {
				$this->customer->phone = $this->address->phone;
			}
		} else {
			$this->addFieldError("address[phone]", Lang::get("Phone number cannot be empty"));
		}
		if ($this->address->country == 411 || $this->address->country == 384) {
			if (AppUtil::isEmptyString($this->address->state)) {
				$this->addFieldError("address[state]", Lang::get("Please select a state"));
			} else {
				$addressVo = new AddressVo();
				AppUtil::copyProperties($this->address, $addressVo);
				$addressSv = new AddressService();
				$resultValidUS = $addressSv->upsAddressValidation($addressVo);
				if (!$resultValidUS["status"]) {
					$this->addActionError($resultValidUS["errorMessage"]);
					if ("AmbiguousAddressIndicator" === $resultValidUS["errorCode"]) {
						$this->listAddressSuggest = $resultValidUS["candidateAddress"];
					}
				}
			}
		}
	}

	private function prepareAddressData(){
		StringUtil::clearObject($this->address);
		$this->address->type = 2;
		$this->address->firstName = $this->customer->firstName;
		$this->address->email = $this->customer->email;
		$this->address->lastName = $this->customer->lastName;
		$this->address->phone = AppUtil::defaultIfEmpty($this->customer->phone);
	}

	private function prepareCustomerData(){
		StringUtil::clearObject($this->customer);
		$this->customer->userName = $this->customer->email;
		$this->customer->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		$this->customer->crDate = date('Y-m-d H:i:s');
		$this->customer->mdDate = date('Y-m-d H:i:s');
		$this->customer->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
		$this->customer->accountTypeId = 1; // Customer
		if ($this->address->country == "411") {
			$this->customer->customerTypeId = 1; // Retail (US)
		} else {
			$this->customer->customerTypeId = 6; // Retail (EU)
		}
	}

	private function validCustomerData(){
		$this->validCustomerForm();
		if ($this->hasErrors()) {
			return false;
		}
		$filter = new CustomerVo ();
		$filter->email = $this->customer->email;
		$customerResult = $this->customerSv->selectByFilter($filter);
		if (!empty ($customerResult)) {
			$this->addFieldError("customer[email]", Lang::getWithFormat("{0} has already existed", $this->customer->email));
			return false;
		}
		return true;
	}

	private function validCustomerForm(){
		if (AppUtil::isEmptyString($this->customer->email)) {
			$this->addFieldError("customer[email]", Lang::get("Email cannot be empty"));
		} else if (!ValidateUtil::isEmail($this->customer->email)) {
			$this->addFieldError("customer[email]", Lang::getWithFormat("{0} is not a valid email address", $this->customer->email));
		} else if (!EmailHelper::isValidEmailMx($this->customer->email)) {
			$this->addFieldError("customer[email]", Lang::getWithFormat("{0} is not a valid email address", $this->customer->email));
		}else if(BlockEmailHelper::checkIsBlockEmail($this->customer->email)){
			$this->addFieldError("customer[email]", Lang::get("Your email account has been blocked in our system. Please contact our customer support."));
			return false;
		}
		if (AppUtil::isEmptyString($this->customer->password)) {
			$this->addFieldError("customer[password]", Lang::get("Password cannot be empty"));
		} else if (strlen($this->customer->password) < 3) {
			$this->addFieldError("customer[password]", Lang::get("Your password must contain at least 3 characters"));
		} else if (AppUtil::isEmptyString($this->cPassword)) {
			$this->addFieldError("customer[cPassword]", Lang::get("Confirm password cannot be empty"));
		} else if ($this->customer->password != $this->cPassword) {
			$this->addFieldError("customer[cPassword]", Lang::get("Confirm password does not match"));
		}
		if (AppUtil::isEmptyString($this->customer->firstName)) {
			$this->addFieldError("customer[firstName]", Lang::get("First name cannot be empty"));
		} else if (!StringUtil::validName($this->customer->firstName)) {
			$this->addFieldError("customer[firstName]", Lang::get("First name cannot using special characters"));
		}
		if (AppUtil::isEmptyString($this->customer->lastName)) {
			$this->addFieldError("customer[lastName]", Lang::get("Last name cannot be empty"));
		} elseif (!StringUtil::validName($this->customer->lastName)) {
			$this->addFieldError("customer[lastName]", Lang::get("Last name cannot using special characters"));
		}
	}

	private function getCustomerDetail(){
		$customer = new CustomerVo ();
		$customer->id = $this->loginCustomerInfo->userId;
		$this->customer = $this->customerSv->selectByKey($customer);
	}

	private function getAddressDetail(){
		if (!AppUtil::isEmptyString($this->customer->id)) {
			$addressSv = new AddressService ();
			$addressVo = new AddressVo ();
			$addressVo->groupId = $this->customer->id;
			$addressVo->type = 2;
			$addressVos = $addressSv->selectByFilter($addressVo);
			if (isset ($addressVos [0])) {
				$this->address = $addressVos [0];
			}
		}
	}

	public function changeCountry(){
		$stateSv = new StateService ();
		$state = new StateVo();
		$state->country = AppUtil::defaultIfEmpty($this->address->country, 0);
		$this->listState = $stateSv->selectByFilter($state);
		return "success";
	}
}