<?php
use core\config\ModuleConfig;
use core\utils\RouteUtil;

$mod = RouteUtil::getRoute()->getModule();
$viewPath = ModuleConfig::getModuleConfig($mod)['VIEW_PATH'];
$fileView = "$viewPath/frontend/home/home_boxes/home_videos.php";
include $fileView;
?>