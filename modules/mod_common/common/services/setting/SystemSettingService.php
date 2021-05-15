<?php

namespace common\services\setting;

use common\persistence\base\vo\SystemSettingGroupVo;
use common\persistence\base\vo\SystemSettingVo;
use common\persistence\extend\dao\SystemSettingExtendDao;
use common\persistence\extend\dao\SystemSettingGroupExtendDao;
use common\services\base\BaseService;
use core\BaseArray;
use core\database\SqlMapClient;

class SystemSettingService extends BaseService {
	private $systemSettingDao;
	private $systemSettingGroupDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->systemSettingDao = new SystemSettingExtendDao ();
		$this->systemSettingGroupDao = new SystemSettingGroupExtendDao ();
	}
	public function getAll() {
		return $this->systemSettingDao->selectAll ();
	}
	public function getById(SystemSettingVo $filter) {
		return $this->systemSettingDao->selectByKey ( $filter );
	}
	public function getByName(SystemSettingVo $filter) {
		return $this->systemSettingDao->getByName ( $filter );
	}
	public function getByFilter(SystemSettingVo $filter) {
		return $this->systemSettingDao->getByFilter ( $filter );
	}
	public function getCountByFilter(SystemSettingVo $filter) {
		return $this->systemSettingDao->getCountByFilter ( $filter );
	}
	public function update(SystemSettingVo $settingVo) {
		return $this->systemSettingDao->updateDynamicByKey ( $settingVo );
	}
	public function delete(SystemSettingVo $settingVo) {
		return $this->systemSettingDao->deleteByKey ( $settingVo );
	}
	public function getGroups(SystemSettingGroupVo $filter = null) {
		if (! isset ( $filter )) {
			return $this->systemSettingGroupDao->selectAll ();
		}
		return $this->systemSettingGroupDao->getByFilter ( $filter );
	}
	public function countGroups(SystemSettingGroupVo $filter) {
		return $this->systemSettingGroupDao->getCountByFilter ( $filter );
	}
	public function createGroup(SystemSettingGroupVo $settingGroupVo) {
		return $this->systemSettingGroupDao->insertDynamic ( $settingGroupVo );
	}
	public function getGroupByKey(SystemSettingGroupVo $filter) {
		return $this->systemSettingGroupDao->selectByKey ( $filter );
	}
	public function updateGroup(SystemSettingGroupVo $settingGroupVo) {
		return $this->systemSettingGroupDao->updateDynamicByKey ( $settingGroupVo );
	}
	public function deleteGroup(SystemSettingGroupVo $settingGroupVo) {
		return $this->systemSettingGroupDao->deleteByKey ( $settingGroupVo );
	}
	public function updateSettings(BaseArray $settings) {
		$sqlClient = new SqlMapClient ( $this->context );
		$settingDao = new SystemSettingExtendDao ( $this->context, $sqlClient );
		$sqlClient->startTransaction ();
		try {
			foreach ( $settings->getArray () as $setting ) {
				$settingDao->updateDynamicByKey ( $setting );
			}
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
}