<?php

use core\config\FConstants;

return array(
	'' => array(
		FConstants::MODULE_PATH => ROOT . DS . "app",
		FConstants::CONFIG_PATH => ROOT . DS . "app" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "app" . DS . "views",
		FConstants::LAYOUT_PATH => ROOT . DS . "app" . DS . "views" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "app" . DS . "views" . DS . "layouts"
	),

	'mod_common' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_common",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_common" . DS . "common" . DS . "views",
	),

	'mod_tool' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_tool",
		FConstants::CONFIG_PATH => ROOT . DS . "modules" . DS . "mod_tool" . DS . "tool" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_tool" . DS . "tool" . DS . "views",
		FConstants::LAYOUT_PATH => ROOT . DS . "modules" . DS . "mod_tool" . DS . "tool" . DS . "views" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "modules" . DS . "mod_tool" . DS . "tool" . DS . "views" . DS . "layouts"
	),

	'mod_backend' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_backend",
		FConstants::CONFIG_PATH => ROOT . DS . "modules" . DS . "mod_backend" . DS . "backend" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_backend" . DS . "backend" . DS . "views",
		FConstants::LAYOUT_PATH => ROOT . DS . "modules" . DS . "mod_backend" . DS . "backend" . DS . "views" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "modules" . DS . "mod_backend" . DS . "backend" . DS . "views" . DS . "assets"
	),
	'mod_frontend' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_frontend",
		FConstants::CONFIG_PATH => ROOT . DS . "modules" . DS . "mod_frontend" . DS . "frontend" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_frontend" . DS . "frontend" . DS . "views" . DS . "frontend",
		FConstants::LAYOUT_PATH => ROOT . DS . "modules" . DS . "mod_frontend" . DS . "frontend" . DS . "views" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "modules" . DS . "mod_frontend" . DS . "frontend" . DS . "views" . DS . "assets"
	),

	'mod_api' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_api",
		FConstants::CONFIG_PATH => ROOT . DS . "modules" . DS . "mod_api" . DS . "api" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_api" . DS . "api" . DS . "views",
		FConstants::LAYOUT_PATH => ROOT . DS . "modules" . DS . "mod_api" . DS . "api" . DS . "views" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "modules" . DS . "mod_api" . DS . "api" . DS . "views" . DS . "assets"
	),

	'mod_test' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_test",
		FConstants::CONFIG_PATH => ROOT . DS . "modules" . DS . "mod_test" . DS . "test" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_test" . DS . "test" . DS . "views",
		FConstants::LAYOUT_PATH => ROOT . DS . "modules" . DS . "mod_test" . DS . "test" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "modules" . DS . "mod_test" . DS . "test" . DS . "assets"
	),

	'mod_file_manager' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_file_manager",
		FConstants::CONFIG_PATH => ROOT . DS . "modules" . DS . "mod_file_manager" . DS . "filemanager" . DS . "config",
		FConstants::VIEW_PATH => ROOT . DS . "modules" . DS . "mod_file_manager" . DS . "filemanager" . DS . "views",
		FConstants::LAYOUT_PATH => ROOT . DS . "modules" . DS . "mod_file_manager" . DS . "filemanager" . DS . "views" . DS . "layouts",
		FConstants::RELATIVE_RESOURCE_PATH => "modules" . DS . "mod_backend" . DS . "backend" . DS . "views" . DS . "assets"
	),

	'mod_authorize_net' => array(
		FConstants::MODULE_PATH => ROOT . DS . "modules" . DS . "mod_authorize_net"
	),

);