<?php

namespace frontend\controllers\subscriber;

use common\helper\EmailHelper;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\base\vo\SubscriberVo;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use common\persistence\extend\vo\SubscriberExtendVo;
use common\services\email_template\EmailTemplateService;
use common\services\subscriber\SubscriberService;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use core\utils\EmailUtil;
use core\utils\ValidateUtil;
use frontend\controllers\ControllerHelper;
use core\utils\ActionUtil;
use frontend\controllers\FrontendController;

class SubscriberController extends FrontendController {
	public $subscriber;
	private $subscriberService;
	private $emailTemplateService;
	public $key;
	public function __construct() {
		parent::__construct ();
		$this->subscriber = new SubscriberVo ();
		$this->subscriberService = new SubscriberService ();
		$this->emailTemplateService = new EmailTemplateService ();
	}
	public function add() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Check subscriber
		$filter = new SubscriberExtendVo ();
		$filter->email = $this->subscriber->email;
		$result = $this->subscriberService->getByFilter ( $filter );
		
		if (empty ( $result ) || count ( $result ) == 0 || (count ( $result ) > 0 && $result [0]->status == "inactive")) {
			// Set some initial values.
			if(count ( $result ) > 0 && $result [0]->status == "inactive"){ // exist subscriber that inactive
				$this->subscriber = $result [0];
				$this->subscriber->status = "active";
				$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
				$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
				$this->subscriberService->update ( $this->subscriber );
				$this->addActionMessage(Lang::get("You were successfully subscribed to our newsletter."));
				$this->sendEmailToSubscriber ();
			}else{//new subscriber
				$this->subscriber->crDate = date ( 'Y-m-d H:i:s' );
				$this->subscriber->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
				$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
				$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
				// Add to the database.
				if (! AppUtil::isEmptyString ( $this->subscriber->email ) & ValidateUtil::isEmail ( $this->subscriber->email )) {
					$this->subscriberService->add ( $this->subscriber );
					$this->addActionMessage(Lang::get("You were successfully subscribed to our newsletter."));
					$this->sendEmailToSubscriber ();
				}
			}
		} else { // exist subscriber that active
			$this->addActionMessage(Lang::get("You were successfully subscribed to our newsletter."));
		}
		return "success";
	}
	public function unsubscribe() {
		$this->subscriber->email = $this->key;
		$result = $this->subscriberService->getByKey ( $this->subscriber );
		$this->subscriber = $result;
		if ($this->subscriber->status == "active") {
			$this->subscriber->status = "inactive";
			$this->subscriber->mdDate = date ( 'Y-m-d H:i:s' );
			$this->subscriber->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
			$this->subscriberService->update ( $this->subscriber );
		}
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->subscriber->email )) {
			$this->addFieldError ( "subscriber[email]", Lang::get ("Email cannot be empty" ));
		} else if (! ValidateUtil::isEmail ( $this->subscriber->email )) {
			$this->addFieldError ( "subscriber[email]", "Email is not valid" );
		} else if (! EmailHelper::isValidEmailMx ( $this->subscriber->email )) {
			$this->addFieldError ( "subscriber[email]", $this->subscriber->email . " is not a valid email address" );
			$this->addFieldError ( "subscriber[emailmx]", $this->subscriber->email . " is not a valid email address" );
		}
		if (AppUtil::isEmptyString ( $this->subscriber->firstName )) {
			$this->addFieldError ( "subscriber[firstName]", "First Name cannot be empty" );
		}
		if (AppUtil::isEmptyString ( $this->subscriber->lastName )) {
			$this->addFieldError ( "subscriber[lastName]", "Last Name cannot be empty" );
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
		
		$fullPath = ActionUtil::getFullPathAlias("home/subscriber/unsubscribe");
		
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