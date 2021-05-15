<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$batchGroupMo = RequestUtil::get ( "batchGroupMo" );
$form = new FormContainer ();
$form->id = "batchGroupEditFormId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

if(RequestUtil::hasActionErrors()){
	echo '<div class="has-error"><span class="help-block">' . RequestUtil::getErrorMessage().  '</span></div>';
}
?>
<div class="form-body">
<?php
$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "batchGroupMo[name]" );
$text->hasError = RequestUtil::isFieldError ( "batchGroupMo[name]" );
$text->label = Lang::get ( "Name" );
$text->name = "batchGroupMo[name]";
$text->required = true;
$text->value = $batchGroupMo->name;
$text->render ();

$text = new Text ();
$text->type = "hidden";
$text->value = $batchGroupMo->id;
$text->name = "batchGroupMo[id]";
$text->render ();
?>
</div>
<?php $form->renderEnd ();?>
