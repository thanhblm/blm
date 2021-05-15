<?php

namespace common\persistence\extend\dao;

use common\persistence\base\vo\SeoInfoLangVo;
use core\database\BaseDao;
use core\database\SqlMapClient;
use common\persistence\base\vo\PageVo;
use common\persistence\extend\mapping\PageExtendMapping;
use common\persistence\extend\vo\PageExtendVo;
use common\persistence\base\vo\PageLangVo;

class PageExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getGridListOfPage(PageVo $pageVo){
		return $this->executeSelectList(PageExtendMapping::class, 'getGridListOfPage', $pageVo);
	}

	public function getWidgetListOfPage(PageVo $pageVo){
		return $this->executeSelectList(PageExtendMapping::class, 'getWidgetListOfPage', $pageVo);
	}

	/*****************************
	 * FILTER
	 *****************************/
	public function getPageByFilter(PageExtendVo $filter = null){
		$result = $this->executeSelectList(PageExtendMapping::class, 'getPageByFilter', $filter);
		return $result;
	}

	public function getCountByFilter(PageExtendVo $filter = null){
		$result = $this->executeCount(PageExtendMapping::class, 'getCountByFilter', $filter);
		return $result;
	}

	public function deletePageLang(PageLangVo $filter = null){
		$result = $this->executeDelete(PageExtendMapping::class, 'deletePageLang', $filter);
		return $result;
	}

	public function getPageInfoBySeoUrl(SeoInfoLangVo $filter){
		$result = $this->executeSelectOne(PageExtendMapping::class, "getPageInfoBySeoUrl", $filter);
		return $result;
	}
}