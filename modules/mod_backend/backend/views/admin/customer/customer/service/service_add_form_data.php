<?php
use common\template\extend\FormContainer;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$address = RequestUtil::get ( "address" );
$listCountry = RequestUtil::get("listCountry");
$listState = RequestUtil::get("listState");
$form = new FormContainer ();
$form->id = "addressAddFormId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
<div class="form-body">
<?php
	
	$text = new Text();
	$text->name ="address[groupId]";
	$text->value = $address->groupId;
	$text->type = "hidden";
	$text->render();

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "address[firstName]" );
	$text->hasError = RequestUtil::isFieldError ( "address[firstName]" );
	$text->label = Lang::get ( "First Name" );
	$text->required = true;
	$text->name = "address[firstName]";
	$text->value = $address->firstName;
	$text->placeholder = Lang::get("First Name...");
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[lastName]" );
	$text->hasError = RequestUtil::isFieldError ( "address[lastName]" );
	$text->label = Lang::get ( "Last Name" );
	$text->name = "address[lastName]";
	$text->required = true;
	$text->placeholder = Lang::get("Last Name...");
	$text->value = $address->lastName;
	$text->class = "form-control";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[email]" );
	$text->hasError = RequestUtil::isFieldError ( "address[email]" );
	$text->label = Lang::get ( "Email" );
	$text->name = "address[email]";
	$text->required = true;
	$text->placeholder = Lang::get("Email...");
	$text->value = $address->email;
	$text->class = "form-control";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[phone]" );
	$text->hasError = RequestUtil::isFieldError ( "address[phone]" );
	$text->label = Lang::get ( "Phone" );
	$text->name = "address[phone]";
	$text->required = true;
	$text->placeholder = Lang::get("Phone...");
	$text->value = $address->phone;
	$text->class = "form-control";
	$text->render ();

	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[fax]" );
	$text->hasError = RequestUtil::isFieldError ( "address[fax]" );
	$text->label = Lang::get ( "Fax" );
	$text->placeholder = Lang::get('Fax...');
	$text->value = $address->fax;
	$text->name = "address[fax]";
	$text->render ();
	
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[address]" );
	$text->hasError = RequestUtil::isFieldError ( "address[address]" );
	$text->label = Lang::get ( "Address" );
	$text->required = true;
	$text->placeholder = Lang::get('Address...');
	$text->value = $address->address;
	$text->name = "address[address]";
	$text->render ();
	
	$select = new SelectInput();
	$select->errorMessage = RequestUtil::getFieldError ( "address[country]" );
	$select->hasError = RequestUtil::isFieldError ( "address[country]" );
	$select->label = Lang::get ( "Country" );
	$select->required = true;
	$select->collections = $listCountry;
	$select->headerKey = "0";
	$select->class = "form-control input-sm";
	$select->headerValue = "--Select Country--";
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->name = "address[country]";
	$select->attributes = " onclick='changeCountry($(this).val())'";
	$select->value = $address->country;
	$select->render ();
	
?>
<div id="state_result">
	<?php  include 'state_list_data.php'; ?>
</div>
<?php 
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[city]" );
	$text->hasError = RequestUtil::isFieldError ( "address[city]" );
	$text->label = Lang::get ( "City" );
	$text->placeholder = Lang::get('City...');
	$text->value = $address->city;
	$text->name = "address[city]";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[postalCode]" );
	$text->hasError = RequestUtil::isFieldError ( "address[postalCode]" );
	$text->label = Lang::get ( "Postal Code" );
	$text->placeholder = Lang::get('Postal Code...');
	$text->value = $address->postalCode;
	$text->name = "address[postalCode]";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[latitude]" );
	$text->hasError = RequestUtil::isFieldError ( "address[latitude]" );
	$text->label = Lang::get ( "Latitude" );
	$text->placeholder = Lang::get('Latitude...');
	$text->value = $address->latitude;
	$text->name = "address[latitude]";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "address[longitude]" );
	$text->hasError = RequestUtil::isFieldError ( "address[longitude]" );
	$text->label = Lang::get ( "Longitude" );
	$text->placeholder = Lang::get('Longitude...');
	$text->value = $address->longitude;
	$text->name = "address[longitude]";
	$text->render ();
?>
</div>
<?php $form->renderEnd ();?>