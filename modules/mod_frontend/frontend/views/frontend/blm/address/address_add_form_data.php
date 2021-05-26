<?php
use common\template\extend\FormContainer;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use frontend\common\Constants;
use core\utils\SessionUtil;
use core\utils\AppUtil;
$address = RequestUtil::get ( "address" );
$customerInfo = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
$order = SessionUtil::get("order");
$listCountry = RequestUtil::get("listCountry");
$listState = RequestUtil::get("listState");
$listAddressSuggest = RequestUtil::get("listAddressSuggest");


$form = new FormContainer ();
$form->id = "addressAddFormId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();

$text = new Text();
$text->name ="address[groupId]";
$text->value = $address->groupId;
$text->type = "hidden";
$text->render();

$text = new Text();
$text->name ="addressType";
$text->value = RequestUtil::get("addressType");
$text->type = "hidden";
$text->render();


if(RequestUtil::get("addressType") == "shipping"){
	if(!AppUtil::isEmptyString($order->shipCompany)){
		$order->customerCompany = $order->shipCompany;
	}
	
	if(!AppUtil::isEmptyString($order->shipCompanyResellerCertNo)){
		$order->customerCompany = $order->shipCompanyResellerCertNo;
	}
	
	if(!AppUtil::isEmptyString($order->shipCompanyRegCode)){
		$order->customerCompanyRegCode = $order->shipCompanyRegCode;
	}
	if(!AppUtil::isEmptyString($order->shipCompanyVat)){
		$order->customerCompanyVat = $order->shipCompanyVat;
	}
}elseif(RequestUtil::get("addressType") == "payment"){
	if(!AppUtil::isEmptyString($order->billCompany)){
		$order->customerCompany = $order->billCompany;
	}
	
	if(!AppUtil::isEmptyString($order->billCompanyResellerCertNo)){
		$order->customerCompany = $order->billCompanyResellerCertNo;
	}
	
	if(!AppUtil::isEmptyString($order->billCompanyRegCode)){
		$order->customerCompanyRegCode = $order->billCompanyRegCode;
	}
	if(!AppUtil::isEmptyString($order->billCompanyVat)){
		$order->customerCompanyVat = $order->billCompanyVat;
	}
}

if(RequestUtil::hasActionErrors()){
?>
<ul class="message-stack">
	<li class="error"><?=RequestUtil::getErrorMessage()?></li>
</ul>
<?php 
}

