<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$priceLevel = RequestUtil::get ( "priceLevel" );
$form = new FormContainer ();
$form->id = "edit_price_level_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->name = "priceLevel[id]";
	$text->value = $priceLevel->id;
	$text->type = "hidden";
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "priceLevel[name]" );
	$text->hasError = RequestUtil::isFieldError ( "priceLevel[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->readonly = false;
	$text->name = "priceLevel[name]";
	$text->value = $priceLevel->name;
	$text->render ();
	
	$text = new TextInput ();
	$text->type = "number";
	$text->errorMessage = RequestUtil::getFieldError ( "priceLevel[value]" );
	$text->hasError = RequestUtil::isFieldError ( "priceLevel[value]" );
	$text->label = Lang::get ( "Value" );
	$text->required = true;
	$text->readonly = false;
	$text->name = "priceLevel[value]";
	$text->value = $priceLevel->value;
	$text->attributes .= " min='1' max='99' ";
	$text->render ();
	?>
</div>
<?php $form->renderEnd ();?>