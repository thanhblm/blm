<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\SelectInput;
use core\template\html\base\BaseSelect;
use core\config\ApplicationConfig;
$shippingMo = RequestUtil::get ( "shippingMo" );
$statusList = ApplicationConfig::get("common.status.list");
$form = new FormContainer ();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
<div class="form-body">
<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "shippingMo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "shippingMo[name]" );
	$text->label = Lang::get ( "Name" );
	$text->name = "shippingMo[name]";
	$text->value = $shippingMo->name;
	$text->render ();
	
	$text = new TextArea();
	$text->errorMessage = RequestUtil::getFieldError ( "shippingMo[description]" );
	$text->hasError = RequestUtil::isFieldError ( "shippingMo[description]" );
	$text->label = Lang::get ( "Description" );
	$text->name = "shippingMo[description]";
	$text->value = $shippingMo->description;
	$text->class = "form-control";
	$text->render ();
	
	$text = new Text();
	$text->type = "hidden";
	$text->value = $shippingMo->id;
	$text->name = "shippingMo[id]";
	$text->render ();
	
	$select = new SelectInput();
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
	$select->hasError = RequestUtil::isFieldError ( "shippingMo[status]" );
	$select->required = true;
	$select->name = "shippingMo[status]";
	$select->label = Lang::get ( "Status" );
	$select->collections = $statusList;
	$select->errorMessage = RequestUtil::getFieldError("shippingMo[status]");
	$select->value = $shippingMo->status;
	$select->render();
?>
</div>
<?php $form->renderEnd ();?>