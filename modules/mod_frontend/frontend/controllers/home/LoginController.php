<?php

namespace frontend\controllers\home;

use common\helper\EmailHelper;
use common\model\LoginUserInfoMo;
use common\persistence\base\vo\AddressVo;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\CustomerChangePasswordVo;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use common\services\address\StateService;
use common\services\country\CountryService;
use common\services\customer\CustomerService;
use common\services\email_template\EmailTemplateService;
use common\utils\StringUtil;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use frontend\controllers\FrontendController;
use frontend\service\BlockEmailHelper;

/**
 *
 * @author TANDT
 *
 */
class LoginController extends FrontendController {
	public $customer;
	public $cPassword;
	public $codeComfirmPw;
	public $countryList;
	public $stateList;
	public $address;
	protected $customerSv;
	public $isChangeLanguage;
	public $activeTab;

	public function __construct(){
		parent::__construct();
		$this->customer = new CustomerVo ();
		$this->customerSv = new CustomerService ();
		$this->address = new AddressVo ();
		$this->isChangeLanguage = false;
	}

	public function loginView(){
		$this->buildCountryList();
		return "success";
	}

	public function login(){
		$this->checkLogin();
		if ($this->hasErrors()) {
			return "success";
		}
		$this->prepareSessionCustomerFrontend();
		$context = new ContextBase ();
		WorkflowManager::Instance()->execute("shopping_cart_update", $context);
		return "success";
	}
	
	public function guestLogin(){
		$this->prepareSessionGuestFrontend();
		$context = new ContextBase ();
		WorkflowManager::Instance()->execute("shopping_cart_update", $context);
		return "success";
	}

	public function logoutView(){
		return "success";
	}

	public function logout(){
		$loginCustomerInfo = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
		if ($loginCustomerInfo !== null) {
			if ($loginCustomerInfo->isSaleRepChild == true) {
				$filter = new CustomerVo ();
				$filter->id = $loginCustomerInfo->saleRepId;
				$saleRepParentDetail = $this->customerSv->selectByKey($filter);
				$loginCustomerInfo->isSaleRepChild = false;
				$loginCustomerInfo->saleRepChildName = null;
				$loginCustomerInfo->saleRepId = $saleRepParentDetail->saleRepId; // id of saleRep parent of parent (not use)
				$loginCustomerInfo->userId = $saleRepParentDetail->id; // id of saleRep parent
				SessionUtil::set(Constants::CUSTOMER_LOGIN_SESSION_NAME, $loginCustomerInfo);
				$this->clearSessionCart();
			} else {
				SessionUtil::remove(Constants::CUSTOMER_LOGIN_SESSION_NAME);
				SessionUtil::remove("order");
			}

			if (!is_null(SessionUtil::get("orderSurcharge")) && !is_null(SessionUtil::get("orderSurcharge")->getArray())) {
				foreach (SessionUtil::get("orderSurcharge")->getArray() as $orderSurcharge) {
					if ("price_level" == $orderSurcharge->surchargeType) {
						if (!is_null(SessionUtil::get("listOrderProduct")) && !is_null(SessionUtil::get("listOrderProduct")->getArray())) {
							foreach (SessionUtil::get("listOrderProduct")->getArray() as $orderProduct) {
								$orderProduct->price = $orderProduct->basePrice;
							}
						}
					}
				}
				$context = new ContextBase ();
				WorkflowManager::Instance()->execute("shopping_cart_update", $context);
			}
		}

		return "success";
	}

	public function rePassword(){
		$seoInfo = new SeoInfoLangVo();
		$seoInfo->title = Lang::get("Password Reset Request");
		$this->seoInfoVo = $seoInfo;
		if (RequestUtil::isPost()) {
			$this->validEmailRecoverPassword();
			if (!$this->hasErrors()) {
				if ($this->doSendEmailConfirm() != 0) {
					$customerChangePassVo = new CustomerChangePasswordVo ();
					$customerChangePassVo->customerId = $this->customer->id;
					$listCode = $this->customerSv->customerChangePassSelectByFilter($customerChangePassVo);
					foreach ($listCode as $code) {
						$datas = explode("@@", StringUtil::decrypt($code->code));
						$date = $datas [2];
						$today = strtotime(date("Y-m-d H:i:s"));
						$seconds = $today - strtotime($date);
						if ($seconds > 24 * 3600) {
							$customerChangePassVo = new CustomerChangePasswordVo ();
							$customerChangePassVo->id = $code->id;
							$this->customerSv->delCustomerChangePass($customerChangePassVo);
						}
					}
					$customerChangePassVo = new CustomerChangePasswordVo ();
					$customerChangePassVo->customerId = $this->customer->id;
					$customerChangePassVo->code = $this->codeComfirmPw;
					$this->customerSv->customerChangePassInstall($customerChangePassVo);
					$this->addActionMessage(Lang::getWithFormat("Email sent. Please check your inbox.", $this->customer->email));
				} else {
					$this->addActionError(Lang::get("Has error with email server. Please try agail later!"));
				}
			}
		}
		return "success";
	}

