<?php
use common\template\extend\SelectInput;
use core\template\html\base\BaseSelect;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$stateList = RequestUtil::get ( "stateList" );
$index = AppUtil::defaultIfEmpty ( RequestUtil::get ( "indexRegionCountry" ), 0 );

$select = new SelectInput ( 'select_input_single' );
$select->name = "regionCountries[$index][stateId]";
$select->class = "form-control input-sm";
$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
$select->collections = $stateList;
$select->headerKey = "";
$select->headerValue = "Select One";
$select->propertyName = "id";
$select->propertyValue = "name";
$select->value = "";
$select->render ();
?>