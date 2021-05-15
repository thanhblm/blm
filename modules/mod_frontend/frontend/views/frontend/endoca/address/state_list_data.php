<?php
use common\template\extend\SelectInput;
use core\utils\RequestUtil;
use core\Lang;
$stateList = RequestUtil::get("listState");
$address = RequestUtil::get("address");
if("411" == $address->country || "384" == $address->country){
	$select = new SelectInput();
	$select->errorMessage = RequestUtil::getFieldError ( "address[state]" );
	$select->hasError = RequestUtil::isFieldError ( "address[state]" );
	$select->label = Lang::get("State");
	$select->name = "address[state]";
	$select->value = $address->state;
	$select->headerKey = "";
	$select->required = true;
	$select->headerValue = Lang::get("Select state");
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->class = " ";
	$select->collections = $stateList;
	$select->id = "selStateId";
	$select->render ();
}else{
	$select = new SelectInput();
	$select->errorMessage = RequestUtil::getFieldError ( "address[state]" );
	$select->hasError = RequestUtil::isFieldError ( "address[state]" );
	$select->label = Lang::get("State");
	$select->name = "address[state]";
	$select->value = $address->state;
	$select->class = " ";
	$select->headerKey = "";
	$select->headerValue = Lang::get("Select state");
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->collections = $stateList;
	$select->id = "selStateId";
	$select->render ();
}

?>
