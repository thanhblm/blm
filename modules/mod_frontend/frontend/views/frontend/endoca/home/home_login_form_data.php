<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\Lang;
use core\utils\ActionUtil;
$customer = RequestUtil::get ( "customer" );
?>
<?php
$form = new FormContainer ();
$form->id = "formLoginId";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();

if(!AppUtil::isEmptyString(RequestUtil::getErrorMessage())){
?>
<ul class="message-stack"><li class="error"><?=RequestUtil::getErrorMessage() ?></li></ul>
<?php } ?>

<div class="_form">
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
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "customer[password]" );
	$text->hasError = RequestUtil::isFieldError ( "customer[password]" );
	$text->name = "customer[password]";
	$text->placeholder = "Password...";
	$text->type = "password";
	$text->required = true;
	$text->class = " ";
	$text->render ();
	
	?>
</div>
<p class="pull-right"><a class="lost_password" href="<?=ActionUtil::getFullPathAlias("home/customer/password/reminder") ?>"><?=Lang::get("Forgot your password?")?></a></p>
<?php
$form->renderEnd ();
?>