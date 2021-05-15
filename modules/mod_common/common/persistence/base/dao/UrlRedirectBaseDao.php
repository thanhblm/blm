<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\UrlRedirectVo;
use common\persistence\base\mapping\UrlRedirectMapping;

class UrlRedirectBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeSelectOne ( UrlRedirectMapping::class, 'selectByKey', $urlRedirectVo );
		return $result;
	}
	final public function selectAll(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeSelectList ( UrlRedirectMapping::class, 'selectAll', $urlRedirectVo );
		return $result;
	}
	final public function selectByFilter(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeSelectList ( UrlRedirectMapping::class, 'selectByFilter', $urlRedirectVo );
		return $result;
	}
	final public function countByFilter(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeCount ( UrlRedirectMapping::class, 'countByFilter', $urlRedirectVo );
		return $result;
	}
	final public function insertDynamic(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeInsert ( UrlRedirectMapping::class, 'insertDynamic', $urlRedirectVo );
		return $result;
	}
	final public function insertDynamicWithId(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeInsert ( UrlRedirectMapping::class, 'insertDynamicWithId', $urlRedirectVo );
		return $result;
	}
	final public function updateDynamicByKey(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeUpdate ( UrlRedirectMapping::class, 'updateDynamicByKey', $urlRedirectVo );
		return $result;
	}
	final public function deleteByKey(UrlRedirectVo $urlRedirectVo = null) {
		$result = $this->executeDelete ( UrlRedirectMapping::class, 'deleteByKey', $urlRedirectVo );
		return $result;
	}
}

