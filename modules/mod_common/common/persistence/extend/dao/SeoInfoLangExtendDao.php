<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\mapping\SeoInfoLangExtendMapping;
use common\persistence\extend\vo\SeoInfoLangExtendVo;
use core\database\SqlMapClient;

class SeoInfoLangExtendDao extends SeoInfoLangBaseDao{
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null){
		parent::__construct($addInfo, $sqlMapClient);
	}

	public function getLangsByKey(SeoInfoLangExtendVo $filter = null){
		$result = $this->executeSelectList(SeoInfoLangExtendMapping::class, 'getSeoInfoLangsByKey', $filter);
		return $result;
	}

	public function deleteByFilter(SeoInfoLangVo $filter = null){
		$result = $this->executeDelete(SeoInfoLangExtendMapping::class, 'deleteByFilter', $filter);
		return $result;
	}

	public function getSeoInfoLangByCategory(SeoInfoLangVo $filter){
		return $this->executeSelectList(SeoInfoLangExtendMapping::class, "getSeoInfoLangByCategory", $filter);
	}

	public function getSeoInfoLangByCategoryBlog(SeoInfoLangVo $filter){
		return $this->executeSelectList(SeoInfoLangExtendMapping::class, "getSeoInfoLangByCategoryBlog", $filter);
	}

	public function getSeoInfoLangByProduct(SeoInfoLangVo $filter){
		return $this->executeSelectList(SeoInfoLangExtendMapping::class, "getSeoInfoLangByProduct", $filter);
	}

	public function getSeoInfoLangByBlog(SeoInfoLangVo $filter){
		return $this->executeSelectList(SeoInfoLangExtendMapping::class, "getSeoInfoLangByBlog", $filter);
	}
}