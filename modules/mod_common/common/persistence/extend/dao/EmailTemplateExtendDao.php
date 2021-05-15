<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\EmailTemplateBaseDao;
use common\persistence\extend\mapping\EmailTemplateExtendMapping;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use core\database\SqlMapClient;

class EmailTemplateExtendDao extends EmailTemplateBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getByFilter(EmailTemplateExtendVo $filter = null) {
		$result = $this->executeSelectList ( EmailTemplateExtendMapping::class, 'getByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(EmailTemplateExtendVo $filter = null) {
		$result = $this->executeCount ( EmailTemplateExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
}