	public function confirmChangePw(){
		$seoInfo = new SeoInfoLangVo();
		$seoInfo->title = Lang::get("Confirm Password Reset");
		$this->seoInfoVo = $seoInfo;
		$this->validCode();
		if ($this->hasErrors()) {
			return "error";
		}
		return "success";
	}

	public function changePassword(){
        $seoInfo = new SeoInfoLangVo();
        $seoInfo->title = Lang::get("Confirm Password Reset");
        $this->seoInfoVo = $seoInfo;
		$regionVo = ControllerHelper::getRegion();
		$this->validCode();
		$this->validPassword();
		if ($this->hasErrors()) {
			return "error";
		}
		$datas = explode("@@", StringUtil::decrypt($this->codeComfirmPw));
		$id = $datas [1];
		$this->customer->id = $id;
		$customerVo = new CustomerVo();
		$customerVo->id = $id;
		$customerVo = $this->customerSv->selectByKey($customerVo);
		$encryptedType = ApplicationConfig::get("encryption.type.default");
		$customerPassword = AppUtil::defaultIfEmpty($this->customer->password);
		if (!AppUtil::isEmptyString($encryptedType)) {
			$this->customer->password = "{" . $encryptedType . "}" . ($encryptedType ($this->customer->password));
		} else {
			$this->customer->password = $this->customer->password;
		}
		$this->customer->mdDate = date('Y-m-d H:i:s');
		$this->customer->mdBy = $id;
		$this->customerSv->rePassword($this->customer);

		$emailTemplate = new EmailTemplateExtendVo ();
		$emailTemplate->id = "8";
		$emailTemplateSv = new EmailTemplateService ();
		$emailTemplates = $emailTemplateSv->getEmailTemplateByFilter($emailTemplate);
		if (isset($customerVo)) {
			if (isset ($emailTemplates [0])) {
				$email = $customerVo->email;
				$subject = Lang::get($emailTemplates [0]->subject);
				$body = Lang::get($emailTemplates [0]->body);
				$body = str_replace('$(firstname)', $customerVo->firstName, $body);
				$body = str_replace('$(password)', $customerPassword, $body);
				//EmailUtil::sendMail ( $subject, $body, array($email), array(), array(), array(), $regionVo->contactEmail);
			}
		}

		$this->addActionMessage(Lang::get("Password is changed successfully!"));
		return "success";
	}

	private function validPassword(){
		if (AppUtil::isEmptyString($this->customer->password)) {
			$this->addFieldError("customer[password]", Lang::get("New password cannot be empty"));
		} else if (strlen($this->customer->password) < 6) {
			$this->addFieldError("customer[password]", Lang::get("Your password must contain at least 6 characters"));
		} else if ($this->customer->password !== $this->cPassword) {
			$this->addFieldError("cPassword", Lang::get("Confirm password doesn't match"));
		}
	}

	private function validCode(){
		try {
			if (!is_null($this->codeComfirmPw)) {
				$datas = explode("@@", StringUtil::decrypt($this->codeComfirmPw));
				$email = $datas [0];
				$id = $datas [1];
				$date = $datas [2];
				$customerVo = new CustomerVo ();
				$customerVo->id = $id;
				$customerVo = $this->customerSv->selectByKey($customerVo);

				$customerChangePassVo = new CustomerChangePasswordVo ();
				$customerChangePassVo->code = $this->codeComfirmPw;

				$customerChangePassVo = $this->customerSv->customerChangePassSelectByFilter($customerChangePassVo);
				if (count($customerChangePassVo) == 0) {
					$this->addActionError(Lang::get("This code not found. Please reset again"));
				}
				if (is_null($customerVo)) {
					$this->addActionError(Lang::get("This code not found. Please reset again"));
				} elseif ($customerVo->email != $email) {
					$this->addActionError(Lang::get("This code not found. Please reset again"));
				} else {
					$today = strtotime(date("Y-m-d H:i:s"));
					$seconds = $today - strtotime($date);
					if ($seconds > 24 * 3600) {
						$this->addActionError(Lang::get("This code had expires! Please reset again"));
					}
				}
			} else {
				$this->addActionError(Lang::get("Password reset code cannot be empty. Please try again"));
			}
		} catch (Exception $e) {
			$this->addActionError(Lang::get("This code not valid! Please reset again"));
		}
	}

