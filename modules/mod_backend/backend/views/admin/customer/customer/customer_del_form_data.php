<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;

$customer = RequestUtil::get ( "customer" );

$form = new FormContainer ();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

$text = new Text ();
$text->name = "customer[id]";
$text->value = $customer->id;
$text->type = "hidden";
$text->render ();

echo Lang::getWithFormat ( "Are you sure you want to delete {0}?", $customer->firstName );

$form->renderEnd ();
?>