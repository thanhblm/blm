<?php
use common\template\extend\SelectInput;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;

$stateList = RequestUtil::get ( "stateList" );
$regionCountries = RequestUtil::get ( "regionCountries" );
$stateId = RequestUtil::get ( "stateId" );

$select = new SelectInput ( 'select_input_inline' );
$select->name = "group-a[0][stateId]";
$select->class = "form-control";
$select->label = Lang::get ( "State" );
$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
$select->collections = $stateList;
$select->headerKey = "";
$select->headerValue = "Select One";
$select->propertyName = "id";
$select->propertyValue = "name";
$select->value = $stateId;
$select->render ();
?>