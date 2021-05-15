<?php
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\AppUtil;
use core\config\ApplicationConfig;

$customer = RequestUtil::get ( "customer" );
$accountTypes = RequestUtil::get ( "accountTypes" );
$customerTypes = RequestUtil::get ( "customerTypes" );
$priceLevels = RequestUtil::get ( "priceLevels" );
$languages = RequestUtil::get ( "languages" );
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[firstName]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[firstName]" );
	$text->label = Lang::get ( "First Name" );
	$text->placeholder = Lang::get ( "First Name" );
	$text->name = "customer[firstName]";
	$text->required = true;
	$text->value = $customer->firstName;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[lastName]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[lastName]" );
	$text->placeholder = Lang::get ( "Last Name" );
	$text->label = Lang::get ( "Last Name" );
	$text->name = "customer[lastName]";
	$text->required = true;
	$text->value = $customer->lastName;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[phone]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[phone]" );
	$text->label = Lang::get ( "Phone" );
	$text->name = "customer[phone]";
	$text->value = $customer->phone;
	$text->placeholder = Lang::get ( "Phone" );
	$text->render ();
	
	$select = new SelectInput ();
	$select->errorMessage = RequestUtil::getFieldError ( "customer[languageCode]" );
	$select->hasError = RequestUtil::isFieldError ( "customer[languageCode]" );
	$select->label = Lang::get ( "Language" );
	$select->headerKey = "";
	$select->headerValue = "Select One";
	$select->value = $customer->languageCode;
	if(AppUtil::isEmptyString($customer->languageCode)){
		$select->value = ApplicationConfig::get("language.default.code");
	}
	$select->class = "form-control input-sm";
	$select->collections = $languages;
	$select->propertyName = "code";
	$select->propertyValue = "name";
	$select->name = "customer[languageCode]";
	$select->render ();
	?>
</div>