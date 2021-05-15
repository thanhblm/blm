<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$slideGroupMo = RequestUtil::get ( "slideGroupMo" );
$form = new FormContainer ();
$form->id = "slideGroupEditFormId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

if(RequestUtil::hasActionErrors()){
	echo '<div class="has-error"><span class="help-block">' . RequestUtil::getErrorMessage().  '</span></div>';
}
?>
<div class="form-body">
<?php
$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "slideGroupMo[name]" );
$text->hasError = RequestUtil::isFieldError ( "slideGroupMo[name]" );
$text->label = Lang::get ( "Name" );
$text->name = "slideGroupMo[name]";
$text->required = true;
$text->value = $slideGroupMo->name;
$text->render ();

$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "slideGroupMo[code]" );
$text->hasError = RequestUtil::isFieldError ( "slideGroupMo[code]" );
$text->label = Lang::get ( "Code" );
$text->required = true;
$text->name = "slideGroupMo[code]";
$text->value = $slideGroupMo->code;
$text->render ();

$text = new Text ();
$text->type = "hidden";
$text->value = $slideGroupMo->id;
$text->name = "slideGroupMo[id]";
$text->render ();
?>
</div>
<?php $form->renderEnd ();?>
