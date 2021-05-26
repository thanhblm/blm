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
$listAddressSuggest = RequestUtil::get("listAddressSuggest");

$form = new FormContainer ();
$form->id = "addressEditFormId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();

$text = new Text();
$text->name ="address[groupId]";
$text->value = $address->groupId;
$text->type = "hidden";
$text->render();

$text = new Text();
$text->name ="address[id]";
$text->value = $address->id;
$text->type = "hidden";
$text->render();

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
    <div class="col-xs-12 col-md-6">
        <?php
        $text = new TextInput ();
        $text->errorMessage = RequestUtil::getFieldError ( "address[firstName]" );
        $text->hasError = RequestUtil::isFieldError ( "address[firstName]" );
        $text->label = Lang::get ( "First Name" );
        $text->required = true;
        $text->class = " ";
        $text->name = "address[firstName]";
        $text->value = $address->firstName;
        $text->placeholder = Lang::get ( "First Name..." );
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
		$text->class = " ";
		$text->required = true;
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
        $text->required = true;
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
        $text->required = true;
        $text->class = " ";
        $text->name = "address[city]";
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
		$text->placeholder = Lang::get('Postal Code...');
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
<?php $form->renderEnd ();?>