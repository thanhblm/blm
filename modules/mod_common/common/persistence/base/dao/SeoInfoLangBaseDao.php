<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\base\mapping\SeoInfoLangMapping;

class SeoInfoLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeSelectOne ( SeoInfoLangMapping::class, 'selectByKey', $seoInfoLangVo );
		return $result;
	}
	final public function selectAll(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeSelectList ( SeoInfoLangMapping::class, 'selectAll', $seoInfoLangVo );
		return $result;
	}
	final public function selectByFilter(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeSelectList ( SeoInfoLangMapping::class, 'selectByFilter', $seoInfoLangVo );
		return $result;
	}
	final public function countByFilter(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeCount ( SeoInfoLangMapping::class, 'countByFilter', $seoInfoLangVo );
		return $result;
	}
	final public function insertDynamic(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeInsert ( SeoInfoLangMapping::class, 'insertDynamic', $seoInfoLangVo );
		return $result;
	}
	final public function insertDynamicWithId(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeInsert ( SeoInfoLangMapping::class, 'insertDynamicWithId', $seoInfoLangVo );
		return $result;
	}
	final public function updateDynamicByKey(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeUpdate ( SeoInfoLangMapping::class, 'updateDynamicByKey', $seoInfoLangVo );
		return $result;
	}
	final public function deleteByKey(SeoInfoLangVo $seoInfoLangVo = null) {
		$result = $this->executeDelete ( SeoInfoLangMapping::class, 'deleteByKey', $seoInfoLangVo );
		return $result;
	}
}