	private function buildLinkRecover(){
		$urlConfirm = ActionUtil::getFullPathAlias("home/customer/password/reminder/confirm");
		$code = $this->customer->email . "@@" . $this->customer->id . "@@" . date('Y-m-d H:i:s');
		$codeEncrypt = StringUtil::encrypt($code);
		$this->codeComfirmPw = $codeEncrypt;
		return $urlConfirm . "?codeComfirmPw=" . urlencode($codeEncrypt);
	}

	private function doSendEmailConfirm(){
		$regionVo = ControllerHelper::getRegion();
		$subject = Lang::getWithFormat("{0}: Password Reset", "Endoca");
		$email = array(
			$this->customer->email
		);
		$body = "Hello " . $this->customer->firstName . ",
		<br/>Someone (You) requested a password reset for your account.
		<br/>Your link confirm is: <a href='" . $this->buildLinkRecover() . "'>Click here</a>
		<br/>Please click this link to confirm reset.";

		$emailTemplateVo = new EmailTemplateExtendVo();
		$emailTemplateVo->id = "8371";
		$emailTemplateVo->sendTo = "customer";
		$emailTemplateSv = new EmailTemplateService();
		$emailTemplateVos = $emailTemplateSv->getEmailTemplateByFilter($emailTemplateVo);

		if (isset($emailTemplateVos[0])) {
			$subject = Lang::get($emailTemplateVos[0]->subject);
			$body = Lang::get($emailTemplateVos[0]->body);
			$body = str_replace('$(firstname)', $this->customer->firstName, $body);
			$body = str_replace('$(linkconfirm)', "<a href='" . $this->buildLinkRecover() . "'>Click here</a>", $body);
		}

		return EmailUtil::sendMail($subject, $body, $email, array(), array(), array(), $regionVo->contactEmail);
	}

	private function validEmailRecoverPassword(){
		if (AppUtil::isEmptyString($this->customer->email)) {
			$this->addFieldError("customer[email]", Lang::get("Email cannot be empty"));
		} else if (filter_var($this->customer->email, FILTER_VALIDATE_EMAIL) === false) {
			$this->addFieldError("customer[email]", Lang::getWithFormat("{0} is not a valid email address", $this->customer->email));
		} else if (!EmailHelper::isValidEmailMx($this->customer->email)) {
			$this->addFieldError("customer[email]", Lang::getWithFormat("{0} is not a valid email address", $this->customer->email));
		} else {
			$customer = new CustomerVo ();
			$customer->email = $this->customer->email;
			$customers = $this->customerSv->selectByFilter($customer);
			if (!isset ($customers [0])) {
				$this->addFieldError("customer[email]", Lang::getWithFormat("Not found email {0} in us system.", $this->customer->email));
			} elseif ('3' == $customers [0]->accountTypeId) {
				$this->addFieldError("customer[email]", Lang::getWithFormat("{0} is email for Account type Affiliates, we are unsupport!.", $this->customer->email));
			} else {
				$this->customer = $customers [0];
				$customerChangePassVo = new CustomerChangePasswordVo ();
				$customerChangePassVo->customerId = $this->customer->id;
				$listCode = $this->customerSv->customerChangePassSelectByFilter($customerChangePassVo);
				if (count($listCode) > 5) {
					$this->addFieldError("customer[email]", Lang::getWithFormat("{0} has request maximun 5 email confirm, please check email inbox or junk", $this->customer->email));
				}
			}
		}
	}

	protected function prepareSessionCustomerFrontend(){
		$loginCustomerInfo = new LoginUserInfoMo ();
		$loginCustomerInfo->userGroupId = 0;
		$loginCustomerInfo->userId = $this->customer->id;
		$loginCustomerInfo->userName = $this->customer->email;
		$loginCustomerInfo->firstName = $this->customer->firstName;
		$loginCustomerInfo->lastName = $this->customer->lastName;
		$loginCustomerInfo->accountTypeId = $this->customer->accountTypeId;
		$loginCustomerInfo->saleRepId = $this->customer->saleRepId;
		$loginCustomerInfo->userType = "FRONTEND";
		$loginCustomerInfo->isSaleRepChild = false;
		SessionUtil::set(Constants::CUSTOMER_LOGIN_SESSION_NAME, $loginCustomerInfo);
		// Get language code of the customer.
		$languageCode = $this->customer->languageCode;
		$languageCode = AppUtil::isEmptyString($languageCode) ? ApplicationConfig::get("language.default.code") : $languageCode;
		$languageCode = AppUtil::isEmptyString($languageCode) ? "en" : $languageCode;
		if ($languageCode !== SessionUtil::get("language.default.code")) {
			$this->isChangeLanguage = true;
		}
		SessionUtil::set("language.default.code", $languageCode);
		$this->addExtraData("isChangeLanguage", $this->isChangeLanguage);
		$this->addExtraData("languageCode", $languageCode);
	}

