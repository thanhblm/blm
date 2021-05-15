<?php
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$customer = RequestUtil::get ( "customer" );
$accountTypes = RequestUtil::get ( "accountTypes" );
$customerTypes = RequestUtil::get ( "customerTypes" );
$priceLevels = RequestUtil::get ( "priceLevels" );
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[userName]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[userName]" );
	$text->label = Lang::get ( "User Name" );
	$text->name = "customer[userName]";
	$text->placeholder = Lang::get ( "User Name" );
	$text->value = $customer->userName;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[email]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[email]" );
	$text->label = Lang::get ( "Email" );
	$text->name = "customer[email]";
	$text->required = true;
	$text->placeholder = Lang::get ( "Email" );
	$text->value = $customer->email;
	$text->render ();
	
	$text = new TextInput ();
	$text->type = "password";
	$text->errorMessage = RequestUtil::getFieldError ( "customer[password]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[password]" );
	$text->label = Lang::get ( "Password" );
	if (AppUtil::isEmptyString ( $customer->id )) {
		$text->required = true;
	}
	$text->name = "customer[password]";
	$text->value = "";
	$text->placeholder = Lang::get ( "Password" );
	$text->render ();
	
	$text = new TextInput ();
	$text->type = "password";
	$text->errorMessage = RequestUtil::getFieldError ( "cPassword" );
	$text->hasError = RequestUtil::isFieldError ( "cPassword" );
	$text->label = Lang::get ( "Confirm Password" );
	$text->name = "cPassword";
	if (AppUtil::isEmptyString ( $customer->id )) {
		$text->required = true;
	}
	$text->value = "";
	$text->placeholder = Lang::get ( "Confirm password" );
	$text->render ();
	
	$select = new SelectInput ();
	$select->errorMessage = RequestUtil::getFieldError ( "customer[customerTypeId]" );
	$select->hasError = RequestUtil::isFieldError ( "customer[customerTypeId]" );
	$select->label = Lang::get ( "Customer Type" );
	$select->headerKey = "";
	$select->headerValue = "Select One";
	$select->value = $customer->customerTypeId;
	$select->class = "form-control input-sm";
	$select->collections = $customerTypes;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->name = "customer[customerTypeId]";
	$select->render ();
	
	$select = new SelectInput ();
	$select->errorMessage = RequestUtil::getFieldError ( "customer[accountTypeId]" );
	$select->hasError = RequestUtil::isFieldError ( "customer[accountTypeId]" );
	$select->label = Lang::get ( "Account Type" );
	$select->headerKey = "";
	$select->class = "form-control input-sm";
	$select->headerValue = "Select One";
	$select->value = $customer->accountTypeId;
	if(AppUtil::isEmptyString($customer->accountTypeId)){
		$select->value = 1;
	}
	$select->collections = $accountTypes;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->name = "customer[accountTypeId]";
	$select->render ();
	
	$select = new SelectInput ();
	$select->errorMessage = RequestUtil::getFieldError ( "customer[priceLevelId]" );
	$select->hasError = RequestUtil::isFieldError ( "customer[priceLevelId]" );
	$select->label = Lang::get ( "Price Level" );
	$select->headerKey = "";
	$select->class = "form-control input-sm";
	$select->headerValue = "Select One";
	$select->value = $customer->priceLevelId;
	if(AppUtil::isEmptyString($customer->priceLevelId)){
		$select->value = 0;
	}
	$select->name = "customer[priceLevelId]";
	$select->collections = $priceLevels;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->render ();
	?>
</div>

