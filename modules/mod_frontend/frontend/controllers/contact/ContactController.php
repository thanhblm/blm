<?php

namespace frontend\controllers\contact;

use common\persistence\base\vo\ContactVo;
use common\persistence\base\vo\CountryVo;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use common\services\contact\ContactService;
use common\services\country\CountryService;
use common\services\email_template\EmailTemplateService;
use core\Lang;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\ValidateUtil;
use frontend\controllers\ControllerHelper;
use frontend\controllers\FrontendController;
use common\helper\EmailHelper;

class ContactController extends FrontendController {
	private $countryService;
	private $contactService;
	private $emailTemplateService;
	public $countryList;
	public $contact;
	public $seoInfoVo;

	public function __construct(){
		parent::__construct();
		$this->contact = new ContactVo ();
		$this->contactService = new ContactService ();
		$this->countryService = new CountryService ();
		$this->seoInfoVo = new SeoInfoLangVo ();
		$this->emailTemplateService = new EmailTemplateService ();
	}

	public function show(){
		$this->seoInfoVo->title = Lang::get("Contact Us | Etoviet.vn");
		$this->seoInfoVo->keywords = Lang::get("Contact Us");
		$this->seoInfoVo->description = Lang::get("Our customer support team are here to help you. If you have any questions about our services, feel free to call us or send us a message via email");
		$this->getCountryList();
		return "success";
	}

	public function add(){
		$this->validate();
		if ($this->hasErrors()) {
			return "success";
		}
		$this->contact->status = "pending";
		$this->contact->crDate = date('Y-m-d H:i:s');
		$this->contactService->add($this->contact);
		$this->sendContactEmail();
		$this->contact = new ContactVo ();
		$this->addActionMessage(Lang::get("Thông tin liên hệ của bạn đã được gửi đi thành công!"));
		return "success";
	}

	protected function getCountryList(){
		$this->countryList = $this->countryService->getAll();
	}

	protected function validate($isAdding = true){
		if (AppUtil::isEmptyString($this->contact->fullName)) {
			$this->addFieldError("contact[fullName]", Lang::get("Fullname cannot be empty"));
		}
		if (AppUtil::isEmptyString($this->contact->email)) {
			$this->addFieldError("contact[email]", Lang::get ("Email cannot be empty"));
		} else if (!ValidateUtil::isEmail($this->contact->email)) {
			$this->addFieldError("contact[email]", "Email is not valid");
		}
		if (AppUtil::isEmptyString($this->contact->phone)) {
			$this->addFieldError("contact[phone]", Lang::get("Phone cannot be empty"));
		}
		if (AppUtil::isEmptyString($this->contact->message)) {
			$this->addFieldError("contact[message]", Lang::get("Message cannot be empty"));
		}
	}

	protected function sendContactEmail(){
		// get email template
		$emailTemplateLangVo = new EmailTemplateLangExtendVo ();
		$emailTemplateLangVo->emailTemplateId = 8370;
		$emailTemplateLangVo->languageCode = ControllerHelper::getLangCode();
		$emailTemplate = $this->emailTemplateService->getEmailTemplateLangById($emailTemplateLangVo);
		if (count($emailTemplate) == 0 || (count($emailTemplate) > 0) && AppUtil::isEmptyString($emailTemplate->body)) {
			$emailTemplateVo = new EmailTemplateVo ();
			$emailTemplateVo->id = 8370;
			$emailTemplate = $this->emailTemplateService->getEmailTemplateByKey($emailTemplateVo);
		}
		// end get email template

		// prepare email data
		$countryVo = new CountryVo ();
		$countryVo->iso2 = $this->contact->countryCode;
		$country = $this->countryService->selectByFilter($countryVo);

		$fromName = "";
		$fromAddress = $this->contact->email;

		$toEmail = array(
			ControllerHelper::getRegion()->contactEmail
		);

		$cc = array();
		if (!AppUtil::isEmptyString($emailTemplate->cc)) {
			$cc = explode(",", $emailTemplate->cc);
		}

		$bcc = array();
		if (!AppUtil::isEmptyString($emailTemplate->bcc)) {
			$bcc = explode(",", $emailTemplate->bcc);
		}

		$subject = $emailTemplate->subject;

		$bodyTemplate = $emailTemplate->body;
		$body = str_replace([
			"$(name)",
			"$(email)",
			"$(phone)",
			"$(message)"
		], [
			$this->contact->fullName,
			$this->contact->email,
			$this->contact->phone,
			$this->contact->message
		], $bodyTemplate);

		$attachment = array();

		// send email
		EmailUtil::sendMail($subject, $body, $toEmail, $cc, $bcc, $attachment, $fromAddress, $fromName);
	}
}