<?php

namespace backend\workflow\erdt;


use common\config\Attributes;
use common\config\ErrorCodes;
use common\helper\SettingHelper;
use core\config\ApplicationConfig;
use core\workflow\ContextBase;
use core\workflow\Task;

class UploadErdtCsvFileTask implements Task {

	public function execute(ContextBase &$context){
		try {
			$filePath = $context->get(Attributes::FILE_PATH);
			if (ApplicationConfig::get('production.mode') == 'production') {
				if ($ftph = ftp_connect(SettingHelper::getSettingValue("ERDT host"), SettingHelper::getSettingValue("ERDT port"))) {
					if (ftp_login($ftph, SettingHelper::getSettingValue("ERDT User"), SettingHelper::getSettingValue("ERDT password"))) {
						ftp_pasv($ftph, true);
						if (ftp_put($ftph, SettingHelper::getSettingValue("ERDT Ftp path") . basename($filePath), $filePath, FTP_BINARY)) {
						} else {
							$context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR);
							$context->set(Attributes::ATTR_ERROR_MESSAGE, "Cannot Upload to FTP server.");
							return false;
						}
					} else {
						$context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR);
						$context->set(Attributes::ATTR_ERROR_MESSAGE, "Cannot Login FTP server.");
						return false;
					}
					ftp_close($ftph);
				} else {
					$context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR);
					$context->set(Attributes::ATTR_ERROR_MESSAGE, "Cannot connect to the server.");
					return false;
				}
			}
		} catch (Exception $e) {
			$context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR);
			$context->set(Attributes::ATTR_ERROR_MESSAGE, $e->getMessage());
			return false;
		}
	}
}