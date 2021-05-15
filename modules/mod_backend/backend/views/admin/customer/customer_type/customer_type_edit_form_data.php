<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$customerType = RequestUtil::get ( "customerType" );
$form = new FormContainer ();
$form->id = "customerTypeEditFormId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

if(RequestUtil::hasActionErrors()){
	echo '<div class="has-error"><span class="help-block">' . RequestUtil::getErrorMessage().  '</span></div>';
}
?>
<div class="form-body">
<?php
$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "customerType[name]" );
$text->hasError = RequestUtil::isFieldError ( "customerType[name]" );
$text->label = Lang::get ( "Name" );
$text->name = "customerType[name]";
$text->required = true;
$text->value = $customerType->name;
$text->render ();

$text = new Text ();
$text->type = "hidden";
$text->value = $customerType->id;
$text->name = "customerType[id]";
$text->render ();

?>
</div>
<?php $form->renderEnd ();?>
