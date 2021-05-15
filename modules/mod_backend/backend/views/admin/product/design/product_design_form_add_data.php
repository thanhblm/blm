<?php
use core\config\ModuleConfig;
use core\utils\RouteUtil;

$viewPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['VIEW_PATH'] . DS . "admin" . DS . "attribute" . DS;
include $viewPath."attribute_list.php";
?>
