<?php
use common\template\extend\SelectInput;
use core\utils\RequestUtil;
use core\Lang;
$listState = RequestUtil::get("listState");
$address = RequestUtil::get("address");
 
$select = new SelectInput();
$select->errorMessage = RequestUtil::getFieldError ( "address[state]" );
$select->hasError = RequestUtil::isFieldError ( "address[state]" );
$select->label = Lang::get ( "State" );
$select->collections = $listState;
if($address->country == 411 || $address->country == 384){
	$select->required = true;
}
$select->headerKey = "";
$select->class = "form-control input-sm";
$select->headerValue = "--Select Country First--";
$select->propertyName = "id";
$select->propertyValue = "name"; 
$select->name = "address[state]";
$select->value = $address->state;
$select->render ();
?>
