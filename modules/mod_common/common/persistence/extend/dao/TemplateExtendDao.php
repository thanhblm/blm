<?php

namespace common\persistence\extend\dao;
use core\database\BaseDao;
use core\database\SqlMapClient;
use common\persistence\base\vo\TemplateVo;
use common\persistence\extend\mapping\TemplateExtendMapping;

class TemplateExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	
	public function getGridListOfTemplate(TemplateVo $templateVo) {
		return $this->executeSelectList ( TemplateExtendMapping::class, 'getGridListOfTemplate', $templateVo );
	}
	
	public function deleteByFilter(TemplateVo $filter = null) {
		$result = $this->executeDelete ( TemplateExtendMapping::class, 'deleteByFilter', $filter );
		return $result;
	}
	
	public function deleteTemplateLang(TemplateLangVo $filter = null) {
		$result = $this->executeDelete ( TemplateExtendMapping::class, 'deleteTemplateLang', $filter );
		return $result;
	}
	
	/**
	 * ***************************
	 * ADVANCE
	 * ***************************
	 */

	/*****************************
	 * FILTER
	 *****************************/
	public function getTemplateByFilter(TemplateVo $filter = null) {
		$result = $this->executeSelectList ( TemplateExtendMapping::class, 'getTemplateByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(TemplateVo $filter = null) {
		$result = $this->executeCount ( TemplateExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
}