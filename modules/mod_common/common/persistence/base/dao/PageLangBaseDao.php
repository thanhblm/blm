<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PageLangVo;
use common\persistence\base\mapping\PageLangMapping;

class PageLangBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PageLangVo $pageLangVo = null) {
		$result = $this->executeSelectOne ( PageLangMapping::class, 'selectByKey', $pageLangVo );
		return $result;
	}
	final public function selectAll(PageLangVo $pageLangVo = null) {
		$result = $this->executeSelectList ( PageLangMapping::class, 'selectAll', $pageLangVo );
		return $result;
	}
	final public function selectByFilter(PageLangVo $pageLangVo = null) {
		$result = $this->executeSelectList ( PageLangMapping::class, 'selectByFilter', $pageLangVo );
		return $result;
	}
	final public function countByFilter(PageLangVo $pageLangVo = null) {
		$result = $this->executeCount ( PageLangMapping::class, 'countByFilter', $pageLangVo );
		return $result;
	}
	final public function insertDynamic(PageLangVo $pageLangVo = null) {
		$result = $this->executeInsert ( PageLangMapping::class, 'insertDynamic', $pageLangVo );
		return $result;
	}
	final public function insertDynamicWithId(PageLangVo $pageLangVo = null) {
		$result = $this->executeInsert ( PageLangMapping::class, 'insertDynamicWithId', $pageLangVo );
		return $result;
	}
	final public function updateDynamicByKey(PageLangVo $pageLangVo = null) {
		$result = $this->executeUpdate ( PageLangMapping::class, 'updateDynamicByKey', $pageLangVo );
		return $result;
	}
	final public function deleteByKey(PageLangVo $pageLangVo = null) {
		$result = $this->executeDelete ( PageLangMapping::class, 'deleteByKey', $pageLangVo );
		return $result;
	}
}

