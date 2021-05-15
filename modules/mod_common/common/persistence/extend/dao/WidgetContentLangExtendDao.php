<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\WidgetContentLangBaseDao;
use common\persistence\extend\mapping\WidgetContentLangExtendMapping;
use core\database\SqlMapClient;
use common\persistence\extend\vo\WidgetContentLangExtendVo;

class WidgetContentLangExtendDao extends WidgetContentLangBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function getLangsByWidgetContentId(WidgetContentLangExtendVo $filter = null) {
		$result = $this->executeSelectList ( WidgetContentLangExtendMapping::class, 'getLangsByWidgetContentId', $filter );
		return $result;
	}
}