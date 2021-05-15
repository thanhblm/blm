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
$paymentMo = RequestUtil::get ( "paymentMo" );
$statusList = ApplicationConfig::get("common.status.list");
$form = new FormContainer ();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "paymentMo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "paymentMo[name]" );
	$text->label = Lang::get ( "Name" );
	$text->name = "paymentMo[name]";
	$text->value = $paymentMo->name;
	$text->render ();
	
	$text = new TextArea();
	$text->errorMessage = RequestUtil::getFieldError ( "paymentMo[description]" );
	$text->hasError = RequestUtil::isFieldError ( "paymentMo[description]" );
	$text->label = Lang::get ( "Description" );
	$text->name = "paymentMo[description]";
	$text->value = $paymentMo->description;
	$text->class = "form-control";
	$text->render ();
	
	$text = new Text();
	$text->type = "hidden";
	$text->value = $paymentMo->id;
	$text->name = "paymentMo[id]";
	$text->render ();
	
	$select = new SelectInput();
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
	$select->hasError = RequestUtil::isFieldError ( "paymentMo[status]" );
	$select->required = true;
	$select->name = "paymentMo[status]";
	$select->label = Lang::get ( "Status" );
	$select->collections = $statusList;
	$select->errorMessage = RequestUtil::getFieldError("paymentMo[status]");
	$select->value = $paymentMo->status;
	$select->render();
?>
</div>
<?php $form->renderEnd ();?>