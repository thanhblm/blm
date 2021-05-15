<?php

namespace backend\controllers\system_setting;

use common\persistence\base\vo\SystemSettingVo;
use core\BaseArray;
use core\PagingController;
use core\utils\AppUtil;
use common\services\setting\SystemSettingService;
use core\config\ApplicationConfig;

class SystemSettingController extends PagingController {
	public $groups;
	public $settings;
	public $editSettings;
	private $systemSettingService;
	public function __construct() {
		parent::__construct ();
		$this->systemSettingService = new SystemSettingService ();
		$this->editSettings = new BaseArray ( SystemSettingVo::class );
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - System settings";
	}
	public function listView() {
		$this->getGroups ();
		$this->getSettings ();
		return "success";
	}
	public function update() {
		if ($this->validateSettings ( $this->editSettings )) {
			$this->updateSettings ( $this->editSettings );
			$this->addActionMessage ( "Settings updated successfully" );
		}
		return "success";
	}
	protected function getGroups() {
		$this->groups = $this->systemSettingService->getGroups ();
	}
	protected function getSettings() {
		$settings = array ();
		foreach ( $this->groups as $group ) {
			$filter = new SystemSettingVo ();
			$filter->systemSettingGroupId = $group->id;
			$settings [$group->id] = $this->systemSettingService->getByFilter ( $filter );
		}
		$this->settings = $settings;
	}
	protected function updateSettings(BaseArray $settings) {
		$this->systemSettingService->updateSettings ( $this->editSettings );
	}
	protected function validateSettings(BaseArray $settings) {
		for($i = 0; $i < count ( $this->editSettings->getArray () ); $i ++) {
			$setting = $this->editSettings->get ( $i );
			$field = "editSettings[{$i}][value]";
			if (! AppUtil::isEmptyString ( $setting->id )) {
				// Get setting info.
				$settingVo = $this->systemSettingService->getById ( $setting );
				// Check required and type.
				if (0 === $settingVo->allowNull) {
					if (AppUtil::isEmptyString ( $setting->value )) {
						$this->addFieldError ( $field, $settingVo->name . " is required" );
					}
				}
			}
		}
		return ! $this->hasFieldErrors ();
	}
}