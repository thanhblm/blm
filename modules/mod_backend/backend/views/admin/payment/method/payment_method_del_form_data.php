<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
$paymentMo = RequestUtil::get("paymentMo");

$form = new FormContainer();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

$text = new Text();
$text->name = "paymentMo[id]";
$text->value = $paymentMo->id;
$text->type = "hidden";
$text->render();

echo  Lang::getWithFormat("Are you sure you want to delete <b>{0}</b>?",  $paymentMo->name);

$form->renderEnd ();
?>