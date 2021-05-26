<?php 
use core\config\ModuleConfig;
use core\utils\RouteUtil;
use common\template\extend\Button;
use core\Lang;

$viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule())['VIEW_PATH'].DS.ApplicationConfig::get("template.name").DS;

include $viewPath."address".DS."address_add_form_data.php";

$button = new Button();
$button->type = "button";
$button->id = "btnSubmitAddress";
$button->title = " " . Lang::get ( "Save" );
$button->attributes = "";
$button->class = "button green";
$button->render ();
?>