	protected function prepareSessionGuestFrontend(){
		$loginCustomerInfo = new LoginUserInfoMo ();
		$loginCustomerInfo->userGroupId = 0;
		$loginCustomerInfo->userId = 0;
		$loginCustomerInfo->userName = "";
		$loginCustomerInfo->firstName = "Guest";
		$loginCustomerInfo->lastName = "";
		$loginCustomerInfo->accountTypeId = 1;
		$loginCustomerInfo->saleRepId = "";
		$loginCustomerInfo->userType = "FRONTEND";
		$loginCustomerInfo->isSaleRepChild = false;
		SessionUtil::set(Constants::CUSTOMER_LOGIN_SESSION_NAME, $loginCustomerInfo);
		// Get language code of the customer.
		$languageCode = $this->languageCode;
		$languageCode = AppUtil::isEmptyString($languageCode) ? ApplicationConfig::get("language.default.code") : $languageCode;
		$languageCode = AppUtil::isEmptyString($languageCode) ? "en" : $languageCode;
		if ($languageCode !== SessionUtil::get("language.default.code")) {
			$this->isChangeLanguage = true;
		}
		SessionUtil::set("language.default.code", $languageCode);
		$this->addExtraData("isChangeLanguage", $this->isChangeLanguage);
		$this->addExtraData("languageCode", $languageCode);
	}
	
	protected function checkLogin(){
		$this->validateLogin();
		if ($this->hasErrors()) {
			return false;
		}
		// Check login by email.
		$customer = new CustomerVo ();
		$customer->email = $this->customer->email;
		// $customer->password = sha1 ( $this->customer->password );
		$customerVos = $this->customerSv->selectByFilter($customer);
		if (!empty ($customerVos)) {
			$customerVo = $customerVos [0];
		} else {
			$customerVo = null;
		}

		$encryptType = "";
		$password = "";
		if (!is_null($customerVo) && !AppUtil::isEmptyString($customerVo->password)) {
			foreach (ApplicationConfig::get("encryption.type.list") as $value) {
				if (AppUtil::startsWith($customerVo->password, "{" . $value . "}")) {
					$encryptType = $value;
				}
			}
			if (!AppUtil::isEmptyString($encryptType)) {
				$password = "{" . $encryptType . "}" . $encryptType ($this->customer->password);
			} else {
				$password = $this->customer->password;
			}
		}

		if (is_null($customerVo) || $customerVo->password !== $password) {
			$this->addActionError(Lang::get("Invalid Email or Password"));
			return false;
		}

		if (3 === $customerVo->accountTypeId) {
			$this->addActionError(Lang::get("Account type Affiliates is not permission"));
			return false;
		}
		$this->customer = $customerVo;
		return true;
	}

	protected function validateLogin(){
		if (AppUtil::isEmptyString($this->customer->email)) {
			$this->addFieldError("customer[email]", Lang::get("Email cannot be empty"));
		}else if (BlockEmailHelper::checkIsBlockEmail ( $this->customer->email )) {
			$this->addFieldError ( "customer[email]", Lang::get ( "Your email account has been blocked in our system. Please contact our customer support." ) );
		}
		if (AppUtil::isEmptyString($this->customer->password)) {
			$this->addFieldError("customer[password]", Lang::get("Password cannot be empty"));
		}
	}

	protected function buildCountryList(){
		$countrySv = new CountryService ();
		$this->countryList = $countrySv->selectByFilter(new CountryVo ());
	}

	protected function buildStateList(){
		$stateSv = new StateService ();
		$filterVo = new StateVo ();
		$filterVo->country = AppUtil::defaultIfEmpty($this->address->country, 0);
		$this->stateList = $stateSv->selectByFilter($filterVo);
	}

	private function clearSessionCart(){
		SessionUtil::remove("order");
		SessionUtil::remove("orderChargeInfo");
		SessionUtil::remove("orderSurcharge");
		SessionUtil::remove("listOrderProduct");
		SessionUtil::remove("sessionId");
	}
}