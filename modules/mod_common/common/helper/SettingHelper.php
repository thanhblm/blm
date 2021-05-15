<?php
namespace common\helper;

use common\persistence\base\dao\SystemSettingBaseDao;
use common\persistence\base\vo\SystemSettingVo;
use core\utils\AppUtil;
use core\config\ApplicationConfig;
use core\utils\SessionUtil;
class SettingHelper{
	public static function getSettingValue($key){
		
		if (AppUtil::isEmptyString($key)){
			return null;
		}else{
			$mykey = strtolower($key);
		}
		$settingCache = self::getSystemSettingData();
		$result = null;
		if (isset($settingCache[$mykey])){
			$result = $settingCache[$mykey];
		}
		if (is_null($result)){
			$settingDao = new SystemSettingBaseDao();
			$settingVo = new SystemSettingVo();
			$settingVo->name = $key;
			$settingVos = $settingDao->selectByFilter($settingVo);
			if (empty($settingVos)){
				$result = null;
				\DatoLogUtil::warn("not found system setting for:".$key);
			}else{
				$result = $settingVos[0]->value;
				//no recache as recach from filter
				//self::reload();
			}
		}
		return $result;
	}
	
	private static function getSystemSettingData(){
		$settingCache = SessionUtil::get(ApplicationConfig::get("cache.settings.name")) ;
		if (is_null($settingCache)){
			$settingCache = self::reload();
		}
		return $settingCache;
	}
	
	public static function reload(){
		\DatoLogUtil::devInfo("reload System setting");
		$settingCache = array();
		$settingDao = new SystemSettingBaseDao();
		$settingVos = $settingDao->selectAll();
		foreach ($settingVos as $settingVo){
			$settingCache[strtolower($settingVo->name)] = $settingVo->value;
		}
		SessionUtil::set(ApplicationConfig::get("cache.settings.name"),$settingCache) ;
		return $settingCache;
	}
}