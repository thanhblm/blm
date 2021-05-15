<?php

namespace backend\controllers\email_template;

use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use common\services\email_template\EmailTemplateService;
use core\BaseArray;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\PagingController;
use core\utils\AppUtil;
use common\services\language\LanguageService;

class EmailTemplateController extends PagingController {
	public $emailTemplates;
	public $emailTemplate;
	public $id;
	public $languageList;
	public $emailTemplateLanguages;
	private $emailTemplateService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new EmailTemplateExtendVo ();
		$this->emailTemplate = new EmailTemplateVo ();
		$this->emailTemplates = new Paging ();
		$this->emailTemplateService = new EmailTemplateService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Email Templates Management";
		$this->languageList = $this->getSupportLanguages ();
		$this->emailTemplateLanguages = new BaseArray ( EmailTemplateLangExtendVo::class );
	}
	
	private function getSupportLanguages() {
		$languageService = new LanguageService();
		return $languageService->getAllLanguages();
	}
	
	public function listView() {
		$this->getEmailTemplates ();
		return "success";
	}
	public function search() {
		$this->getEmailTemplates ();
		return "success";
	}
	public function editView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for editing" );
		}
		$this->getEmailTemplate ();
		$this->getEmailTemplateLanguages ();
		return "success";
	}
	public function edit() {
		$this->validate ( false );
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->emailTemplate->mdDate = date ( 'Y-m-d H:i:s' );
		$this->emailTemplate->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->emailTemplateService->updateEmailTemplate ( $this->emailTemplate, $this->emailTemplateLanguages );
		$this->addActionMessage ( "The email template updated successfully" );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for cloning" );
		}
		$this->getEmailTemplate ();
		$this->getEmailTemplateLanguages ();
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->emailTemplate->crDate = date ( 'Y-m-d H:i:s' );
		$this->emailTemplate->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->emailTemplate->mdDate = date ( 'Y-m-d H:i:s' );
		$this->emailTemplate->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->emailTemplateService->createEmailTemplate ( $this->emailTemplate, $this->emailTemplateLanguages );
		$this->addActionMessage ( "The email template cloned successfully" );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Load system setting group.
		$filter = new EmailTemplateVo ();
		$filter->id = $this->id;
		$this->emailTemplate = $this->emailTemplateService->getEmailTemplateByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( "No id for deleting" );
		}
		// Delete the system setting group.
		$filter = new EmailTemplateVo ();
		$filter->id = $this->id;
		$this->emailTemplateService->deleteEmailTemplate ( $filter );
		$this->addActionMessage ( "The email template deleted successfully" );
		return "success";
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->emailTemplate->title )) {
			$this->addFieldError ( "emailTemplate[title]", "Title is required" );
		}
		if (AppUtil::isEmptyString ( $this->emailTemplate->sendTo )) {
			$this->addFieldError ( "emailTemplate[sendTo]", "Send to is required" );
		}
		if (AppUtil::isEmptyString ( $this->emailTemplate->subject )) {
			$this->addFieldError ( "emailTemplate[subject]", "Subject is required" );
		}
		if (AppUtil::isEmptyString ( $this->emailTemplate->body )) {
			$this->addFieldError ( "emailTemplate[body]", "Body is required" );
		}
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if (!AppUtil::isEmptyString ( $this->emailTemplate->from )) {
			if(preg_match($regex, $this->emailTemplate->from)==false){
				$this->addFieldError ( "emailTemplate[from]", "From is not email format" );
			}
		}
		if (!AppUtil::isEmptyString ( $this->emailTemplate->to )) {
			if(preg_match($regex, $this->emailTemplate->to)==false){
				$this->addFieldError ( "emailTemplate[to]", "To is not email format" );
			}
		}
		// Validation for multi language.
		/*
		 * if (! empty ( $this->emailTemplateLanguages ) && ! empty ( $this->emailTemplateLanguages->getArray () )) {
		 * $index = 0;
		 * foreach ( $this->emailTemplateLanguages->getArray () as $lang ) {
		 * $fieldName = "emailTemplateLanguages[" . $index . "]";
		 * if (AppUtil::isEmptyString ( $lang->title )) {
		 * $this->addFieldError ( $fieldName . "[title]", "Title is required" );
		 * }
		 * if (AppUtil::isEmptyString ( $lang->subject )) {
		 * $this->addFieldError ( $fieldName . "[subject]", "Subject is required" );
		 * }
		 * if (AppUtil::isEmptyString ( $lang->body )) {
		 * $this->addFieldError ( $fieldName . "[body]", "Body is required" );
		 * }
		 * $index ++;
		 * }
		 * }
		 */
	}
	protected function getEmailTemplates() {
		$filter = $this->buildFilter ();
		// Get total records of emailTemplates.
		$count = $this->emailTemplateService->countEmailTemplateByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get emailTemplates.
		$emailTemplateVos = $this->emailTemplateService->getEmailTemplateByFilter ( $filter );
		$paging->records = $emailTemplateVos;
		$this->emailTemplates = $paging;
	}
	protected function getEmailTemplate() {
		$filter = new EmailTemplateVo ();
		$filter->id = $this->id;
		$this->emailTemplate = $this->emailTemplateService->getEmailTemplateByKey ( $filter );
	}
	protected function getEmailTemplateLanguages() {
		$filter = new EmailTemplateLangExtendVo ();
		if (AppUtil::isEmptyString ( $this->id )) {
			$this->id = - 1;
		}
		$filter->emailTemplateId = $this->id;
		$emailTemplateLangVos = $this->emailTemplateService->getLangsByTemplateId ( $filter );
		$result = new BaseArray ( EmailTemplateLangExtendVo::class );
		foreach ( $emailTemplateLangVos as $emailTemplateLangVo ) {
			$emailTemplateLangVo->emailTemplateId = $this->id;
			$result->add ( $emailTemplateLangVo );
		}
		$this->emailTemplateLanguages = $result;
	}
	protected function buildFilter() {
		return $this->buildBaseFilter ( "id asc" );
	}
}