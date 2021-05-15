<?php
use core\config\FConstants;
return array (
		FConstants::APP_SETTINGS => 'app_config.php',
		FConstants::ACTION_CONFIG => 'action_config.php',
		FConstants::LAYOUT_CONFIG => 'layout_config.php',
		FConstants::FILTER_CONFIG => 'filter_config.php',
		FConstants::WORKFLOW_CONFIG => 'workflow_config.php',
		FConstants::MODULE_SPECIFIC_CONFIG => array (
				FConstants::APP_SETTINGS => 'module_specific_config.php'
		)
);