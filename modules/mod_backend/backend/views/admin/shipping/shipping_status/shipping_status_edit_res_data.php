<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use common\template\extend\TextArea;
$shippingStatus = RequestUtil::get ( "shippingStatus" );
$form = new FormContainer ();
$form->id = "edit_shipping_status_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input type="hidden" name="shippingStatus[id]" value="<?=$shippingStatus->id?>"/>
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "shippingStatus[name]" );
	$text->hasError = RequestUtil::isFieldError ( "shippingStatus[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "shippingStatus[name]";
	$text->value = $shippingStatus->name;
	$text->render ();
	
	$select = new SelectInput();
	$select->value = $shippingStatus->status;
	$select->name = "shippingStatus[status]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "shippingStatus[status]" );
	$select->hasError = RequestUtil::isFieldError ( "shippingStatus[status]" );
	$select->required = true;
	$select->render ();
	
	$text = new TextArea();
	$text->name = "shippingStatus[description]";
	$text->label = Lang::get("Description");
	$text->render();
	?>
</div>
<?php $form->renderEnd ();?>