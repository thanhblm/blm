<?php
use common\template\extend\FormContainer;
use core\Lang;
use common\template\extend\TextInput;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
$customer = RequestUtil::get("customer");
?>
<div id="main">
	<div class="light">
		<div>
			<article class="box col-xs-5 login" style="float:left">
				<h2><?=Lang::get("Reset Your Password") ?></h2>
				<p><?=Lang::get("Please enter email address you have used during account creation, and we will send you instruction on how to reset your password.") ?></p>
<?php 
$form = new FormContainer();
$form->name = "formRecoverPassword";
$form->id = "formRecoverPassword";
$form->attributes = " class='_recoverPassword  purlForm' ";
$form->method = "post";
$form->action = ActionUtil::getFullPathAlias("home/customer/password/reminder");
$form->renderStart();

if(RequestUtil::hasFieldErrors()){
?>
<ul class="message-stack">
		<li class="error"><?=RequestUtil::getFieldError("customer[email]") ?></li>
</ul>
<?php  
}elseif(RequestUtil::hasActionMessages()) {
?>
<ul class="message-stack">
	<li class="success"><?=RequestUtil::getActionMessage() ?></li>
</ul>
<?php 
}elseif (RequestUtil::hasActionErrors()){ ?>
<ul class="message-stack">
	<li class="error"><?=RequestUtil::getErrorMessage() ?></li>
</ul>
<?php 
}

$text = new TextInput ();
$text->hasError = RequestUtil::isFieldError ( "customer[email]" );
$text->name = "customer[email]";
$text->value = $customer->email;
$text->placeholder = "Email Address";
$text->type = "email";
$text->required = true;
$text->class = " ";
$text->render ();
?>
	<div class="_buttons">
		<button type="submit" class="continue">
			<span><?=Lang::get("Reset Password") ?></span>
		</button>
	</div>
<?php 
$form->renderEnd();
?>
			</article>
			<article class="box col-xs-2" style="text-align: center !important;"><?=Lang::get("or")?></article>
			<article class="box col-xs-5 register_links">
				<h2><?=Lang::get("Don't Have an Account") ?></h2>
				<p><?=Lang::get("Create an account to get access to the newest products, sales and special offers!") ?></p>
				<button type="submit" class="continue" onclick='createAccount()'>
					<span><?=Lang::get("Create Account") ?></span>
				</button>
			</article>
		</div>
	</div>
</div>
<script type="text/javascript">
function createAccount(){
	showLoginDialog("registration-tab");
}
</script>