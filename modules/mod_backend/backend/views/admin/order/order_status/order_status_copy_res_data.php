<?php
use common\template\extend\FormContainer;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
$orderStatus = RequestUtil::get ( "orderStatus" );
$form = new FormContainer ();
$form->id = "copy_order_status_form";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
<div class="form-body">
	<?php
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "orderStatus[name]" );
	$text->hasError = RequestUtil::isFieldError ( "orderStatus[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "orderStatus[name]";
	$text->value = $orderStatus->name;
	$text->render ();
	
	$select = new SelectInput();
	$select->value = $orderStatus->status;
	$select->name = "orderStatus[status]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "orderStatus[status]" );
	$select->hasError = RequestUtil::isFieldError ( "orderStatus[status]" );
	$select->required = true;
	$select->render ();
	
	$text = new TextArea();
	$text->name = "orderStatus[description]";
	$text->label = Lang::get("Description");
	$text->render();
	?>
</div>
<?php $form->renderEnd ();?>
