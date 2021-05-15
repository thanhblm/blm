<?php
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$customer = RequestUtil::get ( "customer" );
$accountTypes = RequestUtil::get ( "accountTypes" );
$customerTypes = RequestUtil::get ( "customerTypes" );
$priceLevels = RequestUtil::get ( "priceLevels" );
$saleRepList = RequestUtil::get("saleRepList");
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[companyName]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[companyName]" );
	$text->label = Lang::get ( "Company Name" );
	$text->name = "customer[companyName]";
	$text->placeholder = Lang::get ( "Company Name" );
	$text->value = $customer->companyName;
	$text->render ();
	
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[registrationNo]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[registrationNo]" );
	$text->label = Lang::get ( "Company Code" );
	$text->placeholder = Lang::get ( "Company Code" );
	$text->name = "customer[registrationNo]";
	$text->value = $customer->registrationNo;
	$text->render ();
	
 	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[resellerCertNo]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[resellerCertNo]" );
	$text->label = Lang::get ( "Reseller Certificate Nr" );
	$text->name = "customer[resellerCertNo]";
	$text->placeholder = Lang::get ( "Reseller Certificate Nr" );
	$text->value = $customer->resellerCertNo;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[vatNo]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[vatNo]" );
	$text->label = Lang::get ( "VAT No." );
	$text->placeholder = Lang::get ( "VAT No." );
	$text->name = "customer[vatNo]";
	$text->value = $customer->vatNo;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[fax]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[fax]" );
	$text->label = Lang::get ( "Fax" );
	$text->name = "customer[fax]";
	$text->placeholder = Lang::get ( "Fax" );
	$text->value = $customer->fax;
	$text->render ();
	
	$select = new SelectInput ();
	$select->errorMessage = RequestUtil::getFieldError ( "customer[saleRepId]" );
	$select->hasError = RequestUtil::isFieldError ( "customer[saleRepId]" );
	$select->label = Lang::get ( "Sales Rep" );
	$select->headerKey = "";
	$select->class = "form-control input-sm";
	$select->headerValue = "Select One";
	$select->name = "customer[saleRepId]";
	$select->value = $customer->saleRepId;
	$select->collections = $saleRepList;
	$select->propertyName = "id";
	$select->propertyValue = "firstName";
	$select->render ();
	?>
</div>

