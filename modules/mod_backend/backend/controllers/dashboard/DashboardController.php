<?php

namespace backend\controllers\dashboard;

use core\Controller;
use common\helper\SettingHelper;

/**
 * *
 *
 * @author TANDT
 *        
 */
class DashboardController extends Controller {
	public $piwikUrl;
	public $piwikUser;
	public $piwikPassword;
	
	public function __construct() {
		parent::__construct ();
	}
	public function dashboard() {
		$this->piwikUrl = SettingHelper::getSettingValue('Piwik Url');
		$this->piwikUser = SettingHelper::getSettingValue('Piwik User');
		$this->piwikPassword = md5(SettingHelper::getSettingValue('Piwik Password'));
		return "success";
	}
}