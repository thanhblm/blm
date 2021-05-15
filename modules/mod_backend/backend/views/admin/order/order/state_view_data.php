<?php
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\Lang;
$countryIso = RequestUtil::get("countryIso");
$stateList = RequestUtil::get ( "stateList" );
$categoryState = RequestUtil::get("categoryState");

$select = new SelectInput();
$select->label=Lang::get("State:") ;
$select->errorMessage = RequestUtil::getFieldError ( "order[shipStateCode]" );
$select->hasError = RequestUtil::isFieldError ( "order[shipStateCode]" );
if($categoryState=="bill"){
	$select->name = "order[billStateCode]";
}else{
	$select->name = "order[shipStateCode]";
}
$select->headerKey = "";
$select->headerValue = "Select state";
//$select->value = $order->shipStateCode;
$select->class = "form-control input-sm";
$select->required = false;
$select->collections = $stateList;
$select->propertyName = "iso2";
$select->propertyValue = "name";
if( $countryIso=='US' || $countryIso=='ES'){
	$select->required = true;
}
$select->render ();
?>

