<?php
use core\config\ModuleConfig;
use core\utils\RouteUtil;

$mod = RouteUtil::getRoute()->getModule();
$viewPath = ModuleConfig::getModuleConfig($mod)['VIEW_PATH'];
$fileView = "$viewPath/endoca/home/home_boxes/home_findouts.php";
include $fileView;
?>