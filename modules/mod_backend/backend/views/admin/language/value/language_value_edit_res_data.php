<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\TextArea;
$languageValue = RequestUtil::get ( "languageValue" );
$form = new FormContainer ();
$form->id = "edit_language_value_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input type="hidden" name="languageValue[id]" value="<?=$languageValue->id?>" />
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "languageValue[languageCode]" );
	$text->hasError = RequestUtil::isFieldError ( "languageValue[languageCode]" );
	$text->label = Lang::get ( "Language Code" );
	$text->required = true;
	$text->readonly = true;
	$text->name = "languageValue[languageCode]";
	$text->value = $languageValue->languageCode;
	$text->render ();
	
	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "languageValue[original]" );
	$text->hasError = RequestUtil::isFieldError ( "languageValue[original]" );
	$text->label = Lang::get ( "Original" );
	$text->name = "languageValue[original]";
	$text->value = $languageValue->original;
	$text->class = "form-control";
	$text->required = true;
	$text->readonly = true;
	$text->render ();
	
	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "languageValue[destination]" );
	$text->hasError = RequestUtil::isFieldError ( "languageValue[destination]" );
	$text->label = Lang::get ( "Translation" );
	$text->name = "languageValue[destination]";
	$text->value = $languageValue->destination;
	$text->class = "form-control";
	$text->attributes = "rows=10";
	$text->required = true;
	$text->readonly = false;
	$text->render ();
	?>
</div>
<?php $form->renderEnd ();?>