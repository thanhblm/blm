<?php
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\utils\RouteUtil;

$customView = "includes/api-header.php";
$mod = RouteUtil::getRoute()->getModule();
$layoutName = ApplicationConfig::get('layout.name');;
$layoutPath = ModuleConfig::getModuleConfig($mod)['LAYOUT_PATH'];
$fileView = "$layoutPath/$layoutName/$customView";
include $fileView;