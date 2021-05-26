<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\config\ModuleConfig;
use core\utils\ActionUtil;
$frontendPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) ['VIEW_PATH'] . DS . 'endoca' . DS;

$countryListPath = $frontendPath . 'address' . DS . 'country_list_data.php';
$listAddressSuggest = RequestUtil::get("listAddressSuggest");
$stateListPath = $frontendPath . 'home' . DS . 'state_list_data.php';
$cityListPath = $frontendPath . 'address' . DS . 'city_list_data.php';
$customer = RequestUtil::get ( "customer" );
$address = RequestUtil::get ( "address" );
$form = new FormContainer ();
$form->id = "formRegisterId";
$form->attributes = 'class="_register"';
$form->renderStart ();
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
<div class="_form">
	<h2><?= Lang::get("Login Details") ?></h2>
    	<?php
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "customer[email]" );
		$text->hasError = RequestUtil::isFieldError ( "customer[email]" );
		$text->name = "customer[email]";
		$text->value = $customer->email;
		$text->placeholder = "Email Address";
		$text->type = "email";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		?>
    <div class="blank-label _field _user_e1 _empty">
		<div class="_label"></div>
		<div class="_input"></div>
	</div>
    	<?php
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "customer[password]" );
		$text->hasError = RequestUtil::isFieldError ( "customer[password]" );
		$text->name = "customer[password]";
		$text->placeholder = "Password...";
		$text->type = "password";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "customer[cPassword]" );
		$text->hasError = RequestUtil::isFieldError ( "customer[cPassword]" );
		$text->name = "cPassword";
		$text->placeholder = "Confirm Password...";
		$text->type = "password";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		?>
    <h2><?= Lang::get("Contact Details") ?></h2>
    	<?php
    	$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "customer[companyName]" );
		$text->hasError = RequestUtil::isFieldError ( "customer[companyName]" );
		$text->name = "customer[companyName]";
		$text->placeholder = "Company Name...";
		$text->value = $customer->companyName;
		$text->type = "text";
		$text->required = true;
		$text->class = " ";
		$text->render ();

		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "customer[firstName]" );
		$text->hasError = RequestUtil::isFieldError ( "customer[firstName]" );
		$text->name = "customer[firstName]";
		$text->placeholder = "First Name...";
		$text->value = $customer->firstName;
		$text->type = "text";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "customer[lastName]" );
		$text->hasError = RequestUtil::isFieldError ( "customer[lastName]" );
		$text->name = "customer[lastName]";
		$text->placeholder = "Last Name...";
		$text->value = $customer->lastName;
		$text->type = "text";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "address[phone]" );
		$text->hasError = RequestUtil::isFieldError ( "address[phone]" );
		$text->name = "address[phone]";
		$text->placeholder = "Phone...";
		$text->value = $address->phone;
		$text->required = true;
		$text->type = "text";
		$text->class = " ";
		$text->render ();
		?>
    <h2><?= Lang::get("Address") ?></h2>
		<?php
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "address[address]" );
		$text->hasError = RequestUtil::isFieldError ( "address[address]" );
		$text->name = "address[address]";
		$text->placeholder = "Address...";
		$text->value = $address->address;
		$text->type = "text";
		$text->required = true;
		$text->class = " ";
		$text->helperText= Lang::get("Please do not include special characters (e.g. #, /, ., @, &, and etc), multiple blanks, and punctuation in your Address.");
		$text->render ();
		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "address[city]" );
		$text->hasError = RequestUtil::isFieldError ( "address[city]" );
		$text->name = "address[city]";
		$text->placeholder = "City...";
		$text->value = $address->city;
		$text->type = "text";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		
		include $countryListPath;

		$text = new TextInput ();
		$text->errorMessage = RequestUtil::getFieldError ( "address[postalCode]" );
		$text->hasError = RequestUtil::isFieldError ( "address[postalCode]" );
		$text->name = "address[postalCode]";
		$text->placeholder = "Zip Code...";
		$text->value = $address->postalCode;
		$text->type = "text";
		$text->required = true;
		$text->class = " ";
		$text->render ();
		?>
		<div id="divStateList">
		<?php  include $stateListPath; ?>
		</div>
    <div class="blank-label _field _ _empty">
		<div class="_label"></div>
		<div class="_input"></div>
	</div>
	<div class="_field _subscribe _checkbox">
		<div class="_label">
            <?= Lang::get("I would like to receive regular updates, news and and educational material about the benefits of CBD oil.<br>(Your email address is safe, you can unsubscribe any time)") ?>
        </div>
		<div class="_input">
			<label><span class="frm_field frm_radio"> <input type="radio" name="subscribe" value="1" checked="checked"><span></span></span><?= Lang::get("Yes") ?></label> <label><span class="frm_field frm_radio"> <input
					type="radio" name="subscribe" value="0"><span></span></span><?= Lang::get("No") ?></label>
		</div>
	</div>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
	divStateList = "#divStateList";
    formRegister = $("#formRegisterId");
    urlSelCountry = "<?=ActionUtil::getFullPathAlias("home/register/state/list") ?>" + "?rtype=json";
    function selCountrySuccess(res) {
        $(divStateList).html(res.content);
    }
    function changeCountry() {
        dataRegister = $(formRegister).serialize();
        simpleAjaxPost(
            guid(),
            urlSelCountry,
            dataRegister,
            selCountrySuccess
        )
    }
</script>