<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\EmailTemplateLangBaseDao;
use common\persistence\extend\mapping\EmailTemplateLangExtendMapping;
use core\database\SqlMapClient;
use common\persistence\extend\vo\EmailTemplateLangExtendVo;

class EmailTemplateLangExtendDao extends EmailTemplateLangBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getLangsByTemplateId(EmailTemplateLangExtendVo $filter = null){
		$result = $this->executeSelectList(EmailTemplateLangExtendMapping::class, 'getLangsByTemplateId', $filter);
		return $result;
	}

	public function getEmailTemplateLangById(EmailTemplateLangExtendVo $filter){
		return $this->executeSelectOne(EmailTemplateLangExtendMapping::class, 'getEmailTemplateLangById', $filter);;
	}

	public function getEmailTemplate2Send(EmailTemplateLangExtendVo $filter){
		return $this->executeSelectOne(EmailTemplateLangExtendMapping::class, 'getEmailTemplate2Send', $filter);;
	}
}

