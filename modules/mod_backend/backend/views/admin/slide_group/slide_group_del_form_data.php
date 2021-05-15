<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
$slideGroupMo= RequestUtil::get("slideGroupMo");

$form = new FormContainer();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

$text = new Text();
$text->name = "slideGroupMo[id]";
$text->value = $slideGroupMo->id;
$text->type = "hidden";
$text->render();

echo  Lang::getWithFormat("Are you sure you want to delete {0}?",  $slideGroupMo->name);

$form->renderEnd ();

?>