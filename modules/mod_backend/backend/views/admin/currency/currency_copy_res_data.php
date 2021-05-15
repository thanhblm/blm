<?php
use common\template\extend\Select;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\TextInput;
use common\template\extend\FormContainer;

$currency = RequestUtil::get ( "currency" );

$form = new FormContainer ();
$form->id = "copy_currency_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "currency[code]" );
	$text->hasError = RequestUtil::isFieldError ( "currency[code]" );
	$text->label = Lang::get ( "Code" );
	$text->required = true;
	$text->readonly = false;
	$text->name = "currency[code]";
	$text->value = $currency->code;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "currency[name]" );
	$text->hasError = RequestUtil::isFieldError ( "currency[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "currency[name]";
	$text->value = $currency->name;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "currency[symbol]" );
	$text->hasError = RequestUtil::isFieldError ( "currency[symbol]" );
	$text->label = Lang::get ( "Symbol" );
	$text->required = false;
	$text->name = "currency[symbol]";
	$text->value = $currency->symbol;
	$text->render ();
	
	$select = new SelectInput ();
	$select->value = $currency->placement;
	$select->name = "currency[placement]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = ApplicationConfig::get ( "currency.placement.list" );
	$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Placement" );
	$select->errorMessage = RequestUtil::getFieldError ( "currency[placement]" );
	$select->hasError = RequestUtil::isFieldError ( "currency[placement]" );
	$select->required = true;
	$select->render ();
	
	$text = new TextInput ();
	$text->type = "number";
	$text->errorMessage = RequestUtil::getFieldError ( "currency[decimal]" );
	$text->hasError = RequestUtil::isFieldError ( "currency[decimal]" );
	$text->label = Lang::get ( "Decimal" );
	$text->required = true;
	$text->name = "currency[decimal]";
	$text->value = $currency->decimal;
	$text->render ();
	
	$select = new SelectInput ();
	$select->value = $currency->status;
	$select->name = "currency[status]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "currency[status]" );
	$select->hasError = RequestUtil::isFieldError ( "currency[status]" );
	$select->required = true;
	$select->render ();
	?>
</div>
<?php $form->renderEnd ();?>
<script type="text/javascript">
	$(document).ready(function(){
		$("input.numberic-float").autoNumeric('init');
	});
</script>