<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
$customerType= RequestUtil::get("customerType");

$form = new FormContainer();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

$text = new Text();
$text->name = "customerType[id]";
$text->value = $customerType->id;
$text->type = "hidden";
$text->render();

echo  Lang::getWithFormat("Are you sure you want to delete {0}?",  $customerType->name);

$form->renderEnd ();

?>