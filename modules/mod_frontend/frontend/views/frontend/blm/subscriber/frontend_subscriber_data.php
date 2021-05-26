<?php
use common\template\extend\TextInput;
use core\utils\RequestUtil;
use common\template\extend\Button;
use core\Lang;
use core\utils\ActionUtil;

$subscriber = RequestUtil::get ( "subscriber" );

if (RequestUtil::hasActionMessages()){
?>
<div id="alert-success" class="alert alert-success" role="alert" style="border: 1px solid #588609; padding: 8px 10px; margin-left:2px; border-radius:10px; color:#333">
	<img src="<?=ActionUtil::getFullPathAlias("/") ?>modules/mod_frontend/frontend/views/assets/layouts/blm/images/icon_accepted_16.png" style="padding-right:6px;">
	<?=RequestUtil::getActionMessage();?>
</div>
<?php 
} 
?>
<form id="newsletter-form" class="_newsletter purlForm" onsubmit="return false;">
	<div class="col-xs-12 col-md-2 no-padding">
	<?php
	$text = new TextInput();
	$text->type = "Text";
	$text->name = "subscriber[firstName]";
	$text->value = $subscriber->firstName;
	$text->placeholder = Lang::get("First name");
	$text->errorMessage = "";
	$text->hasError = RequestUtil::isFieldError ( "subscriber[firstName]" );
	$text->class = "name";
	$text->render ();
	?>
	</div>
	<div class="col-xs-12 col-md-2 no-padding">
	<?php
	$text = new TextInput ();
	$text->type = "Text";
	$text->name = "subscriber[lastName]";
	$text->value = $subscriber->lastName;
	$text->placeholder = Lang::get("Last name") ;
	$text->errorMessage = "";
	$text->hasError = RequestUtil::isFieldError ( "subscriber[lastName]" );
	$text->class = "";
	$text->render ();
	?>
	</div>
	<div class="col-xs-12 col-md-4 col-lg-5 no-padding">
	<?php
	$text = new TextInput ();
	$text->type = "text";
	$text->name = "subscriber[email]";
	$text->value = $subscriber->email;
	$text->required = "required";
	$text->placeholder = Lang::get("Email");
	$text->errorMessage = RequestUtil::getFieldError("subscriber[emailmx]");
	$text->hasError = RequestUtil::isFieldError ( "subscriber[email]" );
	$text->class = "email";
	$text->render ();
	?>
	</div>
	<div class="col-xs-12 col-md-4 col-lg-3 no-padding">
	<?php
	$button = new Button();
	$button->type = "submit";
	$button->id = "";
	$button->title = Lang::get('Send Me Updates');
	$button->attributes = "onclick=\" addSubscriber()\"";
	$button->render ();
	?>
	</div>
</form>