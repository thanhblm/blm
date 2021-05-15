<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;

$address = RequestUtil::get ( "address" );

$form = new FormContainer ();
$form->id = "formIdAddress";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

$text = new Text ();
$text->name = "address[id]";
$text->value = $address->id;
$text->type = "hidden";
$text->render ();

echo Lang::getWithFormat ( "Are you sure you want to delete {0}?", $address->firstName );

$form->renderEnd ();
?>