if(count($listAddressSuggest)>0){
?>
<ul class="message-stack">
	<li class="warning">
	<?=Lang::get("Suggestion:") ?>
<?php
	$countAddress = count($listAddressSuggest) > 5 ? 5 : count($listAddressSuggest);
	for ($i = 0; $i < $countAddress; $i++){
?>
	 <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$listAddressSuggest[$i]?>
<?php  
	} 
?>
		</li>
	</ul>
<?php 
} 
?>
<div class="form-body">

    <div class="row">
    <?php 
     if(!is_null($order) && !is_null($customerInfo) && $customerInfo->userId == 0){
     ?> 
    	<div class="col-xs-12 col-md-6">
    	<?php 
    	
            	$text = new TextInput ();
            	$text->errorMessage = RequestUtil::getFieldError ( "order[customerCompany]" );
            	$text->hasError = RequestUtil::isFieldError ( "order[customerCompany]" );
            	$text->label = Lang::get ( "Company Name" );
            	$text->name = "order[customerCompany]";
            	$text->class = " ";
            	$text->placeholder = Lang::get ( "Company Name" );
            	$text->value = $order->customerCompany;
            	$text->render ();
            	
            	
            	$text = new TextInput ();
            	$text->errorMessage = RequestUtil::getFieldError ( "order[customerCompanyRegCode]" );
            	$text->hasError = RequestUtil::isFieldError ( "order[customerCompanyRegCode]" );
            	$text->label = Lang::get ( "Company Code" );
            	$text->placeholder = Lang::get ( "Company Code" );
            	$text->name = "order[customerCompanyRegCode]";
            	$text->class = " ";
            	$text->value = $order->customerCompanyRegCode;
            	$text->render ();
		?>
		</div>
		<div class="col-xs-12 col-md-6">
		<?php 
            	$text = new TextInput ();
            	$text->errorMessage = RequestUtil::getFieldError ( "order[customerCompanyVat]" );
            	$text->hasError = RequestUtil::isFieldError ( "order[customerCompanyVat]" );
            	$text->label = Lang::get ( "Company VAT No." );
            	$text->placeholder = Lang::get ( "Company VAT No." );
            	$text->name = "order[customerCompanyVat]";
            	$text->value = $order->customerCompanyVat;
            	$text->class = " ";
            	$text->render ();
		?>
		
		<?php 
            	$text = new TextInput ();
            	$text->errorMessage = RequestUtil::getFieldError ( "order[customerCompanyResellerCertNo]" );
            	$text->hasError = RequestUtil::isFieldError ( "order[customerCompanyResellerCertNo]" );
            	$text->label = Lang::get ( "Company Reseller Certificate Nr." );
            	$text->placeholder = Lang::get ( "Company Reseller Certificate Nr." );
            	$text->name = "order[customerCompanyResellerCertNo]";
            	$text->value = $order->customerCompanyResellerCertNo;
            	$text->class = " ";
            	$text->render ();
		?>
		
		<br/><br/>
        </div>
        <?php 
      }
        ?>   
        <div class="col-xs-12 col-md-6">
            <?php
            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "address[firstName]" );
            $text->hasError = RequestUtil::isFieldError ( "address[firstName]" );
            $text->label = Lang::get ( "First Name" );
            $text->required = true;
            $text->name = "address[firstName]";
            $text->class = " ";
            $text->value = $address->firstName;
            $text->placeholder = Lang::get("First Name...");
            $text->render ();

            $text = new TextInput();
            $text->errorMessage = RequestUtil::getFieldError ( "address[email]" );
            $text->hasError = RequestUtil::isFieldError ( "address[email]" );
            $text->label = Lang::get ( "Email" );
            $text->name = "address[email]";
            $text->required = true;
            $text->placeholder = Lang::get("Email...");
            $text->value = $address->email;
            $text->class = " ";
            $text->render ();
            ?>
        </div>

        <div class="col-xs-12 col-md-6">
            <?php
            $text = new TextInput();
            $text->errorMessage = RequestUtil::getFieldError ( "address[lastName]" );
            $text->hasError = RequestUtil::isFieldError ( "address[lastName]" );
            $text->label = Lang::get ( "Last Name" );
            $text->name = "address[lastName]";
            $text->required = true;
            $text->placeholder = Lang::get("Last Name...");
            $text->value = $address->lastName;
            $text->class = " ";
            $text->render ();

            $text = new TextInput();
            $text->errorMessage = RequestUtil::getFieldError ( "address[phone]" );
            $text->hasError = RequestUtil::isFieldError ( "address[phone]" );
            $text->label = Lang::get ( "Phone" );
            $text->name = "address[phone]";
            $text->placeholder = Lang::get("Phone...");
            $text->value = $address->phone;
            $text->required = true;
            $text->class = " ";
            $text->render ();
            ?>
        </div>
        <div class="col-xs-12">
            <?php
            $text = new TextInput();
            $text->errorMessage = RequestUtil::getFieldError ( "address[address]" );
            $text->hasError = RequestUtil::isFieldError ( "address[address]" );
            $text->label = Lang::get ( "Address" );
            $text->name = "address[address]";
            $text->required = true;
            $text->placeholder = Lang::get("Address...");
            $text->value = $address->address;
            $text->class = " ";
            $text->helperText= Lang::get("Please do not include special characters (e.g. #, /, ., @, &, and etc), multiple blanks, and punctuation in your Address.");
            $text->render ();
            ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?php
            $text = new TextInput();
            $text->errorMessage = RequestUtil::getFieldError ( "address[city]" );
            $text->hasError = RequestUtil::isFieldError ( "address[city]" );
            $text->label = Lang::get ( "City" );
            $text->placeholder = Lang::get('City...');
            $text->value = $address->city;
            $text->name = "address[city]";
            $text->required = true;
            $text->class = " ";
            $text->render ();

            $select = new SelectInput();
            $select->errorMessage = RequestUtil::getFieldError ( "address[country]" );
            $select->hasError = RequestUtil::isFieldError ( "address[country]" );
            $select->label = Lang::get ( "Country" );
            $select->required = true;
            $select->collections = $listCountry;
            $select->headerKey = "0";
            $select->class = " ";
            $select->headerValue = "--Select Country--";
            $select->propertyName = "id";
            $select->propertyValue = "name";
            $select->name = "address[country]";
            $select->attributes = " onchange='changeCountry($(this).val())'";
            $select->required = true;
            $select->value = $address->country;
            $select->render ();
            ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?php
            $text = new TextInput();
            $text->errorMessage = RequestUtil::getFieldError ( "address[postalCode]" );
            $text->hasError = RequestUtil::isFieldError ( "address[postalCode]" );
            $text->label = Lang::get ( "Postal Code" );
            $text->placeholder = Lang::get('Postal Code');
            $text->value = $address->postalCode;
            $text->class = " ";
            $text->required = true;
            $text->name = "address[postalCode]";
            $text->render ();
            ?>
            <div id="state_result">
		        <?php  include 'state_list_data.php'; ?>
            </div>
        </div>
    </div>
</div>
<?php $form->renderEnd ();?>