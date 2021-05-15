<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
$userGroupMo = RequestUtil::get("userGroupMo");

$form = new FormContainer();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

$text = new Text();
$text->name = "userGroupMo[id]";
$text->value = $userGroupMo->id;
$text->type = "hidden";
$text->render();

echo  Lang::getWithFormat("Are you sure you want to delete <b>{0}</b>?",  $userGroupMo->name);

$form->renderEnd ();
?>