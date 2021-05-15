<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
$language = RequestUtil::get ( "language" );
$form = new FormContainer ();
$form->id = "copy_language_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "language[code]" );
	$text->hasError = RequestUtil::isFieldError ( "language[code]" );
	$text->label = Lang::get ( "Code" );
	$text->required = true;
	$text->readonly = false;
	$text->name = "language[code]";
	$text->value = $language->code;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "language[name]" );
	$text->hasError = RequestUtil::isFieldError ( "language[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "language[name]";
	$text->value = $language->name;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "language[localeName]" );
	$text->hasError = RequestUtil::isFieldError ( "language[localeName]" );
	$text->label = Lang::get ( "Locale Name" );
	$text->required = true;
	$text->name = "language[localeName]";
	$text->value = $language->localeName;
	$text->render ();
	
	$select = new SelectInput ();
	$select->value = $language->flag;
	$select->name = "language[flag]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = RequestUtil::get ( "countries" );
	$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
	$select->propertyName = "iso2";
	$select->propertyValue = "name";
	$select->label = Lang::get ( "Flag" );
	$select->errorMessage = RequestUtil::getFieldError ( "language[flag]" );
	$select->hasError = RequestUtil::isFieldError ( "language[flag]" );
	$select->required = true;
	$select->render ();
	
	$select = new SelectInput ();
	$select->value = $language->status;
	$select->name = "language[status]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "language[status]" );
	$select->hasError = RequestUtil::isFieldError ( "language[status]" );
	$select->required = true;
	$select->render ();
	?>
</div>
<?php $form->renderEnd ();?>