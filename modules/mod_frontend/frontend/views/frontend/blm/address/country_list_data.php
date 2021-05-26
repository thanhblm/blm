<?php
use common\template\extend\SelectInput;
use core\utils\RequestUtil;
use core\Lang;
$countryList = RequestUtil::get("countryList");
$address = RequestUtil::get("address");

$select = new SelectInput();
$select->errorMessage = RequestUtil::getFieldError ( "address[country]" );
$select->hasError = RequestUtil::isFieldError ( "address[country]" );
$select->name = "address[country]";
$select->value = $address->country;
$select->headerKey = "";
$select->headerValue = Lang::get("Select country");
$select->collections = $countryList;
$select->propertyName = "id";
$select->propertyValue = "name";
$select->class = " ";
$select->id = "selCountryId";
$select->attributes = 'onchange="changeCountry()"';
$select->render ();
?>
