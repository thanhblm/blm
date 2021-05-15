<?php 
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$order = RequestUtil::get("order");
$countryList = RequestUtil::get("countryList");
$stateList = RequestUtil::get("stateList");
$shipStateList = RequestUtil::get("shipStateList");

?>
<div class="col-xs-12 col-md-6">
	<div class="portlet box red-flamingo">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-bank"></i> <?= Lang::get("Billing details") ?>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row static-info">
				<div class="col-md-4 name text-right"> <?= Lang::get("Payment method:") ?></div>
				<div class="col-md-8 value">
					<?= $order->paymentMethod; ?>
					<input type="hidden" value="<?=$order->paymentMethod ?>" name="order[paymentMethod]">
				</div>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label = Lang::get("First Name:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[billFirstName]" );
					$text->hasError = RequestUtil::isFieldError ( "order[billFirstName]" );
					$text->required = true;
					$text->name = "order[billFirstName]";
					$text->value = $order->billFirstName;
					$text->render ();
					?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label = Lang::get("Last Name:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[billLastName]" );
					$text->hasError = RequestUtil::isFieldError ( "order[billLastName]" );
					$text->required = true;
					$text->name = "order[billLastName]";
					$text->value = $order->billLastName;
					$text->render ();
					?>
			</div>
			<div class="static-info">
					<?php 
						$text = new TextInput();
						$text->label = Lang::get("Email:") ;
						$text->errorMessage = RequestUtil::getFieldError ( "order[billEmail]" );
						$text->hasError = RequestUtil::isFieldError ( "order[billEmail]" );
						$text->required = true;
						$text->name = "order[billEmail]";
						$text->value = $order->billEmail;
						$text->render ();
					?>
			</div>
			<div class="static-info">
					<?php 
						$text = new TextInput();
						$text->label = Lang::get("Address:");
						$text->errorMessage = RequestUtil::getFieldError ( "order[billAddress]" );
						$text->hasError = RequestUtil::isFieldError ( "order[billAddress]" );
						$text->required = true;
						$text->name = "order[billAddress]";
						$text->value = $order->billAddress;
						$text->render ();
					?>
			</div>
			<div class="static-info">
					<?php 
						$text = new TextInput();
						$text->label = Lang::get("City:");
						$text->errorMessage = RequestUtil::getFieldError ( "order[billCity]" );
						$text->hasError = RequestUtil::isFieldError ( "order[billCity]" );
						$text->required = true;
						$text->name = "order[billCity]";
						$text->value = $order->billCity;
						$text->render ();
					?>
			</div>
			<div class="static-info">
					<?php 
						$text = new TextInput();
						$text->label = Lang::get("Zip code:");
						$text->errorMessage = RequestUtil::getFieldError ( "order[billZipcode]" );
						$text->hasError = RequestUtil::isFieldError ( "order[billZipcode]" );
						$text->required = true;
						$text->name = "order[billZipcode]";
						$text->value = $order->billZipcode;
						$text->render ();
					?>
			</div>
			<div class="static-info">
					<?php 
						$text = new TextInput();
						$text->label = Lang::get("Phone:");
						$text->errorMessage = RequestUtil::getFieldError ( "order[billPhone]" );
						$text->hasError = RequestUtil::isFieldError ( "order[billPhone]" );
						$text->required = true;
						$text->name = "order[billPhone]";
						$text->value = $order->billPhone;
						$text->render ();
					?>
			</div>
			
			<div class="static-info">
					<?php 
					$select = new SelectInput();
					$select->label = Lang::get("Country:");
					$select->errorMessage = RequestUtil::getFieldError ( "order[billCountryCode]" );
					$select->hasError = RequestUtil::isFieldError ( "order[billCountryCode]" );
					$select->name = "order[billCountryCode]";
					$select->headerKey = "";
					$select->headerValue = "Select country";
					$select->value = $order->billCountryCode;
					$select->attributes = "onchange=\"getBillState(this)\"";
					$select->class = "form-control input-sm";
					$select->required = true;
					$select->collections = $countryList;
					$select->propertyName = "iso2";
					$select->propertyValue = "name";
					$select->render ();
					?>
					<?php //$order->billCountry ?>
			</div>
			<div class="static-info" id="billState">
					<?php 
					$select = new SelectInput();
					$select->label = Lang::get("State:");
					$select->errorMessage = RequestUtil::getFieldError ( "order[billStateCode]" );
					$select->hasError = RequestUtil::isFieldError ( "order[billStateCode]" );
					$select->name = "order[billStateCode]";
					$select->headerKey = "";
					$select->headerValue = "Select state";
					$select->value = $order->billStateCode;
					$select->class = "form-control input-sm";
					$select->required = false;
					$select->collections = $stateList;
					$select->propertyName = "iso2";
					$select->propertyValue = "name";
					if( $order->billCountryCode=='US' || $order->billCountryCode=='ES'){
						$select->required = true;
					}
					$select->render ();
					?>
					<?php //$order->billState ?>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-12 col-md-6">
	<div class="portlet box green-sharp">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-truck"></i> <?= Lang::get("Shipping details") ?>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row static-info">
				<div class="col-md-4 name text-right"> <?= Lang::get("Shipping method:") ?></div>
				<div class="col-md-8 value">
					<?php echo $order->shippingMethod . ' : ' . $order->shippingMethodItem; ?>
					<input type="hidden" value="<?=$order->shippingMethod ?>" name="order[shippingMethod]">
					<input type="hidden" value="<?=$order->shippingMethodItem ?>" name="order[shippingMethodItem]">
				</div>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label=Lang::get("First Name:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipFirstName]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipFirstName]" );
					$text->required = true;
					$text->name = "order[shipFirstName]";
					$text->value = $order->shipFirstName;
					$text->render ();
					?>
					<?php  // $order->shipFirstName ?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label = Lang::get("Last Name:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipLastName]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipLastName]" );
					$text->required = true;
					$text->name = "order[shipLastName]";
					$text->value = $order->shipLastName;
					$text->render ();
					?>
					<?php // $order->shipLastName ?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label=Lang::get("Email:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipEmail]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipEmail]" );
					$text->required = true;
					$text->name = "order[shipEmail]";
					$text->value = $order->shipEmail;
					$text->render ();
					?>
					<?php // $order->shipEmail ?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label=Lang::get("Address:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipAddress]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipAddress]" );
					$text->required = true;
					$text->name = "order[shipAddress]";
					$text->value = $order->shipAddress;
					$text->render ();
					?>
					<?php //$order->shipAddress ?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label=Lang::get("City:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipCity]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipCity]" );
					$text->required = true;
					$text->name = "order[shipCity]";
					$text->value = $order->shipCity;
					$text->render ();
					?>
					<?php // $order->shipCity ?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label=Lang::get("Zip code:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipZipcode]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipZipcode]" );
					$text->required = true;
					$text->name = "order[shipZipcode]";
					$text->value = $order->shipZipcode;
					$text->render ();
					?>
					<?php // $order->shipZipcode ?>
			</div>
			<div class="static-info">
					<?php 
					$text = new TextInput();
					$text->label=Lang::get("Phone:");
					$text->errorMessage = RequestUtil::getFieldError ( "order[shipPhone]" );
					$text->hasError = RequestUtil::isFieldError ( "order[shipPhone]" );
					$text->required = true;
					$text->name = "order[shipPhone]";
					$text->value = $order->shipPhone;
					$text->render ();
					?>
					<?php // $order->shipPhone ?>
			</div>
			<div class="static-info">
					<?php 
					$select = new SelectInput(  );
					$select->label=Lang::get("Country:");
					$select->errorMessage = RequestUtil::getFieldError ( "order[shipCountryCode]" );
					$select->hasError = RequestUtil::isFieldError ( "order[shipCountryCode]" );
					$select->name = "order[shipCountryCode]";
					$select->headerKey = "";
					$select->headerValue = "Select country";
					$select->value = $order->shipCountryCode;
					$select->attributes = "onchange=\"getShipState(this)\"";
					$select->class = "form-control input-sm";
					$select->required = true;
					$select->collections = $countryList;
					$select->propertyName = "iso2";
					$select->propertyValue = "name";
					$select->render ();
					?>
					<?php //$order->shipCountry ?>
			</div>
			<div class="static-info" id="shipState">
					<?php
					$select = new SelectInput();
					$select->label=Lang::get("State:") ;
					$select->errorMessage = RequestUtil::getFieldError ( "order[shipStateCode]" );
					$select->hasError = RequestUtil::isFieldError ( "order[shipStateCode]" );
					$select->name = "order[shipStateCode]";
					$select->id = "shipState";
					$select->headerKey = "";
					$select->headerValue = "Select state";
					$select->value = $order->shipStateCode;
					$select->class = "form-control input-sm";
					$select->required = false;
					$select->collections = $shipStateList;
					$select->propertyName = "iso2";
					$select->propertyValue = "name";
					if( $order->shipCountryCode=='US' || $order->shipCountryCode=='ES'){
						$select->required = true;
					}
					$select->render ();
					?>
					<?php //$order->shipState ?>
			</div>
			
		</div>
	</div>
</div>
