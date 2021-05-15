<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$customerType = RequestUtil::get ( "customerType" );
$form = new FormContainer ();
$form->id = "customerTypeAddFormId";
$form->attributes = 'class="form-horizontal" ';

$form->renderStart ();
?>
<div class="form-body">
<?php
$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "customerType[name]" );
$text->hasError = RequestUtil::isFieldError ( "customerType[name]" );
$text->label = Lang::get ( "Name" );
$text->required = true;
$text->name = "customerType[name]";
$text->value = $customerType->name;
$text->render ();
?>
</div>
<?php $form->renderEnd(); ?>
