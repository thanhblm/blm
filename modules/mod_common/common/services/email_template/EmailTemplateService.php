<?php

namespace common\services\email_template;

use common\persistence\base\vo\EmailTemplateLangVo;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\extend\dao\EmailTemplateExtendDao;
use common\persistence\extend\dao\EmailTemplateLangExtendDao;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;
use core\utils\AppUtil;

class EmailTemplateService extends BaseService {
	private $emailTemplateDao;
	private $emailTemplateLangDao;

	public function __construct($context = array()){
		parent::__construct($context);
		$this->emailTemplateDao = new EmailTemplateExtendDao ();
		$this->emailTemplateLangDao = new EmailTemplateLangExtendDao ();
	}

	public function getEmailTemplateByKey(EmailTemplateVo $filter){
		return $this->emailTemplateDao->selectByKey($filter);
	}

	public function selectByName(EmailTemplateVo $filter){
		return $this->emailTemplateDao->selectByFilter($filter);
	}

	public function getEmailTemplateByFilter(EmailTemplateExtendVo $filter){
		return $this->emailTemplateDao->getByFilter($filter);
	}

	public function countEmailTemplateByFilter(EmailTemplateExtendVo $filter){
		return $this->emailTemplateDao->getCountByFilter($filter);
	}

	public function updateEmailTemplate(EmailTemplateVo $emailTemplateVo, BaseArray $emailTemplateLangs){
		// Remove extra field to get email template lang list.
		$emailTemplateLangVos = array();
		foreach ($emailTemplateLangs->getArray() as $item) {
			$emailTemplateLangVo = new EmailTemplateLangVo ();
			AppUtil::copyProperties($item, $emailTemplateLangVo);
			$emailTemplateLangVos [] = $emailTemplateLangVo;
		}
		$sqlClient = new SqlMapClient ();
		$sqlClient->startTransaction();
		$emailTemplateDao = new EmailTemplateExtendDao ($this->context, $sqlClient);
		$emailTemplateLangDao = new EmailTemplateLangExtendDao ($this->context, $sqlClient);
		try {
			// Add to email template table.
			$emailTemplateDao->updateDynamicByKey($emailTemplateVo);
			// Remove all email template lang of this email template
			// and insert new email template lang.
			foreach ($emailTemplateLangVos as $lang) {
				// Delete email template lang.
				$emailTemplateLangDao->deleteByKey($lang);
				// Add new email template lang.
				$emailTemplateLangDao->insertDynamic($lang);
			}
			$sqlClient->endTransaction();
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
	}

	public function deleteEmailTemplate(EmailTemplateVo $emailTemplateVo){
		return $this->emailTemplateDao->deleteByKey($emailTemplateVo);
	}

	public function createEmailTemplate(EmailTemplateVo $emailTemplateVo, BaseArray $emailTemplateLangs){
		// Remove extra field to get email template lang list.
		$emailTemplateLangVos = array();
		foreach ($emailTemplateLangs->getArray() as $item) {
			$emailTemplateLangVo = new EmailTemplateLangVo ();
			AppUtil::copyProperties($item, $emailTemplateLangVo);
			$emailTemplateLangVos [] = $emailTemplateLangVo;
		}
		$sqlClient = new SqlMapClient ();
		$sqlClient->startTransaction();
		$emailTemplateDao = new EmailTemplateExtendDao ($this->context, $sqlClient);
		$emailTemplateLangDao = new EmailTemplateLangExtendDao ($this->context, $sqlClient);
		try {
			// Add to email template table.
			$emailTemplateId = $emailTemplateDao->insertDynamic($emailTemplateVo);
			// Add email template langs.
			foreach ($emailTemplateLangVos as $lang) {
				$lang->emailTemplateId = $emailTemplateId;
				$emailTemplateLangDao->insertDynamic($lang);
			}
			$sqlClient->endTransaction();
		} catch (\Exception $e) {
			$sqlClient->rollback();
			throw $e;
		}
		return $emailTemplateId;
	}

	public function getLangsByTemplateId(EmailTemplateLangExtendVo $filter){
		return $this->emailTemplateLangDao->getLangsByTemplateId($filter);
	}

	public function getEmailTemplateLangById(EmailTemplateLangExtendVo $filter){
		return $this->emailTemplateLangDao->getEmailTemplateLangById($filter);
	}

	public function getEmailTemplate2Send(EmailTemplateLangExtendVo $filter){
		return $this->emailTemplateLangDao->getEmailTemplate2Send($filter);
	}
}